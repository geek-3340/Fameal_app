<?php

namespace Database\Seeders;

use App\Models\MasterBabyFood;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MasterBabyFoodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $babyFoods = [
            ['name' => 'おかゆ', 'kana' => 'オカユ'],
            ['name' => '軟飯', 'kana' => 'ナンハン'],
            ['name' => 'うどん', 'kana' => 'ウドン'],
            ['name' => 'そうめん', 'kana' => 'ソウメン'],
            ['name' => 'パン', 'kana' => 'パン'],
            ['name' => '食パン', 'kana' => 'ショクパン'],
            ['name' => 'パンがゆ', 'kana' => 'パンガユ'],
            ['name' => 'にんじん', 'kana' => 'ニンジン'],
            ['name' => '大根', 'kana' => 'ダイコン'],
            ['name' => 'かぼちゃ', 'kana' => 'カボチャ'],
            ['name' => 'じゃがいも', 'kana' => 'ジャガイモ'],
            ['name' => 'さつまいも', 'kana' => 'サツマイモ'],
            ['name' => '玉ねぎ', 'kana' => 'タマネギ'],
            ['name' => '小松菜', 'kana' => 'コマツナ'],
            ['name' => 'ほうれん草', 'kana' => 'ホウレンソウ'],
            ['name' => 'ブロッコリー', 'kana' => 'ブロッコリー'],
            ['name' => 'キャベツ', 'kana' => 'キャベツ'],
            ['name' => '白菜', 'kana' => 'ハクサイ'],
            ['name' => 'トマト', 'kana' => 'トマト'],
            ['name' => 'なす', 'kana' => 'ナス'],
            ['name' => 'きゅうり', 'kana' => 'キュウリ'],
            ['name' => '豆腐', 'kana' => 'トウフ'],
            ['name' => 'しらす', 'kana' => 'シラス'],
            ['name' => '白身魚', 'kana' => 'シロミザカナ'],
            ['name' => '鶏ささみ', 'kana' => 'トリササミ'],
            ['name' => '鶏ひき肉', 'kana' => 'トリヒキニク'],
            ['name' => 'りんご', 'kana' => 'リンゴ'],
            ['name' => 'バナナ', 'kana' => 'バナナ'],
            ['name' => 'みかん', 'kana' => 'ミカン'],
            ['name' => 'もも', 'kana' => 'モモ'],
            ['name' => 'いちご', 'kana' => 'イチゴ'],
            ['name' => 'ヨーグルト', 'kana' => 'ヨーグルト'],
            ['name' => 'チーズ', 'kana' => 'チーズ'],
            ['name' => '卵黄', 'kana' => 'ランオウ'],
            // ... 必要なだけ記述
        ];

        MasterBabyFood::upsert(
            $babyFoods,
            ['name'],
            []
        );
    }
}
