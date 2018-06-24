@extends('layouts.admin') @section('title', 'Markets') @section('javascript')
<script type="text/javascript">
    $(document).ready(function () {
        $('#markets').addClass('active');
    });
    $('.confirm').click(function (e) {
        if (!confirm('Are you sure?')) {
            e.preventDefault();
        }
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
    <legend>Edit Market {{ $market['symbol'] }}</legend>
    <table id="pair-table" class="table table-borderless">
        <thead>
            <tr>
                <th scope="col" onClick="alert('orderPair')">Symbol</th>
                <th scope="col">Market status</th>
                <th scope="col">Market actions</th>
            </tr>
        </thead>
        <tbody>
            <tr class="">
                <td name="coin">{{ $market->symbol }}</td>
                    <td name="market_status">
                        <form action="{{ route('markets.update', $market) }}" method="POST">
                            {{ csrf_field() }}
                            <input type="hidden" name="_method" value="PUT">
                            @if ($market->market_open)
                                <span class="badge badge-success">Open</span>
                                <button type="submit" name="submit" value="close_market" class="btn btn-sm btn-danger">Close</button>
                            @else
                                <span class="badge badge-danger">Closed</span>
                                <button type="submit" name="submit" value="open_market" class="btn btn-sm btn-success">Open</button>
                            @endif
                        </form>

                    </td>
                    <td name="volume" class="float-right">
                        <form action="{{ route('markets.destroy', $market) }}" method="post">
                            {{ csrf_field() }}
                            <input type="hidden" name="_method" value="delete">
                            <button type="submit" name="submit" value="delete" class="btn btn-sm btn-success">Delete</button>
                        </form>
                    </td>
            </tr>
        </tbody>
    </table>
</fieldset>

@endsection