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

        // --- カタカナ判定・変換ロジックを追加 ---
        // 'C' オプション：全角ひらがなを全角カタカナに変換
        $katakanaKeyword = mb_convert_kana($keyword, 'C');

        $recipes = MasterRecipe::where(function ($query) use ($keyword, $katakanaKeyword) {
            $query->where('name', 'LIKE', "%{$keyword}%")          // 元の入力で検索
                ->orWhere('name', 'LIKE', "%{$katakanaKeyword}%"); // カタカナ変換後で検索
        })
            ->limit(10)
            ->get('name');

        return response()->json($recipes);
    }

    public function searchBabyFoods(Request $request)
    {
        $keyword = $request->input('keyword');
        if (empty($keyword)) {
            return response()->json([]);
        }

        // --- カタカナ判定・変換ロジックを追加 ---
        // 'C' オプション：全角ひらがなを全角カタカナに変換
        $katakanaKeyword = mb_convert_kana($keyword, 'C');

        $babyFoods = MasterBabyFood::where(function ($query) use ($keyword, $katakanaKeyword) {
            $query->where('name', 'LIKE', "%{$keyword}%")          // 元の入力で検索
                ->orWhere('name', 'LIKE', "%{$katakanaKeyword}%"); // カタカナ変換後で検索
        })
            ->limit(10)
            ->get('name');

        return response()->json($babyFoods);
    }

    public function searchIngredients(Request $request)
    {
        $keyword = $request->input('keyword');
        if (empty($keyword)) {
            return response()->json([]);
        }

        // --- カタカナ判定・変換ロジックを追加 ---
        // 'C' オプション：全角ひらがなを全角カタカナに変換
        $katakanaKeyword = mb_convert_kana($keyword, 'C');

        $ingredients = MasterIngredient::where(function ($query) use ($keyword, $katakanaKeyword) {
            $query->where('name', 'LIKE', "%{$keyword}%")          // 元の入力で検索
                ->orWhere('name', 'LIKE', "%{$katakanaKeyword}%"); // カタカナ変換後で検索
        })
            ->limit(10)
            ->get('name');

        return response()->json($ingredients);
    }
}
