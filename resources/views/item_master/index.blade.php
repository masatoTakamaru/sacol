<x-app-layout>
    <x-slot name="header">
        <h2>科目の一覧</h2>
    </x-slot>
 
    <div class="flex justify-end">
        <a class="text-blue-500 py-4 mr-6" href="{{ route('item_master.create') }}">科目の新規登録</a>
    </div>
    <div class="flex justify-center">
    <table>
    <thead>
    <tr>
        <th>コード</th>
        <th>科目名</th>
        <th>価格</th>
        <th>摘要</th>
    </tr>
    </thead>
    <tbody>
    <tr>
        <td colspan="4">
            <div class="flex">
                <p class="mr-3">{{ $categories[0] }}({{ $subject_qtys->count() }})</p>
            </div>
        </td>
    </tr>
    @foreach($subject_qtys as $e)
        <tr>
            <td class="pr-2">{{ $e->code }}</td>
            <td class="pr-2"><a class="text-blue-500 underline" href="{{ route('item_master.show', ['item_master' => Hashids::encode($e->id)]) }}">{{ $e->name }}</a></td>
            <td class="text-center">-</td>
            <td class="pr-2">{{ $e->description }}</td>
        </tr>
    @endforeach
    <tr>
        <td colspan="4">
            <div class="flex">
                <p class="mr-3">{{ $categories[1] }}({{ $subject_singles->count() }})</p>
            </div>
        </td>
    </tr>
    @foreach($subject_singles as $e)
        <tr>
            <td class="pr-2">{{ $e->code }}</td>
            <td class="pr-2"><a class="text-blue-500 underline" href="{{ route('item_master.show', ['item_master' => Hashids::encode($e->id)]) }}">{{ $e->name }}</a></td>
            <td class="pr-2 text-end">{{ number_format($e->price) }}</td>
            <td class="pr-2">{{ $e->description }}</td>
        </tr>
    @endforeach
    <tr>
        <td colspan="4">
            <div class="flex">
                <p class="mr-3">{{ $categories[2] }}({{ $charges->count() }})</p>
            </div>
        </td>
    </tr>
    @foreach($charges as $e)
        <tr>
            <td class="pr-2">{{ $e->code }}</td>
            <td class="pr-2"><a class="text-blue-500 underline" href="{{ route('item_master.show', ['item_master' => Hashids::encode($e->id)]) }}">{{ $e->name }}</a></td>
            <td class="pr-2 text-end">{{ number_format($e->price) }}</td>
            <td class="pr-2">{{ $e->description }}</td>
        </tr>
    @endforeach
    <tr>
        <td colspan="4">
            <div class="flex">
                <p class="mr-3">{{ $categories[3] }}({{ $discounts->count() }})</p>
            </div>
        </td>
    </tr>
    @foreach($discounts as $e)
        <tr>
            <td class="pr-2">{{ $e->code }}</td>
            <td class="pr-2"><a class="text-blue-500 underline" href="{{ route('item_master.show', ['item_master' => Hashids::encode($e->id)]) }}">{{ $e->name }}</a></td>
            <td class="pr-2 text-end">{{ number_format($e->price) }}</td>
            <td class="pr-2">{{ $e->description }}</td>
        </tr>
    @endforeach
    </tbody>
    </table>
    </div>
</x-app-layout>