@extends('layouts.account')
@section('title', 'My account')

@section('javascript')
<script type="text/javascript">
$( document ).ready(function() {
    $('#withdrawals').addClass('active');
});
</script>
@endsection

@section('content')
withdrawals
@endsection
