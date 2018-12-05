<?php

/**
 * @Project NUKEVIET-MUSIC
 * @Author Phan Tan Dung (phantandung92@gmail.com)
 * @copyright 2011
 * @createdate 26/01/2011 09:17 AM
 */
if (!defined('NV_MAINFILE')) {
  die('Stop!!!');
}

define('NV_NEXTMONTH', 30 * 24 * 60 * 60);
define('NV_NEXTWEEK', 7 * 24 * 60 * 60);

function get_main_recent_list($disease) {
  global $db;
  $now = NV_CURRENTTIME;
  $filter_time = $global_config["filter_time"] ? $global_config["filter_time"] : NV_NEXTWEEK;
  $start = strtotime(date("Y-m-d", NV_CURRENTTIME)) - $filter_time;

  $return_var = array();
  foreach ($disease as $disease_key => $disease_row) {
    $this_vaccine_list = array();
    $sql = "SELECT * from " . VAC_PREFIX . "_" . $disease_row["id"] . " where cometime between " . $start . " and " . $now;
    $this_vaccine_list_query = $db->sql_query($sql);
    $this_vaccine_list[] = fetchall($db, $this_vaccine_list_query);
    foreach ($this_vaccine_list as $this_vaccine_list_row) {
      $info = getpet_info($row["petid"]);
      $list[$key] = transprop($list[$key], $info);
      $return_var[] = $this_vaccine_list_row;
    }
  }
  return $return_var;
}

function get_main_list($disease) {
  global $db, $global_config;
  $now = NV_CURRENTTIME;
  $filter_time = $global_config["filter_time"] ? $global_config["filter_time"] : NV_NEXTWEEK;
  $start = strtotime(date("Y-m-d", NV_CURRENTTIME)) - $filter_time;
  $end = strtotime(date("Y-m-d", NV_CURRENTTIME)) + $filter_time;

  $return_var = array();
  foreach ($disease as $disease_key => $disease_row) {
    $list = array();
    $sql = "SELECT *, " . $disease_row["id"] . " as disease from " . VAC_PREFIX . "_" . $disease_row["id"] . " where calltime between " . $start . " and " . $end;
    $list_query = $db->sql_query($sql);
    $list = fetchall($db, $list_query);
    foreach ($list as $key => $row) {
      $info = getpet_info($row["petid"]);
      $list[$key] = transprop($list[$key], $info);
      $return_var[] = $list[$key];
    }
  }
  return $return_var;
}

function getpet_info($petid) {
  global $db;
  $sql = "SELECT * from " . VAC_PREFIX . "_pets where id = $petid";
  $pet_query = $db->sql_query($sql);
  $pet_row = $db->sql_fetch_assoc($pet_query);

  $customer_row = getcustomer_info($pet_row["customerid"]);
  $return_var = array("petname" => $pet_row["petname"], "customer" => $customer_row["customer"], "phone" => $customer_row["phone"], "address" => $customer_row["address"]);
  return $return_var;
}

function getcustomer_info($customerid) {
  global $db;
  $sql = "SELECT customer, phone, address from  " . VAC_PREFIX . "_customers where id = $customerid";
  $customer_query = $db->sql_query($sql);
  $customer_row = $db->sql_fetch_assoc($customer_query);

  return $customer_row;
}

function parse_list($list, $order = 1) {
  global $lang_module, $hex;
  $sort_order_left = array();
  $sort_order_right = array();
  $today = strtotime(date("Y-m-d", NV_CURRENTTIME));

	$status_color = array("red", "orange", "green");
	$now = strtotime(date("Y-m-d", time()));
	
	$sort_order_left = array();
	$sort_order_right = array();
	$array_left = array();
  $array_right = array();

	foreach ($list as $key => $row) {
    if ($order) $dday = $row['calltime'];
    else $dday = $row['cometime'];
    if ($dday < $now) $sort_order_right[$key] = $dday;
    else $sort_order_left[$key] = $dday;
	}
	asort($sort_order_left);
  arsort($sort_order_right);

  foreach ($sort_order_left as $key => $value) {
    if ($order) $dday = $list[$key]['calltime'];
    else $dday = $list[$key]['cometime'];
    $d = ceil(($dday - $now) / (24 * 60 * 60)  / 2);
    $c = 15 - $d;
		$list[$key]["bgcolor"] = "#4" . $hex[$c] . "4";
		$array_left[] = $list[$key];
	}
  foreach ($sort_order_right as $key => $value) {
    if ($order) $dday = $list[$key]['calltime'];
    else $dday = $list[$key]['cometime'];
    $d = ceil(($dday - $now) / (24 * 60 * 60)  / 2);
    $d = $list[$key]["calltime"];
    $c = 15 - ($now - $d) / (24 * 60 * 60);
		$list[$key]["bgcolor"] = "#$hex[$c]$hex[$c]$hex[$c]";
		$array_right[] = $list[$key];
	}

	$list = array_merge($array_left, $array_right);
	foreach ($list as $key => $row) {
		$list[$key]["confirm"] = $lang_module["confirm_" . $row["confirm"]];
		$list[$key]["cometime"] = date("d/m/Y", $row["cometime"]);
		$list[$key]["calltime"] = date("d/m/Y", $row["calltime"]);
		$list[$key]["color"] = $color;
	}
  return $list;
}

