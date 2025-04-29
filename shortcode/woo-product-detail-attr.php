<?php

/**
 * add shortcode
 * syntax: [pt-product-detail-attr]
 */



//
add_action('ux_builder_setup', 'pt_ux_builder_product_detail_attr_shortocde');

function pt_ux_builder_product_detail_attr_shortocde()
{
    add_ux_builder_shortcode('pt-product-detail-attr', array(
        'name'      => __('Pt Product Atrribute'),
        'category'  => __('PRODUCT PAGE'),
        'priority'  => 10,
        // 'type' => 'container',
        'wrap'   => false,
        'inline' => true,
        'nested' => true,
        'options' => array(
            // 
            'advanced_options' => require(THEME_CHILD_ROOT . '/../flatsome/inc/builder/shortcodes/commons/advanced.php'),
        ),
    ));
}


//
add_shortcode('pt-product-detail-attr', 'pt_get_product_detail_attr_shortocde');
function pt_get_product_detail_attr_shortocde($atts, $content = null)
{

    extract(shortcode_atts(array(
        'class' => '',
        'visibility' => '',
    ), $atts));

    global $product;

    ob_start();

?>
    <div class="product-attr-area <?php echo esc_attr($class); ?> <?php echo esc_attr($visibility); ?>">
        <?php echo wc_display_product_attributes($product); ?>
    </div>
<?php

    return ob_get_clean();
}
