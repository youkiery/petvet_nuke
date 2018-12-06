<?php

/**
 * @Project NUKEVIET-MUSIC
 * @Author Phan Tan Dung
 * @Copyright (C) 2011
 * @Createdate 26/01/2011 10:26 AM
 */
if (!defined('NV_IS_MOD_VAC')) {
  die('Stop!!!');
}
$action = $nv_Request->get_string('action', 'get/post', '');
$ret = array("status" => 0, "data" => array());

if ($action) {
  switch ($action) {
    case 'getcustomer':
      $customer = $nv_Request->get_string('customer', 'post', '');
      $phone = $nv_Request->get_string('phone', 'post', '');
      $ret["data"] = getcustomer($customer, $phone);
      if (count($ret["data"])) {
        $ret["status"] = 2;
      }
      break;
      case 'getpet':
      $customerid = $nv_Request->get_string('customerid', 'post', '');
      $sql = "select * from `" . VAC_PREFIX . "_pets` where customerid = $customerid";
      $result = $db->sql_query($sql);
      while ($row = $db->sql_fetch_assoc($result)) {
        $ret["data"][] = $row;
        $ret["status"] = 2;
      }
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
      break;
  }
}
echo json_encode($ret);
die();