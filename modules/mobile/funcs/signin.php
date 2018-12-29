<?php

if (!defined('NV_IS_MOD_VAC')) {
  die('Stop!!!');
}

$username = $nv_Request->get_string('username', 'post/get', '');
$password = $nv_Request->get_string('password', 'post/get', '');
$msg = "";
if (!(empty($username) || empty($password))) {
  $sql = "SELECT * from user where username = '$username'";
  $query = $db->sql_query($sql);

  $sql = "SELECT * from user where username = '$username' and password = '$password'";
  $query2 = $db->sql_query($sql);

  if (!$db->sql_numrows($query)) {
    $msg = $lang_module["notusername"];
  }
  else if (!$db->sql_numrows($query2)) {
    $msg = $lang_module["notpassword"];
  }
  else {
    $user = $db->sql_fetch_assoc($query);
    $result["data"]["status"] = 1;
    $result["data"]["info"] = $user;
  }
}
if (!empty($msg)) {
  $result["data"]["msg"] = $msg;
  $result["data"]["status"] = 2;
}
if (!empty($result["data"]["status"])) {
  $result["status"] = 1;
}
