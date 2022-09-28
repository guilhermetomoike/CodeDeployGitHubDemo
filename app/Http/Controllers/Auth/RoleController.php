<?php

namespace App\Http\Controllers\Auth;

use App\Http\Resources\RoleResource;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index()
    {
//        $this->authorize('cadastrar roles');
        $roles = Role::with(['permissions'])->get();
        return RoleResource::collection($roles);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $this->validate($request, ['name' => ['required', 'unique:roles,name']]);
        $role = Role::create(['guard_name' => 'api_usuarios', 'name' => $request->post('name')]);
        $role->syncPermissions($request->post('permissions'));
        return $this->created($role);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        $role = Role::with('permissions')->find($id);
        return response($role);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, ['permissions' => ['required']]);
        $role = Role::findById($id, 'api_usuarios')->syncPermissions($request->post('permissions'));
        return $this->successResponse($role);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        $deleted = Role::destroy($id);
        return $this->successResponse();
    }
}
