<?php

namespace App\Http\Controllers\User\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Buisness\User\Command\RegistrationUserCommand;
use Buisness\User\ValueObject\UserVO;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Infrastructure\Interfaces\IUserMapper;
use Infrastructure\Mapper\User\UserMapper;
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
        $validator = $this->validateData($validator);
        if($validator){
            return $validator;
        }
        if($data[UserVO::KEY_PASSWORD] != $data['password_repeat']){
            return response()->json(['message' => 'Diff password'])->setStatusCode((HttpStatuses::BAD_REQUEST)->value);
        }
        /** @var UserMapper $user_mapper */
        $user_mapper = app(IUserMapper::class);
        return (new RegistrationUserCommand(
            $user_mapper->arrayLoginToVoHash($data))
        )->execute();
    }

    public function update(Request $request): JsonResponse
    {
        $data = $request->all();
        $validator = Validator::make($data, [User::FIELD_EMAIL => self::USER_RULES[User::FIELD_EMAIL]]);
        if($validator = $this->validateData($validator)){
            return $validator;
        }
        return response()->json()->setStatusCode((HttpStatuses::ERROR)->value);
    }

    protected function validateData(\Illuminate\Validation\Validator $validator): ?JsonResponse
    {
        if ($validator->fails()) {
            $errors = $validator->errors();
            $message = '';
            foreach ($errors->all() as $error) {
                $message .= $error . ".";
            }
            return response()->json(['message' => $message])->setStatusCode((HttpStatuses::BAD_REQUEST)->value);
        }

        return null;
    }
}
