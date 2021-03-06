<?php

/**
 * @Project NUKEVIET 3.0
 * @Author VINADES.,JSC (contact@vinades.vn)
 * @Copyright (C) 2010 VINADES.,JSC. All rights reserved
 * @Createdate 2-9-2010 14:43
 */

if ( ! defined( 'NV_ADMIN' ) or ! defined( 'NV_MAINFILE' ) or ! defined( 'NV_IS_MODADMIN' ) ) die( 'Stop!!!' );

$ini = nv_parse_ini_file( NV_ROOTDIR . '/includes/ini/mime.ini', true );

$myini = array( //
    'types' => array( '' ), //
    'exts' => array( '' ), //
    'mimes' => array( '' ) //
    );

foreach ( $ini as $type => $extmime )
{
    $myini['types'][] = $type;
    $myini['exts'] = array_merge( $myini['exts'], array_keys( $extmime ) );
    $m = array_values( $extmime );
    if ( is_string( $m ) ) $myini['mimes'] = array_merge( $myini['mimes'], $m );
    else
    {
        foreach ( $m as $m2 )
        {
            if ( ! is_array( $m2 ) ) $m2 = array( $m2 );
            $myini['mimes'] = array_merge( $myini['mimes'], $m2 );
        }
    }
}

sort( $myini['types'] );
unset( $myini['types'][0] );
sort( $myini['exts'] );
unset( $myini['exts'][0] );
$myini['mimes'] = array_unique( $myini['mimes'] );
sort( $myini['mimes'] );
unset( $myini['mimes'][0] );

