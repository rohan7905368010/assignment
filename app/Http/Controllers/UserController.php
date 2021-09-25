<?php
 
namespace App\Http\Controllers;
 
use App\User;
use Illuminate\Http\Request;
 
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
 
class UserController extends Controller
{
   public function index()
   {
       $users = User::all();
 
       return $users;
   }

   public function store(Request $request)
   {
        $validator = Validator::make($request->all(),[
            'email' => 'required|unique:users',
            'password' => 'required|max:8',
            'name' => 'required|max:20|min:2'
        ]);

        if( $validator->fails() ) {
            return response()->json($validator->messages()->all(),400);
        }

       $userData = $request->all();
       $user = User::create($userData);
 
       return $user;
   }
}