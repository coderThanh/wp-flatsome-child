<?php

/**
 * Show pagiantion
 * put function content  replace default pagination
 */

function replacte_flatsome_posts_pagination_to_loadmore()
{
    ob_start();
?>
    <?php
    global $wp_query; // you can remove this line if everything works for you
    $current_page = get_query_var('paged') ? get_query_var('paged') : 1;
    ?>
    <?php if ($current_page == '1' && !is_search()) :; ?>
        <?php
        if ($wp_query->max_num_pages > 1 &&  $current_page < $wp_query->max_num_pages)
            echo '<div style="display:flex;justify-content:center;"><button class="btn_loop_load_more button primary btn"><span>Tải thêm</span></button></div>';
        ?>
    <?php else :; ?>
        <?php flatsome_posts_pagination(); ?>
    <?php endif; ?>
    <?php

    echo ob_get_clean();
}


/**
 * Ajax Load more for Blog Archive
 */

function pt_blog_load_more_scripts()
{
    global $wp_query;

    // register our main script but do not enqueue it yet

    wp_register_script('pt_load_more', WEBSITE_CHILD_URL . '/inc/modules/flatsome-loadmore-posts/loop-load-more-blog.php', array('jquery'), '1.0', true);

    wp_localize_script('pt_load_more', 'pt_loadmore_params', array(

        'ajaxurl' => admin_url('admin-ajax.php'), // WordPress AJAX

        'posts' => json_encode($wp_query->query_vars), // everything about your loop is here

        'current_page' => get_query_var('paged') ? get_query_var('paged') : 1,

        'max_page' => $wp_query->max_num_pages

    ));

    wp_enqueue_script('pt_load_more');
}

add_action('wp_enqueue_scripts', 'pt_blog_load_more_scripts');

// Load more step 4
function pt_blog_loadmore_ajax_handler()
{

    // prepare our arguments for the query
    $args = json_decode(stripslashes($_POST['query']), true);
    $args['paged'] = $_POST['page'] + 1; // we need next page to be loaded
    $args['post_status'] = 'publish';

    // it is always better to use WP_Query but not here
    query_posts($args);

    if (have_posts()) :
        while (have_posts()) : the_post();
    ?>
            <div class="col post-item">
                <div class="col-inner">
                    <?php
                    echo flatsome_apply_shortcode('loop-post-item', array(
                        'style' => 'vertical',
                        'class'            => "",
                        'depth'       => get_theme_mod('blog_posts_depth', 0),
                        'depth_hover' => get_theme_mod('blog_posts_depth_hover', 0),
                        'text_align'  => get_theme_mod('blog_posts_title_align', 'left'),
                        'excerpt' => 'visible',
                        'excerpt_length' => 18,
                        'show_date'   =>  'text',
                        'comments' => 'false',
                        'show_category' => 'text',
                        'image_height' => '75%',
                        'image_size' => "medium",
                        'image_overlay' => "rgb(0 0 0 / 0)",
                        "image_hover" => "zoom",
                        'readmore' => '',
                        'readmore_color' => 'secondary',
                        'readmore_style' => 'bevel',
                        // 'readmore_size' => 'small',
                    ));
                    ?>
                </div>
            </div>

<?php
        endwhile;

    endif;
    die; // here we exit the script and even no wp_reset_query() required!
}

add_action('wp_ajax_loadmore', 'pt_blog_loadmore_ajax_handler'); // wp_ajax_{action}
add_action('wp_ajax_nopriv_loadmore', 'pt_blog_loadmore_ajax_handler'); // wp_ajax_nopriv_{action}
