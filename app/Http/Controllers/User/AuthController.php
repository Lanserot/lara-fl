<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User\User;
use Buisness\Enums\HttpStatuses;
use Buisness\User\Command\LoginUserCommand;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Infrastructure\Interfaces\User\IUserMapper;
use Infrastructure\Mapper\User\UserMapper;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
        private const USER_RULES = [
        User::FIELD_LOGIN => 'required|string|min:4|max:255',
        User::FIELD_PASSWORD => 'required|string|min:5',
    ];

    public function login(Request $request): JsonResponse
    {
        $data = $request->all();
        $validator = Validator::make($data, self::USER_RULES);
        if ($validator->fails()) {
            return response()->json()->setStatusCode((HttpStatuses::BAD_REQUEST)->value);
        }
        /** @var UserMapper $user_mapper */
        $user_mapper = app(IUserMapper::class);
        return (new LoginUserCommand($user_mapper->arrayLoginToVo($data)))->execute();
    }

    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login']]);
    }

    public function me(): JsonResponse
    {
        return response()->json(auth()->user());
    }

    public function refresh(): JsonResponse
    {
        return $this->respondWithToken(auth()->refresh());
    }

    protected function respondWithToken(string $token): JsonResponse
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => JWTAuth::factory()->getTTL() * 60 * 60 * 60
        ])->setStatusCode((HttpStatuses::SUCCESS)->value);
    }
}
