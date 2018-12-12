<?php
$db = new mysqli("localhost", "root", "", "petcoffe_2016");
$db->set_charset("utf8");
if(!$db) die("mysqli");

$sql = "select * from vng_vac_customers";
$query = $db->query($sql);
$customer = $query->fetch_all(MYSQLI_ASSOC);

$sql = "select * from vng_vac_doctor";
$query = $db->query($sql);
$doctor = $query->fetch_all(MYSQLI_ASSOC);

$sql = "select * from vng_vac_luubenh";
$query = $db->query($sql);
$treat = $query->fetch_all(MYSQLI_ASSOC);

$sql = "select * from vng_vac_lieutrinh";
$query = $db->query($sql);
$treating = $query->fetch_all(MYSQLI_ASSOC);

$sql = "select * from vng_vac_pets";
$query = $db->query($sql);
$pet = $query->fetch_all(MYSQLI_ASSOC);

$sql = "select * from vng_vac_sieuam";
$query = $db->query($sql);
$sieuam = $query->fetch_all(MYSQLI_ASSOC);

foreach ($pet as $crow) {
	$sql = "insert into vng_vaccine_pet (id, name, customerid) values($crow[id], '$crow[petname]', $crow[customerid])";
	// $res = $db->query($sql);
}

foreach ($sieuam as $crow) {
	$sql = "insert into vng_vaccine_usg (id, petid, doctorid, cometime, calltime, image, status, note) values($crow[id], $crow[idthucung], $crow[idbacsi], $crow[ngaysieuam], $crow[ngaydusinh], '$crow[hinhanh]', $crow[trangthai], '$crow[ghichu]')";
	// $res = $db->query($sql);
}

foreach ($treating as $crow) {
	$sql = "insert into vng_vaccine_treating (id, treatid, temperate, eye, other, examine, image, time, treating, status, doctorx) values($crow[id], $crow[idluubenh], '$crow[nhietdo]', '$crow[niemmac]', '$crow[khac]', '$crow[xetnghiem]', '$crow[hinhanh]', $crow[ngay], '$crow[dieutri]', $crow[tinhtrang], $crow[doctorx])";
	// $db->query($sql);
}

foreach ($treat as $crow) {
	$sql = "insert into vng_vaccine_treat (id, petid, doctorid, cometime, insult) values($crow[id], $crow[idthucung], $crow[idbacsi], $crow[ngayluubenh], $crow[ketqua])";
	$db->query($sql);
}

foreach ($customer as $crow) {
	$sql = "insert into vng_vaccine_customer (id, name, phone, address) values($crow[id], '$crow[customer]', '$crow[phone]', '$crow[address]')";
	// $db->query($sql);
}

foreach ($doctor as $drow) {
	$sql = "insert into vng_vaccine_doctor (id, name) values($drow[id], '$drow[doctor]')";
	// $db->query($sql);
}

$sql = "select * from vng_vac_diseases";
$query = $db->query($sql);
$disease = $query->fetch_all(MYSQLI_ASSOC);
foreach ($disease as $drow) {
	//	// DISEASE
	$sql = "insert into vng_vaccine_disease (id, name) values($drow[id], '$drow[disease]')";
	$db->query($sql);
	// // VACCINE
	$sql = "select * from vng_vac_$drow[id]";
	$query2 = $db->query($sql);
	while($row2 = $query2->fetch_assoc()) {
		$recall = 0;
		if (!empty($row2["recall"])) {
			$recall = strtotime($row2["recall"]);
		}
		$sql = "insert into vng_vaccine_vaccine (petid, diseaseid, cometime,	calltime,	note, status, recall, doctorid) values ($row2[petid], $drow[id], $row2[cometime], $row2[calltime], '$row2[note]', $row2[status], $recall, $row2[doctorid])";
		$db->query($sql);
	}
}

