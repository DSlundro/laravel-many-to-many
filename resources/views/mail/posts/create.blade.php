<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>New Post Created</title>
</head>
<body>

    <h1>Nuovo post creato</h1>

    <p><strong>Title:</strong>{{$post->title}}</p>

    <img src="{{ asset('storage/'. $post->cover_image)}}" alt="{{$post->title}}" width="400">
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

</body>
</html>