@extends('layouts.account')
@section('title', 'My account')

@section('javascript')
<script type="text/javascript">
$( document ).ready(function() {
    $('#verification').addClass('active');
});
</script>
@endsection

@section('content')
verification
@endsection
