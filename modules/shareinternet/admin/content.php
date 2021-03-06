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
    $query = "SELECT * FROM `" . NV_PREFIXLANG . "_" . $module_data . "` WHERE `id`=" . $id;
    $result = $db->sql_query( $query );
    $numrows = $db->sql_numrows( $result );
    if ( empty( $numrows ) )
    {
        Header( "Location: " . NV_BASE_ADMINURL . "index.php?" . NV_NAME_VARIABLE . "=" . $module_name );
        die();
    }
    $row = $db->sql_fetchrow( $result );
    define( 'IS_EDIT', true );
    $page_title = $lang_module ['support11'];
    $action = NV_BASE_ADMINURL . "index.php?" . NV_NAME_VARIABLE . "=" . $module_name . "&amp;" . NV_OP_VARIABLE . "=" . $op . "&amp;id=" . $id;
}
else
{
    $page_title = $lang_module ['support10'];
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
    $idgroup = filter_text_input( 'idgroup', 'post', '', 1 );
    $phone = filter_text_input( 'phone', 'post', '', 1 );
    $email = filter_text_input( 'email', 'post', '', 1 );
    $yahoo_item = filter_text_input( 'yahoo_item', 'post', '', 1 );
    $yahoo_type = filter_text_input( 'yahoo_type', 'post', '', 1 );
	if ( empty( $title ) )
    {
        $error = $lang_module ['support14'];
    } else {
       
        if ( defined( 'IS_EDIT' ) )
        {
            $query = "UPDATE`" . NV_PREFIXLANG . "_" . $module_data . "` SET 
            `idgroup` =  " . $db->dbescape( $idgroup ) . ", 
			`title`=" . $db->dbescape( $title ) . ", 			
            `phone`=" . $db->dbescape( $phone ) . ", 
			`email`=" . $db->dbescape( $email ) . ", 
			`yahoo_item`=" . $db->dbescape( $yahoo_item ) . ", 
			`yahoo_type`=" . $db->dbescape( $yahoo_type ) . " 
			WHERE `id` =" . $id;
        }
        else
        {
            list( $weight ) = $db->sql_fetchrow( $db->sql_query( "SELECT MAX(`weight`) FROM `" . NV_PREFIXLANG . "_" . $module_data . "`" ) );
            $weight = intval( $weight ) + 1;
            
            $query = "INSERT INTO `" . NV_PREFIXLANG . "_" . $module_data . "` VALUES (
            NULL, 			
			" . $db->dbescape( $idgroup ) . ",
			" . $db->dbescape( $title ) . ",
			" . $db->dbescape( $phone ) . ",
			" . $db->dbescape( $email ) . ", 
			" . $db->dbescape( $yahoo_item ) . ", 
			" . $db->dbescape( $yahoo_type ) . ", 
			" . $weight . ");";
        }
        $db->sql_query( $query );
        nv_del_moduleCache( $module_name );
        if ( $db->sql_affectedrows() > 0 )
        {
            if ( defined( 'IS_EDIT' ) )
            {
                nv_insert_logs( NV_LANG_DATA, $module_name, $lang_module['log_edit_support'], "supportid " . $id, $admin_info ['userid'] );
            }
            else
            {
                nv_insert_logs( NV_LANG_DATA, $module_name, $lang_module['log_add_support'], " ", $admin_info ['userid'] );
            }
            Header( "Location: " . NV_BASE_ADMINURL . "index.php?" . NV_NAME_VARIABLE . "=" . $module_name . "&" . NV_OP_VARIABLE . "=main" );
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
        $idgroup = $row ['idgroup'];
        $phone = $row ['phone'];
        $email = $row ['email'];
        $yahoo_item = $row ['yahoo_item'];
        $yahoo_type = $row ['yahoo_type'];
    }
    else
    {
        $title = $idgroup =$phone =$email = $yahoo_item = $yahoo_type = "";
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
$contents .= "<td>" . $lang_module ['support03'] . ":</td>\n";
$contents .= "<td><input style=\"width:400px\" name=\"title\" id=\"idtitle\" type=\"text\" value=\"" . $title . "\" maxlength=\"255\" /></td>\n";
$contents .= "</tr>\n";
$contents .= "</tbody>\n";

$j ++;
$class = ( $j % 2 == 0 ) ? " class=\"second\"" : "";
$contents .= "<tbody" . $class . ">\n";
$contents .= "<tr>\n";
$contents .= "<td>" . $lang_module ['support04'] . ":</td>\n";
$contents .= "<td>\n";
	$contents .= "<select name=\"idgroup\">\n";
	$sqls = "SELECT * FROM `" . NV_PREFIXLANG . "_" . $module_data . "_group`";
	$results = $db->sql_query( $sqls );
	while ($rows = mysql_fetch_array($results)){
			if($rows['id'] == $idgroup){$checkselect = "selected";}else{$checkselect = "";}
	$contents .= "<option value=\"".$rows['id']."\" " . $checkselect . ">".$rows['title']."</option>";
	}
	$contents .= "</select>\n";
$contents .= "</td>\n";
$contents .= "</tr>\n";
$contents .= "</tbody>\n";

$j ++;
$class = ( $j % 2 == 0 ) ? " class=\"second\"" : "";
$contents .= "<tbody" . $class . ">\n";
$contents .= "<tr>\n";
$contents .= "<td>" . $lang_module ['support07'] . ":</td>\n";
$contents .= "<td><input style=\"width:400px\" name=\"yahoo_item\" id=\"idyahoo_item\" type=\"text\" value=\"" . $yahoo_item . "\" maxlength=\"255\" /></td>\n";
$contents .= "</tr>\n";
$contents .= "</tbody>\n";

$j ++;
$class = ( $j % 2 == 0 ) ? " class=\"second\"" : "";
$contents .= "<tbody" . $class . ">\n";
$contents .= "<tr>\n";
$contents .= "<td>" . $lang_module ['support12'] . ":</td>\n";
$contents .= "<td><input style=\"width:400px\" name=\"yahoo_type\" id=\"idyahoo_type\" type=\"text\" value=\"" . $yahoo_type . "\" maxlength=\"255\" /><input type=\"button\" name=\"selecticon\" value=\"Browse server\"></td>\n";
$contents .= "</tr>\n";
$contents .= "</tbody>\n";

$contents .= "</table>\n";

$contents .= "<br>\n";
$contents .= "<div style=\"text-align:center\"><input name=\"submit1\" type=\"submit\" value=\"" . $lang_module ['save'] . "\" /></div>\n";
$contents .= "</form>\n";

$contents .=' <script type="text/javascript">
//<![CDATA[
	$("input[name=selecticon]").click(function(){
		var area = "idyahoo_type";
		var path= "uploads/' . $module_name . '";	
		var currentpath= "uploads/' . $module_name . '";						
		var type= "image";
		nv_open_browse_file(script_name + "?" + nv_name_variable + "=upload&popup=1&area=" + area+"&path="+path+"&type="+type+"&currentpath="+currentpath, "NVImg", "850", "420","resizable=no,scrollbars=no,toolbar=no,location=no,status=no");
		return false;
	});
</script>
';

include ( NV_ROOTDIR . "/includes/header.php" );
echo nv_admin_theme( $contents );
include ( NV_ROOTDIR . "/includes/footer.php" );

?>