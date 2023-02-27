<?php

namespace Tests\Unit\Http\Controllers;

use Tests\TestCase;
use App\Models\Github;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Cache;
use App\Exceptions\NotFoundException;

class GithubApiControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_index_returns_correct_response_structure()
    {
        // Arrange
        Github::factory()->count(3)->create([
            'name' => 'Smarty',
            'url' => 'http://github.com/smarty-php/smarty'
        ]);

        // Act
        $response = $this->getJson(route('api.github.index'));

        // Assert
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
                            'original' => [
                                'stars',
                                'followers',
                                'forks',
                                'releases',
                                'last_release_date',
                                'open_pull_requests',
                                'closed_pull_requests',
                                'latest_pull_request',
                                'latest_merge_pull_request'
                            ]
                        ],
                    ],
                ],
            ]);
    }

    public function test_store_with_valid_data_creates_new_record()
    {
        $this->assertDatabaseCount('githubs', 0);

        $response = $this->postJson(route('api.github.store'), [
            'name' => 'Test Repository',
            'url' => 'https://github.com/test/repository',
        ]);

        $response->assertStatus(JsonResponse::HTTP_CREATED)
                 ->assertJson([
                     'success' => true,
                     'id' => 4,
                 ]);

        $this->assertDatabaseCount('githubs', 1);
    }

    public function test_store_with_existing_id_updates_existing_record()
    {
        $github = Github::factory()->create([
            'name' => 'Test Repository',
            'url' => 'https://github.com/test/repository',
        ]);

        $this->assertDatabaseCount('githubs', 1);

        $response = $this->postJson(route('api.github.store', $github->id), [
            'name' => 'Updated Test Repository',
            'url' => 'https://github.com/test/updated-repository',
        ]);

        $response->assertStatus(JsonResponse::HTTP_OK);

        $this->assertDatabaseCount('githubs', 1);
        $this->assertDatabaseHas('githubs', [
            'id' => $github->id,
            'name' => 'Updated Test Repository',
            'url' => 'https://github.com/test/updated-repository',
        ]);
    }

    public function test_store_with_no_data_throws_exception()
    {
        $response = $this->postJson(route('api.github.store'), []);
        $response->assertStatus(JsonResponse::HTTP_BAD_REQUEST);
    }

    public function test_store_with_more_than_5_records_throws_exception()
    {
        Github::factory()->count(5)->create();

        $response = $this->postJson(route('api.github.store'), [        'name' => 'Test Repository',        'url' => 'https://github.com/test/repository',    ]);
        $response->assertStatus(JsonResponse::HTTP_BAD_REQUEST);
    }

    public function test_remove_with_existing_id_deletes_record()
    {
        $github = Github::factory()->create();

        $this->assertDatabaseCount('githubs', 1);

        $response = $this->get(route('api.github.remove', $github->id));

        $response->assertStatus(JsonResponse::HTTP_OK)
                ->assertJson(['success' => true]);

        $this->assertDatabaseCount('githubs', 0);
    }

    public function test_remove_with_non_existing_id_throws_exception()
    {
        $nonExistingId = 12345; // assuming this id does not exist in the database

        $response = $this->get(route('api.github.remove', $nonExistingId));
        $response->assertStatus(JsonResponse::HTTP_NO_CONTENT);
    }
}
