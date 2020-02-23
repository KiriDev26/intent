<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ImageHelper;
use App\Http\Controllers\Controller;
use App\ImageToPost;
use Illuminate\Http\Request;

class ImageToPostController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        if ($request->id) {
            foreach (ImageHelper::saveImages($request) as $path) {
                ImageToPost::create([
                    'path' => $path,
                    'post_id' => $request->id
                ]);
            }

            return response()->json([
                'success' => true,
            ], 200);
        }

        return response()->json([
            'success' => false,
            'message' => 'id param not found'
        ], 404);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $image = ImageToPost::find($id);

        if ($image) {
            $image->delete();

            return response()->json([
                'success' => true,
            ], 200);
        }

        return response()->json([
            'success' => false,
            'message' => 'Iamge  not found'
        ], 404);
    }
}
