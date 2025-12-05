<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\StoreUserRequest;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use App\Helpers\ApiResponse;
use App\Http\Requests\User\UpdateUserRequest;
use Illuminate\Support\Facades\Storage;
class UserController extends Controller
{
    public function index()
    {
        $users = User::orderBy('id', 'desc')->paginate(10)
            ->through(function ($user) {
                return [
                    'id'=> $user->id,
                    'name'=> $user->name ?? null,
                    'email'=> $user->email ?? null,
                    'bio'=> $user->bio ?? null,
                    'imageUrl'=> isset($user->image_url) && Storage::disk('public')->exists($user->image_url) ? url("storage/{$user->image_url}") : null,
                    'location'=> $user->location ?? null,
                ];
            });


        return ApiResponse::success(
            "User Fetch successfully!",
            $users
        );
    }

    public function store(StoreUserRequest $request): JsonResponse
    {
        $data = $request->validated();

        // image optional
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('users', 'public');
        }

        // adapt fields to your users table
        $user = User::create([
            'name'     => $data['name'],
            'email'    => $data['email'],
            'password' => bcrypt('password'), // temp, or change later
            'location' => $data['location'] ?? null,
            'bio'      => $data['bio'] ?? null,
            // You can store interests/countries in JSON fields if you have them:
            // 'interests' => $data['interests'] ?? [],
            // 'countries' => $data['countries'] ?? [],
            // 'image_url' => $data['image'] ?? null,
            // 'interests' => json_encode($validated['interests'] ?? []),
            // 'countries' => json_encode($validated['countries'] ?? []),
            'image_url' => $imagePath ?? null,
        ]);

        return ApiResponse::success(
            "User Created successfully!",
            $user
        );
    }

    public function update(UpdateUserRequest $request, $id)
    {
        $user = User::find($id);

        if (!$user) {
            return ApiResponse::error(
                'User not found',
                404
            );
        }

        $data = $request->validated();

        // Image handling (optional)
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('users', 'public');
            $data['image_url'] = $path;
        }

        $user->update($data);

        return ApiResponse::success(
            "User updated successfully",
            $user
        );
    }


    public function destroy($id)
    {
        $user = User::find($id);

        if (!$user) {
            return ApiResponse::error(
                'User not found',
                404
            );
        }

        $user->delete();

        return ApiResponse::success(
            "User deleted successfully",
            User::orderBy('id', 'desc')->get()
        );
    }
}
