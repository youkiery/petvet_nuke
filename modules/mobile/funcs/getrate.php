<?php

if (!defined('NV_IS_MOD_VAC')) {
  die('Stop!!!');
}

$name = $nv_Request->get_string('name', 'post/get', '');
$phone = $nv_Request->get_string('phone', 'post/get', '');
$page = $nv_Request->get_string('page', 'post/get', '');
if (!(empty($name) || (empty($phone))) && $page > 0) {
  $sql = "SELECT id from user where name = '$name' and phone = '$phone'";
  $query = $db->sql_query($sql);
  $row = $db->sql_fetch_assoc($query);
  $puid = $row["id"];

  $from = 0;
  $to = $page * 12;
  $limit = "limit $from, $to";
  $sql = "SELECT count(a.id) as count from rate where user = $puid";
  $query = $db->sql_query($sql);
  $row = $db->sql_fetch_assoc($query);
  if ($row["count"] > $to) {
    $result["data"]["next"] = true;
  } else {
    $result["data"]["next"] = false;
  }
  
  $sql = "SELECT a.*, b.name from rate a inner join user b on a.uid = b.id where user = $puid order by time $limit";
  $query = $db->sql_query($sql);
  $total = $db->sql_numrows($query);
  $rate = array();
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

  $sql = "SELECT * from post a inner join user b on b.name = '$name' and b.phone = '$phone' and a.sold = 1 and a.user = b.id";
  $query = $db->sql_query($sql);
  $totalsale = $db->sql_numrows($query);

  $crate = array();
  foreach ($rate as $key => $row) {
    $crate[] = array("name" => $row["name"], "msg" => $row["review"], "time" => date("d/m/Y", $row["time"]));
  }

  $result["status"] = 1;
  $result["data"]["total"] = $total;
  $result["data"]["average"] = $average;
  $result["data"]["totalsale"] = $totalsale;
  $result["data"]["rate"] = $crate;
}
