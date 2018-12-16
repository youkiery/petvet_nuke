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
if (!empty($global_config['module_theme'])) {
  define('THEME', $global_config['module_theme']);
} else if (!empty($module_info['theme'])) {
  define('THEME', $module_info['theme']);
}
define("DEFAULT_IMAGE", "/theme/" . THEME . "/images/" . $module_file . "/usg-no-image.jpg");
$sort = array("1" => array("name" => "Tên A-Z", "value" => "name asc"), "2" => array("name" => "Tên Z-A", "value" => "name desc"), "3" => array("name" => "Ngày báo giảm", "value" => "calltime desc"), "4" => array("name" => "Ngày báo tăng", "value" => "calltime asc"), "5" => array("name" => "Ngày đến giảm", "value" => "cometime asc"), "6" => array("name" => "Ngày đến tăng", "value" => "cometime desc"));
$vaccine_status = array("chưa gọi", "đã gọi", "đã tiêm", "đã tái chủng");
$usg_status = array("chưa gọi", "đã gọi", "đã siêu âm", "đã đã sinh");
$status_color = array("red", "orange", "yellow", "green");
$result = array("status" => 0);

// function đã làm: thêm vaccine, tìm vaccine cuối, lấy danh sách khách hàng, thêm khách hàng, lấy khách hàng, lấy danh sách thú cưng, thêm thú cưng, lấy thú cưng, lấy danh sách bệnh, thêm/sửa/xóa bệnh, sửa danh sách bệnh, tạo truy vấn lọc, đảo vị, chuyển list thành obj, quá giờ, thêm/sửa/xóa/confirm vaccine/usg
// function sẽ làm: 
// chuẩn bị sửa: confirm, overtime

// xác nhận vaccine, trả về màu, tên giá trị
function confirm_usg($id, $status, $mod_index) {
  global $db, $usg_status, $status_color;
  $result = array();
  $status = mb_strtolower($status);
  $confirmid = array_search($status, $usg_status);
  $new_confirmid = array_search($usg_status[$confirmid + $mod_index], $usg_status);
  if ($new_confirmid >= 0) {
    $sql = "update " . VAC_PREFIX . "_usg set status = " . $new_confirmid . " where id = " . $id;
    if ($db->sql_query($sql)) {
      $result["color"] = $usg_status[$new_confirmid];
      $result["value"] = $usg_status[$new_confirmid];
    }
  }
  return $result;
}

function insert_usg($petid, $cometime, $calltime, $doctorid, $image, $note) {
  global $db;
  if (!(empty($petid) || empty($cometime) || empty($calltime) || empty($doctorid))) {
    if (empty($image)) {
      $image = DEFAULT_IMAGE;
    }
    $sql = "INSERT INTO " . VAC_PREFIX . "_usg (petid, doctorid, cometime, calltime, image, note) VALUES ($petid, $doctorid, $cometime, $calltime, '$image', '$note')";
    $query = $db->sql_query($sql);
    if ($query) {
      return true;
    }
  }
  return false;
}

function update_usg($petid, $cometime, $calltime, $doctorid, $image, $note) {
  global $db;
  if (!(empty($petid) || empty($cometime) || empty($calltime) || empty($doctorid))) {
    if (empty($image)) {
      $image = DEFAULT_IMAGE;
    }
    $sql = "INSERT INTO " . VAC_PREFIX . "_usg (petid, doctorid, cometime, calltime, image, note) VALUES ($petid, $doctorid, $cometime, $calltime, '$image', '$note')";
    $query = $db->sql_query($sql);
    if ($query) {
      return true;
    }
  }
  return false;
}

function get_usg_list($filter = array()) {
  global $db;
  $sql = "select * from " . VAC_PREFIX . "_usg " . parse_filter($filter);
  $result = array();
  if ($query = $db->sql_query($sql)) {
    $result = fetchall($query);
  }
  return $result;
}

