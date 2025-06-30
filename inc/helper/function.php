<?php

/**
 * Create button upload image / media
 * This funtion need file js and admin css.
 * ===============================================================================
 */

function button_upload_image($name = null, $value = null)
{
	ob_start();
	?>
	<div class="attachment_media-view">
		<button type="button"
			class="button_add-media"
			onclick="buttonAddMediaList(event)">
			<?php
			if( $value ) {
				echo do_shortcode( '[img class="preview-img" id="' . $value . '"]' );
			} else {
				echo 'Upload image';
			}
			?>
		</button>
		<div class="actions">
			<?php
			if( $value ) {
				echo '<button type="button" onclick="buttonRemoveMediaList(event)" class="button button_remove-media">x</button>';
			}
			?>
		</div>
		<input class="image-url widefat"
			type="hidden"
			name="<?php echo $name; ?>"
			value="<?php echo $value; ?>" />
	</div>
	<?php
	return ob_get_clean();
}


/**
 * Function format number View to k, m, b
 */
if( !function_exists( 'pt_number_format_to_signature' ) ) {
	function pt_number_format_to_signature($number, $precision = 1)
	{
		if( $number < 1000 ) {
			$number_format = number_format( $number );
		} elseif( $number < 1000000 ) {
			// Anything less than a billion
			$number_format = number_format( $number / 1000, $precision ) . 'K';
		} elseif( $number < 1000000000 ) {
			// Anything less than a billion
			$number_format = number_format( $number / 1000000, $precision ) . 'M';
		} else {
			// At least a billion
			$number_format = number_format( $number / 1000000000, $precision ) . 'B';
		}

		return $number_format;
	}
}

/** Count post --- */

if( !function_exists( 'customSetPostViews' ) ) {
	function customSetPostViews($postID)
	{
		$countKey = 'post_views_count';
		$count    = get_post_meta( $postID, $countKey, true );
		if( $count == '' ) {
			$count = 0;
			delete_post_meta( $postID, $countKey );
			add_post_meta( $postID, $countKey, '1' );
		} else {
			$count++;
			update_post_meta(
				$postID,
				$countKey,
				$count
			);
		}
	}
}



/**
 * Create Random text
 * ===============================================================================
 */

if( !function_exists( 'generateRandomString' ) ) {
	function generateRandomString($length = 10)
	{
		return substr( str_shuffle( str_repeat( $x = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil( $length / strlen( $x ) ) ) ), 1, $length );
	}
}


/**
 * Show input categories with hierachical and args
 * ===============================================================================
 */

if( !function_exists( 'show_categories_hierachical_input_checkbox' ) ) {

	function show_categories_hierachical_input_checkbox($args, $name_input = '', $categories_checked = [])
	{
		$default = array(
			'type'         => 'post',
			'child_of'     => 0,
			'parent'       => '',
			'orderby'      => 'name',
			'order'        => 'ASC',
			'hide_empty'   => 0,
			'hierarchical' => 1,
			'exclude'      => '',
			'include'      => '',
			'number'       => '',
			'taxonomy'     => 'category',
			'pad_counts'   => false,
		);

		$args_query      = wp_parse_args( (array) $args, $default );
		$list_categories = get_categories( $args_query );

		if( $list_categories ) {
			echo '<ul style="background: white;border: 1px solid #8c8f94;border-radius: 5px;padding: 12px;height: 200px;overflow: auto;">';
			foreach( $list_categories as $category ) {
				if( !$category->category_parent ) {
					show_category_input_checkbox( $category, $name_input, $categories_checked, $args_query );
				}
			}
			echo '</ul>';
		}
	}
}

// Call in function show_categories_hierachical_input_checkbox($args, $name_input , $categories_checked)

