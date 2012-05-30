<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------
| CLOUD STORAGE SETTINGS
| -------------------------------------------------------------------
| This file will contain the settings needed to access your S3-compatible
| cloud storage.
|
*/

$config['storage_accessKey'] = '';
$config['storage_secretKey'] = '';
$config['storage_useSSL'] = false;

// rm1.cloudaccess.it : HostingSolutions.it
// s3.amazonaws.com : Amazon Web Services
$config['storage_endpoint'] = '';

$config['storage_bucket_name'] = '';
$config['storage_base_path'] = '';

/* End of file cloudStorage */
/* Location: ./application/config/cloud_storage.php */