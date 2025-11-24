<?php

namespace App\Repositories;

use App\Models\Menus;
use App\Models\MenusDishes;

class MenusDishesRepository
{
    public function firstOrCreateMenu($request)
    {
        return Menus::firstOrCreate([
            'date' => $request->date,
            'user_id' => auth()->id(),
        ]);
    }

    public function createMenusDishes($request, $menu)
    {
        return MenusDishes::create([
            'menu_id' => $menu->id,
            'dish_id' => $request->dish_id,
            'category' => $request->category,
            'gram' => $request->gram,
        ]);
    }

    public function getMenusDishesByAllDay($type)
    {
        return MenusDishes::with('dish', 'menu')->whereHas('menu', function ($query) {
            $query->where('user_id', auth()->id());
        })->whereHas('dish', function ($query) use ($type) {
            $query->where('type', $type);
        })->get();
    }

    public function getMenusDishesByDate($type, $date)
    {
        return MenusDishes::with('dish', 'menu')->whereHas('menu', function ($query) use ($date) {
            $query->where('user_id', auth()->id());
            $query->where('date', $date);
        })->whereHas('dish', function ($query) use ($type) {
            $query->where('type', $type);
        })->get();
    }

    public function findMenuDish($id)
    {
        return MenusDishes::find($id);
    }
}