// switch ($list_data["trangthai"]) {
//   case '1':
//     $color = "orange";
//     break;
//   case '2':
//     $color = "green";
//     break;
//   default:
//     $color = "red";
// }

function checkNewDisease($id) {
  global $db, $db_config, $module_name;

  $sql = array();
  $sql[] = "CREATE TABLE IF NOT EXISTS " . VAC_PREFIX . "_$id ( `id` int(11) NOT NULL, `petid` int(11) NOT NULL, `cometime` int(11) NOT NULL, `calltime` int(11) NOT NULL, `status` tinyint(4) NOT NULL, `note` text NOT NULL ) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
  $sql[] = "ALTER TABLE `" . VAC_PREFIX . "_$id` ADD PRIMARY KEY (`id`);";
  $sql[] = "ALTER TABLE `" . VAC_PREFIX . "_$id` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;";
  $check = true;
  foreach ($sql as $value) {
    if (!$db->sql_query($value))
      $check = false;
  }
  return $check;
}

function get_disease_list() {
  global $db, $db_config, $module_name;
  $sql = "select * from " . VAC_PREFIX . "_diseases";
  $result = $db->sql_query($sql);
  $diseases = array();
  while ($row = $db->sql_fetch_assoc($result)) {
    $diseases[] = $row;
  }
  return $diseases;
}

function getCustomerList($key, $sort, $filter, $page) {
  global $db, $db_config, $module_name;
  $order = "order by customer ";
  if ($sort == 1)
    $order .= "asc";
  else
    $order .= "desc";
  $from_item = ($page - 1) * $filter;
  $end_item = $from_item + $filter;

  $customers = array();
  $customers["data"] = array();

  $sql = "select count(id) as num from " . VAC_PREFIX . "_customers where customer like '%$key%' or phone like '%$key%'";
  $result = $db->sql_query($sql);
  $num = $db->sql_fetch_assoc($result);
  $customers["info"] = $num["num"];

  $sql = "select * from " . VAC_PREFIX . "_customers where customer like '%$key%' or phone like '%$key%' " . $order . " limit $from_item, $end_item";
  $result = $db->sql_query($sql);
  while ($row = $db->sql_fetch_assoc($result)) {
    $customers["data"][] = $row;
  }
  return $customers;
}

