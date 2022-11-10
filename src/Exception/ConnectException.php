<?php

declare(strict_types=1);

namespace NoFrixion\Exception;

class ConnectException extends NoFrixionException
{
    public function __construct(string $curlErrorMessage, int $curlErrorCode)
    {
        parent::__construct($curlErrorMessage, $curlErrorCode);
    }
}
