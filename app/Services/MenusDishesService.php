<?php

namespace App\Services;

use App\Models\Menus;
use App\Models\MenusDishes;

class MenusDishesService
{
    public function createMenusDishesAndResponseNewData($request)
    {
        // 献立（menus）を日付＆ユーザーで取得 or 作成
        // 同じ日付のmenusがあれば取得、なければ新規作成
        $menu = Menus::firstOrCreate([
            'date' => $request->date,
            'user_id' => auth()->id(),
        ]);
        // 献立と料理の紐付け（menus_dishes）
        $menuDish = MenusDishes::create([
            'menu_id' => $menu->id,
            'dish_id' => $request->dish_id,
            'category' => $request->category,
            'gram' => $request->gram,
        ]);

        // dish情報も一緒に取得して返す
        $menuDish->load('dish'); // リレーションをロード（MenusDishesモデルで定義されている前提）

        $date = $request->date;

        $menuByAllDay = MenusDishes::with('dish', 'menu')->whereHas('menu', function ($query) {
            $query->where('user_id', auth()->id());
        })->whereHas('dish', function ($query) use ($menuDish) {
            $query->where('type', $menuDish->dish->type);
        })->get();
        $menuByDate = MenusDishes::with('dish', 'menu')->whereHas('menu', function ($query) use ($date) {
            $query->where('user_id', auth()->id());
            $query->where('date', $date);
        })->whereHas('dish', function ($query) use ($menuDish) {
            $query->where('type', $menuDish->dish->type);
        })->get();

        $newModalDishes = [];
        $newCalendarDishes = [];

        foreach ($menuByAllDay as $menu) {
            [$dishBgColor, $dishDisplayOrder] = $this->setDishBgColorAndDisplayOrder($menu->dish->category);
            $newCalendarDishes[] = [
                'backgroundColor' => $dishBgColor,
                'title' => $menu->dish->name . ($menu->gram ? ' ' . $menu->gram . 'g' : ''),
                'start' => $menu->menu->date,
                'dishDisplayOrder' => $dishDisplayOrder,
                'category' => $menu->category,
            ];
        }
        foreach ($menuByDate as $menu) {
            [$dishBgColor, $dishDisplayOrder] = $this->setDishBgColorAndDisplayOrder($menu->dish->category);
            $newModalDishes[] = [
                'id' => $menu->id,
                'menu_category' => $menu->category,
                'dish_name' => $menu->dish->name,
                'dish_gram' => $menu->gram,
                'dish_recipe_url' => $menu->dish->recipe_url,
                'dishDisplayOrder' => $dishDisplayOrder,
            ];
        }

        $newCalendarDishes = collect($newCalendarDishes)->sortBy('dishDisplayOrder')->values();
        $newModalDishes = collect($newModalDishes)->sortBy('dishDisplayOrder')->values();

        return compact('newCalendarDishes', 'newModalDishes', 'date');
    }

    public function deleteMenusDishesAndResponseNewData($id)
    {
        $menuDish = MenusDishes::find($id);
        $date = $menuDish->menu->date;
        $menuDish->load('dish');
        $type = '';
        if ($menuDish->dish->type === 'dish') {
            $type = 'dish';
        } else {
            $type = 'babyfood';
        }
        $menuDish->delete();

        $menuByAllDay = MenusDishes::with('dish', 'menu')->whereHas('menu', function ($query) {
            $query->where('user_id', auth()->id());
        })->whereHas('dish', function ($query) use ($type) {
            $query->where('type', $type);
        })->get();
        $menuByDate = MenusDishes::with('dish', 'menu')->whereHas('menu', function ($query) use ($date) {
            $query->where('user_id', auth()->id());
            $query->where('date', $date);
        })->whereHas('dish', function ($query) use ($type) {
            $query->where('type', $type);
        })->get();

        $newModalDishes = [];
        $newCalendarDishes = [];

        foreach ($menuByAllDay as $menu) {
            [$dishBgColor, $dishDisplayOrder] = $this->setDishBgColorAndDisplayOrder($menu->dish->category);
            $newCalendarDishes[] = [
                'backgroundColor' => $dishBgColor,
                'title' => $menu->dish->name . ($menu->gram ? ' ' . $menu->gram . 'g' : ''),
                'start' => $menu->menu->date,
                'dishDisplayOrder' => $dishDisplayOrder,
                'category' => $menu->category,
            ];
        }
        foreach ($menuByDate as $menu) {
            [$dishBgColor, $dishDisplayOrder] = $this->setDishBgColorAndDisplayOrder($menu->dish->category);
            $newModalDishes[] = [
                'id' => $menu->id,
                'menu_category' => $menu->category,
                'dish_name' => $menu->dish->name,
                'dish_gram' => $menu->gram,
                'dish_recipe_url' => $menu->dish->recipe_url,
                'dishDisplayOrder' => $dishDisplayOrder,
            ];
        }

        $newCalendarDishes = collect($newCalendarDishes)->sortBy('dishDisplayOrder')->values();
        $newModalDishes = collect($newModalDishes)->sortBy('dishDisplayOrder')->values();
        return compact('newCalendarDishes', 'newModalDishes', 'date');
    }

    private function setDishBgColorAndDisplayOrder($dishCategory)
    {
        return match ($dishCategory) {
            '主食', 'エネルギー' => ['#ffb700', 0],
            '主菜', 'タンパク質' => ['#ff7d55', 1],
            '副菜', 'ビタミン' => ['#91ff00', 2],
            default => ['#bbbbbb', 3],
        };
    }
}
