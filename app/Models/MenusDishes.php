<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MenusDishes extends Model
{
    use HasFactory;

    protected $fillable = [
        'menu_id',
        'dish_id',
        'category',
        'gram',
    ];

    public function menu()
    {
        return $this->belongsTo(Menus::class);
    }

    public function dish()
    {
        return $this->belongsTo(Dishes::class);
    }
}
