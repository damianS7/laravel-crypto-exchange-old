@extends('layouts.admin')
@section('title', 'Pairs')

@section('javascript')
<script type="text/javascript">
$( document ).ready(function() {
    $('#pairs').addClass('active');
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
                <th scope="col">Pair</th>
                <th scope="col">Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($pairs as $pair)
            <tr class="">
                <td>
                    <a href="{{ route('pairs.edit', $pair->id) }}">{{ $pair->symbol }}/{{ $pair->market }}</a>
                </td>
                <td>
                    @if ($pair->tradeable)
                        <span class="badge badge-success">Open</span>
                    @else
                        <span class="badge badge-danger">Closed</span>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    {{ $pairs->links() }}
</fieldset>
<a href="{{ route('pairs.create') }}">Add pair</a>


@endsection
