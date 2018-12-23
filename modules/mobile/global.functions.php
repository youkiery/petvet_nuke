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
    $l = strlen($type);
    $type = explode(",", $type);
    $check_type = array();
    foreach ($type as $key => $value) {
      if ($value !== "false") {
        $check_type[] = $key;
      }
    }
    $type_set = "";
    if (count($check_type)) {
      $type_set = "and a.type in (" . implode(",", $check_type) . ")";
    }

    $where = "where (a.name like '%$keyword%' or a.description like '%$keyword%' or b.name like '%$keyword%' or b.phone like '%$keyword%') $whereprovince and a.sold = 0 $type_set";
    $order = " order by " . $sorttype[$sort];

    if ($price[1] >= 100000) {
      $where .= " and price >= $price[0]";
    } else {
      $where .= " and price between $price[0] and $price[1]";
    }

    if ($species > 0) {
      $species = $_GET["species"];
      $where .= " and a.species = $species";
    } else if ($kind > 0) {
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

  if ($uid > 0 && $sort >= 0 && $type >= 0 && $page) {
    $where = "";
    $total = $page * 12;
    if (!empty($keyword)) {
      $where = " (a.name like '%$keyword%' or a.description like '%$keyword%' or b.name like '%$keyword%' or b.phone like '%$keyword%')";
    }

    $order = "order by " . $sorttype[$sort];
    $main = "SELECT a.type as typeid, a.kind as kindid, a.species as speciesid, a.id, a.user, a.name, a.price, a.age as ageid, a.image, a.time, a.vaccine, b.name as owner, a.description, c.name as species, d.name as kind, b.province from post a inner join user b on a.user = b.id inner join species c on a.species = c.id inner join kind d on c.kind = d.id";
    $main2 = "SELECT e.id as oid, a.type as typeid, a.kind as kindid, a.species as speciesid, a.id, a.user, a.name, a.price, a.age as ageid, a.image, a.time, a.vaccine, b.name as owner, a.description, c.name as species, d.name as kind, b.province from petorder e inner join post a on e.pid = a.id inner join user b on a.user = b.id inner join species c on a.species = c.id inner join kind d on c.kind = d.id";
    $count = "SELECT count(a.id) as count from post a inner join user b on a.user = b.id";
    $count2 = "SELECT count(a.id) as count from petorder e inner join post a on e.pid = a.id inner join user b on a.user = b.id";

    $typeid = 0;
    $allrow = array();
    switch ($type) {
      case '1':
        // buy
        $sql = "select * from petorder e inner join user b on e.user = b.id $where limit " . ($page * 12);
        $sql2 = "select count(e.id) as count from petorder e inner join user b on e.user = b.id $where";
        $query = $db->sql_query($sql);
        while ($row = $db->sql_fetch_assoc($query)) {
          $sql = "select * from post where id = " . $row["pid"];
          $query2 = $db->sql_query($sql);
          $crow = $db->sql_fetch_assoc($query2);
          if ($crow) {
            $row["image"] = $crow["image"];
            $row["ageid"] = $crow["age"];
            $row["price"] = $crow["price"];
            $row["time"] = $crow["time"];
            $row["typeid"] = $crow["type"];
            $row["kind"] = $crow["kind"];
            $row["species"] = $crow["species"];
            $allrow[] = $row;
          }
          // $sql = "select count(e.id) as count from petorder e inner join user b on e.user = a.id where e.pid = $row[id]";
          // $query2 = $db->sql_query($sql);
          // $result = $db->sql_fetch_assoc($query2);
          // $row["count"] = $result["count"];
          // var_dump();
        }
        break;
      case '2':
        // order
        $sql = "select * from petorder e inner join post a on e.pid = a.id inner join user b on a.user = b.id $where and type > 0 $order limit " . ($page * 12);
        $sql2 = "select count(e.id) as count from petorder e inner join post a on e.pid = a.id inner join user b on a.user = b.id $where and type > 0";
        $query = $db->sql_query($sql);
        while ($row = $db->sql_fetch_assoc($query)) {
          $sql = "select * from post where id = " . $row["pid"];
          $query2 = $db->sql_query($sql);
          $crow = $db->sql_fetch_assoc($query2);
          $row["image"] = $crow["image"];
          $row["ageid"] = $crow["age"];
          $row["price"] = $crow["price"];
          $row["time"] = $crow["time"];
          $row["typeid"] = $crow["type"];
          $row["kind"] = $crow["kind"];
          $row["species"] = $crow["species"];
          $allrow[] = $row;
        }
        break;
      case '3':
        // mating
        $sql = "select * from petorder e inner join post a on e.pid = a.id inner join user b on a.user = b.id $where and type = 0 $order limit " . ($page * 12);
        $sql2 = "select count(e.id) as count from petorder e inner join post a on e.pid = a.id inner join user b on a.user = b.id $where and type = 0";
        $query = $db->sql_query($sql);
        while ($row = $db->sql_fetch_assoc($query)) {
          $sql = "select * from post where id = " . $row["pid"];
          $query2 = $db->sql_query($sql);
          $crow = $db->sql_fetch_assoc($query2);
          // $sql = "select count(e.id) as count from petorder e inner join user b on e.user = a.id where e.pid = $row[id]";
          // $query2 = $db->sql_query($sql);
          // $result = $db->sql_fetch_assoc($query2);
          // $row["count"] = $result["count"];
          $row["image"] = $crow["image"];
          $row["ageid"] = $crow["age"];
          $row["price"] = $crow["price"];
          $row["time"] = $crow["time"];
          $row["typeid"] = $crow["type"];
          $row["kind"] = $crow["kind"];
          $row["species"] = $crow["species"];
          $allrow[] = $row;
        }
        break;
      default:
        //sell
        $sql = "select b.*, a.* from post a inner join user b on a.user = b.id $where $order limit " . ($page * 12 - 1);
        $sql2 = "select count(a.id) from post a inner join user on a.user = b.id $where $order";
        $query = $db->sql_query($sql);
        while ($row = $db->sql_fetch_assoc($query)) {
          $sql = "select count(e.id) as count from petorder e where e.pid = $row[id]";
          $query2 = $db->sql_query($sql);
          $r_count = $db->sql_fetch_assoc($query2);
          $row["count"] = $r_count["count"];
          $row["ageid"] = $row["age"];
          $row["typeid"] = $row["type"];
          $allrow[] = $row;
        }
        $total --;
    }

    $alldata = parseData($allrow);
    $result["data"]["userpet"] = $alldata;
    $result["data"]["next"] = false;
    if ($count > $total) {
      $result["data"]["next"] = true;
    }

    $count_result = $db->sql_query($sql2);
    $count = $count_result["count"];
    if (!$count > 0) {
      $count = 0;
    }

    if ($query) {
      $result["status"] = 1;
    }

    // $result["count"] = $countid["count"];
    // $result["to"] = $to;

    // $query = $db->sql_query($sql);

    // if ($query) {
    //   if (!$result["status"]) {
    //     $result["status"] = 1;
    //   }
    //   $userpet = sqlfetchall($db, $query);
    //   foreach ($userpet as $key => $row) {
    //     $userpet[$key]["realtime"] = date("d/m/Y", $row["time"]);
    //     $sql = "select * from petorder pid = $row[id]";
    //     $query = $db->sql_query($sql);
    //     $petorder = sqlfetchall($db, $query);
    //     $userpet[$key]["count"] = count($petorder);
    //     $sql = "select b.* from petorder a inner join user b on a.user = b.id a.pid = $row[id] and a.status = 1";
    //     $userpet[$key]["soldsql"] = $sql;
    //     $query = $db->sql_query($sql);
    //     $bought = $db->sql_fetch_assoc($query);
    //     $sql = "select b.* from petorder a inner join post c on a.pid = c.id inner join user b on c.user = b.id a.pid = $row[id] and a.status = 1";
    //     $userpet[$key]["boughtsql"] = $sql;
    //     $query = $db->sql_query($sql);
    //     $sold = $db->sql_fetch_assoc($query);
    //     if (!empty($sold)) {
    //       $userpet[$key]["sold"] = $sold;
    //     }
    //     if (!empty($bought)) {
    //       $userpet[$key]["bought"] = $bought;
    //     }
    //   }

    //   $result["data"]["userpet"] = parseData($userpet);
    //   if ($typeid) {

    //     $sql = "select count(type) as count from notify user = $uid and view = 0 and type = $typeid group by type order by type";
    //     $query = $db->sql_query($sql);
    //     $row = $db->sql_fetch_assoc($query);
    //     if ($row) {
    //       $result["data"]["new"] = $row["count"];
    //     } else {
    //       $result["data"]["new"] = 0;
    //     }
    //     $result["data"]["newtype"] = $typeid;

    //     $sql = "update notify set view = 1 type = $typeid and user = $uid and view = 0";
    //     $query = $db->sql_query($sql);
    //     $row = $db->sql_fetch_assoc($query);
    //     $result["status"] = 1;
    //   }
    // }
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
    $petlist[$key]["age"] = $config["age"][$value["ageid"]];
    $petlist[$key]["province"] = $config["province"][$value["province"]];
    $petlist[$key]["pricevalue"] = $value["price"];
    $petlist[$key]["price"] = number_format(preg_replace("/[^0-9.]/", "", $value["price"])) . " ₫";
    $timedistance = $time - $value["time"];
    $petlist[$key]["type"] = $type[$value["typeid"]];
    if ($value["kind"] == "Chưa chọn" || $value["species"] == "Chưa chọn") {
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

function sqlfetchall($db, $query) {
  $result = array();
  while ($row = $db->sql_fetch_assoc($query)) {
    $result[] = $row;
  }
  return $result;
}
