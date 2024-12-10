<?php
// Controll all input custom by PT

class PT_INPUT
{
    public static function get_form_range(string $input_name, string $input_min, string $input_max, string $inpunt_step, string $suffix, string $input_value)
    {
        /**
         * Create Class input Range
         * File js: /inc/js/admin-script.js
         * 
         *  */
        ob_start();
?>
        <div class="form-range_wrap">
            <input type="range" name="<?php echo $input_name; ?>" step="<?= $inpunt_step; ?>" min="<?= $input_min; ?>" max="<?= $input_max; ?>" value="<?= $input_value; ?>" onchange="changeValueInputRangeWrap (event)">
            <label>
                <div class="form-range_value"><?= $input_value; ?></div>
                <div class="form-range_suffix"><?php echo $suffix; ?></div>
            </label>
        </div>
    <?php
        return ob_get_clean();
    }

    public static function get_field_imgs(string $input_name, array $input_value)
    {
        ob_start();
    ?>
        <div class="imgs_wrap">
            <div class="input__box">
                <?php
                if (sizeof($input_value) == 0) :
                ?>
                    <div class="input__content">
                        <label>Ảnh</label>
                        <?php echo button_upload_image($input_name, ''); ?>
                        <a class="btn__add_delete admin-btn__input" onclick="deleteInputWrap(event)">
                            <?php _e('Xoá ảnh'); ?>
                        </a>
                    </div>
                <?php endif; ?>

                <?php
                if (sizeof($input_value) > 0) :
                    for ($index = 0; $index < sizeof($input_value); $index++) :
                ?>
                        <div class="input__content">
                            <?php echo button_upload_image($input_name, $input_value[$index]); ?>
                            <a class="btn__add_delete admin-btn__input" onclick="deleteInputWrap(event)">
                                <?php _e('Xoá ảnh'); ?>
                            </a>
                        </div>
                    <?php endfor; ?>
                <?php endif; ?>


            </div>

            <a class="btn__add_more admin-btn__input" onclick="addInputImageToMetaBox(event, '<?php echo  $input_name; ?> ', '.imgs_wrap','.input__box')">
                Thêm ảnh
            </a>
        </div>
    <?php
        return ob_get_clean();
    }

    public static function get_field_box_img(array $args)
    {
        extract(wp_parse_args($args, [
            'img_name' => '',
            'img_value' => '',
            'link_name' => '',
            'link_value' => '',
            'title_name' => '',
            'title_value' => '',
            'rel_name' => '',
            'rel_value' => '',
            'target_name' => '',
            'target_value' => '',
            'is_show_link' => true,
            'is_show_title' => true,
            'is_show_rel' => true,
            'is_show_target' => true,
        ]));

        ob_start();
    ?>
        <div class="card mb-3 input__content">
            <?php echo button_upload_image($img_name, $img_value); ?>
            <?php if ($is_show_link) :; ?>
                <div class="input-group my-2">
                    <div class="input-group-prepend">
                        <span class="input-group-text">Link</span>
                    </div>
                    <input type="text" class="form-control m-0" name="<?php echo esc_attr($link_name); ?>" value="<?php echo esc_attr($link_value); ?>">
                </div>
            <?php endif; ?>
            <?php if ($is_show_title) :; ?>
                <div class="input-group my-2">
                    <div class="input-group-prepend">
                        <span class="input-group-text">Title</span>
                    </div>
                    <input type="text" class="form-control m-0" name="<?php echo esc_attr($title_name); ?>" value="<?php echo esc_attr($title_value); ?>">
                </div>
            <?php endif; ?>
            <?php if ($is_show_rel) :; ?>
                <div class="input-group my-2">
                    <div class="input-group-prepend">
                        <span class="input-group-text">Rel</span>
                    </div>
                    <input type="text" class="form-control m-0" name="<?php echo esc_attr($rel_name); ?>" value="<?php echo esc_attr($rel_value); ?>">
                </div>
            <?php endif; ?>
            <?php if ($is_show_target) :; ?>
                <div class="input-group my-2">
                    <div class="input-group-prepend">
                        <span class="input-group-text">Target</span>
                    </div>
                    <select name="popup_options_type" class="flex-fill">
                        <option value="" <?php if ($target_value === '') echo 'selected="selected"'; ?>><?= __('default'); ?></option>
                        <option value="_blank" <?php if ($target_value === '_blank') echo 'selected="selected"'; ?>><?= __('_blank'); ?></option>
                        <option value="_top" <?php if ($target_value === '_top') echo 'selected="selected"'; ?>><?= __('_top'); ?></option>
                        <option value="_parent" <?php if ($target_value === '_parent') echo 'selected="selected"'; ?>><?= __('_parent'); ?></option>
                        <option value="framename" <?php if ($target_value === 'framename') echo 'selected="selected"'; ?>><?= __('framename'); ?></option>
                    </select>
                </div>
            <?php endif; ?>
        </div>
    <?php
        return ob_get_clean();
    }


