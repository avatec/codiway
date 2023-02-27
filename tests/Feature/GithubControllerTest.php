<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Models\Github;
use App\Models\User;

class GithubControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function testIndexDisplaysAllGithubs()
    {
        $user = User::factory()->create();
        $githubs = Github::factory()->count(3)->create();

        $response = $this->actingAs($user)->get(route('github'));
        $response->assertStatus(200);
        $response->assertViewIs('github.index');
        $response->assertViewHas('list', $githubs);
    }

    public function testShowDisplaysGithubDetails()
    {
        $user = User::factory()->create();
        $github = Github::factory()->create();

        $response = $this->actingAs($user)->get(route('github.show', $github->id));
        $response->assertStatus(200);
        $response->assertViewIs('github.show');
        $response->assertViewHas('item', $github);
    }

    public function testAddShowsAddForm()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('github.add'));
        $response->assertStatus(200);
        $response->assertViewIs('github.add');
    }

    public function testStoreCreatesNewGithub()
    {
        $user = User::factory()->create();

        $githubData = Github::factory([
            'name' => 'Test Repository',
            'url' => 'https://github.com/test/repository',
            'rank' => 3
        ])->make()->toArray();

        $response = $this->actingAs($user)->patch(route('github.store'), $githubData);
        $response->assertSessionHas('status', 'github-created');
        $response->assertRedirect(route('github'));

        $this->assertDatabaseHas('githubs', $githubData);
    }

    public function testStoreUpdatesExistingGithub()
    {
        $user = User::factory()->create();

        $github = Github::factory()->create();
        $updatedData = Github::factory()->make()->toArray();

        $response = $this->actingAs($user)->patch(route('github.store', $github->id), $updatedData);
        $response->assertSessionHas('status', 'github-updated');
        $response->assertRedirect(route('github'));

        $this->assertDatabaseHas('githubs', $updatedData);
    }

    public function testStoreFailsToCreateMoreThan5Githubs()
    {
        $user = User::factory()->create();

        $existingGithubs = Github::factory()->count(5)->create();
        $newGithubData = Github::factory()->make()->toArray();

        $response = $this->actingAs($user)->post(route('github.store'), $newGithubData);
        $response->assertSessionHasErrors('message');
        $response->assertRedirect(route('github'));
        $this->assertDatabaseMissing('githubs', $newGithubData);
    }


    public function testRemove()
    {
        $user = User::factory()->create();
        $github = Github::factory()->create();

        $response = $this->actingAs($user)
            ->followingRedirects()
            ->delete(route('github.remove', $github->id))
            ->assertStatus(200);

        $this->assertDatabaseMissing('githubs', ['id' => $github->id]);
    }
}
