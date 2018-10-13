<?php

if ( ! defined( 'NV_IS_FILE_ADMIN' ) ) die( 'Stop!!!' );

$id = $nv_Request->get_int( 'id', 'post', 0 );
if ( empty( $id ) ) die( "NO_" . $id );

$query = "SELECT * FROM `" . NV_PREFIXLANG . "_" . $module_data . "` WHERE `id`=" . $id;
$result = $db->sql_query( $query );

$num = $db->sql_numrows( $result );
if ( $num != 1 ) die( 'NO_' . $id );
$row_old = $db->sql_fetchrow( $result ); 

$idgroup = $nv_Request -> get_int('idgroup', 'post', 0);
$new_weight = $nv_Request->get_int( 'new_weight', 'post', 0 );

if ( empty( $new_weight ) ) die( 'NO_' . $mod );

$query = "SELECT * FROM `" . NV_PREFIXLANG . "_" . $module_data . "` WHERE `weight`=" . $new_weight . " AND `idgroup`=" . $row_old['idgroup'] . "";
$result = $db->sql_query( $query );  

$row_new = $db->sql_fetchrow( $result );


$sql = "UPDATE `" . NV_PREFIXLANG . "_" . $module_data . "` SET `weight`=" . $new_weight . " WHERE `id`=" . $row_old['id'];
$db->sql_query( $sql );


$sql = "UPDATE `" . NV_PREFIXLANG . "_" . $module_data . "` SET `weight`=" . $row_old['weight'] . " WHERE `id`=" . $row_new['id'];
$db->sql_query( $sql );

nv_del_moduleCache( $module_name );
include ( NV_ROOTDIR . "/includes/header.php" );
echo 'OK_' . $id . "_" . $idgroup;
include ( NV_ROOTDIR . "/includes/footer.php" );

?>