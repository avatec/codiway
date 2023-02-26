<?php

namespace Tests\Unit\Http\Controllers;

use Tests\TestCase;
use App\Models\Github;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Cache;

class GithubApiControllerTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        Cache::flush();
    }

    public function test_index_returns_correct_response_structure()
    {
        $response = $this->getJson(route('github.index'));

        $response->assertStatus(JsonResponse::HTTP_OK)
                 ->assertJsonStructure([
                     'data' => [
                         '*' => [
                             'id',
                             'name',
                             'url',
                             'created_at',
                             'updated_at',
                             'stats' => [
                                 'stars',
                                 'followers',
                                 'forks',
                                 'releases',
                                 'last_release_date',
                                 'open_pull_requests',
                                 'closed_pull_requests',
                                 'latest_pull_request',
                                 'latest_merge_pull_request',
                             ],
                         ],
                     ],
                 ]);
    }

    public function test_store_with_valid_data_creates_new_record()
    {
        $this->assertDatabaseCount('githubs', 0);

        $response = $this->postJson(route('github.store'), [
            'name' => 'Test Repository',
            'url' => 'https://github.com/test/repository',
        ]);

        $response->assertStatus(JsonResponse::HTTP_CREATED)
                 ->assertJson([
                     'success' => true,
                     'id' => 1,
                 ]);

        $this->assertDatabaseCount('githubs', 1);
    }

    public function test_store_with_existing_id_updates_existing_record()
    {
        $this->assertDatabaseCount('githubs', 0);

        $github = Github::factory()->create([
            'name' => 'Test Repository',
            'url' => 'https://github.com/test/repository',
        ]);

        $response = $this->postJson(route('github.store', $github->id), [
            'name' => 'Updated Test Repository',
            'url' => 'https://github.com/test/updated-repository',
        ]);

        $response->assertStatus(JsonResponse::HTTP_NO_CONTENT);

        $this->assertDatabaseCount('githubs', 1);
        $this->assertDatabaseHas('githubs', [
            'id' => $github->id,
            'name' => 'Updated Test Repository',
            'url' => 'https://github.com/test/updated-repository',
        ]);
    }

    public function test_store_with_no_data_throws_exception()
    {
        $this->expectExceptionMessage('Data not found');

        $this->postJson(route('github.store'));
    }

    public function test_store_with_more_than_5_records_throws_exception()
    {
        Github::factory()->count(5)->create();

        $this->expectExceptionMessage('Cannot create more than 5 records.');

        $this->postJson(route('github.store'), [
            'name' => 'Test Repository',
            'url' => 'https://github.com/test/repository',
        ]);
    }

    public function test_remove_with_existing_id_deletes_record()
    {
        $github = Github::factory()->create();

        $this->assertDatabaseCount('githubs', 1);

        $response = $this->deleteJson(route('github.remove', $github->id));

        $response->assertStatus(JsonResponse::HTTP_OK)
                 ->assertJson(['success' => true]);

        $this->assertDatabaseCount('githubs', 0);
    }

    public function test_remove_with_non_existing_id_throws_exception()
    {
        $this->expectExceptionMessage('Record not found');

        $this->deleteJson(route('github.remove', 1));
    }
}
