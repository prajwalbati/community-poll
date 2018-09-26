<?php

namespace Tests\Feature\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PollTest extends TestCase
{
    public function testsPollsAreCreatedCorrectly()
    {
        $user = factory(User::class)->create();
        $token = $user->generateToken();
        $headers = ['Authorization' => "Bearer $token"];
        $payload = [
            'title' => 'Lorem',
        ];

        $this->json('POST', '/api/polls', $payload, $headers)
            ->assertStatus(200)
            ->assertJson(['id' => 1, 'title' => 'Lorem']);
    }

    public function testsPollssAreUpdatedCorrectly()
    {
        $user = factory(User::class)->create();
        $token = $user->generateToken();
        $headers = ['Authorization' => "Bearer $token"];
        $poll = factory(Poll::class)->create([
            'title' => 'First Article',
        ]);

        $payload = [
            'title' => 'Lorem',
        ];

        $response = $this->json('PUT', '/api/polls/' . $poll->id, $payload, $headers)
            ->assertStatus(200)
            ->assertJson([ 
                'id' => 1, 
                'title' => 'Lorem', 
            ]);
    }

    public function testsPollsAreDeletedCorrectly()
    {
        $user = factory(User::class)->create();
        $token = $user->generateToken();
        $headers = ['Authorization' => "Bearer $token"];
        $poll = factory(Poll::class)->create([
            'title' => 'First Article',
        ]);

        $this->json('DELETE', '/api/polls/' . $poll->id, [], $headers)
            ->assertStatus(204);
    }

    public function testPollsAreListedCorrectly()
    {
        factory(Poll::class)->create([
            'title' => 'First Article',
        ]);

        factory(Poll::class)->create([
            'title' => 'Second Article',
        ]);

        $user = factory(User::class)->create();
        $token = $user->generateToken();
        $headers = ['Authorization' => "Bearer $token"];

        $response = $this->json('GET', '/api/polls', [], $headers)
            ->assertStatus(200)
            ->assertJson([
                [ 'title' => 'First Poll'],
                [ 'title' => 'Second Poll']
            ])
            ->assertJsonStructure([
                '*' => ['id', 'title', 'created_at', 'updated_at'],
            ]);
    }
}
