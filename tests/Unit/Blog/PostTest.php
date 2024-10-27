<?php

namespace Tests\Unit\Blog;

// use PHPUnit\Framework\TestCase;

use App\Models\Category;
use App\Models\Post;
use Tests\TestCase;

use Inertia\Testing\AssertableInertia as Assert;

class PostTest extends TestCase
{
    /**
     * A basic unit test example.
     */
    public function test_example(): void
    {
        $this->assertTrue(true);
    }
    public function test_index(): void
    {
        $this->assertTrue(true);
        $this->get(route('web.index'))
            ->assertStatus(200)
             ->assertViewIs('app');
            // ->assertSee('Post List');
            // ->assertViewHas('posts', Post::paginate(2))
        // $this->assertInstanceOf(LengthAwarePaginator::class, $response->viewData('posts'));


        $this->get(route('web.index'))
            // ->assertInertia(fn (Assert $page) => dd($page)
            ->assertInertia(fn (Assert $page) => $page
                ->component('Blog/Index')
                ->where('categories', Category::get())
                ->where('prop_from', null)
                ->where('posts', Post::with('category')->paginate(15))
                // ->has('posts', fn (Assert $page) => $page
                //     ->where('last_page', 47)
                    // ->where('data', fn (Assert $page) => $page)
                    // ->where('description', 'The Laravel Podcast brings you Laravel and PHP development news and discussion.')
                    // ->has('data', 4)
                    // ->has('seasons.4.episodes', 21)
                    // ->has('host', fn (Assert $page) => $page
                    //     ->where('id', 1)
                    //     ->where('name', 'Matt Stauffer')
                    // )
                    // ->has('subscribers', 7, fn (Assert $page) => $page
                    //     ->where('id', 2)
                    //     ->where('name', 'Claudio Dekker')
                    //     ->where('platform', 'Apple Podcasts')
                    //     ->etc()
                    //     ->missing('email')
                    //     ->missing('password')
                    // )
                // )
            );

    }
}
