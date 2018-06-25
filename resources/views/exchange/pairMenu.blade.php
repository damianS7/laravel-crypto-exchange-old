like poloniex DIVIDIR EN 2 EL MARKET HISTORY COMO BUY SELLS

<p>Market id 1 {{ @$markets['BTC']->symbol }}</p>
<p>Pairs:{{ count( @$markets['BTC']->getPairs() ) }}</p>
@foreach ($markets as $market)
<p>Market: {{ $market->symbol }}</p>
<p>Pairs: {{ count($market->getPairs()) }}</p>
@foreach ($market->getPairs() as $pair)
<p>Pair: {{ $pair->symbol }}</p>
@endforeach @endforeach
<div id="pairs">
    <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item">
            <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">BTC</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">ETH</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="contact-tab" data-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-selected="false">BTX</a>
        </li>
        <li class="nav-item">
            <input id="search_coin" class="form-control" aria-label="" type="text" value="" placeholder="Search a coin" onClick="doSearch()">
        </li>
    </ul>

    <table id="ppp" class="table table-borderless">

        <tbody>
            <tr>
                <th style="width: 25%">Symbol</th>
                <th style="width: 25%">Price</th>
                <th style="width: 25%">24h Change</th>
                <th style="width: 25%">24h Volume</th>
            </tr>
        </tbody>
    </table>

    <div id="search-scroll" class="tab-content">
        <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
            <table id="pair-table" class="table table-borderless">

                <tbody>
                    <?php foreach ($coins as $coin): ?>
                    <tr class="">
                        <input type="hidden" name="id" value="<?php echo $coin['id']; ?>" />
                        <td style="width: 25%" name="coin">
                            <?php echo $coin['symbol']; ?>
                        </td>
                        <td style="width: 25%" name="price">1</td>
                        <td style="width: 25%" name="24hchange">1</td>
                        <td style="width: 25%" name="24hvolume">1</td>
                    </tr>
                    <?php endforeach;?>
                </tbody>
            </table>
        </div>

        <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">

        </div>

        <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">

        </div>
    </div>
</div>