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
            'name' => 'required|string|max:255',
            'dish_id' => 'required|integer|exists:dishes,id',
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
