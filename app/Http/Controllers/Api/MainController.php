<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Post;
use Illuminate\Http\Request;

class MainController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $posts = Post::get();

        if ($posts->count() > 0) {
            foreach ($posts as &$post) {
                $post->comments;
                $post->likes;
                $post->author;
                $post->images;
            }

            return response()->json([
                'success' => true,
                'data' => $posts
            ], 200);
        }

        return response()->json([
            'success' => false,
            'message' => 'Posts not found'
        ], 404);
    }
}
