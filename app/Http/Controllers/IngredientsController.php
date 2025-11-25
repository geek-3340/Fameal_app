<?php

namespace App\Http\Controllers;

use App\Models\Ingredients;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;

class IngredientsController extends Controller
{
    use AuthorizesRequests;

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required',
            'dish_id' => 'required',
        ]);
        $newIngredient = Ingredients::create($validated);
        $updatedIngredients = Ingredients::where('dish_id', $newIngredient->dish_id)->get();

        return response()->json($updatedIngredients);
    }

    public function destroy($id)
    {
        $ingredient = Ingredients::find($id);
        $dishId = $ingredient->dish_id;
        $this->authorize('delete', $ingredient);
        $ingredient->delete();
        $updatedIngredients = Ingredients::where('dish_id', $dishId)->get();

        return response()->json($updatedIngredients);
    }
}
