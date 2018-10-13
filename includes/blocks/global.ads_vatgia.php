<?php
/**
 * @Project Archives OF NUKEVIET 3.x
 * @Author PCD-GROUP (contact@dinhpc.com)
 * @Copyright (C) 2011 PCD-GROUP. All rights reserved
 * @Createdate July 27, 2011  11:24:58 AM 
 */

if ( ! defined( 'NV_MAINFILE' ) ) die( 'Stop!!!' );
if ( ! nv_function_exists( 'nv_block_ads_vatgia' ) )
{
	function nv_block_config_ads_vatgia ( $module, $data_block, $lang_block )
    {
        global $db, $language_array, $site_mods;
        $html = "";
        $html .= "<tr>";
        $html .= "	<td>Kiểu</td>";
        $html .= "	<td><input type=\"text\" name=\"config_type\" size=\"5\" value=\"" . $data_block['type'] . "\"/></td>";
        $html .= "</tr>";
      
        return $html;
    }

    function nv_block_config_ads_vatgia_submit ( $module, $lang_block )
    {
        global $nv_Request;
        $return = array();
        $return['error'] = array();
        $return['config'] = array();
        $return['config']['type'] = $nv_Request->get_int( 'config_type', 'post', 0 );
        return $return;
    }

	function nv_block_ads_vatgia ( $block_config )
    {
		global $global_config;
    	if ( file_exists( NV_ROOTDIR . "/themes/" . $global_config['site_theme'] . "/blocks/ads_vatgia.tpl") )
        {
            $block_theme = $global_config['site_theme'];
        }
        else
        {
            $block_theme = "default";
        }
		if ( empty( $block_config ['type'] ) ) $block_config ['type'] = 0;
        $xtpl = new XTemplate( "ads_vatgia.tpl", NV_ROOTDIR . "/themes/" . $block_theme . "/blocks" );
		$xtpl->assign( 'THEME' , $block_theme );
		$xtpl->assign( 'NV_BASE_SITEURL' , NV_BASE_SITEURL );
		
		if ( $block_config ['type'] == 0 ) 
		{
			$xtpl->parse( 'main.type0' );
		}
        if ( $block_config ['type'] == 1 ) 
		{
			$xtpl->parse( 'main.type1' );
		}
		if ( $block_config ['type'] == 2 ) 
		{
			$xtpl->parse( 'main.type2' );
		}
		if ( $block_config ['type'] == 3 ) 
		{
			$xtpl->parse( 'main.type3' );
		}
		if ( ! defined( 'NV_IS_VATGIA' ) ) 
		{
			$xtpl->parse( 'main.hed' );
			define('NV_IS_VATGIA', TRUE );
		}
		$xtpl->parse( 'main' );
		return $xtpl->text( 'main' );
    }
}
if ( defined( 'NV_SYSTEM' ) )
{
    $content = nv_block_ads_vatgia ( $block_config );
}
?>