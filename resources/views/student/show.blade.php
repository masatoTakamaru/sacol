<x-app-layout>
    <x-slot name="header">
        <h2>生徒の詳細</h2>
    </x-slot>
    <div class="flex justify-end">
        <a class="text-blue-500 mr-4" href="{{ route('student.edit', ['student' => Hashids::encode($st->id)]) }}">編集</a>
        <a class="text-blue-500" href="{{ route('student.index') }}">生徒の一覧に戻る</a>
    </div>
    <div class="flex justify-center">
    <table>
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
        <td class="pr-4">生年月日</td>
        <td class="pr-2">{{ $st->birth_date }}</td>
    </tr>
    <tr>
        <td class="pr-4">学校名</td>
        <td class="pr-2">{{ $st->school_attended }}</td>
    </tr>
    <tr>
        <td class="pr-4">保護者名</td>
        <td class="pr-2">{{ $st->guardian_family_name }}&nbsp;{{ $st->guardian_given_name }}</td>
    </tr>
    <tr>
        <td class="pr-4">フリガナ</td>
        <td class="pr-2">{{ $st->guardian_family_name_kana }}&nbsp;{{ $st->guardian_given_name_kana }}</td>
    </tr>
    <tr>
        <td class="pr-4">電話番号１</td>
        <td class="pr-2">{{ $st->phone1 }}</td>
    </tr>
    <tr>
        <td class="pr-4">続柄</td>
        <td class="pr-2">{{ $st->phone1_relationship }}</td>
    </tr>
    <tr>
        <td class="pr-4">電話番号２</td>
        <td class="pr-2">{{ $st->phone2 }}</td>
    </tr>
    <tr>
        <td class="pr-4">続柄</td>
        <td class="pr-2">{{ $st->phone2_relationship }}</td>
    </tr>
    <tr>
        <td class="pr-4">メールアドレス</td>
        <td class="pr-2">{{ $st->email }}</td>
    </tr>
    <tr>
        <td class="pr-4">備考</td>
        <td>{{ $st->remarks }}</td>
    </tr>
    </tbody>
    </table>
    </div>
    <div class="flex justify-between items-center">
        <h2 class="mr-4">生徒の退会</h2>
        <p class="mr-6">生徒を退会者名簿に移動します。</p>
        <div class="flex items-center">
            <label class="mr-4" for="expired_date">退会日</label>
            @if ($st->expired_flg)
                <input class="border rounded" type="date" name="expired_date" value="{{ old('expired_date') ?? $st->expired_date }}">
            @else
                <input class="border rounded" type="date" name="expired_date" value="">
            @endif
            @if ($errors->has('expired_date'))
                <p class="text-red-600">{{ $errors->first('expired_date') }}</p>
            @endif
        </div>
    </div>
    <hr class="mt-4">    
    <form action="{{ route('student.destroy',['student' => $st->id]) }}" method="POST">
        @method('DELETE')
        @csrf
        <div class="flex justify-between items-center mt-10">
            <h2 class="mr-4 text-red-500">生徒の削除</h2>
            <p class="mr-6">生徒は一覧から完全に削除され、もとに戻せません。</p>
            <button id="student-delete" class="btn btn-white px-8 py-2"><input type="submit" value="完全に削除する"></button>
        </div>
    </form>
</x-app-layout>