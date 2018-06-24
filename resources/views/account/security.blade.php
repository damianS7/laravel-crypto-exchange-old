@extends('layouts.account')
@section('title', 'My account')

@section('javascript')
<script type="text/javascript">
$( document ).ready(function() {
    $('#security').addClass('active');
});
</script>
@endsection

@section('content')
Please enable 2FA
QR CODE
CODE TEXT
Enter 2FA to activate
<button>SAVE</button>
@endsection