function getVaccineTable($path, $lang, $key, $sort, $time) {
  // next a week
  global $db, $db_config, $module_name, $global_config;
  $fromtime = strtotime(date("Y-m-d", NV_CURRENTTIME)) - $time;
  $endtime = $fromtime + 2 * $time;
  $link = NV_BASE_ADMINURL . "index.php?" . NV_NAME_VARIABLE . "=" . $module_name . "&" . NV_OP_VARIABLE . "=";

  $sort_type[1] = 'order by calltime asc';
  $sort_type[2] = 'order by calltime desc';
  $sort_type[3] = 'order by cometime asc';
  $sort_type[4] = 'order by cometime desc';

  if ($sort_type[$sort])
    $order = $sort_type[$sort];
  else
    $order = "";
  $xtpl = new XTemplate("main-1.tpl", $path);
  $xtpl->assign("lang", $lang);

  $diseases = get_disease_list();
  foreach ($diseases as $disease_index => $disease_data) {
    $xtpl->assign("title", $disease_data["disease"]);

    $sql = "select a.id, b.id as petid, b.petname, c.id as customerid, c.customer, c.phone as phone, cometime, calltime, status from " . VAC_PREFIX . "_" . $disease_data["id"] . " a inner join " . VAC_PREFIX . "_pets b on calltime between " . $fromtime . " and " . $endtime . " and a.petid = b.id inner join " . VAC_PREFIX . "_customers c on b.customerid = c.id where c.customer like '%$key%' or phone like '%$key%' " . $order;

    // $sql = "select a.id, b.id as petid, b.petname, c.id as customerid, c.customer, c.phone as phone, cometime, calltime, status, recall, doctorid from " . VAC_PREFIX . "_" . $id . " a inner join " . VAC_PREFIX . "_pets b on calltime between " . $fromtime . " and " . $endtime . " and a.petid = b.id inner join " . VAC_PREFIX . "_customers c on b.customerid = c.id";

    $result = $db->sql_query($sql);
    $vaccines = array();
    while ($row = $db->sql_fetch_assoc($result)) {
      $vaccines[] = $row;
    }

    $i = 1;
    foreach ($vaccines as $vac_index => $vac_data) {
      $xtpl->assign("index", $i);
      $xtpl->assign("petname", $vac_data["petname"]);
      $xtpl->assign("customer", $vac_data["customer"]);
      $xtpl->assign("pet_link", $link . "patient&petid=" . $vac_data["petid"]);
      $xtpl->assign("customer_link", $link . "customer&customerid=" . $vac_data["customerid"]);
      $xtpl->assign("phone", $vac_data["phone"]);
      $xtpl->assign("cometime", date("d/m/Y", $vac_data["cometime"]));
      $xtpl->assign("calltime", date("d/m/Y", $vac_data["calltime"]));
      $i++;
      $xtpl->parse("main.disease.vac_body");
    }

    $xtpl->parse("main.disease");
  }
  $xtpl->parse("main");


  // $sql = "select a.id, b.id as petid, b.petname, c.id as customerid, c.customer, c.phone as phone, cometime, calltime, status from " . VAC_PREFIX . "_" . $id . " a inner join " . VAC_PREFIX . "_pets b on calltime between " . $time . " and " . $next_time . " and a.petid = b.id inner join " . VAC_PREFIX . "_customers c on b.customerid = c.id" . $order;

  return $xtpl->text("main");
}

