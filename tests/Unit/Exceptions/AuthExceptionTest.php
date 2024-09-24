<?php

use App\Exceptions\AuthException;

test('issue a token', function () {
    $exception = AuthException::class;
    $this->expectException($exception);
    $this->expectExceptionMessageMatches('/Credenciais inválidas/');

    throw new $exception;
});
