<?php

if (!defined('NV_IS_MOD_VAC')) {
  die('Stop!!!');
}

define('NV_OK', 1);
define('NV_PHONEEXSIT', 2);
define('NV_USEREXIST', 3);

$username = $nv_Request->get_string('username', 'post/get', '');
$password = $nv_Request->get_string('password', 'post/get', '');
$name = $nv_Request->get_string('name', 'post/get', '');
$phone = $nv_Request->get_string('phone', 'post/get', '');
$address = $nv_Request->get_string('address', 'post/get', '');
$province = $nv_Request->get_string('province', 'post/get', '');
if (!(empty($username) || empty($password) || empty($name) || empty($phone)) && $province >= 0) {
  $sql = "SELECT * from user where username = '$username' or phone = '" . $phone . "'";
  $query = $db->sql_query($sql);

  if (!validphone($phone)) {
    $result["data"]["status"] = NV_PHONEEXSIT;
  }
  else if (!validuser($username)) {
    $result["data"]["status"] = NV_USEREXIST;
  }
  else {
    $sql = "INSERT into user (username, password, name, phone, address, province, area) values ('$username', '$password', '$name', '$phone', '$address', $province, 0)";
    $id = $db->sql_query_insert_id($sql);
    if ($id) {
      $result["data"]["status"] = NV_OK;
      $sql = "select * from user where  id = $id";
      $query = $db->sql_query($sql);
      $row = $db->sql_fetch_assoc($query);
      $result["data"]["info"] = $row;
    }
  }
  if ($result["data"]["status"]) {
    $result["status"] = 1;
  }
}
