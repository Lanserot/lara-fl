<?php

declare(strict_types=1);

namespace Buisness\User\Command;

use App\Models\User;
use Buisness\User\Entity\UserEntity;
use Buisness\User\ValueObject\UserVO;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use Infrastructure\BaseCommand;
use Infrastructure\Repositories\UserRepository;
use Tools\HttpStatuses;

/**
 * Class RegistrationUserCommand
 * @package Buisness\User\Command
 */
class RegistrationUserCommand extends BaseCommand
{
    private UserVO $user_vo;

    public function __construct(UserVO $user_vo)
    {
        $this->user_vo = $user_vo;
    }

    public function execute()
    {
        $user = User::query()
            ->select([UserVO::KEY_LOGIN, UserVO::KEY_EMAIL])
            ->where(User::FIELD_LOGIN, '=', $this->user_vo->getLogin())
            ->orWhere(User::FIELD_EMAIL, '=', $this->user_vo->getEmail())
            ->first();
        if ($user) {
            return $this->returnError($user);
        }
        try {
            (new UserRepository())->save(
                new UserEntity(
                    Hash::make($this->user_vo->getPassword()),
                    $this->user_vo->getLogin(),
                    $this->user_vo->getEmail(),
                )
            );
        }catch (\Exception $e){
            return $this->jsonAnswer((HttpStatuses::ERROR)->value, $e->getMessage());
        }
        return $this->jsonAnswer((HttpStatuses::SUCCESS)->value);
    }

    private function returnError(Model $user): JsonResponse
    {
        $message = '';
        if ($user->login == $this->user_vo->getLogin()) {
            $message = 'login exist';
        }
        if ($user->email == $this->user_vo->getEmail()) {
            $message = 'Email exist';
        }
        return $this->jsonAnswer((HttpStatuses::FOUND)->value, $message);
    }
}
