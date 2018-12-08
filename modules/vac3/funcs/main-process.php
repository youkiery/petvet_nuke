<?php

/**
 * @Project TXManager
 * @Author Youkiery (youkiery@gmail.com)
 * @copyright 2018
 * @createdate 01/11/2018 08:00 AM
 */

if (!defined('NV_IS_MOD_VAC')) {
  die('Stop!!!');
}
$action = $nv_Request->get_string('action', 'get/post', '');
$ret = array("status" => 0, "data" => array());
if (!empty($action)) {
  switch ($action) {
    case 'confirm':
    $value = $nv_Request->get_string('value', 'post', '');
    $vacid = $nv_Request->get_string('id', 'post', '');
    $diseaseid = $nv_Request->get_string('diseaseid', 'post', '');
    $act = $nv_Request->get_string('act', 'post', '');

    $ret["step"] = 1;
    if(!(empty($act) || empty($value) || empty($vacid) || empty($diseaseid))) {
      $ret["step"] = 2;
      $mod = 0;
      if ($act == "up") {
        $mod = 1;
      } else if ($act == "down") {
        $mod = -1;
      }
      $value = mb_strtolower($value);
      $confirmid = array_search($value, $lang_module["confirm"]) + $mod;
      $confirm = $lang_module["confirm"][$confirmid];
      if ($confirm) {
        $sql = "update vng_vac_$diseaseid set status = $confirmid where id = $vacid";
        $result = $db->sql_query($sql);
        if ($result) {
          $sql = "select * from vng_vac_$diseaseid where id = $vacid";
          $result = $db->sql_query($sql);
          $row = $db->sql_fetch_assoc($result);
          if (empty($row["recall"]) || $row["recall"] == "0") $ret["data"]["recall"] = 0;
          else $ret["data"]["recall"] = 1;
          $ret["status"] = 1;
          $ret["data"]["value"] = $confirm;
          $color = parse_status_color($confirmid);
          $ret["data"]["color"] = $color;
        }
      }
    }
    break;
    case 'getrecall':
      $vacid = $nv_Request->get_string('vacid', 'post', '');
      $diseaseid = $nv_Request->get_string('diseaseid', 'post', '');
      $sql = "select a.recall, b.doctor from `" . VAC_PREFIX . "_$diseaseid` a inner join `" . VAC_PREFIX . "_$diseaseid` b on id = $vacid where a.doctorid = b.id";

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
      break;
    case 'save':
      $recall = $nv_Request->get_string('recall', 'post', '');
      $doctor = $nv_Request->get_string('doctor', 'post', '');
      $vacid = $nv_Request->get_string('vacid', 'post', '');
      $diseaseid = $nv_Request->get_string('diseaseid', 'post', '');
      $petid = $nv_Request->get_string('petid', 'post', '');
      $cometime = time();
      $calltime = strtotime($recall);
      $doctor ++;
      if (!(empty($petid) || empty($recall) || empty($doctor) || empty($vacid) || empty($diseaseid))) {
        $sql = "update `" . VAC_PREFIX . "_$diseaseid` set recall = '$recall', doctorid = $doctor where id = $vacid;";
        if ($db->sql_query($sql)) {
          $sql = "insert into `" . VAC_PREFIX . "_$diseaseid` (petid, cometime, calltime, status, note, recall, doctorid) values ($petid, $cometime, $calltime, 0, '', 0, 0);";
          if ($db->sql_query($sql)) {
            $ret["status"] = 1;
          }
        }
      }
      break;
    case 'insertvac':
      $petid = $nv_Request->get_string('petid', 'post', '');
      $customer = $nv_Request->get_string('customer', 'post', '');
      $phone = $nv_Request->get_string('phone', 'post', '');
      $address = $nv_Request->get_string('address', 'post', '');
      $diseaseid = $nv_Request->get_string('diseaseid', 'post', '');
      $cometime = $nv_Request->get_string('cometime', 'post', '');
      $calltime = $nv_Request->get_string('calltime', 'post', '');
      $note = $nv_Request->get_string('note', 'post', '');
      if (!(empty($petid) || empty($diseaseid) || empty($cometime) || empty($calltime))) {
        $sql = "select * from `" . VAC_PREFIX . "_pets` where id = $petid";
        $result = $db->sql_query($sql);
        $x = $db->sql_numrows($result);
        if ($db->sql_numrows($result)) {
          $cometime = strtotime($cometime);
          $calltime = strtotime($calltime);
          $sql = "select * from vng_vac_$diseaseid where petid = $petid order by id desc limit 0, 1";
          $query = $db->sql_query($sql);
          $x = array();
          $row = $db->sql_fetch_assoc($query);
          $sql = "update vng_vac_$diseaseid set status = 2, recall = $calltime where id = $row[id]";
          $db->sql_query($sql);
          $sql = "insert into `" . VAC_PREFIX . "_$diseaseid` (petid, cometime, calltime, note, status, doctorid, recall) values ($petid, $cometime, $calltime, '$note', 0, 0, 0);";
          $ret["sql"] = $sql;
          if ($id = $db->sql_query_insert_id($sql)) {
            if (!empty($phone)) {
              $sql = "update `" . VAC_PREFIX . "_customers` set customer = '$customer', address = '$address' where phone = '$phone'";
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
        $ret["data"] = filter(VAC_PATH, $lang_module, $fromtime, $time_amount, $sort);
      }
      break;
    case "editNote":
      $note = $nv_Request->get_string('note', 'post', '');
      $id = $nv_Request->get_string('id', 'post', '');
      $diseaseid = $nv_Request->get_string('diseaseid', 'post', '');
      $ret = array("status" => 0, "data" => array());
      if (!(empty($id))) {
        $sql = "update `" . VAC_PREFIX . "_$diseaseid` set note = '$note' where id = $id";
        $result = $db->sql_query($sql);
        if ($result) {
          $ret["data"] = $sql;
          $ret["status"] = 1;
        }
      }
      break;
  }
}
echo json_encode($ret);
die();
?>
