@extends('layouts.base')

@section('content')

<div class="p-5">
    <form action="{{route('save-settings')}}" method="post">
        @csrf

    <h6 class="section-secondary-title">Transaction Fee Amounts</h6>
        <p>Check SSN</p>
    <div class="form-group">
        <input type="number" step="0.01" name="amount_check" class="form-control" id="exampleFormControlInput1" value="{{$settings->amount_check??0}}">
    </div>
        <p>Register</p>
    <div class="form-group">
        <input type="number" step="0.01" name="amount_register" class="form-control" id="exampleFormControlInput1" value="{{$settings->amount_register??0}}">
    </div>
        <p>Portal Registration</p>
        <div class="form-group">
            <input type="number" step="0.01" name="amount_card" class="form-control" id="exampleFormControlInput1" value="{{$settings->amount_card??0}}">
        </div>
        <button type="submit" class="btn btn-primary">Save</button>
    </form>
</div>
@endsection
