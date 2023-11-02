@extends('layouts.base')

@section('title')
    Registrations
@endsection

@section('content')
    <table class="table table-striped">
        <thead>
            <tr>
                <th>First Names</th>
                <th>Lastname</th>
                <th>DOB</th>
                <th>ID No</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Company</th>
                <th>Position</th>
                <th>Start-End</th>
                <th>Salary</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
        @foreach($registrations as $reg)
            <tr>
                <td>{{$reg->first_names}}</td>
                <td>{{$reg->last_name}}</td>
                <td>{{$reg->dob}}</td>
                <td>{{$reg->id_number}}</td>
                <td>{{$reg->email}}</td>
                <td>{{$reg->phone}}</td>
                <td>{{$reg->company}}</td>
                <td>{{$reg->occupation}}</td>
                <td>{{$reg->start_date}}-{{$reg->end_date}}</td>
                <td>{{$reg->salary}}</td>
                @if($reg->status=='complete')
                <td>Not Registered</td>
                @elseif($reg->status=='registered')
                <td>Registered</td>
                @else
                <td>Unknown Status</td>
                @endif
                @if($reg->status=='complete')
                    <td><a class="btn btn-primary" href="{{route('register',[$reg->id])}}">Register</a></td>
                @elseif($reg->status=='registered')
                    <td><a class="btn btn-secondary" href="{{route('unregister',[$reg->id])}}">unRegister</a></td>
                @else
                    <td>Unknown Status</td>
                @endif

            </tr>
        @endforeach
        </tbody>
    </table>
    {{$registrations->links()}}
@endsection
