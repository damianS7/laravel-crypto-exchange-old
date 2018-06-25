@extends('layouts.admin')
@section('title', 'Edit account')

@section('javascript')
<script type="text/javascript">
$( document ).ready(function() {
    $('#accounts').addClass('active');
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
    <form action="{{ route('accounts.update', $account) }}" method="post">
        {{ csrf_field() }}
        <input type="hidden" name="_method" value="PUT">
        <legend>Edit account</legend>
        <div class="form-group row">
            <label for="" class="col-sm-2 col-form-label">Id</label>
            <div class="col-sm-4">
                <input type="text" class="form-control" value="{{ $account->id }}" readonly>
            </div>
            <label for="" class="col-sm-2 col-form-label">Email</label>
            <div class="col-sm-4">
                <input type="text" name="email" class="form-control" value="{{ $account->email }}">
            </div>
        </div>

        <div class="form-group row">
            <label for="" class="col-sm-2 col-form-label">Privileges</label>
            <div class="col-sm-4">
                <select name="privileges" class="custom-select">
                    <option value="{{ $account->privileges }}">{{ $account->privileges }}</option>
                    <option value="user">user</option>
                    <option value="admin">admin</option>
                </select>
            </div>
            <label for="" class="col-sm-2 col-form-label">Date</label>
            <div class="col-sm-4">
                <input type="text" class="form-control" value="{{ $account->created_at }}" readonly>
            </div>
        </div>

        <div class="form-group row">
            <label for="" class="col-sm-2 col-form-label">Actions</label>
            <div class="col-sm-10">
                <button type="submit" name="submit" value="password" class="btn btn-primary float-right confirm">New password</button>
                <button type="submit" name="submit" value="update" class="btn btn-primary float-right confirm">Update</button>
                <button type="submit" name="submit" value="freeze" class="btn btn-info float-right confirm">Freeze</button>
            </div>
        </div>
    </form>
    <hr/>
    <form action="{{ route('accounts.destroy', $account) }}" method="post">
        <input type="hidden" name="_method" value="delete">
        {{ csrf_field() }}
        <button type="submit" name="submit" value="delete" class="btn btn-danger float-right confirm">Delete</button>
    </form>
</fieldset>
@endsection
