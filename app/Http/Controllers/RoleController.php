<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Support\Facades\DB;


class RoleController extends Controller
{
    //
   public function index(){
    $this->authorize('viewAllRoles', Role::class);
    $pageTitle = 'Role Lists';
        $roles = Role::all();

        return view('roles.index', [
            'pageTitle' => $pageTitle,
            'roles' => $roles,
        ]);

    }

 public function store(Request $request){
    $this->authorize('manageRoles', Role::class);
    $request->validate([
        'name' => ['required'],
        'permissionIds' => ['required'],
    ]);

    DB::beginTransaction();
    try {
        $role = Role::create([
            'name' => $request->name,
        ]);

        $role->permissions()->sync($request->permissionIds);

        DB::commit();

        return redirect()->route('roles.index');
    } catch (\Throwable $th) {
        DB::rollBack();
        throw $th;
    }

    }

 public function edit($id){
    $this->authorize('manageRoles', Role::class);
    $pageTitle = 'Edit Role';
        $roles = Role::find($id);
        $permissions = Permission::all();
    return view('roles.edit', [
        'pageTitle' => $pageTitle,
        'role' => $roles,
        'permissions' => $permissions
    ]);

 }

 public function create(){
    $this->authorize('manageRoles', Role::class);
    $pageTitle = 'Add Role';
        $permissions = Permission::all();
        return view('roles.create', [
            'pageTitle' => $pageTitle,
            'permissions' => $permissions,
        ]);

 }

 public function destroy($id){
    $this->authorize('manageRoles', Role::class);
    $roles = Role::find($id);

    DB::beginTransaction();
    try {
        $roles->permissions()->detach();
        $roles->delete();

        DB::commit();

        return redirect()->route('roles.index');
    } 
    catch (\Throwable $th) {
        DB::rollBack();
        throw $th;
    }


 }

 public function delete($id){

    $pageTitle = 'Delete Role';
        $roles = Role::find($id);
        $this->authorize('manageRoles', Role::class);

        return view('roles.delete',[
            'pageTitle' => $pageTitle,
            'role' => $roles
        ]);

 }

 public function update($id, Request $request){
    $this->authorize('manageRoles', Role::class);
    $request->validate([
        'name' => ['required'],
        'permissionIds' => ['required'],
    ]);
    $roles = Role::find($id);

    DB::beginTransaction();
    try {
        $roles->update([
            'name' => $request->name,
        ]);
        $roles->permissions()->sync($request->permissionIds);

        DB::commit();

        return redirect()->route('roles.index');
    } catch (\Throwable $th) {
        DB::rollBack();
        throw $th;
    }

 }

 
}