if( !function_exists( 'show_category_input_checkbox' ) ) {


	function show_category_input_checkbox($category, $name_input, $categories_checked, $args_query)
	{
		?>
		<li style="list-style: none; margin-bottom: 10px;">
			<label>
				<input class="checkbox"
					type="checkbox"
					name="<?php echo $name_input; ?>"
					value="<?php echo $category->cat_ID; ?>"
					<?php checked( in_array( $category->cat_ID, $categories_checked ) ) ?>
					style="height:1rem; width:1rem; margin-bottom:0;">
				<?php echo $category->name; ?>
				</input>
			</label>
			<?php
			$args_query['parent'] = $category->cat_ID;

			$list_categories_child = get_categories( $args_query );

			if( $list_categories_child ) {
				echo '<ul class="chilrent" style="margin: 7px 0 0 25px; padding-left:0px;">';
				foreach( $list_categories_child as $category_child ) {
					if( $category_child->category_parent == $category->cat_ID ) {
						show_category_input_checkbox( $category_child, $name_input, $categories_checked, $args_query );
					}
				}
				echo '</ul>';
			}
			?>
		</li>
		<?php
	}
}



/**
 * Return class col responsive with number input
 * ===============================================================================
 */

function get_class_div_col_responsive_boostrap($number_md = 3, $number_sm = 3, $number_xs = 2)
{
	$class_col = 'col';

	switch( $number_md ) {
		case 1:
			$class_col .= ' col-lg-12';
			break;
		case 2:
			$class_col .= ' col-lg-6';
			break;
		case 3:
			$class_col .= ' col-lg-4';
			break;
		case 4:
			$class_col .= ' col-lg-3';
			break;
		default:
			$class_col .= ' col-lg-2';
			break;
	}

	switch( $number_sm ) {
		case 1:
			$class_col .= ' col-sm-12';
			break;
		case 2:
			$class_col .= ' col-sm-6';
			break;
		case 3:
			$class_col .= ' col-sm-4';
			break;
		case 4:
			$class_col .= ' col-sm-3';
			break;
		default:
			$class_col .= ' col-sm-2';
			break;
	}

	switch( $number_xs ) {
		case 1:
			$class_col .= ' col-12';
			break;
		case 2:
			$class_col .= ' col-6';
			break;
		case 3:
			$class_col .= ' col-4';
			break;
		case 4:
			$class_col .= ' col-3';
			break;
		default:
			$class_col .= ' col-2';
			break;
	}

	return $class_col;
}


/**
 * Return class col responsive with number input
 * ===============================================================================
 */

function get_class_div_col_responsive_flatsome($number_md = 3, $number_sm = 3, $number_xs = 2)
{
	$class_col = 'col';

	switch( $number_md ) {
		case 1:
			$class_col .= ' large-12';
			break;
		case 2:
			$class_col .= ' large-6';
			break;
		case 3:
			$class_col .= ' large-4';
			break;
		case 4:
			$class_col .= ' large-3';
			break;
		default:
			$class_col .= ' large-2';
			break;
	}

	switch( $number_sm ) {
		case 1:
			$class_col .= ' medium-12';
			break;
		case 2:
			$class_col .= ' medium-6';
			break;
		case 3:
			$class_col .= ' medium-4';
			break;
		case 4:
			$class_col .= ' medium-3';
			break;
		default:
			$class_col .= ' medium-2';
			break;
	}

	switch( $number_xs ) {
		case 1:
			$class_col .= ' small-12';
			break;
		case 2:
			$class_col .= ' small-6';
			break;
		case 3:
			$class_col .= ' small-4';
			break;
		case 4:
			$class_col .= ' small-3';
			break;
		default:
			$class_col .= ' small-2';
			break;
	}

	return $class_col;
}



//
function pt_customize_flatsome_posts_pagination($wp_query)
{

	$prev_arrow = is_rtl() ? get_flatsome_icon( 'icon-angle-right' ) : get_flatsome_icon( 'icon-angle-left' );
	$next_arrow = is_rtl() ? get_flatsome_icon( 'icon-angle-left' ) : get_flatsome_icon( 'icon-angle-right' );

	$total = $wp_query->max_num_pages;
	$big   = 999999999; // need an unlikely integer
	if( $total > 1 ) {

		if( get_option( 'permalink_structure' ) ) {
			$format = 'page/%#%/';
		} else {
			$format = '&paged=%#%';
		}

		$base_url = str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) );

		$list_url = explode( '?', $base_url );

		if( !empty( $list_url[0] ) ) {
			$base_url = $list_url[0];
		}

		$pages = paginate_links( array(
			'base'      => $base_url,
			'format'    => $format,
			'current'   => max( 1, get_query_var( 'paged' ) ),
			'total'     => $total,
			'mid_size'  => 3,
			'type'      => 'array',
			'prev_text' => $prev_arrow,
			'next_text' => $next_arrow,
		) );

		if( is_array( $pages ) ) {
			echo '<ul class="page-numbers nav-pagination links text-center" translate="no">';
			foreach( $pages as $page ) {
				$page = str_replace( "page-numbers", "page-number", $page );
				echo "<li>$page</li>";
			}
			echo '</ul>';
		}
	}
}

