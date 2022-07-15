<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2>{{ $sheet->year }} 年 {{ $sheet->month }} 月の帳票（生徒数：{{ $count }} 人）</h2>
            <a class="text-blue-500" href="{{ route('dashboard') }}">ダッシュボードに戻る</a>
        </div>
    </x-slot>
    
    <div class="flex justify-center">
    <table>
        <thead>
            <tr>
                <th class="px-12">名前</th>
                <th class="px-12">学年</th>
                <th class="px-12">請求額</th>
            </tr>
        </thead>
        <tbody>
            {{-- 家族グループごとに表示する --}}
            @foreach($family_groups as $fg)
                {{-- グループが１名の場合 --}}
                @if($fg->count() == 1)
                    <tr class="border-b-2">
                        <td class="pr-2"><a class="text-blue-600" href="{{ route('item.edit', ['student' => Hashids::encode($fg->first()['id']), 'sheet' => Hashids::encode($sheet->id)]) }}">{{ $fg->first()['family_name'] }}&nbsp;{{ $fg->first()['given_name'] }}</a></td>
                        <td class="pr-2">{{ $grades[$fg->first()['grade']] }}</td>
                        <td class="pr-2 text-right font-bold text-green-600">{{ number_format($fg->first()['fee']) }}</td>
                    </tr>
                @else
                    {{-- グループが２名以上の場合 --}}
                    @foreach($fg as $st)
                        <tr>
                            <td class="pr-2"><a class="text-blue-600" href="{{ route('item.edit', ['student' => Hashids::encode($st['id']), 'sheet' => Hashids::encode($sheet->id)]) }}">{{ $st['family_name'] }}&nbsp;{{ $st['given_name'] }}</a></td>
                            <td class="pr-2">{{ $grades[$st['grade']] }}</td>
                            <td class="pr-2 text-right text-gray-500">{{ number_format($st['fee']) }}</td>
                        </tr>
                    @endforeach
                    {{-- グループごとの計 --}}
                    <tr class="border-b-2">
                        <td></td>
                        <td class="text-center">計</td>
                        <td class="pr-2 text-right font-bold text-green-600">{{ number_format($fg->sum('fee')) }}</td>
                    </tr>
                @endif
            @endforeach
            {{-- 全体の合計 --}}
            <tr>
                <td></td>
                <td>合計</td>
                <td class="pr-2 text-right font-bold">{{ number_format($total) }}</td>
            </tr>
        </tbody>
    </table>

    </div>

</x-app-layout>