<?php

declare(strict_types=1);

namespace Buisness\User\Command;

use App\Enums\HttpStatuses;
use App\Models\User\User;
use Buisness\User\ValueObject\UserVO;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Infrastructure\BaseCommand;
use Infrastructure\Interfaces\User\IUserMapper;
use Infrastructure\Interfaces\User\IUserRepository;
use Infrastructure\Mapper\User\UserMapper;
use Infrastructure\Repositories\UserRepository;
use Infrastructure\Tools\JsonFormatter;

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
            return JsonFormatter::makeAnswer((HttpStatuses::ERROR)->value, $e->getMessage());
        }
        if ($user) {
            return JsonFormatter::makeAnswer((HttpStatuses::FOUND)->value);
        }
        /** @var UserRepository $user_repository */
        $user_repository = app(IUserRepository::class);

        try {
            $user = $user_repository->getById($this->id);
        }catch (\Exception $e) {
            return JsonFormatter::makeAnswer((HttpStatuses::ERROR)->value, $e->getMessage());
        }

        /** @var UserMapper $user_mapper */
        $user_mapper = app(IUserMapper::class);
        $user_array = $user_mapper->entityToArray($user);
        $user_array[UserVO::KEY_EMAIL] = $this->email;
        try {
            $user_repository->update($user_array);
        } catch (\Exception $e) {
            return JsonFormatter::makeAnswer((HttpStatuses::ERROR)->value, $e->getMessage());
        }
        return JsonFormatter::makeAnswer((HttpStatuses::SUCCESS)->value);
    }
}
