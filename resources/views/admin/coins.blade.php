@extends('layouts.admin')
@section('title', 'Manage coins')

@section('javascript')
<script type="text/javascript">
$( document ).ready(function() {
    $('#coins').addClass('active');
});
</script>
@endsection

@section('content')
<fieldset class="form-group">
    <form method="POST">
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


<fieldset class="form-group">
    <legend>Edit coins</legend>
    <table id="pair-table" class="table table-borderless" >
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
            @foreach ($coins as $coin)
            <tr class="">
                <form class="" action="" method="post">
                    <input type="hidden" name="id" value="{{ $coin->id }}" />
                    <td name="coin"><input type="text" name="symbol" class="form-control" value="{{ $coin->symbol }}"></td>
                    <td name="price"><input type="text" name="name" class="form-control" value="{{ $coin->name }}"></td>
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
                        <button type="submit" class="btn btn-danger btn-sm confirm" name="remove_coin">X</button>
                    </td>

                </form>
            </tr>

            @endforeach
        </tbody>
    </table>
    {{ $coins->links() }}
</fieldset>


@endsection
