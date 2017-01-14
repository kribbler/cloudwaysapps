<?php

add_action('wp_ajax_bkb_get_search_results', 'bkb_get_search_results');

add_action('wp_ajax_nopriv_bkb_get_search_results', 'bkb_get_search_results');

function bkb_get_search_results() {

    if (isset($_REQUEST['bwl_ajax_search'])) {

        global $wpdb;
        $like = "";
        $where = "";
        $s = trim($_REQUEST['s']);
        $s = preg_replace('/\s+/', ' ', $s);

        $limit = 10;

        $not_exactonly = FALSE;
        $searchintitle = true;
        $searchincontent = true;
        $searchinposts = FALSE;
        $searchinpages = FALSE;
        $searchInCustomPostType = true;

        $post_type = 'post';

        if ($searchintitle) {
            if ($not_exactonly) {
                $sr = implode("%' OR lower($wpdb->posts.post_title) like '%", $_s);
                $sr = " lower($wpdb->posts.post_title) like '%" . $sr . "%'";
            } else {
                $sr = " lower($wpdb->posts.post_title) like '%" . $s . "%'";
            }
            $like .= $sr;
        }

        if ($searchincontent) {
            if ($not_exactonly) {
                $sr = implode("%' OR lower($wpdb->posts.post_content) like '%", $_s);
                if ($like != "") {
                    $sr = " OR lower($wpdb->posts.post_content) like '%" . $sr . "%'";
                } else {
                    $sr = " lower($wpdb->posts.post_content) like '%" . $sr . "%'";
                }
            } else {
                if ($like != "") {
                    $sr = " OR lower($wpdb->posts.post_content) like '%" . $s . "%'";
                } else {
                    $sr = " lower($wpdb->posts.post_content) like '%" . $s . "%'";
                }
            }
            $like .= $sr;
        }


        if ($searchinposts) {
            $where = " $wpdb->posts.post_type='post'";
        }

        if ($searchinpages) {
            $post_type = 'page';
            if ($where != "")
                $where.= " OR $wpdb->posts.post_type='page'";
            else
                $where.= "$wpdb->posts.post_type='page'";
        }

        if ($searchInCustomPostType) {
            $post_type = 'bwl_kb';
            if ($where != "")
                $where.= " OR $wpdb->posts.post_type='bwl_kb'";
            else
                $where.= "$wpdb->posts.post_type='bwl_kb'";
        }

        if ($where == "") {
            $where = "$wpdb->posts.post_type=''";
        }

        $orderby = "ID";

        $s = strtolower(addslashes($_REQUEST['s']));

        $join = "LEFT JOIN $wpdb->users ON $wpdb->users.ID = $wpdb->posts.post_author
     LEFT JOIN $wpdb->term_relationships ON $wpdb->posts.ID = $wpdb->term_relationships.object_id
     LEFT JOIN $wpdb->term_taxonomy ON $wpdb->term_taxonomy.term_taxonomy_id = $wpdb->term_relationships.term_taxonomy_id
     LEFT JOIN $wpdb->terms ON $wpdb->term_taxonomy.term_id = $wpdb->terms.term_id";

        if (defined('ICL_SITEPRESS_VERSION')) {

            global $sitepress;

            $join .= " INNER JOIN {$wpdb->prefix}icl_translations
             ON {$wpdb->posts}.ID = {$wpdb->prefix}icl_translations.element_id";

            $where .= $wpdb->prepare(") AND ({$wpdb->prefix}icl_translations.language_code = %s
                              AND {$wpdb->prefix}icl_translations.element_type = %s", $sitepress->get_current_language(), "post_{$post_type}");
        }

        $querystr = "
  		SELECT 
        $wpdb->posts.guid as permalink ,
        $wpdb->posts.post_title as title,
        $wpdb->posts.ID as id,
        $wpdb->posts.post_date as date,
        $wpdb->posts.post_content as content,
        $wpdb->posts.post_excerpt as excerpt,
        $wpdb->users.user_nicename as author
  		FROM $wpdb->posts
        {$join}
  		WHERE
      ($wpdb->posts.post_status='publish') AND
      (" . $where . ")			    
      AND (" . $like . ")
      GROUP BY
        $wpdb->posts.ID 
  		ORDER BY " . $wpdb->posts . "." . $orderby . "
  		LIMIT $limit ";

        $pageposts = $wpdb->get_results($querystr, OBJECT);
        foreach ($pageposts as $k => $v) {
            $pageposts[$k]->link = get_permalink($v->id);

            $pageposts[$k]->content = strip_shortcodes($pageposts[$k]->content);
            if ($pageposts[$k]->content != '')
                $pageposts[$k]->content = substr(strip_tags($pageposts[$k]->content), 0, 130) . "...";
        }

        $results = $pageposts;


        echo json_encode($results);
        die();
    }

    die();
}
