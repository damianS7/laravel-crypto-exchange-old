<div id="market_menu_tabs" class="tabbable">
  <div class="table-market-header">
    <div class="form-group">

      <div class="form-group row">
        <div class="col-sm-3">
          <small>MARKETS</small>
        </div>
        <div class="col-sm-9 text-right">
          <input id="search_coin" class="form-control form-control-sm" type="text" placeholder="Filter">
        </div>
      </div>
    </div>
  </div>
  <ul class="nav nav-tabs" id="market_menu_tabs" role="tablist">
    @foreach ($markets as $market_symbol => $marketList)
    <li class="nav-item">
      <a class="nav-link" href="#tab-{{ $market_symbol }}" data-toggle="tab">{{ $market_symbol }}</a>
    </li>
    @endforeach
  </ul>
  <div id="markets_menu" class="tab-content ">
    @foreach ($markets as $market_symbol => $marketList)
    <div class="tab-pane" id="tab-{{ $market_symbol }}">
      <table id="table-{{ $market_symbol }}" class="table table-striped table-responsive table-market ">
        <thead>
          <tr>
            <th name="market" class="text-left" scope="col">Market</th>
            <th name="price" class="text-center" scope="col">Price</th>
            <th name="volume" class="text-center" scope="col">Volume(24h)</th>
            <th name="change" class="text-right" scope="col">Change</th>
          </tr>
        </thead>
        <tbody>
          @foreach($marketList as $market) @if (!$market->visible)
          <tr data-id="{{ $market->id }}">
            <td name="market" class="text-left coin-{{ $market->coin_symbol }}">
              <a href="{{ route('trade', $market->coin_symbol . '-'. $market_symbol) }}">{{ $market->coin_symbol }}</a>
            </td>
            <td name="price" class="text-center amount">{{ $market->price }}</td>
            <td name="volume" class="text-center date">{{ $market->volume24h }}</td>
            <td name="change" class="text-right date">+25000%</td>
          </tr>
          @endif @endforeach
        </tbody>
      </table>
    </div>
    @endforeach
  </div>
</div>