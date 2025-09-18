<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Dishes;

class MenusController extends Controller
{
    public function index(){
        $dishes = Dishes::where('user_id', auth()->id())->get();
        return view('contents', compact('dishes'));
    }
}
