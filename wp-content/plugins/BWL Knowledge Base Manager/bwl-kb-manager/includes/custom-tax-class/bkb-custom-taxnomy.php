<?php

//include the main class file
require_once("tax-meta-class/tax-meta-class.php");

if (is_admin()){
  /* 
   * prefix of meta keys, optional
   */
    
  $prefix = 'bkb_';
  $bkb_get_fa_icons = bkb_get_fa_icons();
  
  /* 
   * configure your meta box
   */
  $config = array(
    'id' => 'bwl_tax_icon',          // meta box id, unique per meta box
    'title' => 'Meta Box',          // meta box title
    'pages' => array('bkb_category', 'bkb_tags'),        // taxonomy name, accept categories, post_tag and custom taxonomies
    'context' => 'normal',            // where the meta box appear: normal (default), advanced, side; optional
    'fields' => array(),            // list of meta fields (can be added by field arrays)
    'local_images' => false,          // Use local or hosted images (meta box images for add/remove)
    'use_with_theme' => false          //change path if used with theme set to true, false for a plugin or anything else for a custom path(default false).
  );
  
  
  /*
   * Initiate your meta box
   */
  $bkb_tax_meta =  new Tax_Meta_Class($config);
  
  /*
   * Add fields to your meta box
   */
  
  //select field
  $bkb_tax_meta->addSelect($prefix.'fa_id', $bkb_get_fa_icons,array('name'=> __('Custom Icon','bwl_kb'), 'std'=> array('fa fa-file-o')));
     
 //checkbox field
  $bkb_tax_meta->addCheckbox($prefix.'upload_icon_status',array('name'=> __('Upload Own Icon?','bwl-kb')));
  //Image field
  $bkb_tax_meta->addImage($prefix.'uploaded_icon',array('name'=> __('Upload Icon ','bwl-kb'), 'desc'=> __('Best size 16px X 16 px', 'bwl-kb')));
  /*
   * Don't Forget to Close up the meta box decleration
   */
  //Finish Meta Box Decleration
  $bkb_tax_meta->Finish();
  
}