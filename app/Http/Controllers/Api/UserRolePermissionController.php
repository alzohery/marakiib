<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Validation\ValidationException;

class UserRolePermissionController extends Controller
{
    public function __construct()
    {
        // حماية المسارات باستخدام middleware
        $this->middleware('permission:manage user roles', ['only' => ['assignRole', 'revokeRole', 'getUserRoles']]);
        $this->middleware('permission:manage user permissions', ['only' => ['assignPermission', 'revokePermission', 'getUserPermissions']]);
    }

    /**
     * Assign a role to a user.
     */
    public function assignRole(Request $request, User $user)
    {
        $request->validate([
            'role_name' => 'required|string|exists:roles,name',
        ]);

        $role = Role::where('name', $request->role_name)->first();

        if (!$role) {
            return response()->json(['message' => 'Role not found.'], 404);
        }

        if ($user->hasRole($role)) {
            return response()->json(['message' => 'User already has this role.'], 400);
        }

        $user->assignRole($role);

        return response()->json([
            'message' => 'Role assigned to user successfully.',
            'user' => $user->load('roles'),
        ]);
    }

    /**
     * Revoke a role from a user.
     */
    public function revokeRole(Request $request, User $user)
    {
        $request->validate([
            'role_name' => 'required|string|exists:roles,name',
        ]);

        $role = Role::where('name', $request->role_name)->first();

        if (!$role) {
            return response()->json(['message' => 'Role not found.'], 404);
        }

        if (!$user->hasRole($role)) {
            return response()->json(['message' => 'User does not have this role.'], 400);
        }

        $user->removeRole($role);

        return response()->json([
            'message' => 'Role revoked from user successfully.',
            'user' => $user->load('roles'),
        ]);
    }

    /**
     * Assign a direct permission to a user.
     */
    public function assignPermission(Request $request, User $user)
    {
        $request->validate([
            'permission_name' => 'required|string|exists:permissions,name',
        ]);

        $permission = Permission::where('name', $request->permission_name)->first();

        if (!$permission) {
            return response()->json(['message' => 'Permission not found.'], 404);
        }

        if ($user->hasPermissionTo($permission)) {
            return response()->json(['message' => 'User already has this permission directly.'], 400);
        }

        $user->givePermissionTo($permission);

        return response()->json([
            'message' => 'Permission assigned to user directly successfully.',
            'user' => $user->load('permissions'),
        ]);
    }

    /**
     * Revoke a direct permission from a user.
     */
    public function revokePermission(Request $request, User $user)
    {
        $request->validate([
            'permission_name' => 'required|string|exists:permissions,name',
        ]);

        $permission = Permission::where('name', $request->permission_name)->first();

        if (!$permission) {
            return response()->json(['message' => 'Permission not found.'], 404);
        }

        if (!$user->hasPermissionTo($permission)) {
            return response()->json(['message' => 'User does not have this permission directly.'], 400);
        }

        $user->revokePermissionTo($permission);

        return response()->json([
            'message' => 'Permission revoked from user directly successfully.',
            'user' => $user->load('permissions'),
        ]);
    }

    /**
     * Get all roles assigned to a user.
     */
    public function getUserRoles(User $user)
    {
        return response()->json($user->getRoleNames()); // Returns a collection of role names
    }

    /**
     * Get all permissions assigned to a user (direct and via roles).
     */
    public function getUserPermissions(User $user)
    {
        return response()->json($user->getAllPermissions()->pluck('name')); // Returns a collection of permission names
    }

    public function getMainImageAttribute($value)
    {
        if (!$value) {
            return asset('images/default.png'); // صورة افتراضية
        }

        // لو القيمة URL كامل (http/https)
        if (filter_var($value, FILTER_VALIDATE_URL)) {
            return $value;
        }

        // لو بتبدأ بـ /storage أو storage -> رجّعها كاملة
        if (str_starts_with($value, '/storage') || str_starts_with($value, 'storage')) {
            return asset(ltrim($value, '/'));
        }

        // غير كده يبقى مجرد اسم ملف
        return asset('storage/cars/' . $value);
    }
}