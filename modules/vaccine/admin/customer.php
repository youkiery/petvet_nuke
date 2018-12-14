<?php
/**
* @Project NUKEVIET-MUSIC
* @Phan Tan Dung (phantandung92@gmail.com)
* @Copyright (C) 2011
* @Createdate 26-01-2011 14:43
*/

if (!defined('NV_IS_QUANLY_ADMIN')) die('Stop!!!');
$link = NV_BASE_ADMINURL . "index.php?" . NV_NAME_VARIABLE . "=" . $module_name . "&" . NV_OP_VARIABLE . "=";
$fs_option = array("1" => "Tên A-Z", "2" => "Tên Z-A");
$ff_option = array("25", "50", "100", "500", "1000");

$action = $nv_Request->get_string('action', 'post', "");
if($action) {
  switch ($action) {
    case "add":
      $name = $nv_Request -> get_string('customer', 'post', '');
      $phone = $nv_Request -> get_string('phone', 'post', '');
      $address = $nv_Request -> get_string('address', 'post', '');
      if(!(empty($name) || empty($phone))) {
        $sql = "insert into `" . VAC_PREFIX . "_customer` (name, phone, address) values('$name', '$phone', '$address');";
        $id = $db->sql_query_insert_id($sql);
        if($id){
          $row = array("id" => $id, "name" => $name, "phone" => $phone, "address" => $address);
          echo json_encode($row);
        }
      }
    break;
    case "remove":
      $id = $nv_Request->get_string('id', 'post', '');
      if(!empty($id)) {
        $sql = "delete from `" . VAC_PREFIX . "_customer` where id = $id";
        if($db->sql_query($sql)) echo 1;
      }
    break;
    case "update":
      $id = $nv_Request->get_string('id', 'post', '');
      $name = $nv_Request -> get_string('customer', 'post', '');
      $phone = $nv_Request -> get_string('phone', 'post', '');
      $address = $nv_Request -> get_string('address', 'post', '');
      if(!(empty($id) || empty($name) || empty($phone))) {
        $sql = "update `" . VAC_PREFIX . "_customer` set name = '$name', phone = '$phone', address = '$address' where id = $id";
        if($db->sql_query($sql)) {
          $row = array("id" => $id, "name" => $name, "phone" => $phone, "address" => $address);
          echo json_encode($row);
        }
      }
    break;
    case "addpet":
      $petname = $nv_Request -> get_string('petname', 'post', '');
      $customerid = $nv_Request -> get_string('id', 'post', '');
      if(!(empty($petname) || empty($customerid))) {
        $sql2 .= "insert into `" . VAC_PREFIX . "_pet` (customerid, name) values('$customerid', '$petname');";
        
        $id = $db->sql_query_insert_id($sql2);
        if($id){
          $row = array("id" => $id, "petname" => $petname);
          echo json_encode($row);
        }
      }
    break;
    case "removepet":
      $id = $nv_Request->get_string('id', 'post', '');
      if(!empty($id)) {
        $sql = "delete from `" . VAC_PREFIX . "_pet` where id = $id";
        if($db->sql_query($sql)) echo 1;
      }
    break;
    case "updatepet":
      $id = $nv_Request->get_string('id', 'post', '');
      $petname = $nv_Request -> get_string('petname', 'post', '');
      if(!(empty($id) || empty($petname))) {
        $sql = "update `" . VAC_PREFIX . "_pet` set name = '$petname' where id = $id";
        if($db->sql_query($sql)) {
          $row = array("id" => $id, "name" => $petname);
          echo json_encode($row);
        }
      }
    break;
  } 

  die();
}


