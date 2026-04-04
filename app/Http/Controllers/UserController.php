<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use App\Http\Resources\UserResource;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::paginate(10);
        return response()->json($users);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserRequest $request)
    {
        $data = $request->validated();

        $user = User::create([
            'first_name'  => $data['first_name'],
            'last_name'   => $data['last_name'],
            'username'    => $data['username'],
            'roles'       => $data['roles'] ?? null,
            'permissions' => $data['permissions'] ?? null,
            'password'    => bcrypt($data['password']),
        ]);

        return response()->json([
            'message' => 'User created successfully',
            'user'    => $user
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        return new UserResource($user);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json([
                'message' => 'User not found'
            ], 404);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json([
                'message' => 'User not found'
            ], 404);
        }

        $user->delete();

        return response()->json([
            'message' => 'User deleted successfully'
        ], 200);
    }
}
