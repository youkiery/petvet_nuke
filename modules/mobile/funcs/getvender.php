<?php

if (!defined('NV_IS_MOD_VAC')) {
  die('Stop!!!');
}

$oid = $nv_Request->get_string('oid', 'post/get', '');
if (!empty($oid)) {
  $sql = "SELECT c.name, c.phone, c.address from petorder a inner join post b on a.id = $oid and a.pid = b.id inner join user c on b.user = c.id";

  
  $query = $db->sql_query($sql);
  $row = $db->sql_fetch_assoc($query);
  if ($row) {
    $result["status"] = 1;
    $result["data"]["vender"] = $row;
  }
}
