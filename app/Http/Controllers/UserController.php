<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades;
class UserController extends Controller
{

    function register(Request $req){
        $user = new User;
        $user->name = $req->input('name');
        $user->email= $req->input('email');
        $user->password = $req->input('password');
        $user->role = $req->input('role');
$user->save();
        return $user;
     }


    function login(Request $req){
        $user = User::where('email',$req->email)->first();
if(!isset($user->id)){
    return response([
        'error'=> ["Incorrect Email"],
        'Email'=>$user
    ]);
}
      else  if($req->password !== $user->password){
            return response([
                'error'=> ["Incorrect Password"]
            ]);
        }
        else if (isset($user->id) && $req->password === $user->password ){
            return response([
                'error'=> ["login"],
                'data'=>$user
            ]);
        }


 


    
    }
    












}
