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
    <table id="pair-table" class="table table-borderless">
        <thead>
            <tr>
                <th scope="col">Symbol</th>
                <th scope="col">Market status</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($markets as $market)
            <tr class="">
                <td name="coin">
                    <a href="{{ route('markets.edit', $market->id) }}">{{ $market['symbol'] }}</a>
                </td>
                <td name="market_status">
                    @if ($market['market_open'])
                        <span class="badge badge-success">Open</span>
                    @else
                        <span class="badge badge-danger">Closed</span>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    {{ $markets->links() }}
</fieldset>
<a href="{{ route('markets.create') }}">Add market</a>
@endsection