<x-app-layout>
    <x-slot name="header">
        <h2>科目の編集</h2>
    </x-slot>

    <div class="flex justify-end">
        <p class="text-red-600">*は入力必須</p>
    </div>

    <div class="flex justify-center">

    <form action="{{ route('item_master.update', ['item_master' => $item_master->id]) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="flex items-center">
            @include('item_master/item_master_form')
        </div>

        <div class="flex justify-center mt-6">
            <button class="btn px-8 py-2 mr-6"><input type="submit" value="更新する"></button>
            <a class="btn-white px-6 py-2" href="{{ route('item_master.index') }}">キャンセル</a>
        </div>
    </form>

    </div>

    <hr class="mt-4">
    <form action="{{ route('item_master.destroy',['item_master' => $item_master->id]) }}" method="POST">
        @method('DELETE')
        @csrf
        <div class="flex justify-between items-center mt-10">
            <h2 class="mr-4 text-red-500">科目の削除</h2>
            <p class="mr-6">科目は一覧から完全に削除され、もとに戻せません。</p>
            <button id="item-master-delete" class="btn-white px-8 py-2"><input type="submit" value="完全に削除する"></button>
        </div>
    </form>

    <script>
        //生徒の削除：確認メッセージ
        $("#item-master-delete").on('click', () => {
            if(!confirm("削除してもよろしいですか？")) {
                return false;
            }
        });
    </script>
</x-app-layout>