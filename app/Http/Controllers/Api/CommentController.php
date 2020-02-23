<?php

namespace App\Http\Controllers\Api;

use App\Comment;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CommentController extends Controller
{
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
            'text' => 'required|string',
            'post_id' => 'required',
        ]);

        $user = auth()->user();
        $comment = Comment::create([
            'text' => $request->text,
            'post_id' => $request->post_id,
            'user_id' => $user->id,
        ]);

        if ($comment) {
            return response()->json([
                'success' => true,
                'data' => $comment
            ], 200);
        }

        return response()->json([
            'success' => false,
            'message' => 'Comment cannot be created'
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $comment = Comment::find($id);

        if ($comment) {
            return response()->json([
                'success' => true,
                'data' => $comment,
            ], 200);
        }

        return response()->json([
            'success' => false,
            'message' => 'Comment not found'
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
            'text' => 'required|string',
        ]);

        $comment = auth()->user()->comments->where('id', $id)->first();

        if ($comment) {
            if ($comment->update($request->all())) {
                return response()->json([
                    'success' => true,
                    'data' => $comment,
                ], 200);
            }
        }

        return response()->json([
            'success' => false,
            'message' => 'Comment not found'
        ], 404);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $user = auth()->user();
        $comment = auth()->user()->comments->where('id', $id)->first();

        if ($comment) {
            $comment->delete();

            return response()->json([
                'success' => true,
            ], 200);
        }

        return response()->json([
            'success' => false,
            'message' => 'Comment  not found'
        ], 404);
    }
}
