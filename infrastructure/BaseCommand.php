<?php

declare(strict_types=1);

namespace Infrastructure;

use Illuminate\Http\JsonResponse;
use Infrastructure\Interfaces\ICommand;

/**
 * Class BaseCommand
 * @package Infrastructure
 */
abstract class BaseCommand implements ICommand
{
    public function execute(){}

    public function jsonAnswer(int $status_code, string $message = ''): JsonResponse
    {
        if($message){
            $message = ['message' => $message];
        }

        return response()->json($message)->setStatusCode($status_code);
    }
}
