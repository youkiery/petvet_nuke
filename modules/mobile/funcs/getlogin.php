<?php
if (!defined('NV_IS_MOD_VAC')) {
  die('Stop!!!');
}
$uid = $nv_Request->get_string('uid', 'post/get', '');
      $count = 0;
      if ($uid >= 0) {
        $sql = "SELECT * from user where id = $uid";
        $query = $db->sql_query($sql);

        if ($db->sql_numrows($query)) {
          $row = $db->sql_fetch_assoc($query);
          $result["data"]["logininfo"] = array("uid" => $row["id"], "name" => $row["name"], "phone" => $row["phone"], "address" => $row["address"], "province" => $row["province"]);
        }
        if ($uid) {
          $sql = "SELECT count(id) as count from notify where user = $uid and view = 0 order by time desc";
          $result["sql"] = $sql;
  
          $query = $db->sql_query($sql);
          $row = $db->sql_fetch_assoc($query);
          $count = $row["count"];
        }
        else {
          $count = 0;
        }
        $result["data"]["new"] = $count;
      }

      $sql = 'SELECT * from kind';
      $query = $db->sql_query($sql);
      $result["data"]["kind"] = sqlfetchall($db, $query);
      $result["data"]["species"] = array();

      foreach ($result["data"]["kind"] as $key => $value) {
        $sql = "SELECT * from species where kind = $value[id]";
        $query = $db->sql_query($sql);

        $data = sqlfetchall($db, $query);
        $result["data"]["species"][$value["id"]][0] = array("id" => 0, "name" => "Chưa chọn");
        foreach ($data as $key => $row) {
          $result["data"]["species"][$value["id"]][] = $row;
        }
      }

      $result["status"] = 1;
      $result["data"]["type"] = $type;
      $result["data"]["config"] = $config;
      filterbase();
