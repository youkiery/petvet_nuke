<?php

if (!defined('NV_IS_MOD_VAC')) {
  die('Stop!!!');
}

$oid = $nv_Request->get_string('id', 'post/get', '');
if (!empty($oid)) {
  $sql = "select * from petorder where id = " . $oid . " and status = 1";
  $query = $db->sql_query($sql);
  $order = $db->sql_fetch_assoc($query);

  $sql = "select * from post where id = " . $order["pid"];
  $query = $db->sql_query($sql);
  $post = $db->sql_fetch_assoc($query);
  
  $sql = "select id, name, phone, address from user where id = " . $post["user"];
  $query = $db->sql_query($sql);
  $user = $db->sql_fetch_assoc($query);

  $result["data"]["info"] = array("id" => $user["id"], "name" => $user["name"], "phone" => $user["phone"], "address" => $user["address"]);
  $result["status"] = 1;
}
