<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\MasterIngredient;
use App\Models\MasterRecipe;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function searchRecipes(Request $request)
    {
        $keyword = $request->input('keyword');
        if (empty($keyword)) {
            return response()->json([]);
        }
        $recipes = MasterRecipe::where('name', 'LIKE', "%{$keyword}%")->get();
        return response()->json($recipes);
    }

    public function searchIngredients(Request $request)
    {
        $keyword = $request->input('keyword');
        if (empty($keyword)) {
            return response()->json([]);
        }
        $ingredients = MasterIngredient::where('name', 'LIKE', "%{$keyword}%")->get();
        return response()->json($ingredients);
    }
}
