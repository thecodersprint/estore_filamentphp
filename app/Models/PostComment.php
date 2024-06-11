<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostComment extends Model
{
    use HasFactory;

    protected $fillable=['user_id','post_id','comment','replied_comment','parent_id','status'];

    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }

    public function post(){
        return $this->belongsTo(Post::class, 'post_id');
    }


    public function parent(){
        return $this->belongsTo(PostComment::class, 'parent_id');
    }

}
