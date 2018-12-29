<?php

if (!defined('NV_IS_MOD_VAC')) {
  die('Stop!!!');
}
define("NV_ORDER", 1);
define("NV_MATE", 2);

$oid = $nv_Request->get_string('oid', 'post/get', '');
if ($oid) {
  $today = time();
  $sql = "update petorder set status = 1, time = $today where id = " . $oid;
  if ($db->sql_query($sql)) {
    $sql = "SELECT * from petorder where id = $oid";
    $pquery = $db->sql_query($sql);
    $row = $db->sql_fetch_assoc($pquery);
    $sql = "SELECT * from post where id = $row[pid]";
    $pquery = $db->sql_query($sql);
    $post = $db->sql_fetch_assoc($pquery);
    $sql = "insert into notify (type, user, uid, pid, time) values(6, $post[user], $row[user], $post[id], " . $today . ")";
    $in1query = $db->sql_query($sql);
    $sql = "insert into notify (type, user, uid, pid, time) values(9, $row[user], $post[user], $post[id], " . $today . ")";
    $in2query = $db->sql_query($sql);
    filterorder();
    $result["status"] = 1;
  }
}
