<?php


/**
 * 
 * Shortcode [pt-menu]
 * Require: 
 */


add_action('ux_builder_setup', 'pt_ux_builder_menu');

function pt_ux_builder_menu()
{
    $list_menus =  wp_get_nav_menus();
    // $list_menus = get_nav_menu_locations();

    $pre_menu = array('' => '-- Menus --');

    foreach ($list_menus as $menu) {
        $pre_menu[$menu->term_id] = $menu->name;
    }


    add_ux_builder_shortcode('pt-menu', array(
        'name'      => __('Pt Menu'),
        'category'  => __('Content'),
        'priority'  => 1,
        'wrap'   => false,
        'inline' => true,
        'nested' => true,
        'info'      => '{{ label }}',
        'options' => array(
            'label' => array(
                'full_width' => true,
                'type' => 'textfield',
                'heading' => 'Label',
                'placeholder' => 'Enter admin label here..'
            ),
            'id' => array(
                'type' => 'select',
                'heading' => 'Select menu',
                'default' => '',
                'options' => $pre_menu
            ),
            'depth' => array(
                'type'    => 'slider',
                'heading' => __('Depth'),
                'unit'    => 'level',
                'default' => 1,
                'max'     => 4,
                'min'     => 0,
            ),
            'advanced_options' => require(THEME_CHILD_ROOT . '/../flatsome/inc/builder/shortcodes/commons/advanced.php'),
        ),
    ));
}


add_shortcode('pt-menu', 'pt_gallery_btn_shotcode');

function pt_gallery_btn_shotcode($atts,  $content = null)
{

    extract(shortcode_atts(array(
        'id' => '',
        'depth' => '1',
        'class' => '',
        'visibility' => '',
    ), $atts));


    if (empty($id)) return;

    ob_start();

?>


<?php wp_nav_menu([
        'menu' => $id,
        'link_before' => '<span>',
        'link_after' => '</span>',
        'menu_class' => 'menu-area ' . $class . ' ' . $visibility,
        'container' =>  false,
        'depth' => $depth,
        'fallback_cb' => null,
        'walker' => new FlatsomeNavDropdown,
    ]); ?>



<?php
    return ob_get_clean();
}