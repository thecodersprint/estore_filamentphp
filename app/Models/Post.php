<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;


    protected $fillable = ['title',  'slug', 'summary', 'content', 'photo', 'quote', 'post_cat_id', 'added_by', 'status'];


    public function category()
    {
        return $this->hasOne(PostCategory::class, 'id', 'post_cat_id');
    }
    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'post_tags')->withTimestamps();
    }

    public function author()
    {
        return $this->hasOne(User::class, 'id', 'added_by');
    }

    public function comments()
    {
        return $this->hasMany(PostComment::class, 'post_id');
    }

}
