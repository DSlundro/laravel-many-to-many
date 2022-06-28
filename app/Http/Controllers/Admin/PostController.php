<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Http\Requests\PostRequest;
use App\Mail\SendNewMail;
use App\Models\Category;
use App\Models\Tag;
use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::orderByDesc('id')->get();
        //dd($posts);
        return view('admin.posts.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $categories = Category::orderByDesc('id')->get();
        $tags = Tag::orderByDesc('id')->get();

        return view('admin.posts.create', compact('categories','tags'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PostRequest $request)
    {

        $val_data = $request->validated();
        $slug = Post::generateSlug($request->title);
        $val_data['slug'] = $slug;

        if($request->hasFile('cover_image')){
            //validation
            $request->validate([
                'cover_image' => 'nullable|image|max:1000'
            ]);
            //save
            //take path
            $path = Storage::put('post_images', $request->cover_image);


            //pass the path of array
            $val_data['cover_image'] = $path ;

        };

        $new_post = Post::create($val_data);
        $new_post->tags()->attach($request->tags );

        Mail::to($request->user())->send(new SendNewMail($new_post) );
        return redirect()->route('admin.posts.index')->with('message','Post Created Successfully');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        //
        return view('admin.posts.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        //
        $categories = Category::all();
        $tags = Tag::all();

        /* Metodo nel caso avessimo piu variabili  */
   /*      $data = [
            'post'=> $post,
            'category' => Category::all(),
            'tags' => Tag::all(),
        ]; */
        return view('admin.posts.edit', compact('post', 'categories', 'tags'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(PostRequest $request, Post $post)
    {
        //
        $val_data = $request->validated();

        $slug = Post::generateSlug($request->title);
        // old slug version
       /*  $slug = Str::slug($request->title,'-'); */
        $val_data['slug'] = $slug;

        if($request->hasFile('cover_image')){
            //validation
            $request->validate([
                'cover_image' => 'nullable|image|max:500'
            ]);
            //save
            Storage::delete($post->cover_image);
            //take path
            $path = Storage::put('post_images', $request->cover_image);


            //pass the path of array
            $val_data['cover_image'] = $path ;

        };

        $post->tags()->sync($request->tags);
        $post->update($val_data);


        return redirect()->route('admin.posts.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        //
        $post->delete();
        Storage::delete($post->cover_image);

        return redirect()->route('admin.posts.index')->with('message','Post Deleted Successfully');;
    }
}