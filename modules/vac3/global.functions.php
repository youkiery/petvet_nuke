<?php

/**
 * @Project TXManager
 * @Author Youkiery (youkiery@gmail.com)
 * @copyright 2018
 * @createdate 01/11/2018 08:00 AM
 */

 if (!defined('NV_MAINFILE')) {
  die('Stop!!!');
}

function insert_vaccine($petid, $diseaseid, $cometime, $calltime, $note) {
  global $db;
  if (!(empty($petid) || empty($diseaseid) || empty($cometime) || empty($calltime))) {
    $vaccine_sql = "INSERT INTO " . VAC_PREFIX . "_vaccine (petid, diseaseid, cometime, calltime, status, note, recall) VALUES ($petid, $diseaseid, $cometime, $calltime, $status, $note, $recall)";
    $vaccine_query = $db->sql_query($vaccine_sql);
    if () {
      return true;
    }
  }
  return false;
}

function find_last_vaccine($petid, $diseaseid) {
  global $db;
  $vaccine_list = array();
  if (!(empty($petid) || empty($diseaseid))) {
    $vaccine_sql = "SELECT * from " . VAC_PREFIX . "_vaccine where petid = $petid and diseaseid = $diseaseid order by id desc";
    if ($vaccine_query = $db->sql_query($vaccine_sql)) {
      $vaccine_list = $db->sql_fetch_assoc($vaccine_query);
      return $vaccine_list;
    }
  }
  return $vaccine_list;
}

function get_customer_list() {
  global $db;
  $result = array();
  $customer_sql = "SELECT * from " . VAC_PREFIX . "_customer";
  $customer_query = $db->sql_query($customer_sql);
  if ($customer_list = fetchall($customer_query)) {
    foreach ($customer_list as $customer) {
      if ($temp_customer = return_customer($customer)) {
        $result[] = $temp_customer;
      }
    }
  }
  return $result;
}

function get_customer($id, $keyword = "") {
  global $db;
  $result = array();
  $customer_sql = "SELECT * from " . VAC_PREFIX . "_customer";
  if ($keyword) {
    $customer_sql .= " where name like '" . $keyword . "' or phone lke  like '" . $keyword . "'";
  }
  $customer_query = $db->sql_query($customer_sql);
  if ($customer = $db->sql_fetch_assoc($customer_query)) {
    return return_customer($customer);
  }
  return false;
}

function insert_customer($name, $phone, $address) {
  global $db;
  if (!(empty($name) || empty($phone))) {
    $sql = "INSERT into " . VAC_PREFIX . "_customer (name, phone, address) values ('". $name ."', '". $name ."', '". $name ."')";
    $customer_query = $db->sql_query($sql);
    if ($customer_query) {
      return true;
    }
  }
  return false;
}

// trả về name, address, phone
function return_customer($customer) {
  if (!(empty($customer["name"]) || empty($customer["phone"]))) {
    return array("name" => $customer["name"], "address" => $customer["address"], "phone" => $customer["phone"]);
  }
  return false;
}

function get_pet_list() {
  global $db;
  $result = array();
  $pet_sql = "SELECT * from " . VAC_PREFIX . "_pet";
  $pet_query = $db->sql_query($pet_sql);
  if ($pet_list = fetchall($pet_query)) {
    foreach ($pet_list as $pet) {
      if ($temp_pet = return_pet($pet)) {
        $result[] = $temp_pet;
      }
    }
  }
  return $result;
}

function get_pet($id, $keyword = "") {
  global $db;
  $result = array();
  $pet_sql = "SELECT * from " . VAC_PREFIX . "_pet";
  if ($keyword) {
    $pet_sql .= " where name like '" . $keyword . "'";
  }
  $pet_query = $db->sql_query($pet_sql);
  if ($pet = $db->sql_fetch_assoc($pet_query)) {
    return return_pet($pet);
  }
  return false;
}

function insert_pet($name, $customerid) {
  global $db;
  if (!(empty($name) || empty($customerid))) {
    $customer = get_customer($customerid);
    if ($customer) {
      $sql = "INSERT into " . VAC_PREFIX . "_pet (name, phone, address) values ('". $name ."', '". $name ."', '". $name ."')";
      $pet_query = $db->sql_query($sql);
      if ($pet_query) {
        return true;
      }
    }
  }
  return false;
}

// trả về name, address, phone
function return_pet($pet) {
  if (!(empty($pet["name"]))) {
    return array("name" => $pet["name"]);
  }
  return false;
}

// Lấy danh sách bệnh trả về array(id => name)
function get_disease_list() {
  global $db;
  $result = array();
  $disease_sql = "SELECT * from " . VAC_PREFIX . "_disease";
  $disease_query = $db->sql_query($disease_sql);
  if ($disease_list = fetchall($disease_query)) {
    $result = transform($disease_list);
  }
  return $result;
}

// chuyển list thành object
function transform($list) {
  $result = array();
  foreach ($list as $row) {
    $result[$row["id"]] = $row;
  }
  return $result;
}

// Nếu quá giờ làm việc sẽ chặn đường vào
function overtime() {
  global $global_config, $admin_info;
  $today = strtotime(date("Y-m-d"));
  $from = $global_config["worktime"] ? $global_config["worktime"] : $today + 7 * 60 * 60;
  $end = $global_config["resttime"] ? $global_config["resttime"] : $today + 17 * 60 * 60 + 30 * 60;

  if ((NV_CURRENTTIME < $from || NV_CURRENTTIME > $end) && !($admin_info["level"] == "1")) {
    $xtpl = new XTemplate("overtime.tpl", VAC_PATH);
    $xtpl->assign("lang", $lang_module);
    $xtpl->parse("overtime");

    $contents = $xtpl->text("overtime");
    include ( NV_ROOTDIR . "/includes/header.php" );
    echo nv_site_theme($contents);
    include ( NV_ROOTDIR . "/includes/footer.php" );
    die();
  }
}
function fetchall($query) {
  global $db;
  $result = array();
  while ($row = $db->sql_fetch_assoc($query)) {
      $result[] = $row;
  }
  return $result;
}

function transprop($object, $proplist) {
  foreach ($proplist as $key => $value) {
    $object[$key] = $value;
  }
  return $object;
}

?>
