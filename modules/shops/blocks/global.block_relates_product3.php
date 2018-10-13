<?php
/**
 * @Project NUKEVIET 3.0
 * @Author VINADES.,JSC (contact@vinades.vn)
 * @Copyright (C) 2010 VINADES., JSC. All rights reserved
 * @Createdate 3/9/2010 23:25
 */

if ( ! defined( 'NV_MAINFILE' ) ) die( 'Stop!!!' );

if ( ! nv_function_exists( 'nv_relates_product3' ) )
{

    function nv_block_config_relates3_blocks ( $module, $data_block, $lang_block )
    {
        global $db, $language_array, $db_config;
        $html = "";
        $html .= "<tr>";
        $html .= "	<td>" . $lang_block['blockid'] . "</td>";
        $html .= "	<td><select name=\"config_blockid\">\n";
        $sql = "SELECT `bid`,  " . NV_LANG_DATA . "_title," . NV_LANG_DATA . "_alias FROM `" . $db_config['prefix'] . "_" . $module . "_block_cat` ORDER BY `weight` ASC";
        $list = nv_db_cache( $sql, 'catid', $module );
        foreach ( $list as $l )
        {
            $sel = ( $data_block['blockid'] == $l['bid'] ) ? ' selected' : '';
            $html .= "<option value=\"" . $l['bid'] . "\" " . $sel . ">" . $l[NV_LANG_DATA . '_title'] . "</option>\n";
        }
        $html .= "	</select></td>\n";
        $html .= "</tr>";
        $html .= "<tr>";
        $html .= "	<td>" . $lang_block['numrow'] . "</td>";
        $html .= "	<td><input type=\"text\" name=\"config_numrow\" size=\"5\" value=\"" . $data_block['numrow'] . "\"/></td>";
        $html .= "</tr>";
        $html .= "<tr>";
        $html .= "	<td>" . $lang_block['cut_num'] . "</td>";
        $html .= "	<td><input type=\"text\" name=\"config_cut_num\" size=\"5\" value=\"" . $data_block['cut_num'] . "\"/></td>";
        $html .= "</tr>";
		$html .= "<tr>";
        $html .= "	<td>" . $lang_block['cut_num2'] . "</td>";
        $html .= "	<td><input type=\"text\" name=\"config_cut_num2\" size=\"5\" value=\"" . $data_block['cut_num2'] . "\"/></td>";
        $html .= "</tr>";
        return $html;
    }

    function nv_block_config_relates3_blocks_submit ( $module, $lang_block )
    {
        global $nv_Request;
        $return = array();
        $return['error'] = array();
        $return['config'] = array();
        $return['config']['blockid'] = $nv_Request->get_int( 'config_blockid', 'post', 0 );
        $return['config']['numrow'] = $nv_Request->get_int( 'config_numrow', 'post', 0 );
        $return['config']['cut_num'] = $nv_Request->get_int( 'config_cut_num', 'post', 0 );
        $return['config']['cut_num2'] = $nv_Request->get_int( 'config_cut_num2', 'post', 0 );
        return $return;
    }
    
    if ( ! function_exists( 'CurrencyConversion' ) )
    {

        function CurrencyConversion ( $price, $currency_curent, $currency_convert, $block_config )
        {
            global $money_config, $module_config;
            $module = $block_config['module'];
            $pro_config = $module_config[$module];
            $str = number_format( $price, 0, '.', ' ' );
            if ( ! empty( $money_config ) )
            {
                if ( $currency_curent == $pro_config['money_unit'] )
                {
                    $value = doubleval( $money_config[$currency_convert]['exchange'] );
                    $price = doubleval( $price * $value );
                    $str = number_format( $price, 0, '.', ' ' );
                    $ss = "~";
                }
                elseif ( $currency_convert == $pro_config['money_unit'] )
                {
                    $value = doubleval( $money_config[$currency_curent]['exchange'] );
                    $price = doubleval( $price / $value );
                    $str = number_format( $price, 0, '.', ' ' );
                }
            }
            $ss = ( $currency_curent == $currency_convert ) ? "" : "~";
            return $ss . $str;
        }
    }

    function nv_relates_product3 ( $block_config )
    {
        global $site_mods, $global_config, $module_config, $module_name, $module_info, $global_array_cat, $db, $db_config, $my_head;
        $module = $block_config['module'];
        $mod_data = $site_mods[$module]['module_data'];
        $mod_file = $site_mods[$module]['module_file'];
		include (NV_ROOTDIR . "/modules/" . $mod_file . "/language/" . NV_LANG_DATA . ".php");
        $pro_config = $module_config[$module];
        $array_cat_shops = $global_array_cat;
        /*get theme block*/
        if ( file_exists( NV_ROOTDIR . "/themes/" . $global_config['site_theme'] . "/modules/" . $mod_file . "/block.others_product.tpl" ) )
        {
            $block_theme = $global_config['site_theme'];
        }
        else
        {
            $block_theme = "default";
        }
        /*get $array_cat module*/
        if ( $module != $module_name )
        {
            $sql = "SELECT catid, image, icon, parentid, lev," . NV_LANG_DATA . "_title as title," . NV_LANG_DATA . "_alias as alias, viewcat, numsubcat, subcatid, numlinks, del_cache_time, " . NV_LANG_DATA . "_description, inhome, " . NV_LANG_DATA . "_keywords, who_view, groups_view FROM `" . $db_config['prefix'] . "_" . $mod_data . "_catalogs` ORDER BY `order` ASC";
			$list = nv_db_cache( $sql, 'catid', $module );
			foreach ( $list as $l )
			{
				$l['link'] = NV_BASE_SITEURL . "index.php?" . NV_LANG_VARIABLE . "=" . NV_LANG_DATA . "&amp;" . NV_NAME_VARIABLE . "=" . $module . "&amp;" . NV_OP_VARIABLE . "=" . $l['alias'] . "";
				$array_cat_shops[$l['catid']] = $l;
			}
            if ( file_exists( NV_ROOTDIR . "/themes/" . $block_theme . "/css/" . $mod_file . ".css" ) )
            {
                $my_head .= '<link rel="StyleSheet" href="' . NV_BASE_SITEURL . 'themes/' . $block_theme . '/css/' . $mod_file . '.css' . '" type="text/css" />';
            }
        }
        /*show data*/
        $link = NV_BASE_SITEURL . "index.php?" . NV_LANG_VARIABLE . "=" . NV_LANG_DATA . "&amp;" . NV_NAME_VARIABLE . "=" . $module . "&amp;" . NV_OP_VARIABLE . "=";
        
		$xtpl = new XTemplate( "block.others_product3.tpl", NV_ROOTDIR . "/themes/" . $block_theme . "/modules/" . $mod_file );
		$xtpl->assign( 'LANG', $lang_module );
		$xtpl->assign( 'TEMPLATE', $block_theme );
        $sql = "SELECT  t1.id, t1.listcatid, t1." . NV_LANG_DATA . "_title as title, t1." . NV_LANG_DATA . "_alias as alias, t1." . NV_LANG_DATA . "_hometext as hometext, t1.addtime,t1.homeimgthumb,t1.product_price,t1.product_discounts,t1.money_unit,t1.showprice FROM `" . $db_config['prefix'] . "_" . $module . "_rows` as t1 INNER JOIN `" . $db_config['prefix'] . "_" . $module . "_block` AS t2 ON t1.id = t2.id WHERE t2.bid= " . $block_config['blockid'] . " AND t1.status= 1 AND  t1.publtime < " . NV_CURRENTTIME . " AND (t1.exptime=0 OR t1.exptime >" . NV_CURRENTTIME . ") ORDER BY t1.addtime DESC, t2.weight ASC LIMIT 0 , " . $block_config['numrow'];
		
		$list = nv_db_cache_adv( $sql, 'block_cateid'.$block_config['bid'], $module );
		//print($list);exit();
        $i = 1;
		

        $cut_num = $block_config['cut_num'];
        $cut_num2 = $block_config['cut_num2'];
        ///////////////////////////////////////////////////////////
			$y = 0;
		foreach ( $list as $l )
        {
            $thumb = explode( "|", $l['homeimgthumb'] );
            if ( ! empty( $thumb[0] ) && ! nv_is_url( $thumb[0] ) )
            {
                $thumb[0] = NV_BASE_SITEURL . NV_UPLOADS_DIR . "/" . $module . "/" . $thumb[0];
            }
            else
            {
                $thumb[0] = $l['homeimgthumb'];
                // $thumb[0] = NV_BASE_SITEURL . "themes/" . $module_info['template'] . "/images/" . $mod_file . "/no-image.jpg";
            }
			//link xem them
			$sql = "SELECT `bid`,  " . NV_LANG_DATA . "_title," . NV_LANG_DATA . "_alias FROM `" . $db_config['prefix'] . "_" . $module . "_block_cat` ORDER BY `weight` ASC";
			$list_cat = nv_db_cache( $sql, 'catid', $module );
			
			$row = array();
		
			foreach ( $list_cat as $a )
			{
				if( $block_config['blockid'] == $a['bid'] ) $row = $a;
				
			
			}
			//print_r( $row);exit();
			$xtpl->assign( 'LINK_FULL',$link . $row['vi_alias']  );
			$xtpl->assign( 'TITLE',$row['vi_title']  );
			
            $xtpl->assign( 'link', $link . $row['vi_alias'] . "/" . $l['alias'] . "-" . $l['id'] );
            $title_i = nv_clean60( $l['title'], $cut_num );
            $hometext_i = nv_clean60( $l['hometext'], $cut_num2 );
            $xtpl->assign( 'title', $title_i );
			$a= round ((100-(($l['product_discounts'])/($l['product_price']))*100));
			//print_r($l);exit();
			$xtpl->assign( 'sale', $a );
			$xtpl->assign( 'hometext', $hometext_i );
            $xtpl->assign( 'src_img', $thumb[0] );
            $xtpl->assign( 'time', nv_date( 'd-m-Y h:i:s A', $l['addtime'] ) );
            if ( $pro_config['active_price'] == '1' && $l['showprice'] == '1' )
            {
                
                $product_price = CurrencyConversion( $l['product_price'], $l['money_unit'], $pro_config['money_unit'], $block_config );
                $xtpl->assign( 'product_price', $product_price );
                $xtpl->assign( 'money_unit', $pro_config['money_unit'] );
                if ( $l['product_discounts'] != 0 )
                {
                    $price_product_discounts = $l['product_price'] - ( $l['product_price'] * ( $l['product_discounts'] / 100 ) );
                    $xtpl->assign( 'product_discounts', CurrencyConversion(  $l['product_discounts'], $l['money_unit'], $pro_config['money_unit'], $block_config ) );
					//print_r(CurrencyConversion($l['product_discounts'], $l['money_unit'], $pro_config['money_unit'], $block_config ));exit();
                    $xtpl->assign( 'class_money', 'old-price' );
                    $xtpl->parse( 'main.loop.discounts' );
				
                }
                else
                {
                    $xtpl->assign( 'class_money', 'special-price' );
                }
                $xtpl->parse( 'main.loop.price' );
				
            }
			
            $bg = ( $i % 2 == 0 ) ? "bg" : "";
			$id = ( $i % 2 == 0 ) ? "2" : "1";
			$xtpl->assign( "id", $id );
            $xtpl->assign( "bg", $bg );
			 $xtpl->assign( 'id', $y );
		
		  
		  
		  $xtpl->parse( 'main.loop' );
		$y ++;
            $i ++;
			
        }
        ///////////////////////////////////////////////////////////////////////////////////
        $xtpl->parse( 'main' );
        return $xtpl->text( 'main' );
    }
}

if ( defined( 'NV_SYSTEM' ) )
{
    global $site_mods;
    $module = $block_config['module'];
    $content = nv_relates_product3( $block_config );
}

?>