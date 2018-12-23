<?php
if (!defined('NV_IS_MOD_VAC')) {
  die('Stop!!!');
}
$action = $nv_Request->get_string('action', 'post/get', '');
$connectkey = $nv_Request->get_string('ck', 'post/get', '');

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

$type = array("Phối giống", "Cần bán", "Cần mua", "Muốn tặng", "Tìm thú lạc");
$role_type = array("Thành viên", "Mod", "Smod", "Admin");
$roles_type = array("a" => "Quản trị chung", "k" => "Thêm giống", "u" => "Sửa người dùng");
$result = array("status" => 0, "data" => array());
if (!(empty($action) || empty($connectkey))) {
  $result["data"]["key"] = $connectkey;
  $db_config["dbname"] = "petcoffe";
  $db_config["dbuname"] = "root";
  $db_config["dbpass"] = "";

  $db = new sql_db($db_config);
  $query = $db->sql_query("SET CHARACTER SET 'utf8'");

  $sql = "SELECT * FROM `config`";
  $query = $db->sql_query($sql);
  $data = sqlfetchall($db, $query);

  $config = array();
  foreach ($data as $key => $value) {
    $config[$value["name"]][] = $value["value"];
  }
  $newprovince = array("Toàn quốc");
  foreach ($config["province"] as $key => $row) {
    $newprovince[] = $row;
  }
  $config["province"] = $newprovince;
  $sorttype = array("time desc", "time asc", "price asc", "price desc");
  
  $allow_action = array("getlogin, login, signup, savepost, removepost, order, getinfo, filter, salefilter, disorder, postchat, rate, submitorder, getproviderpet, getnotify, getvender, getorderlist, changepass, changeinfo, changeprovince, getdatainfo, nextcomment, getnewnotice, getnewsalenotices, getnewsalenotice");
  if (in_array($action, $allow_action) >= 0) {
    $path = NV_ROOTDIR . "/modules/" . $module_name . "/funcs/" . $action . ".php";
    include_once($path);
  }
}

// var_dump($result);
echo json_encode($result);


