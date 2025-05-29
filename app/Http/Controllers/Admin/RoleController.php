<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Bouncer;
use Silber\Bouncer\Database\Role;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::orderBy('name')->paginate(10);
        return view('admin.roles.index', compact('roles'));
    }

    public function create()
    {
        return view('admin.roles.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|unique:roles,name',
            'title' => 'nullable|string',
        ]);

        Role::create($request->only('name', 'title'));

        return redirect()->route('admin.roles.index')->with('success', 'Rol creado correctamente.');
    }

    public function edit($id)
    {
        $role = Role::findOrFail($id);
        return view('admin.roles.edit', compact('role'));
    }

    public function update(Request $request, $id)
    {
        $role = Role::findOrFail($id);

        $request->validate([
            'name' => 'required|string|unique:roles,name,' . $role->id,
            'title' => 'nullable|string',
        ]);

        $role->update($request->only('name', 'title'));

        return redirect()->route('admin.roles.index')->with('success', 'Rol actualizado correctamente.');
    }

    public function destroy($id)
    {
        $role = Role::findOrFail($id);

        if (in_array($role->name, ['admin', 'admin_entrenador', 'entrenador', 'cliente'])) {
            return redirect()->route('admin.roles.index')->with('error', 'No se puede eliminar el rol "' . $role->name . '".');
        }
        $role->delete();

        return redirect()->route('admin.roles.index')->with('success', 'Rol eliminado correctamente.');
    }
}
