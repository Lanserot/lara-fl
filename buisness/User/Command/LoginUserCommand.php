<?php

declare(strict_types=1);


namespace Buisness\User\Command;


use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Tools\HttpStatuses;

/**
 * @see \Tests\Unit\buisness\User\Command\LoginUserCommandTest
 */
final class LoginUserCommand
{
    private array $data = [];

    /**
     * @throws \Exception
     */
    public function execute(): JsonResponse
    {
        if(empty($this->data)){
            throw new \Exception();
        }
        try {
            $user = User::where(User::FIELD_LOGIN, $this->data[User::FIELD_LOGIN])->first();
        } catch (\Exception $e) {
            return response()->json()->setStatusCode(HttpStatuses::ERROR);
        }
        if (!$user) {
            return response()->json()->setStatusCode(HttpStatuses::NOT_FOUND);
        }
        Auth::login($user);
        if (Auth::check()) {
            return response()->json()->setStatusCode(HttpStatuses::SUCCESS);
        }

        return response()->json()->setStatusCode(HttpStatuses::ERROR);
    }

    public function setData(array $data): self
    {
        $this->data = $data;
        return $this;
    }
}
