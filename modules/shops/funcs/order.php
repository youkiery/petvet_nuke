<?php
if (!defined('NV_IS_MOD_SHOPS')) die('Stop!!!');
$contents = "";
$link1 = NV_BASE_SITEURL . "index.php?" . NV_LANG_VARIABLE . "=" . NV_LANG_DATA . "&amp;" . NV_NAME_VARIABLE . "=" . $module_name . "";
$link = NV_BASE_SITEURL . "index.php?" . NV_LANG_VARIABLE . "=" . NV_LANG_DATA . "&amp;" . NV_NAME_VARIABLE . "=" . $module_name . "&amp;" . NV_OP_VARIABLE . "=";
$action = 0;
$post_order = $nv_Request->get_int('postorder', 'post', 0);
$error = array();
$data_order = array(
	"user_id" => $user_info["userid"], "order_name" => (!empty($user_info["full_name"])) ? $user_info["full_name"] : $user_info["username"], "order_email" => $user_info["email"], "order_address" => $user_info["location"], "order_phone" => $user_info["telephone"], "order_note" => "", "listid" => "", "listnum" => "", "listprice" => "","listcolor"=>"", "admin_id" => 0, "shop_id" => 0, "who_is" => 0, "unit_total" => $pro_config['money_unit'], "order_total" => 0, "order_time" => NV_CURRENTTIME 
);

if ($post_order == 1) {
	$listid = "";
	$listnum = "";
	$listprice = "";
	$listcolor = "";
	$i = 0;
	$total = 0;
	
	foreach ($_SESSION[$module_data . '_cart'] as $index => $info) {
		if ($info['order'] == 1) {
			// zsize
			if ($i == 0) {
				$listid .= $info["id"];
				$size .= $info["size"];
				$listprice .= $info['price'];
				$listnum .= $info['num'];
				$listcolor .= $info['color'];
			}
			else {
				$listid .= "|" . $info["id"];
				$size .= "|" . $info["size"];
				$listnum .= "|" . $info['num'];
				$listprice .= "|" . $info['price'];
				$listcolor .= "|" . $info['color'];
			}
			$total = $total + ((int)$info['num'] * (double)$info['price']);
			$i ++;
		}
	}
	
	$data_order['order_name'] = filter_text_input('order_name', 'post', '', 1, 200);
	$data_order['order_email'] = filter_text_input('order_email', 'post', '', 1, 250);
	$data_order['order_address'] = filter_text_input('order_address', 'post', '', 1);
	$data_order['order_phone'] = filter_text_input('order_phone', 'post', '', 1, 20);
	$data_order['order_note'] = filter_text_input('order_note', 'post', '', 1, 2000);
	$data_order['listid'] = $listid;
	$data_order['listnum'] = $listnum;
	$data_order['listprice'] = $listprice;
	$data_order['listcolor'] = $listcolor;
	$data_order['order_total'] = $total;
	if (empty($data_order['order_name'])) $error['order_name'] = $lang_module['order_name_err'];
	elseif (empty($data_order['order_phone'])) $error['order_phone'] = $lang_module['order_phone_err'];
	
	if (empty($error) and $i > 0) {
		$result = $db->sql_query("SHOW TABLE STATUS WHERE `Name`='" . $db_config['prefix'] . "_" . $module_data . "_orders'");
		$item = $db->sql_fetch_assoc($result);
		$db->sql_freeresult($result);
		
		$order_code = vsprintf($pro_config['format_order_id'], $item['Auto_increment']);
		$transaction_status = (empty($pro_config['auto_check_order'])) ? - 1 : 0;
		$sql = "INSERT INTO `" . $db_config['prefix'] . "_" . $module_data . "_orders` (
		`order_id`, `lang`, `order_code`, `size`, `order_name`, `order_email`, `order_address`, `order_phone`, `order_note`, `listid`, `listnum`, `listprice`, `listcolor`,
		`user_id`, `admin_id`, `shop_id`, `who_is`, `unit_total`, `order_total`, `order_time`, `postip`, `view`, 
		`transaction_status`, `transaction_id`, `transaction_count`
		)
		VALUES (
		NULL , '" . NV_LANG_DATA . "', " . $db->dbescape_string($order_code) . ", '" . $size . "', " . $db->dbescape_string($data_order['order_name']) . ", " . $db->dbescape_string($data_order['order_email']) . ", 
				 " . $db->dbescape_string($data_order['order_address']) . "," . $db->dbescape_string($data_order['order_phone']) . ", 
				 " . $db->dbescape_string($data_order['order_note']) . ", " . $db->dbescape_string($data_order['listid']) . ", 
				 " . $db->dbescape_string($data_order['listnum']) . ", " . $db->dbescape_string($data_order['listprice']) . ", 
				 " . $db->dbescape_string($data_order['listcolor']) . ", 
				 " . intval($data_order['user_id']) . ", " . intval($data_order['admin_id']) . ", " . intval($data_order['shop_id']) . ", 
				 " . intval($data_order['who_is']) . ", " . $db->dbescape_string($data_order['unit_total']) . ", " . doubleval($data_order['order_total']) . ", 
				 " . intval($data_order['order_time']) . "," . $db->dbescape($client_info['ip']) . " ,0," . $transaction_status . ",0,0
		);				
		";
		$order_id = $db->sql_query_insert_id($sql);

		if ($order_id > 0) {
			// if ($pro_config['active_order_number'] == '0') {
			// 	product_number_order($data_order['listid'], $data_order['listnum']);
			// }
			// product_number_order ($data_order['listid'], $data_order['listnum']);
			//*********** tru hang trong kho/////////////////
			$order_code2 = vsprintf($pro_config['format_order_id'], $order_id);
			if ($order_code != $order_code2) {
				$db->sql_query("UPDATE `" . $db_config['prefix'] . "_" . $module_data . "_orders` SET `order_code`=" . $db->dbescape_string($order_code2) . "  WHERE `order_id`=" . $order_id);
			}
			$checkss = md5($order_id . $global_config['sitekey'] . session_id());
			unset($_SESSION[$module_data . '_cart']);
			Header("Location: " . NV_BASE_SITEURL . "index.php?" . NV_LANG_VARIABLE . "=" . NV_LANG_DATA . "&" . NV_NAME_VARIABLE . "=" . $module_name . "&" . NV_OP_VARIABLE . "=payment&order_id=" . $order_id . "&checkss=" . $checkss);
			$action = 1;
		}
	}
}
		

