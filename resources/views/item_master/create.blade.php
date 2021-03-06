<x-app-layout>
    <x-slot name="header">
        <h2>科目の新規登録</h2>
    </x-slot>

    <div class="flex justify-end">
        <p class="text-red-600">*は入力必須</p>
    </div>

    <div class="flex justify-center">

    <form action="{{ route('item_master.store') }}" method="POST">
        @csrf

        <div class="flex items-center">
            @include('item_master/item_master_form')
        </div>

        <div class="flex justify-center mt-6">
            <button class="btn px-8 py-2 mr-6"><input type="submit" value="登録する" disabled></button>
            <a class="btn-white px-6 py-2" href="{{ route('item_master.index') }}">キャンセル</a>
        </div>

        <div class="mt-8">
            <p class="text-green-500">サンプルのため新規登録はできません。</p>
        </div>

    </form>

</div>

</x-app-layout>