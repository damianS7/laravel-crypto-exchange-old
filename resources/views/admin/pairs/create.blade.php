@extends('layouts.admin')
@section('title', 'New pair')

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
<fieldset class="form-group">
    <form action="{{ route('pairs.store') }}" method="post">
        {{ csrf_field() }}
        <legend>Add pair</legend>
        <div class="form-group row">
            <label for="symbol" class="col-sm-2 col-form-label">Coin</label>
            <div class="col-sm-4">
                <select name="coin_id" class="custom-select">
                    @foreach ($coins as $coin)
                    <option value="{{ $coin->id }}">
                        {{ $coin->symbol }}
                    </option>
                    @endforeach
                </select>
            </div>
            <label for="symbol" class="col-sm-2 col-form-label">Market</label>
            <div class="col-sm-4">
                <select name="market_id" class="custom-select">
                    @foreach ($markets as $market)
                    <option value="{{ $market->id }}">
                        {{ $market->symbol }}
                    </option>
                    @endforeach
                </select>
            </div>
        </div>
        <hr/>
        <button type="submit" class="btn btn-primary float-right" name="add_market">Add new pair</button>
    </form>
</fieldset>
@endsection
