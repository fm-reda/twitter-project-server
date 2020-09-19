<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;


class PassportController extends Controller
{
    /**
     * Handles Registration Request
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request)
    {
        $userEmail = User::where('email', $request->get('email'))->first();

        if ($userEmail) {
            return response()->json(['Email already exist' => $userEmail], 208);
        }
        // dd($request->all());
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            // 'c_password' => 'required|same:password',

        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        }


        $input = $request->all();

        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);
    
        $user->save();
        $success['token'] =  $user->createToken('MyApp')->accessToken;
  
        $success['name'] =  $user->name;
        $success['email'] =  $user->email;


        return response()->json(['success' => $user], 201);

       
    }

    /**
     * Handles Login Request
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {

     
        if (Auth::attempt(['email' => request('email'), 'password' => request('password')])) {
     
            $user = Auth::user();
            // dd($user);
            $success['token'] =  $user->createToken('MyApp')->accessToken;
            $response = [
                'user' => Auth::User(),
                'access_token' => $success['token']
            ];
            return response()->json($response,200);
        } else {
            return response()->json(['status' =>401, 'error' => 'Invalid credentials'], $this->unauthorisedStatus);
        }
     
    }

    /**
     * Returns Authenticated User Details
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function details()
    {
        return response()->json(['user' => auth()->user()], 200);
    }
}
