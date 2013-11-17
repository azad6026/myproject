<?php

/**
 * WEB_ROOT_FOLDER is the name of the parent folder you created these 
 * documents in.
 */

//$full_path = '/D:/xampp-win32-1.8.0-VC9/xampp/htdocs/mymvc/public_html';
$full_path = '/home/domain/public_html';
$file = basename($full_path);  // $file is "public_html"
$dir  = dirname($full_path);   // $dir is "."
defined ('SERVER_ROOT') ? null : define('SERVER_ROOT', '/home/domain');
defined ('DS') ? null : define('DS', '/');
//define('SERVER_ROOT' ,ROOT.DS.'application');
$site=$_SERVER['SERVER_NAME'];



include(SERVER_ROOT .DS.'application'.DS. 'controllers'.DS.'router.php' );