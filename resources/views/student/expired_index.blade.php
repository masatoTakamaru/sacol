<x-app-layout>
    <x-slot name="header">
        <h2>退会者の一覧</h2>
    </x-slot>
    <div class="flex">
        <p>退会者数：{{ $students->count() }}人</p>
    </div>

    <div class="flex justify-center">
    <table>
    <thead>
    <tr>
        <th>学年</th>
        <th>名前</th>
        <th>フリガナ</th>
        <th>性別</th>
        <th>退会日</th>
    </tr>
    </thead>
    <tbody>
    @foreach($students as $st)
        <tr>
            <td class="pr-2">{{ $grades[$st->grade] }}</td>
            <td class="pr-2"><a class="text-blue-500 underline" href="{{ route('student.show', ['student' => Hashids::encode($st->id)]) }}">{{ $st->family_name }}&nbsp;{{ $st->given_name }}</a></td>
            <td class="pr-2">{{ $st->family_name_kana }}&nbsp;{{ $st->given_name_kana }}</td>
            <td class="pr-2">{{ $st->gender }}</td>
            <td>{{ $st->expired_date }}</td>
        </tr>
    @endforeach
    </tbody>
    </table>
    </div>
</x-app-layout>