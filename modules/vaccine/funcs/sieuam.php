<?php

/**
 * @Project NUKEVIET-MUSIC
 * @Author Phan Tan Dung
 * @Copyright (C) 2011
 * @Createdate 26/01/2011 10:26 AM
 */

if (!defined('NV_IS_MOD_QUANLY')) die('Stop!!!');
$action = $nv_Request->get_string('action', 'get/post', '');
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
      case "cvsieuam":
        $value = $nv_Request->get_string('value', 'get', '');
        $vacid = $nv_Request->get_string('vacid', 'get', '');
        $act = $nv_Request->get_string('act', 'get', '');
        if(!(empty($act) || empty($value) || empty($vacid))) {
          $mod = 0;
          if ($act == "up") {
            $mod = 1;
          } else {
            $mod = -1;
          }
          if (in_array($value, $lang_module["confirm_value"])) {
            $confirmid = array_search($value, $lang_module["confirm_value"]);
            $confirmid += $mod;
            if (!empty($lang_module["confirm_value"][$confirmid])) {
              $sql = "update " .  VAC_PREFIX . "_usg set vaccine = $confirmid where id = $vacid";
              $result = $db->sql_query($sql);
              if ($result) {
                $sql = "select * from " .  VAC_PREFIX . "_usg where id = $vacid";
                $result = $db->sql_query($sql);
                $row = $db->sql_fetch_assoc($result);
                if (empty($row["recall"]) || $row["recall"] == "0") $ret["data"]["recall"] = 0;
                else $ret["data"]["recall"] = 1;
                $ret["data"]["recall"] = $row["recall"];
                $ret["status"] = 1;
                $ret["data"]["value"] = $lang_module["confirm_value"][$confirmid];
                switch ($confirmid) {
                  case '1':
                    $color = "orange";
                    break;
                  case '2':
                    $color = "green";
                    break;
                  default:
                    $color = "red";
                }
                $ret["data"]["color"] = $color;
              }
            }
          }
        }
      break;
      case 'save':
      $recall = $nv_Request->get_string('recall', 'post', '');
      $doctor = $nv_Request->get_string('doctor', 'post', '');
      $vacid = $nv_Request->get_string('vacid', 'post', '');
      $petid = $nv_Request->get_string('petid', 'post', '');

      if (!(empty($petid) || empty($recall) || empty($doctor) || empty($vacid))) {
        $cometime = time();
        $calltime = strtotime($recall);

        $sql = "update `" . VAC_PREFIX . "_usg` set recall = $calltime where id = $vacid;";
        // echo $sql;
        if ($db->sql_query($sql)) {
          $sql = "insert into `" . VAC_PREFIX . "_vaccine` (petid, diseaseid, cometime, calltime, status, note, recall, doctorid) values ($petid, 0, $cometime, $calltime, 0, '', 0, 0);";
          // echo $sql;
          if ($db->sql_query($sql)) {
            $ret["status"] = 1;
          }
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
