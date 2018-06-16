@extends('layouts.account')
@section('title', 'My account')

@section('javascript')
<script type="text/javascript">
$( document ).ready(function() {
    $('#security').addClass('active');
});
</script>
@endsection

@section('content')
security
@endsection
