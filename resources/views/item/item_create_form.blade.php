<form action="{{ route('item.store') }}" method="POST">
    @csrf

    <input type="hidden" name="sheet_id" value="{{ $sheet->id }}"></input>
    <input type="hidden" name="student_id" value="{{ $st->id }}"></input>

    <table>
    <tbody>
    <tr>
        <td>コード</td>
        <td class="mr-2">
            <input id="code" name="code" class="rounded mr-1" type="number" min="1" max="9999" size="8" value="{{ old('code') ?? $new_item->code }}"></input>
            <button type="button" id="api-search" class="btn-search shadow py-1 px-2 text-sm">検索</button>
        </td>
    </tr>
    <tr>
        <td>
            <label class="mr-2" for="category">種別</label>
        </td>
        <td>
            <select id="category" class="pl-2 py-2 w-48 rounded" name="category">
                <option value="">選択してください</option>
                @foreach ($categories as $cat)
                    @if ($loop->index > 0)
                        @if (old('category') && old('category') == $loop->index)
                            <option value="{{ $loop->index }}" selected="selected">{{ $cat }}</option>
                        @else
                            <option value="{{ $loop->index }}">{{ $cat }}</option>
                        @endif
                    @endif
                @endforeach
            </select>
        </td>
    </tr>
    <tr>
        <td>
            <label class="mr-2" for="name">科目名</label>
        </td>
        <td class="mr-2">
            <input id="name" name="name" class="rounded mr-1" type="text" max="20" size="30" value="{{ old('name') ?? $new_item->name }}"></input>
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
    <tr>
        <td>
            <label class="mr-2" for="price">価格</label>
        </td>
        <td class="mr-2">
            <input id="price" name="price" class="rounded mr-1" type="number" mix="0" max="999999" size="8" value="{{ old('price') ?? $new_item->price }}"></input>
        </td>
    </tr>
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
            <input id="description" name="description" class="rounded mr-1" type="text" max="50" size="50" value="{{ old('description') ?? $new_item->description }}"></input>
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
    @if (session('error'))
        <tr>
            <td></td>
            <td>
                <p class="text-red-600">{{ session('error') }}</p>
            </td>
        </tr>
    @endif
    </tbody>
    </table>
    <div class="flex justify-center my-4">
        <div class="flex justify-center">
            <button class="btn mr-4 py-2 px-6 text-sm"><input type="submit" value="新規登録"></input></button>
        </div>
    </div>
</form>

<script>
    let elem_price = document.querySelector('#price');
    let elem_cat = document.querySelector('#category');
    //コードから科目を検索
    document.querySelector('#api-search').addEventListener('click', ()=> {
        const elem_code = document.querySelector('#code');
        const code = elem_code.value;
        fetch('/item_master/' + code + '/search')
            .then((data) => data.json())
            .then((obj) => {
                //オブジェクトが空かどうか判定
                if (!Object.keys(obj).length) {
                    document.querySelector('#name').value = '科目が存在しません';
                    elem_cat.value = null;
                    elem_price.value = null;
                    document.querySelector('#description').value = null;
                } else {
                    elem_cat.value = obj.category;
                    document.querySelector('#name').value = obj.name;
                    elem_price.value = obj.price;
                    document.querySelector('#description').value = obj.description;
                }
                //従量課金型科目の場合は価格を表示しない
                if (obj.category == '1') {
                    elem_price.style.display='none';
                } else {
                    elem_price.style.display='block';
                }
            });
        elem_code.focus();
    });
    //従量課金型科目の場合は価格を表示しない
    elem_cat.addEventListener('load', catDisplay());
    elem_cat.addEventListener('change', catDisplay());
    function catDisplay() {
        if (elem_cat.value == '1') {
            elem_price.style.display='none';
        } else {
            elem_price.style.display='block';
        }        
    }

</script>