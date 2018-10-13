<?php
if ( ! defined( 'NV_IS_MOD_ABOUT' ) ) die( 'Stop!!!' );

function nv_about_main ( $row, $ab_links )
{
    global $global_config, $module_name, $module_file, $lang_module, $module_info;
    
    $xtpl = new XTemplate( "main.tpl", NV_ROOTDIR . "/themes/" . $module_info['template'] . "/modules/" . $module_file );
    $xtpl->assign( 'LANG', $lang_module );
    $xtpl->assign( 'CONTENT', $row );
    if ( ! empty( $ab_links ) )
    {
        foreach ( $ab_links as $row )
        {
            $xtpl->assign( 'OTHER', $row );
            $xtpl->parse( 'main.other.loop' );
        }
        $xtpl->parse( 'main.other' );
    }
    $xtpl->parse( 'main' );
    return $xtpl->text( 'main' );
}

?>