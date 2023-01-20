@extends('layouts.base')

@section('title')
    Messages
@endsection

@section('content')
    @if(session()->has('error'))

        <div class="alert alert-danger alert-dismissible" role="alert">
            {{ session()->get('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">X</button>
        </div>


    @elseif(session()->has('success'))


        <div class="alert alert-success alert-dismissible" role="alert">
            {{ session()->get('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">X</button>
        </div>

    @endif
    <table class="table table-striped">
        <thead>
        <tr>
            <th>Name</th>
            <th>Email</th>
            <th>Message</th>
            <th>Date</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
        </thead>
        <tbody>
        @foreach($messages as $reg)
            <tr>
                <td>{{$reg->name}}</td>
                <td>{{$reg->email}}</td>
                <td>{{$reg->message}}</td>
                <td>{{$reg->created_at->diffForHumans()}}</td>
                <td>{{$reg->status}}</td>
                <td><a href="{{route('attended',[$reg->id])}}" class="btn btn-primary">Mark as Attended</a></td>


            </tr>
        @endforeach
        </tbody>
    </table>
    {{$messages->links()}}
@endsection
