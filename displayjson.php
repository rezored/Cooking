<?php
$json = file_get_contents('post_test.php');
$obj = json_decode($json);
print_r($obj);