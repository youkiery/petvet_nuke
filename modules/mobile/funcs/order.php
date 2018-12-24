<?php

if (!defined('NV_IS_MOD_VAC')) {
  die('Stop!!!');
}

define("NV_PHONEEXIST", 2);
define("NV_OK", 1);

$name = $nv_Request->get_string('name', 'post/get', '');
$address = $nv_Request->get_string('address', 'post/get', '');
$phone = $nv_Request->get_string('phone', 'post/get', '');
$pid = $nv_Request->get_string('pid', 'post/get', '');
$uid = $nv_Request->get_string('uid', 'post/get', '');
if (!(empty($name) || empty($phone)) && $pid >= 0) {
  if (!($uid && $uid !== "null")) {
    $uid = 0;
  }

  $sql = "select * from petorder where user = 0 and status <> 0 and phone = '$phone' and pid = " . $pid;
  $query = $db->sql_query($sql);
  $petorder = $db->sql_fetch_assoc($query);
  
  if ($petorder) {
    $result["data"]["status"] = NV_PHONEEXIST;
    $result["status"] = 1;
  }

  $today = time();
  if (!$result["status"]) {
    $sql = "INSERT into petorder(pid, user, name, address, phone, status, time) values ($pid, $uid, '$name', '$address', '$phone', 0, " . $today . ")";
    $query = $db->sql_query($sql);
    if ($query) {
      $time = time();
      $sql = "SELECT user, type from post where id = $pid";
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
        if ($prow["type"]) {
          $sql = "insert into notify (type, user, uid, pid, time) values(1, $prow[user], $uid, $pid, $time)";
          $query = $db->sql_query($sql);
          $result["data"]["status"] = NV_OK;
          $result["status"] = NV_OK;
        }
        else {
          $sql = "insert into notify (type, user, uid, pid, time) values(8, $prow[user], $uid, $pid, $time)";
          $query = $db->sql_query($sql);
          $result["data"]["status"] = NV_OK;
          $result["status"] = NV_OK;
        }
      }
    }
  }
}
