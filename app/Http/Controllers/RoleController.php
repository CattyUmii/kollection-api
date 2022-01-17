<?php

namespace App\Http\Controllers;

use App\Http\Resources\RoleResource;
use App\Models\Role;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class RoleController extends Controller {

    public function index(): JsonResponse {

        $roles = RoleResource::collection(Role::with("users")->get());
        return response()->json($roles);
    }

    public function show($id): JsonResponse {

        $role = new RoleResource(Role::with("users")->findOrFail($id));
        return response()->json($role);
    }

    public function store(Request $request): JsonResponse {

        $request->validate([
            'name' => 'required'
        ]);

        $new_role = new RoleResource(Role::create($request->all()));
        return response()->json($new_role);

    }

    public function update(Request $request, $roleId): JsonResponse {

        $request->validate([
            'name' => 'required'
        ]);

        $role = Role::findOrFail($roleId);
        $role->update($request->all());

        return response()->json($role);

    }

    public function delete($id) {

    }

}
