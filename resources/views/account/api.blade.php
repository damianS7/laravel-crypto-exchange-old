@extends('layouts.account')
@section('title', 'My account')

@section('javascript')
<script type="text/javascript">
$( document ).ready(function() {
    $('#api').addClass('active');
});
</script>
@endsection

@section('content')
api
@endsection
