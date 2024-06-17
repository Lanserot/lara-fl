<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Buisness\User\Command\LoginUserCommand;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Infrastructure\Interfaces\IUserMapper;
use Infrastructure\Mapper\User\UserMapper;
use Tools\HttpStatuses;

class LoginController extends Controller
{
    private const USER_RULES = [
        User::FIELD_LOGIN => 'required|string|min:4|max:255',
        User::FIELD_PASSWORD => 'required|string|min:5',
    ];

    public function index(): View|\Illuminate\Foundation\Application|Factory|Application
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
        /** @var UserMapper $user_mapper */
        $user_mapper = app(IUserMapper::class);
        return (new LoginUserCommand($user_mapper->arrayLoginToVo($data)))->execute();
    }

    public function logout(): RedirectResponse
    {
        Auth::logout();
        return redirect()->route('main');
    }
}
