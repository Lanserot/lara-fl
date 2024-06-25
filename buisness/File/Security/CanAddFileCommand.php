<?php

declare(strict_types=1);

namespace Buisness\File\Security;

use App\Enums\RolePermissions;
use Infrastructure\BaseCommand;
use Infrastructure\Interfaces\User\IUserRepository;
use Infrastructure\Repositories\UserRepository;
use Spatie\Permission\Models\Role;

/**
 * Class CanAddOrderCommand
 * @package Buisness\File\Security
 */
class CanAddFileCommand extends BaseCommand
{
    public function execute(): bool
    {
        /** @var UserRepository $user_repository */
        $user_repository = app(IUserRepository::class);
        $role = Role::findById(
            $user_repository->getById(auth('api')->user()->getAuthIdentifier())->getRoleId(),
            'api'
        );
        //TODO: вынести APP
        if(!$role->hasAnyPermission([
            RolePermissions::API->value,
            RolePermissions::API_USER->value
        ])){
            return false;
        }

        return true;
    }
}
