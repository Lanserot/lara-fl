<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Buisness\User\Command\RegistrationUserCommand;
use Buisness\User\ValueObject\UserVO;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Infrastructure\User\Mapper\UserMapper;
use Tools\HttpStatuses;

/**
 * @see \Tests\Unit\app\Http\Controllers\User\UserControllerTest
 */
class UserController extends Controller
{
    private const USER_RULES = [
        User::FIELD_LOGIN => 'required|string|min:5|max:255',
        User::FIELD_PASSWORD => 'required|string|min:7',
        User::FIELD_EMAIL => 'required|email',
    ];

    public function store(Request $request): JsonResponse
    {
        $data = $request->all();
        $validator = Validator::make($data, self::USER_RULES);
        if ($validator->fails()) {
            $errors = $validator->errors();
            $message = '';
            foreach ($errors->all() as $error) {
                $message .= $error . ".";
            }
            return response()->json(['message' => $message])->setStatusCode(HttpStatuses::BAD_REQUEST);
        }
        if($data[UserVO::KEY_PASSWORD] != $data['password_repeat']){
            return response()->json(['message' => 'Diff password'])->setStatusCode(HttpStatuses::BAD_REQUEST);
        }
        return (new RegistrationUserCommand(
            (new UserMapper())->arrayLoginToVo($data))
        )->execute();
    }
}
