@extends('layouts.base')

@section('title')
    Pricing Plans
@endsection

@section('content')
    <div class="container">
        <h1 class="text-center">Pricing Plans</h1>
        <!-- Button to trigger modal for adding new item -->
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addItemModal">
            Add New Item
        </button>
        <!-- Modal for adding new item -->
        <div class="modal fade" id="addItemModal" tabindex="-1" aria-labelledby="addItemModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form id="addItemForm" action="{{route('create-pricing')}}" method="post">
                        @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="addItemModalLabel">Add New Plan</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <!-- Form for adding new item -->

                            <div class="form-group">
                                <label for="title">Title</label>
                                <input type="text" class="form-control" id="title" name="name" required>
                            </div>
                            <div class="form-group">
                                <label for="content">Price</label>
                                <input type="number" step="0.01" class="form-control" id="content" name="amount" required></input>
                            </div>


                    </div>
                    <div class="modal-footer">
                        <!-- Button to submit form -->
                        <button type="submit" class="btn btn-primary" id="addItemBtn">Add Plan</button>
                        <!-- Button to close modal -->
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Table to display items -->
        <table class="table table-striped table-bordered mt-4">
            <thead class="thead-dark">
            <tr>
                <th scope="col">Title</th>
                <th scope="col">Price</th>
                <th scope="col">Items</th>
                <th scope="col">Action</th>
            </tr>
            </thead>
            <tbody>
            @foreach($plans as $plan)
                <tr>
                    <td>{{$plan->name}}</td>
                    <td>{{$plan->amount}}</td>
                    <td>
                        @foreach($plan->items as $item)
                            <div class="row">
                               <div class="col-8">{{$item->name}}</div>
                                <div class="col-4"><a class="btn btn-danger" href="{{route('delete-pricing-item',$item->id)}}">Delete</a></div>
                            </div>
                            <hr>
                        @endforeach

                    </td>
                    <td><a class="btn btn-danger" href="{{route('delete-pricing',$plan->id)}}">Delete</a>
                        <a class="btn btn-success" data-toggle="modal" data-target="#addItemModal{{$plan->id}}">Add Item</a></td>
                </tr>


                            <div class="modal fade" id="addItemModal{{$plan->id}}" tabindex="-1" aria-labelledby="addItemModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <form id="addItemForm" action="{{route('create-pricing-item')}}" method="post">
                                            @csrf
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="addItemModalLabel">Add New Item to {{$plan->name}} </h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <!-- Form for adding new item -->

                                                <div class="form-group">
                                                    <label for="title">Title</label>
                                                    <input type="text" class="form-control" id="title" name="name" required>
                                                </div>
                                                <input type="hidden" name="pricing_plan_id" value="{{$plan->id}}">


                                            </div>
                                            <div class="modal-footer">
                                                <!-- Button to submit form -->
                                                <button type="submit" class="btn btn-primary" id="addItemBtn">Add Item</button>
                                                <!-- Button to close modal -->
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>



                @endforeach
            </tbody>
        </table>
    </div>
@endsection
