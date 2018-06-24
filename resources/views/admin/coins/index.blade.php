@extends('layouts.admin') @section('title', 'Coins')
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
    <legend>Coins</legend>
    <table id="pair-table" class="table table-borderless">
        <thead>
            <tr>
                <th scope="col" onClick="alert('orderPair')">Symbol</th>
                <th scope="col">Name</th>
                <th scope="col">M.Deposit</th>
                <th scope="col">M.Withdrawal</th>
                <th scope="col">Withdrawal fee</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($coins as $coin)
             <tr class="">
                <form class="" action="{{ route('coins.update', $coin) }}" method="post">
                    {{ csrf_field() }}
                    <input type="hidden" name="_method" value="PUT">
                    <td name="coin">
                        <a href="{{ route('coins.edit', $coin->id) }}">{{ $coin->symbol }}</a>
                    </td>
                    <td name="price">
                        {{ $coin->name }}
                    </td>
                    <td name="change">
                        {{ $coin->min_deposit }}
                    </td>
                    <td name="volume">
                        {{ $coin->min_withdrawal }}
                    </td>
                    <td name="volume">
                        {{ $coin->fee_withdrawal }}
                    </td>
                </form>
            </tr>
            @endforeach
        </tbody>
    </table>
    {{ $coins->links() }}
</fieldset>
<a href="{{ route('coins.create') }}">Add coin</a>
@endsection