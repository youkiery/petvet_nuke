<?php

/**
 * @Project TXManager
 * @Author Youkiery (youkiery@gmail.com)
 * @copyright 2018
 * @createdate 01/11/2018 08:00 AM
 */

if (!defined('NV_IS_MOD_VAC'))
  die('Stop!!!');

$action = $nv_Request->get_string('action', 'post', '');
$ret = array("status" => 0, "data" => array());
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

      if (! (empty($ltid) || $xetnghiem < 0 || $tinhtrang < 0)) {
        $sql = "update vng_vac_lieutrinh set nhietdo = '$nhietdo', niemmac = '$niemmac', khac = '$khac', xetnghiem = '$xetnghiem', dieutri = '$dieutri', tinhtrang = $tinhtrang where id = $ltid";
        // $ret["data"] = $sql;

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
    case 'thongtinluubenh':
      $lid = $nv_Request->get_string('id', 'post', '');
      if (!(empty($lid))) {
        $sql = "SELECT a.id, a.ngayluubenh, a.ketqua, b.id, c.customer, c.phone, c.address, b.petname, d.doctor from " . VAC_PREFIX . "_luubenh a inner join " . VAC_PREFIX . "_pets b on a.id = $lid and a.idthucung = b.id inner join " . VAC_PREFIX .  "_customers c on c.id = b.customerid and (c.customer like '%$key%' or c.phone like '%$key%' or b.petname like '%$key%') inner join " . VAC_PREFIX . "_doctor d on a.idbacsi = d.id order by ngayluubenh";
        $query = $db->sql_query($sql);
        if ($row = $db->sql_fetch_assoc($query)) {
          $row["ngayluubenh"] = date("d/m/Y", $row["ngayluubenh"]);
          $sql = "SELECT * from " . VAC_PREFIX . "_lieutrinh where idluubenh = $lid";
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
      if (! (empty($lid) || empty($ngay))) {
        $i_ngay = strtotime($ngay);
        $sql = "select * from `" . VAC_PREFIX . "_lieutrinh` where idluubenh = $lid and ngay = " . $i_ngay;
        // $ret["data"] = $sql;
        $query = $db->sql_query($sql);
        
        if (!$db->sql_numrows($query)) {
          // echo 1;
          $sql = "insert into `" . VAC_PREFIX . "_lieutrinh` (idluubenh, nhietdo, niemmac, khac, xetnghiem, hinhanh, ngay, dieutri, tinhtrang) values($lid, '', '', '', 0, '', " . $i_ngay . ", '', 0)";
          // $ret["data"] = $sql;
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
}
echo json_encode($ret);
die();
