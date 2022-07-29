<x-guest-layout>
    <div class="home-container">
        <div>
            <div class="front-logo">
                <p class="flex items-center text-3xl text-green-800 pt-8 pl-10 front-logo"><img class="mr-4" src="fabicon-64x64.png"/>Sacol</p>
                <p class="text-xl text-green-800 font-bold pb-8 mt-4 ml-28">小規模学習塾・習い事教室向け月謝管理アプリ</p>
            </div>
            <div class="flex justify-center mt-28">
                @if (Route::has('login'))
                    <a href="{{ route('login') }}" class="btn btn-login py-2 text-center">ログイン</a>
                @endif
            </div>
            <div class="flex justify-center mt-6">
                <!--
                <a href="{{ route('register') }}" class="btn-white btn-register py-2 text-center" disabled>新規登録はこちらから</a>
                -->
                <a class="btn-white btn-register py-2 text-center" disabled>新規登録はこちらから</a>
            </div>
        </div>
    </div>
    <div class="introduction mt-6">
        <p class="text-green-500">このサイトはサンプルのためユーザーの新規登録はできません。デフォルトのユーザーとしてログインして動作を確認して下さい。</p>
        <div class="intro-cards-container flex flex-wrap justify-evenly">
            <div class="intro-card">
                <img class="intro-img" src="{{ asset('images/intro01.webp') }}">
                <h2 class="mb-4 font-bold">ダッシュボード</h2>
                <p>月別の帳票を管理できます。帳票を新規作成すると最新の月の帳簿が作成されます。</p>
            </div>
            <div class="intro-card">
                <img class="intro-img" src="{{ asset('images/intro07.webp') }}">
                <h2 class="mb-4 font-bold">帳票</h2>
                <p>生徒ごとの請求額を確認することができます。家族設定が行われている場合は家族ごとの請求額が表示されます。</p>
            </div>
            <div class="intro-card">
                <img class="intro-img" src="{{ asset('images/intro02.webp') }}">
                <h2 class="mb-4 font-bold">生徒管理</h2>
                <p>生徒管理画面から新規生徒の登録・更新・削除が行えます。</p>
            </div>
            <div class="intro-card">
                <img class="intro-img" src="{{ asset('images/intro03.webp') }}">
                <h2 class="mb-4 font-bold">生徒の新規登録</h2>
                <p>生徒の新規登録ができます。入力した情報はバリデーションチェックを受けます。</p>
            </div>
            <div class="intro-card">
                <img class="intro-img" src="{{ asset('images/intro04.webp') }}">
                <h2 class="mb-4 font-bold">生徒の編集</h2>
                <p>生徒の編集ができます。退会処理を行うと，生徒は退会者名簿に移動します。また，退会した生徒は退会者名簿から再び生徒名簿に戻すことができます。</p>
            </div>
            <div class="intro-card">
                <img class="intro-img" src="{{ asset('images/intro05.webp') }}">
                <h2 class="mb-4 font-bold">家族設定</h2>
                <p>複数の生徒を家族設定により紐づけすることができます。これによりダッシュボードで家族ごとの請求額が表示されるようになります。</p>
            </div>
            <div class="intro-card">
                <img class="intro-img" src="{{ asset('images/intro08.webp') }}">
                <h2 class="mb-4 font-bold">科目設定</h2>
                <p>科目のテンプレートを用意することで，生徒が受講する科目を素早く登録することができます。</p>
            </div>
            <div class="intro-card">
                <img class="intro-img" src="{{ asset('images/intro09.webp') }}">
                <h2 class="mb-4 font-bold">生徒ごとの科目の編集</h2>
                <p>テンプレートを用いて登録された科目は，あとから編集することができます。これによって，その生徒のみ価格を変更する等のケースに対応することができます。</p>
            </div>
            <div class="intro-card">
                <img class="intro-img" src="{{ asset('images/intro10.webp') }}">
                <h2 class="mb-4 font-bold">従量課金型科目の設定</h2>
                <p>受講する科目数に応じた金額を設定することができます。</p>
            </div>
        </div>
    </div>
    <div class="home-footer">
        <div class="flex justify-end">
            <ul class="footer-list mr-4">
                <li>powered by mmsankosho 2022</li>
            </ul>
        </div>
    </div>
</x-guest-layout>
