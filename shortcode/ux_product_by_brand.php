<?php

/**
 * add shortcode
 * syntax: [pt-product-by-brand]
 */

add_action('ux_builder_setup', 'pt_ux_builder_product_by_brand');

function pt_ux_builder_product_by_brand()
{

    if (!isset($repeater_posts)) $repeater_posts = 'posts';
    if (!isset($repeater_post_type)) $repeater_post_type = 'product';
    if (!isset($repeater_post_cat)) $repeater_post_cat = 'product_brand';

    add_ux_builder_shortcode('pt-product-by-brand', array(
        'name'      => __('Pt sản phẩm bởi thương hiệu'),
        'category'  => __('Product Page'),
        'priority'  => 1,
        'options' => array(
            'category' => array(
                'type' => 'select',
                'heading' => 'Brand',
                'param_name' => 'category',
                'default' => '',
                'config' => array(
                    'multiple' => true,
                    'placeholder' => 'Select...',
                    'termSelect' => array(
                        'post_type' => $repeater_post_type,
                        'taxonomies' => $repeater_post_cat
                    ),
                )
            ),
            $repeater_posts => array(
                'type' => 'textfield',
                'heading' => 'Total Posts',
                'default' => '8',
            ),
            'orderby'       => array(
                'type'       => 'select',
                'heading'    => 'Order by',
                'default'    => 'date',
                'options'    => array(
                    'ID'            => 'ID',
                    'title'         => 'Title',
                    'date'          => 'Published Date',
                    'rand'          => 'Random',
                ),
            ),
            'order'         => array(
                'type'       => 'select',
                'heading'    => 'Order',
                'default'    => 'DESC',
                'options'    => array(
                    'ASC'  => 'ASC',
                    'DESC' => 'DESC',
                ),
            ),
            'type'         => array(
                'type'       => 'select',
                'heading'    => 'type',
                'default'    => 'row',
                'options'    => array(
                    'slider' => 'Slider',
                    'row' => 'Row',
                ),
            ),
            'layout_options_slider' => require(THEME_CHILD_ROOT . '/../flatsome/inc/builder/shortcodes/commons/repeater-slider.php'),
            'columns' => array(
                'type' => 'slider',
                'heading' => 'Columns',
                'default' => '3',
                'responsive' => true,
                'max' => '8',
                'min' => '1',
            ),
            'col_spacing' => array(
                'type' => 'select',
                'heading' => 'Column Spacing',
                'default' => 'normal',
                'options' => require(THEME_CHILD_ROOT . '/../flatsome/inc/builder/shortcodes/values/col-spacing.php')
            ),
            'image_options' => array(
                'type' => 'group',
                'heading' => __('Image'),
                'options' => array(
                    'image_hover' => array(
                        'type' => 'select',
                        'heading' => __('Hover'),
                        'default' => '',
                        'options' => require(THEME_CHILD_ROOT . '/../flatsome/inc/builder/shortcodes/values/image-hover.php'),
                        'on_change' => array(
                            'selector' => '.image-cover',
                            'class' => 'image-{{ value }}'
                        )
                    ),
                ),
            ),

            'advanced_options' => require(THEME_CHILD_ROOT . '/../flatsome/inc/builder/shortcodes/commons/advanced.php'),
        ),
    ));
}

//
add_shortcode('pt-product-by-brand', 'pt_shortcode_product_by_brand');

function pt_shortcode_product_by_brand($atts, $content)
{
    extract(shortcode_atts(array(
        "_id" => 'row-' . rand(),
        // 
        'category' => '',
        'posts' => '',
        'orderby' => 'date',
        'order' => 'DESC',
        // layout
        "type" => 'row', // slider, row, 
        "columns" => '3',
        "columns__sm" => '1',
        "columns__md" => '2',
        "col_spacing" => 'normal',
        'slider_nav_style' => 'reveal',
        'slider_nav_position' => '',
        'slider_nav_color' => '',
        'slider_bullets' => 'false',
        'slider_arrows' => 'true',
        'auto_slide' => 'false',
        'infinitive' => 'true',
        'image_hover' => '',
        // advance
        'class' => '',
        'visibility' => '',
    ),  $atts));

    $a = [
        'category' => $category,
        'count' => $post,
        'orderby' => $orderby,
        'order' => $order,
        'post_type' =>  'product',
        'post_status' => 'publish',
    ];

    if (!empty($a['category'])) {
        $category = (array) explode(',', $a['category']);

        $a['tax_query'] = array();

        $category_ids = array_filter(
            $category,
            function ($id) {
                return is_numeric($id);
            }
        );

        if (!empty($category_ids)) {
            $a['tax_query'] = array(
                array(
                    'taxonomy' => 'pa_thuong-hieu',
                    'field'    => 'term_id',
                    'terms'    => $category_ids,
                    'operator' => 'IN',
                ),
            );
        }
    }

    $a['posts_per_page'] = (int) $a['count'];

    wp_reset_query();

    $the_query = new WP_Query($a);

    // Create IDS
    $ids = array();
    while ($the_query->have_posts()) : $the_query->the_post();
        array_push($ids, get_the_ID());
    endwhile; // end of the loop.
    $ids = implode(',', $ids);


    if (empty($ids)) {
        return;
    }






    ob_start();
?>
<?php
    echo flatsome_apply_shortcode('ux_products', array(
        'type'        => $type,
        'style' => 'normal',
        'col_spacing' => $col_spacing,
        'class'            => $class,
        'columns'     => $columns,
        "columns__md" => $columns__md,
        "columns__sm" => $columns__sm,
        'slider_nav_style' => $slider_nav_style,
        'slider_nav_position' => $slider_nav_position,
        'slider_nav_color' => $slider_nav_color,
        'slider_bullets' => $slider_bullets,
        'slider_arrows' => $slider_arrows,
        'auto_slide' => $auto_slide,
        'infinitive' => $infinitive,

        'show_cat' => '0',
        'show_title' => 'true',
        'show_rating' => '0',
        'show_price' => 'true',
        'equalize_box' => 'true',
        'ids'         => $ids,
        'image_height' => '100%',
        'image_size' => "full",
        'image_hover' => $image_hover,
        'image_overlay' => "rgb(0 0 0 / 0)",
        'visibility' => $visibility,
    ));
?>

<?php
    // Reset Post Data
    wp_reset_postdata();

    return ob_get_clean();
}