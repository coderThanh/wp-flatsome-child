<?php

/**
 * add shortcode
 * syntax: [pt-marquee-multi-item]
 */


add_action('wp_enqueue_scripts', 'pt_shortcode_marquee_multi_item_setup');

function pt_shortcode_marquee_multi_item_setup()
{
    wp_enqueue_style('marquee-multi-item-shortcode', get_stylesheet_directory_uri() . '/shortcode/marquee-multi-item/syles.css', [], '1.0');
}

//
add_action('ux_builder_setup', 'pt_ux_builder_marquee_milti_item');

function pt_ux_builder_marquee_milti_item()
{
    add_ux_builder_shortcode('pt-marquee-multi-item', array(
        'name'      => __('Pt Marquee Multi Item'),
        'category'  => __('Content'),
        'priority'  => 10,
        'type' => 'container',
        'options' => [
            'advanced_options' => require(THEME_CHILD_ROOT . '/../flatsome/inc/builder/shortcodes/commons/advanced.php'),
        ],
    ));
}


//
add_shortcode('pt-marquee-multi-item', 'pt_get_marquee_milti_item');

function pt_get_marquee_milti_item($atts, $content = null)
{
    extract(shortcode_atts(array(
        'class' => '',
        'visibility' => '',
    ), $atts));

    ob_start();

?>
    <div class="marquee-wrap <?php echo esc_attr($class); ?> <?php echo esc_attr($visibility); ?>">
        <div class="marquee-inner marquee-animation">
            <div class="item">
                <?php echo do_shortcode($content); ?>
            </div>
            <div class="item">
                <?php echo do_shortcode($content); ?>
            </div>
            <div class="item">
                <?php echo do_shortcode($content); ?>
            </div>
            <div class="item">
                <?php echo do_shortcode($content); ?>
            </div>
            <div class="item">
                <?php echo do_shortcode($content); ?>
            </div>
            <div class="item">
                <?php echo do_shortcode($content); ?>
            </div>
            <div class="item">
                <?php echo do_shortcode($content); ?>
            </div>
            <div class="item">
                <?php echo do_shortcode($content); ?>
            </div>
        </div>
    </div>
<?php

    return ob_get_clean();
}
