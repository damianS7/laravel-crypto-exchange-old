@extends('layouts.account')
@section('title', 'Balances')

@section('javascript')
<script type="text/javascript">
$( document ).ready(function() {
    $('#balances').addClass('active');
});
</script>
@endsection

@section('content')
BALANCES
@endsection