$customerid = $nv_Request->get_string('customerid', 'get', "");
if (!empty($customerid)) {
  $page_title = $lang_module["patient_title2"];
  $patients = getPatientsList2($customerid);
  $xtpl = new XTemplate("customer2.tpl", NV_ROOTDIR . "/themes/" . $global_config['module_theme'] . "/modules/" . $module_file);
  $xtpl->assign("lang", $lang_module);
  $xtpl->assign("customer", $patients["customer"]);
  $xtpl->assign("customerid", $customerid);
  $xtpl->assign("phone", $patients["phone"]);
  $xtpl->assign("address", $patients["address"]);
  // echo json_encode($patients["data"]);
  foreach ($patients["data"] as $key => $patient_data) {
    if(!empty($patient_data["lastcome"])) $lasttime = date("d/m/Y", $patient_data["lastcome"]);
    else $lasttime = "";
    if(!empty($patient_data["lastname"])) $lastname = $patient_data["lastname"];
    else $lastname = "";
    $xtpl->assign("id", $patient_data["petid"]);
    $xtpl->assign("detail_link", $link . "patient&petid=" . $patient_data["petid"]);
    $xtpl->assign("petname", $patient_data["petname"]);
    $xtpl->assign("lasttime", $lasttime);
    $xtpl->assign("lastname", $lastname);
    $xtpl->parse("main.vac");
  }
}
else {
  $page_title = $lang_module["customer_title"];
  $xtpl = new XTemplate("customer.tpl", NV_ROOTDIR . "/themes/" . $global_config['module_theme'] . "/modules/" . $module_file);
  $xtpl->assign("lang", $lang_module);
  
	$pan = $nv_Request->get_string('pan', 'get', "");
	$id = $nv_Request->get_string('id', 'get', "");

	if (!(empty($pan) || empty($id))) {
		$sql = "select * from " . VAC_PREFIX . "_customer where id = $id";
		$query = $db->sql_query($sql);
		$row = $db->sql_fetch_assoc($query);
		if ($row) {
			$xtpl->assign("customer2", $row["name"]);
			$xtpl->assign("phone2", $row["phone"]);
			$xtpl->assign("address2", $row["address"]);
		}
	}

  $keyword = $nv_Request->get_string('key', 'get', "");
  $sort = $nv_Request->get_string('sort', 'get', "");
  $filter = $nv_Request->get_string('filter', 'get', "");
  $page = $nv_Request->get_string('page', 'get', "");
  $xtpl->assign("nv", $module_name);
  $xtpl->assign("op", $op);
  $xtpl->assign("keyword", $keyword);

  if (empty($sort)) $sort = 1;
  if (empty($filter)) $filter = 25;
  if (empty($page)) $page = 1;

  foreach ($fs_option as $key => $value) {
    $xtpl->assign("fs_name", $value);
    $xtpl->assign("fs_value", $key);
    if ($sort == $key) $xtpl->assign("fs_select", "selected");
    else $xtpl->assign("fs_select", "");
    $xtpl->parse("main.fs_option");
  }
  
  foreach ($ff_option as $key => $value) {
    $xtpl->assign("ff_name", $value);
    $xtpl->assign("ff_value", $value);
    if ($filter == $value) $xtpl->assign("ff_select", "selected");
    else $xtpl->assign("ff_select", "");
    $xtpl->parse("main.ff_option");
  }
  $customers = getCustomerList($keyword, $sort, $filter, $page);
  // $customers: info, data
  // var_dump(ceil($customers["info"]));
  // die();
  // for ($i=1; $i < 10; $i++) { 
  //   $page_nav = getNavPage($i, ceil($customers["info"] / $filter), $link . "customer&sort=$sort&filter=$filter");
  //   echo "<span style='color: red'>$i</span>: " . $page_nav . "<br>";
  // }
  // $page_nav = getNavPage($page, ceil($customers["info"] / $filter), $link . "customer&sort=$sort&filter=$filter");
  $url = $link . $op . "&sort=$sort&filter=$filter";
  if(!empty($key)) {
    $url .= "&key=$keyword";
  }
  $xtpl->assign("filter_count", sprintf ( $lang_module['filter_result'], $customers["info"] ));
  $xtpl->assign("nav_link", nv_generate_page_shop($url, $customers["info"], $filter, $page));
  foreach ($customers["data"] as $customer_index => $customer_data) {
    $xtpl->assign("index", $customer_data["id"]);
    $xtpl->assign("customer", $customer_data["customer"]);
    $xtpl->assign("detail_link", $link . "customer&customerid=" . $customer_data["id"]);
    $xtpl->assign("phone", $customer_data["phone"]);
    $xtpl->assign("address", $customer_data["address"]);
    $xtpl->parse("main.customer");
  }
}

$xtpl->parse("main");

$contents = $xtpl->text("main");

include (NV_ROOTDIR . "/includes/header.php");
echo nv_admin_theme($contents);
include (NV_ROOTDIR . "/includes/footer.php");
?>
