<?php

declare(strict_types=1);

namespace Buisness\Order\Security;

use App\Enums\Roles;
use Infrastructure\BaseCommand;
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
        /** @var UserRepository $user_repository */
        $user_repository = app(IUserRepository::class);
        $user_entity = $user_repository->getById(auth()->user()->getAuthIdentifier());
        if($user_entity->getRoleId() != Role::findByName((Roles::USER)->name)){
            return false;
        }

        return true;
    }
}
