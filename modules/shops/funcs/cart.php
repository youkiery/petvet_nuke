<?php
/**
 * @Project NUKEVIET 3.0
 * @Author VINADES.,JSC (contact@vinades.vn)
 * @Copyright (C) 2010 VINADES., JSC. All rights reserved
 * @Createdate 3-6-2010 0:14
 */

if ( ! defined( 'NV_IS_MOD_SHOPS' ) ) die( 'Stop!!!' );
$data_content = array();
$link = NV_BASE_SITEURL . "index.php?" . NV_LANG_VARIABLE . "=" . NV_LANG_DATA . "&amp;" . NV_NAME_VARIABLE . "=" . $module_name . "&amp;" . NV_OP_VARIABLE . "=";
if ( $nv_Request->get_int( 'save', 'post', 0 ) == 1 )
{
    // set cart to order
    $listproid = $nv_Request->get_array( 'listproid', 'post', '' );
	$listcolorid = $nv_Request->get_array( 'listcolorid', 'post', '' );
    if ( ! empty( $listproid ) )
    {
        foreach ( $listproid as $pro_id => $number )
        {
			
            if ( ! empty( $_SESSION[$module_data . '_cart'][$pro_id] ) and $number >= 0 )
            {
                $_SESSION[$module_data . '_cart'][$pro_id]['num'] = $number;
				$_SESSION[$module_data . '_cart'][$pro_id]['color'] = ($listcolorid[$pro_id])?$listcolorid[$pro_id]:0;
			}
			
        }
    }
	
}
$array_error_product_number = array();
if ( ! empty( $_SESSION[$module_data . '_cart'] ) )
{
    $arrayid = array();
    foreach ( $_SESSION[$module_data . '_cart'] as $pro_id => $pro_info )
    {
        $arrayid[] = $pro_id;
    }
    if ( ! empty( $arrayid ) )
    {
        $listid = implode( ",", $arrayid );
        $sql = "SELECT t1.id, t1.listcatid,t1.color_id, t1.publtime, t1." . NV_LANG_DATA . "_title, t1." . NV_LANG_DATA . "_alias, t1." . NV_LANG_DATA . "_note, t1." . NV_LANG_DATA . "_hometext, t1.homeimgalt, t1.homeimgthumb, t1.product_number, t1.product_price,t1.product_discounts,t2." . NV_LANG_DATA . "_title, t1.money_unit  FROM `" . $db_config['prefix'] . "_" . $module_data . "_rows` as t1 LEFT JOIN `" . $db_config['prefix'] . "_" . $module_data . "_units` as t2 ON t1.product_unit = t2.id WHERE  t1.id IN (" . $listid . ")  AND t1.status=1 AND t1.publtime < " . NV_CURRENTTIME . " AND (t1.exptime=0 OR t1.exptime>" . NV_CURRENTTIME . ")";
        $result = $db->sql_query( $sql );
        while ( list( $id, $listcatid,$color_id, $publtime, $title, $alias, $note, $hometext, $homeimgalt, $homeimgthumb, $product_number, $product_price, $product_discounts, $unit, $money_unit ) = $db->sql_fetchrow( $result ) )
        {
            $thumb = explode( "|", $homeimgthumb );
            if ( ! empty( $thumb[0] ) && ! nv_is_url( $thumb[0] ) )
            {
                $thumb[0] = NV_BASE_SITEURL . NV_UPLOADS_DIR . "/" . $module_name . "/" . $thumb[0];
            }
            else
            {
                $thumb[0] = $homeimgthumb;
                // $thumb[0] = NV_BASE_SITEURL . "themes/" . $module_info['template'] . "/images/" . $module_file . "/no-image.jpg";
            }
            $number = $_SESSION[$module_data . '_cart'][$id]['num'];
            if ( $number > $product_number && $number>0 )
            {
                $number = $_SESSION[$module_data . '_cart'][$id]['num'] = $product_number;
                $array_error_product_number[] = sprintf( $lang_module['product_number_max'], $title, $product_number );
            }
            if ( $pro_config['active_price'] == '0' ) { $product_discounts = $product_price = 0; }
            // zsize
            $zsize = $_SESSION[$module_data . '_cart'][$id]['zsize'];
            $zprice = $_SESSION[$module_data . '_cart'][$id]['zprice'];
            $data_content[] = array( 
                "id" => $id, 'zsize' => $zsize, 'zprice' => $zprice,"color_id" => $color_id, "publtime" => $publtime, "title" => $title, "alias" => $alias, "note" => $note, "hometext" => $hometext, "homeimgalt" => $homeimgalt, "homeimgthumb" => $thumb[0], "product_price" => $product_price, "product_discounts" => $product_discounts, "product_unit" => $unit, "money_unit" => $money_unit, "link_pro" => $link . $global_array_cat[$listcatid]['alias'] . "/" . $alias . "-" . $id, "num" => $number, "link_remove" => $link . "remove&id=" . $id 
            );
            $_SESSION[$module_data . '_cart'][$id]['order'] = 1;
        }
        
        if ( empty( $array_error_product_number ) and $nv_Request->isset_request( 'cart_order', 'post' ) )
        {
            Header( "Location: " . NV_BASE_SITEURL . "index.php?" . NV_NAME_VARIABLE . "=" . $module_name . "&" . NV_OP_VARIABLE . "=order" );
            die();
        }
    }
}
else
{
    Header( "Location: " . NV_BASE_SITEURL . "index.php?" . NV_NAME_VARIABLE . "=" . $module_name );
    die();
}

$contents = call_user_func( "cart_product", $data_content, $array_error_product_number );
include ( NV_ROOTDIR . "/includes/header.php" );
echo nv_site_theme( $contents );
include ( NV_ROOTDIR . "/includes/footer.php" );

?>