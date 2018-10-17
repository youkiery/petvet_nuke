<?php

if (!defined('NV_IS_MOD_SHOPS'))
  die('Stop!!!');
if (!defined('NV_IS_AJAX'))
  die('Wrong URL');
if (!isset($_SESSION[$module_data . '_cart']))
  $_SESSION[$module_data . '_cart'] = array();

$id = $nv_Request->get_int('id', 'post,get', 1);
$num = $nv_Request->get_int('num', 'post,get', 1);
$ac = $nv_Request->get_string('ac', 'post,get', 0);
$size = $nv_Request->get_string('size', 'post,get', 0);
$price = $nv_Request->get_string('price', 'post,get', 0);
$contents_msg = "";
if (!is_numeric($num) || $num < 0) {
  $contents_msg = 'ERR_' . $lang_module['cart_set_err'];
} else {
  if ($ac == 0) {
    if ($id > 0) {
      $query = $db->sql_query("SELECT * FROM `" . $db_config['prefix'] . "_" . $module_data . "_rows` WHERE `id` = " . $id . "");
      $data_content = $db->sql_fetchrow($query, 2);
      $thumb = explode("|", $data_content['homeimgthumb']);
      if (!empty($thumb[0]) && !nv_is_url($thumb[0])) {
        $thumb[0] = NV_BASE_SITEURL . NV_UPLOADS_DIR . "/" . $module_name . "/" . $thumb[0];
      }
			$data_content['homeimgthumb'] = $thumb[0];
			
			if (empty($size) || empty($price)) {
				if ($data_content['product_discounts'] > 0) {
					$price = $data_content['product_discounts'];
				}
				else {
					$price = $data_content['product_price'];
				}
			}
      if ($pro_config['active_order_number'] == '1') {
        $num = 0;
      }
			$update_cart = true;
      if (!isset($_SESSION[$module_data . '_cart'])) {
				$_SESSION[$module_data . '_cart'] = array();
			}
			$_SESSION[$module_data . '_cart'][] = array(
				'id' => $id, 'num' => $num, 'size' => $size, 'price' => $price, 'order' => 0, 'data' => $data_content
			);
      if ($update_cart) {
        $title = str_replace("_", "#@#", $data_content[NV_LANG_DATA . '_title']);
        $contents = sprintf($lang_module['set_cart_success'], $title);
        $contents_msg = 'OK_' . $contents;
      }
		}
		else {
			die(json_encode($id));
		}
  } else {
    if ($id > 0) {
			foreach ($_SESSION[$module_data . '_cart'] as $index => $cart) {
				if($cart["id"] == $id) {
					$_SESSION[$module_data . '_cart'][$index]["num"] = $num;
					$contents_msg = 'OK_' . $lang_module['cart_set_ok'] . $num;
					break;
				}
			}
    }
		else {
			die(json_encode($id));
		}
  }
}
include ( NV_ROOTDIR . "/includes/header.php" );
echo nv_unhtmlspecialchars($contents_msg);
include ( NV_ROOTDIR . "/includes/footer.php" );
?>