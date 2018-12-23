<?php
if (!defined('NV_IS_MOD_VAC')) {
  die('Stop!!!');
}
$oid = $nv_Request->get_string('oid', 'post/get', '');
if (!empty($oid)) {
  $sql = "select * from petorder where id = " . $oid;
  $query = $db->sql_query($sql);
  $order = $db->sql_fetch_assoc($query);
  if ($order) {
    $result["data"]["order"] = $order;
    $result["status"] = 1;
  }
}
