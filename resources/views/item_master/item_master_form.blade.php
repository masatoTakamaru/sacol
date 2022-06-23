<table>
<tbody>

<tr>
    <td><label class="mr-4" for="code">コード<span class="text-red-600">*</span></label></td>
    <td>
        <input class="border rounded" type="number" name="code" min="1" max="9999" size="4" value="{{ old('code') ?? $item_master->code }}">
        @if ($errors->has('code'))
            <p class="text-red-600">{{ $errors->first('code') }}</p>
        @endif
    </td>
</tr>
<tr>
    <td><label class="mr-4" for="category">種別<span class="text-red-600">*</span></label></td>
    <td>
        <select id="item-master-caterogy-select" class="border rounded py-2 pl-2 pr-8" name="category">
            <option value="">選択</option>
            @foreach ($categories as $cat)
                @if ($loop->index + 1 == (old('category') ?? $item_master->category))
                    <option value="{{ $loop->index + 1 }}" selected="selected">{{ $cat }}</option>
                @else
                    <option value="{{ $loop->index + 1 }}">{{ $cat }}</option>
                @endif
            @endforeach
        </select>
        @if ($errors->has('category'))
            <p class="text-red-600">{{ $errors->first('category') }}</p>
        @endif
    </td>
</tr>
<tr>
    <td><label class="mr-4" for="name">科目名<span class="text-red-600">*</span></label></td>
    <td>
        <input class="border rounded" type="text" name="name" size="30" value="{{ old('name') ?? $item_master->name }}">
        @if ($errors->has('name'))
            <p class="text-red-600">{{ $errors->first('name') }}</p>
        @endif
    </td>
</tr>
<tr>
    <td><label class="mr-4" for="name">価格<span class="text-red-600">*</span></label></td>
    <td>
        <input id="item-master-price-field" class="border rounded" type="number" name="price" mix="0" max="999999" size="6" value="{{ old('price') ?? $item_master->price }}">
        @if ($errors->has('price'))
            <p class="text-red-600">{{ $errors->first('price') }}</p>
        @endif
    </td>
</tr>
<tr>
    <td><label class="mr-4" for="description">摘要</label></td>
    <td>
        <input class="border rounded" type="text" name="description" size="50" value="{{ old('description') ?? $item_master->description }}">
        @if ($errors->has('description'))
            <p class="text-red-600">{{ $errors->first('description') }}</p>
        @endif
    </td>
</tr>

</tbody>
</table>

<script>
    const e = document.querySelector('#item-master-caterogy-select');
    if (e.value == '1') {
        $('#item-master-price-field').hide();        
    }
    e.addEventListener('change', () => {
        if (e.value == '1') {
            $('#item-master-price-field').slideUp();
        } else {
            $('#item-master-price-field').slideDown();
        }
    });
</script>