function filter($vaclist, $path, $lang, $fromtime, $amount_time, $sort, $order) {
  $hex = array("0", "1", "2", "3", "4", "5", "6", "7", "8", "9", "a", "b", "c", "d", "e", "f");
  $xtpl = new XTemplate("list-1.tpl", $path);
  $xtpl->assign("lang", $lang);

  $fromtime = strtotime($fromtime);

  $diseases = get_disease_list();
  $dis = array();
  foreach ($diseases as $key => $value) {
    $dis[$value["id"]] = $value["disease"];
  }
  $diseases = $dis;
  // echo json_encode($diseases); die();
  $now = strtotime(date("Y-m-d", NV_CURRENTTIME));
  $today = date("d", $now);
  $dom = date("t");
  $xtpl->assign("title", $lang["main_title"]);

  $i = 1;
  $xtpl->assign("diseaseid", $disease["id"]);
  $sort_order_left = array();
  $sort_order_right = array();

  // $realvac = array();
  $price = array();
  foreach ($vaclist as $key => $row) {
    if ($order) {
      $price[$key] = $row['calltime'];
    }
    else {
      $price[$key] = $row['cometime'];
    }
  }
  array_multisort($price, SORT_ASC, $vaclist);

  // var_dump($vaclist); die();

// 	foreach ($vaclist as $key => $row) {
// 		$realvac[$row["petid"]] = $key;
// 	}
//     foreach ($realvac as $key => $row) {
//   		if ($vaclist[$row]["calltime"] <= $now)
//       $sort_order_right[] = $row;
//     else
//       $sort_order_left[] = $row;
//     }
  // echo "$vaclist, $path, $lang, $fromtime, $amount_time, $sort, $order"; die();
  foreach ($vaclist as $key => $row) {
    if ($order) {
      // echo "$row[calltime], $now<br>";
      if ($row["calltime"] < $now)
        $sort_order_right[] = $key;
      else
        $sort_order_left[] = $key;
    }
    else {
      if ($row["cometime"] < $now)
        $sort_order_right[] = $key;
      else
        $sort_order_left[] = $key;      
    }
  }
  // var_dump($sort_order_right);
  // die();
  asort($sort_order_left);
  arsort($sort_order_right);
  if ($order) $hack = 1;
  else $hack = 2;
  foreach ($sort_order_left as $key => $value) {
    // var_dump($vaclist[$value]); die();
    $xtpl->assign("index", $i);
    $xtpl->assign("petname", $vaclist[$value]["petname"]);
    $xtpl->assign("petid", $vaclist[$value]["petid"]);
    $xtpl->assign("vacid", $vaclist[$value]["id"]);
    $xtpl->assign("customer", $vaclist[$value]["customer"]);
    $xtpl->assign("phone", $vaclist[$value]["phone"]);
    $xtpl->assign("diseaseid", $vaclist[$value]["diseaseid"]);
    // $xtpl->assign("disease", $vaclist[$value]["diseaseid"]);
    $xtpl->assign("disease", $diseases[$vaclist[$value]["diseaseid"]]);
    $xtpl->assign("note", $vaclist[$value]["note"]);
    $xtpl->assign("confirm", $lang["confirm_" . $vaclist[$value]["status"]]);
    if ($vaclist[$value]["status"] == 2 && empty($vaclist[$value]["recall"]))
      $xtpl->parse("disease.vac_body.recall_link");
    switch ($vaclist[$value]["status"]) {
      case '1':
        $xtpl->assign("color", "orange");
        break;
      case '2':
        $xtpl->assign("color", "green");
        break;
      default:
        $xtpl->assign("color", "red");
        break;
    }
    if ($order) {
      $d = date("d", $vaclist[$value]["calltime"]);
    } else {
      $d = date("d", $vaclist[$value]["cometime"]);
    }
    if ($d - $today < 0) {
      $c = $dom - $today + $d;
    } else {
      $c = $d - $today;
    }
    $c = 15 - round($c / 2 / $hack);
    $xtpl->assign("bgcolor", "#4" . $hex[$c] . "4");
    $xtpl->assign("cometime", date("d/m/Y", $vaclist[$value]["cometime"]));
    $xtpl->assign("calltime", date("d/m/Y", $vaclist[$value]["calltime"]));
    $i++;
    $xtpl->parse("disease.vac_body");
  }
  foreach ($sort_order_right as $key => $value) {
    $xtpl->assign("index", $i);
    $xtpl->assign("petname", $vaclist[$value]["petname"]);
    $xtpl->assign("petid", $vaclist[$value]["petid"]);
    $xtpl->assign("vacid", $vaclist[$value]["id"]);
    $xtpl->assign("customer", $vaclist[$value]["customer"]);
    $xtpl->assign("phone", $vaclist[$value]["phone"]);
    $xtpl->assign("diseaseid", $vaclist[$value]["diseaseid"]);
    $xtpl->assign("disease", $diseases[$vaclist[$value]["diseaseid"]]);
    $xtpl->assign("note", $vaclist[$value]["note"]);
    $xtpl->assign("confirm", $lang["confirm_" . $vaclist[$value]["status"]]);
    if ($vaclist[$value]["status"] == 2 && empty($vaclist[$value]["recall"]))
      $xtpl->parse("disease.vac_body.recall_link");
    switch ($vaclist[$value]["status"]) {
      case '1':
        $xtpl->assign("color", "orange");
        break;
      case '2':
        $xtpl->assign("color", "green");
        break;
      default:
        $xtpl->assign("color", "red");
        break;
    }
    if ($order) {
      $d = date("d", $vaclist[$value]["calltime"]);
    } else {
      $d = date("d", $vaclist[$value]["cometime"]);
    }
    if ($today - $d < 0) {
      $c = $today + $dom - $d;
      // day of prv month
    } else {
      $c = $today - $d;
    }
    $c = 14 - round($c / 2 / $hack);
    $xtpl->assign("bgcolor", "#$hex[$c]$hex[$c]$hex[$c]");
    $xtpl->assign("cometime", date("d/m/Y", $vaclist[$value]["cometime"]));
    $xtpl->assign("calltime", date("d/m/Y", $vaclist[$value]["calltime"]));
    $i++;
    $xtpl->parse("disease.vac_body");
  }
  $xtpl->parse("disease");
  return $xtpl->text("disease");
}

