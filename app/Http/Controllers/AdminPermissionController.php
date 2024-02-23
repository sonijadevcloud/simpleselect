<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Silber\Bouncer\Database\Ability;
use Silber\Bouncer\Database\Role;

class AdminPermissionController extends Controller
{
    public function index()
    {
        $permissions = Ability::paginate(10);
        $roles = Role::with('abilities')->paginate(10);
    
        return view('admin.permissions.index', compact('permissions', 'roles'));
    }

    public function createPermissionForm()
    {
        return redirect()->route('permissions.index');
    }

    public function storePermission(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:abilities',
            'title' => 'required',
        ]);

        $permission = Ability::create($request->only('name', 'title'));

        return redirect()->route('permissions.index')->with('permission_success', 'Permission created successfully.');
    }

    public function createRoleForm()
    {
        $permissions = Ability::all();

        return redirect()->route('permissions.index');
    }

    public function storeRole(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:roles',
            'title' => 'required',
            'permissions' => 'required|array',
        ]);

        $role = Role::create($request->only('name', 'title'));

        $role->allow($request->permissions);

        return redirect()->route('permissions.index')->with('role_success', 'Role created successfully.');
    }

    public function destroyPermission($id)
    {
        $permission = Ability::findOrFail($id);
        $permission->delete();

        return redirect()->route('permissions.index')->with('permission_success', 'Permission deleted successfully.');
    }

    public function destroyRole($id)
    {
        $role = Role::findOrFail($id);
        $role->delete();

        return redirect()->route('permissions.index')->with('role_success', 'Role deleted successfully.');
    }

    public function updatePermission(Request $request, $id)
    {
        $permission = Ability::findOrFail($id);

        $request->validate([
            'name' => 'required|unique:abilities,name,' . $permission->id,
            'title' => 'required',
        ]);

        $permission->update($request->only('name', 'title'));

        return redirect()->route('permissions.index')->with('permission_success', 'Permission updated successfully.');
    }

    public function updateRole(Request $request, $id)
    {
        $role = Role::findOrFail($id);
    
        $request->validate([
            'name' => 'required|unique:roles,name,' . $role->id,
            'title' => 'required',
            'permissions' => 'array', // Usuń "required" - może być puste, jeśli nie wybrano żadnych uprawnień
        ]);
    
        // Aktualizacja nazwy i opisu roli
        $role->update($request->only('name', 'title'));
    
        // Pobierz wybrane uprawnienia z formularza
        $selectedPermissions = $request->input('permissions', []);
    
        // Odznacz uprawnienia, które nie są już wybrane w formularzu
        $role->disallow($role->abilities()->pluck('abilities.id')->diff($selectedPermissions)->all());
    
        // Przypisz nowe uprawnienia
        $role->allow(Ability::whereIn('id', $selectedPermissions)->pluck('id')->all());
    
        return redirect()->route('permissions.index')->with('role_success', 'Role updated successfully.');
    }

}
