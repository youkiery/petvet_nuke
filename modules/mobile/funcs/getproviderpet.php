<?php

if (!defined('NV_IS_MOD_VAC')) {
  die('Stop!!!');
}

$name = $nv_Request->get_string('name', 'post/get', '');
$phone = $nv_Request->get_string('phone', 'post/get', '');
$page = $nv_Request->get_string('page', 'post/get', '');
if (!(empty($name) || (empty($phone))) && $page > 0) {
  $from = 0;
  $to = $page * 12;
  $limit = "limit $from, $to";
  $sql = "SELECT count(a.id) as count from post a inner join user b on b.name = '$name' and b.phone = '$phone' and a.user = b.id inner join species c on a.species = c.id inner join kind d on c.kind = d.id where sold = 0";
  $query = $db->sql_query($sql);
  $row = $db->sql_fetch_assoc($query);
  if ($row["count"] > $to) {
    $result["data"]["next"] = true;
  } else {
    $result["data"]["next"] = false;
  }

  // $result["data"]["sql"] = $sql;

  $sql = "SELECT a.type as typeid, a.id, a.user, a.name, a.price, a.age as ageid, a.image, a.time, a.vaccine, a.description, b.name as owner, c.name as species, d.name as kind, b.province from post a inner join user b on b.name = '$name' and b.phone = '$phone' and a.user = b.id inner join species c on a.species = c.id inner join kind d on c.kind = d.id where sold = 0 order by a.time desc $limit";
  $query = $db->sql_query($sql);
  if ($query) {
    $data = sqlfetchall($db, $query);
    // $sql = "SELECT * from rate a inner join post b on a.pid = b.id inner join user c on c.id in ("1", "2", "3") and b.user = c.id";
    $sql = "SELECT * from rate a inner join post b on a.pid = b.id inner join user c on c.id = b.user";
    $query = $db->sql_query($sql);
    $total = $db->sql_numrows($query);
    // $result["data"]["sql"] = $sql;

    if ($total) {
      $rate = sqlfetchall($db, $query);
      $totalpoint = 0;
      foreach ($rate as $key => $value) {
        $totalpoint += $value["value"];
      }
      $average = $totalpoint / $total;
    } else {
      $average = 0;
    }

    $sql = "SELECT * from post a inner join user b on b.name = '$name' and b.phone = '$phone' and a.sold = 1 and a.user = b.id";
    $query = $db->sql_query($sql);
    $totalsale = $db->sql_numrows($query);
    // $result["data"]["sql"] = $sql;

    $crate = array();
    foreach ($rate as $key => $row) {
      $crate[] = array("name" => $row["name"], "msg" => $row["review"], "time" => date("d/m/Y", $row["time"]));
    }

    $result["status"] = 1;
    $result["data"]["propet"] = parseData($data);
    $result["data"]["total"] = $total;
    $result["data"]["average"] = $average;
    $result["data"]["totalsale"] = $totalsale;
    $result["data"]["rate"] = $crate;
  }
}
