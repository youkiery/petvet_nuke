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
    case 'insertusg':
    $petid = $nv_Request->get_string('petid', 'post/get', '');
    $cometime = $nv_Request->get_string('cometime', 'post', '');
    $calltime = $nv_Request->get_string('calltime', 'post', '');
    $image = $nv_Request->get_string('image', 'post', '');
    $doctorid = $nv_Request->get_string('doctorid', 'post', '');
    $note = $nv_Request->get_string('note', 'post', '');
    $customer = $nv_Request->get_string('customer', 'post', '');
    $phone = $nv_Request->get_string('phone', 'post', '');
    $address = $nv_Request->get_string('address', 'post', '');
    $ret = array("status" => 0, "data" => array());
    // var_dump($_POST);
    
    if ( ! ( empty($petid) || empty($doctorid) || empty($cometime) || empty($calltime) ) ) {
      $sql = "select id from `" . VAC_PREFIX . "_pets` where id = $petid";
      $result = $db->sql_query($sql);
    
      if ($db->sql_numrows($result)) {
        $sql = "INSERT INTO `" . VAC_PREFIX . "_usg` (`petid`, `doctorid`, `cometime`, `calltime`, `image`, `status`, `note`) VALUES ($petid, $doctorid, ". strtotime($cometime) .", ". strtotime($calltime) .", '$image', 0, '$note')";
        $insert_id = $db->sql_query_insert_id($sql);
    
        // if ($sql) {
        if ($insert_id) {
          if (!empty($phone)) {
            $sql = "update `" . VAC_PREFIX . "_customers` set customer = '$customer', address = '$address' where phone = '$phone'";
            $db->sql_query($sql);
          }
          $ret["status"] = 1;
          $ret["data"] = $lang_module["themsatc"];
        }
      }
    }
    
    if (!$ret["status"]) {
      $ret["data"] = $lang_module["themsatb"];
    }
    break;
    case 'confirm':
    $id = $nv_Request->get_string('id', 'post', '');
    $value = $nv_Request->get_string('value', 'post', '');
    $act = $nv_Request->get_string('act', 'post', '');
    if(!(empty($act) || empty($value) || empty($id))) {
      $mod = 0;
      if ($act == "up") {
        $mod = 1;
      } else if ($act == "down") {
        $mod = -1;
      }
      $value = mb_strtolower($value);
      $confirmid = array_search($value, $lang_module["confirm2"]) + $mod;
      $confirm = $lang_module["confirm2"][$confirmid];
      if ($confirm) {
        $sql = "update `" . VAC_PREFIX . "_usg` set status = $confirmid where id = $id";
        $result = $db->sql_query($sql);
        if ($result) {
          $ret["status"] = 1;
          $ret["data"]["value"] = $confirm;
          $color = parse_status_color($confirmid);
          $ret["data"]["color"] = $color;
        }
      }
    }
    break;
    case "editNote":
      $note = $nv_Request->get_string('note', 'post', '');
      $id = $nv_Request->get_string('id', 'post', '');
      $ret = array("status" => 0, "data" => array());

      if (!(empty($id))) {
        $sql = "update `" . VAC_PREFIX . "_usg` set note = '$note' where id = $id";
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
