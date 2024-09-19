<?php

namespace App\Exceptions;

class AuthException extends AppException
{
    public function __construct()
    {
        parent::__construct(
            message: trans('errors.auth.invalid_credentials'),
            httpCode: 401,
        );
    }
}
