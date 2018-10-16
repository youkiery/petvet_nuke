<?php
if (!defined('NV_IS_MOD_SHOPS'))
  die('Stop!!!');
$data_content = array();
$link = NV_BASE_SITEURL . "index.php?" . NV_LANG_VARIABLE . "=" . NV_LANG_DATA . "&amp;" . NV_NAME_VARIABLE . "=" . $module_name . "&amp;" . NV_OP_VARIABLE . "=";

if ($nv_Request->get_int('save', 'post', 0) == 1) {
	// set cart to order
	// die("set cart to order");
  $listproid = $nv_Request->get_array('listproid', 'post', '');
  // $listcolorid = $nv_Request->get_array('listcolorid', 'post', '');
  if (!empty($listproid)) {
    foreach ($listproid as $pro_id => $number) {
      if (!empty($_SESSION[$module_data . '_cart'][$pro_id]) and $number >= 0) {
        $_SESSION[$module_data . '_cart'][$pro_id]['num'] = $number;
      }
    }
  }
}
$array_error_product_number = array();

foreach ($_SESSION[$module_data . '_cart'] as $pro_index => $pro_info) {
	$number = intval($pro_info['num']);
	if($number < 1) {
		$_SESSION[$module_data . '_cart'][$pro_index]['num'] = 1;
	}

	$_SESSION[$module_data . '_cart'][$pro_index]['order'] = 1;
	// zsize
	$temp_data = $_SESSION[$module_data . '_cart'][$pro_index]["data"];
	$temp_data["link_pro"] = $link . $global_array_cat[$listcatid]['alias'] . "/" . $alias . "-" . $id;
	$temp_data["link_remove"] = $link . "remove&id=" . $id;
	$temp_data["num"] = $pro_info["num"];

	$temp_data["price"] = $pro_info["price"];

	$data_content[] = $temp_data;
}
	
if (empty($array_error_product_number) and $nv_Request->isset_request('cart_order', 'post')) {
	Header("Location: " . NV_BASE_SITEURL . "index.php?" . NV_NAME_VARIABLE . "=" . $module_name . "&" . NV_OP_VARIABLE . "=order");
	die();
}
// die(json_encode($data_content));
$contents = call_user_func("cart_product", $data_content, $array_error_product_number);
include ( NV_ROOTDIR . "/includes/header.php" );
echo nv_site_theme($contents);
include ( NV_ROOTDIR . "/includes/footer.php" );
?>