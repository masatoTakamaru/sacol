<x-app-layout>
    <x-slot name="header">
        <h2>生徒の編集</h2>
    </x-slot>

    <div class="flex justify-end">
        <p class="text-red-600">*は入力必須</p>
    </div>

    <div class="flex justify-center">

        <form action="{{ route('student.update',['student' => $st->id]) }}" method="POST">
            @method('PUT')
            @csrf

            <div class="flex items-center">
                @include('student/student_form')
            </div>

            <div class="flex justify-center mt-6">
                <button class="btn px-8 py-2 mr-6"><input type="submit" value="更新する"></button>
                <a class="btn-white px-6 py-2" href="{{ route('student.show', ['student' => Hashids::encode($st->id)]) }}">キャンセル</a>
            </div>

        </form>

    </div>

</x-app-layout>