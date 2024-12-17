<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Post;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;

use Inertia\Testing\AssertableInertia as Assert;

// use PHPUnit\Framework\TestCase;
use Tests\TestCase;

class BlogTest extends TestCase
{

    use DatabaseMigrations;

    public function test_index(): void
    {

        Category::factory(3)->create();
        Post::factory(100)->create();

        $category = Category::first();

        $this->get(route('web.index'))
            // ->assertViewIs('app')
            ->assertStatus(200);

        //dd(Post::with('category')->toSQL());

        $this->get(route('web.index'))->assertInertia(
            // fn(Assert $page) => dd($page)
            fn(Assert $page) => $page
                ->component('Blog/Index')
                ->has('posts')
                ->has('posts', 13)
                ->has('categories.0.title')
                ->where('categories.0.title', $category->title)
                ->where('categories', Category::get())
                ->where('prop_from', null)
                ->where('posts', Post::with('category')->paginate(15))

            // ->has(
            //     'posts',
            //     fn(Assert $posts) => $posts
            // ->where('current_page', 1)
            // )
        );
    }


    public function test_index_filter(): void
    {

        Category::factory(3)->create();
        Post::factory(100)->create();

        $category = Category::first();

        $category_id = 1;

        // dd(Post::with('category')->toSQL());
        // dd(route('web.index', ['type' => 'post']));
        $this->get(route('web.index', ['type' => 'post', 'category_id' => $category_id]))->assertInertia(
            fn(Assert $page) => $page
                ->component('Blog/Index')
                ->where('posts', Post::with('category')->where('category_id', $category_id)->paginate(15))
        );
    }

    public function test_show(): void
    {

        Category::factory(3)->create();
        Post::factory(10)->create();

        $post = Post::with('category')->first();
        // $post->category;

        $this->get(route('web.show', ['post' => $post]))
            ->assertStatus(200)
            ->assertInertia(
                fn(Assert $page) => $page
                    ->component('Blog/Show')
                    ->has('post')
                    ->has('post.category')
                    ->has('post.category.title')
                    ->where('post.title', $post->title)
                    ->where('post', $post)

            );
    }
    // public function test_detail(): void
    // {
    //     $response = $this->get(route('web.show','post-4'))
    //         ->assertViewIs('app')
    //         ->assertStatus(200);
    // }
}
