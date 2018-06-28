<table class="table table-borderless">
    <colgroup>
        <col style="width: 33%">
        <col style="width: 33%">
        <col style="width: 33%">
    </colgroup>
    <tbody>
        <tr>
            <th class="text-left" scope="col">Price</th>
            <th class="text-center" scope="col">Amount</th>
            <th class="text-right" scope="col">Total</th>
        </tr>
    </tbody>
</table>

<div id="order-book-sells" class="table-responsive">
    <table id="table-book-sells" class="table table-borderless table-striped">
        <colgroup>
            <col style="width: 33%">
            <col style="width: 33%">
            <col style="width: 33%">
        </colgroup>
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
    </table>
</div>

<div id="order-book-buys" class="table-responsive">
    <table id="table-book-buys" class="table table-borderless table-striped">
        <colgroup>
            <col style="width: 33%">
            <col style="width: 33%">
            <col style="width: 33%">
        </colgroup>
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
