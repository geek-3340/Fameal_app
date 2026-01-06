<?php

namespace App\Repositories;

class SearchRepository
{
    public function getMasterByKeyword($modelClass, $keyword, $katakanaKeyword)
    {
        return $modelClass::where(function ($query) use ($keyword, $katakanaKeyword) {
            $query->where('name', 'LIKE', "%{$keyword}%")          // 元の入力で検索
                ->orWhere('name', 'LIKE', "%{$katakanaKeyword}%")  // カタカナ変換後で検索
                ->orWhere('kana', 'LIKE', "%{$katakanaKeyword}%"); // フリガナで検索
        })->limit(10)->get('name');
    }
}
