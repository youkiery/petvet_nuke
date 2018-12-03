<?php

if (!defined('NV_IS_MOD_VAC')) {
  die('Stop!!!');
}

$username = $nv_Request->get_string('username', 'post/get', '');
$password = $nv_Request->get_string('password', 'post/get', '');
if (!(empty($username) || empty($password))) {
  $sql = "SELECT * from user where username = '$username'";
  $query = $db->sql_query($sql);
  // echo $sql;
  // var_dump($db->sql_fetch_assoc($query));

  if ($db->sql_numrows($query)) {
    $sql = "SELECT * from user where username = '$username' and password = '$password'";
    $query = $db->sql_query($sql);

    if ($db->sql_numrows($query)) {
      $row = $db->sql_fetch_assoc($query);
      $result["data"]["status"] = 3;
      $result["data"]["logininfo"] = array("uid" => $row["id"], "name" => $row["name"], "phone" => $row["phone"], "address" => $row["address"]);

      $sql = "SELECT count(id) as count from notify where user = $row[id] and view = 0 order by time desc";
      $query = $db->sql_query($sql);
      $row = $db->sql_fetch_assoc($query);
      $count = $row["count"];
      $result["data"]["new"] = $count;
    } else {
      $result["data"]["status"] = 2;
    }
  } else
    $result["data"]["status"] = 1;
  if ($result["data"]["status"]) {
    $result["status"] = 1;
  }
}
