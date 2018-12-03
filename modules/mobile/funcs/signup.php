<?php

if (!defined('NV_IS_MOD_VAC')) {
  die('Stop!!!');
}

$username = $nv_Request->get_string('username', 'post/get', '');
$password = $nv_Request->get_string('password', 'post/get', '');
$name = $nv_Request->get_string('name', 'post/get', '');
$phone = $nv_Request->get_string('phone', 'post/get', '');
$address = $nv_Request->get_string('address', 'post/get', '');
$province = $nv_Request->get_string('province', 'post/get', '');
if (!(empty($username) || empty($password) || empty($name) || empty($phone) || empty($address)) && $province >= 0) {
  $sql = "SELECT * from user where username = '$username'";
  $query = $db->sql_query($sql);

  if (!$db->sql_numrows($query)) {
    $sql = "INSERT into user (username, password, name, phone, address, province, area) values ('$username', '$password', '$name', '$phone', '$address', $province, 0)";
    $id = $db->sql_query_insert_id($sql);
    if ($id) {
      $result["data"]["status"] = 2;
      $result["data"]["info"] = array("uid" => $id, "name" => $name, "phone" => $phone, "address" => $address);
    }
  } else {
    $result["data"]["status"] = 1;
  }
  if ($result["data"]["status"]) {
    $result["status"] = 1;
  }
}
