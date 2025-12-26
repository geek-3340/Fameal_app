{{-- 料理名 --}}
<div class="relative mb-5">
    <label for="recipe_name">料理名</label>
    <input type="text" id="recipe-input" name="recipe_name" placeholder="料理名を入力（例：カレー）" autocomplete="off">
    <ul id="recipe-list"
        class=" absolute top-full left-0 right-0 bg-white border-b border-[#ccc]  list-none p-0 m-0 z-50 hidden"></ul>
</div>

{{-- 材料名 --}}
<div class="relative mb-5">
    <label for="ingredient_name">材料名</label>
    <input type="text" id="ingredient-input" name="ingredient_name" placeholder="材料を入力" autocomplete="off">
    <ul id="ingredient-list"
        class=" absolute top-full left-0 right-0 bg-white border-b border-[#ccc]  list-none p-0 m-0 z-50 hidden"></ul>
</div>
