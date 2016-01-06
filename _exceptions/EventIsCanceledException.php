<?php

/**
 * Event is canceled Exception File
 * Date: 05/01/2016
 * Project: OpenBooking
 * @copyright 2015 - 2016 OpenBooking Group
 */

namespace OpenBooking\_Exceptions;
use \Exception;

/**
 * Class EventIsCanceledException
 * @package OpenBooking\_Exceptions
 */
class EventIsCanceledException extends Exception
{
    /**
     * EventIsCanceledException constructor.
     * @param string $message
     * @param int $code
     * @param Exception|null $previous
     */
    public function __construct($message = "Event is canceled", $code = -10, Exception $previous = null) {
        parent::__construct($message, $code, $previous);
    }

    /**
     * Magic Method
     * @return string
     */
    public function __toString() {
        return __CLASS__ . ": [{$this->code}]: {$this->message}\n";
    }
}