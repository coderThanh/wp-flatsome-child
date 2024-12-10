<?php

/**
 * Breadcrumb -----
 * Shortcode [pt-breadcrumb]
 */

function pt_ux_builder_breakcrumb()
{
    add_ux_builder_shortcode('pt-breadcrumb', array(
        'name'      => __('Pt Breakcrumb'),
        'category'  => __('Content'),
        'priority'  => 1,

    ));
}

add_action('ux_builder_setup', 'pt_ux_builder_breakcrumb');


add_shortcode('pt-breadcrumb', 'pt_breadcrumb');

function pt_breadcrumb()
{
    if (is_front_page()) {
        return;
    }

    // $delimiter = '&raquo;';
    // $name = '<svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:svgjs="http://svgjs.com/svgjs" width="20" height="20" x="0" y="0" viewBox="0 0 512 512" style="enable-background:new 0 0 512 512" xml:space="preserve" class=""><g><path xmlns="http://www.w3.org/2000/svg" d="m498.195312 222.695312c-.011718-.011718-.023437-.023437-.035156-.035156l-208.855468-208.847656c-8.902344-8.90625-20.738282-13.8125-33.328126-13.8125-12.589843 0-24.425781 4.902344-33.332031 13.808594l-208.746093 208.742187c-.070313.070313-.140626.144531-.210938.214844-18.28125 18.386719-18.25 48.21875.089844 66.558594 8.378906 8.382812 19.445312 13.238281 31.277344 13.746093.480468.046876.964843.070313 1.453124.070313h8.324219v153.699219c0 30.414062 24.746094 55.160156 55.167969 55.160156h81.710938c8.28125 0 15-6.714844 15-15v-120.5c0-13.878906 11.289062-25.167969 25.167968-25.167969h48.195313c13.878906 0 25.167969 11.289063 25.167969 25.167969v120.5c0 8.285156 6.714843 15 15 15h81.710937c30.421875 0 55.167969-24.746094 55.167969-55.160156v-153.699219h7.71875c12.585937 0 24.421875-4.902344 33.332031-13.808594 18.359375-18.371093 18.367187-48.253906.023437-66.636719zm0 0" fill="" data-original="" class=""></path></g></svg>';

    $delimiter = '<span class="divider">/</span>';
    $name = '';

    $currentBefore = '<span class="current">';
    $currentAfter = '</span>';

    ob_start();

    if (true) {

        global $post;
        $home = get_bloginfo('url');
        echo '<div id="theme-breadcrumb" class="breadcrumbs">';
        echo '<a href="' . $home . '">' . $name . ' ' . __('Trang chủ')  . '</a> ' . $delimiter . ' ';

        if (is_home()) {
            $home_title = get_the_title(get_option('page_for_posts'));
            echo $currentBefore . $home_title . $currentAfter;
        } elseif (is_tax()) {
            $term = get_term_by('slug', get_query_var('term'), get_query_var('taxonomy'));
            echo $currentBefore . $term->name . $currentAfter;
        } elseif (is_category()) {
            global $wp_query;
            $cat_obj = $wp_query->get_queried_object();
            $thisCat = $cat_obj->term_id;
            $thisCat = get_category($thisCat);
            $parentCat = get_category($thisCat->parent);
            if ($thisCat->parent != 0) echo (get_category_parents($parentCat, TRUE, ' ' . $delimiter . ' '));
            echo $currentBefore . '';
            single_cat_title();
            echo '' . $currentAfter;
        } elseif (is_day()) {
            echo '<a href="' . get_year_link(get_the_time('Y')) . '">' . get_the_time('Y') . '</a> ' . $delimiter . ' ';
            echo '<a href="' . get_month_link(get_the_time('Y'), get_the_time('m')) . '">' . get_the_time('F') . '</a> ' . $delimiter . ' ';
            echo $currentBefore . get_the_time('d') . $currentAfter;
        } elseif (is_month()) {
            echo '<a href="' . get_year_link(get_the_time('Y')) . '">' . get_the_time('Y') . '</a> ' . $delimiter . ' ';
            echo $currentBefore . get_the_time('F') . $currentAfter;
        } elseif (is_year()) {
            echo $currentBefore . get_the_time('Y') . $currentAfter;
        } elseif (is_single()) {
            $postType = get_post_type();
            if ($postType == 'post') {
                $cat = get_the_category();
                $cat = $cat[0];
                echo get_category_parents($cat, TRUE, ' ' . $delimiter . ' ');
            } elseif ($postType == 'portfolio') {
                $terms = get_the_term_list($post->ID, 'portfolio-category', '', '###', '');
                $terms = explode('###', $terms);
                echo $terms[0] . ' ' . $delimiter . ' ';
            }
            echo $currentBefore;
            the_title();
            echo $currentAfter;
        } elseif (is_page() && !$post->post_parent) {
            echo $currentBefore;
            the_title();
            echo $currentAfter;
        } elseif (is_page() && $post->post_parent) {
            $parent_id  = $post->post_parent;
            $breadcrumbs = array();
            while ($parent_id) {
                $page = get_page($parent_id);
                $breadcrumbs[] = '<a href="' . get_permalink($page->ID) . '">' . get_the_title($page->ID) . '</a>';
                $parent_id  = $page->post_parent;
            }
            $breadcrumbs = array_reverse($breadcrumbs);
            foreach ($breadcrumbs as $crumb) echo $crumb . ' ' . $delimiter . ' ';
            echo $currentBefore;
            the_title();
            echo $currentAfter;
        } elseif (is_search()) {
            echo $currentBefore . __('Search Results for:', 'wpinsite') . ' &quot;' . get_search_query() . '&quot;' . $currentAfter;
        } elseif (is_tag()) {
            echo $currentBefore . __('Post Tagged with:', 'wpinsite') . ' &quot;';
            single_tag_title();
            echo '&quot;' . $currentAfter;
        } elseif (is_author()) {
            global $author;
            $userdata = get_userdata($author);
            echo $currentBefore .  __('Author ', 'wpinsite') . $userdata->display_name . $currentAfter;
        } elseif (is_404()) {
            echo $currentBefore . __('Page Not Found', 'wpinsite') . $currentAfter;
        }
        if (get_query_var('paged')) {
            // if (is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author()) echo ' (';
            echo ' ' . $delimiter . ' ' . __('Page') . ' ' . get_query_var('paged');
            // if (is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author()) echo ')';
        }

        echo '</div>';
    }

    return ob_get_clean();
}
