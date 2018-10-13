<?php
/**
 * @Project NUKEVIET 3.0
 * @Author PCD
 * @Copyright (C) 2011 VINADES., JSC. All rights reserved
 * @Createdate 3/9/2011 23:25
 */

if ( ! defined( 'NV_MAINFILE' ) ) die( 'Stop!!!' );

if ( ! nv_function_exists( 'nv_articles_top' ) )
{

    function nv_block_config_articles_top ( $module, $data_block, $lang_block )
    {
        global $db, $language_array, $site_mods;
        $mod_data = $site_mods[$module]['module_data'];
        $html = "";
        $html .= "<tr>";
        $html .= "	<td>" . $lang_block['type'] . "</td>";
        $html .= "	<td><input type=\"text\" name=\"config_type\" size=\"5\" value=\"" . $data_block['type'] . "\"/></td>";
        $html .= "<td></tr>";
        $html .= "<tr>";
        $html .= "	<td>" . $lang_block['cut'] . "</td>";
        $html .= "	<td><input type=\"text\" name=\"config_cut\" size=\"5\" value=\"" . $data_block['cut'] . "\"/></td>";
        $html .= "<td></tr>";
        return $html;
    }

    function nv_block_config_articles_top_submit ( $module, $lang_block )
    {
        global $nv_Request;
        $return = array();
        $return['error'] = array();
        $return['config'] = array();
        $return['config']['type'] = $nv_Request->get_int( 'config_type', 'post', 0 );
        $return['config']['cut'] = $nv_Request->get_int( 'config_cut', 'post', 0 );
        return $return;
    }

    function nv_articles_top ( $block_config )
    {
        global $module_info, $lang_module, $site_mods, $module_name,$db;
        $module = $block_config['module'];
        $mod_data = $site_mods[$module]['module_data'];
        $mod_file = $site_mods[$module]['module_file'];
        $order = " ID DESC ";
        if ( $block_config['type'] == "1" ) $order = " RAND() ";
        $sql = "SELECT * FROM `" . NV_PREFIXLANG . "_" . $mod_data . "` ORDER BY " . $order . " LIMIT 1 ";
        $result = $db->sql_query( $sql );
        $data = $db->sql_fetchrow( $result,2 );
        $html = "";
        $i = 1;
    	if ( $module != $module_name )
		{
			include ( NV_ROOTDIR . "/modules/" . $mod_file . "/language/".NV_LANG_DATA.".php" );
		}
        if ( ! empty( $data ) )
        {
            if ( file_exists( NV_ROOTDIR . "/themes/" . $module_info['template'] . "/modules/articles/block_top.tpl" ) )
            {
                $block_theme = $module_info['template'];
            }
            else
            {
                $block_theme = "default";
            }
            $xtpl = new XTemplate( "block_top.tpl", NV_ROOTDIR . "/themes/" . $block_theme . "/modules/articles" );
			$xtpl->assign( 'LANG', $lang_module );
            $data['link'] = NV_BASE_SITEURL . "index.php?" . NV_LANG_VARIABLE . "=" . NV_LANG_DATA . "&amp;" . NV_NAME_VARIABLE . "=" . $module . "&amp;" . NV_OP_VARIABLE . "=" . $data['alias'] . "-" . $data['id'] . "";
            $data['add_time'] = nv_date( "l - d/m/Y  H:i", $data['add_time'] );
            $data['hometext'] = nv_clean60( $data['hometext'], $block_config['cut'] );
            if ( ! empty( $data['homefileimg'] ) )
            {
                $imageinfo = nv_ImageInfo( NV_ROOTDIR . '/' . NV_UPLOADS_DIR . '/' . $module . '/' . $data['homefileimg'], 120, true, NV_ROOTDIR . '/' . NV_FILES_DIR . '/' . $module );
                $data['src'] = $imageinfo['src'];
            }
            $xtpl->assign( 'ROW', $data );
            if ( ! empty( $data['homefileimg'] ) && file_exists( NV_ROOTDIR . '/' . NV_UPLOADS_DIR . '/' . $module . '/' . $data['homefileimg'] ) )
            {
                $xtpl->parse( 'main.img' );
            }
            $xtpl->parse( 'main' );;
            return $xtpl->text( 'main' );
        }
        return "";
    }
}

if ( defined( 'NV_SYSTEM' ) )
{
    global $site_mods, $module_name;
    $module = $block_config['module'];
    $content = nv_articles_top( $block_config );
}

?>