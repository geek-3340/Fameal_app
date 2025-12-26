<?php

namespace Database\Seeders;

use App\Models\MasterRecipe;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MasterIngredientSeeder extends Seeder
{
    public function run(): void
    {
        $recipes = [
            ['name' => 'カレーライス'],
            ['name' => 'ハンバーグ'],
            ['name' => '肉じゃが'],
            ['name' => 'オムライス'],
            ['name' => '生姜焼き'],
            ['name' => '唐揚げ'],
            // ... 必要なだけ記述
        ];

        MasterRecipe::upsert(
            $recipes,
            ['name'],
            []
        );
    }
}