if ( $nv_Request->isset_request( 'submit', 'post' ) )
{
    $type = $nv_Request->get_typed_array( 'type', 'post', 'int' );
    $type = array_flip( $type );
    $type = array_intersect_key( $myini['types'], $type );
    $type = implode( ',', $type );

    $ext = $nv_Request->get_typed_array( 'ext', 'post', 'int' );
    $ext = array_flip( $ext );
    $ext = array_intersect_key( $myini['exts'], $ext );
    $ext[] = "php";
    $ext[] = "php3";
    $ext[] = "php4";
    $ext[] = "php5";
    $ext[] = "phtml";
    $ext[] = "inc";
    $ext = array_unique( $ext );
    $ext = implode( ',', $ext );

    $mime = $nv_Request->get_typed_array( 'mime', 'post', 'int' );
    $mime = array_flip( $mime );
    $mime = array_intersect_key( $myini['mimes'], $mime );
    $mime = implode( ',', $mime );

    $upload_checking_mode = $nv_Request->get_string( 'upload_checking_mode', 'post', '' );
    if ( $upload_checking_mode != "mild" and $upload_checking_mode != "lite" and $upload_checking_mode != "strong" ) $upload_checking_mode = "none";

    $nv_max_size = $nv_Request->get_int( 'nv_max_size', 'post', $global_config['nv_max_size'] );
    $nv_max_size = min( nv_converttoBytes( ini_get( 'upload_max_filesize' ) ), nv_converttoBytes( ini_get( 'post_max_size' ) ), $nv_max_size );

    $db->sql_query( "REPLACE INTO `" . NV_CONFIG_GLOBALTABLE . "` (`lang`, `module`, `config_name`, `config_value`) VALUES ('sys', 'global', 'file_allowed_ext', " . $db->dbescape_string( $type ) . ")" );
    $db->sql_query( "REPLACE INTO `" . NV_CONFIG_GLOBALTABLE . "` (`lang`, `module`, `config_name`, `config_value`) VALUES ('sys', 'global', 'forbid_extensions', " . $db->dbescape_string( $ext ) . ")" );
    $db->sql_query( "REPLACE INTO `" . NV_CONFIG_GLOBALTABLE . "` (`lang`, `module`, `config_name`, `config_value`) VALUES ('sys', 'global', 'forbid_mimes', " . $db->dbescape_string( $mime ) . ")" );
    $db->sql_query( "REPLACE INTO `" . NV_CONFIG_GLOBALTABLE . "` (`lang`, `module`, `config_name`, `config_value`) VALUES ('sys', 'global', 'nv_max_size', " . $db->dbescape_string( $nv_max_size ) . ")" );
    $db->sql_query( "REPLACE INTO `" . NV_CONFIG_GLOBALTABLE . "` (`lang`, `module`, `config_name`, `config_value`) VALUES ('sys', 'global', 'upload_checking_mode', " . $db->dbescape_string( $upload_checking_mode ) . ")" );

    nv_save_file_config_global();

    Header( 'Location: ' . NV_BASE_ADMINURL . 'index.php?' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=' . $op . '&rand=' . nv_genpass() );
    die();
}

$page_title = $lang_module['uploadconfig'];

$contents = "<form action=\"\" method=\"post\">\n";
$contents .= "<table class=\"tab1\" style=\"auto\">\n";
$contents .= "<tbody class=\"second\">\n";
$contents .= "<tr>\n";
$contents .= "<td colspan=\"2\"><strong>" . $lang_module['uploadconfig'] . "</strong></td>\n";
$contents .= "</tr>\n";
$contents .= "</tbody>";
$contents .= "<tbody>";
$contents .= "<tr>";
$contents .= "<td align=\"right\"><strong>" . $lang_module['nv_max_size'] . ":</strong> </td>\n";
$contents .= "<td>";
$contents .= "<select name=\"nv_max_size\">\n";
$sys_max_size = min( nv_converttoBytes( ini_get( 'upload_max_filesize' ) ), nv_converttoBytes( ini_get( 'post_max_size' ) ) );
$p_size = $sys_max_size / 100;
for ( $index = 100; $index > 0; $index-- )
{
    $size = floor( $index * $p_size );
    $sl = ( $size == $global_config['nv_max_size'] ) ? " selected=\"selected\"" : "";
    $contents .= "<option value=\"" . $size . "\"" . $sl . ">" . nv_convertfromBytes( $size ) . "</option>\n";
}
$contents .= "</select> \n";
$contents .= " (" . $lang_module['sys_max_size'] . ": " . nv_convertfromBytes( $sys_max_size ) . ")";
$contents .= "</td>";
$contents .= "</tr>";
$contents .= "</tbody>";

$contents .= "<tbody class=\"second\">";
$contents .= "<tr>";
$contents .= "<td align=\"right\"><strong>" . $lang_module['upload_checking_mode'] . ":</strong> </td>\n";
$contents .= "<td>";
$contents .= "<select name=\"upload_checking_mode\">\n";
$_upload_checking_mode = array( 'strong' => $lang_module['strong_mode'], 'mild' => $lang_module['mild_mode'], 'lite' => $lang_module['lite_mode'], 'none' => $lang_module['none_mode'] );
foreach ( $_upload_checking_mode as $m => $n )
{
    $sl = ( $m == $global_config['upload_checking_mode'] ) ? " selected=\"selected\"" : "";
    $contents .= "<option value=\"" . $m . "\"" . $sl . ">" . $n . "</option>\n";
}
$contents .= "</select>\n";

$strong = false;
if ( nv_function_exists( 'finfo_open' ) //
    or nv_class_exists( "finfo" ) //
    or nv_function_exists( 'mime_content_type' ) //
    or ( substr( $sys_info['os'], 0, 3 ) != 'WIN' and ( nv_function_exists( 'system' ) or nv_function_exists( 'exec' ) ) ) //
    )
{
    $strong = true;
}

if ( ! $strong )
{
    $contents .= " " . $lang_module['upload_checking_note'];
}

$contents .= "</td>";
$contents .= "</tr>";
$contents .= "</tbody>";

$contents .= "<tbody>\n";
$contents .= "<tr>\n";
$contents .= "<td style=\"width:200px\"><strong>" . $lang_module['uploadconfig_types'] . "</strong></td>\n";
$contents .= "<td>";
foreach ( $myini['types'] as $key => $name )
{
    $contents .= "<label style=\"display:inline-block;width:100px\"><input type=\"checkbox\" name=\"type[]\" value=\"" . $key . "\"" . ( in_array( $name, $global_config['file_allowed_ext'] ) ? ' checked="checked"' : '' ) . " /> " . $name . "&nbsp;&nbsp;</label>\n";
}
$contents .= "</td>\n";
$contents .= "</tr>\n";
$contents .= "</tbody>\n";
$contents .= "<tbody class=\"second\">\n";
$contents .= "<tr>\n";
$contents .= "<td style=\"vertical-align:top\"><strong>" . $lang_module['uploadconfig_ban_ext'] . "</strong></td>\n";
$contents .= "<td>";
foreach ( $myini['exts'] as $key => $name )
{
    $contents .= "<label style=\"display:inline-block;width:100px\"><input type=\"checkbox\" name=\"ext[]\" value=\"" . $key . "\"" . ( in_array( $name, $global_config['forbid_extensions'] ) ? ' checked="checked"' : '' ) . " /> " . $name . "&nbsp;&nbsp;</label>\n";
}
$contents .= "</td>\n";
$contents .= "</tr>\n";
$contents .= "</tbody>\n";

$contents .= "<tbody>\n";
$contents .= "<tr>\n";
$contents .= "<td style=\"vertical-align:top\"><strong>" . $lang_module['uploadconfig_ban_mime'] . "</strong></td>\n";
$contents .= "<td>";
foreach ( $myini['mimes'] as $key => $name )
{
    $contents .= "<label style=\"display:inline-block;width:300px\"><input type=\"checkbox\" name=\"mime[]\" value=\"" . $key . "\"" . ( in_array( $name, $global_config['forbid_mimes'] ) ? ' checked="checked"' : '' ) . " /> " . $name . "&nbsp;&nbsp;</label>\n";
}
$contents .= "</td>\n";
$contents .= "</tr>\n";
$contents .= "</tbody>\n";

$contents .= "<tbody class=\"second\">\n";
$contents .= "<tr>\n";
$contents .= "<td colspan=\"2\" style=\"text-align:center\">";
$contents .= "<input type=\"submit\" value=\"" . $lang_module['banip_confirm'] . "\" name=\"submit\"/>\n";
$contents .= "</td>\n";
$contents .= "</tr>\n";
$contents .= "</tbody>\n";
$contents .= "</table>\n";
$contents .= "</form>\n";

include ( NV_ROOTDIR . "/includes/header.php" );
echo nv_admin_theme( $contents );
include ( NV_ROOTDIR . "/includes/footer.php" );

?>