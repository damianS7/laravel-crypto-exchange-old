@extends('layouts.account')
@section('title', 'My account')

@section('javascript')
<script type="text/javascript">
$( document ).ready(function() {
    $('#tradehistory').addClass('active');
});
</script>
@endsection

@section('content')
<h3>Trade history</h3>
<hr/>
<table class="table table-hover">
    <thead>
        <tr>
            <th scope="col">Pair</th>
            <th scope="col">Buy/Sell</th>
            <th scope="col">Date</th>
            <th scope="col">Amount</th>
            <th scope="col">Price</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($tradeHistory as $trade)
            <tr>
                <td>{{ $trade['pair'] }}</td>
                <td>{{ $trade['type'] }}</td>
                <td>{{ $trade['date'] }}</td>
                <td>{{ $trade['amount'] }}</td>
                <td>{{ $trade['price'] }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
{{ $tradeHistory->links() }}
@endsection
