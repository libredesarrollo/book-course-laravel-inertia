<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Post;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 0; $i < 700; $i++) {
            $title = Str::random(rand(2, 50));

            Post::create([
                'title' => $title,
                'slug' => str($title)->slug(),
                'text' => Str::random(rand(5, 500)),
                'date' => Carbon::today()->subDays(rand(0, 400)),
                'posted' => ['yes', 'not'][rand(0, 1)],
                'type' => ['advert', 'post', 'course', 'movie', 'post'][rand(0, 4)],
                'category_id' => Category::inRandomOrder()->first()->id,
            ]);
        }
    }
}
