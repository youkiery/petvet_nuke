<?php

/**
 * @Project NUKEVIET-MUSIC
 * @Author Phan Tan Dung
 * @Copyright (C) 2011
 * @Createdate 26/01/2011 10:26 AM
 */
if (!defined('NV_IS_MOD_VAC'))
  die('Stop!!!');
$action = $nv_Request->get_string('action', 'post', '');
$ret = array("status" => 0, "data" => array());

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

      echo json_encode($ret);
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

      echo json_encode($ret);
      break;
    case 'getpet':
      $customerid = $nv_Request->get_string('customerid', 'post', '');
      $sql = "select * from `" . VAC_PREFIX . "_pets` where customerid = $customerid";

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
        $sql = "select * from `" . VAC_PREFIX . "_customers` where phone = '$phone'";
        $result = $db->sql_query($sql);
        if (!$db->sql_numrows($result)) {
          $sql = "insert into `" . VAC_PREFIX . "_customers` (customer, phone, address) values ('$customer', '$phone', '$address');";
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
          $sql = "select * from `" . VAC_PREFIX . "_pets` where petname = '$petname' and customerid = $customerid";
          $result = $db->sql_query($sql);
          if (!$db->sql_numrows($result)) {
            $sql = "insert into `" . VAC_PREFIX . "_pets` (petname, customerid) values ('$petname', $customerid);";
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
          // echo($sql); die();
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

      echo json_encode($ret);
      break;
  }
  die();
}
?>
