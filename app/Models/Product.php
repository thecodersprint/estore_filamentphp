<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable=['title','slug','summary','description','cat_id','child_cat_id','price','brand_id','discount','status','photo','size','stock','is_featured','condition'];


    protected $casts = [
        'photo' => 'array',
        'size' => 'array',
    ];
    public function brand(){
        return $this->belongsTo(Brand::class);
    }
    public function category(){
        return $this->belongsTo(Category::class, 'cat_id');
    }
    public function childCategory(){
        return $this->belongsTo(Category::class,'child_cat_id');
    }
    // public function reviews(){
    //     return $this->hasMany(Review::class);
    // }
    // public function images(){
    //     return $this->hasMany(ProductImage::class);
    // }

    public function reviews(){
        return $this->hasMany(ProductReview::class, 'product_id');
    }
}
