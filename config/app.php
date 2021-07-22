<?php

$config['base_url'] = 'http://localhost/perpus/'; 
$config['app_name'] = 'Sistem Perpustakaan'; 
$config['debug']    = true;

if($config['debug']){
  ini_set('display_errors', '1');
  ini_set('display_startup_errors', '1');
  error_reporting(E_ALL);
}

?>