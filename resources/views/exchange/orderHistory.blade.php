<table class="table table-borderless" style="margin:0">
    <colgroup>
        <col style="width: 30%">
        <col style="width: 30%">
        <col style="width: 40%">
    </colgroup>
    <tbody>
        <tr>
            <th class="text-left" scope="col">Price</th>
            <th class="text-center" scope="col">Amount</th>
            <th class="text-right" scope="col">Date</th>
        </tr>
    </tbody>
</table>
<div id="" class="table-responsive">
	<table class="table table-borderless">
		<tbody>
			<?php foreach ($marketHistory as $order): ?>
				<?php for ($i=0; $i < 50; $i++): ?>
                    <?php if($order['type'] == "buy"): ?>
                        <tr>
                            <td class="text-left" style="color:#8ec919"><?php echo $order['price']; ?></td>
                            <td class="text-center" style="color:#cdcdcd"><?php echo $order['amount']; ?></td>
                            <td class="text-right" style="color:#595d61"><?php echo $order['date']; ?></td>
                        </tr>
                    <?php else: ?>
                        <tr>
                            <td class="text-left" style="color:#ff007a"><?php echo $order['price']; ?></td>
                            <td class="text-center" style="color:#cdcdcd"><?php echo $order['amount']; ?></td>
                            <td class="text-right" style="color:#595d61"><?php echo $order['date']; ?></td>
                        </tr>
                    <?php endif; ?>
				<?php endfor; ?>
			<?php endforeach; ?>
		</tbody>
	</table>
</div>
