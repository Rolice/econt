<?php
namespace Rolice\Econt\Helpers;

use App;

class Locale {

    public function __callStatic($method) {
        $postfix = 'bg' !== App::getLocale() ? '_en' : '';

        return $method . $postfix;
    }

}