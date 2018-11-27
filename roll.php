<?php
include_once('includes/class/PHPExcel/IOFactory.php');
$fileType = 'Excel2007';
$fileName = 'product_import.xlsx';
$objPHPExcel = PHPExcel_IOFactory::load("product_import.xlsx");
$array_data = array(
					0 => array('name' => 'Hieu', 'email' => 'hieu@gmail.com', 'phone' => '0123456789', 'address' => 'address 1'),
					1 => array('name' => 'Nam', 'email' => 'nam@gmail.com', 'phone' => '0124567892', 'address' => 'address 2'),
					2 => array('name' => 'Tuan', 'email' => 'tuan@gmail.com', 'phone' => '09764346789', 'address' => 'address 3'),
					3 => array('name' => 'Mai', 'email' => 'mai@gmail.com', 'phone' => '09876543356', 'address' => 'address 4'),
					4 => array('name' => 'Thao', 'email' => 'thao@gmail.com', 'phone' => '0975458979', 'address' => 'address 5'),
				);
$objPHPExcel->setActiveSheetIndex(0)
                            ->setCellValue('A1', "STT")
                            ->setCellValue('B1', "Name")
                            ->setCellValue('C1', "Email")
                            ->setCellValue('D1', "Phone")
                            ->setCellValue('E1', "Address");

$i = 2;
foreach ($array_data as $value) {
	$objPHPExcel->setActiveSheetIndex(0)
								->setCellValue("A$i", "$i")
								->setCellValue("B$i", $value['name'])
	                            ->setCellValue("C$i", $value['email'])
	                            ->setCellValue("D$i", $value['phone'])
	                            ->setCellValue("E$i", $value['address']);
	$i++;
}
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, $fileType);
$objWriter->save($fileName);
$file_url = '/product_import.xlsx';
header("location: " . $file_url);
?>
