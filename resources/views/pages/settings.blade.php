@extends('layouts.base')

@section('content')

<div class="p-5">
    <form action="{{route('save-settings')}}" method="post">
        @csrf

    <h6 class="section-secondary-title">Transaction Fee Amount</h6>
    <div class="form-group">
        <input type="number" name="amount" class="form-control" id="exampleFormControlInput1" value="{{$settings->amount}}">
    </div>
        <button type="submit" class="btn btn-primary">Save</button>
    </form>
</div>
@endsection
