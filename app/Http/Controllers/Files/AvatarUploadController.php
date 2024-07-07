<?php

namespace App\Http\Controllers\Files;

use App\Http\Controllers\Controller;
use Buisness\File\AddAvatarStorageCommand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AvatarUploadController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->all();
        $format = implode(',', config('files.avatars.format'));
        $size = config('files.avatars.size');
        $validator = Validator::make($data, ['file' => 'required|file|mimes:'.$format.'|max:'.$size]);
        if($validator = \Infrastructure\Tools\Validator::validateData($validator)){
            return $validator;
        }
        return (new AddAvatarStorageCommand())
            ->setFileVO($request->file('file'))
            ->execute();
    }
}
