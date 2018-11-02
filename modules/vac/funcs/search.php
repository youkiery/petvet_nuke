<?php
	$key = $nv_Request->get_string('key', 'get', '');

		$xtpl = new XTemplate("list-1.tpl", NV_ROOTDIR . "/themes/" . $module_info['template'] . "/modules/" . $module_file);
		$xtpl->assign("lang", $lang_module);

		$diseases = getDiseaseList();

		foreach ($diseases as $disease) {
			$xtpl->assign("title", $disease["disease"]);
			$vacs = getvaccustomer($key, NV_CURRENTTIME, $global_config["filter_time"], $global_config["sort_type"], $disease["id"]);
			$i = 1;

			foreach ($vacs as $row) {
				$xtpl->assign("id", $row["id"]);
				$xtpl->assign("index", $i);
				$xtpl->assign("petname", $row["petname"]);
				$xtpl->assign("customer", $row["customer"]);
				$xtpl->assign("phone", $row["phone"]);
				$xtpl->assign("confirm", $lang_module["confirm_" . $row["status"]]);
				if($row["status"] == 2 && !$row["recall"]) $xtpl->parse("disease.vac_body.recall_link");
				switch ($row["status"]) {
					case '1':
						$xtpl->assign("color", "orange");
						break;
					case '2':
						$xtpl->assign("color", "green");
						break;
					default:
						$xtpl->assign("color", "red");
						break;
				}
				$xtpl->assign("cometime", date("d/m/Y", $row["cometime"]));
				$xtpl->assign("calltime", date("d/m/Y", $row["calltime"]));
				$i++;
				$xtpl->parse("disease.vac_body");
			}
			$xtpl->parse("disease");
		}
		echo $xtpl->text("disease");

	die();
?>
