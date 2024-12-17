<?php

namespace Tests\Feature\Shop;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Inertia\Testing\AssertableInertia as Assert;

use Tests\TestCase;

use App\Models\Category;
use App\Models\Post;
use App\Models\ShoppingCart;
use App\Models\User;

class CartTest extends TestCase
{

    use DatabaseMigrations;

    protected function setUp(): void
    {
        parent::setUp();

        User::factory(1)->create();
        $this->actingAs(User::first());
    }

    /**
     * A basic feature test example.
     */
    public function test_index_get(): void
    {
        $this->get(route('shop.index'))
            ->assertOk()
            ->assertInertia(
                fn(Assert $page) => $page
                    ->component('Shop/Index')
            );
    }

    public function test_create_db_session_post(): void
    {
        Category::factory(3)->create();
        Post::factory(1)->create();

        $this->post(route('shop.add', ['post' => 1, 'count' => 1]))
            ->assertRedirect('/');

        // session('cart')[<PK>] = [<POST>, <COUNT>]  
        $this->assertEquals(1, session('cart')[1][0]->id);
        $this->assertEquals(1, session('cart')[1][1]);

        $this->assertDatabaseHas('shopping_carts', [
            'user_id' => 1,
            'post_id' => 1,
            'count' => 1,
        ]);
    }
    public function test_update_count_db_session_post(): void
    {

        $this->test_create_db_session_post();

        $this->post(route('shop.add', ['post' => 1, 'count' => 2]))
            ->assertRedirect('/');


        // session('cart')[<PK>] = [<POST>, <COUNT>]  
        $this->assertEquals(1, session('cart')[1][0]->id);
        $this->assertEquals(2, session('cart')[1][1]);

        $this->assertDatabaseMissing('shopping_carts', [
            'user_id' => 1,
            'post_id' => 1,
            'count' => 1,
        ]);

        $this->assertDatabaseHas('shopping_carts', [
            'user_id' => 1,
            'post_id' => 1,
            'count' => 2,
        ]);
    }
    public function test_delete_count_db_session_post(): void
    {
        $this->test_create_db_session_post();
        
        // duerme el proceso un segundo para evitar que la operacion se realice muy rapido (agregar y eliminar) y el control sea el mismo en ambos casos
        sleep(1);
        // delete item
        $this->post(route('shop.add', ['post' => 1, 'count' => 0]))
            ->assertRedirect('/');

        // dd(ShoppingCart::find(1));

        $this->assertEquals([], session('cart'));


        $this->assertDatabaseMissing('shopping_carts', [
            'user_id' => 1,
            'post_id' => 1,
            // 'count' => 1,
        ]);
    }
    public function test_delete_count_db_session_item_not_exist_post(): void
    {
        // $this->test_create_db_session_post();

        Category::factory(3)->create();
        Post::factory(1)->create();
        $this->post(route('shop.add', ['post' => 1, 'count' => 0]))->assertRedirect('/');

        $this->assertNull(session('cart'));

        // no hace falta porque no se realiza ninguna op en la bd
        // $this->assertDatabaseMissing('shopping_carts', [
        //     'user_id' => 1,
        //     'post_id' => 1,
        //     // 'count' => 1,
        // ]);
    }
}
