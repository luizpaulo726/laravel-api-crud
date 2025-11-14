<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Author;
use App\Models\Book;

class BookApiTest extends TestCase
{
    use RefreshDatabase;


    public function test_user_can_create_book()
    {
        $author = Author::factory()->create();
        $headers = $this->authenticate();

        $payload = [
            'author_id' => $author->id,
            'title'     => 'titulo de teste',
            'year'      => '2008',
            'genre'     => 'genero teste',
        ];

        $response = $this->postJson('/api/books', $payload, $headers);

        $response->assertStatus(201)
            ->assertJsonFragment(['title' => 'titulo de teste']);

        $this->assertDatabaseHas('books', [
            'title'     => 'titulo de teste',
            'author_id' => $author->id,
        ]);
    }
    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }
}
