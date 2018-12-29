<?php

if (!defined('NV_IS_MOD_VAC')) {
  die('Stop!!!');
}

$uid = $nv_Request->get_string('uid', 'post/get', '');
$msg = "";

$user = array();
if ($uid > 0 && $user = getuserbuid($uid)) {
  $result["data"]["info"] = $user;
  $notify = getnotify($uid);
}

$age = getage();
$area = getarea();
$broadcast = getbroadcast($user);
echo json_encode($broadcast);
$category = getcategory();
$post = getpost();
die();
