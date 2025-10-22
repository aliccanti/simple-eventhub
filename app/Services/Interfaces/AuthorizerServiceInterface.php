<?php

namespace App\Services\Interfaces;

use Exception;

interface AuthorizerServiceInterface
{
    public function authorize(): bool|Exception;
}
