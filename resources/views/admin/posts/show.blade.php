@extends('layouts.admin')

@section('content')
    <img src="{{ asset('storage/'. $post->cover_image)}}" alt="{{$post->title}}" width="400">
    <h1>{{$post->title}}</h1>
    <div class="content">
        {{$post->content}}
    </div>
    <div class="category">
        Category: {{$post->category ? $post->category->name : 'Not assigned'}}
    </div>
    <div class="tags">
        @if(count($post->tags)>0)
            @foreach($post->tags as $tag)
                <span>
                    #{{$tag->name }}
                </span>
            @endforeach
        @else
            <span>Not assigned tags</span>
        @endif
    </div>
@stop