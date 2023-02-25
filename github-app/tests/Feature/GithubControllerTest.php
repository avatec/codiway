<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Http\Requests\GithubStoreRequest;
use App\Models\Github;
use App\Models\User;
use App\Http\Controllers\GithubController;

class GithubControllerTest extends TestCase
{
    use DatabaseTransactions;

    public function testIndex()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        Github::factory()->count(3)->create();
        $response = $this->get(route('github'));
        $response->assertOk();
        $githubs = Github::all();
        foreach ($githubs as $github) {
            $response->assertSee($github->name);
        }
    }

    public function testAdd()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->get('/github/add');
        $response->assertStatus(200);
        $response->assertViewIs('github.add');
    }

    public function testShow()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $github = Github::factory()->create();

        $response = $this->get("/github/{$github->id}");
        $response->assertStatus(200);
        $response->assertViewIs('github.show');
        $response->assertViewHas('item', $github);
    }

    public function testStoreCreatesNewGithub()
    {
        $this->actingAs(User::factory()->create());

        $githubData = Github::factory()->make()->toArray();
        $response = $this->post(route('github.store'), $githubData);

        $response->assertSessionHas('status', 'github-created');
        $response->assertRedirect(route('github'));

        $this->assertDatabaseHas('githubs', $githubData);
    }

    public function testStoreUpdatesExistingGithub()
    {
        $user = User::factory()->create();
        $github = Github::factory()->create();
        $newData = Github::factory()->make()->toArray();

        $response = $this->actingAs($user)->patch(route('github.store', ['id' => $github->id]), $newData);

        $response->assertRedirect(route('github'));
        $response->assertSessionHas('status', 'github-updated');

        $this->assertDatabaseHas('githubs', $newData);
        $this->assertDatabaseMissing('githubs', $github->toArray());
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
