<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Menus extends Model
{
    use HasFactory;

    protected $table = 'menus'; // CLIでタイポしてもーてlaravelがmenuesで検索してまうけ、これ定義してる

    protected $fillable = [
        'user_id',
        'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function menusDishes()
    {
        return $this->hasMany(MenusDishes::class);
    }
}
