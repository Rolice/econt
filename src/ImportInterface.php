<?php
namespace Rolice\Econt;

/**
 * Interface ImportInterface
 * This interface provides common ground for models to implement import functionality for their given data-type
 * @package Rolice\Econt
 * @version 1.0
 */
interface ImportInterface {

    /**
     * A generic interface method defining the scope of importing class routines for the package models.
     * @param array $data Data to be imported. Retrieved by Econt API service in XML format and parsed by the package.
     * @return bool True on success, false or exception otherwise
     */
    public function import(array $data);

}