function getdoctorlist() {
  global $db, $db_config, $module_name;
  $sql = "select * from " . VAC_PREFIX . "_doctor";
  $result = $db->sql_query($sql);
  $doctor = array();

  while ($row = $db->sql_fetch_assoc($result)) {
    $doctor[] = $row;
  }
  return $doctor;
}

function doctorlist($path, $lang) {
  $xtpl = new XTemplate("doctor-2.tpl", $path);

  $xtpl->assign("lang", $lang);

  $doctors = getdoctorlist();
  foreach ($doctors as $key => $doctor_data) {
    echo
    $xtpl->assign("index", $doctor_data["id"]);
    $xtpl->assign("name", $doctor_data["doctor"]);
    $xtpl->parse("main.doctor");
  }

  $xtpl->parse("main");
  return $xtpl->text("main");
}

function getrecentlist($fromtime, $amount_time, $sort, $diseaseid) {
  global $db, $db_config, $module_name;
  $endtime = $fromtime + $amount_time;
  $fromtime -= $amount_time;

  $order = '';
  switch ($sort) {
    case '1':
      $order = 'order by cometime, customer asc';
      break;
    case '2':
      $order = 'order by cometime, customer desc';
      break;
    case '3':
      $order = 'order by calltime, customer asc';
      break;
    case '4':
      $order = 'order by calltime, customer desc';
      break;
  }

  $sql = "select a.id, a.note, b.id as petid, b.petname, c.id as customerid, c.customer, c.phone as phone, cometime, calltime, status, doctorid, recall, '$diseaseid' as diseaseid from " . VAC_PREFIX . "_" . $diseaseid . " a inner join " . VAC_PREFIX . "_pets b on cometime between " . $fromtime . " and " . $endtime . " and a.petid = b.id inner join " . VAC_PREFIX . "_customers c on b.customerid = c.id " . $order;

  // if ($diseaseid == 2) {
  // 	die($sql);
  // }

  $result = $db->sql_query($sql);
  $ret = array();
  while ($row = $db->sql_fetch_assoc($result)) {
    $ret[] = $row;
  }
  return $ret;
}

function filterVac($fromtime, $amount_time, $sort, $diseaseid) {
  global $db, $db_config, $module_name;
  $endtime = $fromtime + $amount_time;
  $fromtime -= $amount_time;

  $order = '';
  switch ($sort) {
    case '1':
      $order = 'order by cometime, customer asc';
      break;
    case '2':
      $order = 'order by cometime, customer desc';
      break;
    case '3':
      $order = 'order by calltime, customer asc';
      break;
    case '4':
      $order = 'order by calltime, customer desc';
      break;
  }

  $sql = "select a.id, a.note, b.id as petid, b.petname, c.id as customerid, c.customer, c.phone as phone, cometime, calltime, status, doctorid, recall, '$diseaseid' as diseaseid from " . VAC_PREFIX . "_" . $diseaseid . " a inner join " . VAC_PREFIX . "_pets b on calltime between " . $fromtime . " and " . $endtime . " and a.petid = b.id inner join " . VAC_PREFIX . "_customers c on b.customerid = c.id " . $order;

  // if ($diseaseid == 2) {
  // 	die($sql);
  // }

  $result = $db->sql_query($sql);
  $ret = array();
  while ($row = $db->sql_fetch_assoc($result)) {
    $ret[] = $row;
  }
  return $ret;
}

function getvaccustomer($customer, $fromtime, $amount_time, $sort, $diseaseid, $disease) {
  global $db, $db_config, $module_name;
  $endtime = $fromtime + $amount_time;
  $fromtime -= $amount_time;

  $order = '';
  switch ($sort) {
    case '1':
      $order = 'order by cometime, customer asc';
      break;
    case '2':
      $order = 'order by cometime, customer desc';
      break;
    case '3':
      $order = 'order by calltime, customer asc';
      break;
    case '4':
      $order = 'order by calltime, customer desc';
      break;
  }

  $sql = "select a.id, a.note, b.id as petid, b.petname, c.id as customerid, c.customer, c.phone as phone, cometime, calltime, status, doctorid, recall, '$diseaseid' as diseaseid, '$disease' as disease from " . VAC_PREFIX . "_" . $diseaseid . " a inner join " . VAC_PREFIX . "_pets b on calltime between " . $fromtime . " and " . $endtime . " and a.petid = b.id inner join " . VAC_PREFIX . "_customers c on b.customerid = c.id where c.customer like '%$customer%' or c.phone like '%$customer%' " . $order;

  // if ($diseaseid == 2) {
  // 	die($sql);
  // }
  // $sql = "select a.id, b.id as petid, b.petname, c.id as customerid, c.customer, c.phone as phone, cometime, calltime, status from " . VAC_PREFIX . "_" . $diseaseid . " a inner join " . VAC_PREFIX . "_pets b on calltime between " . $fromtime . " and " . $endtime . " and a.petid = b.id inner join " . VAC_PREFIX . "_customers c on b.customerid = c.id where c.customer like '%$customer%' or c.phone like '%$customer%' " . $order;
  $result = $db->sql_query($sql);
  $ret = array();
  while ($row = $db->sql_fetch_assoc($result)) {
    $ret[] = $row;
  }
  return $ret;
}

