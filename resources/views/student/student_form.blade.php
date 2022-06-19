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
    <td><label class="mr-4" for="birth_date">生年月日</label></td>
    <td>
        <input class="border rounded" type="date" name="birth_date" value="{{ old('birth_date') ?? $st->birth_date }}">
        @if ($errors->has('birth_date'))
            <p class="text-red-600">{{ $errors->first('birth_date') }}</p>
        @endif
    </td>
</tr>
<tr>
    <td><label class="mr-4" for="school_attended">学校名</label></td>
    <td>
        <input class="border rounded" type="text" name="school_attended" size="40" value="{{ old('school_attended') ?? $st->school_attended }}">
        @if ($errors->has('school_attended'))
            <p class="text-red-600">{{ $errors->first('school_attended') }}</p>
        @endif
    </td>
</tr>
<tr>
    <td><label class="mr-4" for="guardian_family_name">保護者姓・名</label></td>
    <td>
        <input class="border rounded" type="text" name="guardian_family_name" value="{{ old('guardian_family_name') ?? $st->guardian_family_name }}">
        <input class="border rounded" type="text" name="guardian_given_name" value="{{ old('guardian_given_name') ?? $st->guardian_given_name }}">
        @if ($errors->has('guardian_family_name'))
            <p class="text-red-600">{{ $errors->first('guardian_family_name') }}</p>
        @endif
        @if ($errors->has('guardian_given_name'))
            <p class="text-red-600">{{ $errors->first('guardian_given_name') }}</p>
        @endif
    </td>
</tr>
<tr>
    <td><label class="mr-4" for="guardian_family_name_kana">保護者フリガナ</label></td>
    <td>
        <input class="border rounded" type="text" name="guardian_family_name_kana" value="{{ old('guardian_family_name_kana') ?? $st->guardian_family_name_kana }}">
        <input class="border rounded" type="text" name="guardian_given_name_kana" value="{{ old('guardian_given_name_kana') ?? $st->guardian_given_name_kana }}">
        @if ($errors->has('guardian_family_name_kana'))
            <p class="text-red-600">{{ $errors->first('guardian_family_name_kana') }}</p>
        @endif
        @if ($errors->has('guardian_given_name_kana'))
            <p class="text-red-600">{{ $errors->first('guardian_given_name_kana') }}</p>
        @endif
    </td>
</tr>
<tr>
    <td><label class="mr-4" for="phone1">電話番号１</label></td>
    <td>
        <input class="border rounded" type="text" name="phone1" value="{{ old('phone1') ?? $st->phone1 }}">
        @if ($errors->has('phone1'))
            <p class="text-red-600">{{ $errors->first('phone1') }}</p>
        @endif
    </td>
</tr>
<tr>
    <td><label class="mr-4" for="phone1_relationship">続柄</label></td>
    <td>
        <input class="border rounded" type="text" name="phone1_relationship" value="{{ old('phone1_relationship') ?? $st->phone1_relationship }}">
        @if ($errors->has('phone1_relationship'))
            <p class="text-red-600">{{ $errors->first('phone1_relationship') }}</p>
        @endif
    </td>
</tr>
<tr>
    <td><label class="mr-4" for="phone2">電話番号２</label></td>
    <td>
        <input class="border rounded" type="text" name="phone2" value="{{ old('phone2') ?? $st->phone2 }}">
        @if ($errors->has('phone2'))
            <p class="text-red-600">{{ $errors->first('phone2') }}</p>
        @endif
    </td>
</tr>
<tr>
    <td><label class="mr-4" for="phone2_relationship">続柄</label></td>
    <td>
        <input class="border rounded" type="text" name="phone2_relationship" value="{{ old('phone2_relationship') ?? $st->phone2_relationship }}">
        @if ($errors->has('phone2_relationship'))
            <p class="text-red-600">{{ $errors->first('phone2_relationship') }}</p>
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
