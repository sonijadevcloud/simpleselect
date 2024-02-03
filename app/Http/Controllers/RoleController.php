<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Role;


class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::paginate(5);
        return view('admin.roles.index', compact('roles'));
    }

    public function create()
    {
        return view('admin.roles.create');
    }
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|unique:roles|max:255',
            'description' => 'nullable|max:1000',
        ]);

        $role = Role::create($validatedData);

        return redirect()->route('roles.index')->with('success', 'Role added successfully.');
    }
    public function show(Role $role)
    {
        return view('admin.roles.show', compact('role'));
    }
    public function edit(Role $role)
    {
        return view('admin.roles.edit', compact('role'));
    }
    public function update(Request $request, Role $role)
    {
        $role->fill($request->all());
        try {
            $role->save();
            return redirect()->route('roles.index')->with('success', 'Role edited successfully.');
        } catch (\Exception $e) {
            return redirect()->route('roles.index')->with('error', 'There was an error editing the role.');
        }
    }
    public function destroy(Role $role)
    {
        try {
            $role->delete();
            return redirect()->route('roles.index')->with('success', 'Role deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->route('roles.index')->with('error', 'There was an error deleting the role.');
        }
    }
}