function getcustomer($customer, $phone) {
  global $db, $db_config, $module_name;
  if (!empty($customer)) {
    $sql = "select * from `" . VAC_PREFIX . "_customers` where customer like '%$customer%'";
  } else {
    $sql = "select * from `" . VAC_PREFIX . "_customers` where phone like '%$phone%'";
  }

  $result = $db->sql_query($sql);
  $ret = array();
  while ($row = $db->sql_fetch_assoc($result)) {
    $ret[] = $row;
  }
  return $ret;
}

function getPatientsList($key, $sort, $filter, $page) {
  global $db, $db_config, $module_name;
  $patients = array();
  $patients["data"] = array();

  if ($sort / 2 <= 1)
    $order = "order by petname ";
  else
    $order = "order by customer ";
  if ($sort == 1)
    $order .= "asc";
  else
    $order .= "desc";
  $from_item = ($page - 1) * $filter;
  $end_item = $from_item + $filter;

  $sql = "select count(b.id) as num from " . VAC_PREFIX . "_pets b inner join " . VAC_PREFIX . "_customers c on b.customerid = c.id where c.customer like '%$key%' or b.petname like '%$key%'";
  $result = $db->sql_query($sql);
  $num = $db->sql_fetch_assoc($result);
  $patients["info"] = $num["num"];
  // var_dump($patients["info"]);
  // die();

  $sql = "select b.id, b.petname, c.id as customerid, c.customer, c.phone as phone from " . VAC_PREFIX . "_pets b inner join " . VAC_PREFIX . "_customers c on b.customerid = c.id where c.customer like '%$key%' or b.petname like '%$key%' or c.phone like '%$key%' " . $order . " limit $from_item, $end_item";
  $result = $db->sql_query($sql);
  while ($row = $db->sql_fetch_assoc($result)) {
    $patients["data"][] = $row;
  }
  // var_dump($patients);
  // die($sql);
  return $patients;
}

function getPatientsList2($customerid) {
  global $db, $db_config, $module_name;
  $sql = "select * from " . VAC_PREFIX . "_customers where id = $customerid";
  $result = $db->sql_query($sql);
  $patients = $db->sql_fetch_assoc($result);
  $patients["data"] = array();
  $sql = "select petname, id from " . VAC_PREFIX . "_pets where customerid = $customerid";
  $result = $db->sql_query($sql);
  $diseases = get_disease_list();
  // echo json_encode($diseases);
  // die();
  $ax = array();
  while ($row = $db->sql_fetch_assoc($result)) {
    $ax[] = $row;
  }

  foreach ($ax as $key => $row) {
    $petid = $row["id"];
    $union = array();
    foreach ($diseases as $key => $value) {
      $result = $db->sql_query("select *, $value[id] as disease from vng_vac_$value[id] where petid = $petid order by calltime desc LIMIT 1");
      while ($row2 = $db->sql_fetch_assoc($result)) {
        $union[] = $row2;
      }
    }

    $s_calltime = array();
    foreach ($union as $key => $row2) {
      $s_calltime[$key] = $row2['calltime'];
    }
    array_multisort($s_calltime, SORT_ASC, $union);
    $row2 = $union[0];

// 		foreach ($diseases as $key => $value) {
// 			$key ++;
// 			$union[] = "(select *, $key as disease from vng_vac_$key where petid = $petid order by calltime desc LIMIT 1)";
// 		}
    // $sql = "SELECT * from	( (select *, 1 as disease from vng_vac_1 LIMIT 1) UNION  (select *, 2 as disease  from vng_vac_2 LIMIT 1) UNION  (select *, 3 as disease from vng_vac_3 LIMIT 1) ) as a limit 1";
// 		$sql = "SELECT * from	( " . implode(" union ", $union) . ") as a limit 1";
    // die($sql);
// 		$result2 = $db->sql_query($sql);
// 		$row2 = $db->sql_fetch_assoc($result2);
    if (!empty($row2)) {
      $patients["data"][] = array("petid" => $row["id"], "petname" => $row["petname"], "lastcome" => $row2["calltime"], "lastname" => $diseases[$row2["disease"]]);
    } else {
      $patients["data"][] = array("petid" => $row["id"], "petname" => $row["petname"], "lastcome" => "", "lastname" => "");
    }
  }
  // die();
  return $patients;
}

