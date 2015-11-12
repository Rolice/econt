<?php
namespace Rolice\\Econt\Exceptions;

use Exception;

class EcontException extends Exception
{
    public function __construct($message = '', $code = '') {
        parent::__construct($message, 0);
        $this->code = $code;
    }
}