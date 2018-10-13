<?php

/**
 * @Project VINAGON - HOTDEAL 1.1.0
 * @Author VINAGON.COM (info@vinagon.com)
 * @Copyright (C) 2012 VINAGON.COM. All rights reserved
 * @Createdate Sat, 08 Aug 2013 02:59:43 GMT
 */

if( ! defined( 'NV_IS_MOD_SHOPS' ) ) die( 'Stop!!!' );

$data = array( 
	"id" => 0 , "email" => "" , "addtime"=> NV_CURRENTTIME
);
$msg = "Không có e-mail";
if ( $nv_Request->get_int( 'emailsave', 'post,get' ) == 1 )
{
	$email = $nv_Request->get_string( 'email', 'post,get', '' ); 
	$error = nv_check_valid_email( $email ); 
	if ( !empty( $email ) && empty( $error ) )
    {
		//insert data
		$query = "INSERT INTO `" . $db_config['prefix'] . "_" . $module_data . "_email` (`id`, `email`, `addtime`)
				  VALUES (NULL, " . $db->dbescape( $email ) .",". $db->dbescape( $data['addtime'] ) . " )";
		$newid = intval( $db->sql_query_insert_id( $query ) );
		if ( $newid > 0 )
		{
			$msg = "Đã đăng ký thành công. xin trân thành cảm ơn!";
		}
		else
		{
			$msg = "E-mail này đã đăng ký rồi. Bạn hãy đăng ký e-mail khác";
		}
		$db->sql_freeresult();
	}
	else
	{
		$msg = $error;
	}
}
echo $msg;
die();

?>