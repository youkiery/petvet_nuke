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
//   var_dump($customers["info"]); die();

  $sql = "select id, name as customer, phone, address from " . VAC_PREFIX . "_customer where name like '%$key%' or phone like '%$key%' " . $order . " limit $from_item, $end_item";
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

    $sql = "select a.id, b.id as petid, b.petname, c.id as customerid, c.name as customer, c.phone as phone, cometime, calltime, status from " . VAC_PREFIX . "_vaccine a inner join " . VAC_PREFIX . "_pet b on calltime between " . $fromtime . " and " . $endtime . " and a.petid = b.id inner join " . VAC_PREFIX . "_customer c on b.customerid = c.id where c.customer like '%$key%' or phone like '%$key%' " . $order;

    // $sql = "select a.id, b.id as petid, b.petname, c.id as customerid, c.customer, c.phone as phone, cometime, calltime, status, recall, doctorid from " . VAC_PREFIX . "_" . $id . " a inner join " . VAC_PREFIX . "_pet b on calltime between " . $fromtime . " and " . $endtime . " and a.petid = b.id inner join " . VAC_PREFIX . "_customer c on b.customerid = c.id";

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
  $xtpl->parse("main");


  // $sql = "select a.id, b.id as petid, b.petname, c.id as customerid, c.customer, c.phone as phone, cometime, calltime, status from " . VAC_PREFIX . "_" . $id . " a inner join " . VAC_PREFIX . "_pet b on calltime between " . $time . " and " . $next_time . " and a.petid = b.id inner join " . VAC_PREFIX . "_customer c on b.customerid = c.id" . $order;

  return $xtpl->text("main");
}

function filter($vaclist, $path, $lang, $fromtime, $amount_time, $sort, $order) {
  $hex = array("0", "1", "2", "3", "4", "5", "6", "7", "8", "9", "a", "b", "c", "d", "e", "f");
  $xtpl = new XTemplate("list-1.tpl", $path);
  $xtpl->assign("lang", $lang);

  $fromtime = strtotime($fromtime);

  $diseases = getDiseaseList();
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
    $xtpl->assign("name", $doctor_data["name"]);
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

  $sql = "select a.id, a.note, b.id as petid, b.petname, c.id as customerid, c.name as customer, c.phone as phone, cometime, calltime, status, doctorid, recall, '$diseaseid' as diseaseid from " . VAC_PREFIX . "_" . $diseaseid . " a inner join " . VAC_PREFIX . "_pet b on cometime between " . $fromtime . " and " . $endtime . " and a.petid = b.id inner join " . VAC_PREFIX . "_customer c on b.customerid = c.id " . $order;

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

  $sql = "select a.id, a.note, b.id as petid, b.petname, c.id as customerid, c.name as customer, c.phone as phone, cometime, calltime, status, doctorid, recall, '$diseaseid' as diseaseid from " . VAC_PREFIX . "_" . $diseaseid . " a inner join " . VAC_PREFIX . "_pet b on calltime between " . $fromtime . " and " . $endtime . " and a.petid = b.id inner join " . VAC_PREFIX . "_customer c on b.customerid = c.id " . $order;

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

  $sql = "select a.id, a.note, b.id as petid, b.petname, c.id as customerid, c.name as customer, c.phone as phone, cometime, calltime, status, doctorid, recall, '$diseaseid' as diseaseid, '$disease' as disease from " . VAC_PREFIX . "_" . $diseaseid . " a inner join " . VAC_PREFIX . "_pet b on calltime between " . $fromtime . " and " . $endtime . " and a.petid = b.id inner join " . VAC_PREFIX . "_customer c on b.customerid = c.id where c.customer like '%$customer%' or c.phone like '%$customer%' " . $order;

  // if ($diseaseid == 2) {
  // 	die($sql);
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
  // die();

  $sql = "select b.id, b.name as petname, c.id as customerid, c.name as customer, c.phone from " . VAC_PREFIX . "_pet b inner join " . VAC_PREFIX . "_customer c on b.customerid = c.id where c.name like '%$key%' or b.name like '%$key%' or c.phone like '%$key%' " . $order . " limit $from_item, $end_item";
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
    $sql = "SELECT v.calltime, dd.name as disease from " . VAC_PREFIX . "_vaccine v inner join " . VAC_PREFIX . "_pet p on  v.petid = " . $petid . " and v.petid = p.id inner join " . VAC_PREFIX . "_customer c on p.customerid = c.id inner join disease dd on v.disease = dd.id order by v.id desc";
    $query = $db->sql_query($sql);

    if ($query) {
      $row2 = $db->sql_fetch_assoc($query);
      $patients["data"][] = array("petid" => $row["id"], "petname" => $row["petname"], "lastcome" => $row2["calltime"], "lastname" => $row2["disease"]);
    } else {
      $patients["data"][] = array("petid" => $row["id"], "petname" => $row["petname"], "lastcome" => "", "lastname" => "");
    }
  }
  // die();
  return $patients;
}

function getPatientDetail($petid) {
  global $db, $db_config, $module_name;
  $sql = "select b.name as petname, c.name as customer, c.phone from " . VAC_PREFIX . "_pet b inner join " . VAC_PREFIX . "_customer c on b.id = $petid and b.customerid = c.id";
  $result = $db->sql_query($sql);
  $patients = $db->sql_fetch_assoc($result);

  $sql = "select v.*, dd.name as disease, dd.id as diseaseid from " . VAC_PREFIX . "_vaccine v inner join " . VAC_PREFIX . "_disease dd on petid = $petid and v.diseaseid = dd.id";
  $result = $db->sql_query($sql);
  $patients["data"] = fetchall($db, $result);
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
  $worktime = $today;
  $resttime = $today;
  if (!empty($global_config["worktime"])) {
    $worktime = $global_config["worktime"];
  }
  if (!empty($global_config["resttime"])) {
    $resttime = $global_config["resttime"];
  }
  $from = $worktime ? $worktime : $today + 7 * 60 * 60;
  $end = $resttime ? $resttime : $today + 17 * 60 * 60 + 30 * 60;

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

?>
