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
  $post = $db->sql_fetch_assoc($query);
  $sql = "SELECT * from rate where user = $post[user]";
  $query = $db->sql_query($sql);
  $total = $db->sql_numrows($query);
  if ($total) {
    $rate = sqlfetchall($db, $query);
    $totalpoint = 0;
    foreach ($rate as $key => $row) {
      $totalpoint += $row["value"];
    }
    $average = $totalpoint / $total;
  } else {
    $average = 0;
  }
  $result["data"]["total"] = $total;
  $result["data"]["average"] = $average;


  $sql = "SELECT * from post where id = $pid";
  $query = $db->sql_query($sql);
  $row = $db->sql_fetch_assoc($query);
  if ($row) {
    $sql = "INSERT into rate (uid, user, value, review, time) values($uid, $row[user], $value, '$review', $time)";
    if ($db->sql_query($sql)) {
      $sql = "SELECT * from post where id = $pid";
      $query = $db->sql_query($sql);
      $post = $db->sql_fetch_assoc($query);
      $sql = "SELECT * from rate where user = $post[user]";
      $query = $db->sql_query($sql);
      $total = $db->sql_numrows($query);
      if ($total) {
        $rate = sqlfetchall($db, $query);
        $totalpoint = 0;
        foreach ($rate as $key => $value) {
          $totalpoint += $value["value"];
        }
        $average = $totalpoint / $total;
      } else {
        $average = 0;
      }
      $result["data"]["total"] = $total;
      $result["data"]["average"] = $average;

      $sql = "insert into notify (type, user, uid, pid, time) values(3, $row[user], $uid, $pid, " . time() . ")";
      $query = $db->sql_query($sql);
      $result["status"] = 1;
    }
  }
}
