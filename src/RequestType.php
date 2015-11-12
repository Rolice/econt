<?php
namespace Rolice\Econt;

use Rolice\Econt\Exceptions\EcontException;

/**
 * Class RequestType
 * Class with constants, providing valid, predefined Econt request types.
 * @package Rolice\Econt
 * @version 0.1
 * @access public
 */
class RequestType
{
    const NONE = null;
    const REGISTRATION = 'e_econt_registration';
    const PROFILE = 'client_info';

}