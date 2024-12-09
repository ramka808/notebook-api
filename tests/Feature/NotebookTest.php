<?php

namespace Tests\Feature;

// use Database\Factories\NotebookFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Notebook;


class NotebookTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_get_notebboks(): void
    {
        $user = Notebook::factory()->create(10);

        $response = $this->getJson('/api/notebook?page=1');
        $response->assertStatus(200)
                 ->assertJsonStructure([
                     'current_page',
                     'per_page',
                     'data' => [
                         '*' => [
                             'id',
                             'fio',
                             'company',
                             'phone',
                             'email',
                             'date_of_birth',
                             'photo',
                         ],
                     ],
                     'next_page_url',
                     'prev_page_url',
                     'total',
                     'total_pages',
                 ]);
    }
    
}
