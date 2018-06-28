<div class="row">

<div class="col-sm-6">
	<div class="form-group">
    <label class="control-label">
		<?php //echo "Buy: " . $pair[1] . " Your Balance: " . $_SESSION['balances'][$pair[1]] . " " . $pair[1]; ?>
	</label>
		<div class="form-group row">
				<label for="" class="col-sm-12 col-form-label">
				@if(Auth::check())
				<small>Balance:{{ $balance[$coin1->symbol] }} {{ $coin1->symbol }}</small>
				@endif
				</label>
			</div>
		<div class="form-group row">
			<label for="staticPrice" class="col-sm-2 col-form-label">Price</label>
			<div class="col-sm-10 input-group mb-3">
				<input class="form-control" id="input-buy-price" type="text" value="0.0005">

				<div class="input-group-append">
					<span class="input-group-text">USDT</span>
				</div>
			</div>
		</div>

		<div class="form-group row">
			<label for="staticEmail" class="col-sm-2 col-form-label">Amount</label>
			<div class="col-sm-10 input-group mb-3">
				<input class="form-control" id="input-buy-amount" type="text" value="0.0005">
				<div class="input-group-append">
					<span class="input-group-text">BTC</span>
				</div>
			</div>
		</div>

		<div class="form-group row">
			<label for="staticEmail" class="col-sm-2 col-form-label">Total</label>
			<div class="col-sm-10 input-group mb-3">
				<span name="total-buy" class="">-</span> <?php //echo $pair[1]; ?>
			</div>
		</div>
	</div>
	<button type="submit" id="btn-buy" data-type="buy" data-pair="{{ $pair->id }}" class="btn btn-success btn-block">BUY</button>
	<p>Setting buyfee {{ @$settings['buy_fee']->value }}</p>
</div>

<div class="col-sm-6">
	<div class="form-group">
		<label class="control-label">
			<?php //echo "Buy: " . $pair[0] . " Your Balance: " . $_SESSION['balances'][$pair[0]] . " " . $pair[0]; ?>
		</label>
		<div class="form-group row">
			<label for="" class="col-sm-12 col-form-label">
				@if(Auth::check())
				<small>Balance:{{ $balance[$coin2->symbol] }} {{ $coin2->symbol }}</small>
				@endif
			</label>
		</div>
		<div class="form-group row">
			<label for="staticEmail" class="col-sm-2 col-form-label">Price</label>
			<div class="col-sm-10 input-group mb-3">
				<input class="form-control" id="input-sell-price" value="0.0005" type="text">
				<div class="input-group-append">
					<span class="input-group-text">USDT</span>
				</div>
			</div>
		</div>
		<div class="form-group row">
			<label for="staticEmail" class="col-sm-2 col-form-label">Amount</label>
			<div class="col-sm-10 input-group mb-3">
				<input class="form-control" id="input-sell-amount" value="0.0005" type="text">
				<div class="input-group-append">
					<span class="input-group-text">BTC</span>
				</div>
			</div>
		</div>

		<div class="form-group row">
			<label for="staticEmail" class="col-sm-2 col-form-label">Total</label>
			<div class="col-sm-10 input-group mb-3">
				<span name="total-sell" class="">-</span> <?php //echo $pair[1]; ?>
			</div>
		</div>
	</div>
	<button type="submit" id="btn-sell" data-type="sell" data-pair="{{ $pair->id }}" class="btn btn-danger btn-block">SELL</button>
</div>
</div>
