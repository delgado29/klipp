<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class RoleController extends Controller
{
    // Obtener todos los roles
    public function index()
    {
        return response()->json(Role::all());
    }

   
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|unique:roles,name',
        ]);

        $role = Role::create($request->only('name'));

        return response()->json($role, Response::HTTP_CREATED);
    }

    
    public function show(Role $role)
    {
        return response()->json($role);
    }

   
    public function update(Request $request, Role $role)
    {
        $request->validate([
            'name' => 'required|string|unique:roles,name,' . $role->id,
        ]);

        $role->update($request->only('name'));

        return response()->json($role);
    }

    
    public function destroy(Role $role)
    {
        $role->delete();

        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}