<?php

if (!defined('NV_IS_MOD_VAC')) {
  die('Stop!!!');
}

$pid = $nv_Request->get_string('pid', 'post/get', '');
if (!empty($pid)) {
  $sql = "SELECT a.id as oid, a.name, a.phone, a.address from petorder a inner join post b on a.pid = $pid and a.pid = b.id";
  $result["data"]["sql"] = $sql;
  $query = $db->sql_query($sql);
  $allrow = sqlfetchall($db, $query);

  foreach ($allrow as $key => $row) {
    if ($row["user"]) {
      $sql = "SELECT * from user where $row[id]";
      $query = $db->sql_query($sql);
      $urow = $db->sql_fetch_assoc($query);
      $allrow[$key]["name"] = $urow["name"];
      $allrow[$key]["name"] = $urow["phone"];
      $allrow[$key]["address"] = $urow["address"];
    }
  }
  if ($query) {
    $result["status"] = 1;
    $result["data"]["vender"] = $allrow;
  }
}
