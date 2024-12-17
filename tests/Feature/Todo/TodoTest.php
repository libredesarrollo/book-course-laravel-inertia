<?php

namespace Tests\Feature\Todo;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

use App\Models\User;
use App\Models\Todo;

use Inertia\Testing\AssertableInertia as Assert;

class TodoTest extends TestCase
{
    use DatabaseMigrations;

    public User $user;
    protected function setUp(): void
    {
        parent::setUp();

        User::factory(1)->create();
        $this->user = User::first();
        $this->actingAs($this->user);
    }

    public function test_index(): void
    {

        Todo::factory(5)->create();

        $todos = Todo::where('user_id', $this->user->id)->orderBy('count')->get();

        $this->get(route('todo.index'))
            ->assertStatus(200)
            ->assertInertia(
                fn(Assert $page) => $page
                    ->component('Todo/Index')
                    ->has('todos')
                    ->has('todos.0.name')
                    ->where('todos.0.name', $todos[0]->name)
                    ->where('todos', $todos)
            );
    }
    public function test_create_post(): void
    {
        $data = [
            'name' => 'Name',
        ];

        $this->post(route('todo.store'), $data)
            ->assertRedirect(route('todo.index'));

        $this->assertDatabaseHas('todos', $data);
    }
    public function test_edit_post(): void
    {
        Todo::factory(1)->create();
        $todo = Todo::first();

        $data = [
            'name' => 'Name',
        ];

        $this->put(route('todo.update', $todo), $data)
            ->assertRedirect(route('todo.index'));

        $this->assertDatabaseHas('todos', $data);
        $this->assertDatabaseMissing('todos', $todo->toArray());
    }

    public function test_delete_post(): void
    {
        Todo::factory(1)->create();
        $todo = Todo::first();

        $this->delete(route('todo.destroy', $todo))
            ->assertRedirect(route('todo.index'));

        $this->assertDatabaseMissing('todos', $todo->toArray());
    }
    public function test_status_completed_post(): void
    {
        Todo::factory(1)->create();
        $todo = Todo::first();

        $data = [
            'status' => 1,
        ];

        $this->post(route('todo.status', $todo), $data)
            ->assertRedirect(route('todo.index'));

        $this->assertDatabaseHas('todos', $data);
        $this->assertDatabaseMissing('todos', $todo->toArray());
    }

    public function test_status_uncompleted_post(): void
    {
        $this->test_status_completed_post();
        $todo = Todo::first();

        $data = [
            'status' => 0,
        ];

        $this->post(route('todo.status', $todo), $data)
            ->assertRedirect(route('todo.index'));

        //$todoNew = Todo::select('user_id', 'status', 'count', 'name')->first();

        //$this->assertDatabaseHas('todos', $todoNew->toArray());
        $this->assertDatabaseHas('todos', $data);
        $this->assertDatabaseMissing('todos', $todo->toArray());
    }

    public function test_reorder(): void
    {
        Todo::factory(5)->create();
        // $todosNoOrder = Todo::pluck('id');
        $todosReOrder = [2, 4, 1, 3, 5];

        $this->post(route('todo.order'), ['ids' => $todosReOrder]);

        $todosOrdened = Todo::orderBy('count')->pluck('id');

        foreach ($todosOrdened as $key => $id) {
            $this->assertTrue($id == $todosReOrder[$key]);
        }
    }

    public function test_edit_error_validation_post(): void
    {
        Todo::factory(1)->create();
        $todo = Todo::first();

        $dataInvalid = [
            'name' => '',
        ];

        $this->put(route('todo.update', $todo), $dataInvalid)->assertSessionHasErrors(
            [
                'name' => 'The name field is required.'
            ]
        );

        $this->assertDatabaseHas('todos', [
            'name' => $todo->name
        ]);
        $this->assertDatabaseMissing('todos', $dataInvalid);
    }
    public function test_create_error_validation_post(): void
    {

        $dataInvalid = [
            'name' => '',
        ];

        $this->post(route('todo.store'), $dataInvalid)->assertSessionHasErrors(
            [
                'name' => 'The name field is required.'
            ]
        );

        $this->assertDatabaseMissing('todos', $dataInvalid);
    }
}
