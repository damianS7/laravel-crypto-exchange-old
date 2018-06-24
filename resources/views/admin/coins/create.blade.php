@extends('layouts.admin') @section('title', 'Manage coins')
@section('javascript')
<script type="text/javascript">
    $(document).ready(function () {
        $('#coins').addClass('active');
    });
</script>
@endsection
@section('content')
@if (Session::has('success'))
<div class="alert alert-success">
    {{ Session('success') }}
</div>
@endif @if (Session::has('info'))
<div class="alert alert-info">
    {{ Session('info') }}
</div>
@endif @if (Session::has('error'))
<div class="alert alert-danger">
    {{ Session('error') }}
</div>
@endif
<fieldset class="form-group">
    <form action="{{ route('coins.store') }}" method="post">
    {{ csrf_field() }}
        <legend>Add coin</legend>
        <div class="form-group row">
            <label for="staticEmail" class="col-sm-2 col-form-label">Symbol</label>
            <div class="col-sm-4">
                <input type="text" name="symbol" class="form-control" value="">
            </div>
            <label for="staticEmail" class="col-sm-2 col-form-label">Name</label>
            <div class="col-sm-4">
                <input type="text" name="name" class="form-control" value="">
            </div>
        </div>
        <div class="form-group row">
            <label for="staticEmail" class="col-sm-2 col-form-label">Min deposit</label>
            <div class="col-sm-4">

                <input type="number" name="min_deposit" min="0.00000001" step="0.00000001" class="form-control" value="0.00000001">
            </div>
            <label for="staticEmail" class="col-sm-2 col-form-label">Min withdrawl</label>
            <div class="col-sm-4">
                <input type="number" name="min_withdrawal" min="0.00000001" step="0.00000001" class="form-control" value="0.00000001">
            </div>
        </div>
        <div class="form-group row">
            <label for="staticEmail" class="col-sm-2 col-form-label">Withdrawl fee</label>
            <div class="col-sm-4">
                <input type="number" name="fee_withdrawal" min="0.00000001" step="0.00000001" class="form-control" value="0.00000001">
            </div>
        </div>
        <hr/>
        <button type="submit" class="btn btn-primary float-right" name="add_coin">Add new coin</button>
    </form>
</fieldset>
@endsection