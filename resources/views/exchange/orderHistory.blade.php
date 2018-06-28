<table class="table table-borderless" style="margin:0">
    <colgroup>
        <col style="width: 30%">
        <col style="width: 30%">
        <col style="width: 40%">
    </colgroup>
    <tbody>
        <tr>
            <th class="text-left" scope="col">Price</th>
            <th class="text-left" scope="col">Amount</th>
            <th class="text-right" scope="col">Filled</th>
        </tr>
    </tbody>
</table>
<div id="trade-history" class="table-responsive">
    <table id="table-trade-history" class="table table-borderless">
        <colgroup>
            <col style="width: 30%">
            <col style="width: 30%">
            <col style="width: 40%">
        </colgroup>
        <tbody>
            @foreach ($marketHistory as $order)
            <tr data-id="{{ $order->id }}">
                <td class="text-left {{ $order->type }}-price">{{ $order->price }}</td>
                <td class="text-left amount">{{ $order->amount }}</td>
                <td class="text-right date">{{ $order->filled_at }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
