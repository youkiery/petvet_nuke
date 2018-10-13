<?php

/**
 * @Project NUKEVIET 3.0
 * @Author VINADES.,JSC (contact@vinades.vn)
 * @Copyright (C) 2010 VINADES., JSC. All rights reserved
 * @Createdate 3-6-2010 0:14
 */
if (! defined ( 'NV_IS_MOD_SHOPS' ))
	die ( 'Stop!!!' );
$_SESSION['sort'] = $nv_Request->get_int( 'sort', 'get,post', 0 );
$contents = $_SESSION['sort'];

echo $contents;

?>