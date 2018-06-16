<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>BitEx | @yield('title')</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous">
    <link rel="stylesheet" href="/bitex/resources/css/account.css">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/common.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous">
    <link href="{{ asset('css/account.css') }}" rel="stylesheet">

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js" integrity="sha384-smHYKdLADwkXOn1EmN1qk/HfnUcbVRZyYmZ4qpPea6sjB/pTJ0euyQp0Mk8ck+5T" crossorigin="anonymous"></script>
    @yield('javascript')
</head>
<body>
    <nav class="navbar navbar-expand-lg nav-light bg-light">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
            <span class="navbar-toggler-icon"></span>
        </button>
        <a class="navbar-brand" href="#">BitEx</a>

        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">

            <ul class="navbar-nav ml-md-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="{{ route('logout') }}"
                        onclick="event.preventDefault();
                                 document.getElementById('logout-form').submit();">
                        Logout
                    </a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        {{ csrf_field() }}
                    </form>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('trade') }}">Exchange</a>
                </li>
            </ul>
        </div>
    </nav>
    <p>&nbsp;</p>
    <div class="container">
        <div class="row">
            <div class="col-sm-3">
                <div class="list-group" id="menu-list">
                    <a class="list-group-item list-group-item-action" id="settings" href="{{ route('admin-settings') }}">Settings</a>
                    <a class="list-group-item list-group-item-action" id="accounts" href="{{ route('admin-accounts') }}">Accounts</a>
                    <a class="list-group-item list-group-item-action" id="coins" href="{{ route('admin-coins') }}">Coins</a>
                    <a class="list-group-item list-group-item-action" id="markets" href="{{ route('admin-markets') }}">Markets</a>
                    <a class="list-group-item list-group-item-action" id="pairs" href="{{ route('admin-pairs') }}">Pairs</a>
                    <a class="list-group-item list-group-item-action" id="withdrawals" href="{{ route('admin-withdrawals') }}">Pending Withdrawls</a>
                    <a class="list-group-item list-group-item-action" id="security" href="security.php">Maintenance</a>
                    <a class="list-group-item list-group-item-action" id="verification" href="verification.php">Verification</a>
                    <a class="list-group-item list-group-item-action" id="verification" href="verification.php">Stats</a>
                    <a class="list-group-item list-group-item-action" id="verification" href="verification.php">Exchange status</a>
                    <a class="list-group-item list-group-item-action" id="verification" href="verification.php">Cron</a>
                    <a class="list-group-item list-group-item-action" id="verification" href="verification.php">Scripts</a>
                </div>
            </div>
            <div class="col-sm-9">
                <div class="jumbotron">
                    @yield('content')
                </div>
            </div>
        </div>
    </div>
</body>
</html>
