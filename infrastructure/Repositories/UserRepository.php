<?php

declare(strict_types=1);

namespace Infrastructure\Repositories;

use App\Models\User\User;
use App\Models\User\UserInfo;
use Buisness\User\Entity\NullUserEntity;
use Buisness\User\Entity\UserEntity;
use Buisness\User\ValueObject\UserVO;
use Buisness\UserInfo\Entity\NullUserInfoEntity;
use Buisness\UserInfo\Entity\UserInfoEntity;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Infrastructure\Interfaces\User\IUserEntity;
use Infrastructure\Interfaces\User\IUserInfoEntity;
use Infrastructure\Interfaces\User\IUserRepository;

class UserRepository implements IUserRepository
{
    private int $last_id = 0;

    public function getByLogin(UserVO $user_vo): IUserEntity
    {
        $user = User::query()
            ->where(User::FIELD_LOGIN, '=', $user_vo->getLogin())
            ->first();
        if (!$user || $user[UserVO::KEY_PASSWORD] != Hash::check($user_vo->getPassword(), $user->password)) {
            return new NullUserEntity();
        }
        $user = $user->toArray();
        return new UserEntity(
            $user[userVO::KEY_LOGIN],
            $user[userVO::KEY_EMAIL],
            $user[userVO::KEY_ID],
            $user[userVO::KEY_ROLE_ID],
        );
    }

    public function save(UserVO $user): bool
    {
        DB::beginTransaction();
        try {
            $user = User::create($user->toArray());
            $this->last_id = $user->id;
            DB::commit();
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            DB::rollback();
            return false;
        }

        return true;
    }

    public function getById(int $id): IUserEntity
    {
        $user = User::find($id);
        if (!$user) {
            return new NullUserEntity();
        }
        return new UserEntity(
            $user->login,
            $user->email,
            $user->id,
            $user->role_id,
        );
    }

    public function getLastId(): int
    {
        $last_id = $this->last_id;
        $this->last_id = 0;
        return $last_id;
    }

    public function update(array $user_update): bool
    {
        $user_old = User::find($user_update[User::FIELD_ID]);
        $user_new = clone $user_old;
        $user_new[User::FIELD_EMAIL] = $user_update[User::FIELD_EMAIL];
        DB::beginTransaction();
        try {
            $user_new->save();
            DB::commit();
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            $user_old->save();
            DB::rollback();
            return false;
        }

        return true;
    }

    public function getUserInfoByUserId(int $id): IUserInfoEntity
    {
        $user_info = UserInfo::getByUserIdOrCreate($id);
        if (!$user_info) {
            return new NullUserInfoEntity();
        }
        return new UserInfoEntity(
            $user_info->name ?? '',
            $user_info->second_name ?? '',
            $user_info->description ?? '',
            $user_info->id,
        );
    }
}
