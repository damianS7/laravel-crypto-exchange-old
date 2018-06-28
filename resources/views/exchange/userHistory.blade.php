<div id="user-history" class="">
    <table id="table-user-history" class="table table-striped table-responsive table-borderless">
        <colgroup>
            <col style="width: 30%">
            <col style="width: 30%">
            <col style="width: 10%">
            <col style="width: 30%">
        </colgroup>
        <thead>
            <tr>
                <th class="text-left" scope="col">Price</th>
                <th class="text-left" scope="col">Amount</th>
                <th class="text-left" scope="col">Type</th>
                <th class="text-right" scope="col">Filled at</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($userHistory as $order)
            <tr data-id="{{ $order->id }}">
                <td class="{{ $order->type }}-price">
                    <span>{{ $order->price }}</span>
                </td>
                <td class="amount">
                    <span>{{ $order->amount }}</span>
                </td>
                <td class="{{ $order->type }}-price">
                    <span>{{ $order->type }}</span>
                </td>
                <td class="text-right date">
                    <span>{{ $order->filled_at }}</span>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
