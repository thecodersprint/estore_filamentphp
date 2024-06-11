<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostCategory extends Model
{
    use HasFactory;

    protected $fillable=['title','slug','status'];


    public function posts(){
        return $this->hasMany(Post::class, 'post_cat_id','id')->where('status','active');
    }

}
