@extends('layouts.admin')
@section('title', 'Edit pair')

@section('javascript')
<script type="text/javascript">
$( document ).ready(function() {
    $('#pairs').addClass('active');
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
    <legend>Edit pair {{ $pair->symbol }}</legend>
    <table id="pair-table" class="table table-borderless">
        <thead>
            <tr>
                <th scope="col">Symbol</th>
                <th scope="col">Pair status</th>
                <th scope="col">Pair actions</th>
            </tr>
        </thead>
        <tbody>
            <tr class="">
                <td>{{ $pair->symbol }}/{{ $pair->market }}</td>
                    <td name="market_status">
                        <form action="{{ route('pairs.update', $pair) }}" method="POST">
                            {{ csrf_field() }}
                            <input type="hidden" name="_method" value="PUT">
                            @if ($pair->tradeable)
                                <span class="badge badge-success">Open</span>
                                <button type="submit" name="submit" value="suspend_pair" class="btn btn-sm btn-danger">Close</button>
                            @else
                                <span class="badge badge-danger">Closed</span>
                                <button type="submit" name="submit" value="resume_pair" class="btn btn-sm btn-success">Open</button>
                            @endif
                        </form>

                    </td>
                    <td name="volume" class="float-right">
                        <form action="{{ route('pairs.destroy', $pair) }}" method="post">
                            {{ csrf_field() }}
                            <input type="hidden" name="_method" value="delete">
                            <button type="submit" name="submit" value="delete" class="btn btn-sm btn-success confirm">Delete</button>
                        </form>
                    </td>
            </tr>
        </tbody>
    </table>
</fieldset>


@endsection
