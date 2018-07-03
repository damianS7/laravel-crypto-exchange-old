<div class="row">
  <div class="col-sm-6">
    <div class="form-group">

      <div class="form-group row">
        <div class="col-sm-6">
          <small>Buy {{ $coin1->symbol }}</small>
        </div>
        <div class="col-sm-6 text-right">
          <small>
            @if(Auth::check())
            <span id="buy-balance" class="balance clickable">{{ $balance[$coin2->symbol] }}</span> {{ $coin2->symbol}} @else
            <span>-</span> {{ $coin2->symbol}} @endif
          </small>
        </div>
      </div>

      <div class="form-group row">
        <label for="" class="col-sm-3 col-form-label">Price</label>
        <div class="col-sm-9 input-group mb-3">
          <input class="form-control" id="input-buy-price" type="text" value="">
          <div class="input-group-append">
            <span class="input-group-text">{{ $coin2->symbol }}</span>
          </div>
        </div>
      </div>

      <div class="form-group row">
        <label for="" class="col-sm-3 col-form-label">Amount</label>
        <div class="col-sm-9 input-group mb-3">
          <input class="form-control" id="input-buy-amount" type="text" value="">
          <div class="input-group-append">
            <span class="input-group-text">{{ $coin1->symbol }}</span>
          </div>
        </div>
      </div>

      <div class="form-group row">
        <div class="col-sm-3">
          <span class="">Total</span>
        </div>
        <div class="col-sm-9 text-right">
          <span id="total-buy" class="">-</span> {{ $coin2->symbol }}
        </div>
      </div>
    </div>
    <button type="submit" id="btn-buy" data-type="buy" data-market="{{ $market->id }}" class="btn btn-success btn-block">BUY</button>
    <p>Setting buyfee {{ @$settings['buy_fee']->value }}</p>
  </div>

  <div class="col-sm-6">
    <div class="form-group">

      <div class="form-group row">
        <div class="col-sm-6">
          <small>Sell {{ $coin1->symbol }}</small>
        </div>
        <div class="col-sm-6 text-right">
          <small>
            @if(Auth::check())
            <span id="sell-balance" class="balance clickable">{{ $balance[$coin1->symbol] }}</span> {{ $coin1->symbol}} @else
            <span>-</span> {{ $coin1->symbol}} @endif
          </small>
        </div>
      </div>

      <div class="form-group row">
        <label for="" class="col-sm-3 col-form-label">Price</label>
        <div class="col-sm-9 input-group mb-3">
          <input class="form-control" id="input-sell-price" type="text" value="">
          <div class="input-group-append">
            <span class="input-group-text">{{ $coin2->symbol }}</span>
          </div>
        </div>
      </div>

      <div class="form-group row">
        <label for="" class="col-sm-3 col-form-label">Amount</label>
        <div class="col-sm-9 input-group mb-3">
          <input class="form-control" id="input-sell-amount" type="text" value="">
          <div class="input-group-append">
            <span class="input-group-text">{{ $coin1->symbol }}</span>
          </div>
        </div>
      </div>

      <div class="form-group row">
        <div class="col-sm-3">
          <span class="">Total</span>
        </div>
        <div class="col-sm-9 text-right">
          <span id="total-sell" class="">-</span> {{ $coin2->symbol }}
        </div>
      </div>
    </div>
    <button type="submit" id="btn-sell" data-type="sell" data-market="{{ $market->id }}" class="btn btn-danger btn-block">SELL</button>
    <p>Setting sellee {{ @$settings['sell_fee']->value }}</p>
  </div>
</div>