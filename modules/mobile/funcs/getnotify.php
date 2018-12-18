<?php

if (!defined('NV_IS_MOD_VAC')) {
  die('Stop!!!');
}

$uid = $nv_Request->get_string('uid', 'post/get', '');
$page = $nv_Request->get_string('page', 'post/get', '');
if (!(empty($uid) || empty($page))) {
  $from = 0;
  $to = $page * 12;
  $limit = "limit $from, $to";
  $sql = "SELECT count(a.id) as count from notify a where a.user = $uid";
  $query = $db->sql_query($sql);
  $row = $db->sql_fetch_assoc($query);
  $result["data"]["count"] = $sql;

  if ($row["count"] > $to) {
    $result["data"]["next"] = true;
  } else {
    $result["data"]["next"] = false;
  }

  $sql = "SELECT a.type, a.time, a.pid, b.name as title from notify a inner join post b on a.pid = b.id where a.user = $uid order by a.time desc $limit";
  $result["data"]["sql2"] = $sql;

  if ($query = $db->sql_query($sql)) {
    $data = sqlfetchall($db, $query);
    foreach ($data as $key => $row) {
      if ($row["uid"]) {
        $sql = "select * from user where id = $row[id]";
        $query = $db->sql_query($sql);
        $urow = $db->sql_fetch_assoc($query);
        $data[$key]["name"] = $urow["name"];
      } else {
        $data[$key]["name"] = $lang_module["guest"];
      }
      $data[$key]["time"] = date("d/m/Y", $row["time"]);
    }

    $sql = "SELECT count(id) as count from notify where user = $uid and view = 0 order by time desc";
    $query = $db->sql_query($sql);
    $row = $db->sql_fetch_assoc($query);
    $count = $row["count"];
    $result["data"]["new"] = $count;


    $sql = "UPDATE notify set view = 1 where id in (select id from (select id from notify where user = $uid and view = 0 order by time desc $limit) tpl )";
    $db->sql_query($sql);
    $result["status"] = 1;
    $result["data"]["notify"] = $data;
  }
}
