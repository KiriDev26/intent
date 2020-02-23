<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ImageHelper;
use App\Http\Controllers\Controller;
use App\ImageToPost;
use App\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $user = auth()->user();

        return response()->json([
                'success' => true,
                'data' => $user->posts,
            ], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required|string',
            'text' => 'required|string'
        ]);

        $post = Post::create([
            'title' => $request->title,
            'text' => $request->text,
            'user_id' => auth()->user()->id,
        ]);

        if ($post) {
            foreach (ImageHelper::saveImages($request) as $path) {
                ImageToPost::create([
                    'path' => $path,
                    'post_id' => $post->id
                ]);
            }

            return response()->json([
               'success' => true,
               'data' => $post
            ], 200);
        }

        return response()->json([
            'success' => false,
            'message' => 'Post cannot be created'
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $user = auth()->user();
        $post = $user->posts->where('id', $id)->first();

        if ($post) {
            $post->comments;
            $post->images;
            return response()->json([
                'success' => true,
                'data' => $post,
            ], 200);
        }

        return response()->json([
            'success' => false,
            'message' => 'Post not found'
        ], 404);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'title' => 'required|string',
            'text' => 'required|string'
        ]);

        $user = auth()->user();
        $post = $user->posts->where('id', $id)->first();

        if ($post->update($request->all())) {
            return response()->json([
                'success' => true,
                'data' => $post
            ], 200);
        }

        return response()->json([
            'success' => false,
            'message' => 'Post cannot be updated'
        ], 201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $user = auth()->user();
        $post = $user->posts->where('id', $id)->first();

        if ($post) {
            $post->delete();

            return response()->json([
                'success' => true,
            ], 200);
        }

        return response()->json([
            'success' => false,
            'message' => 'Post  not found'
        ], 404);
    }
}
