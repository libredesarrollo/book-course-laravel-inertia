<?php

namespace Tests\Feature\Dashboard;

use App\Models\Category;
use App\Models\Post;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

use Inertia\Testing\AssertableInertia as Assert;

class PostTest extends TestCase
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
        Category::factory(3)->create();
        Post::factory(15)->create();

        $post = Post::orderBy('id', 'desc')->first();

        // dd(Post::paginate(15));

        $this->get(route('post.index'))
            ->assertStatus(200)
            ->assertInertia(
                fn(Assert $page) => $page
                    ->component('Dashboard/Post/Index')
                    ->has('posts')
                    ->has('posts.data.0.title')
                    // ->where('posts.data.0.title', 'Cate 1')
                    ->where('posts.data.0.title', $post->title)
                    ->where('posts.data.0.slug', $post->slug)
                    ->where('posts.data.0.posted', $post->posted)
                    ->where('posts.data.0.type', $post->type)
                    ->where('posts', Post::with('category')->orderBy('id', 'desc')->paginate(15))
            );
    }
    public function test_create_get(): void
    {

        $categories = Category::get();

        $this->get(route('post.create'))
            ->assertOk()
            ->assertInertia(
                fn(Assert $page) => $page
                    ->component('Dashboard/Post/Save')
                    ->has('categories')
                    ->where('categories', $categories)
            );
    }
    public function test_create_post(): void
    {

        Category::factory(1)->create();

        $data = [
            'title' => 'Title',
            'slug' => 'title',
            'description' => 'Description',
            'posted' => 'yes',
            'text' => 'Content',
            'type' => 'post',
            'category_id' => 1,
            'date' => Carbon::now()
        ];

        $this->post(route('post.store'), $data)
            ->assertRedirect(route('post.index'));

        $this->assertDatabaseHas('posts', $data);
    }
    public function test_edit_get(): void
    {
        Category::factory(3)->create();
        Post::factory(1)->create();

        $categories = Category::get();
        $post = Post::first();

        $this->get(route('post.edit', $post))
            ->assertOk()
            ->assertInertia(
                fn(Assert $page) => $page
                    ->component('Dashboard/Post/Save')
                    ->has('post')
                    ->has('categories')
                    ->where('categories', $categories)
                    ->where('post', $post)
            );
    }
    public function test_edit_post(): void
    {
        Category::factory(3)->create();
        Post::factory(1)->create();

        $post = Post::first();

        $data = [
            'title' => 'Title',
            'slug' => 'title',
            'description' => 'Description',
            'posted' => 'yes',
            'text' => 'Content',
            'type' => 'post',
            'category_id' => 1,
            'date' => Carbon::now()
        ];

        $this->put(route('post.update', $post), $data)
            ->assertRedirect(route('post.index'));

        $this->assertDatabaseHas('posts', $data);
        $this->assertDatabaseMissing('posts', $post->toArray());
    }
    public function test_delete_post(): void
    {
        Category::factory(3)->create();
        Post::factory(1)->create();

        $post = Post::first();

        $this->delete(route('post.destroy', $post))
            ->assertRedirect(route('post.index'));

        $this->assertDatabaseMissing('posts', $post->toArray());
    }

    public function test_edit_upload_put(): void
    {
        Category::factory(3)->create();
        Post::factory(1)->create();

        $post = Post::first();

        $data = $post->toArray();
        $data['image'] = UploadedFile::fake()->image('image.png');

        $this->put(route('post.update', $post), $data)
            ->assertRedirect(route('post.index'));

        $post = Post::first();

        // dd(Storage::disk('public_upload_testing')->path(''));
        // dd(Storage::disk('public_upload_testing')->path($post->image));
        Storage::disk('public_upload_testing')->assertExists($post->image);
        Storage::disk('public_upload')->assertExists('image\post\\' . $post->image);
        // Storage::disk('public_upload')->assertMissing('other.png');

    }

    public function test_edit_delete_old_image_upload_put(): void
    {
        sleep(1);

        Category::factory(3)->create();
        Post::factory(1)->create();

        //*** init image
        $postOldImg = Post::first();

        $data = $postOldImg->toArray();
        $data['image'] = UploadedFile::fake()->image('imageOld.png');

        $this->put(route('post.update', $postOldImg), $data)
            ->assertRedirect(route('post.index'));

        $postOldImg = Post::first();
        Storage::disk('public_upload')->assertExists('image\post\\' . $postOldImg->image);

        //** update image
        // $post = Post::first();

        sleep(1);

        $data['image'] = UploadedFile::fake()->image('imageNew.png');
        $this->put(route('post.update', $postOldImg), $data)
            ->assertRedirect(route('post.index'));

        // old image
        Storage::disk('public_upload')->assertMissing('image\post\\' . $postOldImg->image);

        // new image
        $postNewImg = Post::first();
        Storage::disk('public_upload')->assertExists('image\post\\' . $postNewImg->image);
    }

    public function test_create_upload_put(): void
    {
        sleep(1);
        Category::factory(1)->create();

        $data = [
            'title' => 'Title',
            'slug' => 'title',
            'description' => 'Description',
            'posted' => 'yes',
            'text' => 'Content',
            'type' => 'post',
            'category_id' => 1,
            'date' => Carbon::now(),
            'image' => UploadedFile::fake()->image('image.png')
        ];

        $this->post(route('post.store'), $data)
            ->assertRedirect(route('post.index'));

        // actualizamos nombre de la img
        $post = Post::first();
        $data['image'] = $post->image;

        $this->assertDatabaseHas('posts', $data);

        Storage::disk('public_upload')->assertExists('image\post\\' . $post->image);
    }
}
