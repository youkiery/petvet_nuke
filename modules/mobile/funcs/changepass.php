<?php

if (!defined('NV_IS_MOD_VAC')) {
  die('Stop!!!');
}

$uid = $nv_Request->get_string('uid', 'post/get', '');
$pass = $nv_Request->get_string('pass', 'post/get', '');
$npass = $nv_Request->get_string('npass', 'post/get', '');
if (!(empty($uid) || empty($pass) || empty($npass))) {
  $sql = "SELECT * from user where password = '$pass' and id = $uid";
  $query = $db->sql_query($sql);

  if ($row = $db->sql_fetch_assoc($query)) {
    $sql = "UPDATE user set password = '$npass' where id = $uid";
    if ($db->sql_query($sql)) {
      $result["data"]["status"] = 1;
    }
  } else {
    $result["data"]["status"] = 2;
  }
  if ($result["data"]["status"]) {
    $result["status"] = 1;
  }
}
