<?php
/**
** @Project: NUKEVIET SUPPORT ONLINE
** @Author: Viet Group (vietgroup.biz@gmail.com)
** @Copyright: VIET GROUP
** @Craetdate: 19.08.2011
** @Website: http://vietgroup.biz
*/

if ( ! defined( 'NV_IS_FILE_ADMIN' ) ) die( 'Stop!!!' );

$id = $nv_Request->get_int( 'id', 'post', 0 );

if ( empty( $id ) ) die( 'NO_' . $id );

$query = "SELECT * FROM `" . NV_PREFIXLANG . "_" . $module_data . "` WHERE `id`=" . $id;
$result = $db->sql_query( $query );
$numrows = $db->sql_numrows( $result );
if ( $numrows != 1 ) die( 'NO_' . $id );
nv_insert_logs( NV_LANG_DATA, $module_name, $lang_module['log_del_support'], "supportid  " . $id, $admin_info['userid'] );
$query = "DELETE FROM `" . NV_PREFIXLANG . "_" . $module_data . "` WHERE `id` = " . $id;
$db->sql_query( $query );
nv_fix_weight_sp();
if ( $db->sql_affectedrows() > 0 )
{
    nv_del_moduleCache( $module_name );
}
else
{
    die( 'NO_' . $id );
}

include ( NV_ROOTDIR . "/includes/header.php" );
echo 'OK_' . $id;
include ( NV_ROOTDIR . "/includes/footer.php" );

?>