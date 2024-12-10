<?php
add_shortcode('img', 'shortcode_image_basic');
add_shortcode('icon-box', 'shortcode_icon_box_basic');

// Function for shortcode [img]
function shortcode_image_basic($args)
{
    extract(shortcode_atts([
        'id' => '',
        'size' => 'full ',
        'alt' =>  get_bloginfo('name'),
        'class' => '',
        'type' => 'img',
        'ratio' => '',
        'width' => '',
    ], $args));

    $style_inner = '';
    $style_wrap = '';

    if (!empty($ratio)) {
        $class .= ' img-ratio';
        $style_inner = '
        padding-top: ' . $ratio . '%;
    ';
    }

    if (!empty($width)) {
        $style_wrap = 'width: ' . $width . ';';
    }


    if (!is_numeric($id) && $type != 'svg') {
        return '<div  class="img ' . $class . '" style="' . $style_wrap . '"><div class="img-inner" style="' . $style_inner . '"><img src="' . $id . '" alt="' . $alt . '" /> <div class="img-overlay"></div></div></div>';
    } elseif (!is_numeric($id) && $type == 'svg') {
        return '<div  class="img ' . $class . '" style="' . $style_wrap . '">' . wp_remote_fopen($id) . '</div>';
    } else {
        $meta = get_post_mime_type($id);

        if ($meta == 'image/svg+xml') {
            $source = wp_get_attachment_image_src($id);
            return '<div  class="img ' . $class . '" style="' . $style_wrap . '">' . wp_remote_fopen($source[0]) . '</div>';
        } else {
            return '<div  class="img ' . $class . '" style="' . $style_wrap . '"><div class="img-inner" style="' . $style_inner . '">' . wp_get_attachment_image($id, $size, false) . '<div class="img-overlay"></div></div></div>';
        }
    }
}

// Function for shortcode [icon-box]
function shortcode_icon_box_basic($args, $content)
{
    extract(shortcode_atts([
        'class' => '',
        'kind' => 'center',
        'img' => '',
        'width' => '14px',
        'size' => 'thrumnail',
        'color' => 'inherit',
        'alt' => get_bloginfo('name'),
        'type' => 'img'
    ], $args));

    ob_start();
?>
    <div class="icon-box <?php echo $class . ' ' . $kind; ?>">
        <div class="icon-box-img" style="width: <?php echo $width; ?>; fill: <?php echo $color; ?>;">
            <?php
            if (!is_numeric($img) && $type != 'svg') {
                echo '<img src="' . $img . '" alt="' . $alt . '" />';
            } elseif (!is_numeric($img) && $type == 'svg') {
                echo wp_remote_fopen($img);
            } else {
                $meta = get_post_mime_type($img);
                if ($meta == 'image/svg+xml') {
                    $source = wp_get_attachment_image_src($img);
                    echo wp_remote_fopen($source[0]);
                } else {
                    echo wp_get_attachment_image($img, $size);
                }
            }
            ?>
        </div>
        <div class="icon-box-text">
            <?php echo do_shortcode($content); ?>
        </div>
    </div>
<?php
    return ob_get_clean();
}
