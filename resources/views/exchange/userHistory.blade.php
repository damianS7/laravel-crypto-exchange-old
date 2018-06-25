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
			<th class="text-left" scope="col">Pair</th>
            <th class="text-left" scope="col">Price</th>
            <th class="text-left" scope="col">Amount</th>
			<th class="text-left" scope="col">Type</th>
            <th class="text-left" scope="col">Date</th>
        </tr>
    </thead>
        <tbody>
            @foreach ($userHistory as $order)
                <tr>
					<td>
                        <span>{{ $order->pair }}</span>
                    </td>
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
						<span>{{ $order->date }}</span>
					</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
