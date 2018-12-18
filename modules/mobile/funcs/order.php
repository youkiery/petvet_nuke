<?php

if (!defined('NV_IS_MOD_VAC')) {
  die('Stop!!!');
}

$name = $nv_Request->get_string('name', 'post/get', '');
$address = $nv_Request->get_string('address', 'post/get', '');
$phone = $nv_Request->get_string('phone', 'post/get', '');
$pid = $nv_Request->get_string('pid', 'post/get', '');
$uid = $nv_Request->get_string('uid', 'post/get', '');
if (!(empty($name) || empty($address) || empty($phone)) && $pid >= 0) {
  if (!($uid && $uid !== "null")) {
    $uid = 0;
  }

  $sql = "INSERT into petorder(pid, user, name, address, phone, status) values ($pid, $uid, '$name', '$address', '$phone', 0)";
  $query = $db->sql_query($sql);
  if ($query) {
    $time = strtotime(date("Y-m-d"));
    $sql = "SELECT user from post where id = $pid";
    $query = $db->sql_query($sql);
    $prow = $db->sql_fetch_assoc($query);

    $sql = "SELECT id from user where name = '$name', phone = '$phone'";
    $query = $db->sql_query($sql);
    $urow = $db->sql_fetch_assoc($query);
    if (!$urow) {
      $uid = 0;
    } else {
      $uid = $urow["id"];
    }
    if ($prow) {
      $sql = "insert into notify (type, user, uid, pid, time) values(1, $prow[user], $uid, $pid, $time)";
      $query = $db->sql_query($sql);
      $result["status"] = 1;
    }
  }
}
