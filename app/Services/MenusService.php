<?php

namespace App\Services;

use App\Models\Dishes;
use App\Models\MenusDishes;

class MenusService
{
    public function dataFormatForIndex($category, $viewType)
    {
        $user = auth()->user();
        $userName = $user->name;

        // 取得する料理種別の判別フラグ
        $type = '';
        if ($category === 'dishes') {
            $type = 'dish';
        } elseif ($category === 'babyfoods') {
            $type = 'babyfood';
        }

        // 料理データ取得（Viewへ渡す）
        $dishes = Dishes::where('user_id', auth()->id())->where('type', $type)->get();

        // 献立中間テーブルデータ取得
        $menus = MenusDishes::with('dish', 'menu')
            ->whereHas('menu', function ($query) {
                $query->where('user_id', auth()->id());
            })->whereHas('dish', function ($query) use ($type) {
                $query->where('type', $type);
            })->get();

        $menusForCalendarEvents = $menus->map(function ($menu) {
            [$dishBgColor, $dishDisplayOrder] = $this->setDishBgColorAndDisplayOrder('index', $menu->dish->category);
            return [
                'backgroundColor' => $dishBgColor,
                'title' => $menu->dish->name . ($menu->gram ? ' ' . $menu->gram . 'g' : ''),
                'start' => $menu->menu->date,
                'dishDisplayOrder' => $dishDisplayOrder,
                'category' => $menu->category,
            ];
        });
        return compact('viewType', 'userName', 'type', 'dishes',  'menusForCalendarEvents');
    }

    public function dataFormatForEdit($date)
    {
        $menuByDate = MenusDishes::with('dish', 'menu')->whereHas('menu', function ($query) use ($date) {
            $query->where('user_id', auth()->id());
            $query->where('date', $date);
        })->get();

        $dishesByDate = [];
        $babyFoodsByDate = [];

        foreach ($menuByDate as $menu) {
            $dishDisplayOrder = $this->setDishBgColorAndDisplayOrder('edit', $menu->dish->category);
            if ($menu->dish->type === 'dish') {
                $dishesByDate[] = [
                    'id' => $menu->id,
                    'menu_category' => $menu->category,
                    'dish_name' => $menu->dish->name,
                    'dish_gram' => $menu->gram,
                    'dish_recipe_url' => $menu->dish->recipe_url,
                    'dishDisplayOrder' => $dishDisplayOrder,
                ];
            } elseif ($menu->dish->type === 'babyfood') {
                $babyFoodsByDate[] = [
                    'id' => $menu->id,
                    'menu_category' => $menu->category,
                    'dish_name' => $menu->dish->name,
                    'dish_gram' => $menu->gram,
                    'dish_recipe_url' => $menu->dish->recipe_url,
                    'dishDisplayOrder' => $dishDisplayOrder,
                ];
            }
        }
        $dishesByDate = collect($dishesByDate)->sortBy('dishDisplayOrder')->values();
        $babyFoodsByDate = collect($babyFoodsByDate)->sortBy('dishDisplayOrder')->values();

        return compact('dishesByDate', 'babyFoodsByDate');
    }

    // ---------------------------------------------------------------------------------------------

    private function setDishBgColorAndDisplayOrder($method, $dishCategory)
    {
        if ($method === 'index') {
            return match ($dishCategory) {
                '主食', 'エネルギー' => ['#ffb700', 0],
                '主菜', 'タンパク質' => ['#ff7d55', 1],
                '副菜', 'ビタミン' => ['#91ff00', 2],
                default => ['#bbbbbb', 3],
            };
        } elseif ($method === 'edit') {
            return match ($dishCategory) {
                '主食', 'エネルギー' => 0,
                '主菜', 'タンパク質' => 1,
                '副菜', 'ビタミン' => 2,
                default => 3,
            };
        }
    }
}
