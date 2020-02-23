<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ImageHelper;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request)
    {
        $user = auth()->user();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'User not login or not found'
            ], 400);
        }

        $updated = $user->update($request->all());
        if ($updated) {
            ImageHelper::saveImage($request, $user);
            return response()->json([
                'success' => true
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'User could not be updated'
        ], 500);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function users()
    {
        return response()->json([
            'success' => true,
            'data' => User::where('id', '!=', auth()->user()->id)->get()
        ], 200);
    }

}
