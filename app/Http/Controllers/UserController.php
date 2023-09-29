<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;
class UserController extends Controller
{
    //
    public function index(){
        $a ='Users List';
        if(!Gate::allows('viewOtherUsersAndTheirRoles', User::class)){
            // $b = User::where()->get();
            return redirect()->route('home');
        } else{ 
    }
    $b =User::all();
        return view('users.index', [
            'pageTitle'=>$a, 
            'users' =>$b
    ]);
    }

    public function editRole($id){
        $a ='Edit Users Role';
        $b =User::findOrFail($id);
        $c =Role::all();

        return view('users.edit_role', ['pageTitle'=>$a, 
        'user' =>$b, 'roles' => $c ]);
    }

    public function updateRole($id, Request $request){

        $b =User::findOrFail($id);
        $e =['role_id'=>$request->role_id];
        $b->update($e);

        return redirect()->route('users.index');
        
    }
}
