<?php

if (!defined('NV_IS_MOD_VAC')) {
  die('Stop!!!');
}

$pid = $nv_Request->get_string('pid', 'post/get', '');
$page = $nv_Request->get_string('page', 'post/get', '');
if (!(empty($pid) || empty($page))) {
  $page ++;
  $commentlimit = 10;
  if ($config["comment"] > 0) {
    $commentlimit = $config["comment"];
  }
  $from = 0;
  $to = $page * $commentlimit;
  $limit = "limit $from, $to";

  $sql = "SELECT a.user, a.name, a.phone, a.address, a.time, a.comment from comment a where a.pid = $pid  order by a.time asc $limit";
  $query = $db->sql_query($sql);
  $comment = sqlfetchall($db, $query);

  foreach ($comment as $key => $row) {
    if ($row["user"]) {
      $sql = "SELECT a.name, a.phone, a.address from user a where id = $row[user]";
      $query = $db->sql_query($sql);
      $crow = $db->sql_fetch_assoc($query);
      $comment[$key]["name"] = $crow["name"];
      $comment[$key]["phone"] = $crow["phone"];
      $comment[$key]["address"] = $crow["address"];
    }
    $comment[$key]["time"] = date("H:i d/m/Y", $row["time"]);
  }

  $sql = "select count(id) as count from comment where pid = $pid";
  $query = $db->sql_query($sql);
  $countid = $db->sql_fetch_assoc($query);
  $result["data"]["next"] = false;
  if ($countid["count"] > $to) {
    $result["data"]["next"] = true;
  }

  $result["status"] = 1;
  $result["data"]["comment"] = $comment;
}
