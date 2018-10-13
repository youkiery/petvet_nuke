<?php
/**
 * @Project PCD-NUKEVIET 3.x
 * @Author PCD-GROUP
 * @Copyright (C) 2011 PCD-GROUP. All rights reserved
 * @Createdate 3/9/2011 23:25
 */

if ( ! defined( 'NV_MAINFILE' ) ) die( 'Stop!!!' );

if ( ! nv_function_exists( 'nv_videos_top' ) )
{
    function nv_block_config_videos_top ( $module, $data_block, $lang_block )
    {
        global $db, $language_array, $site_mods;
        $mod_data = $site_mods[$module]['module_data'];
        $html = "";
        $html .= "<tr>";
        $html .= "	<td>" . $lang_block['num'] . "</td>";
        $html .= "	<td><input type=\"text\" name=\"config_num\" size=\"5\" value=\"" . $data_block['num'] . "\"/></td>";
        $html .= "<td></tr>";
        return $html;
    }
    function nv_block_config_videos_top_submit ( $module, $lang_block )
    {
        global $nv_Request;
        $return = array();
        $return['error'] = array();
        $return['config'] = array();
        $return['config']['num'] = $nv_Request->get_int( 'config_num', 'post', 0 );
        return $return;
    }
    function nv_videos_top ( $block_config )
    {
        global $module_info, $site_mods, $db, $global_config;
        $module = $block_config['module'];
        $mod_data = $site_mods[$module]['module_data'];
        $mod_file = $site_mods[$module]['module_file'];
        $sql = "SELECT * FROM `" . NV_PREFIXLANG . "_" . $mod_data . "_rows` WHERE status=1 ORDER BY view DESC LIMIT 0," . $block_config['num'];
        $result = $db->sql_query( $sql );
        
        if ( file_exists( NV_ROOTDIR . "/themes/" . $global_config['site_theme'] . "/modules/" . $mod_file . "/block_top.tpl" ) )
        {
            $block_theme = $global_config['site_theme'];
        }
        else
        {
            $block_theme = "default";
        }
        $xtpl = new XTemplate( "block_top.tpl", NV_ROOTDIR . "/themes/" . $block_theme . "/modules/" . $mod_file );
        if ( file_exists(NV_ROOTDIR . '/modules/' . $mod_file . '/language/'.NV_LANG_DATA.'.php')) 
        {
        	require_once ( NV_ROOTDIR . '/modules/' . $mod_file . '/language/'.NV_LANG_DATA.'.php' );
        }
        $xtpl->assign( 'NV_BASE_SITEURL', NV_BASE_SITEURL );
        $xtpl->assign( 'THEME', $block_theme );
        $a=1;
        while ( $data = $db->sql_fetchrow( $result, 2 ) )
        {   //die($data);
            $data['link'] = NV_BASE_SITEURL . "index.php?" . NV_LANG_VARIABLE . "=" . NV_LANG_DATA . "&amp;" . NV_NAME_VARIABLE . "=" . $module . "&amp;" . NV_OP_VARIABLE . "=view/" . $data['alias'] . "-" . $data['id'] . "";
            $data['addtime'] = nv_date( "l - d/m/Y  H:i", $data['addtime'] );
            $data['hometext'] = nv_clean60( $data['hometext'], 100 );
            if ( ! empty( $data['img'] ) )
            {
                $imageinfo = nv_ImageInfo( NV_ROOTDIR . '/' . NV_UPLOADS_DIR . '/' . $module . '/' . $data['img'], 120, true, NV_ROOTDIR . '/' . NV_FILES_DIR . '/' . $module );
                $data['src'] = $imageinfo['src'];
            }
              
	            $data['src'] = NV_BASE_SITEURL . NV_UPLOADS_DIR . '/' . $module . '/' . $data['img'];
            	$xtpl->assign( 'ROW', $data );
	            if ( ! empty( $data['src'] ) && file_exists( NV_ROOTDIR . '/' . NV_UPLOADS_DIR . '/' . $module . '/' . $data['img'] ) )
	            {
	                $xtpl->parse( 'main.loop.img' );
	            }
	            $xtpl->parse( 'main.loop' );
         

            $a++;
        }
        $xtpl->parse( 'main' );
        return $xtpl->text( 'main' );
    }
}

if ( defined( 'NV_SYSTEM' ) )
{
    global $site_mods, $module_name;
    $module = $block_config['module'];
    $content = nv_videos_top( $block_config );
}

?>