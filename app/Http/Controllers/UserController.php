<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class UserController extends Controller
{
    public function findUser(Request $request){
        $user = DB::table('users')->select('name','email')->where(["email"=>$request->email])->get();
        return response()->json(['message'=>'success', 'user'=>$user]);

    }
}
