<?php

if (!defined('NV_IS_MOD_VAC')) {
  die('Stop!!!');
}

define('USER_PAGE_LIMIT', 12);
define('INITIAL_PAGE', 1);
define('NV_OK', 1);

$id = $nv_Request->get_string('id', 'post/get', '');
$page = $nv_Request->get_string('page', 'post/get', '');
if (!empty($id) && $id >= 0) {
  $sql = "select * from user where id = " . $id;
  $query = $db->sql_query($sql);
  $numrows = $db->sql_numrows($query);
  if ($numrows) {
    $sql = "delete from user where id = " . $id;
    $u_query = $db->sql_query($sql);

    if ($u_query) {
      /* start: user */
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
        $r = array();
        $x = array();
        if ($row["role"] == 3) {
          $row["roles"] = "aku";
        }
        if ($row["roles"]) {
          $x = str_split($row["roles"]);
        }
        foreach ($x as $key => $value) {
          $r[] = $roles_type[$value];
        }
        $row["roles_s"] = implode(", ", $r);
        $list[] = $row;
        $index ++;
      }
      /* end: user */
      $result["data"]["list"] = $list;
      $result["status"] = NV_OK;
    }
  }
}

