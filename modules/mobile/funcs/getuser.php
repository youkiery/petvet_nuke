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

$sql = "select count(id) as count from user";
$query = $db->sql_query($sql);
$row = $db->sql_fetch_assoc($query);
$count = $row["count"];
$result["data"]["next"] = false;
if ($count > $total) {
  $result["data"]["next"] = true;
}
$sql = "select id, username, name, phone, address, province, role, roles, active from user order by id desc limit " . $total;
$query = $db->sql_query($sql);
$list = array();
$index = 1;
while ($row = $db->sql_fetch_assoc($query)) {
  $row["index"] = $index;
  $row["province"] = $config["province"][$row["province"]];
  $row["role_s"] = $role_type[$row["role"]];
  $row["roles_s"] = "";
  if ($row["roles"]) {
    $x = str_split($row["roles"]);
    $r = array();
    foreach ($x as $key => $value) {
      $r[] = $roles_type[$value];
    }
    $row["roles_s"] = implode(", ", $r);
  }
$list[] = $row;
  $index ++;
}
$result["data"]["list"] = $list;
$result["status"] = NV_OK;