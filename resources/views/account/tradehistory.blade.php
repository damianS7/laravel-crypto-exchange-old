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
TRADE HISTORY
@endsection
