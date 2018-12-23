<?php

if (!defined('NV_IS_MOD_VAC')) {
  die('Stop!!!');
}

$pid = $nv_Request->get_string('id', 'post/get', '');
if (!empty($pid)) {
  $sql = "select * from petorder where pid = " . $pid . " and status = 1";
  $query = $db->sql_query($sql);
  $post = $db->sql_fetch_assoc($query);

  $user = array("id" => $post["id"], "name" => $post["name"], "phone" => $post["phone"], "address" => $post["address"]);
  if ($post["user"] > 0) {
    $sql = "select id, name, phone, address from user where id = " . $post["user"];
    $query = $db->sql_query($sql);
    $user = $db->sql_fetch_assoc($query);
  }


  $result["data"]["info"] = array("id" => $user["id"], "name" => $user["name"], "phone" => $user["phone"], "address" => $user["address"]);
  $result["status"] = 1;
}
