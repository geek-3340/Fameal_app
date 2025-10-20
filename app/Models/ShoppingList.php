<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShoppingList extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'is_checked',
        'user_id',
    ];
}
