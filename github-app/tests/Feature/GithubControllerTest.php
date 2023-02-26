<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Models\Github;
use App\Models\User;

class GithubControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    // public function testIndex()
    // {
    //     $user = User::factory()->create();
    //     $this->actingAs($user);

    //     Github::factory()->count(3)->create();
    //     $response = $this->get(route('github'));
    //     $response->assertOk();
    //     $githubs = Github::all();
    //     foreach ($githubs as $github) {
    //         $response->assertSee($github->name);
    //     }
    // }

    public function testIndexDisplaysAllGithubs()
    {
        // Arrange
        $user = User::factory()->create();
        $githubs = Github::factory()->count(3)->create();

        // Act
        $response = $this->actingAs($user)->get(route('github'));

        // Assert
        $response->assertStatus(200);
        $response->assertViewIs('github.index');
        $response->assertViewHas('list', $githubs);
    }

    public function testShowDisplaysGithubDetails()
    {
        // Arrange
        $user = User::factory()->create();
        $github = Github::factory()->create();

        // Act
        $response = $this->actingAs($user)->get(route('github.show', $github->id));

        // Assert
        $response->assertStatus(200);
        $response->assertViewIs('github.show');
        $response->assertViewHas('item', $github);
    }

    public function testAddShowsAddForm()
    {
        // Arrange
        $user = User::factory()->create();

        // Act
        $response = $this->actingAs($user)->get(route('github.add'));

        // Assert
        $response->assertStatus(200);
        $response->assertViewIs('github.add');
    }

    public function testStoreCreatesNewGithub()
    {
        // Arrange
        $user = User::factory()->create();

        $githubData = Github::factory()->make()->toArray();
        // Act
        $response = $this->actingAs($user)->patch(route('github.store'), $githubData);

        // Assert
        $response->assertSessionHas('status', 'github-created');
        $response->assertRedirect(route('github'));

        $this->assertDatabaseHas('githubs', $githubData);
    }

    public function testStoreUpdatesExistingGithub()
    {
        // Arrange
        $user = User::factory()->create();

        $github = Github::factory()->create();
        $updatedData = Github::factory()->make()->toArray();

        // Act
        $response = $this->actingAs($user)->patch(route('github.store', $github->id), $updatedData);

        // Assert
        $response->assertSessionHas('status', 'github-updated');
        $response->assertRedirect(route('github'));

        $this->assertDatabaseHas('githubs', $updatedData);
    }

    public function testStoreFailsToCreateMoreThan5Githubs()
    {
        // Arrange
        $user = User::factory()->create();

        $existingGithubs = Github::factory()->count(5)->create();
        $newGithubData = Github::factory()->make()->toArray();

        // Act
        $response = $this->actingAs($user)->post(route('github.store'), $newGithubData);

        // Assert
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
