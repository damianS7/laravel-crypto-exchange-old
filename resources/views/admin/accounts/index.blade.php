@extends('layouts.admin')
@section('title', 'User accounts')

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
<fieldset class="form-group">
    <legend>Accounts</legend>
    <table id="pair-table" class="table table-borderless">
        <thead>
            <tr>
                <th scope="col">Id</th>
                <th scope="col">Email</th>
                <th scope="col">Created at</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($accounts as $account)
                <tr class="">
                    <td>
                        {{ $account->id }}
                    </td>
                    <td>
                        <a href="{{ route('accounts.edit', $account->id) }}">{{ $account->email }}</a>
                    </td>
                    <td>
                        {{ $account->created_at }}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {{ $accounts->links() }}
</fieldset>
@endsection
