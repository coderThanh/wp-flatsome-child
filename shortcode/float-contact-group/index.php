<?php

/**
 * add shortcode
 * syntax: [pt-float-contact-group]
 */

add_action('ux_builder_setup', 'pt_ux_builder_float_contact_group');

function pt_ux_builder_float_contact_group()
{
    add_ux_builder_shortcode('pt-float-contact-group', array(
        'name'      => __('Pt Float contact group'),
        'category'  => __('Content'),
        'priority'  => 1,
        'wrap'   => false,
        'inline' => true,
        'nested' => true,
        'thumbnail' =>  WEBSITE_CHILD_URL . '/shortcode/float-contact-group/float-contact-group.png',
        'options' => array(
            'phone' => array(
                'type' => 'textfield',
                'full_width' => true,
                'default' => '',
                'placeholder' => __(''),
                'heading' => 'phone',
            ),
            'zalo' => array(
                'type' => 'textfield',
                'full_width' => true,
                'default' => '',
                'placeholder' => __(''),
                'heading' => 'zalo',
            ),
            'messenger' => array(
                'type' => 'textfield',
                'full_width' => true,
                'default' => '',
                'placeholder' => __(''),
                'heading' => 'messenger',
            ),
            'map' => array(
                'type' => 'textfield',
                'full_width' => true,
                'default' => '',
                'placeholder' => __(''),
                'heading' => 'map',
            ),
            'advanced_options' => require(THEME_CHILD_ROOT . '/../flatsome/inc/builder/shortcodes/commons/advanced.php'),
        ),
    ));
}

//
add_shortcode('pt-float-contact-group', 'pt_get_float_contact_group');