if ($action == 0) {
	$i = 0;
	foreach ($_SESSION[$module_data . '_cart'] as $pro_index => $pro_info) {
		$i++;
		$temp_data = $pro_info;
		$temp_data["link_pro"] = $link . $global_array_cat[$pro_info["data"]["listcatid"]]['alias'] . "/" . $pro_info["data"]["vi_alias"] . "-" . $pro_info["id"];
		$temp_data["size"] = $pro_info["size"];
		$temp_data["order"] = 1;
		$check = true;
		foreach ($data_content as $index => $value) {
			if($value["id"] == $pro_info["id"] && $value["size"] == $_SESSION[$module_data . '_cart'][$pro_index]["size"]) {
				$data_content[$index]["num"] = intval($value["num"]) + intval($_SESSION[$module_data . '_cart'][$pro_index]["num"]);
				$check = false;
				break;
			}
		}
		if($check) {
			$data_content[] = $temp_data;
		}
	}
	if ($i == 0) {
		die();
		Header("Location: " . NV_BASE_SITEURL . "index.php?" . NV_NAME_VARIABLE . "=" . $module_name . "&" . NV_OP_VARIABLE . "=cart");
		die();
	}
	else {
		unset($_SESSION[$module_data . '_cart']);
		$_SESSION[$module_data . '_cart'] = $data_content;
		
		$contents = call_user_func("uers_order", $data_content, $data_order, $error);
	}
}
include (NV_ROOTDIR . "/includes/header.php");
echo nv_site_theme($contents);
include (NV_ROOTDIR . "/includes/footer.php");
?>
