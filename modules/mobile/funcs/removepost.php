<?php

if (!defined('NV_IS_MOD_VAC')) {
  die('Stop!!!');
}

$uid = $nv_Request->get_string('uid', 'post/get', '');
$pid = $nv_Request->get_string('pid', 'post/get', '');
$result["data"]["step"] = 1;

if ($pid > 0 && $uid > 0) {
  $result["data"]["step"] .= 2;
  $sql = "SELECT * from post where id = $pid";
  $query = $db->sql_query($sql);
  $row = $db->sql_fetch_assoc($query);
  $sql = "SELECT * from petorder where pid = $pid";
  $query = $db->sql_query($sql);
  $allrow = sqlfetchall($db, $query);
  $sql = "delete from post where id = $pid";
  $result["data"]["sql"] = $sql;

  if ($db->sql_query($sql)) {
    $result["data"]["step"] .= 3;
    if (!empty($allrow)) {
      foreach ($allrow as $key => $row) {
        $sql = "insert into notify (type, user, uid, pid, time) values(5, $row[uid], $row[user], $pid, " . strtotime(date("Y-m-d")) . ")";
        $query = $db->sql_query($sql);
      }
    }
    $result["status"] = 1;
    filterorder();
  }
}
