<?php

declare(strict_types=1);

namespace Buisness\User\Command;

use App\Models\User;
use Buisness\User\ValueObject\UserVO;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Infrastructure\BaseCommand;
use Infrastructure\Interfaces\IUserMapper;
use Infrastructure\Interfaces\User\IUserRepository;
use Infrastructure\Mapper\User\UserMapper;
use Infrastructure\Repositories\UserRepository;
use Tools\HttpStatuses;

/**
 * Class EditUserCommand
 * @package Buisness\User\Command
 */
class EditUserCommand extends BaseCommand
{
    private string $email;
    private int $id;

    public function __construct(string $email, int $id)
    {
        $this->email = $email;
        $this->id = $id;
    }

    public function execute(): JsonResponse
    {
        try {
            $user = DB::table('users')->where(User::FIELD_EMAIL, $this->email)->first();
        } catch (\Exception $e) {
            return $this->jsonAnswer((HttpStatuses::ERROR)->value, $e->getMessage());
        }
        if ($user) {
            return $this->jsonAnswer((HttpStatuses::FOUND)->value);
        }
        /** @var UserRepository $user_repository */
        $user_repository = app(IUserRepository::class);

        try {
            $user = $user_repository->getById($this->id);
        }catch (\Exception $e) {
            return $this->jsonAnswer((HttpStatuses::ERROR)->value, $e->getMessage());
        }

        /** @var UserMapper $user_mapper */
        $user_mapper = app(IUserMapper::class);
        $user_array = $user_mapper->entityToArray($user);
        $user_array[UserVO::KEY_EMAIL] = $this->email;
        try {
            $user_repository->update($user_array);
        } catch (\Exception $e) {
            return $this->jsonAnswer((HttpStatuses::ERROR)->value, $e->getMessage());
        }
        return $this->jsonAnswer((HttpStatuses::SUCCESS)->value);
    }
}
