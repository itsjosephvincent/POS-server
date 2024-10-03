<?php

namespace App\Exceptions;

use Exception;

class InvalidCategoryException extends Exception
{
    protected $statusCode;

    /**
     * Create a new exception instance.
     *
     * @param  string  $message
     * @param  int  $statusCode
     * @return void
     */
    public function __construct($message, $statusCode)
    {
        parent::__construct($message);

        $this->statusCode = $statusCode;
    }

    /**
     * Get the status code.
     *
     * @return int
     */
    public function getStatusCode()
    {
        return $this->statusCode;
    }
}
