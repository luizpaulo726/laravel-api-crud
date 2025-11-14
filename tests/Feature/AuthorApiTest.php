<?php

namespace Tests\Feature;

use App\Models\Author;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AuthorApiTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_user_can_create_author()
    {
        $headers = $this->authenticate();

        $payload = [
            'name' => 'Luiz teste',
            'bio' => 'Autor teste',
        ];

        $response = $this->postJson('/api/authors', $payload, $headers);

        $response->assertStatus(201)
            ->assertJsonFragment(['name' => 'Luiz teste']);

        $this->assertDatabaseHas('authors', [
            'name' => 'Luiz teste',
        ]);
    }
}
