<x-app-layout>
    <x-slot name="header">
        <h2>生徒の一覧</h2>
    </x-slot>
    <div class="flex">
        <p>生徒数：{{ $students->count() }}人</p>
    </div>
    <div class="flex justify-end">
        <a class="text-blue-500 py-4 mr-6" href="{{ route('student.create') }}">生徒の新規登録</a>
        <a class="text-blue-500 py-4" href="{{ route('student.expired_index') }}">退会者の一覧</a>
    </div>
    <div class="flex justify-center">
    <table>
    <thead>
    <tr>
        <th>学年</th>
        <th>名前</th>
        <th>フリガナ</th>
        <th>性別</th>
    </tr>
    </thead>
    <tbody>
    @foreach($students as $st)
        <tr>
            <td class="pr-2">{{ $grades[$st->grade] }}</td>
            <td class="pr-2"><a class="text-blue-500 underline" href="{{ route('student.show', ['student' => Hashids::encode($st->id)]) }}">{{ $st->family_name }}&nbsp;{{ $st->given_name }}</a></td>
            <td class="pr-2">{{ $st->family_name_kana }}&nbsp;{{ $st->given_name_kana }}</td>
            <td class="pr-2 text-center">{{ $st->gender }}</td>
        </tr>
    @endforeach
    </tbody>
    </table>
    </div>
</x-app-layout>