function pt_get_float_contact_group($atts, $content)
{
    extract(shortcode_atts(array(
        'phone' => '',
        'zalo' => '',
        'messenger' => '',
        'map' => '',
        'class' => '',
        'visibility' => '',
    ), $atts));

    ob_start();
?>
    <div class="vka-wrapper  <?php echo esc_attr($class); ?> <?php echo esc_attr($visibility); ?>">
        <input id="vkaCheckbox" type="checkbox" class="vka-checkbox">
        <label class="vka" for="vkaCheckbox">
            <i class="icon-cps-vka-menu"></i>
        </label>
        <div class="vka-wheel">
            <?php if (!empty($map)) :; ?>
                <a class="vka-action vka-action-1" href="<?php echo esc_attr($map); ?>" rel="nofollow" target="_blank" title="Tìm cửa hàng">
                    <div class="vka-button vka-button-1"><i class="icon-cps-local"></i></div>
                </a>
            <?php endif; ?>

            <?php if (!empty($phone)) :; ?>
                <a class="vka-action vka-action-2" href="<?php echo esc_attr($phone); ?>" rel="nofollow" title="Gọi trực tiếp">
                    <div class="vka-button vka-button-2"><i class="icon-cps-phone"></i></div>
                </a>
            <?php endif; ?>

            <?php if (!empty($messenger)) :; ?>
                <a class="vka-action vka-action-3" href="<?php echo esc_attr($messenger); ?>" rel="nofollow" target="_blank" title="Chat Facebook">
                    <div class="vka-button vka-button-3"><i class="icon-cps-facebook"></i></div>
                </a>
            <?php endif; ?>

            <?php if (!empty($zalo)) :; ?>
                <a class="vka-action vka-action-4" href="<?php echo esc_attr($zalo); ?>" target="_blank" rel="nofollow" title="Chat Zalo">
                    <div class="vka-button vka-button-4"><i class="icon-cps-chat-zalo"></i></div>
                </a>
            <?php endif; ?>
        </div>
    </div>
    <style>
        .vka-wrapper {
            position: fixed;
            bottom: 10px;
            right: 3px;
            z-index: 9999999;
        }

        .vka-checkbox {
            display: none !important;
        }

        .vka {
            width: 60px;
            max-width: unset;
            height: 60px;
            display: flex !important;
            justify-content: center;
            align-items: center;
            margin: 0;
            border-radius: 50%;
            background: #c31d1d;
            box-shadow: 0 3px 6px rgb(0 0 0 / 16%), 0 3px 6px rgb(0 0 0 / 23%);
            position: absolute;
            right: 10px;
            bottom: 10px;
            z-index: 1000;
            overflow: hidden;
            transform: rotate(0deg);
            -webkit-transition: all .15s cubic-bezier(.15, .87, .45, 1.23);
            transition: all .15s cubic-bezier(.15, .87, .45, 1.23);
        }

        .vka-checkbox:checked~.vka {
            -webkit-transition: all .15s cubic-bezier(.15, .87, .45, 1.23);
            transition: all .15s cubic-bezier(.15, .87, .45, 1.23);
            width: 30px;
            height: 30px;
            right: 26px;
            bottom: 35px;
        }

        [class*=icon-cps-] {
            display: inline-block;
            vertical-align: middle;
            background-image: url(data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAANoAAAB1CAYAAAAoV//gAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAAyJpVFh0WE1MOmNvbS5hZG9iZS54bXAAAAAAADw/eHBhY2tldCBiZWdpbj0i77u/IiBpZD0iVzVNME1wQ2VoaUh6cmVTek5UY3prYzlkIj8+IDx4OnhtcG1ldGEgeG1sbnM6eD0iYWRvYmU6bnM6bWV0YS8iIHg6eG1wdGs9IkFkb2JlIFhNUCBDb3JlIDUuMy1jMDExIDY2LjE0NTY2MSwgMjAxMi8wMi8wNi0xNDo1NjoyNyAgICAgICAgIj4gPHJkZjpSREYgeG1sbnM6cmRmPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5LzAyLzIyLXJkZi1zeW50YXgtbnMjIj4gPHJkZjpEZXNjcmlwdGlvbiByZGY6YWJvdXQ9IiIgeG1sbnM6eG1wPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvIiB4bWxuczp4bXBNTT0iaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wL21tLyIgeG1sbnM6c3RSZWY9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9zVHlwZS9SZXNvdXJjZVJlZiMiIHhtcDpDcmVhdG9yVG9vbD0iQWRvYmUgUGhvdG9zaG9wIENTNiAoV2luZG93cykiIHhtcE1NOkluc3RhbmNlSUQ9InhtcC5paWQ6ODVFMzM1MDcwNDAyMTFFQ0I0OTJBMEYxN0VGQ0ExRTMiIHhtcE1NOkRvY3VtZW50SUQ9InhtcC5kaWQ6ODVFMzM1MDgwNDAyMTFFQ0I0OTJBMEYxN0VGQ0ExRTMiPiA8eG1wTU06RGVyaXZlZEZyb20gc3RSZWY6aW5zdGFuY2VJRD0ieG1wLmlpZDo4NUUzMzUwNTA0MDIxMUVDQjQ5MkEwRjE3RUZDQTFFMyIgc3RSZWY6ZG9jdW1lbnRJRD0ieG1wLmRpZDo4NUUzMzUwNjA0MDIxMUVDQjQ5MkEwRjE3RUZDQTFFMyIvPiA8L3JkZjpEZXNjcmlwdGlvbj4gPC9yZGY6UkRGPiA8L3g6eG1wbWV0YT4gPD94cGFja2V0IGVuZD0iciI/Phh/T5sAACNZSURBVHja7F0HuFXF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) !important;
            background-repeat: no-repeat;
            background-size: 148px;
        }

        .icon-cps-vka-menu {
            width: 50px;
            height: 50px;
            margin: 0 !important;
            background-size: 200px;
            background-position: -155px 0;
        }

        .vka-checkbox:checked~.vka .icon-cps-vka-menu {
            width: 20px;
            height: 20px;
            margin: 0;
            background-size: 100px;
            background-position: -79px -29px;
        }

        .vka-wheel {
            position: absolute;
            bottom: 15px;
            right: 18px;
            transform: scale(0);
            transform-origin: bottom right;
            transition: all .3s ease;
            z-index: 12;

            display: flex;
            flex-direction: column;
            flex-wrap: nowrap;
            gap: 12px;
            padding-bottom: 65px;
        }

        .vka-checkbox:checked~.vka-wheel {
            transform: scale(1);
        }

        .vka-wheel .vka-action {
            display: flex;
            align-items: center;
            font-size: 14px;
            font-weight: 700;
            color: #fff;
            /* position: absolute; */
            text-decoration: none;
        }

        .vka-wheel .vka-action:hover {
            transform: scale(1.1);
        }

        .vka-wheel .vka-action-1 {
            bottom: 225px;
            right: 0;
        }

        .vka-button {
            width: 45px;
            height: 45px;
            display: flex;
            justify-content: center;
            align-items: center;
            float: left;
            padding: 4px;
            border-radius: 50%;
            background: #0f1941;
            box-shadow: 0 1px 3px rgb(0 0 0 / 12%), 0 1px 2px rgb(0 0 0 / 24%);
            font-size: 24px;
            color: White;
            transition: all 1s ease;
            overflow: hidden;
        }

        .icon-cps-local {
            width: 30px;
            height: 30px;
            background-position: -5px -43px;
        }

        .icon-cps-mail {
            width: 30px;
            height: 30px;
            background-position: -8px -5px;
        }

        .icon-cps-facebook {
            width: 30px;
            height: 30px;
            background-position: -80px -43px;
        }

        .vka-wheel .vka-button-1 {
            background: #0f9d58;
        }

        .vka-wheel .vka-action-2 {
            bottom: 170px;
            right: 0;
        }

        .vka-wheel .vka-button-2 {
            background: #fb0;
        }

        .icon-cps-phone {
            width: 30px;
            height: 30px;
            background-position: -42px -45px;
        }

        .vka-wheel .vka-action-3 {
            right: 0;
            bottom: 115px;
            cursor: pointer;
        }

        .vka-wheel .vka-button-3 {
            background: #006AFF;
        }

        .vka-wheel .vka-action-4 {
            right: 0;
            bottom: 60px;
        }

        .vka-wheel .vka-button-4 {
            background: #2f82fc;
        }

        .icon-cps-chat-zalo {
            width: 30px;
            height: 30px;
            background-position: -47px -5px;
            background-size: 155px;
        }

        .hidden {
            display: none !important;
        }

        .align-items-center {
            -ms-flex-align: center !important;
            align-items: center !important;
            -ms-flex-pack: distribute !important;
            justify-content: space-around !important;
            display: -ms-flexbox !important;
            display: flex !important;
            -webkit-box-align: center !important;
            -ms-flex-align: center !important;
            align-items: center !important;
        }


        .vka-checkbox:not(:checked)~.vka {
            animation-name: zoom;
            -webkit-animation-name: zoom;
            animation-delay: 0s;
            -webkit-animation-delay: 0s;
            animation-duration: 1.5s;
            -webkit-animation-duration: 1.5s;
            animation-iteration-count: infinite;
            -webkit-animation-iteration-count: infinite;
            cursor: pointer;
            box-shadow: 0 0 0 0 #c31d1d;
        }

        @-webkit-keyframes tada {
            0% {
                -webkit-transform: scale(1);
                transform: scale(1)
            }

            10%,
            20% {
                -webkit-transform: scale(.9) rotate(-3deg);
                transform: scale(.9) rotate(-3deg)
            }

            30%,
            50%,
            70%,
            90% {
                -webkit-transform: scale(1.1) rotate(3deg);
                transform: scale(1.1) rotate(3deg)
            }

            40%,
            60%,
            80% {
                -webkit-transform: scale(1.1) rotate(-3deg);
                transform: scale(1.1) rotate(-3deg)
            }

            100% {
                -webkit-transform: scale(1) rotate(0);
                transform: scale(1) rotate(0)
            }
        }

        @keyframes tada {
            0% {
                -webkit-transform: scale(1);
                -ms-transform: scale(1);
                transform: scale(1)
            }

            10%,
            20% {
                -webkit-transform: scale(.9) rotate(-3deg);
                -ms-transform: scale(.9) rotate(-3deg);
                transform: scale(.9) rotate(-3deg)
            }

            30%,
            50%,
            70%,
            90% {
                -webkit-transform: scale(1.1) rotate(3deg);
                -ms-transform: scale(1.1) rotate(3deg);
                transform: scale(1.1) rotate(3deg)
            }

            40%,
            60%,
            80% {
                -webkit-transform: scale(1.1) rotate(-3deg);
                -ms-transform: scale(1.1) rotate(-3deg);
                transform: scale(1.1) rotate(-3deg)
            }

            100% {
                -webkit-transform: scale(1) rotate(0);
                -ms-transform: scale(1) rotate(0);
                transform: scale(1) rotate(0)
            }
        }

        @-webkit-keyframes zoom {
            0% {
                transform: scale(.9)
            }

            70% {
                transform: scale(1);
                box-shadow: 0 0 0 15px transparent
            }

            100% {
                transform: scale(.9);
                box-shadow: 0 0 0 0 transparent
            }
        }

        @keyframes zoom {
            0% {
                transform: scale(.9)
            }

            70% {
                transform: scale(1);
                box-shadow: 0 0 0 15px transparent
            }

            100% {
                transform: scale(.9);
                box-shadow: 0 0 0 0 transparent
            }
        }
    </style>
<?php
    return ob_get_clean();
}
