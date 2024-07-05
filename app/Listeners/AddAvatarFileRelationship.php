<?php

namespace App\Listeners;

use App\Events\AddAvatarFile;
use App\Models\User\UserInfo;

class AddAvatarFileRelationship
{
    public function handle(AddAvatarFile $event)
    {
        $user_info = UserInfo::firstOrCreate(['user_id' => auth('api')->user()->getAuthIdentifier()]);
        $user_info->avatar_id = $event->getFileId();
        $user_info->update();
    }
}
