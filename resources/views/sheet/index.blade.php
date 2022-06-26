<x-app-layout>
    <x-slot name="header">
        <h2>帳簿の登録：{{ $year }} 年 {{ $month }} 月（生徒数：{{ $count }} 人）
        </h2>
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
                @foreach($fg as $st)
                    <tr>
                        <td class="pr-2">{{ $st['family_name'] }}&nbsp;{{ $st['given_name'] }}</td>
                        <td class="pr-2">{{ $grades[$st['grade']] }}</td>
                        <td class="pr-2 text-right text-gray-500">{{ number_format($st['fee']) }}</td>
                    </tr>
                @endforeach
                <tr>
                    <td></td>
                    <td class="text-center">計</td>
                    <td class="pr-2 text-right font-bold text-green-600">{{ number_format($fg->sum('fee')) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    </div>
    <input class="rounded mr-1" type="number" min="1" max="9999"></input><button class="btn-search shadow py-1 px-2 text-xs">検索</button>
    <button class="btn py-1 px-2 text-xs">登録</button>

</x-app-layout>