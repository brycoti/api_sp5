<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Models\DiceRoll;
use Laravel\Passport\Passport;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

use App\Models\User;
use Spatie\Permission\Traits\HasRoles;

class UserController extends Controller{

    use HasRoles;
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
         ])->assignRole('user');

         return response()->json($user, 201);
    }

    public function login(Request $request){ //

        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }


        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) { // Check if the credentials are correct
            $user = Auth::user();
            $token = $user->createToken('TokenName')->accessToken; // Create a token for the user

            return response()->json(['token' => $token], 200);
        }

        return response()->json(['error' => 'Unauthorized'], 401);
    }

    public function logout(){
        $user = Auth::user();
        
        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }

        $user->token()->revoke();

        return response()->json(['message' => 'Successfully logged out'], 200);
    }

    public function update (Request $request, $id){

        $user = User::find($id);

        if (!$user) { // verify if user  does  not exists
            return response()->json(['error' => 'User not found'], 404);
        }

        if ($user->id !== Auth::user()->id) { // Check if user is the same as the authenticated user.
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $editName = $request->filled('name') ? $request->name : 'Anonymous';

        if ($editName !== 'Anonymous' && User::where('name', $editName)->where('id', '!=', $user->id)->exists()) {
            return response()->json(['error' => 'Name is already in use'], 422);
        }

        if ($editName !== $user->name) { // If name is different, update the user.
            $user->update(['name' => $editName]);
            return response()->json($user, 200);
        }

        return response()->json(['message' => 'No changes were made.'], 200);  // If no changes were made, return 200.
    }

    public function index(){
        $users = User::all();

        $userNamesAndSuccessRates = $users->map(function ($user) {
            $roleNames = $user->getRoleNames();
            return [
                'name' => $user->name,
                'email' => $user->email,
                'email_verified_at' => $user->email_verified_at,
                'successRate' => $user->successRate,
                'wins' => $user->wins,
                'losses' => $user->losses,
                'gamesPlayed' => $user->gamesPlayed,
                'created_at' => $user->created_at,
                'updated_at' => $user->updated_at,
                'role' => $roleNames,
            ];
        });

        if ($userNamesAndSuccessRates->isEmpty()) {
            return response()->json(['error' => 'No users found'], 404);
        }

        return response()->json($userNamesAndSuccessRates, 200);
    }

    public function show($id){
        $user = User::find($id);

        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }

       $userRolls = DiceRoll::where('user_id', $user->id)->get();

        if ($userRolls->isEmpty()) {
            return response()->json(['error' => 'No rolls found'], 404);
        }

        return response()->json($userRolls, 200);

    }

    public function ranking(){
        
        $users = User::all();

        if ($users->isEmpty()) {
            return response()->json(['error' => 'No users found'], 404);
        }


        $averageSuccesRate = $users->map(function ($user) {
            return [
                'name' => $user->name,
                'successRate' => $user->successRate,
                'wins' => $user->wins,
                'losses' => $user->losses,
                'gamesPlayed' => $user->gamesPlayed,
            ];
        })->sortByDesc('successRate')->values(); // Sort the users by success rate in descending order

       
        return response()->json($averageSuccesRate, 200);
    }

    public function loser(){
        $user = User::orderBy('successRate', 'asc')->first();

        if (!$user) {
            return response()->json(['error' => 'No users found'], 404);
        }

        $loser = [
                'name' => $user->name,
                'successRate' => $user->successRate,
                'wins' => $user->wins,
                'losses' => $user->losses,
                'gamesPlayed' => $user->gamesPlayed,
        ];
        
        return response()->json($loser, 200);

    }

    public function winner(){
        $user = User::orderBy('successRate', 'desc')->first();

        if (!$user) {
            return response()->json(['error' => 'No users found'], 404);
        }

        $winner = [
            'name' => $user->name,
            'successRate' => $user->successRate,
            'wins' => $user->wins,
            'losses' => $user->losses,
            'gamesPlayed' => $user->gamesPlayed,
        ];
        
        return response()->json($winner, 200);
    }

}