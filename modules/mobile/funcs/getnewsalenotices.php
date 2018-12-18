<?php

if (!defined('NV_IS_MOD_VAC')) {
  die('Stop!!!');
}

$uid = $nv_Request->get_string('uid', 'post/get', '');
if ($uid) {
  $sql = "SELECT type, count(type) as count from notify where user = $uid and view = 0 group by type order by type";
  $query = $db->sql_query($sql);
  if ($query) {
    // var_dump($query);
    $allrow = sqlfetchall($db, $query);
    $new = array();
    foreach ($allrow as $key => $row) {
      $new[$row["type"]] = $row["count"];
    }
    $result["data"]["new"] = $new;
    $result["status"] = 1;
  }
}
