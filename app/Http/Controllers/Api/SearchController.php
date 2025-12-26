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

        // キーワードが空の場合は空の配列を返す
        if (empty($keyword)) {
            return response()->json([]);
        }

        // 
        $results = MasterRecipe::where('name', 'LIKE', "%{$keyword}%")->limit(10)->get(['id', 'name']);

        return response()->json($results);
    }

    public function searchIngredients(Request $request)
    {
        $keyword = $request->input('keyword');

        // キーワードが空の場合は空の配列を返す
        if (empty($keyword)) {
            return response()->json([]);
        }

        // 
        $results = MasterIngredient::where('name', 'LIKE', "%{$keyword}%")->limit(10)->get(['id', 'name']);

        return response()->json($results);
    }
}
