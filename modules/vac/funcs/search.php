<?php
	$key = $nv_Request->get_string('key', 'get', '');
	$fromtime = $nv_Request->get_string('fromtime', 'get', '');
	$time_amount = $nv_Request->get_string('time_amount', 'get', '');
	$sort = $nv_Request->get_string('sort', 'get', '');

	if(!(empty($key) || empty($fromtime) || empty($time_amount) || empty($sort))) {
		$xtpl = new XTemplate("list-1.tpl", NV_ROOTDIR . "/themes/" . $module_info['template'] . "/modules/" . $module_file);
		$xtpl->assign("lang", $lang_module);

		$diseases = getDiseaseList();

		foreach ($diseases as $disease) {
			$xtpl->assign("title", $disease["disease"]);
			$vacs = getvaccustomer($key, $fromtime, $time_amount, $sort, $disease["id"]);
			$i = 1;

			foreach ($vacs as $row) {
				$xtpl->assign("id", $row["id"]);
				$xtpl->assign("index", $i);
				$xtpl->assign("petname", $row["petname"]);
				$xtpl->assign("customer", $row["customer"]);
				$xtpl->assign("phone", $row["phone"]);
				$xtpl->assign("confirm", $lang_module["confirm_" . $row["status"]]);
				$xtpl->assign("cometime", date("d/m/Y", $row["cometime"]));
				$xtpl->assign("calltime", date("d/m/Y", $row["calltime"]));
				$i++;
				$xtpl->parse("disease.vac_body");
			}
			$xtpl->parse("disease");
		}
		echo $xtpl->text("disease");
	}

	die();
?>
