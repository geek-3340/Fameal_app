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
            'dish_id' => 'required|exists:dishes,id',
            'category' => 'required',
            'gram' => 'nullable',
        ]);
        return response()->json($this->menusDishesService->createMenusDishesAndResponseNewData($request));
    }

    public function destroy($id)
    {
        return response()->json($this->menusDishesService->deleteMenusDishesAndResponseNewData($id));
    }
}
