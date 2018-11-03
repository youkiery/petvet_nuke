<?php

$key = $nv_Request->get_string('key', 'get', '');
$hex = array("0", "1", "2", "3", "4", "5", "6", "7", "8", "9", "a", "b", "c", "d", "e", "f");
$fromtime = strtotime($fromtime);
$now = strtotime(date("Y-m-d", NV_CURRENTTIME));
$today = date("d", $now);
$dom = date("t");

$xtpl = new XTemplate("list-1.tpl", NV_ROOTDIR . "/themes/" . $module_info['template'] . "/modules/" . $module_file);
$xtpl->assign("lang", $lang_module);

$diseases = getDiseaseList();
foreach ($diseases as $disease) {
  $xtpl->assign("title", $disease["disease"]);
  $vacs = getvaccustomer($key, strtotime(date("Y-m-d", NV_CURRENTTIME)), $global_config["filter_time"], $global_config["sort_type"], $disease["id"]);

  $i = 1;
	$xtpl->assign("diseaseid", $disease["id"]);
	$realvac = array();
    $sort_order_left = array();
	$sort_order_right = array();

	$price = array();
	foreach ($vacs as $key => $row) {
		$price[$key] = $row['calltime'];
	}
	array_multisort($price, SORT_ASC , $vacs);

	foreach ($vacs as $key => $row) {
		$realvac[$row["petid"]] = $key;
	}


  foreach ($realvac as $key => $row) {
		if ($vacs[$row]["calltime"] <= $now)
      $sort_order_right[] = $row;
    else
      $sort_order_left[] = $row;
  }
		asort($sort_order_left);
		arsort($sort_order_right);
  foreach ($sort_order_left as $key => $value) {
    $xtpl->assign("index", $i);
    $xtpl->assign("petname", $vacs[$value]["petname"]);
    $xtpl->assign("petid", $vacs[$value]["petid"]);
    $xtpl->assign("vacid", $vacs[$value]["id"]);
    $xtpl->assign("customer", $vacs[$value]["customer"]);
		$xtpl->assign("phone", $vacs[$value]["phone"]);
    $xtpl->assign("confirm", $lang_module["confirm_" . $vacs[$value]["status"]]);
    if ($vacs[$value]["status"] == 2 && !$vacs[$value]["recall"])
      $xtpl->parse("disease.vac_body.recall_link");
		switch ($vacs[$value]["status"]) {
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
    $d = date("d", $vacs[$value]["calltime"]);
    if ($d - $today < 0) {
      $c = $dom - $today + $d;
    } else {
      $c = $d - $today;
    }
    $c = 15 - round($c / 2);
    $xtpl->assign("bgcolor", "#4" . $hex[$c] . "4");
    $xtpl->assign("cometime", date("d/m/Y", $vacs[$value]["cometime"]));
    $xtpl->assign("calltime", date("d/m/Y", $vacs[$value]["calltime"]));
    $i++;
    $xtpl->parse("disease.vac_body");
	}
  foreach ($sort_order_right as $key => $value) {
    $xtpl->assign("index", $i);
    $xtpl->assign("petname", $vacs[$value]["petname"]);
    $xtpl->assign("petid", $vacs[$value]["petid"]);
    $xtpl->assign("vacid", $vacs[$value]["id"]);
    $xtpl->assign("customer", $vacs[$value]["customer"]);
    $xtpl->assign("phone", $vacs[$value]["phone"]);
    $xtpl->assign("confirm", $lang_module["confirm_" . $vacs[$value]["status"]]);
    if ($vacs[$value]["status"] == 2 && !$vacs[$value]["recall"])
			$xtpl->parse("disease.vac_body.recall_link");
    switch ($vacs[$value]["status"]) {
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
    $d = date("d", $vacs[$value]["calltime"]);
    if ($today - $d < 0) {
      $c = $today + $dom - $d;
      // day of prv month
    } else {
      $c = $today - $d;
    }
    $c = 15 - round($c / 2);
    $xtpl->assign("bgcolor", "#$hex[$c]$hex[$c]$hex[$c]");
    $xtpl->assign("cometime", date("d/m/Y", $vacs[$value]["cometime"]));
    $xtpl->assign("calltime", date("d/m/Y", $vacs[$value]["calltime"]));
    $i++;
    $xtpl->parse("disease.vac_body");
  }
  $xtpl->parse("disease");
}
echo $xtpl->text("disease");
die();
?>
