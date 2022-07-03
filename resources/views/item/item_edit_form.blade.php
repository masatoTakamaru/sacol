<td></td>
<td colspan="6">
    <div class="bg-gray-300 rounded">

    <form action="{{ route('item.update', ['item' => $item->id]) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="p-4">

        <table>
        <tbody>
        @if ($item->category != 0)
            <tr>
                <td>コード</td>
                <td class="mr-2">
                    {{ $item->code }}
                </td>
            </tr>
            <tr>
                <td>
                    <label class="mr-2" for="category">種別</label>
                </td>
                <td id="category">
                    {{ $categories[$item->category] }}
                </td>
            </tr>
        @endif
        <tr>
            <td>
                <label class="mr-2" for="name">科目名</label>
            </td>
            <td class="mr-2">
                <input id="name" name="name" class="rounded mr-1" type="text" max="20" size="30" value="{{ old('name') ?? $item->name }}"></input>
            </td>
        </tr>
        @if ($errors->has('name'))
            <tr>
                <td></td>
                <td>
                    <p class="text-red-600">{{ $errors->first('name') }}</p>
                </td>
            </tr>
        @endif

        @if ($item->category != 1)
            <tr>
                <td>
                    <label class="mr-2" for="price">価格</label>
                </td>
                <td class="mr-2">
                    <input id="price" name="price" class="rounded mr-1" type="number" mix="0" max="999999" size="8" value="{{ old('price') ?? $item->price }}"></input>
                </td>
            </tr>
        @endif
        @if ($errors->has('price'))
            <tr>
                <td></td>
                <td>
                    <p class="text-red-600">{{ $errors->first('price') }}</p>
                </td>
            </tr>
        @endif
        <tr>
            <td>
                <label class="mr-2" for="description">摘要</label>
            </td>
            <td class="mr-2">
                <input id="description" name="description" class="rounded mr-1" type="text" max="50" size="50" value="{{ old('description') ?? $item->description }}"></input>
            </td>
        </tr>
        @if ($errors->has('description'))
            <tr>
                <td></td>
                <td>
                    <p class="text-red-600">{{ $errors->first('description') }}</p>
                </td>
            </tr>
        @endif
        </tbody>
        </table>
        <div class="flex justify-center my-4">
            <div class="flex justify-center">
                <button class="btn mr-4 py-2 px-6 text-sm"><input type="submit" value="更新する"></input></button>
                <a class="btn-white py-2 px-4 text-sm" href="{{ route('item.edit', ['student'=>Hashids::encode($st->id), 'year'=>$year, 'month'=>$month]) }}">キャンセル</a>
            </div>
        </div>

        </div>
    </form>
    <form action="{{ route('item.destroy', ['item' => $item->id]) }}" method="POST">
        @csrf
        @method('DELETE')

        <div class="flex justify-between items-center p-4">
            <p>科目の削除</p>
            <button id="item-delete" class="btn-white py-2 px-8 text-sm"><input type="submit" value="削除"></button>
        </div>
    </form>
    
    </div>
</td>

<script>
    //生徒の削除：確認メッセージ
    $("#item-delete").on('click', () => {
        if(!confirm("削除してもよろしいですか？")) return false;
    });
</script>
