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

    $pageTitle = 'Role Lists';
        $roles = Role::all();

        return view('roles.index', [
            'pageTitle' => $pageTitle,
            'roles' => $roles,
        ]);

    }

 public function store(Request $request){

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
    $pageTitle = 'Edit Role';
        $roles = Role::find($id);
        // $this -> authorize('update', $roles);
        $permissions = Permission::all();
// dd($permissions);
    return view('roles.edit', [
        'pageTitle' => $pageTitle,
        'role' => $roles,
        'permissions' => $permissions
    ]);

 }

 public function create(){
    $pageTitle = 'Add Role';
        $permissions = Permission::all();
        return view('roles.create', [
            'pageTitle' => $pageTitle,
            'permissions' => $permissions,
        ]);

 }

 public function destroy($id){

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

        return view('roles.delete',[
            'pageTitle' => $pageTitle,
            'role' => $roles
        ]);

 }

 public function update($id, Request $request){

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

