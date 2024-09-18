<?php

namespace Tests\Feature;

use App\Models\Todo;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Notifications\TodoNotification;
use Illuminate\Support\Facades\Notification;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class TodoTest extends TestCase
{
    use RefreshDatabase;

    protected $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        $this->actingAs($this->user);

        config()->set('queue.default', 'sync');
    }

    public function test_can_create_todo()
    {
        $todoData = [
            'title' => 'Test Todo',
            'description' => 'This is a test todo',
            'due_date' => '2024-12-31',
            'assigned_to' => $this->user->id,
        ];

        $response = $this->postJson('/api/todos', $todoData);

        $response->assertStatus(201)
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'title',
                    'description',
                    'due_date',
                    'assigned_to',
                    'assigned_by',
                    'status',
                    'created_at',
                    'updated_at',
                ],
                'message'
            ]);

        $this->assertDatabaseHas('todos', $todoData);
    }

    public function test_todo_creation_sends_notification()
    {
        Notification::fake();

        $todoData = [
            'title' => 'Notification Test Todo',
            'description' => 'This todo should trigger a notification',
            'due_date' => '2024-12-31',
            'assigned_to' => $this->user->id,
        ];

        $this->postJson('/api/todos', $todoData);

        Notification::assertSentToTimes($this->user, TodoNotification::class, 1);
    }

    public function test_can_upload_image_with_todo()
    {
        Storage::fake('public');

        $todoData = [
            'title' => 'Todo with Image',
            'description' => 'This todo has an attached image',
            'due_date' => '2024-12-31',
            'assigned_to' => $this->user->id,
            'image' => UploadedFile::fake()->image('todo_image.jpg')
        ];

        $response = $this->postJson('/api/todos', $todoData);

        $response->assertStatus(201);

        $createdTodo = Todo::latest()->first();
        Storage::disk('public')->assertExists($createdTodo->image);
    }

    public function test_can_search_todos()
    {
        Notification::fake();

        Todo::unsetEventDispatcher();

        Todo::factory()->count(5)->create(['title' => 'Searchable Todo']);
        Todo::factory()->count(3)->create(['title' => 'Different Title']);

        $response = $this->getJson('/api/todos?q=Searchable');

        $response->assertStatus(200)
            ->assertJsonCount(5, 'data')
            ->assertJsonFragment(['title' => 'Searchable Todo']);

        Notification::assertNothingSent();

        Todo::setEventDispatcher(app('events'));
    }


    public function test_todos_are_paginated()
    {
        Notification::fake();

        Todo::factory()->count(1000)->create();

        $response = $this->getJson('/api/todos');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    '*' => ['id', 'title', 'description', 'due_date', 'assigned_to', 'assigned_by', 'status']
                ],
            ])
            ->assertJsonCount(10, 'data');
    }
}
