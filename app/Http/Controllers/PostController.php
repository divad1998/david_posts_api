<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class PostController extends Controller
{
    //Fetch all posts
    function index(){
        $userId = auth()->id();
        $posts = Post::where('user_id', $userId)->get();

        return response()->json([
            'status' => true, 'message' => "Posts fetched successfully.", 
            'data' => $posts
        ]);
    }

    // Store a newly created post
    function store(Request $request){
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string'
        ]);

        $post = new Post;
        $post->title = $request->title;
        $post->content = $request->content;
        $post->user_id = auth()->id();
        $post->save();

        return response()->json([
            'status' => true, 'message' => "Post created successfully."
        ], 201); 
    }

    // Fetch a specific post
    function show($id){
        $userId = auth()->id();
        $post = Post::where(['id'=>$id, 'user_id' => $userId])->first();
        if(!$post) {
            return response()->json([
                'status' => false, 
                'message' => "Invalid post, or, you don't own this post.", 
                ],404);
        }

        return response()->json([
            'status' => true, 
            'message' => "Post fetched successfully.", 'data' => $post
        ]);
    }

    // Update a specific post
    function update(Request $request, $id){
        $userId = auth()->id();
        $post = Post::where(['id' => $id, 'user_id' => $userId])->first();
        if (!$post) {
            return response()->json([
                'status' => false, 'message' => "Invalid post, or, you don't own this post."
            ],404);
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        $post->title = $request->title; $post->content = $request->content;
        $post->save();

        return response()->json([
            'status' => true, 'message' => "Post updated successfully.", 'data' => $post
            ]);
    }

    // delete a specific post
    function destroy($id){
        $userId = auth()->id();
        $post = Post::where(['id' => $id, 'user_id' => $userId])->first();
        if (!$post) {
            return response()->json([
                'status' => false, 'message' => "Invalid post, or, you don't own this post."
            ], 404);
        }
        $post->delete();

        return response()->json([
            'status' => true, 'message' => "Post deleted successfully."
        ]);
    }
}
