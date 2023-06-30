<?php

declare(strict_types=1);

namespace Nofrixion\Exception;

class ConnectException extends NofrixionException
{
    public function __construct(string $curlErrorMessage, int $curlErrorCode)
    {
        parent::__construct($curlErrorMessage, $curlErrorCode);
    }
}
