<?php

namespace App\Services;

use App\Repositories\MenusRepository;

class MenusService
{
    public function __construct(protected MenusRepository $menusRepository) {}

    public function dataFormatForIndex($category, $viewType)
    {
        // ユーザー名取得
        $user = auth()->user();
        $userName = $user->name;
        // 扱う料理種別の判別フラグ
        $type = '';
        if ($category === 'dishes') {
            $type = 'dish';
        } elseif ($category === 'babyfoods') {
            $type = 'babyfood';
        }
        // 料理データ取得
        $dishes = $this->menusRepository->getDishesByType($type);
        // 献立データ取得
        $menusDishes = $this->menusRepository->getMenusDishesByType($type);
        // 献立をカレンダー描画用に整形
        $menusForCalendarEvents = $this->formatMenusData($menusDishes);
        return compact('viewType', 'userName', 'type', 'dishes',  'menusForCalendarEvents');
    }

    public function dataFormatForEdit($date)
    {
        // 指定日の献立データ取得
        $menuByDate = $this->menusRepository->getMenusDishesByDate($date);
        $formattedDishesData = $this->formatDishesData($menuByDate);
        return $formattedDishesData;
    }

    /*
    private function
    */
    private function formatMenusData($menusDishes)
    {
        return $menusDishes->map(function ($menuDish) {
            [$dishBgColor, $dishDisplayOrder] = $this->setDishBgColorAndDisplayOrder('index', $menuDish->dish->category);
            return [
                'backgroundColor' => $dishBgColor,
                'title' => $menuDish->dish->name . ($menuDish->gram ? ' ' . $menuDish->gram . 'g' : ''),
                'start' => $menuDish->menu->date,
                'dishDisplayOrder' => $dishDisplayOrder,
                'category' => $menuDish->category,
            ];
        });
    }

    private function formatDishesData($menuByDate)
    {
        // 献立データを料理種別ごとに整形
        $dishesByDate = [];
        $babyFoodsByDate = [];

        foreach ($menuByDate as $menu) {
            $dishDisplayOrder = $this->setDishBgColorAndDisplayOrder('edit', $menu->dish->category);
            $dishData = [
                'id' => $menu->id,
                'menu_category' => $menu->category,
                'dish_name' => $menu->dish->name,
                'dish_gram' => $menu->gram,
                'dish_recipe_url' => $menu->dish->recipe_url,
                'dishDisplayOrder' => $dishDisplayOrder,
            ];
            if ($menu->dish->type === 'dish') {
                $dishesByDate[] = $dishData;
            } elseif ($menu->dish->type === 'babyfood') {
                $babyFoodsByDate[] = $dishData;
            }
        }

        // dishDisplayOrderでソート
        $dishesByDate = collect($dishesByDate)->sortBy('dishDisplayOrder')->values();
        $babyFoodsByDate = collect($babyFoodsByDate)->sortBy('dishDisplayOrder')->values();

        return compact('dishesByDate', 'babyFoodsByDate');
    }

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
