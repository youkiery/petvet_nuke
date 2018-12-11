<?php

/**
 * @Project NUKEVIET-MUSIC
 * @Author Phan Tan Dung
 * @Copyright (C) 2011
 * @Createdate 26/01/2011 10:26 AM
 */
if (!defined('NV_IS_MOD_QUANLY')) {
  die('Stop!!!');
}
$action = $nv_Request->get_string('action', 'post', '');
$ret = array("status" => 0, "data" => array());

quagio();
if (!empty($action)) {
  switch ($action) {
    case 'getcustomer':
      $customer = $nv_Request->get_string('customer', 'post', '');
      $phone = $nv_Request->get_string('phone', 'post', '');

      $ret["data"] = getcustomer($customer, $phone);
      if (count($ret["data"])) {
        $ret["status"] = 2;
      }
      echo json_encode($ret);
      break;
    case 'getrecall':
      $vacid = $nv_Request->get_string('vacid', 'post', '');
      $diseaseid = $nv_Request->get_string('diseaseid', 'post', '');
      $sql = "select a.recall, b.doctor from `" . VAC_PREFIX . "_vaccine` a inner join `" . VAC_PREFIX . "_vaccine` b on id = $vacid where a.doctorid = b.id";

      $result = $db->sql_query($sql);
      $check = true;
      $row = $db->sql_fetch_assoc($result);
      if ($row["recall"]) {
        $ret["status"] = 1;
        $ret["data"] = $row;
      } else {
        $sql = "select * from `" . VAC_PREFIX . "_doctor`";
        $result = $db->sql_query($sql);
        $doctor = array();
        while ($row = $db->sql_fetch_assoc($result)) {
          $doctor[] = $row;
        }
        $ret["data"] = $doctor;
      }

      echo json_encode($ret);
      break;
    case 'save':
      $recall = $nv_Request->get_string('recall', 'post', '');
      $doctor = $nv_Request->get_string('doctor', 'post', '');
      $vacid = $nv_Request->get_string('vacid', 'post', '');
      $diseaseid = $nv_Request->get_string('diseaseid', 'post', '');
      $petid = $nv_Request->get_string('petid', 'post', '');

      if (!(empty($petid) || empty($recall) || empty($doctor) || empty($vacid) || empty($diseaseid))) {
        $cometime = time();
        $calltime = strtotime($recall);

        $sql = "update `" . VAC_PREFIX . "_vaccine` set recall = $calltime, doctorid = $doctor where id = $vacid;";
        if ($db->sql_query($sql)) {
          $sql = "insert into `" . VAC_PREFIX . "_vaccine` (petid, diseaseid, cometime, calltime, status, note, recall, doctorid) values ($petid, $diseaseid, $cometime, $calltime, 0, '', 0, 0);";
          if ($db->sql_query($sql)) {
            $ret["status"] = 1;
          }
        }
      }

      echo json_encode($ret);
      break;
    case 'getpet':
      $customerid = $nv_Request->get_string('customerid', 'post', '');
      $sql = "select * from `" . VAC_PREFIX . "_pet` where customerid = $customerid";

      $result = $db->sql_query($sql);
      while ($row = $db->sql_fetch_assoc($result)) {
        $ret["data"][] = $row;
        $ret["status"] = 2;
      }
      echo json_encode($ret);
      break;
    case 'addcustomer':
      $customer = $nv_Request->get_string('customer', 'post', '');
      $phone = $nv_Request->get_string('phone', 'post', '');
      $address = $nv_Request->get_string('address', 'post', '');

      if (!(empty($customer) || empty($phone))) {
        $sql = "select * from `" . VAC_PREFIX . "_customer` where phone = '$phone'";
        $result = $db->sql_query($sql);
        if (!$db->sql_numrows($result)) {
          $sql = "insert into `" . VAC_PREFIX . "_customer` (name, phone, address) values ('$customer', '$phone', '$address');";
          if ($id = $db->sql_query_insert_id($sql)) {
            $ret["status"] = 2;
            $ret["data"][] = array("id" => $id);
          }
        } else {
          $ret["status"] = 1;
        }
      }

      echo json_encode($ret);
      break;
    case 'addpet':
      $customerid = $nv_Request->get_string('customerid', 'post', '');
      $petname = $nv_Request->get_string('petname', 'post', '');

      if (!empty($customerid)) {
        if (!empty($petname)) {
          $sql = "select * from `" . VAC_PREFIX . "_pet` where petname = '$petname' and customerid = $customerid";
          $result = $db->sql_query($sql);
          if (!$db->sql_numrows($result)) {
            $sql = "insert into `" . VAC_PREFIX . "_pet` (name  , customerid) values ('$petname', $customerid);";
            if ($id = $db->sql_query_insert_id($sql)) {
              $ret["status"] = 2;
              $ret["data"][] = array("id" => $id);
            }
          } else {
            $ret["status"] = 1;
          }
        } else {
          $ret["status"] = 3;
        }
      } else {
        $ret["status"] = 4;
      }

      echo json_encode($ret);
      break;
    case 'insertvac':
      $petid = $nv_Request->get_string('petid', 'post', '');
      $customer = $nv_Request->get_string('customer', 'post', '');
      $phone = $nv_Request->get_string('phone', 'post', '');
      $address = $nv_Request->get_string('address', 'post', '');
      $diseaseid = $nv_Request->get_string('diseaseid', 'post', '');
      $doctorid = $nv_Request->get_string('doctorid', 'post', '');
      $cometime = $nv_Request->get_string('cometime', 'post', '');
      $calltime = $nv_Request->get_string('calltime', 'post', '');
      $note = $nv_Request->get_string('note', 'post', '');

      if (!(empty($petid) || empty($diseaseid) || empty($cometime) || empty($calltime))) {
        $sql = "select * from `" . VAC_PREFIX . "_pet` where id = $petid";
        $result = $db->sql_query($sql);
        $x = $db->sql_numrows($result);
        if ($db->sql_numrows($result)) {
          $cometime = strtotime($cometime);
          $calltime = strtotime($calltime);

          $sql = "select * from " . VAC_PREFIX . "_vaccine where petid = $petid order by id desc limit 0, 1";
          $query = $db->sql_query($sql);
          $x = array();
          $row = $db->sql_fetch_assoc($query);
          $sql = "update " . VAC_PREFIX . "_vaccine set status = 2, recall = $calltime where id = $row[id]";
          // echo($sql); die();
          $db->sql_query($sql);

          $sql = "insert into `" . VAC_PREFIX . "_vaccine` (petid, cometime, calltime, doctorid, note, status, diseaseid, recall) values ($petid, $cometime, $calltime, $doctorid, '$note', 0, $diseaseid, 0);";
          $ret["sql"] = $sql;

          if ($id = $db->sql_query_insert_id($sql)) {
            if (!empty($phone)) {
              $sql = "update `" . VAC_PREFIX . "_customer` set name = '$customer', address = '$address' where phone = '$phone'";
              $ret["data"] = $sql;
              $db->sql_query($sql);
            }
            $ret["status"] = 2;
          } else {
            $ret["status"] = 5;
          }
        } else {
          $ret["status"] = 3;
        }
      }

      echo json_encode($ret);
      break;
    case "filter":
      $fromtime = $nv_Request->get_string('fromtime', 'post', '');
      $time_amount = $nv_Request->get_string('time_amount', 'post', '');
      $sort = $nv_Request->get_string('sort', 'post', '');
      $ret = array("status" => 0, "data" => array());

      if (!(empty($fromtime) || empty($time_amount) || empty($sort))) {
        $_SESSION["vac_filter"]["sort"] = $sort;
        $_SESSION["vac_filter"]["time_amount"] = $time_amount;
        $ret["status"] = 1;
        $ret["data"] = filter(NV_ROOTDIR . "/themes/" . $module_info['template'] . "/modules/" . $module_file, $lang_module, $fromtime, $time_amount, $sort);
      }

      echo json_encode($ret);
      break;
    case "editNote":
      $note = $nv_Request->get_string('note', 'post', '');
      $id = $nv_Request->get_string('id', 'post', '');
      $ret = array("status" => 0, "data" => array());

      if (!(empty($id))) {
        $sql = "update `" . VAC_PREFIX . "_vaccine` set note = '$note' where id = $id";
        $result = $db->sql_query($sql);
        if ($result) {
          $ret["data"] = $sql;
          $ret["status"] = 1;
        }
      }

      echo json_encode($ret);
      break;
  }
  die();
}

