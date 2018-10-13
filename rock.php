<?php
	$conn = new mysqli("localhost", "root", "", "petcoffe_2016");
	$conn->set_charset("utf8");
	if(!$conn) die("mysqli");
	$sql = "select * from vng_shops_rows";
	$result = $conn->query($sql);
	$res = "";
	echo $result->num_rows;
	// while($row = $result->fetch_assoc()) {
	// 	$title = $row["vi_title"];
	// 	$alias = $row["vi_alias"];
	// 	$id = $row["id"];
	// 	echo "$alias<br>";
	// 	// $alias = str_replace("-(", "", $alias);
	// 	// $alias = str_replace(")", "", $alias);
	// 	// $alias = str_replace("*", "", $alias);
	// 	// $alias = str_replace(",", "", $alias);
	// 	// $alias = str_replace("+", "", $alias);
	// 	// if($row["code"] != "" && $row["image"] != "") {
	// 	// 	$sql2 = "select * from vng_shops_rows where vi_codesp = " . $row["code"];
	// 	// 	$result2 = $conn->query($sql2);
	// 	// 	if($result2) {
	// 	// 		$row2 = $result2->fetch_assoc();
	// 	// 		$sql3 = "update vng_shops_rows set homeimgfile = '". $row["image"] ."', homeimgthumb = '".$row["image"]."' where vi_codesp = " . $row["code"];
	// 	// 		// if($conn->query($sql3)) 
	// 	// 		// 	echo 1;
				
	// 	// 	}
	// 	// }
	// }
	
?>
