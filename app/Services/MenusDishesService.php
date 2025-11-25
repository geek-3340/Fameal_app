<?php

namespace App\Services;

use App\Repositories\MenusDishesRepository;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class MenusDishesService
{
    use AuthorizesRequests;

    public function __construct(protected MenusDishesRepository $menusDishesRepository) {}

    public function createMenusDishesAndResponseNewData($request)
    {
        $menu = $this->menusDishesRepository->firstOrCreateMenu($request);
        $menuDish = $this->menusDishesRepository->createMenusDishes($request, $menu);
        $menuDish->load('dish');

        $date = $request->date;

        $menuByAllDay = $this->menusDishesRepository->getMenusDishesByAllDay($menuDish->dish->type);
        $menuByDate = $this->menusDishesRepository->getMenusDishesByDate($menuDish->dish->type, $date);

        $formattedMenusDishesData = $this->formatMenusDishesData($menuByAllDay, $menuByDate, $date);

        return $formattedMenusDishesData;
    }

    public function deleteMenusDishesAndResponseNewData($id)
    {
        $menuDish = $this->menusDishesRepository->findMenuDish($id);
        $menuDish->load(['menu', 'dish']);

        $date = $menuDish->menu->date;

        $type = '';
        if ($menuDish->dish->type === 'dish') {
            $type = 'dish';
        } else {
            $type = 'babyfood';
        }

        $this->authorize('delete', $menuDish);
        $menuDish->delete();

        $menuByAllDay = $this->menusDishesRepository->getMenusDishesByAllDay($type);
        $menuByDate = $this->menusDishesRepository->getMenusDishesByDate($type, $date);

        $formattedMenusDishesData = $this->formatMenusDishesData($menuByAllDay, $menuByDate, $date);
        
        return $formattedMenusDishesData;
    }

    /*
    private function
    */

    private function formatMenusDishesData($menuByAllDay, $menuByDate, $date)
    {
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
