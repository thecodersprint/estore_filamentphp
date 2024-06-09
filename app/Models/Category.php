<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'slug', 'summary', 'photo', 'status', 'is_parent', 'parent_id', 'added_by'];

    public function parent(){
        return $this->belongsTo(Category::class, 'parent_id');
    }
}
