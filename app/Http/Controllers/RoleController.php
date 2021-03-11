<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Role;

use Validator;

class RoleController extends Controller
{
    /**
     * Create a role
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function create(Request $request)
    {
        $validator = Validator::make($request->json()->all(), [
            'type' => 'required|string|max:255',
            'description' => 'string|max:255'
        ]);

        if($validator->fails()){
            return response()->json($validator->errors(), 400);
        }

        $role = Role::query()->create([
            'type' => $request->json()->get('type'),
            'description' =>$request->json()->get('description')
        ]);

        if(!$role) return response()->json([
            'message' => 'Failed to create role'
        ], 500);

        return response()->json([
            'message' => 'New role registered successfully',
            'role' => $role
        ], 201);
    }

    /**
     * Get all roles
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function all() 
    {
        return response()->json(Role::all());
    }

    /**
     * Show a certain role
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Role $role) : JsonResponse 
    {
        return response()->json($role);
    }
    /**
     * Edit a certain role
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function edit(Role $role, Request $request){
        $validator = Validator::make($request->json()->all(), [
            'type' => 'required|string|max:255',
            'description' => 'string|max:255'
        ]);

        if($validator->fails()) {
            return response()->json($validator->error(), 400);
        }

        $role->update($request->all());

        $role->save();

        return response()->json([
            'message' => 'Role updated successfully',
            'role' => $role
        ], 200);
    }

    /**
     * Delete role
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete(Role $role)
    {
        $role->delete();

        return response()->json([
            'message' => 'Role deleted successfully'
        ], 200);
    }
}
