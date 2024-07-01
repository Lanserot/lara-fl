<?php

declare(strict_types=1);

namespace Buisness\User\Command;

use App\Models\User\User;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Infrastructure\BaseCommand;
use Infrastructure\Interfaces\User\IUserRepository;
use Infrastructure\Tools\JsonFormatter;

/**
 * Class EditUserCommand
 * @package Buisness\User\Command
 */
class EditUserCommand extends BaseCommand
{
    private string $email;
    private int $id;

    private IUserRepository $user_repository;

    public function __construct(string $email, int $id)
    {
        $this->user_repository = app(IUserRepository::class);
        $this->email = $email;
        $this->id = $id;
    }

    public function execute(): JsonResponse
    {
        if (!$this->user_repository->isExistFieldValue(User::FIELD_ID, $this->id)) {
            return JsonFormatter::makeAnswer(Response::HTTP_NOT_FOUND);
        }
        if ($this->user_repository->isExistFieldValue(User::FIELD_EMAIL, $this->email)) {
            return JsonFormatter::makeAnswer(Response::HTTP_FOUND, User::FIELD_EMAIL);
        }

        try {
            $user = $this->user_repository->getModelById($this->id);
        }catch (\Exception $e) {
            Log::error($e->getMessage());
            return JsonFormatter::makeAnswer(Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        $user->email = $this->email;

        try {
            $this->user_repository->update($user);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return JsonFormatter::makeAnswer(Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        return JsonFormatter::makeAnswer(Response::HTTP_OK);
    }
}
