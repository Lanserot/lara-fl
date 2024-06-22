<?php

declare(strict_types=1);

namespace Buisness\User\Command;

use App\Models\User\User;
use Buisness\Enums\HttpStatuses;
use Buisness\User\ValueObject\UserVO;
use Illuminate\Auth\GenericUser;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Infrastructure\BaseCommand;
use Infrastructure\Interfaces\User\IUserMapper;
use Infrastructure\Interfaces\User\IUserRepository;
use Infrastructure\Mapper\User\UserMapper;
use Infrastructure\Repositories\UserRepository;
use Infrastructure\Tools\JsonFormatter;

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

    public function execute(): JsonResponse
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
                return JsonFormatter::makeAnswer(HttpStatuses::ERROR->value);
            }
        }catch (\Exception $e){
            Log::error($e->getMessage());
            return JsonFormatter::makeAnswer(HttpStatuses::ERROR->value);
        }
        $user_entity = $user_repository->getById($user_repository->getLastId());
        /** @var UserMapper $mapper */
        $mapper = app(IUserMapper::class);
        Auth::login(new GenericUser($mapper->entityToArray($user_entity)));
        if (Auth::check()) {
            return JsonFormatter::makeAnswer(HttpStatuses::SUCCESS->value);
        }
        return JsonFormatter::makeAnswer(HttpStatuses::ERROR->value);
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
        return JsonFormatter::makeAnswer((HttpStatuses::FOUND)->value, $message);
    }
}
