<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
ob_start();
session_start();
$_SESSION['username'] = null;
$_SESSION['firstname'] = null;
$_SESSION['lastname'] = null;
$_SESSION['user_role'] = null;
header("Location:../../index.php");
?>