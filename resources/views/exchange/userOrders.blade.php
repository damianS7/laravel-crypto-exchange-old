<div id="user-orders" class="table-responsive">
    <table id="" class="table table-borderless table-striped">
	<colgroup>
        <col style="width: 20%">
        <col style="width: 20%">
        <col style="width: 20%">
		<col style="width: 20%">
		<col style="width: 20%">
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
                <tr>
                    <td>
                        <span>{{ $order->price }}</span>
                    </td>
                    <td>
                        <span>{{ $order->amount }}</span>
                    </td>
                    <td>
						<span>{{ $order->type }}</span>
					</td>
					<td>
						<span>{{ $order->created_at }}</span>
					</td>
					<td>
						<form action="" method="post">
							<input type="hidden" name="_method" value="delete">
							{{ csrf_field() }}
							<button type="submit" name="submit" value="delete" class="btn btn-sm btn-danger float-right confirm">Delete</button>
						</form>
					</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
