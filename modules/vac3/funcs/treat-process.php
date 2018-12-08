<?php

/**
 * @Project TXManager
 * @Author Youkiery (youkiery@gmail.com)
 * @copyright 2018
 * @createdate 01/11/2018 08:00 AM
 */

if (!defined('NV_IS_MOD_VAC')) {
  die('Stop!!!');
}
$action = $nv_Request->get_string('action', 'post', '');
$ret = array("status" => 0, "data" => array());

if (!empty($action)) {
  switch ($action) {
    case 'themluubenh':
    $petid = $nv_Request->get_string('petid', 'post/get', '');
    $calltime = $nv_Request->get_string('calltime', 'post', '');
    $status = $nv_Request->get_string('status', 'post', '');
    $doctorid = $nv_Request->get_string('doctorid', 'post', '');
    $note = $nv_Request->get_string('note', 'post', '');
    $customer = $nv_Request->get_string('customer', 'post', '');
    $phone = $nv_Request->get_string('phone', 'post', '');
    $address = $nv_Request->get_string('address', 'post', '');
    $ret = array("status" => 0, "data" => "");
    // var_dump(strlen($status) > 0);
    if ( ! ( empty($petid) || empty($doctorid) || empty($calltime) || strlen($status) == 0) ) {
      $sql = "select id from `" . $db_config['prefix'] . "_" . $module_data . "_pets` where id = $petid";
      $result = $db->sql_query($sql);
      // $ret["data"] .= $sql;
    
      if ($db->sql_numrows($result)) {
        $sql = "INSERT INTO `" . $db_config['prefix'] . "_" . $module_data . "_luubenh` (`petid`, `doctorid`, `calltime`, `insult`) VALUES ($petid, $doctorid, ". strtotime($calltime) . ", 1)";
        // $ret["data"] .= $sql;
        $insert_id = $db->sql_query_insert_id($sql);
    
        // if ($sql) {
        if ($insert_id) {
          if (!empty($phone)) {
            $sql = "update `" . VAC_PREFIX . "_customers` set customer = '$customer', address = '$address' where phone = '$phone'";
            $db->sql_query($sql);
          }
          $ret["status"] = 1;
          $ret["data"] .= $lang_module["themsatc"];
        }
      }
    }
    break;
    case 'luulieutrinh':
    $ltid = $nv_Request->get_string('id', 'post', '');
    $temperate = $nv_Request->get_string('temperate', 'post', '');
    $eye = $nv_Request->get_string('niemmac', 'post', '');
    $other = $nv_Request->get_string('other', 'post', '');
    $examine = $nv_Request->get_string('examine', 'post', '');
    $treating = $nv_Request->get_string('treating', 'post', '');
    $status = $nv_Request->get_string('status', 'post', '');
    $doctorx = $nv_Request->get_string('doctorx', 'post', '');
    $ret["step"] = 1;

      if (! (empty($ltid) || $examine < 0 || $status < 0) && $doctorx >= 0) {
        $sql = "update vng_vac_lieutrinh set temperate = '$temperate', niemmac = '$niemmac', other = '$other', examine = '$examine', treating = '$treating', status = $status, doctorx = $doctorx where id = $ltid";
        $ret["sql"] = $sql;

        if ($db->sql_query($sql)) {
          $sql = "select * from `" . VAC_PREFIX . "_luubenh` a inner join `" . VAC_PREFIX . "_lieutrinh` b on b.id = $ltid and a.id = b.idluubenh";
            $query = $db->sql_query($sql);
            if ($row = $db->sql_fetch_assoc($query)) {
              $ret["status"] = 1;
              $ret["data"]["color"] = mauluubenh($row["ketqua"], $row["status"]);
              $ret["data"]["status"] = $status_option[$row["status"]];
            }

          // $sql = "select calltime, lieutrinh from vng_vac_luubenh where id = $lid";
          // $query = $db->sql_query($sql);
          // if ($row = $db->sql_fetch_assoc($query)) {
          //   $lieutrinh = explode("|", $row["lieutrinh"]);
          //   $arrlieutrinh = array();
          //   $ngaybatdau = strtotime(date("Y-m-d", $row["calltime"]));
          //   $khoangcach = floor(1 + (strtotime(date("Y-m-d")) - $ngaybatdau) / (24 * 60 * 60));
          //   // var_dump($khoangcach); die();

          //   foreach ($lieutrinh as $key => $value) {
          //     $ngay = date("Y-m-d", ($ngaybatdau + $key * 24 * 60 * 60));
          //     if ($value !== "") {
          //       $x = explode(":", $value);
          //       $status = $x[0];
          //       $note = $x[1];
          //     } else {
          //       $status = "";
          //     }
          //     // echo $ngay; die();
          //     $arrlieutrinh[] = array("ngay" => $ngay, "note" => $note, "status" => $status);
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
            $ret["data"]["color"] = mauluubenh($row["ketqua"], $row["status"]);
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
        $sql = "SELECT a.id, a.calltime, a.ketqua, b.id, c.customer, c.phone, c.address, b.petname, d.doctor from " . VAC_PREFIX . "_luubenh a inner join " . VAC_PREFIX . "_pets b on a.id = $lid and a.petidcung = b.id inner join " . VAC_PREFIX .  "_customers c on c.id = b.customerid and (c.customer like '%$key%' or c.phone like '%$key%' or b.petname like '%$key%') inner join " . VAC_PREFIX . "_doctor d on a.doctorid = d.id order by calltime";
        $query = $db->sql_query($sql);
        if ($row = $db->sql_fetch_assoc($query)) {
          $row["calltime"] = date("d/m/Y", $row["calltime"]);
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
          $sql = "insert into `" . VAC_PREFIX . "_lieutrinh` (idluubenh, temperate, niemmac, other, examine, hinhanh, ngay, treating, status) values($lid, '', '', '', 0, '', " . $i_ngay . ", '', 0)";
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

}
echo json_encode($ret);
die();
