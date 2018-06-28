<div id="order-book" class="">
    <table id="table-order-book" class="table table-striped table-responsive table-borderless">
        <colgroup>
            <col style="width: 33%">
            <col style="width: 33%">
            <col style="width: 33%">
        </colgroup>
        <thead>
            <tr>
                <th class="text-left" scope="col">Price</th>
                <th class="text-left" scope="col">Amount</th>
                <th class="text-right" scope="col">Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($sellOrders as $order)
            <tr class="selltext">
                <td class="text-left">
                    <span class="clickable" onClick="setPriceOrder('orderprice')">{{ $order->price }}</span>
                </td>
                <td class="text-center">
                    <span class="clickable" onClick="setAmountOrder('{{ $order->price }}')">{{ $order->amount }}</span>
                </td>
                <td class="text-right">
                    {{ $order->total }}
                </td>
            </tr>
            @endforeach
        </tbody>
        <tbody>
            @foreach ($buyOrders as $order)
            <tr class="buytext">
                <td class="text-left">
                    <span class="clickable" onClick="setPriceOrder('orderprice')">{{ $order->price }}</span>
                </td>
                <td class="text-center">
                    <span class="clickable" onClick="setAmountOrder('{{ $order->price }}')">{{ $order->amount }}</span>
                </td>
                <td class="text-right">{{ $order->total }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
