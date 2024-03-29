<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends ApiController
{
    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        if (Auth::attempt(['username' => $request->username, 'password' => $request->password])) {
            $user = $request->user();
            $token = $user->createToken('user-access-token');

            return $this->success(data: [
                'token' => $token->plainTextToken,
                'user' => $user,
            ]);
        }

        return $this->fail('Incorrect username or password', 401);
    }

    public function logout(Request $request)
    {
        $user = $request->user();
        $user->currentAccessToken()->delete();

        return $this->success();
    }

    public function getUser(Request $req)
    {
        $user = $req->user();

        return $this->json($user);
    }
}
