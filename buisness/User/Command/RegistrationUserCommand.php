<?php

declare(strict_types=1);

namespace Buisness\User\Command;

use App\Models\User;
use Buisness\User\ValueObject\UserVO;
use Illuminate\Auth\GenericUser;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Infrastructure\BaseCommand;
use Infrastructure\Interfaces\IUserMapper;
use Infrastructure\Interfaces\User\IUserRepository;
use Infrastructure\Mapper\User\UserMapper;
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
        //TODO:вынести app из бизнеса
        $user = User::query()
            ->select([UserVO::KEY_LOGIN, UserVO::KEY_EMAIL])
            ->where(User::FIELD_LOGIN, '=', $this->user_vo->getLogin())
            ->orWhere(User::FIELD_EMAIL, '=', $this->user_vo->getEmail())
            ->first();
        if ($user) {
            return $this->returnError($user);
        }
        try {
            /** @var UserRepository $user_repository */
            $user_repository = app(IUserRepository::class);
            if(!$user_repository->save($this->user_vo)){
                return $this->jsonAnswer((HttpStatuses::ERROR)->value);
            }
        }catch (\Exception $e){
            return $this->jsonAnswer((HttpStatuses::ERROR)->value, $e->getMessage());
        }
        $user_entity = $user_repository->getById($user_repository->getLastId());
        /** @var UserMapper $mapper */
        $mapper = app(IUserMapper::class);
        Auth::login(new GenericUser($mapper->entityToArray($user_entity)));
        if (Auth::check()) {
            return $this->jsonAnswer((HttpStatuses::SUCCESS)->value);
        }
        return $this->jsonAnswer((HttpStatuses::ERROR)->value);
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
