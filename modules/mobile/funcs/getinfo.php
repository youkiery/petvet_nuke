<?php

if (!defined('NV_IS_MOD_VAC')) {
  die('Stop!!!');
}

$uid = $nv_Request->get_string('uid', 'post/get', '');
$pid = $nv_Request->get_string('pid', 'post/get', '');
$puid = $nv_Request->get_string('puid', 'post/get', '');
$page = $nv_Request->get_string('page', 'post/get', '');
if ($pid > 0 && $puid > 0 && $page > 0) {
  $userdata = array();
  $order = 0;
  $rate = 0;

  $sql = "SELECT * from post where id = $pid";
  $query = $db->sql_query($sql);
  $numrows = $db->sql_numrows($query);

  if ($numrows) {
    $sql = "SELECT name, phone, address from user where id = $puid";
    // $result["data"]["sql"] = $sql;
    // die(var_dump($_GET));
    $query = $db->sql_query($sql);
    $userdata = $db->sql_fetch_assoc($query);

    if ($uid == $puid || $uid ) {
      $rateval = -1;
    }
    else {
      $sql = "SELECT id, value from rate where uid = $uid and user = $puid";
      // $result["sql3"] = $sql;
      // die(var_dump($_GET));
      // die($sql);
      $query = $db->sql_query($sql);
      if ($row = $db->sql_fetch_assoc($query)) {
        // $result["data"] = var_dump($row);
        $rateval = $row["value"];
        // test();
      }
    }

    $sql = "SELECT * from petorder where user = $uid and pid = $pid";
    $query = $db->sql_query($sql);
    // $order = "1: " . $sql;
    $order = $db->sql_numrows($query);
    if (!$order) {
      $sql = "SELECT * from post where user = $uid and id = $pid";
      $query = $db->sql_query($sql);
      $order = $db->sql_numrows($query);
      // $order .= "|2: " . $db->sql_numrows($query);
    }

    if ($uid) {
      $where = "(a.user = $uid or b.user = $puid)";
    } else {
      $where = "(b.user = $puid)";
    }

    $sql = "SELECT * from rate where user = $puid";
    $query = $db->sql_query($sql);
    $total = $db->sql_numrows($query);
    // $result["data"]["sql"] = $sql;

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

    $commentlimit = 10;
    if ($config["comment"] > 0) {
      $commentlimit = $config["comment"];
    }
    $from = 0;
    $to = $page * $commentlimit;
    $limit = "limit $from, $to";

    $sql = "SELECT a.user, a.name, a.phone, a.address, a.time, a.comment from comment a where a.pid = $pid order by a.time asc $limit";
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
    $sql = "insert into notify (type, user, uid, pid, time) values(4, $ouid, $uid, $pid, " . strtotime(date("Y-m-d")) . ")";
    $query = $db->sql_query($sql);
    $result["data"]["status"] = 1; // exist
    $result["status"] = 1;
    $result["data"]["owner"] = $userdata;
    $result["data"]["comment"] = $comment;
    $result["data"]["order"] = $order;
    $result["data"]["rate"] = $rateval;
  }
  else {
    $result["data"]["status"] = 2; // exist
    $result["status"] = 1;
  }
}
