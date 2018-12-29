<?php

if (!defined('NV_IS_MOD_VAC')) {
  die('Stop!!!');
}

$uid = $nv_Request->get_string('uid', 'post/get', '');
$pid = $nv_Request->get_string('id', 'post/get', '');
$page = $nv_Request->get_string('page', 'post/get', '');
$comment = $nv_Request->get_string('chattext', 'post/get', '');
$time = time();

if (empty($uid)) {
  $name = $nv_Request->get_string('name', 'post/get', '');
  $phone = $nv_Request->get_string('phone', 'post/get', '');
  $address = $nv_Request->get_string('address', 'post/get', '');
  $uid = 0;

  $sql = "INSERT into comment(pid, user, name, phone, address, time, comment, cid, public) values($pid, $uid, '$name', '$phone', '$address', $time, '$comment', 0, 0)";
} else {
  $puid = $nv_Request->get_string('puid', 'post/get', '');

  $sql = "INSERT into comment(pid, user, name, phone, address, time, comment, cid, public) values($pid, $uid, '', '', '', $time, '$comment', 0, 0)";
}

if ($db->sql_query($sql)) {
  $commentlimit = 10;
  if (!empty($config["comment"]) && $config["comment"] > 0) {
    $commentlimit = $config["comment"];
  }
  // $result["data"]["page"] = $page;
  // $result["data"]["commentlimit"] = $commentlimit;

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

  $sql = "SELECT * from post where id = $pid";
  $query = $db->sql_query($sql);
  $row = $db->sql_fetch_assoc($query);

  $sql = "insert into notify (type, user, uid, pid, time) values(4, $row[user], $uid, $pid, " . time() . ")";
  $query = $db->sql_query($sql);

  $result["status"] = 1;
  $result["data"]["comment"] = $comment;
  $result["data"]["status"] = 1;
}
