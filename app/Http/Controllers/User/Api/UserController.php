<?php

namespace App\Http\Controllers\User\Api;

use App\Http\Controllers\Controller;
use App\Models\User\User;
use Buisness\User\Command\EditUserCommand;
use Buisness\User\Command\RegistrationUserCommand;
use Buisness\User\ValueObject\UserVO;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Infrastructure\Enums\RolesEnum;
use Infrastructure\Interfaces\User\IUserMapper;
use Infrastructure\Mapper\User\UserMapper;
use Spatie\Permission\Models\Role;
use Symfony\Component\HttpFoundation\Response;

/**
 * @see \Tests\Unit\app\Http\Controllers\User\Api\UserControllerTest
 */
class UserController extends Controller
{
    private const USER_RULES = [
        User::FIELD_LOGIN => 'required|string|min:5|max:255',
        User::FIELD_PASSWORD => 'required|string|min:7',
        User::FIELD_EMAIL => 'required|email',
    ];

    public function show(int $id): JsonResponse
    {
        return response()->json(['message' => $id])->setStatusCode(Response::HTTP_OK);
    }

    public function destroy(int $id): JsonResponse
    {
        return response()->json(['message' => $id])->setStatusCode(Response::HTTP_OK);
    }

    public function store(Request $request): JsonResponse
    {
        $data = $request->all();
        $validator = \Infrastructure\Tools\Validator::validateData(Validator::make($data, self::USER_RULES));
        if($validator){
            return $validator;
        }
        if($data[UserVO::KEY_PASSWORD] != $data['password_repeat']){
            return response()->json(['message' => 'Diff password'])->setStatusCode(Response::HTTP_BAD_REQUEST);
        }
        /** @var UserMapper $user_mapper */
        $user_mapper = app(IUserMapper::class);
        $data['role_id'] = Role::findByName(RolesEnum::USER->value, 'api')->id;
        return (new RegistrationUserCommand(
            $user_mapper->arrayLoginToVoHash($data))
        )->execute();
    }

    public function update(Request $request, int $id): JsonResponse
    {
        $data = $request->all();
        $validator = Validator::make($data, [User::FIELD_EMAIL => self::USER_RULES[User::FIELD_EMAIL]]);
        if($validator = \Infrastructure\Tools\Validator::validateData($validator)){
            return $validator;
        }
        return (new EditUserCommand(
            $data[User::FIELD_EMAIL],
            $id
        ))->execute();
    }
}
