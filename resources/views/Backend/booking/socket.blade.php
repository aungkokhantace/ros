@extends('cashier.layouts.master')
@section('title','Socket Request Blade')
@section('content')
<script>
    $(document).ready(function(){
        var socketKey        = "table_message";
        var socketValue      = {table_message : 'table_message'};
        socketEmit(socketKey,socketValue);
    });
</script>
@endsection
