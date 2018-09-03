<?php

include("../include/config.php");
include("../include/defs.php");

$user = $_REQUEST['user'];
$pass = $_REQUEST['pass'];

$arrLog = GetRecords("SELECT * FROM users WHERE user = '".$user."' and password = '".$pass."' and stat = 1");

$login = array();

foreach ($arrLog as $key => $value) {
  $login[] = $value;
}

echo json_encode($login);

 ?>
