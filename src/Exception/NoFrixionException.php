<?php

declare(strict_types=1);

namespace Nofrixion\Exception;

class NofrixionException extends \RuntimeException
{
    public function __construct(string $message, int $code, \Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
