<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MenusDishes extends Model
{
    protected $fillable = [
        'menu_id',
        'dish_id',
        'category',
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
