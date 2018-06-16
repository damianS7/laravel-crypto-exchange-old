
<div class="col-sm-6">
	<div class="form-group">
    <label class="control-label">
		<?php echo "Buy: " . $pair[1] . " Your Balance: " . $_SESSION['balances'][$pair[1]] . " " . $pair[1]; ?>
	</label>
		<div class="form-group row">
			<label for="staticPrice" class="col-sm-2 col-form-label">Price</label>

			<div class="col-sm-10 input-group mb-3">
				<input class="form-control" name="input-buy-price" aria-label="Amount (to the nearest dollar)" type="text">

				<div class="input-group-append">
					<span class="input-group-text">USDT</span>
				</div>
			</div>
		</div>

		<div class="form-group row">
			<label for="staticEmail" class="col-sm-2 col-form-label">Amount</label>
			<div class="col-sm-10 input-group mb-3">
				<input class="form-control" name="input-buy-amount" aria-label="Amount (to the nearest dollar)" type="text">
				<div class="input-group-append">
					<span class="input-group-text">BTC</span>
				</div>
			</div>
		</div>

		<div class="form-group row">
			<label for="staticEmail" class="col-sm-2 col-form-label">Total</label>
			<div class="col-sm-10 input-group mb-3">
				<span name="total-buy" class="">-</span> <?php echo $pair[1]; ?>
			</div>
		</div>
	</div>
	<button type="submit" onClick="setOrder('buy')" class="btn btn-success btn-block">BUY</button>
</div>

<div class="col-sm-6">
	<div class="form-group">
		<label class="control-label">
			<?php echo "Buy: " . $pair[0] . " Your Balance: " . $_SESSION['balances'][$pair[0]] . " " . $pair[0]; ?>
		</label>
		<div class="form-group row">
			<label for="staticEmail" class="col-sm-2 col-form-label">Price</label>
			<div class="col-sm-10 input-group mb-3">
				<input class="form-control" name="input-sell-price" aria-label="Amount (to the nearest dollar)" type="text">
				<div class="input-group-append">
					<span class="input-group-text">USDT</span>
				</div>
			</div>
		</div>
		<div class="form-group row">
			<label for="staticEmail" class="col-sm-2 col-form-label">Amount</label>
			<div class="col-sm-10 input-group mb-3">
				<input class="form-control" name="input-sell-amount" aria-label="Amount (to the nearest dollar)" type="text">
				<div class="input-group-append">
					<span class="input-group-text">BTC</span>
				</div>
			</div>
		</div>

		<div class="form-group row">
			<label for="staticEmail" class="col-sm-2 col-form-label">Total</label>
			<div class="col-sm-10 input-group mb-3">
				<span name="total-sell" class="">-</span> <?php echo $pair[1]; ?>
			</div>
		</div>
	</div>
	<button type="submit" onClick="setOrder('sell')" class="btn btn-danger btn-block">SELL</button>
</div>
