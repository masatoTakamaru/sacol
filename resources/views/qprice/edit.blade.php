<x-app-layout>
    <x-slot name="header">
        <h2>従量課金型科目の設定</h2>
    </x-slot>

    <div class="flex items-center mb-6">
        <p class="mr-4">学年を選択</p>
        <select class="border rounded pl-2 pr-8 py-2" id="grade" name="grade">
            @foreach ($grades as $grade_name)
                @if ($loop->index == $grade)
                    <option value="{{ $loop->index }}" selected="selected">{{ $grade_name }}</option>
                @else
                    <option value="{{ $loop->index }}">{{ $grade_name }}</option>
                @endif
            @endforeach
        </select>
    </div>

    <div class="flex justify-center">

    <form action="{{ route('qprice.update', ['grade' => $grade]) }}" method="POST">
        @method('PUT')
        @csrf

        <div class="flex justify-center">
            <table>
            <tbody>
                <tr>
                    <th>1科目</th>
                    <th>2科目</th>
                    <th>3科目</th>
                    <th>4科目</th>
                </tr>
                <tr>
                    <td><input class="rounded" type="number" name="price[1]" min="0" max="999999" value="{{ old('p1') ?? $qprices->where('qprice', 1)->first()->price }}"></input></td>
                    <td><input class="rounded" type="number" name="price[2]" min="0" max="999999" value="{{ old('p2') ?? $qprices->where('qprice', 2)->first()->price }}"></input></td>
                    <td><input class="rounded" type="number" name="price[3]" min="0" max="999999" value="{{ old('p3') ?? $qprices->where('qprice', 3)->first()->price }}"></input></td>
                    <td><input class="rounded" type="number" name="price[4]" min="0" max="999999" value="{{ old('p4') ?? $qprices->where('qprice', 4)->first()->price }}"></input></td>
                </tr>
                <tr>
                    <th>5科目</th>
                    <th>6科目</th>
                    <th>7科目</th>
                    <th>8科目</th>
                </tr>
                <tr>
                    <td><input class="rounded" type="number" name="price[5]" min="0" max="999999" value="{{ old('p5') ?? $qprices->where('qprice', 5)->first()->price }}"></input></td>
                    <td><input class="rounded" type="number" name="price[6]" min="0" max="999999" value="{{ old('p6') ?? $qprices->where('qprice', 6)->first()->price }}"></input></td>
                    <td><input class="rounded" type="number" name="price[7]" min="0" max="999999" value="{{ old('p7') ?? $qprices->where('qprice', 7)->first()->price }}"></input></td>
                    <td><input class="rounded" type="number" name="price[8]" min="0" max="999999" value="{{ old('p8') ?? $qprices->where('qprice', 8)->first()->price }}"></input></td>
                </tr>
                <tr>
                    <th>9科目</th>
                    <th>10科目</th>
                    <th>11科目</th>
                    <th>12科目</th>
                </tr>
                <tr>
                    <td><input class="rounded" type="number" name="price[9]" min="0" max="999999" value="{{ old('p9') ?? $qprices->where('qprice', 9)->first()->price }}"></input></td>
                    <td><input class="rounded" type="number" name="price[10]" min="0" max="999999" value="{{ old('p10') ?? $qprices->where('qprice', 10)->first()->price }}"></input></td>
                    <td><input class="rounded" type="number" name="price[11]" min="0" max="999999" value="{{ old('p11') ?? $qprices->where('qprice', 11)->first()->price }}"></input></td>
                    <td><input class="rounded" type="number" name="price[12]" min="0" max="999999" value="{{ old('p12') ?? $qprices->where('qprice', 12)->first()->price }}"></input></td>
                </tr>
            </tbody>
            </table>
        </div>

        <div class="flex justify-center mt-6">
            <button class="btn px-8 py-2 mr-6"><input type="submit" value="更新する"></button>
            <a class="btn-white px-6 py-2" href="{{ route('item_master.index') }}">キャンセル</a>
        </div>
    </form>

    </div>
</x-app-layout>

<script>
    let elem = document.querySelector('#grade');
    elem.addEventListener('change', () => {
        window.location.href = "../qprice/" + elem.value;
    });
</script>