@extends('layouts.admin')

@section('content')

<h1>All Tags</h1>

@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif


<div class="container pt-4">
    <div class="row">
        <div class="col pe-5">
            <form action="" method="post" class="d-flex align-items-center">
                @csrf
                <div class="input-group mb-3">
                    <input type="text" name="name" class="form-control" placeholder="New tag" aria-label="New tag" aria-describedby="button-addon2">
                    <button class="btn btn-outline-secondary" type="submit" id="button-addon2">Add</button>
                </div>
            </form>
        </div>
        <div class="col">

            <table class="table table-striped table-inverse table-responsive">
                <thead class="thead-inverse">
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Slug</th>
                        <th>Posts Count</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($tags as $tag)
                    <tr>
                        <td scope="row">{{$tag->id}}</td>
                        <td>
                            <form id="tag-{{$tag->id}}" action="{{route('admin.tags.update', $tag->slug)}}" method="post">
                                @csrf
                                @method('PATCH')
                                <input class="border-0 bg-transparent" type="text" name="name" value="{{$tag->name}}">
                            </form>

                        </td>
                        <td>{{$tag->slug}}</td>
                        <td><span class="badge badge-info bg-dark text-white">{{count($tag->posts)}}</span></td>
                        <td>
                            <button form="tag-{{$tag->id}}" type="submit" class="btn btn-primary mb-2" style="width:100%;">Update</button>
                            <!-- DELETE -->
                            <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#delete-post-{{ $tag->id }}" style="width:100%;">
                                Delete
                            </button>

                            <!-- Modal -->
                            <div class="modal fade" id="delete-post-{{$tag->id}}" tabindex="-1" role="dialog" aria-labelledby="modelTitle-{{$tag->id}}" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title"><span class="text-secondary">{{$tag->title}}</span>" </h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body text-secondary text-center">
                                            Are you sure?
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                            <form action="{{route('admin.tags.destroy', $tag->slug)}}" method="post">
                                                @csrf
                                                @method('DELETE')
                                                <input class="btn btn-danger" type="submit" value="Delete">
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td scope="row">No tags! Add your first tag.</td>

                    </tr>
                    @endforelse
                </tbody>
            </table>


        </div>

    </div>
</div>

@stop