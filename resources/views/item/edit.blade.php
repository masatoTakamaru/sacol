<x-app-layout>
    <x-slot name="header">
        <h2>{{ $st->family_name }}&nbsp;{{ $st->given_name }}:{{ $year }} 年 {{ $month }} 月</h2>
    </x-slot>

    @foreach($errors->all() as $error)
        <p>{{ $error }}</p>
    @endforeach

    <div class="flex justify-end">
        <a class="btn-white py-1 px-6" href="{{ route('item.index', ['year' => $year, 'month' => $month]) }}">戻る</a>
    </div>

    <div class="flex justify-center mt-4">

    <table>

    <thead>
        <tr>
            <th>編集</th>
            <th>コード</th>
            <th>科目名</th>
            <th>価格</th>
            <th>摘要</th>
        </tr>
    </thead>

    <tbody>

    {{-- 従量課金科目 --}}
    <tr>
        <td colspan="6" class="text-blue-600">
            {{ $categories[1] }}
        </td>
    </tr>
    
    @foreach ($items->where('category', 1) as $item)
        <tr>
            @if ($edit_id && $item->id == Hashids::decode($edit_id)[0])
                @include('item.item_edit_form')
            @else
                <td class="pr-2 text-center">
                    <a href="{{ route('item.edit',['student' => Hashids::encode($st->id), 'year' => $year, 'month' => $month, 'edit_id' => Hashids::encode($item->id)]) }}">
                        @include('item.edit_button')
                    </a>
                </td>
                <td class="pr-4 text-right">{{ $item->code }}</td>
                <td class="pr-4">{{ $item->name }}</td>
                <td class="pr-4 text-right">-</td>
                <td class="pr-4">{{ $item->description }}</td>
            @endif
        </tr>
    @endforeach

    {{-- 従量課金型科目の価格 --}}
    <tr class="border-t-2">
        @if ($edit_id && $items->where('category', 0)->first()->id == Hashids::decode($edit_id)[0])
            @include('item.item_edit_form', ['item' => $items->where('category', 0)->first()])
        @else
            <td class="pr-2 text-center">
                <a href="{{ route('item.edit',['student' => Hashids::encode($st->id), 'year' => $year, 'month' => $month, 'edit_id' => Hashids::encode($items->where('category', 0)->first()->id)]) }}">
                    @include('item.edit_button')
                </a>
            </td>
            <td></td>
            <td class="pr-4">{{ $items->where('category', 0)->first()->name }}</td>
            <td class="pr-4 text-right font-bold">
                {{ number_format($items->where('category',0)->first()->price) }}
            </td>
            <td>{{ $items->where('category',0)->first()->description }}</td>
        @endif
    </tr>

    {{-- 単独課金型科目 --}}
    <tr>
        <td colspan="6" class="text-blue-600">
            {{ $categories[2] }}
        </td>
    </tr>
    @foreach ($items->where('category', 2) as $item)
        <tr>
            @if ($edit_id && $item->id == Hashids::decode($edit_id)[0])
                @include('item.item_edit_form')
            @else
                <td class="pr-2 text-center">
                    <a href="{{ route('item.edit',['student' => Hashids::encode($st->id), 'year' => $year, 'month' => $month, 'edit_id' => Hashids::encode($item->id)]) }}">
                        @include('item.edit_button')
                    </a>
                </td>
                <td class="pr-4 text-right">{{ $item->code }}</td>
                <td class="pr-4">{{ $item->name }}</td>
                <td class="pr-4 text-right font-bold">{{ number_format($item->price) }}</td>
                <td class="pr-4">{{ $item->description }}</td>
            @endif
        </tr>
    @endforeach

    {{-- 諸費用 --}}
    <tr>
        <td colspan="6" class="text-blue-600">
            {{ $categories[3] }}
        </td>
    </tr>
    @foreach ($items->where('category', 3) as $item)
        <tr>
            @if ($edit_id && $item->id == Hashids::decode($edit_id)[0])
                @include('item.item_edit_form')
            @else
                <td class="pr-2 text-center">
                    <a href="{{ route('item.edit',['student' => Hashids::encode($st->id), 'year' => $year, 'month' => $month, 'edit_id' => Hashids::encode($item->id)]) }}">
                        @include('item.edit_button')
                    </a>
                </td>
                <td class="pr-4 text-right">{{ $item->code }}</td>
                <td class="pr-4">{{ $item->name }}</td>
                <td class="pr-4 text-right font-bold">{{ number_format($item->price) }}</td>
                <td class="pr-4">{{ $item->description }}</td>
            @endif
        </tr>
    @endforeach

    {{-- 割引 --}}
    <tr>
        <td colspan="6" class="text-blue-600">
            {{ $categories[4] }}
        </td>
    </tr>
    @foreach ($items->where('category', 4) as $item)
        <tr>
            @if ($edit_id && $item->id == Hashids::decode($edit_id)[0])
                @include('item.item_edit_form')
            @else
                <td class="pr-2 text-center">
                    <a href="{{ route('item.edit',['student' => Hashids::encode($st->id), 'year' => $year, 'month' => $month, 'edit_id' => Hashids::encode($item->id)]) }}">
                        @include('item.edit_button')
                    </a>
                </td>
                <td class="pr-4 text-right">{{ $item->code }}</td>
                <td class="pr-4">{{ $item->name }}</td>
                <td class="pr-4 text-right font-bold">{{ number_format($item->price) }}</td>
                <td class="pr-4">{{ $item->description }}</td>
            @endif
        </tr>
    @endforeach

    {{-- 合計 --}}
    <tr class="border-t-2">
        <td></td>
        <td></td>
        <td class="font-bold">請求額</td>
        <td class="font-bold text-green-600">
            {{ number_format(
                $items->where('category', 0)->first()->price
                + $items->where('category', 2)->sum('price')
                + $items->where('category', 3)->sum('price')
                - $items->where('category', 4)->sum('price')
            )}}
        </td>
    </tr>
    
    </tbody>
    </table>
    </div>

    <hr class="my-4">

    {{-- 科目の新規登録 --}}
    <div class="flex justify-start mt-4">
        @include('item.item_create_form')
    </div>

</x-app-layout>