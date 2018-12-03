<?php

if (!defined('NV_IS_MOD_VAC')) {
  die('Stop!!!');
}

$uid = $nv_Request->get_string('uid', 'post/get', '');
$oid = $nv_Request->get_string('oid', 'post/get', '');
$pid = $nv_Request->get_string('pid', 'post/get', '');
if ($uid > 0 && $oid > 0 && $pid) {
  $sql = "UPDATE petorder set status = 1 where id = $oid";
  if ($db->sql_query($sql)) {
    $sql = "UPDATE petorder set status = 2 where status = 0 and id <> $oid";
    if ($db->sql_query($sql)) {
      $sql = "UPDATE post set sold = 1 where id = $pid";
      if ($db->sql_query($sql)) {
        $sql = "SELECT * from post where id = $pid";
        $pquery = $db->sql_query($sql);
        $row = $db->sql_fetch_assoc($pquery);
        $sql = "insert into notify (type, user, uid, pid, time) values(6, $uid, $row[user], $pid, " . strtotime(date("Y-m-d")) . ")";
        $in1query = $db->sql_query($sql);
        $sql = "insert into notify (type, user, uid, pid, time) values(7, $row[user], $uid, $pid, " . strtotime(date("Y-m-d")) . ")";
        $in2query = $db->sql_query($sql);
        $result["status"] = 1;
        filterorder();
      }
    }
  }
}
