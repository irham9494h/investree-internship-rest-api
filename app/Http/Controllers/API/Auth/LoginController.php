<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\API\APIController;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends APIController
{
    public function login(LoginRequest $request)
    {
        $validatedInput = $request->validated();

        if (!Auth::attempt($validatedInput)) {
            return $this->loginFailedResponse();
        } else {
            $token = Auth::user()->createToken('Investree API')->accessToken;
            return $this->loginSuccessResponse($token);
        }
    }

    public function logout()
    {
        $user = Auth::user()->token();
        $user->revoke();
        return $this->logoutSuccessResponse();
    }
}
