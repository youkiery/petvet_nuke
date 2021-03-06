<?php

/**

** @Project: NUKEVIET SUPPORT ONLINE

** @Author: Viet Group (vietgroup.biz@gmail.com)

** @Copyright: VIET GROUP

** @Craetdate: 19.08.2011

** @Website: http://vietgroup.biz

*/

if ( ! defined( 'NV_IS_FILE_ADMIN' ) ) die( 'Stop!!!' );



$id = $nv_Request->get_int( 'id', 'post,get', 0 );



if ( $id )

{

    $query = "SELECT * FROM `" . NV_PREFIXLANG . "_" . $module_data . "_group` WHERE `id`=" . $id;

    $result = $db->sql_query( $query );

    $numrows = $db->sql_numrows( $result );

    if ( empty( $numrows ) )

    {

        Header( "Location: " . NV_BASE_ADMINURL . "index.php?" . NV_NAME_VARIABLE . "=" . $module_name );

        die();

    }

    $row = $db->sql_fetchrow( $result );

    define( 'IS_EDIT', true );

    $page_title = $lang_module ['support18'];

    $action = NV_BASE_ADMINURL . "index.php?" . NV_NAME_VARIABLE . "=" . $module_name . "&amp;" . NV_OP_VARIABLE . "=" . $op . "&amp;id=" . $id;

}

else

{

    $page_title = $lang_module ['support17'];

    $action = NV_BASE_ADMINURL . "index.php?" . NV_NAME_VARIABLE . "=" . $module_name . "&amp;" . NV_OP_VARIABLE . "=" . $op;

}



$error = "";



if ( defined( 'NV_EDITOR' ) )

{

    require_once ( NV_ROOTDIR . '/' . NV_EDITORSDIR . '/' . NV_EDITOR . '/nv.php' );

}



if ( $nv_Request->get_int( 'save', 'post' ) == '1' )

{

    $title = filter_text_input( 'title', 'post', '', 1 );

    $add = filter_text_input( 'add', 'post', '', 1 );

    $phone = filter_text_input( 'phone', 'post', '', 1 );

    $fax = filter_text_input( 'fax', 'post', '', 1 );

    $email = filter_text_input( 'email', 'post', '', 1 );

    $web = filter_text_input( 'web', 'post', '', 1 );

    

    if ( empty( $title ) )

    {

        $error = $lang_module ['support14'];

    }

    else

    {

       

        if ( defined( 'IS_EDIT' ) )

        {

            $query = "UPDATE`" . NV_PREFIXLANG . "_" . $module_data . "_group` SET 

            `title` =  " . $db->dbescape( $title ) . ",

            `add` =  " . $db->dbescape( $add) . ",

            `phone` =  " . $db->dbescape( $phone ) . ",

            `fax` =  " . $db->dbescape( $fax ) . ",

            `email` =  " . $db->dbescape( $email ) . ",

            `web` =  " . $db->dbescape( $web ) . " WHERE `id` =" . $id;

        }

        else

        {

            list( $weight ) = $db->sql_fetchrow( $db->sql_query( "SELECT MAX(`weight`) FROM `" . NV_PREFIXLANG . "_" . $module_data . "_group`" ) );

            $weight = intval( $weight ) + 1;

            

            $query = "INSERT INTO `" . NV_PREFIXLANG . "_" . $module_data . "_group` VALUES (

            NULL, " . $db->dbescape( $title ) . ",

            " . $db->dbescape( $add ) . ",

            " . $db->dbescape( $phone ) . ",

            " . $db->dbescape( $fax ) . ",

            " . $db->dbescape( $email ) . ",

            " . $db->dbescape( $web ) . ",

			" . $weight . ");";

        }

        $db->sql_query( $query );

        nv_del_moduleCache( $module_name );

        if ( $db->sql_affectedrows() > 0 )

        {

            if ( defined( 'IS_EDIT' ) )

            {

                nv_insert_logs( NV_LANG_DATA, $module_name, $lang_module['log_edit_nsupport'], "nsupportid " . $id, $admin_info ['userid'] );

            }

            else

            {

                nv_insert_logs( NV_LANG_DATA, $module_name, $lang_module['log_add_nsupport'], " ", $admin_info ['userid'] );

            }

            Header( "Location: " . NV_BASE_ADMINURL . "index.php?" . NV_NAME_VARIABLE . "=" . $module_name . "&" . NV_OP_VARIABLE . "=group_main" );

            die();

        }

        else

        {

            $error = $lang_module ['support15'];

        }

    }

}

else

