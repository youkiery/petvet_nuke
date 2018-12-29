<?php

if (!defined('NV_IS_MOD_VAC')) {
  die('Stop!!!');
}
define("NV_ORDER", 1);
define("NV_MATE", 2);

$uid = $nv_Request->get_string('uid', 'post/get', '');
$oid = $nv_Request->get_string('oid', 'post/get', '');
$pid = $nv_Request->get_string('pid', 'post/get', '');
if ($uid > 0 && $oid > 0 && $pid) {
  $sql = "select * from post where id = " . $pid;
  $query = $db->sql_query($sql);
  $post = $db->sql_fetch_assoc($query);
  $today = time();
  if ($post["type"] > 0) {
    $sql = "UPDATE petorder set status = 1, time = " . $today . " where id = $oid";
    if ($db->sql_query($sql)) {
      $sql = "UPDATE petorder set status = 2, time = " . $today . "  where status = 0 and id <> $oid";
      if ($db->sql_query($sql)) {
        $sql = "UPDATE post set sold = 1 where id = $pid";
        if ($db->sql_query($sql)) {
          $sql = "SELECT * from petorder where id = $oid";
          $pquery = $db->sql_query($sql);
          $row = $db->sql_fetch_assoc($pquery);
          $sql = "insert into notify (type, user, uid, pid, time) values(6, $uid, $row[user], $pid, " . $today . ")";
          $in1query = $db->sql_query($sql);
          $sql = "insert into notify (type, user, uid, pid, time) values(7, $row[user], $uid, $pid, " . $today . ")";
          $in2query = $db->sql_query($sql);
          $result["status"] = 1;
          $result["data"]["status"] = NV_ORDER;
          filterorder();
        }
      }
    }
  }
  else {
    $sql = "UPDATE petorder set status = 1 where id = $oid";
    if ($db->sql_query($sql)) {
      $sql = "SELECT * from petorder where id = $oid";
      $pquery = $db->sql_query($sql);
      $row = $db->sql_fetch_assoc($pquery);
      $sql = "insert into notify (type, user, uid, pid, time) values(6, $uid, $row[user], $pid, " . $today . ")";
      $in1query = $db->sql_query($sql);
      $sql = "insert into notify (type, user, uid, pid, time) values(7, $row[user], $uid, $pid, " . $today . ")";
    }
    $sql = "select * from petorder where pid = " . $pid;
    $query = $db->sql_query($sql);
    $allrow = sqlfetchall($db, $query);
    $result["data"]["list"] = $allrow;
    $result["data"]["status"] = NV_MATE;
    $result["status"] = 1;
  }
}
