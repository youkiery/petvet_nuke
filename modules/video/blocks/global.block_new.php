<?php
/**
 * @Project PCD-NUKEVIET 3.x
 * @Author PCD-GROUP
 * @Copyright (C) 2011 PCD-GROUP. All rights reserved
 * @Createdate 3/9/2011 23:25
 */

if ( ! defined( 'NV_MAINFILE' ) ) die( 'Stop!!!' );

if ( ! nv_function_exists( 'nv_videos_new' ) )
{
    function nv_videos_new ( $block_config )
    {
        global $module_info, $site_mods, $db, $global_config;
        $module = $block_config['module'];
        $mod_data = $site_mods[$module]['module_data'];
        $mod_file = $site_mods[$module]['module_file'];
        $sql = "SELECT * FROM `" . NV_PREFIXLANG . "_" . $mod_data . "_rows` WHERE status=1 AND img!= '' ORDER BY id DESC LIMIT 1";
        $result = $db->sql_query( $sql );
        
        if ( file_exists( NV_ROOTDIR . "/themes/" . $global_config['site_theme'] . "/modules/" . $mod_file . "/block_new.tpl" ) )
        {
            $block_theme = $global_config['site_theme'];
        }
        else
        {
            $block_theme = "default";
        }
        $xtpl = new XTemplate( "block_new.tpl", NV_ROOTDIR . "/themes/" . $block_theme . "/modules/" . $mod_file );
        if ( file_exists(NV_ROOTDIR . '/modules/' . $mod_file . '/language/'.NV_LANG_DATA.'.php')) 
        {
        	require_once ( NV_ROOTDIR . '/modules/' . $mod_file . '/language/'.NV_LANG_DATA.'.php' );
        }
        $xtpl->assign( 'LANG', $lang_module );
        $xtpl->assign( 'NV_BASE_SITEURL', NV_BASE_SITEURL );
        $xtpl->assign( 'THEME', $block_theme );
        while ( $data = $db->sql_fetchrow( $result, 2 ) )
        {
            $data['link'] = NV_BASE_SITEURL . "index.php?" . NV_LANG_VARIABLE . "=" . NV_LANG_DATA . "&amp;" . NV_NAME_VARIABLE . "=" . $module . "&amp;" . NV_OP_VARIABLE . "=view/" . $data['alias'] . "-" . $data['id'] . "";
            $data['hometext'] = nv_clean60( $data['hometext'], 160 );
            $data['title1'] = nv_clean60( $data['title'], 60 );
            if ( ! empty( $data['img'] ) )
            { 
            	$data['src'] = NV_BASE_SITEURL . "" . NV_UPLOADS_DIR . "/" . $module . "/" . $data['img'];
            }
            $xtpl->assign( 'ROW', $data );
            $xtpl->parse( 'main.loop' );
        }
        $xtpl->parse( 'main' );
        return $xtpl->text( 'main' );
    }
}

if ( defined( 'NV_SYSTEM' ) )
{
    global $site_mods, $module_name;
    $module = $block_config['module'];
    $content = nv_videos_new( $block_config );
}

?>