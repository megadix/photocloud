<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------
| CLOUD STORAGE SETTINGS
| -------------------------------------------------------------------
| This file will contain the settings needed to access your S3-compatible
| cloud storage.
|
| -------------------------------------------------------------------
| EXPLANATION OF VARIABLES
| -------------------------------------------------------------------
|
| ['s3AccessKey'] Access Key of cloud storage
| ['s3SecretKey'] Secret Key of cloud storage
| ['s3EndPoint'] service-provider specific endpoint
|       'rm1.cloudaccess.it' : Hostingsolutions.it endpoint
|       's3.amazonaws.com' : Amazon S3 endpoint
*/

cloudStorage['s3AccessKey'] = '';
cloudStorage['s3SecretKey'] = '';
cloudStorage['s3EndPoint'] = '';

/* End of file cloudStorage */
/* Location: ./application/config/cloud_storage.php */