<table>
<tbody>
<tr>
    <td><label class="mr-4" for="registered_date">入会日<span class="text-red-600">*</span></label></td>
    <td>
        <input class="border rounded" type="date" name="registered_date" value="{{ old('registered_date') ?? $st->registered_date }}">
        @if ($errors->has('registered_date'))
            <p class="text-red-600">{{ $errors->first('registered_date') }}</p>
        @endif
    </td>
</tr>
<tr>
    <td><label class="mr-4" for="family_name">生徒姓・名<span class="text-red-600">*</span></label></td>
    <td>
        <input class="border rounded" type="text" name="family_name" value="{{ old('family_name') ?? $st->family_name }}">
        <input class="border rounded" type="text" name="given_name" value="{{ old('given_name') ?? $st->given_name }}">
        @if ($errors->has('family_name'))
            <p class="text-red-600">{{ $errors->first('family_name') }}</p>
        @endif
        @if ($errors->has('given_name'))
            <p class="text-red-600">{{ $errors->first('given_name') }}</p>
        @endif
    </td>
</tr>
<tr>
    <td><label class="mr-4" for="family_name_kana">生徒フリガナ<span class="text-red-600">*</span></label></td>
    <td>
        <input class="border rounded" type="text" name="family_name_kana" value="{{ old('family_name_kana') ?? $st->family_name_kana }}">
        <input class="border rounded" type="text" name="given_name_kana" value="{{ old('given_name_kana') ?? $st->given_name_kana }}">
        @if ($errors->has('family_name_kana'))
            <p class="text-red-600">{{ $errors->first('family_name_kana') }}</p>
        @endif
        @if ($errors->has('given_name_kana'))
            <p class="text-red-600">{{ $errors->first('given_name_kana') }}</p>
        @endif
    </td>
</tr>
<tr>
    <td><label class="mr-4" for="gender">性別<span class="text-red-600">*</span></label></td>
    <td>
        <select class="border rounded pl-2 pr-6" name="gender">
            <option value="">選択</option>
            @foreach ($genders as $gender)
                @if ($gender == (old('gender') ?? $st->gender))
                    <option value="{{ $gender }}" selected="selected">{{ $gender }}</option>
                @else
                    <option value="{{ $gender }}">{{ $gender }}</option>
                @endif
            @endforeach
        </select>
        @if ($errors->has('gender'))
            <p class="text-red-600">{{ $errors->first('gender') }}</p>
        @endif
    </td>
</tr>
<tr>
    <td><label class="mr-4" for="grade">学年<span class="text-red-600">*</span></label></td>
    <td>
        <select class="border rounded pl-2 pr-8" name="grade">
            <option value="">選択</option>
            @if (!old('grade') && !$st->grade)
                @foreach ($grades as $grade)
                    <option value="{{ $loop->index }}">{{ $grade }}</option>
                @endforeach
            @else
                @foreach ($grades as $grade)
                    @if ($grade == ($grades[old('grade')] ?? $grades[$st->grade]))
                        <option value="{{ $loop->index }}" selected="selected">{{ $grade }}</option>
                    @else
                        <option value="{{ $loop->index }}">{{ $grade }}</option>
                    @endif
                @endforeach
            @endif
        </select>
        @if ($errors->has('grade'))
            <p class="text-red-600">{{ $errors->first('grade') }}</p>
        @endif
    </td>
</tr>
<tr>
    <td><label class="mr-4" for="email">メールアドレス</label></td>
    <td>
        <input class="border rounded" type="text" name="email" size="40" value="{{ old('email') ?? $st->email }}">
        @if ($errors->has('email'))
            <p class="text-red-600">{{ $errors->first('email') }}</p>
        @endif
    </td>
</tr>
<tr>
    <td><label class="mr-4" for="remarks">備考</label></td>
    <td>
        <textarea class="border rounded" name="remarks" rows="2" cols="50" value="{{ old('remarks') ?? $st->remarks }}"></textarea>
        @if ($errors->has('remarks'))
            <p class="text-red-600">{{ $errors->first('remarks') }}</p>
        @endif
    </td>
</tr>

</tbody>
</table>
