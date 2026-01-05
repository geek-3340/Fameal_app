<?php

namespace Database\Seeders;

use App\Models\MasterIngredient;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MasterIngredientSeeder extends Seeder
{
    public function run(): void
    {
        $ingredients = [
            ['name' => '豚肉', 'kana' => 'ブタニク'],
            ['name' => '豚バラ肉', 'kana' => 'ブタバラニク'],
            ['name' => '鶏もも肉', 'kana' => 'トリモモニク'],
            ['name' => '鶏むね肉', 'kana' => 'トリムネニク'],
            ['name' => '牛肉', 'kana' => 'ギュウニク'],
            ['name' => 'ひき肉', 'kana' => 'ヒキニク'],
            ['name' => 'ベーコン', 'kana' => 'ベーコン'],
            ['name' => 'ウインナー', 'kana' => 'ウインナー'],
            ['name' => '卵', 'kana' => 'タマゴ'],
            ['name' => '鮭', 'kana' => 'サケ'],
            ['name' => 'サバ', 'kana' => 'サバ'],
            ['name' => 'ツナ缶', 'kana' => 'ツナカン'],
            ['name' => '玉ねぎ', 'kana' => 'タマネギ'],
            ['name' => 'じゃがいも', 'kana' => 'ジャガイモ'],
            ['name' => 'にんじん', 'kana' => 'ニンジン'],
            ['name' => 'キャベツ', 'kana' => 'キャベツ'],
            ['name' => '白菜', 'kana' => 'ハクサイ'],
            ['name' => '大根', 'kana' => 'ダイコン'],
            ['name' => 'ピーマン', 'kana' => 'ピーマン'],
            ['name' => 'なす', 'kana' => 'ナス'],
            ['name' => '小松菜', 'kana' => 'コマツナ'],
            ['name' => 'ほうれん草', 'kana' => 'ホウレンソウ'],
            ['name' => 'もやし', 'kana' => 'モヤシ'],
            ['name' => 'ブロッコリー', 'kana' => 'ブロッコリー'],
            ['name' => 'トマト', 'kana' => 'トマト'],
            ['name' => 'きゅうり', 'kana' => 'キュウリ'],
            ['name' => 'かぼちゃ', 'kana' => 'カボチャ'],
            ['name' => '醤油', 'kana' => 'ショウユ'],
            ['name' => 'みりん', 'kana' => 'ミリン'],
            ['name' => '砂糖', 'kana' => 'サトウ'],
            ['name' => '塩', 'kana' => 'シオ'],
            ['name' => 'こしょう', 'kana' => 'コショウ'],
            ['name' => '味噌', 'kana' => 'ミソ'],
            ['name' => '酒', 'kana' => 'サケ'],
            ['name' => '酢', 'kana' => 'ス'],
            ['name' => 'マヨネーズ', 'kana' => 'マヨネーズ'],
            ['name' => 'ケチャップ', 'kana' => 'ケチャップ'],
            ['name' => 'サラダ油', 'kana' => 'サラダアブラ'],
            ['name' => 'ごま油', 'kana' => 'ゴマアブラ'],
            ['name' => '片栗粉', 'kana' => 'カタクリコ'],
            ['name' => '小麦粉', 'kana' => 'コムギコ'],
            ['name' => 'パン粉', 'kana' => 'パンコ'],
            ['name' => '牛乳', 'kana' => 'ギュウニュウ'],
            ['name' => 'バター', 'kana' => 'バター'],
            ['name' => 'ヨーグルト', 'kana' => 'ヨーグルト'],
            ['name' => 'チーズ', 'kana' => 'チーズ'],
            ['name' => '納豆', 'kana' => 'ナットウ'],
            ['name' => '豆腐', 'kana' => 'トウフ'],
            ['name' => '油揚げ', 'kana' => 'アブラアゲ'],
            ['name' => 'こんにゃく', 'kana' => 'コンニャク'],
            ['name' => 'しらたき', 'kana' => 'シラタキ'],
            // ... 必要なだけ記述
        ];
        MasterIngredient::upsert(
            $ingredients,
            ['name'],
            []
        );
    }
}