function confirm_vaccine($id, $status, $mod_index) {
  global $db, $vaccine_status, $status_color;
  $result = array();
  $status = mb_strtolower($status);
  $confirmid = array_search($status, $vaccine_status);
  $new_confirmid = array_search($vaccine_status[$confirmid + $mod_index], $vaccine_status);
  if ($new_confirmid >= 0) {
    $sql = "update " . VAC_PREFIX . "_vaccine set status = " . $new_confirmid . " where id = " . $id;
    if ($db->sql_query($sql)) {
      $result["color"] = $status_color[$new_confirmid];
      $result["value"] = $vaccine_status[$new_confirmid];
    }
  }
  return $result;
}

function insert_vaccine($petid, $doctorid, $diseaseid, $cometime, $calltime, $note) {
  global $db;
  if (!(empty($petid) || empty($doctorid) || empty($diseaseid) || empty($cometime) || empty($calltime))) {
    $sql = "INSERT INTO " . VAC_PREFIX . "_vaccine (petid, doctorid, diseaseid, cometime, calltime, note) VALUES ($petid, $doctorid, $diseaseid, $cometime, $calltime, '$note')";
    $query = $db->sql_query($sql);
    if ($query) {
      return true;
    }
  }
  return false;
}

function insert_doctor($name) {
  global $db;
  if (!(empty($name))) {
    $sql = "INSERT INTO " . VAC_PREFIX . "_doctor (name) VALUES ('". $name ."')";
    $query = $db->sql_query($sql);
    if ($query) {
      return true;
    }
  }
  return false;
}

function get_doctor_list() {
  global $db;
  $result = array();
  $sql = "select * " . VAC_PREFIX . "_doctor";
  $query = $db->sql_query($sql);
  if ($query) {
    $result = transform(fetchall($query));
  }
  return $result;
}

