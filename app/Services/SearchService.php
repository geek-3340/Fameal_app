<?php

namespace App\Services;

use App\Repositories\SearchRepository;
use App\Models\MasterBabyFood;
use App\Models\MasterIngredient;
use App\Models\MasterRecipe;

class SearchService
{
    public function __construct(protected SearchRepository $searchRepository) {}

    public function getMasterRecipesByKeyword($request)
    {
        return $this->executeSearch(MasterRecipe::class, $request->input('keyword'));
    }

    public function getMasterBabyFoodsByKeyword($request)
    {
        return $this->executeSearch(MasterBabyFood::class, $request->input('keyword'));
    }

    public function getMasterIngredientsByKeyword($request)
    {
        return $this->executeSearch(MasterIngredient::class, $request->input('keyword'));
    }

    /*
    private function
    */
    private function executeSearch($modelClass, $keyword)
    {
        if (empty($keyword)) {
            return [];
        }
        $katakanaKeyword = mb_convert_kana($keyword, 'C');
        return $this->searchRepository->getMasterByKeyword($modelClass, $keyword, $katakanaKeyword);
    }
}
