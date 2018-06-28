<div id="user-orders" class="">
    <table id="table-user-orders" class="table table-striped table-responsive table-borderless">
        <colgroup>
            <col style="width: 20%">
            <col style="width: 20%">
            <col style="width: 15%">
            <col style="width: 35%">
            <col style="width: 10%">
        </colgroup>
        <thead>
            <tr>
                <th class="text-left" scope="col">Price</th>
                <th class="text-left" scope="col">Amount</th>
                <th class="text-left" scope="col">Type</th>
                <th class="text-left" scope="col">Date</th>
                <th class="text-right" scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($userOrders as $order)
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
                    <td class="date">
                        <span>{{ $order->created_at }}</span>
                    </td>
                    <td class="text-right">
                        <button type="submit" data-id="{{ $order->id }}" class="btn btn-sm btn-danger cancel-order-button">Delete</button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
