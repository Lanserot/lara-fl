<?php

declare(strict_types=1);

namespace Buisness\File\Security;

use App\Enums\RolePermissionsEnum;
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
            $user_repository->getEntityById(auth('api')->user()->getAuthIdentifier())->getRoleId(),
            'api'
        );
        //TODO: вынести APP
        if(!$role->hasAnyPermission([
            RolePermissionsEnum::API->value,
            RolePermissionsEnum::API_USER->value
        ])){
            return false;
        }

        return true;
    }
}
