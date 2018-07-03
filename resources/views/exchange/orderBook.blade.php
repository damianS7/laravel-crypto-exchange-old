<div id="order-book" class="">
    <table id="table-order-book" class="table table-striped table-responsive table-borderless">
        <colgroup>
            <col style="width: 33%">
            <col style="width: 33%">
            <col style="width: 33%">
        </colgroup>
        <thead>
            <tr>
                <th class="text-left" scope="col">Price({{ $coin2->symbol }})</th>
                <th class="text-center" scope="col">Amount({{ $coin1->symbol }})</th>
                <th class="text-right" scope="col">Total({{ $coin2->symbol }})</th>
            </tr>
        </thead>
        <tbody id="book_sells" data-key-name="sell" data-total-coins="0">
            @foreach ($order_book['sell'] as $order)
            <tr>
                <td class="text-left" style="position:relative">
                    <div data-amount="{{ $order->amount }}" data-total="{{ $order->total }}" class="bar"></div>
                    <span class="price clickable">{{ $order->price }}</span>
                </td>
                <td class="text-center">
                    <span class="amount clickable">{{ $order->amount }}</span>
                </td>
                <td class="text-right">
                    <span class="total clickable">{{ $order->total }}</span>
                </td>
            </tr>
            @endforeach
        </tbody>
        <tbody id="book_buys" data-key-name="buy" data-total-coins="0">
            @foreach ($order_book['buy'] as $order)
            <tr>
                <td class="text-left" style="position:relative">
                    <div data-amount="{{ $order->amount }}" data-total="{{ $order->total }}" class="bar"></div>
                    <span class="price clickable">{{ $order->price }}</span>
                </td>
                <td class="text-center">
                    <span class="amount clickable">{{ $order->amount }}</span>
                </td>
                <td class="text-right">
                    <span class="total clickable">{{ $order->total }}</span>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
