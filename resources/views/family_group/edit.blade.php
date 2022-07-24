<x-app-layout>
    <x-slot name="header">
        <h2>{{ $student->family_name }}&emsp;{{ $student->given_name }} さんの家族設定</h2>
    </x-slot>

    <div class="flex justify-end mb-6">
        <a class="text-blue-500" href="{{ route('student.show', ['student' => Hashids::encode($student->id)])}}">生徒の詳細に戻る</a>
    </div>
    <div class="flex justify-center">
    <table>
        <thead>
        <tr>
            <th></th>
            <th>学年</th>
            <th>名前</th>
            <th>フリガナ</th>
            <th>性別</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($students as $st)
            @unless ($st->id == $student->id)
                <tr>
                    @if ($st->family_group == $student->family_group)
                        <td class="pr-4">
                            <form action="{{ route('family_group.update',['student' => Hashids::encode($student->id)]) }}" method="POST">
                                @method('PUT')
                                @csrf
                                <input type="hidden" name="id" value="{{ $st->id }}"></input>
                                <input type="hidden" name="family_group" value="{{ Str::uuid(); }}"></input>
                                <button class="btn-sm-white px-2 py-1 text-xs"><input type="submit" value="解除"></input></button>
                            </form>
                        </td>
                    @else
                        <td class="pr-4">
                            <form action="{{ route('family_group.update',['student' => Hashids::encode($student->id)]) }}" method="POST">
                                @method('PUT')
                                @csrf
                                <input type="hidden" name="id" value="{{ $st->id }}"></input>
                                <input type="hidden" name="family_group" value="{{ $student->family_group }}"></input>
                                <button class="btn-sm px-2 py-1 text-xs"><input type="submit" value="設定"></input></button>
                            </form>
                        </td>
                    @endif
                    <td class="pr-4">{{ $grades[$st->grade] }}</td>
                    <td class="pr-4">{{ $st->family_name }}&emsp;{{ $st->given_name }}</td>
                    <td class="pr-4">{{ $st->family_name_kana }}&emsp;{{ $st->given_name_kana }}</td>
                    <td class="pr-4">{{ $st->gender }}</td>
                </tr>
            @endunless
        @endforeach
    </table>
    </div>
</x-app-layout>
