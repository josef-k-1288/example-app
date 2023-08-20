<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index(){
        $posts = Post::latest()->with(['user', 'likes'])->paginate(20);

        // dd($posts);

        return view('posts.index', [
            'posts' => $posts
        ]);
    }

    public function store(Request $request){
        // dd('ok');

        //first validate
        $this->validate($request, [
            'body' => 'required'
        ]);

        // create post
        // $request->user()->posts()->create([ // prvi nacin
        //     'body' => $request->body
        // ]);

        $request->user()->posts()->create($request->only('body')); // drugi nacin

        return back();
    }

    public function destroy(Post $post)
    {
        $this->authorize('delete', $post);
        //dd($post);
        $post->delete();

        return back();
    }
}
