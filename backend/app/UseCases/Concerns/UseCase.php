<?php

namespace App\UseCases\Concerns;

/**
 * Use Case Contract
 */
interface UseCase
{
    /**
     * Execute a use case and return results
     *
     * @param string|array $inputs
     * @return mixed
     */
    public function execute($inputs = []);
}
