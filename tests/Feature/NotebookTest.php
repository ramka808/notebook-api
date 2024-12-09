<?php

namespace Tests\Feature;

// use Database\Factories\NotebookFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Notebook;
use App\Models\User;
use Illuminate\Support\Facades\Log;


class NotebookTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    // protected function setUp(): void
    // {
    //     parent::setUp();
    //     $this->artisan('migrate');
    // }
    public function test_get_notebboks(): void
    {
        // $user = Notebook::factory()->create(10);
        $users = Notebook::factory(10)->create();

        $response = $this->getJson('/api/notebook');
        Log::info('Response:', $response->json());
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

     public function test_store_creates_notebook()
    {
        $data = [
            'fio' => 'John Doe',
            'company' => 'Example Corp',
            'phone' => '123456789',
            'email' => 'john@example.com',
            'date_of_birth' => '2000-01-01',
            'photo' => null,
        ];

        $response = $this->postJson('/api/notebook', $data);

        $response->assertStatus(201)
                 ->assertJsonFragment(['fio' => 'John Doe']);

        $this->assertDatabaseHas('notebooks', $data);
    }

     public function test_show_returns_notebook()
    {
        $notebook = Notebook::factory()->create();

        $response = $this->getJson('/api/notebook/' . $notebook->id);

        $response->assertStatus(200)
                 ->assertJsonFragment(['fio' => $notebook->fio]);
    }
    
    public function test_update_changes_notebook()
    {
        $notebook = Notebook::factory()->create();
        $data = [
            'fio' => 'Jane Doe',
            'company' => 'Another Corp',
            'phone' => '987654321',
            'email' => 'jane@example.com',
            'date_of_birth' => '1990-01-01',
            'photo' => null,
        ];

        $response = $this->postJson('/api/notebook/' . $notebook->id, $data);

        $response->assertStatus(200)
                 ->assertJsonFragment(['fio' => 'Jane Doe']);

        $this->assertDatabaseHas('notebooks', $data);
    }

    public function test_destroy_deletes_notebook()
    {
        $notebook = Notebook::factory()->create();

        $response = $this->deleteJson('/api/notebook/' . $notebook->id);

        $response->assertStatus(204);
        $this->assertDatabaseMissing('notebooks', ['id' => $notebook->id]);
    }
}
