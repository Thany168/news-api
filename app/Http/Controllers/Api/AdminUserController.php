<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AdminUser;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;

class AdminUserController extends Controller
{
    // GET /api/admin-users
    public function index(): JsonResponse
    {
        return response()->json(
            AdminUser::orderBy('created_at', 'desc')
                ->get(['id', 'username', 'role', 'created_at'])
        );
    }

    // POST /api/admin-users
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'username' => 'required|string|unique:admin_users,username',
            'password' => 'required|string|min:6',
            'role'     => 'in:editor,superadmin',
        ]);
        $user = AdminUser::create([
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'role'     => $request->role ?? 'editor',
        ]);
        return response()->json($user, 201);
    }

    // DELETE /api/admin-users/{id}
    public function destroy(AdminUser $adminUser): JsonResponse
    {
        $adminUser->delete();
        return response()->json(['message' => 'deleted']);
    }

    // PATCH /api/admin-users/{id} — reset password
    public function resetPassword(Request $request, AdminUser $adminUser): JsonResponse
    {
        $request->validate(['password' => 'required|string|min:6']);
        $adminUser->update(['password' => Hash::make($request->password)]);
        return response()->json(['message' => 'password updated']);
    }

    // POST /api/auth/login
    public function login(Request $request): JsonResponse
    {
        $user = AdminUser::where('username', $request->username)->first();
        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(['error' => 'Invalid credentials'], 401);
        }
        // Return user info — Next.js stores this in a cookie/session
        return response()->json([
            'id'       => $user->id,
            'username' => $user->username,
            'role'     => $user->role,
        ]);
    }
}
