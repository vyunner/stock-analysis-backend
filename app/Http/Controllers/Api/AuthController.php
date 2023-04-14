<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Auth\AuthRequest;
use App\Http\Requests\Api\Auth\RegisterRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(AuthRequest $request)
    {
        $data = $request->validated();
        $user = User::where('login', $data['login'])->first();

        if (!Hash::check($data['password'], $user->password)) {
            return $this->response('Incorrect password', 403);
        }

        $token = $user->createToken('default');
        return $this->response(['token' => $token->plainTextToken, 'user' => $user], 200);
    }
    public function register(RegisterRequest $request)
    {
        $data = $request->validated();
        $data['password'] = Hash::make($data['password']);
        $user = User::create($data);
        $token = $user->createToken('default');

        return $this->response(['token' => $token->plainTextToken, 'user' => $user]);
    }
    public function logout(){
        return 12;
    }
}
