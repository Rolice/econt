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

    /**
     * Validates an input data against model expectations
     * @param array $data The input data for the import validation
     * @return bool True if input data is in valid format, false otherwise
     */
    public function validateImport(array $data);

}