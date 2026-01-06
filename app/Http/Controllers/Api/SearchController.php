<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\SearchService;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function __construct(protected SearchService $searchService) {}

    public function searchRecipes(Request $request)
    {
        return response()->json($this->searchService->getMasterRecipesByKeyword($request));
    }

    public function searchBabyFoods(Request $request)
    {
        return response()->json($this->searchService->getMasterBabyFoodsByKeyword($request));
    }

    public function searchIngredients(Request $request)
    {
        return response()->json($this->searchService->getMasterIngredientsByKeyword($request));
    }
}
