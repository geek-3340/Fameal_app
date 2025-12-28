<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\MasterBabyFood;
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
        $recipes = MasterRecipe::where('name', 'LIKE', "%{$keyword}%")->limit(10)->get('name');
        return response()->json($recipes);
    }

    public function searchBabyFoods(Request $request)
    {
        $keyword = $request->input('keyword');
        if (empty($keyword)) {
            return response()->json([]);
        }
        $babyFoods = MasterBabyFood::where('name', 'LIKE', "%{$keyword}%")->limit(10)->get('name');
        return response()->json($babyFoods);
    }

    public function searchIngredients(Request $request)
    {
        $keyword = $request->input('keyword');
        if (empty($keyword)) {
            return response()->json([]);
        }
        $ingredients = MasterIngredient::where('name', 'LIKE', "%{$keyword}%")->limit(10)->get('name');
        return response()->json($ingredients);
    }
}
