@extends('layouts.admin')
@section('title', 'Exchange settings')

@section('javascript')
<script type="text/javascript">
$( document ).ready(function() {
    $('#pairs').addClass('active');
});
</script>
@endsection

@section('content')

@if (Session::has('success'))
<div class="alert alert-success">
    {{ Session('success') }}
</div>
@endif

@if (Session::has('info'))
<div class="alert alert-info">
    {{ Session('info') }}
</div>
@endif

@if (Session::has('error'))
<div class="alert alert-danger">
    {{ Session('error') }}
</div>
@endif



@endsection
