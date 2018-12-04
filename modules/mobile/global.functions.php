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

function filterbase() {
  global $db, $result, $sorttype, $nv_Request;
  $sort = $nv_Request->get_string('sort', 'post/get', '');
  $price = $nv_Request->get_string('price', 'post/get', '');
  $type = $nv_Request->get_string('type', 'post/get', '');
  $province = $nv_Request->get_string('province', 'post/get', '');
  $page = $nv_Request->get_string('page', 'post/get', '');
  $keyword = $nv_Request->get_string('keyword', 'post/get', '');
  $species = $nv_Request->get_string('species', 'post/get', '');
  $kind = $nv_Request->get_string('kind', 'post/get', '');
  if ($sort >= 0 && !empty($price) && $type >= 0 && $page > 0) {
    $price = explode("-", $price);
    $whereprovince = "";
    if ($province > 0) {
      $whereprovince = "and b.province = $province";
    }

    $where = " where (a.name like '%$keyword%' or a.description like '%$keyword%' or b.name like '%$keyword%' or b.phone like '%$keyword%') $whereprovince and a.sold = 0 and a.type = $type";
    $order = " order by " . $sorttype[$sort];

    if ($price[1] >= 100000) {
      $where .= " and price >= $price[0]";
    } else {
      $where .= " and price between $price[0] and $price[1]";
    }

    if ($species >= 0) {
      $species = $_GET["species"];
      $where .= " and a.species = $species";
    } else if ($kind >= 0) {
      $kind = $_GET["kind"];
      $where .= " and d.kind = $kind";
    }

    $from = 0;
    $to = 12 * $page;

    $sql = "SELECT count(a.id) as count from post a inner join user b on a.user = b.id inner join species c on a.species = c.id inner join kind d on c.kind = d.id $where";
    $query = $db->sql_query($sql);
    $countid = $db->sql_fetch_assoc($query);
    $result["data"]["next"] = false;
    if ($countid["count"] > $to) {
      $result["data"]["next"] = true;
    }

    $sql = "SELECT a.type as typeid, a.id, a.user, a.name, a.price, a.age as ageid, a.image, a.time, a.vaccine, a.description, b.name as owner, c.name as species, d.name as kind, b.province from post a inner join user b on a.user = b.id inner join species c on a.species = c.id inner join kind d on c.kind = d.id $where $order limit $from, $to";
    // $result["data"]["sql"] = $sql;
    // die($sql);
    $query = $db->sql_query($sql);

    if ($query) {
      $result["status"] = 1;
      $result["data"]["newpet"] = parseData(sqlfetchall($db, $query));
    }
  }
}

function filterorder() {
  global $result, $db, $sorttype, $nv_Request;
  $uid = $nv_Request->get_string('uid', 'post/get', '');
  $sort = $nv_Request->get_string('sort', 'post/get', '');
  $type = $nv_Request->get_string('type', 'post/get', '');
  $keyword = $nv_Request->get_string('keyword', 'post/get', '');
  $page = $nv_Request->get_string('page', 'post/get', '');
  // echo 1;
  $result["step"] = 1;
  if ($uid > 0 && $sort >= 0 && $type >= 0 && $page) {
    $result["step"] = 2;
    // echo 2;
    $from = 0;
    $to = (12 * $page);

    $where = " where (a.name like '%$keyword%' or a.description like '%$keyword%' or b.name like '%$keyword%' or b.phone like '%$keyword%')";
    $order = " order by " . $sorttype[$sort];
    $main = "SELECT a.type as typeid, a.kind as kindid, a.species as speciesid, a.id, a.user, a.name, a.price, a.age as ageid, a.image, a.time, a.vaccine, b.name as owner, a.description, c.name as species, d.name as kind, b.province from post a inner join user b on a.user = b.id inner join species c on a.species = c.id inner join kind d on c.kind = d.id";
    $main2 = "SELECT e.id as oid, a.type as typeid, a.kind as kindid, a.species as speciesid, a.id, a.user, a.name, a.price, a.age as ageid, a.image, a.time, a.vaccine, b.name as owner, a.description, c.name as species, d.name as kind, b.province from petorder e inner join post a on e.pid = a.id inner join user b on a.user = b.id inner join species c on a.species = c.id inner join kind d on c.kind = d.id";
    $count = "SELECT count(a.id) as count from post a inner join user b on a.user = b.id";
    $count2 = "SELECT count(a.id) as count from petorder e inner join post a on e.pid = a.id inner join user b on a.user = b.id";

    $result["step"] = 3;

    $typeid = 0;
    switch ($type) {
      case '1':
        // buy
        $sql = "$main2 $where and e.user = $uid and a.sold = 0 $order limit $from, $to";
        $sql2 = "$count2 $where and e.user = $uid and a.sold = 0 $order";
        break;
      case '2':
        // order
        // $sql = "SELECT * from petorder e inner join post a  e.user = $uid";
        $sql = "$main2 $where and a.user = $uid and a.sold = 0 group by e.pid $order, e.pid limit $from, $to";
        $sql2 = "$count2 $where and a.user = $uid and a.sold = 0 group by e.pid $order, e.pid";
        $typeid = 1;
        break;
      case '3':
        // sold
        $sql = "$main2 $where and a.user = $uid and a.sold = 1 and e.status = 1 $order limit $from, $to";
        $sql2 = "$count2 $where and a.user = $uid and a.sold = 1 and e.status = 1 $order";
        $typeid = 6;
        break;
      case '4':
        // bought
        $sql = "$main2 $where and e.user = $uid and a.sold = 1 and e.status = 1 $order limit $from, $to";
        $sql2 = "$count2 $where and e.user = $uid and a.sold = 1 and e.status = 1 $order";
        $typeid = 7;
        break;
      default:
        //sell
        $sql = "$main $where and a.user = $uid and a.sold = 0 $order limit $from, " . ($to - 1);
        $sql2 = "$count $where and a.user = $uid and a.sold = 0 $order";
    }
    $result["sql"] = $sql;

    $query = $db->sql_query($sql2);
    $countid = $db->sql_fetch_assoc($query);
    $result["data"]["next"] = false;
    $result["count"] = $countid["count"];
    $result["to"] = $to;
    // $result["sql"] = $sql2;
    if ($countid["count"] > $to) {
      $result["data"]["next"] = true;
    }

    // echo $type;
    $query = $db->sql_query($sql);

    // $result["sql"] = $sql;
    if ($query) {
      if (!$result["status"]) {
        $result["status"] = 1;
      }
      $userpet = sqlfetchall($db, $query);
      $result["data"]["userpet"] = parseData($userpet);
      if ($typeid) {

        $sql = "select count(type) as count from notify where user = $uid and view = 0 and type = $typeid group by type order by type";
        $query = $db->sql_query($sql);
        $row = $db->sql_fetch_assoc($query);
        if ($row) {
          $result["data"]["new"] = $row["count"];
        } else {
          $result["data"]["new"] = 0;
        }
        $result["data"]["newtype"] = $typeid;

        $sql = "update notify set view = 1 where type = $typeid and user = $uid and view = 0";
        $query = $db->sql_query($sql);
        $row = $db->sql_fetch_assoc($query);
        $result["status"] = 1;
      }
    }
  }
}

