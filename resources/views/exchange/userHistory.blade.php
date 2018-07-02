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
                <th name="price" scope="col">Price</th>
                <th name="amount" scope="col">Amount</th>
                <th name="type" scope="col">Type</th>
                <th name="date" class="text-right" scope="col">Filled at</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($user_history as $order)
            <tr data-id="{{ $order->id }}">
                <td name="price">
                    <span class="{{ $order->type }}-price">{{ $order->price }}</span>
                </td>
                <td name="amount">
                    <span class="amount">{{ $order->amount }}</span>
                </td>
                <td name="type">
                    <span class="{{ $order->type }}-price">{{ $order->type }}</span>
                </td>
                <td name="date" class="text-right">
                    <span class="date">{{ $order->filled_at }}</span>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
