<x-guest-layout>
    <div class="home-container">
        <div>
            <div class="front-logo">
                <p class="flex items-center font-top-page text-3xl text-green-800 pt-8 pl-10 app-name"><img class="mr-4" src="fabicon-64x64.png"/>Sacol</p>
                <p class="font-top-page text-xl text-green-800 font-bold pb-8 mt-4 ml-28">小規模学習塾・習い事教室向け月謝管理アプリ</p>
            </div>
            <div class="flex justify-center mt-28">
                @if (Route::has('login'))
                    <a href="{{ route('login') }}" class="btn btn-login py-2 text-center">ログイン</a>
                @endif
            </div>
            <div class="flex justify-center mt-6">
                <a href="{{ route('register') }}" class="btn-white btn-register py-2 text-center">新規登録はこちらから</a>
            </div>
        </div>
    </div>
    <div class="container">
        <p>#contents</p>
    </div>
    <div class="home-footer">
        <div class="flex justify-end">
            <ul class="footer-list mr-4">
                <li>プライバシーポリシー</li>
                <li>お問い合わせ</li>
                <li>powered by mmsankosho 2022</li>
            </ul>
        </div>
    </div>
</x-guest-layout>
