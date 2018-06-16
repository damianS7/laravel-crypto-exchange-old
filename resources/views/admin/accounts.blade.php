@extends('layouts.admin')
@section('title', 'Exchange accounts')

@section('javascript')
<script type="text/javascript">
$( document ).ready(function() {
    $('#accounts').addClass('active');
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
    @foreach ($accounts as $account)
    <div class="form-group row">
        <label for="staticEmail" class="col-sm-6 col-form-label">{{ $account->email }}</label>
        <div class="col-sm-6">
            <input type="text" name="" class="form-control" value="">
            <small class="form-text text-muted"></small>
        </div>
    </div>
    @endforeach

    {{ csrf_field() }}
    <button type="submit" class="btn btn-primary float-right" name="save_settings">Update settings</button>
</fieldset>
</form>

@endsection
