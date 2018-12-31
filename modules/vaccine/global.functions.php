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
define('VAC_PREFIX', $db_config['prefix'] . "_" . $module_name);
define('NV_NEXTMONTH', 30 * 24 * 60 * 60);
define('NV_NEXTWEEK', 7 * 24 * 60 * 60);

function getDiseaseList() {
  global $db, $db_config, $module_name;
  $sql = "select * from " . VAC_PREFIX . "_disease";
  $result = $db->sql_query($sql);
  return fetchall($db, $result);
}

function getCustomerList($key, $sort, $filter, $page) {
  global $db, $db_config, $module_name;
  $order = "order by name ";
  if ($sort == 1)
    $order .= "asc";
  else
    $order .= "desc";
  $from_item = ($page - 1) * $filter;
  $end_item = $from_item + $filter;

  $customers = array();
  $customers["data"] = array();

  $sql = "select count(id) as num from " . VAC_PREFIX . "_customer where name like '%$key%' or phone like '%$key%'";
  $result = $db->sql_query($sql);
  $num = $db->sql_fetch_assoc($result);
  $customers["info"] = $num["num"];

  $sql = "select id, name as customer, phone, address from " . VAC_PREFIX . "_customer where name like '%$key%' or phone like '%$key%' " . $order . " limit $from_item, $end_item";
  $result = $db->sql_query($sql);
  while ($row = $db->sql_fetch_assoc($result)) {
    $customers["data"][] = $row;
  }
  return $customers;
}

function getVaccineTable($path, $lang, $key, $sort, $time) {
  // next a week
  global $db, $db_config, $module_name, $global_config, $lang_module;
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

    $sql = "SELECT a.id, p.id as petid, a.status, p.name as petname, c.id as customerid, c.name as customer, c.phone, cometime, calltime, a.status, dd.name as disease, d.name as doctor FROM " . VAC_PREFIX . "_vaccine a inner join " . VAC_PREFIX . "_disease dd on calltime between " . $fromtime . " and " . $endtime . " and a.diseaseid = dd.id inner join " . VAC_PREFIX . "_pet p on a.petid = p.id inner join " . VAC_PREFIX . "_customer c on p.customerid = c.id inner join " . VAC_PREFIX . "_doctor d on a.doctorid = d.id where c.name like '%$key%' or phone like '%$key%' " . $order;
    $result = $db->sql_query($sql);
    $sql = "SELECT a.id, p.id as petid, a.status, p.name as petname, c.id as customerid, c.name as customer, c.phone, cometime, calltime, a.status, dd.name as disease, d.name as doctor FROM " . VAC_PREFIX . "_vaccine a inner join (select 0 as id, 'Siêu Âm' as name from DUAL) dd on calltime between " . $fromtime . " and " . $endtime . " and a.diseaseid = dd.id inner join " . VAC_PREFIX . "_pet p on a.petid = p.id inner join " . VAC_PREFIX . "_customer c on p.customerid = c.id inner join " . VAC_PREFIX . "_doctor d on a.doctorid = d.id where c.name like '%$key%' or phone like '%$key%' " . $order;
    $result2 = $db->sql_query($sql);
    $vaccines = array();

    while ($row = $db->sql_fetch_assoc($result)) {
      $vaccines[] = $row;
    }
    while ($row = $db->sql_fetch_assoc($result2)) {
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
      $xtpl->assign("disease", $vac_data["disease"]);
      $xtpl->assign("confirm", $lang_module["confirm_value"][$vac_data["status"]]);
      $xtpl->assign("doctor", $vac_data["doctor"]);
      $xtpl->assign("cometime", date("d/m/Y", $vac_data["cometime"]));
      $xtpl->assign("calltime", date("d/m/Y", $vac_data["calltime"]));
      $i++;
      $xtpl->parse("main.disease.vac_body");
    }

    $xtpl->parse("main.disease");
  $xtpl->parse("main");


  // $sql = "select a.id, b.id as petid, b.petname, c.id as customerid, c.customer, c.phone as phone, cometime, calltime, status from " . VAC_PREFIX . "_" . $id . " a inner join " . VAC_PREFIX . "_pet b on calltime between " . $time . " and " . $next_time . " and a.petid = b.id inner join " . VAC_PREFIX . "_customer c on b.customerid = c.id" . $order;

  return $xtpl->text("main");
}

