<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Buisness\User\Command\LoginUserCommand;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Infrastructure\User\Mapper\UserMapper;
use Tools\HttpStatuses;

class LoginController extends Controller
{
    private const USER_RULES = [
        User::FIELD_LOGIN => 'required|string|min:4|max:255',
        User::FIELD_PASSWORD => 'required|string|min:5',
    ];

    public function index()
    {
        return view('user/login');
    }

    /**
     * @throws Exception
     */
    public function get(Request $request): JsonResponse
    {
        $data = $request->all();
        $validator = Validator::make($data, self::USER_RULES);
        if ($validator->fails()) {
            return response()->json()->setStatusCode((HttpStatuses::BAD_REQUEST)->value);
        }
        return (new LoginUserCommand(
            (new UserMapper())->arrayLoginToVo($data))
        )->execute();
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('main');
    }
}
