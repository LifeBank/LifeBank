<?php
/**
 * Database Constants - these constants refer to 
 * the database configuration settings. 
 */

require_once 'Database.php';

$host = 'localhost';
$user = 'stanley';
$pass = 'warri';
$database = 'lifebank';

Database::connect($host, $user, $pass, $database);


//Define site root
define('SITEURL', 'http://localhost/lifebank');
?>