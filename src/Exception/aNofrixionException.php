<?php

declare(strict_types=1);

namespace Nofrixion\Exception;

/**
 * NofrixionException
 */
class NofrixionException extends \RuntimeException
{
    /**
     * Summary of __construct
     * @param string $message
     * @param int $code
     * @param \Throwable|null $previous
     */
    public function __construct(string $message, int $code, \Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
