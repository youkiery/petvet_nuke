<?php

if (!defined('NV_IS_MOD_VAC')) {
  die('Stop!!!');
}

$name = $nv_Request->get_string('name', 'post/get', '');
$kind = $nv_Request->get_string('kind', 'post/get', '');
if (!empty($name) && $kind >= 0) {
  $sql = "insert into species (name, kind) values ('" . $name . "', " . $kind . ")";
  $query = $db->sql_query($sql);
  if ($query) {
    $result["status"] = 1;
    /* start: species */
    $sql = "select * from kind";
    $query = $db->sql_query($sql);
    $list = array();
    while ($row = $db->sql_fetch_assoc($query)) {
      $list[] = $row;
      $sql = "select * from species where kind = " . $row["id"];
      $query2 = $db->sql_query($sql);
      $x = array();
      while ($crow = $db->sql_fetch_assoc($query2)) {
        $x[] = $crow;
      }
      $list[count($list) - 1]["list"] = $x;
    }
    $result["data"]["list"] = $list;
    /* end: species */
  }
  $result["status"] = 1;
}
