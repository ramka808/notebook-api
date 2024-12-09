<?php

namespace Tests\Feature;

use App\Models\Notebook;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class NotebookControllerTest extends TestCase
{
    // use RefreshDatabase;

    // public function test_index_returns_paginated_notebooks()
    // {
    //     Notebook::factory()->count(10)->create(); // Предполагается, что у вас есть фабрика для модели Notebook.

    //     $response = $this->getJson('/api/notebooks?page=1');

    //     $response->assertStatus(200)
    //              ->assertJsonStructure([
    //                  'current_page',
    //                  'per_page',
    //                  'data' => [
    //                      '*' => [
    //                          'id',
    //                          'fio',
    //                          'company',
    //                          'phone',
    //                          'email',
    //                          'date_of_birth',
    //                          'photo',
    //                      ],
    //                  ],
    //                  'next_page_url',
    //                  'prev_page_url',
    //                  'total',
    //                  'total_pages',
    //              ]);
    // }

    // public function test_store_creates_notebook()
    // {
    //     $data = [
    //         'fio' => 'John Doe',
    //         'company' => 'Example Corp',
    //         'phone' => '123456789',
    //         'email' => 'john@example.com',
    //         'date_of_birth' => '2000-01-01',
    //         'photo' => null,
    //     ];

    //     $response = $this->postJson('/api/notebooks', $data);

    //     $response->assertStatus(201)
    //              ->assertJsonFragment(['fio' => 'John Doe']);

    //     $this->assertDatabaseHas('notebooks', $data);
    // }

    // public function test_show_returns_notebook()
    // {
    //     $notebook = Notebook::factory()->create();

    //     $response = $this->getJson('/api/notebooks/' . $notebook->id);

    //     $response->assertStatus(200)
    //              ->assertJsonFragment(['fio' => $notebook->fio]);
    // }

    // public function test_update_changes_notebook()
    // {
    //     $notebook = Notebook::factory()->create();
    //     $data = [
    //         'fio' => 'Jane Doe',
    //         'company' => 'Another Corp',
    //         'phone' => '987654321',
    //         'email' => 'jane@example.com',
    //         'date_of_birth' => '1990-01-01',
    //         'photo' => null,
    //     ];

    //     $response = $this->putJson('/api/notebooks/' . $notebook->id, $data);

    //     $response->assertStatus(200)
    //              ->assertJsonFragment(['fio' => 'Jane Doe']);

    //     $this->assertDatabaseHas('notebooks', $data);
    // }

    // public function test_destroy_deletes_notebook()
    // {
    //     $notebook = Notebook::factory()->create();

    //     $response = $this->deleteJson('/api/notebooks/' . $notebook->id);

    //     $response->assertStatus(204);
    //     $this->assertDatabaseMissing('notebooks', ['id' => $notebook->id]);
    // }
}
