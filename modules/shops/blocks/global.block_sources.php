<?php
/**
 * @Project NUKEVIET 3.0
 * @Author VINADES.,JSC (contact@vinades.vn)
 * @Copyright (C) 2010 VINADES., JSC. All rights reserved
 * @Createdate 3/9/2010 23:25
 */

if ( ! defined( 'NV_MAINFILE' ) ) die( 'Stop!!!' );

if ( ! function_exists( 'nv_sources' ) )
{

    function nv_block_config_sources_blocks ( $module, $data_block, $lang_block )
    {
        global $db, $language_array, $db_config;
        $html = "";
        $html .= "<tr>";
        $html .= "	<td>" . $lang_block['numrow'] . "</td>";
        $html .= "	<td><input type=\"text\" name=\"config_numrow\" size=\"5\" value=\"" . $data_block['numrow'] . "\"/></td>";
        $html .= "</tr>";
        return $html;
    }

    function nv_block_config_sources_blocks_submit ( $module, $lang_block )
    {
        global $nv_Request;
        $return = array();
        $return['error'] = array();
        $return['config'] = array();
        $return['config']['numrow'] = $nv_Request->get_int( 'config_numrow', 'post', 0 );
        return $return;
    }

    function nv_sources ( $block_config )
    {
        global $site_mods, $db_config, $db, $global_array_group, $module_name, $module_info, $catid,$array_op,$global_array_cat;
        $module = $block_config['module'];
        $mod_data = $site_mods[$module]['module_data'];
        $mod_file = $site_mods[$module]['module_file'];
		$array_th = array();

		$sql = "SELECT * FROM `" . $db_config['prefix'] . "_" . $mod_data . "_sources` ORDER BY RAND() LIMIT 0 , " . $block_config['numrow'];
		
		$list = nv_db_cache( $sql, 'sources', $module_name );
		foreach ( $list as $row )
		{
			$row['link'] = NV_BASE_SITEURL . "index.php?" . NV_LANG_VARIABLE . "=" . NV_LANG_DATA . "&amp;" . NV_NAME_VARIABLE . "=" . $module_name . "&amp;" . NV_OP_VARIABLE . "=".$row['vi_alias'];
			$array_th[] = array('sourceid' => $row['sourceid'], 'link' => $row['link'], 'logo' => $row['logo'], 'weight' => $row['weight'], 'add_time' => $row['add_time'], 'edit_time' => $row['edit_time'], 'title' => $row['vi_title']);
		}
        if ( file_exists( NV_ROOTDIR . "/themes/" . $module_info['template'] . "/modules/" . $mod_file . "/block.sources.tpl" ) )
        {
            $block_theme = $module_info['template'];
        }
        else
        {
            $block_theme = "default";
        }
        $xtpl = new XTemplate( "block.sources.tpl", NV_ROOTDIR . "/themes/" . $block_theme . "/modules/" . $mod_file );
       // print_r($array_th);die();
		foreach ($array_th as $row) {
			if ( ! empty( $row['logo'] ) )
			{
			    $row['logo'] = NV_BASE_SITEURL . NV_UPLOADS_DIR . "/shops/source/" . $row['logo'];
			}
			$xtpl -> assign('ROW', $row);
			$xtpl -> parse('main.loop');
		}
        $xtpl->parse( 'main' );
        return $xtpl->text( 'main' );
    }
}
if ( defined( 'NV_SYSTEM' ) )
{
    global $site_mods, $global_array_group, $module_name;
    $content = nv_sources( $block_config );
}

?>