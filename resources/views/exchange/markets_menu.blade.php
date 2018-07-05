<div id="market_menu_tabs" class="tabbable">
  <ul class="nav nav-tabs" id="market_menu_tabs" role="tablist">
    @foreach ($markets as $market_symbol => $marketList)
    <li class="nav-item">
      <a class="nav-link" href="#tab-{{ $market_symbol }}" data-toggle="tab">{{ $market_symbol }}</a>
    </li>
    @endforeach
    <li class="nav-item">
      <input id="search_coin" class=" form-control form-control-sm " type="text" placeholder="Search">
    </li>
  </ul>
  <div id="markets_menu" class="tab-content ">
    @foreach ($markets as $market_symbol => $marketList)
    <div class="tab-pane" id="tab-{{ $market_symbol }}">
      <table id="table-{{ $market_symbol }}" class="table table-striped table-responsive table-borderless table-market ">
        <colgroup>
          <col style="width: 30% ">
          <col style="width: 30% ">
          <col style="width: 40% ">
        </colgroup>
        <thead>
          <tr>
            <th class="text-left " scope="col ">Symbol</th>
            <th class="text-left " scope="col ">Price</th>
            <th class="text-right " scope="col ">Volume(24h)</th>
          </tr>
        </thead>
        <tbody>
          @foreach($marketList as $market)
          <tr data-id="{{ $market->id }}">
            <td class="text-left coin-{{ $market->coin_symbol }}">
              <a href="{{ route('trade', $market->coin_symbol . '-'. $market_symbol) }}">{{ $market->coin_symbol }}</a>
            </td>
            <td class="text-left amount">{{ $market->id }}</td>
            <td class="text-right date">{{ $market->id }}</td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
    @endforeach
  </div>
</div>