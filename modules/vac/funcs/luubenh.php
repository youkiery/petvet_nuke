<?php

/**
 * @Project NUKEVIET-MUSIC
 * @Author Phan Tan Dung
 * @Copyright (C) 2011
 * @Createdate 26/01/2011 10:26 AM
 */
if (!defined('NV_IS_MOD_VAC'))
  die('Stop!!!');
$action = $nv_Request->get_string('action', 'post/get', '');
$ret = array("status" => 0, "data" => "");

quagio();
$status_option = array("Bình thường", "Hơi yếu", "Yếu", "Sắp chết", "Đã chết");
$export = array("Lưu bệnh", "Đã điều trị", "Đã chết");

if (!empty($action)) {
  switch ($action) {
    case 'luulieutrinh':
    $ltid = $nv_Request->get_string('id', 'post', '');
    $nhietdo = $nv_Request->get_string('nhietdo', 'post', '');
    $niemmac = $nv_Request->get_string('niemmac', 'post', '');
    $khac = $nv_Request->get_string('khac', 'post', '');
    $xetnghiem = $nv_Request->get_string('xetnghiem', 'post', '');
    $dieutri = $nv_Request->get_string('dieutri', 'post', '');
    $tinhtrang = $nv_Request->get_string('tinhtrang', 'post', '');
    $doctorx = $nv_Request->get_string('doctorx', 'post', '');
    $ret["step"] = 1;

      if (! (empty($ltid) || $xetnghiem < 0 || $tinhtrang < 0) && $doctorx >= 0) {
        $sql = "update vng_vac_lieutrinh set nhietdo = '$nhietdo', niemmac = '$niemmac', khac = '$khac', xetnghiem = '$xetnghiem', dieutri = '$dieutri', tinhtrang = $tinhtrang, doctorx = $doctorx where id = $ltid";
        $ret["sql"] = $sql;

        if ($db->sql_query($sql)) {
          $sql = "select * from `" . VAC_PREFIX . "_luubenh` a inner join `" . VAC_PREFIX . "_lieutrinh` b on b.id = $ltid and a.id = b.idluubenh";
            $query = $db->sql_query($sql);
            if ($row = $db->sql_fetch_assoc($query)) {
              $ret["status"] = 1;
              $ret["data"]["color"] = mauluubenh($row["ketqua"], $row["tinhtrang"]);
              $ret["data"]["tinhtrang"] = $status_option[$row["tinhtrang"]];
            }

          // $sql = "select ngayluubenh, lieutrinh from vng_vac_luubenh where id = $lid";
          // $query = $db->sql_query($sql);
          // if ($row = $db->sql_fetch_assoc($query)) {
          //   $lieutrinh = explode("|", $row["lieutrinh"]);
          //   $arrlieutrinh = array();
          //   $ngaybatdau = strtotime(date("Y-m-d", $row["ngayluubenh"]));
          //   $khoangcach = floor(1 + (strtotime(date("Y-m-d")) - $ngaybatdau) / (24 * 60 * 60));
          //   // var_dump($khoangcach); die();

          //   foreach ($lieutrinh as $key => $value) {
          //     $ngay = date("Y-m-d", ($ngaybatdau + $key * 24 * 60 * 60));
          //     if ($value !== "") {
          //       $x = explode(":", $value);
          //       $tinhtrang = $x[0];
          //       $ghichu = $x[1];
          //     } else {
          //       $tinhtrang = "";
          //     }
          //     // echo $ngay; die();
          //     $arrlieutrinh[] = array("ngay" => $ngay, "ghichu" => $ghichu, "tinhtrang" => $tinhtrang);
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
        $sql = "update vng_vac_luubenh set ketqua = $val where id = $lid";
        // $ret["data"] = $sql;
        if ($db->sql_query($sql)) {
          $sql = "select * from `" . VAC_PREFIX . "_luubenh` where id = $lid";
          // $ret["data"] = $sql;
          $query = $db->sql_query($sql);
          if ($row = $db->sql_fetch_assoc($query)) {
            $ret["status"] = 1;
            $ret["data"]["color"] = mauluubenh($row["ketqua"], $row["tinhtrang"]);
            $ret["data"]["ketqua"] = $export[$row["ketqua"]];
          }
        }
      }
      break;
    case 'delete_treat':
      $id = $nv_Request->get_string('id', 'post', '');
      if (!(empty($id))) {
        $sql = "delete from vng_vac_luubenh where id = $id";
        if ($db->sql_query($sql)) {
          $ret["status"] = 1;
        }
      }
      break;
    case 'thongtinluubenh':
      $lid = $nv_Request->get_string('id', 'post', '');
      if (!(empty($lid))) {
        $sql = "SELECT a.id, a.ngayluubenh, a.ketqua, b.id, c.customer, c.phone, c.address, b.petname, d.doctor from " . VAC_PREFIX . "_luubenh a inner join " . VAC_PREFIX . "_pets b on a.id = $lid and a.idthucung = b.id inner join " . VAC_PREFIX .  "_customers c on c.id = b.customerid and (c.customer like '%$key%' or c.phone like '%$key%' or b.petname like '%$key%') inner join " . VAC_PREFIX . "_doctor d on a.idbacsi = d.id order by ngayluubenh";
        $query = $db->sql_query($sql);
        if ($row = $db->sql_fetch_assoc($query)) {
          $row["ngayluubenh"] = date("d/m/Y", $row["ngayluubenh"]);
          $sql = "SELECT * from " . VAC_PREFIX . "_lieutrinh where idluubenh = $lid order by ngay";
          $query = $db->sql_query($sql);
          $lieutrinh = fetchall($db, $query);
          if ($lieutrinh) {
            foreach ($lieutrinh as $key => $value) {
              $lieutrinh[$key]["ngay"] = date("d/m", $value["ngay"]);
            }
            $row["lieutrinh"] = $lieutrinh;
          }
          $ret["status"] = 1;
          $ret["data"] = $row;
        }
      }
    break;
    case 'themlieutrinh':
      $lid = $nv_Request->get_string('id', 'post', '');
      $ngay = $nv_Request->get_string('ngay', 'post', '');
      $ret["step"] = 1;
      if (! (empty($lid) || empty($ngay))) {
        $i_ngay = strtotime($ngay);
        $sql = "select * from `" . VAC_PREFIX . "_lieutrinh` where idluubenh = $lid and ngay = " . $i_ngay;
        // $ret["data"] = $sql;
        $query = $db->sql_query($sql);
        
        $ret["sql"] = $sql;
        if (!$db->sql_numrows($query)) {
          // echo 1;
          $sql = "insert into `" . VAC_PREFIX . "_lieutrinh` (idluubenh, nhietdo, niemmac, khac, xetnghiem, hinhanh, ngay, dieutri, tinhtrang) values($lid, '', '', '', 0, '', " . $i_ngay . ", '', 0)";
          // $ret["data"] = $sql;
          $ret["sql"] = $sql;
          if ($id = $db->sql_query_insert_id($sql)) {
            $ret["status"] = 1;
            $ret["data"]["id"] = $id;
            $ret["data"]["ngay"] = date_format(date_create($ngay), "d/m");
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

$sql = "select * from vng_vac_doctor";
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
		$xtpl->assign("luubenh", date("d/m/Y", $row["ngayluubenh"]));
		$xtpl->assign("nav_link", $nav);
		// $xtpl->assign("delete_link", "");

		$xtpl->parse("main.row");
		$stt ++;
	}

	$xtpl->parse("main");
	return $xtpl->text("main");
}

?>
