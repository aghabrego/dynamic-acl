<?php

namespace DynamicAcl\Http\Controllers;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use DynamicAcl\ACL;
use DynamicAcl\Models\Role;
use DynamicAcl\Http\Requests\RoleRequest;

class RoleController extends Controller
{
    public function index()
    {
		$roles = Role::latest()->paginate();

        return view('dynamicACL::role.index',  compact('roles'));
    }

    public function create()
    {
        $permissions = ACL::getRoutes();

        return view('dynamicACL::role.create', compact('permissions'));
    }

    public function store(RoleRequest $request)
    {
        $permissions = $request->access;

        if (isset($permissions['fullAccess']) && $permissions['fullAccess'] == 0)
            Arr::forget($permissions, 'fullAccess');

		Role::create([
		    'name' => $request->name,
            'permissions' => $permissions
        ]);

        // flash()->success('پیغام', 'نقش با موفقیت ایجاد شد.');
        return redirect()->route('admin.roles.index');
    }

    public function edit(Role $role)
    {
        $permissions = ACL::getRoutes();

        return view('dynamicACL::role.edit',  compact('role', 'permissions'));
    }

    public function update(Role $role, RoleRequest $request)
    {
        $permissions = $request->access;

        if (isset($permissions['fullAccess']) && $permissions['fullAccess'] == 0)
            Arr::forget($permissions, 'fullAccess');

        $role->update([
            'name' => $request->name,
            'permissions' => $permissions
        ]);
        
        // flash()->success('پیغام', 'نقش با موفقیت بروزرسانی شد.');
        return redirect()->route('admin.roles.index');
    }

    public function destroy(Role $role)
    {
        $role->users()->sync([]);

        $role->delete();

        // flash()->success('', 'نقش با موفقیت حذف شد.');
        return back();
    }
}
