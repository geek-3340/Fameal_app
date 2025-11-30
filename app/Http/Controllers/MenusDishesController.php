<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\MenusDishesService;

class MenusDishesController extends Controller
{
    public function __construct(protected MenusDishesService $menusDishesService) {}

    public function store(Request $request)
    {
        $request->validate([
            'date' => 'required|date',
            'dish_id' => 'required|integer|exists:dishes,id',
            'category' => 'required|string|in:朝食,昼食,夕食',
            'gram' => 'nullable|integer|min:0',
        ]);
        return response()->json($this->menusDishesService->createMenusDishesAndResponseNewData($request));
    }

    public function destroy($id)
    {
        return response()->json($this->menusDishesService->deleteMenusDishesAndResponseNewData($id));
    }
}
