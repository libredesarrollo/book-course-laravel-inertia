<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\URL;

class Post extends Model
{
    use HasFactory;
    protected $fillable = ['title', 'slug', 'date', 'image', 'text', 'description', 'posted', 'type', 'category_id'];

    // protected $with = ['category'];

    function category()
    {
        return $this->belongsTo(Category::class);
    }

    function tags()
    {
        return $this->morphToMany(Tag::class, 'taggagles');
    }
    function getImageUrl()
    {
        return URL::asset("images/post/" . $this->image);
    }
}
