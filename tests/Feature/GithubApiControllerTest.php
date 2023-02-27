<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Github;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Cache;
use App\Exceptions\NotFoundException;
use App\Helpers\GithubClientHelper;

class GithubApiControllerTest extends TestCase
{
    use RefreshDatabase;
    private GithubClientHelper $GithubClient;

    public function setUp(): void
    {
        parent::setUp();

        $this->GithubClient = $this->getMockBuilder(GithubClientHelper::class)
                                   ->disableOriginalConstructor()
                                   ->getMock();
    }

    public function test_index_returns_correct_response_structure()
    {
        $githubs = Github::factory()->count(3)->create();
        Cache::shouldReceive('remember')->once()->andReturn($githubs);

        $response = $this->getJson(route('api.github.index'));
        $response->assertStatus(JsonResponse::HTTP_OK);
    }

    public function test_store_with_valid_data_creates_new_record()
    {
        $this->assertDatabaseCount('githubs', 0);

        $response = $this->postJson(route('api.github.store'), [
            'name' => 'Smarty Repository',
            'url' => 'https://github.com/smarty-php/smarty',
            'rank' => 3
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
        $this->assertDatabaseCount('githubs', 0);

        $github = Github::factory([
            'name' => 'Smarty Repository',
            'url' => 'https://github.com/smarty-php/smarty',
            'rank' => 3
        ])->create();

        $response = $this->postJson(route('api.github.store', $github->id), [
            'name' => 'Smarty Repository',
            'url' => 'https://github.com/smarty-php/smarty',
            'rank' => 4
        ]);
        $response->assertStatus(JsonResponse::HTTP_OK);

        $this->assertDatabaseHas('githubs', [
            'id' => $github->id,
            'name' => 'Smarty Repository',
            'url' => 'https://github.com/smarty-php/smarty',
            'rank' => 4
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
        $nonExistingId = 12345;

        $response = $this->get(route('api.github.remove', $nonExistingId));
        $response->assertStatus(JsonResponse::HTTP_NO_CONTENT);
    }
}
