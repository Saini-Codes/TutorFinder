<?php
$hostname = 'localhost';
$username = 'root';
$password = '';
$dbname = 'tutorfinder';
$connect = new mysqli($hostname, $username, $password, $dbname);
if ($connect->connect_error) {
    die('Connection Failed: ' . $connect->connect_error);
} 
?>