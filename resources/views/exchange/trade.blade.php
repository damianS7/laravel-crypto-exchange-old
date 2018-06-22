<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>BitEx | @yield('title') {{ $pair }} </title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous">
    <link rel="stylesheet" href="/bitex/resources/css/account.css">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">

    <!-- Styles -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous">
    
    @if (Cookie::get('theme') == 'light')
        <link href="{{ asset('css/exchange-light.css') }}" rel="stylesheet">
    @else
        <link href="{{ asset('css/exchange-dark.css') }}" rel="stylesheet">
    @endif

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js" integrity="sha384-smHYKdLADwkXOn1EmN1qk/HfnUcbVRZyYmZ4qpPea6sjB/pTJ0euyQp0Mk8ck+5T" crossorigin="anonymous"></script>
</head>
<body>
    <div id="main-menu">
        @include('exchange.menu')
    </div>
    <p>&nbsp;</p>
    <div class="container-fluid">
        <div class="row">
            <div id="col-left" class="col-sm-7">
                <div class="row">
                    <div id="graph" class="col-sm-12">
                        include('exchange.priceHistory')


                        <p>Setting buyfee {{ @$settings['buy_fee']->value }}</p>
                        <p>Market id 1 {{ @$markets['BTC']->symbol }}</p>
                        <p>Pairs:{{ count( @$markets['BTC']->getPairs() ) }}</p>
                        @foreach ($markets as $market)
                            <p>Market: {{ $market->symbol }}</p>
                            <p>Pairs: {{ count($market->getPairs()) }}</p>
                            @foreach ($market->getPairs() as $pair)
                                <p>Pair: {{ $pair->symbol }}</p>
                            @endforeach
                        @endforeach


                    </div>
                </div>

                <div class="row">
                    <div id="user-orders" class="col-sm-12">
                        @include('exchange.userOrders')
                    </div>
                </div>
            </div>

            <div id="col-right" class="col-sm-5">
                <div class="row">
                    <div id="order-book" class="col-sm-6">
                        @include('exchange.orderBook')
                    </div>
                    <div id="order-history" class="col-sm-6">
                        @include('exchange.orderHistory')
                    </div>
                </div>
                <div id="buy-sell-widget" class="row">
                    @include('exchange.orderForm')
                </div>
            </div>
        </div>
    </div>
</body>
</html>
