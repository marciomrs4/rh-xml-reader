<?php

namespace RH\XMLReaderBundle\Service;
use Symfony\Component\HttpFoundation\File\File;

/**
 * Created by PhpStorm.
 * User: marcio
 * Date: 29/08/18
 * Time: 17:06
 */
class ValidatorXml
{
    private $errors;
    private $file;

    public function loadFileXml($file)
    {
        if(!is_file($file))
        {
            return 'Is not file';
        }

        $this->file = $file;
    }

    public function validateXml($fileXSD)
    {
        // Enable user error handling
        libxml_use_internal_errors(true);

        $xml = new \DOMDocument();
        $xml->load($this->file);

        if (!$xml->schemaValidate($fileXSD)) {
            $this->errors = libxml_get_errors();

            return 1;
        }

    }

    public function getAllErrors()
    {
        return $this->errors;
    }


}