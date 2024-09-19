<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Throwable;

abstract class AppException extends Exception implements HttpExceptionInterface
{
    public function getStatusCode(): int
    {
        return $this->getCode();
    }

    public function getHeaders(): array
    {
        return [];
    }

    protected array $data;

    public function __construct(?string $message, ?int $httpCode = null, ?array $data = null, ?Throwable $previous = null)
    {
        parent::__construct(previous: $previous);

        $this->message = $message ?? trans('errors.api.generic_error');
        $this->code = $httpCode ?? 500;
        $this->data = $data ?? [];
    }

    public function getData(): array
    {
        return $this->data;
    }

    public function getInternalLogMessage(): string
    {
        return $this->message;
    }

    public function getInternalLogData(): array
    {
        return $this->data;
    }

    /**
     * Render the exception.
     */
    public function render(): ?JsonResponse
    {
        // Necessary to not render the exception as JSON in Jetstream.
        if (! request()->expectsJson()) {
            return null;
        }

        return response()->json([
            'error' => get_class($this),
            'message' => $this->getMessage(),
            'data' => $this->getData(),
        ], $this->getCode());
    }
}