function get_vaccine_list($filter = array()) {
  global $db;
  $result = array();
  $sql = "select * from " . VAC_PREFIX . "_vaccine " . parse_filter($filter);
  if ($query = $db->sql_query($sql)) {
    $result = fetchall($query);
  }
  return $result;
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

function get_customer_list($filter = array()) {
  global $db;
  $result = array();
  $customer_sql = "SELECT * from " . VAC_PREFIX . "_customer " . parse_filter($filter);
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

function get_customer($id) {
  global $db;
  $result = array();
  $customer_sql = "SELECT * from " . VAC_PREFIX . "_customer";
  $customer_query = $db->sql_query($customer_sql);
  if ($customer = $db->sql_fetch_assoc($customer_query)) {
    return $customer;
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

function get_pet_list($filter = array()) {
  global $db;
  $result = array();
  $pet_sql = "SELECT * from " . VAC_PREFIX . "_pet " . parse_filter($filter);
  $pet_query = $db->sql_query($pet_sql);
  if ($pet_list = fetchall($pet_query)) {
    $result = $pet;
  }
  return $result;
}

function get_pet($id) {
  global $db;
  $result = array();
  $pet_sql = "SELECT * from " . VAC_PREFIX . "_pet";
  $pet_query = $db->sql_query($pet_sql);
  if ($pet = $db->sql_fetch_assoc($pet_query)) {
    return $pet;
  }
  return false;
}

function insert_pet($name, $customerid) {
  global $db;
  if (!(empty($name) || empty($customerid))) {
    $customer = get_customer($customerid);
    if ($customer) {
      $sql = "INSERT into " . VAC_PREFIX . "_pet (name, customerid) values ('". $name ."', ". $customerid .")";
      $pet_query = $db->sql_query($sql);
      if ($pet_query) {
        return true;
      }
    }
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

// sửa bệnh
function mod_disease($mod_list) {
  global $db;
  $disease_list = get_disease_list();
  $disease_count = count($disease_list);
  $mod_count = count($mod_list);
  foreach ($disease_list as $d_key => $disease_row) {
    if ($d_key >= $mod_count) {
      $mod_list["action"] = 1; // delete
    }
    else {
      $mod_list["action"] = 2; // update
    }
  }
	foreach ($mod_list as $mod_row) {
		switch ($mod_row["action"]) {
      case 1:
      $sql = "delete from `" . VAC_PREFIX . "_disease` where id = " . $id;
      $db->sql_query($sql);
      break;
			case 2:
      $sql = "update `" . VAC_PREFIX . "_disease` set name = '". $name ."' where id = " . $id;
      $db->sql_query($sql);
      break;
			default:
      $sql = "insert into `" . VAC_PREFIX . "_disease` (id, name) values(". $id . ", '" . $name . "')";
      $db->sql_query($sql);
    }
	}
}

function parse_vaccine($row, $disease, $doctor) {
  $pet = get_pet($row["petid"]);
  $doctor = get_pet($row["doctorid"]);
  $customer = get_customer($pet["customerid"]);
  $row["petname"] = $pet["name"];
  $row["disease"] = $disease[$row["diseaseid"]]["name"];
  $row["doctor"] = $doctor["name"];
  $row["customer"] = $customer["name"];
  $row["phone"] = $customer["phone"];
  $row["address"] = $customer["address"];
  $row["cometime"] = date("d/m/Y", $row["cometime"]);
  $row["calltime"] = date("d/m/Y", $row["calltime"]);
  return $row;
}

// tạo truy vấn lọc, trả về query string
function parse_filter($filter = array()) {
  global $sort;
  $result = "";
  $order = array();
  $where = array();
  $limit = "";
  if (!(empty($filter["limit"]) || empty($filter["page"]))) {
    $from = ($filter["page"] - 1) * $filter["limit"];
    $end = $from + $filter["limit"];
    $limit = "limit $from, $end";
  }

  if (!empty($filter["sort"])) {
    $order[] = $sort[$filter["sort"]]["value"];
  }
  if (!empty($filter["keyword"])) {
    if (!empty($filter["customer"])) {
      $where[] = "name like '%" . $filter["keyword"] . "%' or phone like '" . $filter["keyword"] . "'";
    }
    if (!empty($filter["pet"])) {
      $where[] = "name like '%" . $filter["keyword"] . "%'";
    }
  }
  $tick = 0;
  if (!empty($filter["from"])) {
    $tick += 1;
  }
  if (!empty($filter["end"])) {
    $tick += 2;    
  }
  if (!empty($filter["time_type"])) {
    switch ($filter["time_type"]) {
      case 1:
      $time_type = "calltime";
      break;
      case 2:
      $time_type = "cometime";
      break;
      case 2:
      $time_type = "time";
      break;
      default:
      $time_type = "calltime";
    }
    switch ($tick) {
      case 1:
      $where[] = $time_type . " >= " . $filter["from"];
      break;
      case 2:
      $where[] = $time_type . " <= " . $filter["end"];
      break;
      case 3:
      if ($filter["end"] < $filter["from"]) {
        swap($filter["from"], $filter["end"]);
      }
      $where[] = $time_type . " between " . $filter["from"] . " and " . $filter["end"];
      break;
    }
  }

  if (count($where)) {
    $result = "where " . implode(" and ", $where);
  }
  if (count($order)) {
    $result .= " order by " . implode(" and ", $order);
  }
  if (!empty($limit)) {
    $result .= " " . $limit;
  }
  return $result;
}

// đảo giá trị a, b
function swap(&$a, &$b) {
  $temp = $a;
  $a = $b;
  $b = $temp;
}

// chuyển list thành object dạng obj[id] = value("id", "attr")
function transform($list) {
  $result = array();
  foreach ($list as $row) {
    $result[$row["id"]] = $row;
  }
  return $result;
}

// Nếu quá giờ làm việc sẽ chặn đường vào
function overtime() {
  global $module_config, $module_name, $admin_info;
  $today = strtotime(date("Y-m-d"));

  $from = $today + 7 * 60 * 60;
  $end = $today + 17 * 60 * 60 + 30 * 60;
  if (!empty($module_config[$module_name]["worktime"])) {
    $from = $module_config[$module_name]["worktime"];
  }
  if (!empty($module_config[$module_name]["resttime"])) {
    $end = $module_config[$module_name]["resttime"];
  }

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
