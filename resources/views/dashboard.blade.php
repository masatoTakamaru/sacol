<x-app-layout>
    <x-slot name="header">
        <h2>{{ __('Dashboard') }}</h2>
    </x-slot>

    @if ($sheets->count())
        <div class="flex justify-end mb-4">
            <form action="{{ route('sheet.store') }}" method="POST">
                @csrf

                {{-- バリデーションを突破するためにダミーのリクエストを送る --}}
                <input type="hidden" name="year" value="{{ $sheets->first()->year }}"></input>
                <input type="hidden" name="month" value="{{ $sheets->first()->month }}"></input>

                <button class="btn mr-4 py-2 px-6 text-sm"><input type="submit" value="帳票の新規作成" disabled></input></button>
            </form>
        </div>
        <div><p class="text-green-500">サンプルのため帳票の新規作成および削除はできません。</p></div>
        <div class="flex justify-center">
            <table>
                <thead>
                    <tr>
                        <th>年月</th>
                        <th>生徒数</th>
                        <th>請求額</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($sheets as $sheet)
                        <tr>
                            <td class="px-8">
                                <a class="font-bold text-blue-600" href="{{ route('item.index', ['sheet'=>Hashids::encode($sheet->id)]) }}">{{ $sheet->year }} 年 {{ $sheet->month }} 月</a>
                            </td>
                            <td class="px-8">{{ $sheet->enrollment }} 人</td>
                            <td class="px-8 text-right">{{ number_format($sheet->sales) }}</td>
                            @if ($loop->index == 0)
                                <td class="px-8">
                                    <form action="{{ route('sheet.destroy', ['sheet' => $sheet->id]) }}" method="POST">
                                        @csrf
                                        @method('DELETE')

                                        <button class="btn-white mr-4 py-1 px-6 text-sm"><input type="submit" value="削除" disabled></input></button>
                                    </form>
                                </td>
                            @endif
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div>
            <p class="mb-8">帳票がありません。最初の帳票を作成してください。</p>
            <form action="{{ route('sheet.store') }}" method="POST">
                @csrf

                <div class="flex justify-center items-center">
                    <input class="border rounded" type="number" name="year" min="1980" max="2099" size="8" value="{{ old('year') }}">
                    <p class="mx-4">年</p>
                    <input class="border rounded" type="number" name="month" min="1" max="12" size="4" value="{{ old('month') }}">
                    <p class="mx-4">月</p>

                    <button class="btn px-8 py-2"><input type="submit" value="作成する"></button>
                </div>
                @if ($errors)
                    <p class="text-red-600">{{ $errors->first() }}</p>
                @endif
            </form>
        </div>
    @endif
</x-app-layout>
