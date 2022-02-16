<?php

declare(strict_types=1);

namespace Yiisoft\RequestModel;

use RuntimeException;

final class RequestValidationException extends RuntimeException
{
    private const MESSAGE = 'Request model validation error';
    /**
     * @psalm-var array<string, non-empty-list<string> $errors
     */
    private array $errors;

    /**
     * @param string[] $errors
     */
    public function __construct(array $errors)
    {
        $this->errors = $errors;
        parent::__construct(self::MESSAGE);
    }

    public function getErrors(): array
    {
        return $this->errors;
    }

    public function getFirstErrors(): array
    {
        if (empty($this->errors)) {
            return [];
        }

        $result = [];
        foreach ($this->errors as $name => $errors) {
            if (!empty($errors)) {
                $result[$name] = reset($errors);
            }
        }

        return $result;
    }

    public function getFirstError(): ?string
    {
        $errors = $this->getFirstErrors();

        return $errors === [] ? null : reset($errors);
    }
}
