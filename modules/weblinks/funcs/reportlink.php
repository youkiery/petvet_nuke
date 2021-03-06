<?php

/**
 * @project nukeviet 3.0
 * @author vinades.,jsc (contact@vinades.vn)
 * @copyright (c) 2010 vinades., jsc. all rights reserved
 * @createdate 3-6-2010 0:14
 */

if ( ! defined( 'NV_IS_MOD_WEBLINKS' ) ) die( 'Stop!!!' );

global $client_info, $lang_module, $my_head;

$submit = $nv_Request->get_string( 'submit', 'post' );
$report_id = $nv_Request->get_int( 'report_id', 'post' );
$id = ( $id == 0 ) ? $report_id : $id;

$sql = "SELECT `title`, `alias` FROM `" . NV_PREFIXLANG . "_" . $module_data . "_rows` WHERE id='" . $id . "'";

$result = $db->sql_query( $sql );
$row = $db->sql_fetchrow( $result );
unset( $sql, $result );
$row['error'] = "";
$row['action'] = "" . NV_BASE_SITEURL . "index.php?" . NV_LANG_VARIABLE . "=" . NV_LANG_DATA . "&amp;" . NV_NAME_VARIABLE . "=" . $module_name . "&amp;op=reportlink-" . $row['alias'] . "-" . $id . "";
$row['id'] = $id;
if ( $id )
{
	$check = false;
    if ( $submit && $report_id )
    {
        $sql = "SELECT `type` FROM `" . NV_PREFIXLANG . "_" . $module_data . "_report` WHERE id='" . $report_id . "'";
        $result = $db->sql_query( $sql );
        $rows = $db->sql_fetchrow( $result );
        $report = $nv_Request->get_int( 'report', 'post' );
        $report_note = filter_text_input( 'report_note', 'post', '', 1, 255 );
        $row['report_note'] = $report_note;
        if ( $report == 0 && empty( $report_note ) )
        {
            $row['error'] = $lang_module['error'];
        
        }
        elseif ( ! empty( $report_note ) && strlen( $report_note ) < 10 )
        {
            $row['error'] = $lang_module['error_word_min'];
        }
        elseif ( $rows['type'] == $report )
        {
            $check = TRUE;
        }
        else
        {
            $report_note = nv_nl2br( $report_note );
            $sql = "INSERT INTO " . NV_PREFIXLANG . "_" . $module_data . "_report (`id`,`type`,`report_time`,`report_userid`,`report_ip`,`report_browse_key`,`report_browse_name`,`report_os_key`,`report_os_name`,`report_note`) 
                                                                       VALUE ('" . $report_id . "', '" . $report . "', UNIX_TIMESTAMP(), '0', " . $db->dbescape_string( $client_info['ip'] ) . ", " . $db->dbescape_string( $client_info['browser']['key'] ) . ", " . $db->dbescape_string( $client_info['browser']['name'] ) . ", " . $db->dbescape_string( $client_info['client_os']['key'] ) . ", " . $db->dbescape_string( $client_info['client_os']['name'] ) . ", " . $db->dbescape_string( $report_note ) . ")";
            $check = $db->sql_query( $sql );
        }
    }
    
    $contents = call_user_func( "report", $row, $check );
}
else
{
    die( "you don't permission to access!!!" );
    exit();
}

?>