<?php
namespace CloudCart\Econt;

use CloudCart\Econt\Exceptions\EcontException;

/**
 * Class RequestType
 * Class with constants, providing valid, predefined Econt request types.
 * @package CloudCart\Econt
 * @version 0.1
 * @license CloudCart License
 * @access public
 */
class RequestType
{
    const NONE = null;
    const REGISTRATION = 'e_econt_registration';
    const PROFILE = 'client_info';

}