<?php

declare(strict_types=1);

namespace Infrastructure;

use Infrastructure\Interfaces\ICommand;

/**
 * Class BaseCommand
 * @package Infrastructure
 */
abstract class BaseCommand implements ICommand
{
    public function execute(){}
}
