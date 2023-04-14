<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Auth\AuthRequest;
use App\Http\Requests\Api\Auth\RegisterRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60 * 24 * 30
        ]);
    }

    public function login(AuthRequest $request)
    {
        $data = $request->validated();
        $user = User::where('login', $data['login'])->first();

        if (!Hash::check($data['password'], $user->password)) {
            return $this->response('Incorrect password', 403);
        }

        $token = auth()->attempt($data);
        return $this->response(['token' => $this->respondWithToken($token), 'user' => $user], 200);
    }

    public function register(RegisterRequest $request)
    {
        $data = $request->validated();
        $data['password'] = Hash::make($data['password']);
        $user = User::create($data);

        $token = auth()->attempt($data);
        return $this->response(['token' => $token->respondWithToken($token), 'user' => $user]);
    }

    public function logout()
    {
        auth()->logout();
        return $this->response([], 200);
    }
}
