<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Ingredients extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'dish_id',
    ];
    
    public function dish()
    {
        return $this->belongsTo(Dishes::class);
    }
}
