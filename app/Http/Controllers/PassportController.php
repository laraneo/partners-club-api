<?php

namespace App\Http\Controllers;

use App\User;
use Storage;
use App\Repositories\ShareRepository;

use Illuminate\Http\Request;


class PassportController extends Controller
{
    public function __construct(ShareRepository $shareRepository)
    {
    $this->shareRepository = $shareRepository;
    }
   /**
     * Handles Registration Request
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|min:3',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
        ]);
 
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password)
        ]);
 
        $token = $user->createToken('TutsForWeb')->accessToken;
 
        return response()->json(['token' => $token], 200);
    }
 
    /**
     * Handles Login Request
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {   
        Storage::disk('partners')->put('testfile.txt','ContentTest');
        $header = $request->header();
        $credentials = [
            'username' => $request->username,
            'password' => $request->password
        ];
 
        if (auth()->attempt($credentials)) {
            $token = auth()->user()->createToken('TutsForWeb')->accessToken;
            $user = auth()->user();
            $user->roles = auth()->user()->getRoles();
            return response()->json(['token' => $token, 'user' =>  $user], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Credenciales incorrectas'
            ])->setStatusCode(401);
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
