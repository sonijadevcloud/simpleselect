<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Silber\Bouncer\Database\Ability;
use Silber\Bouncer\Database\Role;
use Auth;


class AdminPermissionController extends Controller
{
    public function index()
    {
        $permissions = Ability::all();
        $roles = Role::with('abilities')->get();

        return view('admin.permissions.index', compact('permissions', 'roles'));
    }

    public function createPermissionForm()
    {
        return redirect()->route('permissions.index');
    }

    public function storePermission(Request $request)
    {
        if (Auth::user()->can('AdminPrivilege-W')) {
            $request->validate([
                'name' => 'required|unique:abilities',
                'title' => 'required',
            ]);

            $permission = Ability::create($request->only('name', 'title'));

            return redirect()->route('permissions.index')->with('permission_success', 'Permission created successfully.');
        } else {
            // Jeżeli użytkownik nie ma wymaganego uprawnienia, możesz zwrócić 403 Forbidden lub przekierować gdzie indziej
            abort(403, 'You do not have sufficient authority to perform this action');
        }
    }

    public function createRoleForm()
    {
        $permissions = Ability::all();

        return redirect()->route('permissions.index');
    }

    public function storeRole(Request $request)
    {
        if (Auth::user()->can('AdminPrivilege-W')) {
            $request->validate([
                'name' => 'required|unique:roles',
                'title' => 'required',
                'permissions' => 'required|array',
            ]);

            $role = Role::create($request->only('name', 'title'));

            $role->allow($request->permissions);

            return redirect()->route('permissions.index')->with('role_success', 'Role created successfully.');
        } else {
            // Jeżeli użytkownik nie ma wymaganego uprawnienia, możesz zwrócić 403 Forbidden lub przekierować gdzie indziej
            abort(403, 'You do not have sufficient authority to perform this action');
        }
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
        if (Auth::user()->can('AdminPrivilege-W')) {
            $permission = Ability::findOrFail($id);

            $request->validate([
                'name' => 'required|unique:abilities,name,' . $permission->id,
                'title' => 'required',
            ]);

            $permission->update($request->only('name', 'title'));

            return redirect()->route('permissions.index')->with('permission_success', 'Permission updated successfully.');
        } else {
            // Jeżeli użytkownik nie ma wymaganego uprawnienia, możesz zwrócić 403 Forbidden lub przekierować gdzie indziej
            abort(403, 'You do not have sufficient authority to perform this action');
        }
    }

    public function updateRole(Request $request, $id)
    {
        if (Auth::user()->can('AdminPrivilege-W')) {
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
        
            // Pobierz obecne uprawnienia roli
            $currentPermissions = $role->abilities()->pluck('abilities.id')->toArray();
        
            // Znajdź uprawnienia, które należy odznaczyć (czyli te, które nie są już wybrane w formularzu)
            $permissionsToDisallow = array_diff($currentPermissions, $selectedPermissions);
        
            // Odznacz uprawnienia, które nie są już wybrane w formularzu
            $role->disallow($permissionsToDisallow);
        
            // Przypisz nowe uprawnienia
            $role->allow(Ability::whereIn('name', $selectedPermissions)->pluck('name')->all());
        
            return redirect()->route('permissions.index')->with('role_success', 'Role updated successfully.');
        } else {
            // Jeżeli użytkownik nie ma wymaganego uprawnienia, możesz zwrócić 403 Forbidden lub przekierować gdzie indziej
            abort(403, 'You do not have sufficient authority to perform this action');
        }
    }
    

}
