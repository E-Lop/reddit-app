<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    /**
     * List of all users
     */
    public function index()
    {
        return User::all();
    }

    /**
     * Stores a new user
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $user = User::create($data);

        return response()->json([
            'status' => 'success',
            'user' => $user,
        ]);
    }

    /**
     * Shows a specific user
     */
    public function show($id)
    {
        $user = User::find($id);

        if ($user === null) {
            return response()->json([
                'status' => 'error',
                'message' => 'User not found',
            ]);
        }

        return response()->json([
            'status' => 'success',
            'user' => $user,
        ]);
    }

    /**
     * Updates a specific user
     */
    public function update(Request $request, $id)
    {
        $data = $request->all();
        $selected_user = User::find($id);

        if ($selected_user === null) {
            return response()->json([
                'status' => 'error',
                'message' => 'User not found',
            ]);
        }

        $selected_user->update($data);
        return response()->json([
            'status' => 'success',
            'user' => $selected_user,
        ]);
    }

    /**
     * Deletes a specific user
     */
    public function destroy($id)
    {
        $user = User::find($id);

        if ($user === null) {
            return response()->json([
                'status' => 'error',
                'message' => 'User not found',
            ]);
        }

        $user->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'User deleted',
        ]);
    }
}
