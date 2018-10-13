<?php

/**

** @Project: NUKEVIET SUPPORT ONLINE

** @Author: Viet Group (vietgroup.biz@gmail.com)

** @Copyright: VIET GROUP

** @Craetdate: 19.08.2011

** @Website: http://vietgroup.biz

*/



if ( ! defined( 'NV_MAINFILE' ) ) die( 'Stop!!!' );



if ( ! nv_function_exists( 'nv_global_shareinternet' ) )

{

    function nv_global_shareinternet ( )

	{

        global $global_config, $lang_global, $db;

	if ( file_exists( NV_ROOTDIR . "/themes/" . $global_config['site_theme'] . "/modules/shareinternet/global_share.tpl" ) )

		{

			$block_theme = $global_config['site_theme'];

		}

		else

		{

			$block_theme = "default";

		}

	$xtpl = new XTemplate( "global_share.tpl", NV_ROOTDIR . "/themes/" . $block_theme . "/modules/shareinternet" );

    $xtpl->assign( 'TEMPLATE', $block_theme );

    $xtpl->assign( 'LANG', $lang_global );

    $base_url_site = NV_BASE_SITEURL . "?";

    $res_tr = $db->sql_query("SELECT * FROM `" . NV_PREFIXLANG . "_shareinternet_group` ORDER BY `weight`");

    	while($rows = $db->sql_fetchrow($res_tr))

	{

		$id=$rows['id'];

		$res = $db->sql_query("SELECT * FROM `" . NV_PREFIXLANG . "_shareinternet` where idgroup='$id' ORDER BY `weight` ASC");

		while ($row = $db->sql_fetchrow($res)) {

		    $yahoo_item_sub = trim($row['yahoo_item']);

		    $yahoo_type_sub = trim($row['yahoo_type']);

		    $xtpl->assign( 'ADD', $rows['add'] );

		    $xtpl->assign( 'PHONE', $rows['phone'] );

		    $xtpl->assign( 'FAX', $rows['fax'] );

		    $xtpl->assign( 'EMAIL', $rows['email'] );

		    $xtpl->assign( 'WEB', $rows['web'] );

		    $xtpl->assign( 'YHITEM', $yahoo_item_sub );

		    $xtpl->assign( 'YHTYPE', $yahoo_type_sub );	

		    $xtpl->assign( 'SHARENAME', $row['title'] );

		    $xtpl->assign( 'GROUP_SHARE', $rows['title'] );	

            $xtpl->parse( 'main.loop' );

		}

	}

    $xtpl->parse( 'main' );

    return $xtpl->text( 'main' );

	}

}



if ( defined( 'NV_SYSTEM' ) )

{

    $content = nv_global_shareinternet( );

}



?>