<?php

namespace GatewayPay\Exceptions;

/**
 * Represents an exception specific to the GatewayPay API.
 *
 * This exception is used to indicate errors related to the GatewayPay API.
 * It extends the base PHP Exception class and includes a message and code
 * to provide information about the specific error that occurred.
 */
class GatewayPayException extends \Exception
{
    /**
     * Constructs a new GatewayPayException instance.
     *
     * @param string $message The error message.
     * @param int $code The error code.
     */
    public function __construct($message, $code)
    {
        parent::__construct($message, $code);
    }
}
