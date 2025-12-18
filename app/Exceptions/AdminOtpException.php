<?php

namespace App\Exceptions;

use Exception;

class AdminOtpException extends Exception
{
    public function __construct(private readonly string $type)
    {
        parent::__construct();
    }

    public function getType(): string
    {
        return $this->type;
    }
}
