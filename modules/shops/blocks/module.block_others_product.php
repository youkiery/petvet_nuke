<?php
/**
 * @Project NUKEVIET 3.0
 * @Author VINADES.,JSC (contact@vinades.vn)
 * @Copyright (C) 2010 VINADES., JSC. All rights reserved
 * @Createdate 3/9/2010 23:25
 */

if ( ! defined( 'NV_IS_MOD_SHOPS' ) ) die( 'Stop!!!' );
if ( ! function_exists( 'nv_others_product' ) )
{
    function nv_others_product ( )
    {
    	global $global_config, $module_name, $lang_module, $module_info, $module_file, $global_array_cat, $db,$module_data,$db_config,$id,$catid,$pro_config;
    	$link = NV_BASE_SITEURL . "index.php?" . NV_LANG_VARIABLE . "=" . NV_LANG_DATA . "&amp;" . NV_NAME_VARIABLE . "=" . $module_name . "&amp;" . NV_OP_VARIABLE . "=";
	    $xtpl = new XTemplate( "block.others_product.tpl", NV_ROOTDIR . "/themes/" . $module_info['template'] . "/modules/" . $module_file );
	    $xtpl->assign( 'LANG', $lang_module );
	    $xtpl->assign( 'THEME_TEM', NV_BASE_SITEURL . "themes/" . $module_info['template'] );
	    $sql = "SELECT id,listcatid, ".NV_LANG_DATA."_title,".NV_LANG_DATA."_alias,addtime,homeimgthumb,product_price,product_discounts,money_unit,showprice  FROM `" . $db_config['prefix'] . "_" . $module_data . "_rows` WHERE `listcatid` = " .$catid . " AND id < " .$id . " ORDER BY ID DESC LIMIT 0,20";
		///////////////////////////////////////////////////////////
		$i = 1;
		$list = nv_db_cache( $sql, 'nv_others_product', $module_name );
		foreach ( $list as $l )
		{
			$thumb = explode("|",$l['homeimgthumb']);
	    	if (!empty($thumb[0]) && ! nv_is_url( $thumb[0] ))
	    	{
	    		$thumb[0] = NV_BASE_SITEURL . NV_UPLOADS_DIR . "/" . $module_name . "/" . $thumb[0];
	    	}
	    	else
	    	{
                $thumb[0] = $l['homeimgthumb'];
	    		// $thumb[0] = NV_BASE_SITEURL . "themes/" . $module_info ['template'] . "/images/" . $module_file . "/no-image.jpg";
	    	}
			$xtpl->assign( 'link', $link.$global_array_cat[$l['listcatid']]['alias'] ."/" . $l['alias']."-".$l['id']  );
			$xtpl->assign( 'title', $l['title']  );
			$xtpl->assign( 'src_img', $thumb[0]  );
			$xtpl->assign( 'time', nv_date( 'd-m-Y h:i:s A', $l['addtime'])  );
			if ( $pro_config['active_price'] == '1' && $l['showprice'] == '1' )
            {
                $product_price = CurrencyConversion( $l['product_price'], $l['money_unit'], $pro_config['money_unit'] ); 
                $xtpl->assign( 'product_price', $product_price );
                $xtpl->assign( 'money_unit', $pro_config['money_unit'] );
                if ( $product_discounts_i != 0 )
                {
                    $price_product_discounts = $l['product_price'] - ( $l['product_price'] * ( $l['product_discounts'] / 100 ) );
                    $xtpl->assign( 'product_discounts', CurrencyConversion( $price_product_discounts, $l['money_unit'], $pro_config['money_unit'] ) );
                    $xtpl->assign( 'class_money', 'discounts_money' );
                    $xtpl->parse( 'main.loop.discounts' );
                }
                else
                {
                    $xtpl->assign( 'class_money', 'money' );
                }
                $xtpl->parse( 'main.loop.price' );
            }
			$bg = ($i%2 == 0) ? "bg" : "";
			$xtpl->assign( "bg", $bg );
			$xtpl->parse( 'main.loop' );
			$i++;
		}
		///////////////////////////////////////////////////////////////////////////////////
	    $xtpl->parse( 'main' );
	    return $xtpl->text( 'main' );
    }
}
$content = nv_others_product();
?>