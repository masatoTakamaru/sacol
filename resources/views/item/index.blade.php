<x-app-layout>
    <x-slot name="header">
        <h2>{{ $year }} 年 {{ $month }} 月の帳簿（生徒数：{{ $count }} 人）</h2>
    </x-slot>
    
    <div class="flex justify-center">
    <table>
        <thead>
            <tr>
                <th>名前</th>
                <th>学年</th>
                <th>請求額</th>
            </tr>
        </thead>
        <tbody>
            @foreach($family_groups as $fg)
                @if($fg->count() == 1)
                    <tr class="border-b-2">
                        <td class="pr-2"><a class="text-blue-600" href="{{ route('item.edit', ['student' => Hashids::encode($fg->first()['id']), 'year' => $year, 'month' => $month]) }}">{{ $fg->first()['family_name'] }}&nbsp;{{ $fg->first()['given_name'] }}</a></td>
                        <td class="pr-2">{{ $grades[$fg->first()['grade']] }}</td>
                        <td class="pr-2 text-right font-bold text-green-600">{{ number_format($fg->first()['fee']) }}</td>
                    </tr>
                @else
                    @foreach($fg as $st)
                        <tr>
                            <td class="pr-2"><a class="text-blue-600" href="{{ route('item.edit', ['student' => Hashids::encode($st['id']), 'year' => $year, 'month' => $month]) }}">{{ $st['family_name'] }}&nbsp;{{ $st['given_name'] }}</a></td>
                            <td class="pr-2">{{ $grades[$st['grade']] }}</td>
                            <td class="pr-2 text-right text-gray-500">{{ number_format($st['fee']) }}</td>
                        </tr>
                    @endforeach
                    <tr class="border-b-2">
                        <td></td>
                        <td class="text-center">計</td>
                        <td class="pr-2 text-right font-bold text-green-600">{{ number_format($fg->sum('fee')) }}</td>
                    </tr>
                @endif
            @endforeach
            <tr>
                <td></td>
                <td>合計</td>
                <td class="pr-2 text-right font-bold">{{ number_format($total) }}</td>
            </tr>
        </tbody>
    </table>

    </div>

</x-app-layout>