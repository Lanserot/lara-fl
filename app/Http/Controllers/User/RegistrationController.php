<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Buisness\User\Command\LoginUserCommand;
use Buisness\User\Command\RegistrationUserCommand;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Infrastructure\User\Mapper\UserMapper;
use Tools\HttpStatuses;

class RegistrationController extends Controller
{
    private const USER_RULES = [
        User::FIELD_LOGIN => 'required|string|min:4|max:255',
        User::FIELD_PASSWORD => 'required|string|min:5',
        User::FIELD_EMAIL => 'required|email',
    ];

    public function index()
    {
        return view('user/registration');
    }

    public function post(Request $request): JsonResponse
    {
        $data = $request->all();
        $validator = Validator::make($data, self::USER_RULES);
        if ($validator->fails()) {
            return response()->json()->setStatusCode(HttpStatuses::NOT_BAD_REQUEST);
        }
        return (new RegistrationUserCommand(
            (new UserMapper())->arrayLoginToVo($data))
        )->execute();
    }
}
