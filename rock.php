<?php
$db = new mysqli("localhost", "root", "", "petcoffe_2016");
$db->set_charset("utf8");
if(!$db) die("mysqli");

$sql = "select * from vng_shop_temp";
$query = $db->query($sql);
$customer = $query->fetch_all(MYSQLI_ASSOC);

foreach ($customer as $key => $row) {
	$sql = "INSERT INTO vng_shops_rows (listcatid, color_id, topic_id, group_id, user_id, com_id, shopcat_id, source_id, addtime, edittime, status, publtime, exptime, archive, product_number, product_price, product_discounts, money_unit, product_unit, homeimgfile, homeimgthumb, homeimgalt, otherimage, imgposition, copyright, inhome, allowed_comm, allowed_rating, ratingdetail, allowed_send, allowed_print, allowed_save, hitstotal, hitscm, hitslm, showprice, vi_title, vi_alias, vi_description, vi_keywords, vi_note, vi_hometext, vi_bodytext, vi_address, vi_codesp, vi_warranty,vi_promotional,vi_detailpromotional,vi_maps)  VALUES ('260', ',', '0',  '',  '1', '0',  '0',  '0',  '1539047151',  '1539047151',  '1',  '1539047151',   '0',   '0',   '0', " . intval($row["price"]) . ", '0',  'VND', '1', '" . $row["image"] . "',  '" . $row["image"] . "',  '',  '',  '0',  '0',  '1',  '0',  '1',  '0', '1',  '1',  '1',  '8',  '0',  '0', '1', '" . $row["name"] . "', '" . url($row["image"]) . "', 'Siêu thị bệnh viện thú cưng, 14 Lê Đại Hành', 'n˺', '', '', '" . $row["image"] . "', '', '" . $row["code"] . "', '', '', '', '12.685833, 108.045510')";
	$query = $db->query($sql);
	// var_dump($query);
	// die($sql);
}

function url($string) {
	$string = mb_strtolower($string);
	$string = stripVN($string);
	$string = str_replace(" ", "-", $string);
	return $string;
}

function stripVN($str) {
	$str = preg_replace("/(à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ)/", 'a', $str);
	$str = preg_replace("/(è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ)/", 'e', $str);
	$str = preg_replace("/(ì|í|ị|ỉ|ĩ)/", 'i', $str);
	$str = preg_replace("/(ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ)/", 'o', $str);
	$str = preg_replace("/(ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ)/", 'u', $str);
	$str = preg_replace("/(ỳ|ý|ỵ|ỷ|ỹ)/", 'y', $str);
	$str = preg_replace("/(đ)/", 'd', $str);

	$str = preg_replace("/(À|Á|Ạ|Ả|Ã|Â|Ầ|Ấ|Ậ|Ẩ|Ẫ|Ă|Ằ|Ắ|Ặ|Ẳ|Ẵ)/", 'A', $str);
	$str = preg_replace("/(È|É|Ẹ|Ẻ|Ẽ|Ê|Ề|Ế|Ệ|Ể|Ễ)/", 'E', $str);
	$str = preg_replace("/(Ì|Í|Ị|Ỉ|Ĩ)/", 'I', $str);
	$str = preg_replace("/(Ò|Ó|Ọ|Ỏ|Õ|Ô|Ồ|Ố|Ộ|Ổ|Ỗ|Ơ|Ờ|Ớ|Ợ|Ở|Ỡ)/", 'O', $str);
	$str = preg_replace("/(Ù|Ú|Ụ|Ủ|Ũ|Ư|Ừ|Ứ|Ự|Ử|Ữ)/", 'U', $str);
	$str = preg_replace("/(Ỳ|Ý|Ỵ|Ỷ|Ỹ)/", 'Y', $str);
	$str = preg_replace("/(Đ)/", 'D', $str);
	return $str;
}



// $sql = "select * from vng_vac_customers";
// $query = $db->query($sql);
// $customer = $query->fetch_all(MYSQLI_ASSOC);

// $sql = "select * from vng_vac_doctor";
// $query = $db->query($sql);
// $doctor = $query->fetch_all(MYSQLI_ASSOC);

// $sql = "select * from vng_vac_luubenh";
// $query = $db->query($sql);
// $treat = $query->fetch_all(MYSQLI_ASSOC);

// $sql = "select * from vng_vac_lieutrinh";
// $query = $db->query($sql);
// $treating = $query->fetch_all(MYSQLI_ASSOC);

// $sql = "select * from vng_vac_pets";
// $query = $db->query($sql);
// $pet = $query->fetch_all(MYSQLI_ASSOC);

// $sql = "select * from vng_vac_sieuam";
// $query = $db->query($sql);
// $sieuam = $query->fetch_all(MYSQLI_ASSOC);

// foreach ($pet as $crow) {
// 	$sql = "insert into vng_vaccine_pet (id, name, customerid) values($crow[id], '$crow[petname]', $crow[customerid])";
// 	// $res = $db->query($sql);
// }

// foreach ($sieuam as $crow) {
// 	$sql = "insert into vng_vaccine_usg (id, petid, doctorid, cometime, calltime, image, status, note) values($crow[id], $crow[idthucung], $crow[idbacsi], $crow[ngaysieuam], $crow[ngaydusinh], '$crow[hinhanh]', $crow[trangthai], '$crow[ghichu]')";
// 	// $res = $db->query($sql);
// }

// foreach ($treating as $crow) {
// 	$sql = "insert into vng_vaccine_treating (id, treatid, temperate, eye, other, examine, image, time, treating, status, doctorx) values($crow[id], $crow[idluubenh], '$crow[nhietdo]', '$crow[niemmac]', '$crow[khac]', '$crow[xetnghiem]', '$crow[hinhanh]', $crow[ngay], '$crow[dieutri]', $crow[tinhtrang], $crow[doctorx])";
// 	// $db->query($sql);
// }

// foreach ($treat as $crow) {
// 	$sql = "insert into vng_vaccine_treat (id, petid, doctorid, cometime, insult) values($crow[id], $crow[idthucung], $crow[idbacsi], $crow[ngayluubenh], $crow[ketqua])";
// 	$db->query($sql);
// }

// foreach ($customer as $crow) {
// 	$sql = "insert into vng_vaccine_customer (id, name, phone, address) values($crow[id], '$crow[customer]', '$crow[phone]', '$crow[address]')";
// 	// $db->query($sql);
// }

// foreach ($doctor as $drow) {
// 	$sql = "insert into vng_vaccine_doctor (id, name) values($drow[id], '$drow[doctor]')";
// 	// $db->query($sql);
// }

// $sql = "select * from vng_vac_diseases";
// $query = $db->query($sql);
// $disease = $query->fetch_all(MYSQLI_ASSOC);
// foreach ($disease as $drow) {
// 	//	// DISEASE
// 	$sql = "insert into vng_vaccine_disease (id, name) values($drow[id], '$drow[disease]')";
// 	$db->query($sql);
// 	// // VACCINE
// 	$sql = "select * from vng_vac_$drow[id]";
// 	$query2 = $db->query($sql);
// 	while($row2 = $query2->fetch_assoc()) {
// 		$recall = 0;
// 		if (!empty($row2["recall"])) {
// 			$recall = strtotime($row2["recall"]);
// 		}
// 		$sql = "insert into vng_vaccine_vaccine (petid, diseaseid, cometime,	calltime,	note, status, recall, doctorid) values ($row2[petid], $drow[id], $row2[cometime], $row2[calltime], '$row2[note]', $row2[status], $recall, $row2[doctorid])";
// 		$db->query($sql);
// 	}
// }

