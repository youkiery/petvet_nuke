<?php
/**
 * @Project NUKEVIET 3.0
 * @Author VINADES.,JSC (contact@vinades.vn)
 * @Copyright (C) 2010 VINADES., JSC. All rights reserved
 * @Createdate 3/25/2010 18:6
 */

if ( ! function_exists( 'nv_albums_news' ) )
{
	function nv_block_config_albums_news ( $module, $data_block, $lang_block )
    {
        global $db, $language_array;
        $html .= "<input type=\"text\" value=\"".$data_block['numrow']."\" name=\"config_numrow\" />";
        return '<tr><td>' . $lang_block['numrow'] . '</td><td>' . $html . '</td></tr>';
    }

    function nv_block_config_albums_news_submit ( $module, $lang_block )
    {
        global $nv_Request;
        $return = array();
        $return['error'] = array();
        $return['config'] = array();
        $return['config']['numrow'] = $nv_Request->get_int( 'config_numrow', 'post', 0 );
        return $return;
    }
	function nv_albums_news ( $block_config )
    {
        global $global_config, $db, $site_mods;
    	$module = $block_config['module'];
        $mod_data = $site_mods[$module]['module_data'];
        $mod_file = $site_mods[$module]['module_file'];
    	if ( file_exists( NV_ROOTDIR . "/themes/" . $global_config['site_theme'] . "/modules/" . $mod_file . "/global.albums.tpl") )
        {
            $block_theme = $global_config['site_theme'];
        }
        else
        {
            $block_theme = "default";
        }
        $xtpl = new XTemplate( "global.albums.tpl", NV_ROOTDIR . "/themes/" . $block_theme . "/modules/" . $mod_file );
        $xtpl->assign( 'NV_BASE_SITEURL', NV_BASE_SITEURL );
        $xtpl->assign( 'TEMPLATE', $block_theme );
        $s = "SELECT * FROM `" . NV_PREFIXLANG . "_".$mod_data."_imgs` ";
        $re = $db->sql_query( $s );
        while ( $row = $db->sql_fetchrow( $re ) )
        {
            $row['link'] = NV_BASE_SITEURL . "index.php?" . NV_LANG_VARIABLE . "=" . NV_LANG_DATA . "&" . NV_NAME_VARIABLE . "=" . $module . "&" . NV_OP_VARIABLE . "=album/" . $row['alias'] . "-" . $row['id'];
            $row['add_time'] = date( "d/m/Y", $row['add_time'] );
            if ( ! empty( $row['img'] ) )
            {
                $imageinfo = nv_ImageInfo( NV_ROOTDIR . '/' . NV_UPLOADS_DIR . '/' . $module . '/' . $row['img'], 800, true, NV_ROOTDIR . '/' . NV_FILES_DIR . '/' . $module );
                $row['img_small'] = $imageinfo['src'];
            }
            $row['title1'] = nv_clean60( $row['title'], 20 );
            $xtpl->assign( 'ROW', $row );
            if ( ! empty( $row['img'] ) ) $xtpl->parse( 'main.loop.img' );
            $xtpl->parse( 'main.loop' );
        }
        $xtpl->parse( 'main' );
        return $xtpl->text( 'main' );
    }
}

if ( defined( 'NV_SYSTEM' ) )
{
	global $site_mods;
    $content = nv_albums_news($block_config);
}

?>