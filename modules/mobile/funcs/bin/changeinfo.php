<?php

if (!defined('NV_IS_MOD_VAC')) {
  die('Stop!!!');
}

$uid = $nv_Request->get_string('uid', 'post/get', '');
$name = $nv_Request->get_string('name', 'post/get', '');
$address = $nv_Request->get_string('address', 'post/get', '');
$phone = $nv_Request->get_string('phone', 'post/get', '');
if (!(empty($uid) || empty($name) || empty($address) || empty($phone))) {
  $sql = "SELECT * from user where id = $uid";
  $query = $db->sql_query($sql);
  $urow = $db->sql_fetch_assoc($query);
  $sql = "SELECT count(id) as count from user where id <> $uid and phone = '$phone'";
  $query = $db->sql_query($sql);
  $count = $db->sql_fetch_assoc($query);
  if ($urow) {
    if (!$count["count"]) {
      $sql = "UPDATE user set name = '$name', address = '$address', phone = '$phone' where id = $uid";
      if ($db->sql_query($sql)) {
        $result["data"]["status"] = 1;
      }
    } else {
      $result["data"]["status"] = 2;
    }
  }
  if ($result["data"]["status"]) {
    $result["status"] = 1;
  }
}