function getPatientDetail($petid) {
  global $db, $db_config, $module_name;
  $sql = "select b.petname, c.customer, c.phone as phone from " . VAC_PREFIX . "_pets b inner join " . VAC_PREFIX . "_customers c on b.id = $petid and b.customerid = c.id";
  $result = $db->sql_query($sql);
  $patients = $db->sql_fetch_assoc($result);
  $patients["data"] = array();

  $diseases = get_disease_list();
  $union = array();
  foreach ($diseases as $key => $value) {
    $key ++;
    $result = $db->sql_query("select *, $key as disease from vng_vac_$key where petid = $petid");
    while ($row = $db->sql_fetch_assoc($result)) {
      $patients["data"][] = $row;
    }
  }

  return $patients;
}

function nv_generate_page_shop($base_url, $num_items, $per_page, $start_item, $add_prevnext_text = true, $onclick = false, $js_func_name = 'nv_urldecode_ajax', $containerid = 'generate_page') {
  global $lang_global;
  $start_item = ($start_item - 1) * $per_page;

  $total_pages = ceil($num_items / $per_page);
  if ($total_pages == 1)
    return '';
  @$on_page = floor($start_item / $per_page) + 1;
  $amp = preg_match("/\?/", $base_url) ? "&amp;" : "?";
  $page_string = "";
  if ($total_pages > 10) {
    $init_page_max = ( $total_pages > 3 ) ? 3 : $total_pages;
    for ($i = 1; $i <= $init_page_max; $i ++) {
      $href = !$onclick ? "href=\"" . $base_url . $amp . "page=" . ( $i ) . "\"" : "href=\"javascript:void(0)\" onclick=\"" . $js_func_name . "('" . rawurlencode(nv_unhtmlspecialchars($base_url . $amp . "page=" . ( $i ))) . "','" . $containerid . "')\"";
      $page_string .= ( $i == $on_page ) ? "<strong>" . $i . "</strong>" : "<a " . $href . ">" . $i . "</a>";
      if ($i < $init_page_max)
        $page_string .= " ";
    }
    if ($total_pages > 3) {
      if ($on_page > 1 && $on_page < $total_pages) {
        $page_string .= ( $on_page > 5 ) ? " ... " : ", ";
        $init_page_min = ( $on_page > 4 ) ? $on_page : 5;
        $init_page_max = ( $on_page < $total_pages - 4 ) ? $on_page : $total_pages - 4;
        for ($i = $init_page_min - 1; $i < $init_page_max + 2; $i ++) {
          $href = !$onclick ? "href=\"" . $base_url . $amp . "page=" . ( $i ) . "\"" : "href=\"javascript:void(0)\" onclick=\"" . $js_func_name . "('" . rawurlencode(nv_unhtmlspecialchars($base_url . $amp . "page=" . ( $i ))) . "','" . $containerid . "')\"";
          $page_string .= ( $i == $on_page ) ? "<strong>" . $i . "</strong>" : "<a " . $href . ">" . $i . "</a>";
          if ($i < $init_page_max + 1) {
            $page_string .= " ";
          }
        }
        $page_string .= ( $on_page < $total_pages - 4 ) ? " ... " : ", ";
      } else {
        $page_string .= " ... ";
      }

      for ($i = $total_pages - 2; $i < $total_pages + 1; $i ++) {
        $href = !$onclick ? "href=\"" . $base_url . $amp . "page=" . ( $i ) . "\"" : "href=\"javascript:void(0)\" onclick=\"" . $js_func_name . "('" . rawurlencode(nv_unhtmlspecialchars($base_url . $amp . "page=" . ( $i ))) . "','" . $containerid . "')\"";
        $page_string .= ( $i == $on_page ) ? "<strong>" . $i . "</strong>" : "<a " . $href . ">" . $i . "</a>";
        if ($i < $total_pages) {
          $page_string .= " ";
        }
      }
    }
  } else {
    for ($i = 1; $i < $total_pages + 1; $i ++) {
      $href = !$onclick ? "href=\"" . $base_url . $amp . "page=" . ( $i ) . "\"" : "href=\"javascript:void(0)\" onclick=\"" . $js_func_name . "('" . rawurlencode(nv_unhtmlspecialchars($base_url . $amp . "page=" . ( $i - 1 ))) . "','" . $containerid . "')\"";
      $page_string .= ( $i == $on_page ) ? "<strong>" . $i . "</strong>" : "<a " . $href . ">" . $i . "</a>";
      if ($i < $total_pages) {
        $page_string .= " ";
      }
    }
  }
  // if ( $add_prevnext_text )
  // {
  //   if ( $on_page > 1 )
  //   {
  //   $href = ! $onclick ? "href=\"" . $base_url . $amp . "page=" . ( $on_page - 1 ) . "\"" : "href=\"javascript:void(0)\" onclick=\"" . $js_func_name . "('" . rawurlencode( nv_unhtmlspecialchars( $base_url . $amp . "page=" . ( $on_page - 2 ) ) ) . "','" . $containerid . "')\"";
  //   $page_string = "&nbsp;&nbsp;<span><a " . $href . ">" . $lang_global['pageprev'] . "</a></span>&nbsp;&nbsp;" . $page_string;
  //   }
  //   if ( $on_page < $total_pages )
  //   {
  //   $href = ! $onclick ? "href=\"" . $base_url . $amp . "page=" . ( $on_page ) . "\"" : "href=\"javascript:void(0)\" onclick=\"" . $js_func_name . "('" . rawurlencode( nv_unhtmlspecialchars( $base_url . $amp . "page=" . ( $on_page ) ) ) . "','" . $containerid . "')\"";
  //   $page_string .= "&nbsp;&nbsp;<span><a " . $href . ">" . $lang_global['pagenext'] . "</a></span>";
  //   }
  // }
  return $page_string;
}
// Nếu quá giờ làm việc sẽ chặn đường vào
function quagio() {
  global $global_config, $admin_info, $module_info, $module_file;
  $today = strtotime(date("Y-m-d"));
  $from = $global_config["giolamviec"] ? $global_config["giolamviec"] : $today + 7 * 60 * 60;
  $end = $global_config["gionghi"] ? $global_config["gionghi"] : $today + 17 * 60 * 60 + 30 * 60;

  if (!($admin_info["level"] == "1") && (NV_CURRENTTIME < $from || NV_CURRENTTIME > $end)) {
    $xtpl = new XTemplate("overtime.tpl", NV_ROOTDIR . "/themes/" . $module_info['template'] . "/modules/" . $module_file);
    // die(NV_ROOTDIR . "/themes/" . $module_info['template'] . "/modules/" . $module_file);
    $xtpl->assign("lang", $lang_module);

    $xtpl->parse("overtime");
    $contents = $xtpl->text("overtime");

    include ( NV_ROOTDIR . "/includes/header.php" );
    echo nv_site_theme($contents);
    include ( NV_ROOTDIR . "/includes/footer.php" );
    die();
  }
}
function fetchall($db, $query) {
  $result = array();
  while ($row = $db->sql_fetch_assoc($query)) {
      $result[] = $row;
  }
  return $result;
}
// Thay đổi màu trong lưu bệnh
function mauluubenh($ketqua, $tinhtrang) {
  switch ($ketqua) {
    case 1:
      $color = "#ccc";
    break;
    case 2:
      $color = "#f44";
    break;
    default:
      switch ($tinhtrang) {
        case 0:
          $color = "#2d2";
          break;
        case 1:
          $color = "#4a2";
          break;
        case 2:
          $color = "#aa2";
          break;
        case 3:
          $color = "#f62";
          break;
      }
  }
  return $color;
}
function transprop($object, $proplist) {
  foreach ($proplist as $key => $value) {
    $object[$key] = $value;
  }
  return $object;
}

?>