/**
 * Convert Vietnamese characters with diacritics to non-signed characters.
 *
 * This function replaces Vietnamese accented characters in a given string
 * with their non-accented counterparts. It handles both lowercase and uppercase
 * characters across a variety of Vietnamese diacritics.
 *
 * @param string $str The input string containing Vietnamese characters.
 * @return string The modified string with non-signed characters.
 */
function coverChartVNToNonSigned($str)
{
	$str = preg_replace( "/(à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ)/", "a", $str );
	$str = preg_replace( "/(è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ)/", "e", $str );
	$str = preg_replace( "/(ì|í|ị|ỉ|ĩ)/", "i", $str );
	$str = preg_replace( "/(ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ)/", "o", $str );
	$str = preg_replace( "/(ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ)/", "u", $str );
	$str = preg_replace( "/(ỳ|ý|ỵ|ỷ|ỹ)/", "y", $str );
	$str = preg_replace( "/(đ)/", "d", $str );
	$str = preg_replace( "/(À|Á|Ạ|Ả|Ã|Â|Ầ|Ấ|Ậ|Ẩ|Ẫ|Ă|Ằ|Ắ|Ặ|Ẳ|Ẵ)/", "A", $str );
	$str = preg_replace( "/(È|É|Ẹ|Ẻ|Ẽ|Ê|Ề|Ế|Ệ|Ể|Ễ)/", "E", $str );
	$str = preg_replace( "/(Ì|Í|Ị|Ỉ|Ĩ)/", "I", $str );
	$str = preg_replace( "/(Ò|Ó|Ọ|Ỏ|Õ|Ô|Ồ|Ố|Ộ|Ổ|Ỗ|Ơ|Ờ|Ớ|Ợ|Ở|Ỡ)/", "O", $str );
	$str = preg_replace( "/(Ù|Ú|Ụ|Ủ|Ũ|Ư|Ừ|Ứ|Ự|Ử|Ữ)/", "U", $str );
	$str = preg_replace( "/(Ỳ|Ý|Ỵ|Ỷ|Ỹ)/", "Y", $str );
	$str = preg_replace( "/(Đ)/", "D", $str );
	//$str = str_replace(" ", "-", str_replace("&*#39;","",$str));
	return $str;
}


/**
 * Format a number according to a specified locale.
 *
 * This function formats a given number based on the specified locale.
 * If the locale is 'vi_VN', it formats the number with thousand separators
 * using dots and no decimal places.
 *
 * @param mixed $number The input number to be formatted.
 * @param string $locale The locale for formatting, default is 'vi_VN'.
 * @return string|mixed The formatted number as a string, or the original input
 *                      if it's not numeric.
 */
function format_number($number, $locale = 'vi_VN')
{
	if( !is_numeric( $number ) ) {
		return $number;
	}

	if( $locale == 'vi_VN' ) {
		$number = number_format( $number, 0, ',', '.' );
	}

	return $number;
}

// Get Shortcode Inline CSS
function pt_get_shortcode_inline_css($args)
{
	$style = '';
	foreach( $args as $key => $value ) {
		$unit = array_key_exists( 'unit', $value ) ? $value['unit'] : null;
		if( $value['value'] )
			$style .= $value['attribute'] . ':' . $value['value'] . $unit . ';';
	}
	if( $style )
		return 'style="' . esc_attr( $style ) . '"';
}

