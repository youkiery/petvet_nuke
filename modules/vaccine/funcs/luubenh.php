<?php

/**
 * @Project NUKEVIET-MUSIC
 * @Author Phan Tan Dung
 * @Copyright (C) 2011
 * @Createdate 26/01/2011 10:26 AM
 */
if (!defined('NV_IS_MOD_QUANLY'))
  die('Stop!!!');
$action = $nv_Request->get_string('action', 'post/get', '');
$ret = array("status" => 0, "data" => "");

quagio();
$status_option = array("Bình thường", "Hơi yếu", "Yếu", "Sắp chết", "Đã chết");
$export = array("Lưu bệnh", "Đã điều trị", "Đã chết");

if (!empty($action)) {
  switch ($action) {
    case 'luutreating':
    $ltid = $nv_Request->get_string('id', 'post', '');
    $temperate = $nv_Request->get_string('temperate', 'post', '');
    $eye = $nv_Request->get_string('eye', 'post', '');
    $other = $nv_Request->get_string('other', 'post', '');
    $examine = $nv_Request->get_string('examine', 'post', '');
    $treating = $nv_Request->get_string('treating', 'post', '');
    $status = $nv_Request->get_string('status', 'post', '');
    $doctorx = $nv_Request->get_string('doctorx', 'post', '');
    $ret["step"] = 1;

      if (! (empty($ltid) || $examine < 0 || $status < 0) && $doctorx >= 0) {
        $sql = "update " .  VAC_PREFIX . "_treating set temperate = '$temperate', eye = '$eye', other = '$other', examine = '$examine', treating = '$treating', status = $status, doctorx = $doctorx where id = $ltid";
        $ret["sql"] = $sql;

        if ($db->sql_query($sql)) {
          $sql = "select * from `" . VAC_PREFIX . "_treat` a inner join `" . VAC_PREFIX . "_treating` b on b.id = $ltid and a.id = b.treatid";
            $query = $db->sql_query($sql);
            if ($row = $db->sql_fetch_assoc($query)) {
              $ret["status"] = 1;
              $ret["data"]["color"] = mauluubenh($row["insult"], $row["status"]);
              $ret["data"]["status"] = $status_option[$row["status"]];
            }

          // $sql = "select timeluubenh, lieutrinh from " .  VAC_PREFIX . "_treat where id = $lid";
          // $query = $db->sql_query($sql);
          // if ($row = $db->sql_fetch_assoc($query)) {
          //   $lieutrinh = explode("|", $row["lieutrinh"]);
          //   $arrlieutrinh = array();
          //   $timebatdau = strtotime(date("Y-m-d", $row["timeluubenh"]));
          //   $khoangcach = floor(1 + (strtotime(date("Y-m-d")) - $timebatdau) / (24 * 60 * 60));
          //   // var_dump($khoangcach); die();

          //   foreach ($lieutrinh as $key => $value) {
          //     $time = date("Y-m-d", ($timebatdau + $key * 24 * 60 * 60));
          //     if ($value !== "") {
          //       $x = explode(":", $value);
          //       $status = $x[0];
          //       $note = $x[1];
          //     } else {
          //       $status = "";
          //     }
          //     // echo $time; die();
          //     $arrlieutrinh[] = array("time" => $time, "note" => $note, "status" => $status);
          //   }
          //   $ret["status"] = 1;
          //   $ret["data"] = json_encode($arrlieutrinh);
          // }
        }
      }
      break;
    case 'trihet':
      $lid = $nv_Request->get_string('id', 'post', '');
      $val = $nv_Request->get_string('val', 'post', '');
      
      if (!(empty($lid) || empty($val))) {
        $sql = "update " .  VAC_PREFIX . "_treat set insult = $val where id = $lid";
        // $ret["data"] = $sql;
        if ($db->sql_query($sql)) {
          $sql = "select * from `" . VAC_PREFIX . "_treat` where id = $lid";
          // $ret["data"] = $sql;
          $query = $db->sql_query($sql);
          if ($row = $db->sql_fetch_assoc($query)) {
            $ret["status"] = 1;
            $ret["data"]["color"] = mauluubenh($row["insult"], $row["status"]);
            $ret["data"]["insult"] = $export[$row["insult"]];
          }
        }
      }
      break;
    case 'delete_treat':
      $id = $nv_Request->get_string('id', 'post', '');
      if (!(empty($id))) {
        $sql = "delete from " .  VAC_PREFIX . "_treat where id = $id";
        if ($db->sql_query($sql)) {
          $ret["status"] = 1;
        }
      }
      break;
    case 'thongtinluubenh':
      $lid = $nv_Request->get_string('id', 'post', '');
      if (!(empty($lid))) {
        $sql = "SELECT a.id, a.cometime, a.insult, b.id, c.name as customer, c.phone, c.address, b.name as petname, d.name as doctor from " . VAC_PREFIX . "_treat a inner join " . VAC_PREFIX . "_pet b on a.id = $lid and a.petid = b.id inner join " . VAC_PREFIX .  "_customer c on c.id = b.customerid  inner join " . VAC_PREFIX . "_doctor d on a.doctorid = d.id order by cometime";
        $query = $db->sql_query($sql);
        if ($row = $db->sql_fetch_assoc($query)) {
          $row["cometime"] = date("d/m/Y", $row["cometime"]);
          $sql = "SELECT * from " . VAC_PREFIX . "_treating where treatid = $lid order by time";
          $query = $db->sql_query($sql);
          $lieutrinh = fetchall($db, $query);
          if ($lieutrinh) {
            foreach ($lieutrinh as $key => $value) {
              $lieutrinh[$key]["time"] = date("d/m", $value["time"]);
            }
            $row["treating"] = $lieutrinh;
          }
          $ret["status"] = 1;
          $ret["data"] = $row;
        }
      }
    break;
    case 'themlieutrinh':
      $lid = $nv_Request->get_string('id', 'post', '');
      $time = $nv_Request->get_string('time', 'post', '');
      $ret["step"] = 1;
      if (! (empty($lid) || empty($time))) {
        $i_time = strtotime($time);
        $sql = "select * from `" . VAC_PREFIX . "_treating` where treatid = $lid and time = " . $i_time;
        // $ret["data"] = $sql;
        $query = $db->sql_query($sql);
        
        $ret["sql"] = $sql;
        $numrows = $db->sql_numrows($query);
        if (!$db->sql_numrows($query)) {
          // echo 1;
          $sql = "insert into `" . VAC_PREFIX . "_treating` (treatid, temperate, eye, other, examine, image, time, treating, status) values($lid, '', '', '', 0, '', " . $i_time . ", '', 0)";
          // $ret["data"] = $sql;
          $ret["sql"] = $sql;
          if ($id = $db->sql_query_insert_id($sql)) {
            $ret["status"] = 1;
            $ret["data"]["id"] = $id;
            $ret["data"]["time"] = date_format(date_create($time), "d/m");
          }
        }
        else {
          $ret["status"] = 2;
        }
      }
    break;
  }

  echo json_encode($ret);
  die();
}