{

    if ( defined( 'IS_EDIT' ) )

    {

        $title = $row ['title'];

        $add= $row ['add'];

        $phone = $row ['phone'];

        $fax = $row ['fax'];

        $email = $row ['email'];

        $web = $row ['web'];

    }

    else

    {

        $title = "";

        $add = "";

        $phone = "";

        $fax = "";

        $email = "";

        $web = "";

    }

}



if ( ! empty( $error ) )

{

    $contents .= "<div class=\"quote\" style=\"width:780px;\">\n";

    $contents .= "<blockquote class=\"error\"><span>" . $error . "</span></blockquote>\n";

    $contents .= "</div>\n";

    $contents .= "<div class=\"clear\"></div>\n";

}

$j=0;

$contents .= "<form action=\"" . $action . "\" method=\"post\">\n";

$contents .= "<input name=\"save\" type=\"hidden\" value=\"1\" />\n";

$contents .= "<table class=\"tab1\" id=\"items\">\n";



$j ++;

$class = ( $j % 2 == 0 ) ? " class=\"second\"" : "";

$contents .= "<tbody" . $class . ">\n";

$contents .= "<tr>\n";

$contents .= "<td>" . $lang_module ['support04'] . ":</td>\n";

$contents .= "<td><input style=\"width:400px\" name=\"title\" id=\"idtitle\" type=\"text\" value=\"" . $title . "\" maxlength=\"255\" /></td>\n";

$contents .= "</tr>\n";

$contents .= "</tbody>\n";



$j ++;

$class = ( $j % 2 == 0 ) ? " class=\"second\"" : "";

$contents .= "<tbody" . $class . ">\n";

$contents .= "<tr>\n";

$contents .= "<td>" . $lang_module ['add'] . ":</td>\n";

$contents .= "<td><input style=\"width:400px\" name=\"add\" id=\"idadd\" type=\"text\" value=\"" . $add . "\" maxlength=\"255\" /></td>\n";

$contents .= "</tr>\n";

$contents .= "</tbody>\n";



$j ++;

$class = ( $j % 2 == 0 ) ? " class=\"second\"" : "";

$contents .= "<tbody" . $class . ">\n";

$contents .= "<tr>\n";

$contents .= "<td>" . $lang_module ['phone'] . ":</td>\n";

$contents .= "<td><input style=\"width:400px\" name=\"phone\" id=\"idphone\" type=\"text\" value=\"" . $phone . "\" maxlength=\"255\" /></td>\n";

$contents .= "</tr>\n";

$contents .= "</tbody>\n";



$j ++;

$class = ( $j % 2 == 0 ) ? " class=\"second\"" : "";

$contents .= "<tbody" . $class . ">\n";

$contents .= "<tr>\n";

$contents .= "<td>" . $lang_module ['fax'] . ":</td>\n";

$contents .= "<td><input style=\"width:400px\" name=\"fax\" id=\"idfax\" type=\"text\" value=\"" . $fax . "\" maxlength=\"255\" /></td>\n";

$contents .= "</tr>\n";

$contents .= "</tbody>\n";



$j ++;

$class = ( $j % 2 == 0 ) ? " class=\"second\"" : "";

$contents .= "<tbody" . $class . ">\n";

$contents .= "<tr>\n";

$contents .= "<td>" . $lang_module ['support06'] . ":</td>\n";

$contents .= "<td><input style=\"width:400px\" name=\"email\" id=\"idemail\" type=\"text\" value=\"" . $email . "\" maxlength=\"255\" /></td>\n";

$contents .= "</tr>\n";

$contents .= "</tbody>\n";



$j ++;

$class = ( $j % 2 == 0 ) ? " class=\"second\"" : "";

$contents .= "<tbody" . $class . ">\n";

$contents .= "<tr>\n";

$contents .= "<td>" . $lang_module ['supportweb'] . ":</td>\n";

$contents .= "<td><input style=\"width:400px\" name=\"web\" id=\"idweb\" type=\"text\" value=\"" . $web . "\" maxlength=\"255\" /></td>\n";

$contents .= "</tr>\n";

$contents .= "</tbody>\n";



$contents .= "</table>\n";



$contents .= "<br>\n";

$contents .= "<div style=\"text-align:center\"><input name=\"submit1\" type=\"submit\" value=\"" . $lang_module ['save'] . "\" /></div>\n";

$contents .= "</form>\n";



include ( NV_ROOTDIR . "/includes/header.php" );

echo nv_admin_theme( $contents );

include ( NV_ROOTDIR . "/includes/footer.php" );



?>