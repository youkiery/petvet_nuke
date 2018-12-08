<?php

if (!defined('NV_IS_MOD_VAC')) {
  die('Stop!!!');
}

$pid = $nv_Request->get_string('pid', 'post/get', '');
$uid = $nv_Request->get_string('uid', 'post/get', '');
$page = $nv_Request->get_string('page', 'post/get', '');
$result["data"]["step"] = 0;
if ($pid > 0 && $uid > 0 && $page > 0) {
  $userdata = array();
  $order = 0;
  $rate = 0;

  $sql = "select * from post where id = $pid";
  $query = $db->sql_query($sql);
  $row = $db->sql_fetch_assoc($query);
  $puid = $row["user"];
  
  $result["data"]["step"] = 1;
  if ($puid) {
    $result["data"]["step"] .= 2;
    if (!empty($uid) && $uid > 0) {
      $result["data"]["step"] .= 3;
      $sql = "SELECT name, phone, address from user where id = $puid";
      // $result["data"]["sql"] = $sql;
      // die(var_dump($_GET));
      $query = $db->sql_query($sql);
      $userdata = $db->sql_fetch_assoc($query);
  
      if ($uid == $puid) {
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
    } else {
      $uid = 0;
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
    $result["status"] = 1;
    $result["data"]["owner"] = $userdata;
    $result["data"]["comment"] = $comment;
    $result["data"]["order"] = $order;
    $result["data"]["rate"] = $rateval;
    $sql = "SELECT a.type as typeid, a.id, a.user, a.name, a.price, a.age as ageid, a.image, a.time, a.vaccine, a.description, b.name as owner, c.name as species, d.name as kind, b.province from post a inner join user b on a.id = $pid and a.user = b.id inner join species c on a.species = c.id inner join kind d on c.kind = d.id";
    if ($query = $db->sql_query($sql)) {
      $owner = parseData(array($db->sql_fetch_assoc($query)));
      $result["data"]["status"] = 1; // existed
      $result["data"]["data"] = $owner[0];
      $result["status"] = 1;
    }
  }
  else {
    $result["data"]["step"] .= 4;
    $result["data"]["status"] = 2; // deleted
    $result["status"] = 1;
  }
}
