<?php

if (!defined('NV_IS_MOD_VAC')) {
  die('Stop!!!');
}

$pid = $nv_Request->get_string('pid', 'post/get', '');
if (!empty($pid)) {
  $sql = "SELECT a.type as typeid, a.id, a.user, a.name, a.price, a.age as ageid, a.image, a.time, a.vaccine, a.description, b.name as owner, c.name as species, d.name as kind, b.province from post a inner join user b on a.id = $pid and a.user = b.id inner join species c on a.species = c.id inner join kind d on c.kind = d.id";
  if ($query = $db->sql_query($sql)) {
    $owner = parseData(array($db->sql_fetch_assoc($query)));
    $result["data"]["owner"] = $owner[0];
    $result["status"] = 1;
  }
}
