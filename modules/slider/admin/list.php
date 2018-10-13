<?php

if (!defined('NV_IS_FILE_ADMIN')) die('Stop!!!');

$contents = nv_show_list();

include (NV_ROOTDIR . "/includes/header.php");
echo $contents;
include (NV_ROOTDIR . "/includes/footer.php");

?>