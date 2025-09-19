<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Dishes;
use App\Models\MenusDishes;

class MenusController extends Controller
{
    public function index(){
        $dishes = Dishes::where('user_id', auth()->id())->get();
        $menus= MenusDishes::with('dish','menu')
            ->whereHas('menu', function($query){
                $query->where('user_id', auth()->id());
            })->get();
        $events = [];
        foreach($menus as $menu){
            $events[] = [
                'title' => $menu->dish->name,
                'start' => $menu->menu->date,
            ];
        }
        return view('contents', compact('dishes','events'));
    }
}
