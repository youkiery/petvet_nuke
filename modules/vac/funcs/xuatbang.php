<?php
  if (!defined('NV_IS_MOD_VAC')) die('Stop!!!');

// http://localhost/index.php/vac/xuatbang.html
  $action = $nv_Request->get_string('action', 'get', '');

  include_once('includes/class/PHPExcel/IOFactory.php');
  $fileType = 'Excel2007';
  $objPHPExcel = PHPExcel_IOFactory::load('blank.xlsx');

  switch ($action) {
    case 1:
      // var_dump(getall("vng_vac_diseases"));
      putintoe(getall("vng_vac_diseases"));
      $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, $fileType);
      $file_path = "output/vng_vac_benh.xlsx";
      $file_url = "http://" . $global_config["my_domains"][0] . "/" . $file_path;
      $objWriter->save($file_path);
      header("location: $file_url");
    break;
    case 2:
    $objPHPExcel = PHPExcel_IOFactory::load('blank.xlsx');
      putintoe(getall("vng_vac_1"));
      $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, $fileType);
      $file_path = "output/vng_vac_benh_1.xlsx";
      $file_url = "http://" . $global_config["my_domains"][0] . "/" . $file_path;
      $objWriter->save($file_path);
      // $my_head = '<meta http-equiv="refresh" content="0;url=" />';
      header("location: $file_url");
    break;
    case 3:
      $objPHPExcel = PHPExcel_IOFactory::load('blank.xlsx');
      putintoe(getall("vng_vac_2"));
      $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, $fileType);
      $file_path = "output/vng_vac_benh_2.xlsx";
      $file_url = "http://" . $global_config["my_domains"][0] . "/" . $file_path;
      $objWriter->save($file_path);
      header("location: $file_url");
    break;
    case 4:    
      $objPHPExcel = PHPExcel_IOFactory::load('blank.xlsx');
      putintoe(getall("vng_vac_3"));
      $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, $fileType);
      $file_path = "output/vng_vac_benh_3.xlsx";
      $file_url = "http://" . $global_config["my_domains"][0] . "/" . $file_path;
      $objWriter->save($file_path);
      header("location: $file_url");
    break;
    case 5:
      $objPHPExcel = PHPExcel_IOFactory::load('blank.xlsx');
      putintoe(getall("vng_vac_4"));
      $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, $fileType);
      $file_path = "output/vng_vac_benh_4.xlsx";
      $file_url = "http://" . $global_config["my_domains"][0] . "/" . $file_path;
      $objWriter->save($file_path);
      header("location: $file_url");
    break;
    case 6:
      $objPHPExcel = PHPExcel_IOFactory::load('blank.xlsx');
      putintoe(getall("vng_vac_customers"));
      $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, $fileType);
      $file_path = "output/vng_vac_khachhang.xlsx";
      $file_url = "http://" . $global_config["my_domains"][0] . "/" . $file_path;
      $objWriter->save($file_path);
      header("location: $file_url");
    break;
    case 7:    
      // $objPHPExcel = PHPExcel_IOFactory::load('blank.xlsx');
      // putintoe(getall("vng_vac_lieutrinh");
      // $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, $fileType);
      // $file_path = "output/vng_vac_lieutrinh.xlsx";
      // $file_url = "http://" . $global_config["my_domains"][0] . "/" . $file_path;
      // $objWriter->save($file_path);
      // header("location: $file_url");
    break;
    case 8:    
    // $objPHPExcel = PHPExcel_IOFactory::load('blank.xlsx');
    // putintoe(getall("vng_vac_luubenh");
    // $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, $fileType);
    // $file_path = "output/vng_vac_luubenh.xlsx";
    // $file_url = "http://" . $global_config["my_domains"][0] . "/" . $file_path;
    // $objWriter->save($file_path);
    // header("location: $file_url");
    break;
    case 9:    
    // $objPHPExcel = PHPExcel_IOFactory::load('blank.xlsx');
    // putintoe(getall("vng_vac_sieuam");
    // $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, $fileType);
    // $file_path = "output/vng_vac_sieuam.xlsx";
    // $file_url = "http://" . $global_config["my_domains"][0] . "/" . $file_path;
    // $objWriter->save($file_path);
    // header("location: $file_url");
    break;
    case 10:
    // $objPHPExcel = PHPExcel_IOFactory::load('blank.xlsx');
    // putintoe(getall("vng_vac_pets");
    // $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, $fileType);
    // $file_path = "output/vng_vac_thucung.xlsx";
    // $file_url = "http://" . $global_config["my_domains"][0] . "/" . $file_path;
    // $objWriter->save($file_path);
    // header("location: $file_url");
    break;
    case 11:
    //   putintoe(getall("vng_vac_doctor"));
    //   $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, $fileType);
    //   $file_path = "output/vng_vac_bacsi.xlsx";
    //   $file_url = "http://" . $global_config["my_domains"][0] . "/" . $file_path;
    //   $objWriter->save($file_path);      
    //   header("location: $file_url");
    break;
    default:
      $xtpl = new XTemplate("xuatbang.tpl", NV_ROOTDIR . "/themes/" . $module_info['template'] . "/modules/" . $module_file);

      $xtpl->parse("main");
      $contents = $xtpl->text("main");
  
      include ( NV_ROOTDIR . "/includes/header.php" );
      echo nv_site_theme($contents);
      include ( NV_ROOTDIR . "/includes/footer.php" );  
}



function getall($table) {
  global $db;
  $sql = "SELECT * from $table";
  // echo $sql;
  // die();
  $query = $db->sql_query($sql);
  // var_dump($query);
  $res = array();
  while ($row = $db->sql_fetch_assoc($query)) {
    $res[] = $row;
  }
  return $res;
}
function putintoe($data) {
  global $objPHPExcel;
  $row = $data[0];
  
  $ag = array("A", "B", "C", "D", "E", "F", "G", "H", "I", "J", "K", "L", "M", "N", "P", "Q", "R", "S", "T", "U", "V", "W", "X", "Y", "Z");
  $index = 0;
  foreach ($row as $key => $value) {
    // echo $ag[$index] . "1 ";
    // echo $index;
    // echo "<br>";

    $objPHPExcel->setActiveSheetIndex(0)->setCellValue($ag[$index] . "1", $key);
    $index ++;
  }

  $i = 2;
  foreach ($data as $value) {
    $index = 0;
    // var_dump($value); die();
    foreach ($value as $value2) {
      $objPHPExcel->setActiveSheetIndex(0)->setCellValue("$ag[$index]$i", $value2);
      $index++;
    }
    // die();
    $i++;
  }
  // die();
}
?>
