<?php

if (!defined('NV_IS_MOD_VAC')) {
  die('Stop!!!');
}

$pid = $nv_Request->get_string('pid', 'post/get', '');
if (!empty($pid)) {
  $sql = "SELECT a.id as oid, a.user, a.name, a.phone, a.address, a.status from petorder a inner join post b on a.pid = $pid and a.pid = b.id order by id desc";
  $query = $db->sql_query($sql);
  $allrow = sqlfetchall($db, $query);

  foreach ($allrow as $key => $row) {
    if (!empty($row["oid"])) {
      if ($row["user"] == 0) {
        $allrow[$key]["name"] = $row["name"];
        $allrow[$key]["phone"] = $row["phone"];
        $allrow[$key]["address"] = $row["address"];
      }
      else {
        $sql = "SELECT * from user where id = $row[user]";
        $query = $db->sql_query($sql);
        $urow = $db->sql_fetch_assoc($query);
        $allrow[$key]["name"] = $urow["name"];
        $allrow[$key]["phone"] = $urow["phone"];
      }
      $allrow[$key]["status"] = $row["status"];
    }
  }
  if ($query) {
    $result["status"] = 1;
    $result["data"]["vender"] = $allrow;
  }
}
