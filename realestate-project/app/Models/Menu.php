<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    protected $fillable = ['title', 'slug', 'sort_order'];

    public function items()
    {
        return $this->hasMany(MenuItem::class)->orderBy('sort_order');
    }
}