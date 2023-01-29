<?php

namespace App\Actions;

use Exception;
use Illuminate\Http\Request;

class AuthAction
{

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
        if (!$token = auth()->attempt($credentials)) {
            throw new Exception('L\'utilisateur ou le mot passe sont incorrectes, veuillez reessayer!', ResponseDto::UNAUTHORIZED);
        }

        return $this->respondWithToken([
            'user' => $request->user(),
            'token' => $token
        ]);
    }

    public function logout()
    {
        return auth()->invalidate(true);
    }

    public function me()
    {
        return auth()->user();
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

    private function respondWithToken(array $data) : array
    {
        return [
            'access_token' => $data['token'],
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60 * 24,
            'user_info' => auth()->user(),
        ];
    }

}