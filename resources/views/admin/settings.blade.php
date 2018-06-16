@extends('layouts.admin')
@section('title', 'Exchange settings')

@section('javascript')
<script type="text/javascript">
$( document ).ready(function() {
    $('#settings').addClass('active');
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

<form class="" action="{{ route('admin-save-settings') }}" method="post">
<fieldset class="form-group">
    <legend>Settings</legend>
    <div class="form-group row">
        <label for="staticEmail" class="col-sm-6 col-form-label">Buy fee</label>
        <div class="col-sm-6">
            <input type="text" name="buy_fee" class="form-control" value="{{ $settings['buy_fee']['value'] }}">
            <small class="form-text text-muted"></small>
        </div>
    </div>

    <div class="form-group row">
        <label for="staticEmail" class="col-sm-6 col-form-label">Sell fee</label>
        <div class="col-sm-6">
            <input type="text" name="sell_fee" class="form-control" value="{{ $settings['sell_fee']['value'] }}">
            <small class="form-text text-muted"></small>
        </div>
    </div>

    <div class="form-group row">
        <label for="staticEmail" class="col-sm-6 col-form-label">Process Withdrawal</label>
        <div class="col-sm-6">
            <input type="text" name="process_withdrawal" class="form-control" value="{{ $settings['process_withdrawal']['value'] }}">
            <small class="form-text text-muted">Delay in minutes to process all withdrawals</small>
        </div>
    </div>

    {{ csrf_field() }}
    <button type="submit" class="btn btn-primary float-right" name="save_settings">Update settings</button>
</fieldset>
</form>

@endsection
