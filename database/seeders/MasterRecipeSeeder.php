<?php

namespace Database\Seeders;

use App\Models\MasterIngredient;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MasterRecipeSeeder extends Seeder
{
    public function run(): void
    {
        $ingredients = [
            ['name' => '軟飯'],
            ['name' => 'うどん'],
            ['name' => 'そば'],
            ['name' => '食パン'],
            ['name' => '牛肉'],
            ['name' => '豚肉'],
            ['name' => '鶏肉'],
            ['name' => '鮭'],
            ['name' => 'しらす'],
            ['name' => '鯖'],
            ['name' => '豆腐'],
            ['name' => 'ほうれん草'],
            ['name' => '白菜'],
            ['name' => 'キャベツ'],
            ['name' => '人参'],
            ['name' => '玉葱'],
            ['name' => 'トマト'],
            ['name' => '卵'],
            // ... 必要なだけ記述
        ];

        MasterIngredient::upsert(
            $ingredients,
            ['name'],
            []
        );
    }
}
