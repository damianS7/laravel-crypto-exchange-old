@extends('layouts.admin') @section('title', 'Edit coin')
@section('javascript')
<script type="text/javascript">
    $(document).ready(function () {
        $('#coins').addClass('active');

        $('.confirm').click(function (e) {
            if (!confirm('Are you sure?')) {
                e.preventDefault();
            }
        });
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
    <form action="{{ route('coins.update', $coin) }}" method="POST">
        {{ csrf_field() }}
        <input type="hidden" name="_method" value="PUT">
        <legend>Add coin</legend>
        <div class="form-group row">
            <label for="" class="col-sm-2 col-form-label">Symbol</label>
            <div class="col-sm-4">
                <input type="text" name="symbol" class="form-control" value="{{ $coin->symbol }}">
            </div>
            <label for="" class="col-sm-2 col-form-label">Name</label>
            <div class="col-sm-4">
                <input type="text" name="name" class="form-control" value="{{ $coin->name }}">
            </div>
        </div>
        <div class="form-group row">
            <label for="" class="col-sm-2 col-form-label">Min deposit</label>
            <div class="col-sm-4">
                <input type="number" name="min_deposit" min="0.00000001" step="0.00000001" class="form-control" value="{{ $coin->min_deposit }}">
            </div>
            <label for="" class="col-sm-2 col-form-label">Min withdrawl</label>
            <div class="col-sm-4">
                <input type="number" name="min_withdrawal" min="0.00000001" step="0.00000001" class="form-control" value="{{ $coin->min_withdrawal }}">
            </div>
        </div>
        <div class="form-group row">
            <label for="" class="col-sm-2 col-form-label">Withdrawl fee</label>
            <div class="col-sm-4">
                <input type="number" name="fee_withdrawal" min="0.00000001" step="0.00000001" class="form-control" value="{{ $coin->fee_withdrawal }}">
            </div>
            <label for="" class="col-sm-2 col-form-label"></label>
            <div class="col-sm-4">
                <button type="submit" class="btn btn-primary btn-sm" name="submit" value="update">Update</button>
            </div>
        </div>
    </form>
    <hr/>
    <form action="{{ route('coins.destroy', $coin) }}" method="post">
        <input type="hidden" name="_method" value="delete">
        {{ csrf_field() }}
        <button type="submit" name="submit" value="delete" class="btn btn-danger float-right confirm">Delete</button>
    </form>
</fieldset>

@endsection