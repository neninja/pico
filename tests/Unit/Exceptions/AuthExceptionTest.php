<?php

use App\Exceptions\AuthException;
use Illuminate\Support\Facades\Config;

test('issue a token', function () {
    $exception = AuthException::class;
    Config::set('locale', 'pt_BR');
    $this->expectException($exception);
    $this->expectExceptionMessageMatches('/Não foi possível validar o documento/');

    throw new $exception;
});
