<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use Laravel\Passport\Passport;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

use App\Models\User;

class UserController extends Controller
{
    public function store(UserRequest $request){

        $rules = $request->rules();

        $messages = $request->messages();

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) { // verify if validation fails
            return response()->json(['error' => $validator->errors()], 422);
        }

        $userNameExists = User::where('name', $request->name) ->first();
        $userEmailExist = User::where('email', $request->email) ->first();

        if($userNameExists){ // verify if user Name already exists
            return response()->json(['error' => 'Name already exists'], 422);
        }

        if($userEmailExist){ // verify if user Email already exists
            return response()->json(['error' => 'Email already exists'], 422);
        }

        $name = $request->filled('name') ? $request->name : 'Anonymous';
         // set default Anonymous name if name is empty

         $user = User::create([
             'name' => $name,
             'email' => $request->email,
             'password' => Hash::make($request->password),
         ]);

         return response()->json($user, 200);


    }

    /**
     * Handle a login request to the application and generate an access token.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request){
            // Validación personalizada sin usar UserRequest
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        // Intentar autenticar al usuario
        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $token = $user->createToken('TokenName')->accessToken;

            return response()->json(['token' => $token], 200);
        }

        return response()->json(['error' => 'Unauthorized'], 401);
    }
}
