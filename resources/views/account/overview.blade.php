@extends('layouts.account')
@section('title', 'My account')

@section('javascript')
<script type="text/javascript">
$( document ).ready(function() {
    $('#overview').addClass('active');
});
</script>
@endsection

@section('content')
Your email
@endsection
