<?php

/**
 * @Project NUKEVIET 3.0
 * @Author VINADES.,JSC (contact@vinades.vn)
 * @Copyright (C) 2010 VINADES.,JSC. All rights reserved
 * @Createdate 2-10-2010 18:49
 */

if ( ! defined( 'NV_IS_FILE_ADMIN' ) ) die( 'Stop!!!' );

$content = filter_text_input( 'content', 'post', '',1 );
$keywords = nv_content_keywords( $content );

include ( NV_ROOTDIR . "/includes/header.php" );
echo $keywords;
include ( NV_ROOTDIR . "/includes/footer.php" );

?>