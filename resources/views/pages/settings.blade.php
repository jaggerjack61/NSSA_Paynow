@extends('layouts.base')

@section('content')

<div class="p-5">
    <form action="" method="">
        @csrf
    <h6 class="section-secondary-title">Username</h6>
    <div class="form-group">
        <input type="text" name="email" class="form-control" id="exampleFormControlInput1" disabled>
    </div>
    <h6 class="section-secondary-title">Password</h6>
    <div class="form-group">
        <input type="password" name="password" class="form-control" id="exampleFormControlInput1" placeholder="Enter password">
    </div>
    <h6 class="section-secondary-title">Transaction Fee Amount</h6>
    <div class="form-group">
        <input type="number" name="amount" class="form-control" id="exampleFormControlInput1" placeholder="RTGS">
    </div>
        <button type="submit" class="btn btn-primary">Login</button>
    </form>
</div>
@endsection
