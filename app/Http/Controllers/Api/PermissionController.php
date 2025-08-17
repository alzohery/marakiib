<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Illuminate\Validation\ValidationException;

class PermissionController extends Controller
{
    public function __construct()
    {
        // حماية المسارات باستخدام middleware
        $this->middleware('permission:view permissions', ['only' => ['index', 'show']]);
        $this->middleware('permission:create permissions', ['only' => ['store']]);
        $this->middleware('permission:edit permissions', ['only' => ['update']]);
        $this->middleware('permission:delete permissions', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the permissions.
     */
    public function index()
    {
        $permissions = Permission::all();
        return response()->json($permissions);
    }

    /**
     * Store a newly created permission in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|unique:permissions,name',
            'guard_name' => 'nullable|string',
        ]);

        $permission = Permission::create([
            'name' => $request->name,
            'guard_name' => $request->guard_name ?? config('auth.defaults.guard'),
        ]);

        return response()->json([
            'message' => 'Permission created successfully.',
            'permission' => $permission,
        ], 201);
    }

    /**
     * Display the specified permission.
     */
    public function show(Permission $permission)
    {
        return response()->json($permission);
    }

    /**
     * Update the specified permission in storage.
     */
    public function update(Request $request, Permission $permission)
    {
        $request->validate([
            'name' => 'required|string|unique:permissions,name,' . $permission->id,
            'guard_name' => 'nullable|string',
        ]);

        $permission->update([
            'name' => $request->name,
            'guard_name' => $request->guard_name ?? config('auth.defaults.guard'),
        ]);

        return response()->json([
            'message' => 'Permission updated successfully.',
            'permission' => $permission,
        ]);
    }

    /**
     * Remove the specified permission from storage.
     */
    public function destroy(Permission $permission)
    {
        $permission->delete();

        return response()->json([
            'message' => 'Permission deleted successfully.'
        ], 204);
    }
}
