<?php

namespace App\Http\Controllers\Api;

use App\Helpers\LikeHelper;
use App\Http\Controllers\Controller;
use App\Like;
use Illuminate\Http\Request;

class LikeController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        if ($request->type) {
            $like = new LikeHelper($request->type);

            return response()->json([
                'success' => $like->attach($request->model_id)
            ], 200);
        }

        return response()->json([
            'success' => false,
            'message' => 'Param type not found'
        ], 500);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        return response()->json([
            'success' => LikeHelper::unattached($id)
        ], 200);
    }
}
