@extends('layouts.base')

@section('title')
    News Feed
@endsection

@section('content')
    <div class="container">
        <h1 class="text-center">News Feed</h1>
        <!-- Button to trigger modal for adding new item -->
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addItemModal">
            Add New Item
        </button>
        <!-- Modal for adding new item -->
        <div class="modal fade" id="addItemModal" tabindex="-1" aria-labelledby="addItemModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form id="addItemForm" action="{{route('create-news')}}" method="POST"
                          enctype="multipart/form-data">
                        @csrf
                        <div class="modal-header">
                            <h5 class="modal-title" id="addItemModalLabel">Add New Item</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <!-- Form for adding new item -->

                            <div class="form-group">
                                <label for="title">Title</label>
                                <input type="text" class="form-control" id="title" name="title" required>
                            </div>
                            <div class="form-group">
                                <label for="title">Link</label>
                                <input type="text" class="form-control" id="title" name="link">
                            </div>
                            <div class="form-group">
                                <label for="content">Content</label>
                                <textarea class="form-control" id="content" name="content" rows="3" required></textarea>
                            </div>
                            <div class="form-group">
                                <label for="image">Image</label>
                                <input type="file" class="form-control-file" id="image" name="image"
                                       accept=".jpg,.png,.gif,.jpeg,.bmp,.webp,.svg,.ico,.tiff,.tif,.raw,.cr2,.nef,.orf,.sr2,.heic,.heif,.avif,.jfif,.pjpeg,.pjp,.webp2">
                            </div>

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

        <!-- Table to display items -->
        <table class="table table-striped table-bordered mt-4">
            <thead class="thead-dark">
            <tr>
                <th scope="col">Title</th>
                <th scope="col">Content</th>
                <th scope="col">Link</th>
                <th scope="col">Image</th>
                <th scope="col">Action</th>
            </tr>
            </thead>
            <tbody>
            @foreach($items as $item)
                <tr>
                    <td>{{$item->title}}</td>
                    <td>{{$item->content}}</td>
                    <td>{{$item->link}}</td>
                    <td><img src="{{$item->image}}" width="100px"/></td>
                    <td>
                        <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#editItemModal{{$item->id}}">Edit</a>
                        <a href="{{route('delete-news',$item->id)}}" class="btn btn-danger">Delete</a>

                    </td>
                </tr>

                <div class="modal fade" id="editItemModal{{$item->id}}" tabindex="-1" aria-labelledby="addItemModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form id="addItemForm" action="{{route('update-news')}}" method="POST"
                                  enctype="multipart/form-data">
                                @csrf
                                <div class="modal-header">
                                    <h5 class="modal-title" id="addItemModalLabel">Add New Item</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <!-- Form for adding new item -->
                                    <input type="hidden" name="id" value="{{$item->id}}">
                                    <div class="form-group">
                                        <label for="title">Title</label>
                                        <input type="text" class="form-control" id="title" value="{{$item->title}}" name="title" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="title">Link</label>
                                        <input type="text" class="form-control" id="link" value="{{$item->link}}" name="link">
                                    </div>
                                    <div class="form-group">
                                        <label for="content">Content</label>
                                        <textarea class="form-control" id="content" placeholder="{{$item->content}}" name="content" rows="3" required></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="image">Image</label>
                                        <input type="file" class="form-control-file" id="image" name="image"
                                               accept=".jpg,.png,.gif,.jpeg,.bmp,.webp,.svg,.ico,.tiff,.tif,.raw,.cr2,.nef,.orf,.sr2,.heic,.heif,.avif,.jfif,.pjpeg,.pjp,.webp2">
                                    </div>

                                </div>
                                <div class="modal-footer">
                                    <!-- Button to submit form -->
                                    <button type="submit" class="btn btn-primary" id="addItemBtn">Edit Item</button>
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
        {{$items->links()}}
    </div>

@endsection
