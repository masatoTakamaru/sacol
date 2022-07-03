<x-app-layout>
    <x-slot name="header">
        <h2>従量課金型科目の設定</h2>
    </x-slot>

    <div class="flex justify-center">

    <select class="border rounded pl-2 pr-8" name="grade">
        <option value="">選択</option>
        @foreach ($grades as $grade)
            <option value="{{ $loop->index }}">{{ $grade }}</option>
        @endforeach
    </select>

    <form action="{{ route('qprice.update') }}" method="POST">
        @method('PUT')
        @csrf

        <div class="flex justify-center">
            <table>
            <tbody>
                <tr>
                    <th>１科目</th>
                    <th>２科目</th>
                    <th>３科目</th>
                    <th>４科目</th>
                </tr>
                <tr>
                    <td>


        </div>

        <div class="flex justify-center mt-6">
            <button class="btn px-8 py-2 mr-6"><input type="submit" value="更新する"></button>
            <a class="btn-white px-6 py-2" href="{{ route('item_master.index') }}">キャンセル</a>
        </div>

    </form>

    </div>

</x-app-layout>