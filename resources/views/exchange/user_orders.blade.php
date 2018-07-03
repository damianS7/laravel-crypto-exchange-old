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
                <th name="price" class="text-left" scope="col">Price</th>
                <th name="amount" class="text-left" scope="col">Amount</th>
                <th name="type" class="text-left" scope="col">Type</th>
                <th name="date" class="text-left" scope="col">Date</th>
                <th name="button" class="text-right" scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($user_orders as $order)
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
                    <td name="date">
                        <span class="date">{{ $order->created_at }}</span>
                    </td>
                    <td name="button" class="text-right">
                        <button type="submit" data-id="{{ $order->id }}" class="btn btn-sm btn-danger cancel-order-button">Cancel</button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
