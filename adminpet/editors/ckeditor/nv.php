<?php

/**
 * @Project NUKEVIET 3.0
 * @Author VINADES.,JSC (contact@vinades.vn)
 * @Copyright (C) 2010 VINADES.,JSC. All rights reserved
 * @Createdate Apr 10, 2010  10:08:08 AM
 */

if ( ! defined( 'NV_MAINFILE' ) ) die( 'Stop!!!' );

@require_once ( str_replace( '\\\\', '/', dirname( __file__ ) ) . '/ckeditor_php5.php' );

/**
 * nv_aleditor()
 * 
 * @param mixed $textareaname
 * @param string $width
 * @param string $height
 * @param string $val
 * @return
 */

function nv_aleditor ( $textareaname, $width = "100%", $height = '450px', $val = '', $path = '', $currentpath = '' )
{
    global $module_name, $admin_info;
    if ( empty( $path ) and empty( $currentpath ) )
    {
        $path = NV_UPLOADS_DIR;
        $currentpath = NV_UPLOADS_DIR;
        if ( ! empty( $module_name ) and file_exists( NV_UPLOADS_REAL_DIR . '/' . $module_name . '/' . date( "Y_m" ) ) )
        {
            $currentpath = NV_UPLOADS_DIR . '/' . $module_name . '/' . date( "Y_m" );
            $path = NV_UPLOADS_DIR . '/' . $module_name;
        }
        elseif ( ! empty( $module_name ) and file_exists( NV_UPLOADS_REAL_DIR . '/' . $module_name ) )
        {
            $currentpath = NV_UPLOADS_DIR . '/' . $module_name;
        }
    }
    // Create class instance.
    $editortoolbar = array( array( 'Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord', '-', 'Undo', 'Redo', '-', 'Link', 'Unlink', 'Anchor', '-', 'Image', 'Flash', 'jwplayer', 'Table', 'Font', 'FontSize', 'RemoveFormat', 'Templates', 'Maximize' ), array( 'Bold', 'Italic', 'Underline', 'Strike', '-', 'Subscript', 'Superscript', '-', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock', 'NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', 'Blockquote', 'CreateDiv', '-', 'TextColor', 'BGColor', 'SpecialChar', 'Smiley', 'PageBreak', 'Source', 'About' ) );
    
    $CKEditor = new CKEditor();
    // Do not print the code directly to the browser, return it instead
    $CKEditor->returnOutput = true;
    $CKEditor->config['extraPlugins'] = 'jwplayer';
    $CKEditor->config['skin'] = 'v2';
    $CKEditor->config['entities'] = false;
    $CKEditor->config['enterMode'] = 2;
    $CKEditor->config['language'] = NV_LANG_INTERFACE;
    $CKEditor->config['toolbar'] = $editortoolbar;
    $CKEditor->config['pasteFromWordRemoveFontStyles'] = true;
    
    // Path to CKEditor directory, ideally instead of relative dir, use an absolute path:
    //   $CKEditor->basePath = '/ckeditor/'
    // If not set, CKEditor will try to detect the correct path.
    $CKEditor->basePath = NV_BASE_SITEURL . '' . NV_EDITORSDIR . '/ckeditor/';
    // Set global configuration (will be used by all instances of CKEditor).
    if ( ! empty( $width ) )
    {
        $CKEditor->config['width'] = strpos( $width, '%' ) ? $width : intval( $width );
    }
    
    if ( ! empty( $height ) )
    {
        $CKEditor->config['height'] = strpos( $height, '%' ) ? $height : intval( $height );
    }
    
    // Change default textarea attributes
    $CKEditor->textareaAttributes = array( "cols" => 80, "rows" => 10 );
    
    $CKEditor->config['filebrowserBrowseUrl'] = NV_BASE_SITEURL . NV_ADMINDIR . "/index.php?nv=upload&popup=1&path=" . $path . "&currentpath=" . $currentpath;
    $CKEditor->config['filebrowserImageBrowseUrl'] = NV_BASE_SITEURL . NV_ADMINDIR . "/index.php?nv=upload&popup=1&type=image&path=" . $path . "&currentpath=" . $currentpath;
    $CKEditor->config['filebrowserFlashBrowseUrl'] = NV_BASE_SITEURL . NV_ADMINDIR . "/index.php?nv=upload&popup=1&type=flash&path=" . $path . "&currentpath=" . $currentpath;
    if ( ! empty( $admin_info['allow_files_type'] ) )
    {
        $CKEditor->config['filebrowserUploadUrl'] = NV_BASE_SITEURL . NV_ADMINDIR . "/index.php?nv=upload&" . NV_OP_VARIABLE . "=quickupload&currentpath=" . $currentpath;
    }
    if ( in_array( 'images', $admin_info['allow_files_type'] ) )
    {
        $CKEditor->config['filebrowserImageUploadUrl'] = NV_BASE_SITEURL . NV_ADMINDIR . "/index.php?nv=upload&" . NV_OP_VARIABLE . "=quickupload&type=image&currentpath=" . $currentpath;
    }
    if ( in_array( 'flash', $admin_info['allow_files_type'] ) )
    {
        $CKEditor->config['filebrowserFlashUploadUrl'] = NV_BASE_SITEURL . NV_ADMINDIR . "/index.php?nv=upload&" . NV_OP_VARIABLE . "=quickupload&type=flash&currentpath=" . $currentpath;
    }
    
    $val = nv_unhtmlspecialchars( $val );
    return $CKEditor->editor( $textareaname, $val );
}

/**
 * nv_add_editor_js()
 * 
 * @return
 */
function nv_add_editor_js ( )
{
    return "";
}

?>