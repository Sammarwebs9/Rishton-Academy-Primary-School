<?php
require_once 'config.php';

// Create connection
$link = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

// Check connection
if ($link->connect_error) {
    die("Connection failed: " . $link->connect_error);
}
?>
