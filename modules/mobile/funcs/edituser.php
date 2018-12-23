<?php

if (!defined('NV_IS_MOD_VAC')) {
  die('Stop!!!');
}

define('USER_PAGE_LIMIT', 12);
define('INITIAL_PAGE', 1);
define('NV_OK', 1);
define('NV_EXISTED', 2);
define('NV_PHONEHAVE', 3);

$username = $nv_Request->get_string('username', 'post/get', '');
$password = $nv_Request->get_string('password', 'post/get', '');
$name = $nv_Request->get_string('name', 'post/get', '');
$phone = $nv_Request->get_string('phone', 'post/get', '');
$address = $nv_Request->get_string('address', 'post/get', '');
$role = $nv_Request->get_string('role', 'post/get', '');
$roles = $nv_Request->get_string('roles', 'post/get', '');
$page = $nv_Request->get_string('page', 'post/get', '');
$uid = $nv_Request->get_string('uid', 'post/get', '');

if (!(empty($username) || empty($phone))) {
  $sql = "SELECT * from user where username = '$username' and phone = '" . $phone . "'";
  $query = $db->sql_query($sql);
  $row = $db->sql_fetch_assoc($query);

  $sql = "select * from user where id = " . $uid;
  $query = $db->sql_query($sql);
  $uorow = $db->sql_fetch_assoc($query);
  if (!validuser($username)) {
    $result["data"]["status"] = NV_EXISTED;
  }
  else if (!validphone($phone)) {
    $result["data"]["status"] = NV_PHONEHAVE;
  }
  else if ($row && (($role < $uorow["role"] && $row["role"] < $uorow["role"]) || $uorow["role"] == 3)) {
    if (!empty($name)) {
      $sql = "update user set name = '$name' where id = " . $row["id"];
      $query = $db->sql_query($sql);
    }
    if (!empty($phone)) {
      $sql = "update user set phone = '$phone' where  id = " . $row["id"];
      $query = $db->sql_query($sql);
    }
    if (!empty($address)) {
      $sql = "update user set address = '$address' where  id = " . $row["id"];
      $query = $db->sql_query($sql);
    }
    if (!empty($role)) {
      $sql = "update user set role = $role where  id = " . $row["id"];
      $query = $db->sql_query($sql);
    }
    $sql = "update user set roles = '$roles' where  id = " . $row["id"];
    $query = $db->sql_query($sql);
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
      $result["data"]["status"] = NV_OK;
      /* end: user */
      $result["status"] = 1;
  }
}
