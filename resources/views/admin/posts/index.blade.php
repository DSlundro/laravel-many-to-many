@extends('layouts.admin')

@section('content')
<div class="container">

    <div class="py-4">
        <h1>All Posts</h1>
        <div class="text-center"><a href="{{route('admin.posts.create')}}" class="btn btn-primary px-5">Add Post</a></div>
    </div>

    <table class="table table-striped table-inverse table-responsive">
        <thead class="thead-inverse">
            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Category</th>
                <th>Content</th>
                <th>Slug</th>
                <th>Cover Image</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($posts as $post)
            <tr>
                <td scope="row">{{$post->id}}</td>
                <td>{{$post->title}}</td>
                <td>{{$post->category ? $post->category->name : 'Not assigned'}}</td>
                <td width="400">{{mb_strimwidth($post->content, 0, 300, "...")}}</td>
                <td>{{$post->slug}}</td>
                <td><img width="150" src="{{ asset('storage/' . $post->cover_image)}}" alt="{{$post->title}}"></td>
                <td class="d-flex flex-column" style="gap: 10px"> 
                    <a class="btn btn-primary" href="{{ route('admin.posts.show', $post->slug) }}">View</a>
                    <a class="btn btn-warning" href="{{ route('admin.posts.edit', $post->slug) }}">Edit</a>
                    <!-- DELETE -->
                <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#delete-post-{{ $post->id }}">
                    Delete
                </button>

                <!-- Modal -->
                <div class="modal fade" id="delete-post-{{$post->id}}" tabindex="-1" role="dialog" aria-labelledby="modelTitle-{{$post->id}}" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title"><span class="text-secondary">{{$post->title}}</span>" </h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body text-secondary text-center">
                                Are you sure?
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                <form action="{{route('admin.posts.destroy',$post->slug)}}" method="post">
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
                <td scope="row"> Nessun Post da mostrare!</td>
            </tr>
            @endforelse

        </tbody>
    </table>


</div>
@endsection
