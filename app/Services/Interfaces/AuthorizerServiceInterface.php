<?php

namespace App\Services\Interfaces;

interface AuthorizerServiceInterface
{
    public function authorize(): bool;
}
