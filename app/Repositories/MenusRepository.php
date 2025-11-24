<?php

namespace App\Repositories;

use App\Models\Dishes;
use App\Models\MenusDishes;

class MenusRepository
{
    public function getDishesByType($type)
    {
        return Dishes::where('user_id', auth()->id())->where('type', $type)->get();
    }

    public function getMenusDishesByType($type)
    {
        return MenusDishes::with('dish', 'menu')
            ->whereHas('menu', function ($query) {
                $query->where('user_id', auth()->id());
            })->whereHas('dish', function ($query) use ($type) {
                $query->where('type', $type);
            })->get();
    }

    public function getMenusDishesByDate($date)
    {
        return MenusDishes::with('dish', 'menu')->whereHas('menu', function ($query) use ($date) {
            $query->where('user_id', auth()->id());
            $query->where('date', $date);
        })->get();
    }
}
