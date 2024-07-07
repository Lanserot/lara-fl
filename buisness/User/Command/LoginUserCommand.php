<?php

declare(strict_types=1);


namespace Buisness\User\Command;


use Buisness\User\Entity\NullUserEntity;
use Symfony\Component\HttpFoundation\Response;
use Buisness\User\ValueObject\UserVO;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Infrastructure\BaseCommand;
use Infrastructure\Interfaces\User\IUserRepository;
use Infrastructure\Tools\JsonFormatter;
use Tymon\JWTAuth\Facades\JWTAuth;

/**
 * @see \Tests\Unit\buisness\User\Command\LoginUserCommandTest
 */
final class LoginUserCommand extends BaseCommand
{
    private IUserRepository $user_repository;

    private UserVO $user_vo;

    public function __construct(UserVO $user_vo)
    {
        $this->user_repository = app(IUserRepository::class);
        $this->user_vo = $user_vo;
    }

    /**
     * @throws \Exception
     */
    public function execute(): JsonResponse
    {
        if($this->user_vo->isNull()){
            throw new \Exception();
        }
        try {
            $user = $this->user_repository->getByLogin($this->user_vo);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return JsonFormatter::makeAnswer(Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        if ($user instanceof NullUserEntity) {
            return JsonFormatter::makeAnswer(Response::HTTP_NOT_FOUND);
        }

        $credentials = [
            'login' => $this->user_vo->getLogin(),
            'password' => $this->user_vo->getPassword()
        ];
        // TODO:проверить правильно jwt и логина
        $token = JWTAuth::attempt($credentials);
        auth()->attempt($credentials);
        if (!$token) {
            return response()->json(['error' => 'Unauthorized'], Response::HTTP_UNAUTHORIZED);
        }
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => JWTAuth::factory()->getTTL()  * 60 * 60 * 60
        ]);
    }
}
