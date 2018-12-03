<?php

if (!defined('NV_IS_MOD_VAC')) {
  die('Stop!!!');
}

$uid = $nv_Request->get_string('uid', 'post/get', '');
$type = $nv_Request->get_string('uid', 'post/get', '');
if ($uid > 0 && $type > 0) {
  $sql = "count(type) as count from notify where user = $uid and view = 0 and type = $type group by type order by type";
  $query = $db->sql_query($sql);
  $row = $db->sql_fetch_assoc($query);
  $result["data"]["new"] = $row["count"];
  $result["status"] = 1;
}
