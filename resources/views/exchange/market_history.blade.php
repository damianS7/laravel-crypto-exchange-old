<div id="market-history" class="">
    <table id="table-market-history" class="table table-striped table-responsive table-borderless">
        <colgroup>
            <col style="width: 30%">
            <col style="width: 30%">
            <col style="width: 40%">
        </colgroup>
        <thead>
            <tr>
                <th class="text-left" scope="col">Price</th>
                <th class="text-left" scope="col">Amount</th>
                <th class="text-right" scope="col">Filled</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($market_history as $order)
            <tr data-id="{{ $order->id }}">
                <td class="text-left">
                    <span class="{{ $order->type }}-price price clickable">{{ $order->price }}</span>
                </td>
                <td class="text-left">
                    <span class="amount">{{ $order->amount }}</span>
                </td>
                <td class="text-right">
                    <span class="date">{{ $order->filled_at }}</span>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
