<?php

/**
 * Define the metabox and field configurations.
 *
 * @param  array $meta_boxes
 * @return array
 */

function bkb_cmb_framework(array $meta_boxes) {

    $bkb_file_attachment_fields = array(
        array( 'id' => 'bkb_attachment_files', 'name' => __('Upload Files','bwl-kb'), 'type' => 'file', 'repeatable' => 1, 'sortable' => 1 )
    );
    
    $meta_boxes[] = array(
        'title' => __('BKB File Attachment Settings', 'bwl-kb'),
        'pages' => 'bwl_kb',
        'fields' => $bkb_file_attachment_fields
    );

    return $meta_boxes;
}

add_filter('cmb_meta_boxes', 'bkb_cmb_framework');