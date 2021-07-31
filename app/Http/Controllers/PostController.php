<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::latest()->get();

        return response()->json(
            [
                "success" => true,
                "message" => "List Data Post",
                "data" => $posts,
            ],
            200
        );
    }

    //to show detailed data by ID
    public function show($id)
    {
        $posts = Post::findOrFail($id);

        return response()->json(
            [
                "success" => true,
                "message" => "Detailed Data Post",
                "data" => $posts,
            ],
            200
        );
    }

    //to store data to database
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "title" => "required",
            "content" => "required",
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $post = Post::create([
            "title" => $request->title,
            "content" => $request->content,
        ]);

        if ($post) {
            return response()->json(
                [
                    "success" => true,
                    "message" => "Post Created",
                    "data" => $post,
                ],
                201
            );
        }

        return response()->json(
            [
                "success" => false,
                "message" => "Post Failed To Save",
            ],
            409
        );
    }

    //to update the posts
    public function update(Request $request, Post $post)
    {
        $validator = Validator::make($request->all(), [
            "title" => "required",
            "content" => "required",
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $post = Post::findOrFail($post->id);

        if ($post) {
            $post->update([
                "title" => $request->title,
                "content" => $request->content,
            ]);

            return response()->json(
                [
                    "success" => true,
                    "message" => "Post Updated",
                    "data" => $post,
                ],
                200
            );
        }

        return response()->json(
            [
                "success" => false,
                "message" => "Post Not Found",
            ],
            404
        );
    }

    //to delete the post
    public function destroy($id)
    {
        $post = Post::findOrFail($id);

        if ($post) {
            $post->delete();

            return response()->json(
                [
                    "success" => true,
                    "message" => "Post Deleted",
                ],
                200
            );
        }

        return response()->json(
            [
                "success" => false,
                "message" => "Post Not Found",
            ],
            404
        );
    }
}
