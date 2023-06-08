<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function listUser()
    {
        $user = User::all();

        if(empty($user)) {
            return response()->json([
                'error' => 'List User empty',
                'status' => 404
            ]);
        }

        return UserResource::collection($user);
    }

    public function updateNews($id, UserRequest $request)
    {
        $title = $request->input('title');

        $update = User::find($id);
        $update->update($request->validated());

        return response()->json([
            'message'=> "Change new User the $title",
            'status' => 201,
            'data' => new UserResource($update)
        ]);
    }

    public function userId($id)
    {
        $user = User::where('id', $id)->get();

        $checkArray = $user->toArray();

        if(empty($checkArray)) {
            return response()->json([
                'error' => 'Not Found',
                'status' => 404
            ]);
        }

        return UserResource::collection($user);
    }

    public function deleteUser($id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json([
                'error' => 'Not found',
                'status' => 404
            ]);
        }

        $user->delete();

        return response()->json([
            'message' => "$id id is deleted",
            'data' => new UserResource($user)
        ]);
    }
}
