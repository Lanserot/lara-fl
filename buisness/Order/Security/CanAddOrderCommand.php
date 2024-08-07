<?php

declare(strict_types=1);

namespace Buisness\Order\Security;

use Infrastructure\BaseCommand;
use Infrastructure\Enums\RolePermissionsEnum;
use Infrastructure\Interfaces\User\IUserRepository;
use Infrastructure\Repositories\UserRepository;
use Spatie\Permission\Models\Role;

/**
 * Class CanAddOrderCommand
 * @package Buisness\Order\Security
 */
class CanAddOrderCommand extends BaseCommand
{
    public function execute(): bool
    {
        //TODO:: исправить выборку роли
        /** @var UserRepository $user_repository */
        $user_repository = app(IUserRepository::class);
        $role = Role::findById(
            $user_repository->getEntityById(auth('api')->user()->getAuthIdentifier())->getRoleId(),
            'api'
        );

        return $role->hasAnyPermission([
            RolePermissionsEnum::API->value,
            RolePermissionsEnum::API_USER->value
        ]);
    }
}
