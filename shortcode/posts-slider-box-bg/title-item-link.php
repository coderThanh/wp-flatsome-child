<?php


/**
 * 
 * Shortcode [pt-title-link-item]
 * Require: 
 */
add_action('ux_builder_setup', 'pt_ux_builder_title_link_item');

function pt_ux_builder_title_link_item()
{

    add_ux_builder_shortcode('pt-title-link-item', array(
        'name'      => __('Pt Item Link'),
        'category'  => __('Content'),
        'priority'  => 1,
        'wrap'   => false,
        'inline' => true,
        'nested' => true,
        'require' => array('pt-post-slider-box-bg'),
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
    ));
}


add_shortcode('pt-title-link-item', 'pt_title_link_item_shotcode');

function pt_title_link_item_shotcode($atts,  $content = null)
{

    $new_atts = shortcode_atts(array(
        'title' => '',
        'title_link' => '',
    ), $atts);

    extract($new_atts);

    ob_start();
?>
    <?php if (!empty($title)) :; ?>
        <a class="title-link-item" href="<?php echo esc_attr($title_link); ?>"><?php echo $title; ?></a>
    <?php endif; ?>

<?php
    return ob_get_clean();
}
