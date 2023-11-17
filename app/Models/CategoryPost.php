<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryPost extends Model
{
    use HasFactory;

    protected $table = 'category_post';
    protected $fillable = ['category_id', 'post_id']; // we will use createMany()
    public $timestamps = false; //created_at and updated_at

    # Use this method to get the name of the cataegory
    public function category(){
        return $this->belongsTo(Category::class); //hasOne, hasmany
    }
}
