<?php

if (!defined('NV_IS_MOD_VAC')) {
  die('Stop!!!');
}

$uid = $nv_Request->get_string('uid', 'post/get', '');
$oid = $nv_Request->get_string('id', 'post/get', '');
$sort = $nv_Request->get_string('sort', 'post/get', '');
$type = $nv_Request->get_string('type', 'post/get', '');
$keyword = $nv_Request->get_string('keyword', 'post/get', '');
if ($uid > 0 && $oid > 0 && $sort >= 0 && $type >= 0) {
  $sql = "SELECT * from petorder where id = $oid";
  $query = $db->sql_query($sql);
  if ($row = $db->sql_fetch_assoc($query)) {
    $sql = "delete from petorder where id = $oid";
    if ($db->sql_query($sql)) {
      $where = " where (a.name like '%$keyword%' or a.description like '%$keyword%' or b.name like '%$keyword%' or b.phone like '%$keyword%')";
      $order = " order by " . $sorttype[$sort];
      $main = "SELECT e.id as oid, b.province, a.kind as kindid, a.species as speciesid, a.type as typeid, a.id, a.user, a.name, a.price, a.age as ageid, a.image, a.time, a.vaccine, b.name as owner, c.name as species from petorder e inner join post a on e.pid = a.id inner join user b on a.user = b.id inner join species c on a.species = c.id inner join kind d on c.kind = d.id";

      if ($type) {
        $sql = "$main $where and e.user = $uid $order";
      } else {
        $sql = "$main $where and a.user = $uid $order";
      }
      $query = $db->sql_query($sql);

      if ($query) {
        $sql = "insert into notify (type, user, uid, pid, time) values(2, $row[user], $uid, $row[id], " . time() . ")";
        $query = $db->sql_query($sql);
        $query = $db->sql_query($sql);
        $result["status"] = 1;
        $result["data"]["userpet"] = parseData(sqlfetchall($db, $query));
      }
    }
  }
}
