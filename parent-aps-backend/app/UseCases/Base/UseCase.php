<?php

namespace App\UseCases\Base;

use App\UseCases\Concerns\UseCase as IUseCase;
use Illuminate\Foundation\Application;

/**
 * Use Case Base Class
 */
abstract class UseCase implements IUseCase
{
    abstract public function execute($inputs = []);
}
