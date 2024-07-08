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
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Infrastructure\Interfaces\User\IUserEntity;
use Infrastructure\Interfaces\User\IUserInfoEntity;
use Infrastructure\Interfaces\User\IUserMapper;
use Infrastructure\Interfaces\User\IUserRepository;

class UserRepository implements IUserRepository
{
    private IUserMapper $user_mapper;

    public function __construct(IUserMapper $user_mapper)
    {
        $this->user_mapper = $user_mapper;
    }

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
            new NullUserInfoEntity()
        );
    }

    public function save(UserVO $user): bool
    {
        DB::beginTransaction();
        try {
            $user = User::create($this->user_mapper->VoToArray($user));
            $this->last_id = $user->id;
            DB::commit();
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            DB::rollback();
            return false;
        }

        return true;
    }

    public function getEntityById(int $id): IUserEntity
    {
        $user = User::find($id);
        if (!$user) {
            return new NullUserEntity();
        }
        $user_info_entity = $this->getUserInfoByIdEntity($id);

        return new UserEntity(
            $user->login,
            $user->email,
            $user->id,
            $user->role_id,
            $user_info_entity
        );
    }

    public function getLastId(): int
    {
        $last_id = $this->last_id;
        $this->last_id = 0;
        return $last_id;
    }

    public function update(Model $user_update): bool
    {
        $old_user = User::find($user_update->id);
        DB::beginTransaction();
        try {
            $user_update->save();
            DB::commit();
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            $old_user->save();
            DB::rollback();
            return false;
        }

        return true;
    }

    public function getUserInfoByIdEntity(int $id): IUserInfoEntity
    {
        $user_info = UserInfo::getByUserIdOrCreate($id);
        if (is_null($user_info)) {
            return new NullUserInfoEntity();
        }
        return new UserInfoEntity(
            $user_info->name ?? '',
            $user_info->second_name ?? '',
            $user_info->description ?? '',
            $user_info->id,
            $user_info->avatar_id ?? 0,
        );
    }

    public function getModelById(int $id): ?Model
    {
        return User::find($id);
    }

    public function isExistFieldValue(string $field, mixed $value): bool
    {
        return User::query()->where($field, '=', $value)->exists();
    }
}