$xtpl = new XTemplate("luubenh.tpl", NV_ROOTDIR . "/themes/" . $module_info['template'] . "/modules/" . $module_file);
$xtpl->assign("lang", $lang_module);

$today = date("Y-m-d", NV_CURRENTTIME);
// echo $thongbao; die();

$xtpl->assign("now", $today);

$sql = "select * from " .  VAC_PREFIX . "_doctor";
$result = $db->sql_query($sql);

while ($row = $db->sql_fetch_assoc($result)) {
  $xtpl->assign("doctor_value", $row["id"]);
  $xtpl->assign("doctor_name", $row["doctor"]);
  $xtpl->parse("main.doctor");
}

// var_dump($status_option);

foreach ($status_option as $key => $value) {
  // echo $value;
  $xtpl->assign("status_value", $key);
  $xtpl->assign("status_name", $value);
  $xtpl->parse("main.status");
}
// die();

$xtpl->parse("main");

$contents = $xtpl->text("main");
include ( NV_ROOTDIR . "/includes/header.php" );
echo nv_site_theme($contents);
include ( NV_ROOTDIR . "/includes/footer.php" );

function displayRed($list, $path, $lang_module, $index, $nav) {
	$xtpl = new XTemplate("treat-list.tpl", $path);
	$xtpl->assign("lang", $lang_module);	

	// echo $path; die();
	$stt = $index;
	foreach ($list as $key => $row) {
		$xtpl->assign("stt", $stt);
		$xtpl->assign("id", $row["id"]);
		$xtpl->assign("customer", $row["customer"]);
		$xtpl->assign("petname", $row["petname"]);
		$xtpl->assign("phone", $row["phone"]);
		$xtpl->assign("doctor", $row["doctor"]);
		$xtpl->assign("luubenh", date("d/m/Y", $row["timeluubenh"]));
		$xtpl->assign("nav_link", $nav);
		// $xtpl->assign("delete_link", "");

		$xtpl->parse("main.row");
		$stt ++;
	}

	$xtpl->parse("main");
	return $xtpl->text("main");
}

?>