$page_default = true;

if (!empty($array_op[0])) {
  $page = $array_op[0];
  $page_allowed = array(
    "list", "search", "confirm"
  );
  if (in_array($page, $page_allowed)) {
    $page_default = false;
    include_once ( NV_ROOTDIR . "/modules/" . $module_file . "/funcs/$page.php" );
  }
}
if ($page_default) {
  $page_title = $module_info['custom_title'];
  $key_words = $module_info['keywords'];

  $xtpl = new XTemplate("main.tpl", NV_ROOTDIR . "/themes/" . $module_info['template'] . "/modules/" . $module_file);
  $xtpl->assign("lang", $lang_module);
  $xtpl->assign("now", date("Y-m-d", NV_CURRENTTIME));
  // note: nexttime take from config
  $xtpl->assign("calltime", date("Y-m-d", NV_CURRENTTIME + 21 * 24 * 60 * 60));

  $sql = "select * from " . VAC_PREFIX . "_doctor";
  $query = $db->sql_query($sql);
  while ($row = $db->sql_fetch_assoc($query)) {
    $xtpl->assign("doctorid", $row["id"]);
    $xtpl->assign("doctorname", $row["name"]);
    $xtpl->parse("main.doctor");
  }
  $diseases = getDiseaseList();
  foreach ($diseases as $key => $value) {
    $xtpl->assign("disease_id", $value["id"]);
    $xtpl->assign("disease_name", $value["name"]);
    $xtpl->parse("main.option");
  }
}
$xtpl->parse("main");
$contents = $xtpl->text("main");
include ( NV_ROOTDIR . "/includes/header.php" );
echo nv_site_theme($contents);
include ( NV_ROOTDIR . "/includes/footer.php" );
?>
