<?php

if (!defined('NV_IS_MOD_VAC')) {
  die('Stop!!!');
}

$uid = $nv_Request->get_string('uid', 'post/get', '');
$province = $nv_Request->get_string('province', 'post/get', '');
if (!(empty($uid) || empty($province))) {
  $sql = "UPDATE user set province = '$province' where id = $uid";
  if ($db->sql_query($sql)) {
    $result["status"] = 1;
  }
}
