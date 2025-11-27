<x-app-layout>
    <div class="mx-auto my-8 w-3/5 max-md:w-11/12">
        <nav class="flex justify-center mb-8 md:hidden">
            @if (request()->routeIs('top.page'))
                @auth
                    <x-link-button href="{{ route('menus.index', ['category' => 'dishes', 'viewType' => 'month']) }}"
                        type="primary">
                        マイページ
                    </x-link-button>
                @else
                    <x-link-button href="{{ route('login') }}" type="primary">
                        ログイン
                    </x-link-button>
                @endauth
                <x-link-button href="{{ route('register') }}" type="register" class="ml-4 max-md:ml-2">
                    新規登録
                </x-link-button>
            @else
                <x-link-button href="{{ url()->previous() }}" type="primary">
                    戻る
                </x-link-button>
            @endif
        </nav>
        <h1 class="text-3xl font-bold text-center max-md:text-xl">
            <span class="text-main">献立 × 離乳食</span> 子育てをもっとラクにするアプリ
        </h1>

        <div class="mt-8">
            <p class="w-4/5 h-full mx-auto text-left font-semibold leading-relaxed">
                「Fameal（ファミール）」は、毎日の献立と離乳食を “ひとつのアプリでまとめて管理できる” 子育て支援アプリです。<br><br>
                離乳食初期（ゴックン期）〜中期（モグモグ期）に必要な
                食材ごとの g（グラム）管理と、大人の食事の献立管理はまったく別の作業になりがちです。<br><br>
                Fameal は、その両方を直感的に操作できるよう設計されており子育て中の毎日の「何を食べさせよう…？」をスムーズにします。
            </p>

            <div class="mt-8 p-4 bg-sub rounded-xl shadow-custom">
                <p class="text-xl font-bold text-center">主な機能</p>
                <ul class="grid grid-cols-2 gap-4 mt-4 max-xl:grid-cols-1">
                    <li class="bg-white rounded-lg p-1 text-center">
                        <h3 class="font-semibold">献立カレンダー機能</h3>
                        <p class="text-sm">料理／離乳食、月／週での表示切替</p>
                        <p class="text-sm">朝・昼・夜の献立カテゴリー分け</p>
                        <p class="text-sm">離乳食の g 数登録</p>
                    </li>
                    <li class="bg-white rounded-lg p-1 text-center">
                        <h3 class="font-semibold">料理登録機能</h3>
                        <p class="text-sm">主食・主菜・副菜ごとのカテゴリー分け</p>
                        <p class="text-sm">レシピURL・材料の登録機能</p>
                    </li>
                    <li class="bg-white rounded-lg p-1 text-center">
                        <h3 class="font-semibold">離乳食登録機能</h3>
                        <p class="text-sm">三大栄養素ごとのカテゴリー分け</p>
                    </li>
                    <li class="bg-white rounded-lg p-1 text-center">
                        <h3 class="font-semibold">買い物リスト機能</h3>
                        <p class="text-sm">献立から自動で買い物リストを作成</p>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</x-app-layout>
