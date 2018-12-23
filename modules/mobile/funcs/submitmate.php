<?php

if (!defined('NV_IS_MOD_VAC')) {
  die('Stop!!!');
}
define("NV_ORDER", 1);
define("NV_MATE", 2);

$oid = $nv_Request->get_string('oid', 'post/get', '');
if ($oid) {
  $sql = "update petorder set status = 1 where id = " . $oid;
  if ($db->sql_query($sql)) {
    filterorder();
    $result["status"] = 1;
  }
}