    // 
    public static function get_field_imgs_links(string $input_img_name, array $input_img_value, string $input_link_name, array $input_link_value)
    {
        ob_start();
    ?>
        <div class="field-wraps">
            <div class="field-content" style="max-width: 500px;">

                <?php if (count($input_img_value) > 0) :; ?>
                    <?php foreach ($input_img_value as $key => $value_img) :; ?>
                        <div class="card mb-3 input__content">
                            <?php echo button_upload_image($input_img_name . '[' . $key . ']', $input_img_value[$key]); ?>
                            <div class="input-group my-2">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Đường dẫn</span>
                                </div>
                                <input type="text" class="form-control m-0" name="<?php echo esc_attr($input_link_name . '[' . $key . ']'); ?>" value="<?php echo esc_attr($input_link_value[$key]); ?>">
                            </div>
                            <button type="button" class="btn btn-outline-danger my-1" onclick="deleteInputWrap(event)">Xóa item</button>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>

            <button type="button" class="btn__add_more button button-secondary" onclick="addCardFieldHaveImgLink(event, '<?php echo esc_attr($input_img_name); ?>','<?php echo esc_attr($input_link_name); ?>' )">Thêm ảnh</button>
        </div>
    <?php
        return ob_get_clean();
    }

    // 
    public static function get_field_imgs_desktop_mobile_links(string $desk_name, array $desk_value, string  $mobile_name, array $mobile_value, $link_name, array $link_value)
    {
        ob_start();
    ?>
        <div class="field-wraps">
            <div class="field-content" style="max-width: 500px;">

                <?php if (count($desk_value) > 0) :; ?>
                    <?php foreach ($desk_value as $key => $value_img) :; ?>
                        <div class="card mb-3 input__content">

                            <div class="my-2">
                                <label class="form-label">Desktop</label>
                                <?php echo button_upload_image($desk_name . '[' . $key . ']', $desk_value[$key]); ?>
                            </div>
                            <div class="my-2">
                                <label class="form-label">Mobile</label>
                                <?php echo button_upload_image($mobile_name . '[' . $key . ']', $mobile_value[$key]); ?>
                            </div>
                            <div class="input-group my-2">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Đường dẫn</span>
                                </div>
                                <input type="text" class="form-control m-0" name="<?php echo esc_attr($link_name . '[' . $key . ']'); ?>" value="<?php echo esc_attr($link_value[$key]); ?>">
                            </div>
                            <button type="button" class="btn btn-outline-danger my-1" onclick="deleteInputWrap(event)">Xóa item</button>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>

            <button type="button" class="btn__add_more button button-secondary" onclick="addCardFieldHaveImgDesktopMobileLink(event, '<?php echo esc_attr($desk_name); ?>','<?php echo esc_attr($mobile_name); ?>','<?php echo esc_attr($link_name); ?>' )">Thêm item</button>
        </div>
    <?php
        return ob_get_clean();
    }

    // 
    public static function get_field_imgs_links_titles(string $input_img_name, array $input_img_value, string $input_link_name, array $input_link_value, $input_title_name, array $input_title_value)
    {
        ob_start();
    ?>
        <div class="field-wraps">
            <div class="field-content" style="max-width: 500px;">

                <?php if (count($input_img_value) > 0) :; ?>
                    <?php foreach ($input_img_value as $key => $value_img) :; ?>
                        <div class="card mb-3 input__content">
                            <?php echo button_upload_image($input_img_name . '[' . $key . ']', $input_img_value[$key]); ?>

                            <div class="input-group my-2">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Tiêu đề</span>
                                </div>
                                <input type="text" class="form-control m-0" name="<?php echo esc_attr($input_title_name . '[' . $key . ']'); ?>" value="<?php echo esc_attr($input_title_value[$key]); ?>">
                            </div>

                            <div class="input-group my-2">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Đường dẫn</span>
                                </div>
                                <input type="text" class="form-control m-0" name="<?php echo esc_attr($input_link_name . '[' . $key . ']'); ?>" value="<?php echo esc_attr($input_link_value[$key]); ?>">
                            </div>
                            <button type="button" class="btn btn-outline-danger my-1" onclick="deleteInputWrap(event)">Xóa item</button>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>

            <button type="button" class="btn__add_more button button-secondary" onclick="addCardFieldHaveImgLinkTitle(event, '<?php echo esc_attr($input_img_name); ?>','<?php echo esc_attr($input_title_name); ?>','<?php echo esc_attr($input_link_name); ?>' )">Thêm item</button>
        </div>
<?php
        return ob_get_clean();
    }
}
