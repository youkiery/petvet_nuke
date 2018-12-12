<?php
  if (!defined('NV_IS_MOD_VAC')) die('Stop!!!');

// http://localhost/index.php/vac/xuatbang.html

  include_once('includes/class/PHPExcel/IOFactory.php');
  $fileType = 'Excel2007';
  
  $objPHPExcel = PHPExcel_IOFactory::load('blank.xlsx');
  putintoe(getall("" . VAC_PREFIX . "_diseases"));
  $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, $fileType);
  $file_path = "output/" . VAC_PREFIX . "_benh.xlsx";
  $file_url = "http://" . $global_config["my_domains"][0] . "/" . $file_path;
  $objWriter->save($file_path);

  $objPHPExcel = PHPExcel_IOFactory::load('blank.xlsx');
  putintoe(getall("" . VAC_PREFIX . "_1"));
  $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, $fileType);
  $file_path = "output/" . VAC_PREFIX . "_benh_1.xlsx";
  $file_url = "http://" . $global_config["my_domains"][0] . "/" . $file_path;
  $objWriter->save($file_path);
  
  $objPHPExcel = PHPExcel_IOFactory::load('blank.xlsx');
  putintoe(getall("" . VAC_PREFIX . "_2"));
  $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, $fileType);
  $file_path = "output/" . VAC_PREFIX . "_benh_2.xlsx";
  $file_url = "http://" . $global_config["my_domains"][0] . "/" . $file_path;
  $objWriter->save($file_path);

  $objPHPExcel = PHPExcel_IOFactory::load('blank.xlsx');
  putintoe(getall("" . VAC_PREFIX . "_3"));
  $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, $fileType);
  $file_path = "output/" . VAC_PREFIX . "_benh_3.xlsx";
  $file_url = "http://" . $global_config["my_domains"][0] . "/" . $file_path;
  $objWriter->save($file_path);

  $objPHPExcel = PHPExcel_IOFactory::load('blank.xlsx');
  putintoe(getall("" . VAC_PREFIX . "_4"));
  $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, $fileType);
  $file_path = "output/" . VAC_PREFIX . "_benh_4.xlsx";
  $file_url = "http://" . $global_config["my_domains"][0] . "/" . $file_path;
  $objWriter->save($file_path);

  $objPHPExcel = PHPExcel_IOFactory::load('blank.xlsx');
  putintoe(getall("" . VAC_PREFIX . "_customers"));
  $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, $fileType);
  $file_path = "output/" . VAC_PREFIX . "_khachhang.xlsx";
  $file_url = "http://" . $global_config["my_domains"][0] . "/" . $file_path;
  $objWriter->save($file_path);

  $objPHPExcel = PHPExcel_IOFactory::load('blank.xlsx');
  putintoe(getall("" . VAC_PREFIX . "_lieutrinh"));
  $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, $fileType);
  $file_path = "output/" . VAC_PREFIX . "_lieutrinh.xlsx";
  $file_url = "http://" . $global_config["my_domains"][0] . "/" . $file_path;
  $objWriter->save($file_path);

  $objPHPExcel = PHPExcel_IOFactory::load('blank.xlsx');
  putintoe(getall("" . VAC_PREFIX . "_luubenh"));
  $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, $fileType);
  $file_path = "output/" . VAC_PREFIX . "_luubenh.xlsx";
  $file_url = "http://" . $global_config["my_domains"][0] . "/" . $file_path;
  $objWriter->save($file_path);

  $objPHPExcel = PHPExcel_IOFactory::load('blank.xlsx');
  putintoe(getall("" . VAC_PREFIX . "_sieuam"));
  $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, $fileType);
  $file_path = "output/" . VAC_PREFIX . "_sieuam.xlsx";
  $file_url = "http://" . $global_config["my_domains"][0] . "/" . $file_path;
  $objWriter->save($file_path);

  $objPHPExcel = PHPExcel_IOFactory::load('blank.xlsx');
  putintoe(getall("" . VAC_PREFIX . "_pets"));
  $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, $fileType);
  $file_path = "output/" . VAC_PREFIX . "_thucung.xlsx";
  $file_url = "http://" . $global_config["my_domains"][0] . "/" . $file_path;
  $objWriter->save($file_path);

  $objPHPExcel = PHPExcel_IOFactory::load('blank.xlsx');
  putintoe(getall("" . VAC_PREFIX . "_doctor"));
  $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, $fileType);
  $file_path = "output/" . VAC_PREFIX . "_bacsi.xlsx";
  $file_url = "http://" . $global_config["my_domains"][0] . "/" . $file_path;
  $objWriter->save($file_path);      

  $zip = new ZipArchive();
  $filename = "output/petcoffe-" . date("d-m-y") . ".zip";
  $all_file = array("" . VAC_PREFIX . "_bacsi.xlsx", "" . VAC_PREFIX . "_benh.xlsx", "" . VAC_PREFIX . "_benh_1.xlsx", "" . VAC_PREFIX . "_benh_2.xlsx", "" . VAC_PREFIX . "_benh_3.xlsx", "" . VAC_PREFIX . "_benh_4.xlsx", "" . VAC_PREFIX . "_khachhang.xlsx", "" . VAC_PREFIX . "_lieutrinh.xlsx", "" . VAC_PREFIX . "_luubenh.xlsx", "" . VAC_PREFIX . "_sieuam.xlsx", "" . VAC_PREFIX . "_thucung.xlsx");

  if ($zip->open($filename, ZipArchive::CREATE)!==TRUE) {
    exit("cannot open <$filename>\n");
  }

  foreach ($all_file as $value) {
    $zip->addFile("output/" . $value);
  }

  $zip->close();
  header("location: /$filename");

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