function parseData($petlist) {
  global $config;
  $time = time();
  $hour = 60 * 60;
  $day = 24 * $hour;
  $week = 7 * $day;
  $month = 30 * $day;
  $year = 365 * $day;
  $type = array("Cần bán", "Cần mua", "Muốn tặng", "Tìm thú lạc");
  // var_dump($petlist);
  foreach ($petlist as $key => $value) {
    $images = explode("|", $petlist[$key]["image"]);
    foreach ($images as $key2 => $value2) {
      if (empty($value2)) {
        $images[$key2] = "../assets/imgs/noimage.png";
      } else {
        $images[$key2] = "http://" . $_SERVER["SERVER_NAME"] . "/" . $value2;
      }
    }
    $petlist[$key]["image"] = $images;
    // var_dump($config["age"][$value["age"]]);
    // die();
    $petlist[$key]["age"] = $config["age"][$value["ageid"]];
    $petlist[$key]["province"] = $config["province"][$value["province"]];
    $petlist[$key]["pricevalue"] = $value["price"];
    $petlist[$key]["price"] = number_format(preg_replace("/[^0-9.]/", "", $value["price"])) . " ₫";
    $timedistance = $time - $value["time"];
    $petlist[$key]["type"] = $type[$value["typeid"]];
    if ($value["kind"] == "Chưa chọn" || $value[$value["species"] == "Chưa chọn"]) {
      $petlist[$key]["typename"] = "Chưa chọn";
    } else {
      $petlist[$key]["typename"] = $value["kind"] . " " . $value["species"];
    }

    if ($timedistance > (3 * $year)) {
      $petlist[$key]["timer"] = floor($timedistance / $year) . " năm";
    } else if ($timedistance > (3 * $month)) {
      $petlist[$key]["timer"] = floor($timedistance / $month) . " tháng";
    } else if ($timedistance > (3 * $week)) {
      $petlist[$key]["timer"] = floor($timedistance / $week) . " tuần";
    } else if ($timedistance > (3 * $day)) {
      $petlist[$key]["timer"] = floor($timedistance / $day) . " ngày";
    } else {
      $h = floor($timedistance / $hour);
      if ($h) {
        $petlist[$key]["timer"] = $h . " giờ";
      } else {
        $petlist[$key]["timer"] = "vừa mới";
      }
    }
  }
  return $petlist;
}

function checkParam($param, $post = false) {
  $check = true;
  if ($post) {
    foreach ($param as $value) {
      if (!$check && (!isset($_POST[$value]) && $_POST[$value] !== "")) {
        $check = false;
      }
    }
  } else {
    foreach ($param as $value) {
      if (!$check || (!isset($_GET[$value]) || $_GET[$value] == "")) {
        $check = false;
      }
    }
  }
  // var_dump($check);
  return $check;
}

function sqlfetchall($db, $query) {
  $result = array();
  while ($row = $db->sql_fetch_assoc($query)) {
    $result[] = $row;
  }
  return $result;
}
