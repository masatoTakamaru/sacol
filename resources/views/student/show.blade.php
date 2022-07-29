<x-app-layout>
    <x-slot name="header">
        <h2>生徒の詳細</h2>
    </x-slot>
    <div class="flex justify-end">
        <a class="text-blue-500 mr-4" href="{{ route('student.edit', ['student' => Hashids::encode($st->id)]) }}">編集</a>
        <a class="text-blue-500 mr-4" href="{{ route('family_group.edit', ['student' => Hashids::encode($st->id)]) }}">家族設定</a>
        <a class="text-blue-500" href="{{ route('student.index') }}">生徒の一覧に戻る</a>
    </div>
    <div class="flex justify-center">
    <table class="mb-12">
    <tbody>
        <tr>
            <td class="pr-4">学年</td>
            <td class="pr-2">{{ $grades[$st->grade] }}</td>
        </tr>
        <tr>
            <td class="pr-4">名前</td>
            <td class="pr-2">{{ $st->family_name }}&nbsp;{{ $st->given_name }}</td>
        </tr>
        <tr>
            <td class="pr-4">フリガナ</td>
            <td class="pr-2">{{ $st->family_name_kana }}&nbsp;{{ $st->given_name_kana }}</td>
        </tr>
        <tr>
            <td class="pr-4">性別</td>
            <td class="pr-2">{{ $st->gender }}</td>
        </tr>
        <tr>
            <td class="pr-4">メールアドレス</td>
            <td class="pr-2">{{ $st->email }}</td>
        </tr>
        <tr>
            <td class="pr-4">備考</td>
            <td>{{ $st->remarks }}</td>
        </tr>
        <tr>
            <td class="pr-4">入会日</td>
            <td>{{ $st->registered_date }}</td>
        </tr>
        @if($st->expired_flg)
            <tr>
                <td class="pr-4">退会日</td>
                <td>{{ $st->expired_date }}</td>
            </tr>
        @endif
        {{-- 家族の表示 --}}
        <tr>
            <td>家族</td>
            <td>
                <ul>
                    @foreach ($family_members as $fm)
                        <li><a class="text-blue-500" href="{{ route('student.show', ['student' => Hashids::encode($fm->id)]) }}">{{ $fm->family_name }}&emsp;{{ $fm->given_name }}</a>（{{ $grades[$fm->grade] }}）</li>
                    @endforeach
                </ul>
            <td>
        </tr>
    </tbody>
    </table>
    </div>
    {{-- 生徒の退会  --}}
    @if ($st->expired_flg)
        <form action="{{ route('student.unexpired_update',['student' => $st->id]) }}" method="POST">
            @method('PUT')
            @csrf
            <div class="flex justify-between items-center">
                <h2 class="mr-4">退会の取り消し</h2>
                <p class="mr-6">退会を取り消して，生徒の一覧に戻します。</p>
                <button class="btn-white px-8 py-2"><input type="submit" value="退会を取り消す"></button>
            </div>
        </form>
    @else
        <form action="{{ route('student.expired_update',['student' => $st->id]) }}" method="POST">
            @method('PUT')
            @csrf
            <div class="flex justify-between items-center">
                <h2 class="mr-4">生徒の退会</h2>
                <p class="mr-6">生徒を退会者名簿に移動します。</p>
                <div class="flex items-center">
                    <label class="mr-4" for="expired_date">退会日</label>
                    <input class="border rounded" type="date" name="expired_date" value="">
                </div>
            </div>
            @if ($errors->has('expired_date'))
                <p class="text-red-600">{{ $errors->first('expired_date') }}</p>
            @endif
            <div class="flex justify-end mt-3">
                <button class="btn-white px-8 py-2"><input type="submit" value="退会者名簿に移動する" disabled></button>
            </div>
        </form>
    @endif
    {{-- 生徒の削除 --}}
    <hr class="mt-4">
    <form action="{{ route('student.destroy',['student' => $st->id]) }}" method="POST">
        @method('DELETE')
        @csrf
        <div class="flex justify-between items-center mt-10">
            <h2 class="mr-4 text-red-500">生徒の削除</h2>
            <p class="mr-6">生徒は一覧から完全に削除され、もとに戻せません。</p>
            <button id="student-delete" class="btn-white px-8 py-2"><input type="submit" value="完全に削除する" disabled></button>
        </div>
        <div class="mt-8">
            <p class="text-green-500">サンプルのため退会および削除はできません。</p>
        </div>
    </form>

    <script>
        //生徒の削除：確認メッセージ
        $("#student-delete").on('click', () => {
            if(!confirm("削除してもよろしいですか？")) return false;
        });
    </script>
</x-app-layout>