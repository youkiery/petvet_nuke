<?php

if (!defined('NV_IS_MOD_VAC')) {
  die('Stop!!!');
}

$uid = $nv_Request->get_string('uid', 'post/get', '');
$pid = $nv_Request->get_string('pid', 'post/get', '');
$value = $nv_Request->get_string('value', 'post/get', '');
$review = $nv_Request->get_string('review', 'post/get', '');
if ($uid > 0 && $pid > 0 && $value > 0) {
  $time = strtotime(date("Y-m-d"));

  $sql = "SELECT * from post where id = $pid";
  $query = $db->sql_query($sql);
  if ($row = $db->sql_fetch_assoc($query)) {
    $sql = "INSERT into rate (uid, pid, value, review, time) values($uid, $pid, $value, '$review', $time)";
    if ($db->sql_query($sql)) {
      $sql = "insert into notify (type, user, uid, pid, time) values(3, $row[user], $uid, $pid, " . strtotime(date("Y-m-d")) . ")";
      $query = $db->sql_query($sql);
      $result["status"] = 1;
    }
  }
}
