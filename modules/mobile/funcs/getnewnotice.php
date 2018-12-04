<?php

if (!defined('NV_IS_MOD_VAC')) {
  die('Stop!!!');
}

$uid = $nv_Request->get_string('uid', 'post/get', '');
if ($uid) {
  $sql = "SELECT count(id) as count from notify where user = $uid and view = 0";
  // $result["sql"] = $sql;
  $query = $db->sql_query($sql);
  $row = $db->sql_fetch_assoc($query);
  $count = $row["count"];
  $result["data"]["new"] = $count;
  $result["status"] = 1;
}
