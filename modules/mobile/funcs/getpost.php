<?php

if (!defined('NV_IS_MOD_VAC')) {
  die('Stop!!!');
}

define('USER_PAGE_LIMIT', 12);
define('INITIAL_PAGE', 1);
define('NV_OK', 1);

$page = $nv_Request->get_string('page', 'post/get', '');
if (empty($page) || $page < 0) {
  $page = INITIAL_PAGE;
}

$total = $page * USER_PAGE_LIMIT;

$sql = "select count(id) as count from post";
$query = $db->sql_query($sql);
$row = $db->sql_fetch_assoc($query);
$count = $row["count"];
$result["data"]["next"] = false;
if ($count > $total) {
  $result["data"]["next"] = true;
}
$sql = "select * from post order by id desc limit " . $total;
$query = $db->sql_query($sql);
$list = array();
$index = 1;
while ($row = $db->sql_fetch_assoc($query)) {
  $sql = "select * from user where id = " . $row["user"];
  $query2 = $db->sql_query($sql);
  $user = $db->sql_fetch_assoc($query2);
  $row["index"] = $index;
  $row["type"] = $type[$row["type"]];
  $row["title"] = $row["name"];
  $row["name"] = $user["name"];
  $row["phone"] = $user["phone"];
  $row["address"] = $user["address"];
  $list[] = $row;
  $index ++;
}
$result["data"]["list"] = $list;
$result["status"] = NV_OK;