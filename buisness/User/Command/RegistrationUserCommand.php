<?php

declare(strict_types=1);

namespace Buisness\User\Command;

use App\Models\User\User;
use Symfony\Component\HttpFoundation\Response;
use Buisness\User\ValueObject\UserVO;
use Illuminate\Auth\GenericUser;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Infrastructure\BaseCommand;
use Infrastructure\Interfaces\User\IUserMapper;
use Infrastructure\Interfaces\User\IUserRepository;
use Infrastructure\Mapper\User\UserMapper;
use Infrastructure\Tools\JsonFormatter;

/**
 * Class RegistrationUserCommand
 * @package Buisness\User\Command
 */
class RegistrationUserCommand extends BaseCommand
{
    private IUserRepository $user_repository;

    private UserVO $user_vo;

    public function __construct(UserVO $user_vo)
    {
        $this->user_repository = app(IUserRepository::class);
        $this->user_vo = $user_vo;
    }

    public function execute(): JsonResponse
    {
        //TODO:вынести app из бизнеса
        if ($this->user_repository->isExistFieldValue(User::FIELD_LOGIN, $this->user_vo->getLogin())) {
            return JsonFormatter::makeAnswer(Response::HTTP_FOUND, User::FIELD_LOGIN);
        }
        if ($this->user_repository->isExistFieldValue(User::FIELD_EMAIL, $this->user_vo->getEmail())) {
            return JsonFormatter::makeAnswer(Response::HTTP_FOUND, User::FIELD_EMAIL);
        }

        if(!$this->user_repository->save($this->user_vo)){
            return JsonFormatter::makeAnswer(Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        $user_entity = $this->user_repository->getEntityById($this->user_repository->getLastId());
        /** @var UserMapper $mapper */
        $mapper = app(IUserMapper::class);

        Auth::login(new GenericUser($mapper->entityToArray($user_entity)));
        if (Auth::check()) {
            return JsonFormatter::makeAnswer(Response::HTTP_OK);
        }

        return JsonFormatter::makeAnswer(Response::HTTP_INTERNAL_SERVER_ERROR);
    }
}
