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
if ( empty( $id ) ) die( "NO_" . $id );

$query = "SELECT `weight` FROM `" . NV_PREFIXLANG . "_" . $module_data . "_group` WHERE `id`=" . $id;
$result = $db->sql_query( $query );
$numrows = $db->sql_numrows( $result );
if ( $numrows != 1 ) die( 'NO_' . $id );

$new_weight = $nv_Request->get_int( 'new_weight', 'post', 0 );
if ( empty( $new_weight ) ) die( 'NO_' . $mod );

$query = "SELECT `id` FROM `" . NV_PREFIXLANG . "_" . $module_data . "_group` WHERE `id`!=" . $id . " ORDER BY `weight` ASC";
$result = $db->sql_query( $query );
$weight = 0;
while ( $row = $db->sql_fetchrow( $result ) )
{
    $weight++;
    if ( $weight == $new_weight ) $weight++;
    $sql = "UPDATE `" . NV_PREFIXLANG . "_" . $module_data . "_group` SET `weight`=" . $weight . " WHERE `id`=" . $row['id'];
    $db->sql_query( $sql );
}

$sql = "UPDATE `" . NV_PREFIXLANG . "_" . $module_data . "_group` SET `weight`=" . $new_weight . " WHERE `id`=" . $id;
$db->sql_query( $sql );
nv_del_moduleCache( $module_name );
include ( NV_ROOTDIR . "/includes/header.php" );
echo 'OK_' . $id;
include ( NV_ROOTDIR . "/includes/footer.php" );

?>