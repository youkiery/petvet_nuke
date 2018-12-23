<?php

if (!defined('NV_IS_MOD_VAC')) {
  die('Stop!!!');
}

define("NV_OK", 1);

$id = $nv_Request->get_string('id', 'post/get', '');
if (!empty($id) && $id >= 0) {
  $sql = "select * from species where id = " . $id;
  $query = $db->sql_query($sql);
  $numrows = $db->sql_numrows($query);
  if ($numrows) {
    $sql = "delete from species where id = " . $id;
    $s_query = $db->sql_query($sql);

    if ($s_query) {
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
      $result["status"] = NV_OK;
    }
  }
}

