<?php

namespace App\Http\Controllers\Api;

use App\Friend;
use App\Http\Controllers\Controller;
use App\Post;
use Illuminate\Http\Request;

class FriendController extends Controller
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
            'data' => array_merge($user->from->toArray(), $user->to->toArray())
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        if ($request->from_id && $request->to_id) {
            $friend = Friend::firstOrCreate([
                'from_id' => $request->from_id,
                'to_id' => $request->to_id,
            ]);

            if ($friend) {
                return response()->json([
                    'success' => true,
                    'data' => $friend
                ], 200);
            }
        }

        return response()->json([
            'success' => false,
            'Message' => 'Params from_id or to_id missing '
        ], 500);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        $friend = Friend::find($id);
        if ($friend) {
            if ($friend->update($request->all())) {
                return response()->json([
                    'success' => true,
                ], 200);
            }
        }

        return response()->json([
            'success' => false,
            'message' => 'Friend not find'
        ], 400);
    }
}
