<?php
if (!defined('NV_IS_MOD_VAC')) {
  die('Stop!!!');
}
$action = $nv_Request->get_string('action', 'post/get', '');
$connectkey = $nv_Request->get_string('ck', 'post/get', '');

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

$result = array("status" => 0, "data" => array());
if (!(empty($action) || empty($connectkey))) {
  $result["data"]["key"] = $connectkey;
  $db_config["dbname"] = "petcoffe";
  $db_config["dbuname"] = "root";
  $db_config["dbpass"] = "";

  $db = new sql_db($db_config);
  $query = $db->sql_query("SET CHARACTER SET 'utf8'");

  // $allow_action = array("getlogin, login, signup, savepost, removepost, order, getinfo, filter, salefilter, disorder, postchat, rate, submitorder, getproviderpet, getnotify, getvender, getorderlist, changepass, changeinfo, changeprovince, getdatainfo, nextcomment, getnewnotice, getnewsalenotices, getnewsalenotice");
  if ($query) {
    $path = NV_ROOTDIR . "/modules/" . $module_name . "/funcs/" . $action . ".php";
    include_once($path);
  }
}

// var_dump($result);
echo json_encode($result);


