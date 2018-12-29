<?php

if (!defined('NV_IS_MOD_VAC')) {
  die('Stop!!!');
}

define('USER_PAGE_LIMIT', 12);
define('INITIAL_PAGE', 1);
define('NV_OK', 1);
define('NV_NOTALLOW', 2);

$id = $nv_Request->get_string('id', 'post/get', '');
$role = $nv_Request->get_string('role', 'post/get', '');
$uid = $nv_Request->get_string('uid', 'post/get', '');
$page = $nv_Request->get_string('page', 'post/get', '');

if ($role >= 0 && $id >= 0 && $uid >= 0) {
  $sql = "select * from user where id = " . $id;
  $query = $db->sql_query($sql);
  $urow = $db->sql_fetch_assoc($query);

  $sql = "select * from user where id = " . $uid;
  $query = $db->sql_query($sql);
  $uorow = $db->sql_fetch_assoc($query);
  if ($urow && ($urow["role"] < $uorow["role"] || $uorow["role"] == 3)) {
    $sql = "update user set role = $role where id = " . $id;
    $u_query = $db->sql_query($sql);

    if ($u_query) {
      $result["data"]["role"] = $role;
      $result["data"]["roles"] = "as";
      $result["data"]["active"] = $urow["active"];
      /* start: user */
      if (empty($page) || $page < 0) {
        $page = INITIAL_PAGE;
      }
      
      $total = ($page - 1) * USER_PAGE_LIMIT;
      
      $sql = "select id, username, name, phone, address, province, role, roles, active from user limit " . USER_PAGE_LIMIT . " offset " . $total;
      $query = $db->sql_query($sql);
      $list = array();
      $index = ($page - 1) * USER_PAGE_LIMIT + 1;
      while ($row = $db->sql_fetch_assoc($query)) {
        $row["index"] = $index;
        $row["province"] = $config["province"][$row["province"]];
        $list[] = $row;
        $index ++;
      }
      /* end: user */
      $result["data"]["list"] = $list;
      $result["data"]["status"] = NV_OK;
    }
  }
  else {
    $result["data"]["status"] = NV_NOTALLOW;
  }
  $result["status"] = NV_OK;
}

