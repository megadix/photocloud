<?php

require 'S3.php';

/**
 * Wrapper for Amazon S3 PHP class by by Donovan Schonknecht
 *
 * @link http://undesigned.org.za/2007/10/22/amazon-s3-php-class
 */
class S3_CI extends S3
{
    public function __construct($params) {
        parent::__construct($params['accessKey'], $params['secretKey'],
            $params['useSSL'], $params['endpoint']);
    }
}
