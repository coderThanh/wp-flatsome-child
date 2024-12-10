<?php


/**
 * 
 * Shortcode [pt-post-slider-box-bg]
 * Require: 
 */
add_action('ux_builder_setup', 'pt_ux_builder_posts_slider_box_bg');

function pt_ux_builder_posts_slider_box_bg()
{

    add_ux_builder_shortcode('pt-post-slider-box-bg', array(
        'name'      => __('Pt Post Slider Box'),
        'category'  => __('Content'),
        'priority'  => 1,
        'type' => 'container',
        'wrap'   => false,
        'inline' => true,
        'nested' => true,
        'allow' => array('pt-title-link-item'),
        'options' => array(
            'title_options' => array(
                'type' => 'group',
                'heading' => __('Title'),
                'options' => array(
                    'title' => array(
                        'type' => 'textfield',
                        'full_width' => true,
                        'default' => '',
                        'placeholder' => __('title'),
                        'heading' => 'title',
                    ),
                    'title_link' => array(
                        'type' => 'textfield',
                        'full_width' => true,
                        'default' => '',
                        'placeholder' => __(''),
                        'heading' => 'title link',
                    ),

                ),
            ),


        ),
    ));
}


add_shortcode('pt-post-slider-box-bg', 'pt_post_slider_box_bg_shotcode');

function pt_post_slider_box_bg_shotcode($atts,  $content = null)
{

    $new_atts = shortcode_atts(array(
        'title' => '',
        'title_link' => '',

        // posts
        'type'        => 'slider',
        'slider_nav_style' => 'simple',
        'slider_nav_color' => 'light',
        'slider_bullets' => 'false',
        'slider_arrows' => 'true',
        'auto_slide' => 'false',
        'infinitive' => 'true',
        'style' => 'normal',
        'col_spacing' => "small",
        'excerpt' => 'false',
        'excerpt_length' => 18,
        'text_align' => 'left',
        'columns'     => '4',
        "columns__md" => '3',
        "columns__sm" => '2',
        'show_date'   =>  'false',
        'comments' => 'false',
        'show_category' => 'text',
        'image_height' => '0%',
        'image_size' => "medium",
        'image_overlay' => "rgb(0 0 0 / 0)",
        "image_hover" => "zoom",

        // posts
        'posts' => '8',
        'ids' => false, // Custom IDs
        'cat' => '',
        'category' => '',
        'offset' => '',
        'orderby' => 'date',
        'order' => 'DESC',
        'tags' => '',

        'class' => 'slider-arrow-top row-loop',


    ), $atts);

    extract($new_atts);

    ob_start();

?>

    <section class="post-slider-box">
        <div class="section-content relative container">
            <div class="box-wrap">
                <div class="box-title has-arrow has-links">
                    <h5>
                        <a href="<?php echo esc_attr($title_link); ?>"><?php echo $title; ?></a>
                    </h5>
                    <div class="box-title-links">
                        <?php echo  do_shortcode($content); ?>
                    </div>
                </div>
                <?php echo shortcode_latest_from_blog($new_atts); ?>
            </div>
        </div>
    </section>

<?php
    return ob_get_clean();
}
