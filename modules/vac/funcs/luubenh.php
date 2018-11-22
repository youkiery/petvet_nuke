<?php

/**
 * @Project NUKEVIET-MUSIC
 * @Author Phan Tan Dung
 * @Copyright (C) 2011
 * @Createdate 26/01/2011 10:26 AM
 */

if (!defined('NV_IS_MOD_VAC')) die('Stop!!!');
$action = $nv_Request->get_string('action', 'post/get', '');
$ret = array("status" => 0, "data" => "");

quagio();

  if (!empty($action)) {
    switch ($action) {
      case 'luulieutrinh':
      $lid = $nv_Request->get_string('id', 'post', '');
      $lieutrinh = $nv_Request->get_string('lieutrinh', 'post', '');
  
      if (!empty($lid)) {
        $sql = "update vng_vac_luubenh set lieutrinh = '$lieutrinh' where id = $lid";
        $ret["data"] = $sql;
  
        if ($db->sql_query($sql)) {
          $sql = "select ngayluubenh, lieutrinh from vng_vac_luubenh where id = $lid";
          $query = $db->sql_query($sql);
          if ($row = $db->sql_fetch_assoc($query)) {
            $lieutrinh = explode("|", $row["lieutrinh"]);
            $arrlieutrinh = array();
            $ngaybatdau = strtotime(date("Y-m-d", $row["ngayluubenh"]));
            $khoangcach = floor(1 + (strtotime(date("Y-m-d")) - $ngaybatdau) / (24 * 60 * 60));
            // var_dump($khoangcach); die();
        
            foreach($lieutrinh as $key => $value) {
              $ngay = date("Y-m-d", ($ngaybatdau + $key * 24 * 60 * 60));
              if ($value !== "") {
                $x = explode(":", $value);
                $tinhtrang = $x[0];
                $ghichu = $x[1];
              }
              else {
                $tinhtrang = "";
              }
              // echo $ngay; die();
              $arrlieutrinh[] = array("ngay" => $ngay, "ghichu" => $ghichu, "tinhtrang" => $tinhtrang);
            }
            $ret["status"] = 1;
            $ret["data"] = json_encode($arrlieutrinh);
          }
        }
      }
      break;
      case 'trihet':
        $lid = $nv_Request->get_string('id', 'post', '');
        $val = $nv_Request->get_string('val', 'post', '');
        
        if (! (empty($lid) || empty($val))) {
          $sql = "update vng_vac_luubenh set ketqua = $val where id = $lid";
          $ret["data"] = $sql;
          if ($db->sql_query($sql)) {
            $ret["status"] = 1;
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

  $status_option = array("Bình thường", "Hơi yếu", "Yếu", "Sắp chết", "Đã chết");
  // var_dump($status_option);

  foreach($status_option as $key => $value) {
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
?>
