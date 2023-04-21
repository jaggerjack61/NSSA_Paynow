@extends('layouts.base')

@section('title')
    Cards
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
            <th>Phone</th>
            <th>ID</th>
            <th>Email</th>
            <th>Date</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
        </thead>
        <tbody>
        @foreach($cards as $card)
            @if($card->status != "pending")
            <tr>
                <th>{{$card->name}}</th>
                <td>{{$card->phone}}</td>
                <td>{{$card->id_number}}</td>
                <th>{{$card->email}}</th>
                <td>{{$card->created_at->diffForHumans()}}</td>
                <td>{{$card->status=="complete"?"Pending":"Completed"}}</td>
                <td>@if($card->status != "finished")
                    <a href="{{route('finish',[$card->id])}}" class="btn btn-primary">Mark as Completed</a>
                    @endif
                    </td>


            </tr>
            @endif
        @endforeach
        </tbody>
    </table>
    {{$cards->links()}}
    <div class="modal fade" id="viewClientModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">View Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <h4>Identification</h4>
                    <div class="row">
                        <img id="identification" />

                    </div>

                </div>

            </div>
        </div>
    </div>


    <script>
        function loadImages(number){
            var img = new Image();
            img.src = '/client'+number+'/id.jpg';
            var popup = window.open();
            popup.document.write(img);
            document.getElementById('identification').src='clients/'+number+'/id.jpg';

        }
    </script>
@endsection
