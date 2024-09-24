<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $guarded = [];


    public function articles()
    {
        return $this->hasMany(Article::class, 'category_id');
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_categories');
    }

}