function filter($vaclist, $path, $lang, $fromtime, $amount_time, $sort, $order) {
  $hex = array("0", "1", "2", "3", "4", "5", "6", "7", "8", "9", "a", "b", "c", "d", "e", "f");
  $xtpl = new XTemplate("list-1.tpl", $path);
  $xtpl->assign("lang", $lang);
  // var_dump($vaclist);
  // die();

  $fromtime = strtotime($fromtime);

  $now = strtotime(date("Y-m-d", NV_CURRENTTIME));
  $today = date("d", $now);
  $dom = date("t");
  $xtpl->assign("title", $lang["main_title"]);

  $i = 1;
  $sort_order_left = array();
  $sort_order_right = array();

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

  foreach ($vaclist as $key => $row) {
    if ($order) {
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
  asort($sort_order_left);
  arsort($sort_order_right);
  if ($order) {
    if (count($sort_order_left) > 1) {
      $hack = ($vaclist[$sort_order_left[count($sort_order_left) - 1]]["calltime"] - $vaclist[$sort_order_left[0]]["calltime"]) + 1;
    }
    else {
      $hack = 24 * 60 * 60 * 7;
    }
  }
  else {
    if (count($sort_order_left) > 1) {
      $hack = ($vaclist[$sort_order_left[count($sort_order_left) - 1]]["cometime"] - $vaclist[$sort_order_left[0]]["cometime"]) + 1;
    }
    else {
      $hack = 24 * 60 * 60 * 7;
    }
  }
  foreach ($sort_order_left as $key => $value) {
    $xtpl->assign("index", $i);
    $xtpl->assign("petname", $vaclist[$value]["petname"]);
    $xtpl->assign("petid", $vaclist[$value]["petid"]);
    $xtpl->assign("vacid", $vaclist[$value]["id"]);
    $xtpl->assign("customer", $vaclist[$value]["customer"]);
    $xtpl->assign("phone", $vaclist[$value]["phone"]);
    $xtpl->assign("diseaseid", $vaclist[$value]["diseaseid"]);
    // $xtpl->assign("disease", $vaclist[$value]["diseaseid"]);
    $xtpl->assign("disease", $vaclist[$value]["disease"]);
    $xtpl->assign("note", $vaclist[$value]["note"]);
    $xtpl->assign("confirm", $lang["confirm_" . $vaclist[$value]["status"]]);

    // var_dump($vaclist[$value]); die();
    if ($vaclist[$value]["status"] > 1) {
      $xtpl->parse("disease.vac_body.recall_link");
    }
    switch ($vaclist[$value]["status"]) {
      case '1':
        $xtpl->assign("color", "orange");
        break;
      case '2':
        $xtpl->assign("color", "green");
        break;
      case '4':
        $xtpl->assign("color", "gray");
        break;
      default:
        $xtpl->assign("color", "red");
        break;
    }
    if ($order) {
      $d = $vaclist[$value]["calltime"];
    } else {
      $d = $vaclist[$value]["cometime"];
    }
    $c = 15 - round(($d - $now) * 2 / $hack);
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
    $xtpl->assign("disease", $vaclist[$value]["disease"]);
    $xtpl->assign("note", $vaclist[$value]["note"]);
    $xtpl->assign("confirm", $lang["confirm_" . $vaclist[$value]["status"]]);
    if ($vaclist[$value]["status"] > 1) {
      $xtpl->parse("disease.vac_body.recall_link");
    }
    switch ($vaclist[$value]["status"]) {
      case '1':
        $xtpl->assign("color", "orange");
        break;
      case '2':
        $xtpl->assign("color", "green");
        break;
      case '4':
        $xtpl->assign("color", "gray");
        break;
      default:
        $xtpl->assign("color", "red");
        break;
    }
    if ($order) {
      $d = $vaclist[$value]["calltime"];
    } else {
      $d = $vaclist[$value]["cometime"];
    }
    $c = 14 - round(($now - $d) * 2 / $hack);
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
    $xtpl->assign("name", $doctor_data["name"]);
    $xtpl->parse("main.doctor");
  }

  $xtpl->parse("main");
  return $xtpl->text("main");
}

function getrecentlist($fromtime, $amount_time, $sort, $keyword) {
  global $db, $db_config, $module_name;
  $endtime = $fromtime + $amount_time;
  $fromtime -= $amount_time;

  $order = '';
  switch ($sort) {
    case '1':
      $order = 'order by cometime, c.name asc';
      break;
    case '2':
      $order = 'order by cometime, c.name desc';
      break;
    case '3':
      $order = 'order by calltime, c.name asc';
      break;
    case '4':
      $order = 'order by calltime, c.name desc';
      break;
  }

  $where = "where b.name like '%$keyword%' or c.name like '%$keyword%' or c.phone like '%$keyword%'";

  $sql = "select a.id, a.note, a.recall, b.id as petid, b.name as petname, c.id as customerid, c.name as customer, c.phone as phone, cometime, calltime, status, diseaseid, dd.name as disease from " . VAC_PREFIX . "_vaccine a inner join " . VAC_PREFIX . "_pet b on cometime between " . $fromtime . " and " . $endtime . " and a.petid = b.id inner join " . VAC_PREFIX . "_customer c on b.customerid = c.id inner join " . VAC_PREFIX . "_disease dd on a.diseaseid = dd.id $where " . $order;
  $result = $db->sql_query($sql);
  $sql = "select a.id, a.note, a.recall, b.id as petid, b.name as petname, c.id as customerid, c.name as customer, c.phone as phone, cometime, calltime, status, diseaseid, dd.name as disease from " . VAC_PREFIX . "_vaccine a inner join " . VAC_PREFIX . "_pet b on cometime between " . $fromtime . " and " . $endtime . " and a.petid = b.id inner join " . VAC_PREFIX . "_customer c on b.customerid = c.id inner join (select 0 as id, 'Siêu Âm' as name from DUAL) dd on a.diseaseid = dd.id $where " . $order;
  $result2 = $db->sql_query($sql);
  $ret = array();
  while ($row = $db->sql_fetch_assoc($result)) {
    $ret[] = $row;
  }
  while ($row = $db->sql_fetch_assoc($result2)) {
    $ret[] = $row;
  }
  return $ret;
}

function filterVac($fromtime, $amount_time, $sort, $keyword) {
  global $db, $db_config, $module_name;
  $endtime = $fromtime + $amount_time;
  $fromtime -= $amount_time;

  $order = '';
  switch ($sort) {
    case '1':
      $order = 'order by cometime, c.name asc';
      break;
    case '2':
      $order = 'order by cometime, c.name desc';
      break;
    case '3':
      $order = 'order by calltime, c.name asc';
      break;
    case '4':
      $order = 'order by calltime, c.name desc';
      break;
  }

  $where = "where b.name like '%$keyword%' or c.name like '%$keyword%' or c.phone like '%$keyword%'";

  $sql = "select a.id, a.note, b.id as petid, b.name as petname, c.id as customerid, c.name as customer, c.phone as phone, cometime, calltime, recall, status, diseaseid, dd.name as disease from " . VAC_PREFIX . "_vaccine a inner join " . VAC_PREFIX . "_pet b on calltime between " . $fromtime . " and " . $endtime . " and a.petid = b.id inner join " . VAC_PREFIX . "_customer c on b.customerid = c.id inner join " . VAC_PREFIX . "_disease dd on a.diseaseid = dd.id $where " . $order;
  $result = $db->sql_query($sql);
  $sql = "select a.id, a.note, b.id as petid, b.name as petname, c.id as customerid, c.name as customer, c.phone as phone, cometime, calltime, recall, status, diseaseid, dd.name as disease from " . VAC_PREFIX . "_vaccine a inner join " . VAC_PREFIX . "_pet b on calltime between " . $fromtime . " and " . $endtime . " and a.petid = b.id inner join " . VAC_PREFIX . "_customer c on b.customerid = c.id inner join (select 0 as id, 'Siêu Âm' as name from DUAL) dd on a.diseaseid = dd.id where " . $order;
  $result2 = $db->sql_query($sql);
  $ret = array();
  while ($row = $db->sql_fetch_assoc($result)) {
    $ret[] = $row;
  }
  while ($row = $db->sql_fetch_assoc($result2)) {
    $ret[] = $row;
  }
//   var_dump($ret);
//   die();
  
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

  $sql = "select a.id, a.note, b.id as petid, b.petname, c.id as customerid, c.name as customer, c.phone as phone, cometime, calltime, status, doctorid, recall, '$diseaseid' as diseaseid, '$disease' as disease from " . VAC_PREFIX . "_" . $diseaseid . " a inner join " . VAC_PREFIX . "_pet b on calltime between " . $fromtime . " and " . $endtime . " and a.petid = b.id inner join " . VAC_PREFIX . "_customer c on b.customerid = c.id where c.customer like '%$customer%' or c.phone like '%$customer%' " . $order;

  // if ($diseaseid == 2) {
  // }
  // $sql = "select a.id, b.id as petid, b.petname, c.id as customerid, c.customer, c.phone as phone, cometime, calltime, status from " . VAC_PREFIX . "_" . $diseaseid . " a inner join " . VAC_PREFIX . "_pet b on calltime between " . $fromtime . " and " . $endtime . " and a.petid = b.id inner join " . VAC_PREFIX . "_customer c on b.customerid = c.id where c.customer like '%$customer%' or c.phone like '%$customer%' " . $order;
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
    $sql = "select * from `" . VAC_PREFIX . "_customer` where name like '%$customer%'";
  } else {
    $sql = "select * from `" . VAC_PREFIX . "_customer` where phone like '%$phone%'";
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

  $sql = "select count(b.id) as num from " . VAC_PREFIX . "_pet b inner join " . VAC_PREFIX . "_customer c on b.customerid = c.id where c.name like '%$key%' or b.name like '%$key%'";
  $result = $db->sql_query($sql);
  $num = $db->sql_fetch_assoc($result);
  $patients["info"] = $num["num"];
  // var_dump($patients["info"]);

  $sql = "select b.id, b.name as petname, c.id as customerid, c.name as customer, c.phone from " . VAC_PREFIX . "_pet b inner join " . VAC_PREFIX . "_customer c on b.customerid = c.id where c.name like '%$key%' or b.name like '%$key%' or c.phone like '%$key%' " . $order . " limit $from_item, $end_item";
  $result = $db->sql_query($sql);
  while ($row = $db->sql_fetch_assoc($result)) {
    $patients["data"][] = $row;
  }
  // var_dump($patients);
  return $patients;
}

function getPatientsList2($customerid) {
  global $db, $db_config, $module_name;
  $sql = "select name as customer, phone, address from " . VAC_PREFIX . "_customer where id = $customerid";
  $result = $db->sql_query($sql);
  $patients = $db->sql_fetch_assoc($result);
  $patients["data"] = array();
  $sql = "select name as petname, id from " . VAC_PREFIX . "_pet where customerid = $customerid";
  $result = $db->sql_query($sql);
  $ax = array();
  while ($row = $db->sql_fetch_assoc($result)) {
    $ax[] = $row;
  }
  foreach ($ax as $key => $row) {
    $petid = $row["id"];
    $sql = "SELECT v.calltime, dd.name as disease from " . VAC_PREFIX . "_vaccine v inner join " . VAC_PREFIX . "_pet p on  v.petid = " . $petid . " and v.petid = p.id inner join " . VAC_PREFIX . "_customer c on p.customerid = c.id inner join " . VAC_PREFIX . "_disease dd on v.diseaseid = dd.id order by v.id desc";
    $query = $db->sql_query($sql);
    $crow = $db->sql_fetch_assoc($query);
    $sql = "SELECT v.calltime, dd.name as disease from " . VAC_PREFIX . "_vaccine v inner join " . VAC_PREFIX . "_pet p on  v.petid = " . $petid . " and v.petid = p.id inner join " . VAC_PREFIX . "_customer c on p.customerid = c.id inner join (select 0 as id, 'Siêu Âm' as name from DUAL) dd on v.diseaseid = dd.id order by v.id desc";
    $query2 = $db->sql_query($sql);
    $crow2 = $db->sql_fetch_assoc($query2);

    if ($row["cometime"] > $row2["cometime"]) {
        $data = $crow;
    }
    else {
        $data = $crow2;
    }
    if ($data) {
      $patients["data"][] = array("petid" => $row["id"], "petname" => $row["petname"], "lastcome" => $crow["calltime"], "lastname" => $crow["disease"]);
    } else {
      $patients["data"][] = array("petid" => $row["id"], "petname" => $row["petname"], "lastcome" => "", "lastname" => "");
    }
  }
  // ();
  return $patients;
}

function getPatientDetail($petid) {
  global $db, $db_config, $module_name;
  $sql = "select b.name as petname, c.name as customer, c.phone from " . VAC_PREFIX . "_pet b inner join " . VAC_PREFIX . "_customer c on b.id = $petid and b.customerid = c.id";
  $result = $db->sql_query($sql);
  $patients = $db->sql_fetch_assoc($result);

  $sql = "select v.*, dd.name as disease, dd.id as diseaseid from " . VAC_PREFIX . "_vaccine v inner join " . VAC_PREFIX . "_disease dd on v.diseaseid = dd.id and petid = $petid";
  $result = $db->sql_query($sql);
  $sql = "select v.*, dd.name as disease, dd.id as diseaseid from " . VAC_PREFIX . "_vaccine v inner join (select 0 as id, 'Siêu Âm' as name from DUAL) dd on v.diseaseid = dd.id and petid = $petid";
  $result2 = $db->sql_query($sql);
  $data = fetchall($db, $result);
  $data2 = fetchall($db, $result2);
  $patients["data"] = array_merge($data, $data2);
  
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
  global $module_config, $admin_info, $module_info, $module_name, $module_file, $lang_module;
  $today = strtotime(date("Y-m-d"));
  $worktime = 0;
  $resttime = 0;
  if (!empty($module_config[$module_name]["worktime"])) {
    $worktime = $module_config[$module_name]["worktime"];
  }
  else {
    $worktime = 7 * 60 * 60;
  }
  if (!empty($module_config[$module_name]["resttime"])) {
    $resttime = $module_config[$module_name]["resttime"];
  }
  else {
    $resttime = 17 * 60 * 60 + 30 * 60;
  }
  $from = $today + $worktime;
  $end = $today + $resttime;

  if (!empty($admin_info) && !empty($admin_info["level"]) && ($admin_info["level"] == "1")) {

  }
  else if (NV_CURRENTTIME < $from || NV_CURRENTTIME > $end) {
    // echo date("H:i:s", $worktime); 
    // echo date("H:i:s", $resttime); 
    $xtpl = new XTemplate("overtime.tpl", NV_ROOTDIR . "/themes/" . $module_info['template'] . "/modules/" . $module_file);
    $xtpl->assign("lang", $lang_module);

    $xtpl->parse("overtime");
    $contents = $xtpl->text("overtime");
    include ( NV_ROOTDIR . "/includes/header.php" );
    echo nv_site_theme($contents);
    include ( NV_ROOTDIR . "/includes/footer.php" );
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

?>
