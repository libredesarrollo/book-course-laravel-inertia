<?php

namespace Tests\Feature\Dashboard;

use App\Models\Category;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
// use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use Inertia\Testing\AssertableInertia as Assert;

class CategoryTest extends TestCase
{

    use DatabaseMigrations;


    // public User $user;
    // protected function setUp(): void
    // {
    //     parent::setUp();

    //     $this->user = User::first();
    //     $this->actingAs($this->user);
    // }

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

        Category::factory(2)->create();

        $categories = Category::paginate(2);
        $category = Category::first();

        $this->get(route('category.index'))
            ->assertStatus(200)
            ->assertInertia(
                fn(Assert $page) => $page
                    ->component('Dashboard/Category/Index')
                    ->has('categories')
                    ->has('categories.data.0.title')
                    // ->where('categories.data.0.title', 'Cate 1')
                    ->where('categories.data.0.title', $category->title)
                    ->where('categories', Category::paginate(2))
            );
    }
    public function test_create_get(): void
    {

        $this->get(route('category.create'))
            ->assertOk()
            ->assertInertia(
                fn(Assert $page) => $page
                    ->component('Dashboard/Category/Create')
            );
    }
    public function test_create_post(): void
    {
        $data = [
            'title' => 'Title',
            'slug' => 'title',
        ];

        $this->post(route('category.store'), $data)
            ->assertRedirect(route('category.index'));

        $this->assertDatabaseHas('categories', $data);
    }
    public function test_edit_get(): void
    {

        Category::factory(1)->create();
        $category = Category::first();

        $this->get(route('category.edit', $category))
            ->assertOk()
            ->assertInertia(
                fn(Assert $page) => $page
                    ->component('Dashboard/Category/Edit')
                    ->has('category')
                    ->where('category', $category)
            );
    }
    public function test_edit_post(): void
    {
        Category::factory(1)->create();
        $category = Category::first();

        $data = [
            'title' => 'Title',
            'slug' => 'title',
        ];

        $this->put(route('category.update', $category), $data)
            ->assertRedirect(route('category.index'));

        $this->assertDatabaseHas('categories', $data);
        $this->assertDatabaseMissing('categories', $category->toArray());
    }
    public function test_delete_post(): void
    {
        Category::factory(1)->create();
        $category = Category::first();

        $this->delete(route('category.destroy', $category))
            ->assertRedirect(route('category.index'));

        $this->assertDatabaseMissing('categories', $category->toArray());
    }
}
