<?php

namespace App\Http\Controllers;

use Exception;
use App\Dtos\ResponseDto;
use Illuminate\Http\Request;
use App\Actions\AuthAction;

class AuthController extends Controller
{
    /**
     * AuthAction
     * @var mixed
     */
    private $authAction;

    public function __construct()
    {
        $this->authAction = new AuthAction();
    }

    public function login(Request $request)
    {
        try {
            $response = $this->authAction->login($request);
            return ResponseDto::success(ResponseDto::OK, $response);
        } catch (Exception $e) {
            return ResponseDto::error($e->getMessage(), $e->getCode());
        }
    }

    public function logout()
    {
        try {
            $this->authAction->logout();
            return ResponseDto::success(ResponseDto::OK, [], 'Successfully logged out');
        } catch (Exception $e) {
            return ResponseDto::error($e->getMessage(), $e->getCode());
        }
    }

    public function me()
    {
        try {
            $response = $this->authAction->me();
            return ResponseDto::success(ResponseDto::OK, $response);
        } catch (Exception $e) {
            return ResponseDto::error($e->getMessage(), $e->getCode());
        }
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
