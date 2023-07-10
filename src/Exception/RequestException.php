<?php

declare(strict_types=1);

namespace Nofrixion\Exception;

use Nofrixion\Exception\NofrixionException;
use Nofrixion\Http\ResponseInterface;

class RequestException extends NofrixionException
{
    public function __construct(string $method, string $url, ResponseInterface $response)
    {
        $message = 'Error during ' . $method . ' to ' . $url . '. Got response (' . $response->getStatus() . '): ' . $response->getBody();
        parent::__construct($message, $response->getStatus());
    }
}
