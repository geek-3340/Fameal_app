<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dishes extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'user_id',
        'type',
        'category',
        'recipe_url',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function menusDishes()
    {
        return $this->hasMany(MenusDishes::class);
    }
    
    public function ingredients()
    {
        return $this->hasMany(Ingredients::class, 'dish_id');
    }
}
