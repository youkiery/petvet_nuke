<?php
	$db = mysqli_connect("localhost", "root", "", "petcoffe_2016");
	$db->query("set names utf8");
	echo 1;
	// $sql = "select * from vng_vac_diseases";
	// $res = $db->query($sql);
	// $diss = mysqli_fetch_all($res, MYSQLI_ASSOC);
	// $sql = "select * from vng_vac_customers";
	// $res = $db->query($sql);
	// $custom = mysqli_fetch_all($res, MYSQLI_ASSOC);
	// $customer = array();
	// $pet = array();
	// $disease = array();
	// foreach ($custom as $key => $value) {
	// 	$customer[$value["id"]] = $value["phone"];
	// }
	// $sql = "select * from temp";
	// $res = $db->query($sql);
	// $num = mysqli_num_rows($res);
	// echo "$num<br>";
	// $phone = array();
	// while($row = $res->fetch_assoc()) {
	// 	$dis = mb_strtolower($row["dis"]);
	// 	$disid = 0;
	// 	foreach ($diss as $key => $value) {
	// 		if(strpos($dis, $value["disease"])) {
	// 			$disid = $key;
	// 			break;
	// 		}
	// 	}
	// 	$customerid = array_search($row["phone"], $customer);
	// 	$pet[$customerid] = "noname";
	// 	$disease[$disid][] = ["petid" => count($pet), "calltime" => $row["time"]];
	// }
	// foreach ($pet as $key => $value) {
	// 		$sql = "insert into vng_vac_pets (petname, customerid) values ('Chưa đề tên', $key)";
	// 		if($db->query($sql)) $r = 1;
	// 		else $r = 0;
	// 		echo $sql . "($r)<br>";
	// }
	// $now = time();
	// foreach ($disease as $key => $value) {
	// 	$key ++;
	// 	foreach ($value as $key2 => $value2) {
	// 		// $time = strtotime($value2["calltime"]);
	// 		$time = str_replace("/", "-", $value2["calltime"]);
	// 		$time = str_replace("--", "-", $time);
	// 		$date_length = strlen($time);
	// 		$date = substr($time, 0, 2);
	// 		$month = substr($time, 3, 2);
	// 		if(strpos($month, "-")) {
	// 			$month = 0 . str_replace("-", "", $month);
	// 		}
	// 		if ($date_length < 9) {
	// 			$year = 20 . substr($time, -2);
	// 		} else {
	// 			$year = substr($time, -4);
	// 		}

	// 		// $time = date("Y-m-d", $time);
	// 		$confirm = 2;
	// 		$cometime = strtotime("2016-01-01");
	// 		$calltime = strtotime("$year-$month-$date");
	// 		if(empty($calltime)) $calltime = $cometime;
	// 		if($now < $calltime) $confirm = 0;
				
	// 		$sql = "insert into vng_vac_$key (petid, cometime, calltime, status, note) values ($value2[petid], $cometime, $calltime, $confirm, '')";
	// 		echo $sql . "<br>";
	// 		$db->query($sql);
	// 	}
	// }
?>
