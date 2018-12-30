<?php

/**
 * @Project NUKEVIET-MUSIC
 * @Author Phan Tan Dung
 * @Copyright (C) 2011
 * @Createdate 26/01/2011 10:26 AM
 */

if (!defined('NV_IS_MOD_QUANLY')) die('Stop!!!');
$action = $nv_Request->get_string('action', 'post', '');

  if (!empty($action)) {
    $ret = array("status" => 0, "data" => array());
    switch ($action) {
      case "editNote":
      $note = $nv_Request->get_string('note', 'post', '');
      $id = $nv_Request->get_string('id', 'post', '');

      if (!(empty($id))) {
        $sql = "update `" . VAC_PREFIX . "_usg` set note = '$note' where id = $id";
        $result = $db->sql_query($sql);
        if ($result) {
          $ret["status"] = 1;
        }
      }
      break;
      case "birth":
      $id = $nv_Request->get_string('id', 'post', '');
      $petid = $nv_Request->get_string('petid', 'post', '');
      $birth = $nv_Request->get_int('birth', 'post', 1);
      $birthday = $nv_Request->get_string('birthday', 'post', '');

      if (!(empty($id) || empty($petid))) {
        if (empty($birthday)) {
          $birthday = date("Y-m-d");
        }
        if (!$birth) {
          $birth = 1;
        }
        $birthday = strtotime($birthday);
        $recall = $birthday + 60 * 60 * 24 * 60;
        $sql = "select * from " . VAC_PREFIX . "_pet where id = $petid";
        $query = $db->sql_query($sql);
        $customer = $db->sql_fetch_assoc($query);

        $sql = "update `" . VAC_PREFIX . "_usg` set birth = '$birth', birthday = " . $birthday . " where id = $id";
        $result = $db->sql_query($sql);
        
        $sql = "select * from " . VAC_PREFIX . "_usg where id = $id";
        $query = $db->sql_query($sql);
        $usg = $db->sql_fetch_assoc($query);

        $sql = "insert into " . VAC_PREFIX . "_pet (name, customerid) values('" . date("d/m/Y", $birthday) . "', $customer[id])";
        $pet_query = $db->sql_query($sql);
        
        if ($result && $pet_query) {
          $ret["status"] = 1;
          $ret["data"]["birth"] = $birth;
        }
      }
      break;
      case "exbirth":
      $id = $nv_Request->get_string('id', 'post', '');
      $petid = $nv_Request->get_string('petid', 'post', '');
      $birth = $nv_Request->get_int('birth', 'post', 1);

      if (!(empty($id) || empty($petid))) {
        if (!$birth) {
          $birth = 1;
        }
        
        $sql = "update `" . VAC_PREFIX . "_usg` set expectbirth = '$birth' where id = $id";
        $result = $db->sql_query($sql);
        echo $sql;
        
        if ($result) {
          $ret["status"] = 1;
          $ret["data"]["birth"] = $birth;
        }
      }
      break;
    }
    echo json_encode($ret);
    die();
  }

  $xtpl = new XTemplate("sieuam.tpl", NV_ROOTDIR . "/themes/" . $module_info['template'] . "/modules/" . $module_file);
  $xtpl->assign("lang", $lang_module);

  $today = date("Y-m-d", NV_CURRENTTIME);
  $dusinh = $module_config[$module_name]["expert_time"];
  if (empty($dusinh)) {
    $dusinh = 30 * 24 * 60 * 60;
  }
  // echo $thongbao; die();

  $xtpl->assign("now", $today);
  $xtpl->assign("dusinh", date("Y-m-d", strtotime($today) + $dusinh));

  $sql = "select * from " .  VAC_PREFIX . "_doctor";
  $result = $db->sql_query($sql);

  while ($row = $db->sql_fetch_assoc($result)) {
    $xtpl->assign("doctor_value", $row["id"]);
    $xtpl->assign("doctor_name", $row["name"]);
    $xtpl->parse("main.doctor");
  }

  $xtpl->parse("main");

  $contents = $xtpl->text("main");
  include ( NV_ROOTDIR . "/includes/header.php" );
  echo nv_site_theme($contents);
  include ( NV_ROOTDIR . "/includes/footer.php" );
?>
