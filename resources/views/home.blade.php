@extends('layouts.app')
@section('title', 'Home')

@section('javascript')
<script type="text/javascript">
$( document ).ready(function() {

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

<div class="scroll-wrapper" style="">
	<section class="section1">
	</section>
	<section class="section2"></section>
	<section class="section3"></section>
	<section class="section4"></section>
</div>
@endsection
