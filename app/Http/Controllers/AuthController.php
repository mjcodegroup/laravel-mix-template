<?php

namespace App\Http\Controllers;

use App\Dtos\ResponseDto;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
        if (!$token = auth()->attempt($credentials)) {
            return ResponseDto::error('L\'utilisateur ou le mot passe sont incorrectes, veuillez reessayer!', ResponseDto::UNAUTHORIZED);
        }

        return $this->respondWithToken([
            'user' => $request->user(),
            'token' => $token
        ]);
    }

    public function logout()
    {
        auth()->invalidate(true);
        return ResponseDto::success(ResponseDto::OK, [], 'Successfully logged out');
    }

    public function me()
    {
        return ResponseDto::success(ResponseDto::OK, auth()->user());
    }


    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken([
            'user' => null,
            'token' => auth()->refresh()
        ]);
    }

    public function respondWithToken($data, $withUser = true)
    {
        $data = [
            'access_token' => $data['token'],
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60 * 24,
            'user_info' => auth()->user(),
        ];
        return ResponseDto::success(ResponseDto::OK, $data);
    }
}
