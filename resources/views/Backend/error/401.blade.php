@extends('Backend/layouts.master')
@section('title','Unauthorized')
@section('content')
    <div class="container" style="text-align:center;">
        <h1 style="color:red;text-align:center;"> You don't have permission to access this resource </h1>
        <img src="/assets/images/401page.png" style="height:300px;">
    </div>
@endsection
