<?php

if (!defined('NV_IS_MOD_VAC')) {
  die('Stop!!!');
}

$sql = "select * from kind";
$query = $db->sql_query($sql);
$list = array();
while ($row = $db->sql_fetch_assoc($query)) {
  $list[] = $row;
  $sql = "select * from species where kind = " . $row["id"];
  $query2 = $db->sql_query($sql);

  $x = array();
  while ($crow = $db->sql_fetch_assoc($query2)) {
    $x[] = $crow;
  }
  $list[count($list) - 1]["list"] = $x;
}
$result["data"]["list"] = $list;
$result["status"] = 1;