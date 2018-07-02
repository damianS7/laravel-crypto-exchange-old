<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>BitEx | @yield('title') {{ $coin1->symbol }}{{ $coin2->symbol }} </title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous">
    <link href="{{ asset('css/common.css') }}" rel="stylesheet">
    <link href="{{ asset('css/exchange.css') }}" rel="stylesheet">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">

    <!-- Styles -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous">
    <link rel="stylesheet" href="http://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">

    @if (Cookie::get('theme') == 'light')
        <link href="{{ asset('css/exchange-light.css') }}" rel="stylesheet">
    @else
        <link href="{{ asset('css/exchange-dark.css') }}" rel="stylesheet">
    @endif

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.3.1.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js" integrity="sha384-smHYKdLADwkXOn1EmN1qk/HfnUcbVRZyYmZ4qpPea6sjB/pTJ0euyQp0Mk8ck+5T" crossorigin="anonymous"></script>
    <script src="http://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.2/js/toastr.min.js"></script>
</head>
<body>
    <div id="main-menu">
        @include('exchange.menu')
    </div>
    <!-- <p>&nbsp;</p> -->
    <div class="container-fluid">

        <div id="row1" class="row">
            <div id="market-menu-container" class="col-sm-2">
                @include('exchange.pairMenu')
            </div>
            <div id="price-history-container" class="col-sm-4">
                include('exchange.priceHistory')
                MARKET DEPTH
            </div>
            <div id="order-book-container" class="col-sm-3">
                @include('exchange.orderBook')
            </div>
            <div id="market-history-container" class="col-sm-3">
                @include('exchange.marketHistory')
            </div>
        </div>


        <div id="row2" class="row">
            <div id="user-orders-container" class="col-sm-6">
                @include('exchange.tab')
            </div>

            <div id="order-form-container" class="col-sm-6">
                @include('exchange.orderForm')
            </div>
        </div>
    </div>
    <script src="{{ asset('js/trade.js') }}"></script>
</body>
</html>
