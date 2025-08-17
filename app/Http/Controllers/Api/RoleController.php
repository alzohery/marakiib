<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Validation\ValidationException;

class RoleController extends Controller
{
    public function __construct()
    {
        // حماية المسارات باستخدام middleware
        // يمكن تعديل هذه الصلاحيات حسب احتياجاتك
        $this->middleware('permission:view roles', ['only' => ['index', 'show']]);
        $this->middleware('permission:create roles', ['only' => ['store']]);
        $this->middleware('permission:edit roles', ['only' => ['update']]);
        $this->middleware('permission:delete roles', ['only' => ['destroy']]);
        $this->middleware('permission:assign permissions to roles', ['only' => ['assignPermission', 'revokePermission']]);
    }

    /**
     * Display a listing of the roles.
     */
    public function index()
    {
        $roles = Role::with('permissions')->get();
        return response()->json($roles);
    }

    /**
     * Store a newly created role in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|unique:roles,name',
            'guard_name' => 'nullable|string',
        ]);

        $role = Role::create([
            'name' => $request->name,
            'guard_name' => $request->guard_name ?? config('auth.defaults.guard'),
        ]);

        return response()->json([
            'message' => 'Role created successfully.',
            'role' => $role,
        ], 201);
    }

    /**
     * Display the specified role.
     */
    public function show(Role $role)
    {
        $role->load('permissions');
        return response()->json($role);
    }

    /**
     * Update the specified role in storage.
     */
    public function update(Request $request, Role $role)
    {
        $request->validate([
            'name' => 'required|string|unique:roles,name,' . $role->id,
            'guard_name' => 'nullable|string',
        ]);

        $role->update([
            'name' => $request->name,
            'guard_name' => $request->guard_name ?? config('auth.defaults.guard'),
        ]);

        return response()->json([
            'message' => 'Role updated successfully.',
            'role' => $role,
        ]);
    }

    /**
     * Remove the specified role from storage.
     */
    public function destroy(Role $role)
    {
        $role->delete();

        return response()->json([
            'message' => 'Role deleted successfully.'
        ], 204);
    }

    /**
     * Assign a permission to a role.
     */
    public function assignPermission(Request $request, Role $role)
    {
        $request->validate([
            'permission_name' => 'required|string|exists:permissions,name',
        ]);

        $permission = Permission::where('name', $request->permission_name)->first();

        if (!$permission) {
            return response()->json(['message' => 'Permission not found.'], 404);
        }

        if ($role->hasPermissionTo($permission)) {
            return response()->json(['message' => 'Role already has this permission.'], 400);
        }

        $role->givePermissionTo($permission);

        return response()->json([
            'message' => 'Permission assigned to role successfully.',
            'role' => $role->load('permissions'),
        ]);
    }

    /**
     * Revoke a permission from a role.
     */
    public function revokePermission(Request $request, Role $role)
    {
        $request->validate([
            'permission_name' => 'required|string|exists:permissions,name',
        ]);

        $permission = Permission::where('name', $request->permission_name)->first();

        if (!$permission) {
            return response()->json(['message' => 'Permission not found.'], 404);
        }

        if (!$role->hasPermissionTo($permission)) {
            return response()->json(['message' => 'Role does not have this permission.'], 400);
        }

        $role->revokePermissionTo($permission);

        return response()->json([
            'message' => 'Permission revoked from role successfully.',
            'role' => $role->load('permissions'),
        ]);
    }
}