// 
function parse_color_to_rgb_string($color)
{
	$color = trim( $color );

	// Kiểm tra hex (#000 hoặc #000000)
	if( preg_match( '/^#([a-fA-F0-9]{3}){1,2}$/', $color ) ) {
		$hex = ltrim( $color, '#' );
		if( strlen( $hex ) === 3 ) {
			$hex = $hex[0] . $hex[0] . $hex[1] . $hex[1] . $hex[2] . $hex[2];
		}
		$r = hexdec( substr( $hex, 0, 2 ) );
		$g = hexdec( substr( $hex, 2, 2 ) );
		$b = hexdec( substr( $hex, 4, 2 ) );
		return "{$r} {$g} {$b}";
	}

	// Kiểm tra rgb hoặc rgba với dấu phẩy hoặc khoảng trắng
	if( preg_match( '/^rgba?\(([^)]+)\)$/', $color, $matches ) ) {
		$parts = preg_split( '/[\s,]+/', trim( $matches[1] ) );
		if( count( $parts ) >= 3 ) {
			$r = intval( $parts[0] );
			$g = intval( $parts[1] );
			$b = intval( $parts[2] );
			return "{$r} {$g} {$b}";
		}
	}

	// Kiểm tra rgb hoặc rgba với dấu cách (chuẩn CSS mới)
	if( preg_match( '/^rgba?\s*\(\s*([0-9]+)\s+([0-9]+)\s+([0-9]+)(?:\s*[,\/]\s*([0-9.]+))?\s*\)$/', $color, $matches ) ) {
		$r = intval( $matches[1] );
		$g = intval( $matches[2] );
		$b = intval( $matches[3] );
		return "{$r} {$g} {$b}";
	}

	return false; // Không phải màu hợp lệ
}


/**
 * Loại bỏ dấu tiếng Việt khỏi chuỗi
 */
function remove_vietnamese_accents($str)
{
	$str = preg_replace( [ 
		'/[áàảãạăắằẳẵặâấầẩẫậ]/u',
		'/[ÁÀẢÃẠĂẮẰẲẴẶÂẤẦẨẪẬ]/u',
		'/[éèẻẽẹêếềểễệ]/u',
		'/[ÉÈẺẼẸÊẾỀỂỄỆ]/u',
		'/[íìỉĩị]/u',
		'/[ÍÌỈĨỊ]/u',
		'/[óòỏõọôốồổỗộơớờởỡợ]/u',
		'/[ÓÒỎÕỌÔỐỒỔỖỘƠỚỜỞỠỢ]/u',
		'/[úùủũụưứừửữự]/u',
		'/[ÚÙỦŨỤƯỨỪỬỮỰ]/u',
		'/[ýỳỷỹỵ]/u',
		'/[ÝỲỶỸỴ]/u',
		'/[đ]/u',
		'/[Đ]/u',
	], [ 
		'a', 'A', 'e', 'E', 'i', 'I', 'o', 'O', 'u', 'U', 'y', 'Y', 'd', 'D',
	], $str );
	return $str;
}

/**
 * Summary of cover_string_to_slug
 * @param string $title
 * @return string
 */
function cover_string_to_slug($title)
{
	// Chuyển về chữ thường
	$title = mb_strtolower( $title, 'UTF-8' );

	// Loại bỏ dấu tiếng Việt
	$title = remove_vietnamese_accents( $title );

	// Loại bỏ ký tự đặc biệt
	$title = preg_replace( '/[^a-z0-9\s-]/', '', $title );

	// Thay thế khoảng trắng và dấu gạch ngang liên tiếp thành 1 dấu gạch ngang
	$title = preg_replace( '/[\s-]+/', '-', $title );

	// Thay thế dấu gạch ngang liên tiếp thành 1 dấu gạch ngang
	$title = preg_replace( '/[--]+/', '-', $title );

	// Loại bỏ dấu gạch ngang ở đầu và cuối
	$title = trim( $title, '-' );

	return $title;
}

function get_style_responsive($name, $lg, $md, $sm) : string
{
	$style = '';

	if( !empty( $lg ) ) {
		$style .= '--' . $name . ': ' . $lg . ';';
	}
	if( !empty( $md ) ) {
		$style .= '--' . $name . '-md: ' . $md . ';';
	}
	if( !empty( $sm ) ) {
		$style .= '--' . $name . '-sm: ' . $sm . ';';
	}

	return $style;
}