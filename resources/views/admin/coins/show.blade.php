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
    <legend>Edit coins</legend>
    <table id="pair-table" class="table table-borderless">
        <thead>
            <tr>
                <th scope="col" onClick="alert('orderPair')">Symbol</th>
                <th scope="col">Name</th>
                <th scope="col">M.Deposit</th>
                <th scope="col">M.Withdrawal</th>
                <th scope="col">Withdrawal fee</th>
                <th scope="col">Coin actions</th>
            </tr>
        </thead>
        <tbody>
            
            <tr class="">
                <form class="" action="" method="post">
                    <input type="hidden" name="id" value="{{ $coin->id }}" />
                    <td name="coin">
                        <input type="text" name="symbol" class="form-control" value="{{ $coin->symbol }}">
                    </td>
                    <td name="price">
                        <input type="text" name="name" class="form-control" value="{{ $coin->name }}">
                    </td>
                    <td name="change">
                        <input type="number" name="min_deposit" min="0.00000001" step="0.00000001" class="form-control" value="{{ $coin->min_deposit }}">
                    </td>
                    <td name="volume">
                        <input type="number" name="min_withdrawal" min="0.00000001" step="0.00000001" class="form-control" value="{{ $coin->min_withdrawal }}">
                    </td>
                    <td name="volume">
                        <input type="number" name="fee_withdrawal" min="0.00000001" step="0.00000001" class="form-control" value="{{ $coin->fee_withdrawal }}">
                    </td>
                    <td name="volume" class="">
                        <button type="submit" class="btn btn-primary btn-sm" name="update_coin">Update</button>
                    </td>

                </form>
            </tr>

            
        </tbody>
    </table>
    
</fieldset>


@endsection