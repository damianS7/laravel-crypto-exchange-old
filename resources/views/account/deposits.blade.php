@extends('layouts.account')
@section('title', 'Deposits')
@section('javascript')
<script type="text/javascript">
$( document ).ready(function() {
    $('#deposits').addClass('active');
});
</script>
@endsection
@section('content')
<h3>Deposit</h3>

<hr/>
<div class="">
    @if (count($errors) > 0)
        <div class="alert alert-danger">
            err
        </div>
    @else
    <div class="alert alert-info">
        <p class="text-danger">
            Send only <?php //echo htmlentities($_GET['deposit']); ?> to this address:
        </p>
        <p>
            <b>
                <?php //echo $deposit['address']; ?>
            </b>
        </p>
        <p>
            <b>Minimum deposit:</b>
            <?php //echo $deposit['min_deposit']; ?>
        </p>
        <pre>
            <?php //print_r($deposit); ?>
        </pre>
    </div>
    @endif
</div>
<hr/>
{{ Auth::user()->id }}
<span>
    <input id="search_coin" class="form-control" aria-label="" type="text" value="" placeholder="Search a coin" onClick="doSearch()">
</span>
<div class="search-scroll">
    <div class="form-group">
        @foreach ($coins as $coin)
        <form class="" action="{{ route('deposit') }}" method="post">
                {{ csrf_field() }}
                <input type="hidden" name="coin" value="{{ $coin['symbol'] }}">
                <a class="list-group-item" href="#" onclick="submit()">
                    <img class="" src="{{ asset('images/coins/32x32') }}/{{ $coin['symbol'] }}.png" alt="">
                    <span class="badge badge-primary">{{ $coin['symbol'] }}</span>
                    <span class="badge badge-pill">{{ $coin['name'] }}</span>
                </a>
        </form>
        @endforeach
    </div>
</div>
<hr/>

<h3>Deposit history</h3>
<hr/>
<table class="table table-hover">
    <thead>
        <tr>
            <th scope="col">Date</th>
            <th scope="col">Coin</th>
            <th scope="col">Amount</th>
            <th scope="col">Information</th>
            <th scope="col">Status</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($deposits as $deposit)
            <tr>
                <td>{{ $deposit['date'] }}</td>
                <td>{{ $deposit['coin_id'] }}</td>
                <td>{{ $deposit['amount'] }}</td>
                <td>{{ $deposit['address'] }}</td>
                <td>{{ $deposit['status'] }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
{{ $deposits->links() }}
@endsection
