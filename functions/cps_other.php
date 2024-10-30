<?php
/* Template Name: その他 */

if(!defined('ABSPATH')) exit;

/* CSS圧縮 */
function connect_products_with_shopify_css_simple_minify($css)
{
	if( $css != '' ){
		//Character Code削除
		$css = str_replace( '@charset "utf-8";', '', $css );
		$css = str_replace( '@charset"utf-8";', '', $css );
		//コメント削除
		$css = preg_replace( '!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $css );
		//改行削除
		$css = str_replace( array("\r\n", "\r", "\n", "\t" ), '', $css );
		//スペース削除
		$css = str_replace( array( '  ', '    ', '    '), '', $css );
		$css = str_replace( ': ', ':', $css );
		$css = str_replace( ' :', ':', $css );
		$css = str_replace( ' }', '}', $css );
		$css = str_replace( '} ', '}', $css );
	}
	return $css;
}

/* カラーピッカーの生成関数 */
function connect_products_with_shopify_genelate_color_picker_tag($name, $value)
{
	echo '<input type="text" name="' . $name . '" value="' . $value . '">';
	wp_enqueue_script('wp-color-picker');
	$data = '(function( $ ) {
	var options = {
		defaultColor: false,
		change: function(event, ui){},
		clear: function() {},
		hide: true,
		palettes: true
	};
	$("input:text[name=' . $name . ']").wpColorPicker(options);
})( jQuery );';
	wp_add_inline_script('wp-color-picker', $data, 'after');
}

/* カラーピッカー用CSSの読み込み */
function connect_products_with_shopify_admin_print_styles()
{
	wp_enqueue_style('wp-color-picker');
}
add_action('admin_print_styles', 'connect_products_with_shopify_admin_print_styles');

/* Shopifyフォントスタイル選択 */
function connect_products_with_shopify_shopify_fontstyles_select($name, $shopifyFontStyle, $result)
{
	$shopifySelectFontStyles_SansSerif_array = array('Avant Garde', 'Gill Sans', 'Helvetica Neue', 'Helvetica Neue Bold', 'Arial', 'Candara', 'Geneva', 'Droid Sans', 'Droid Sans Bold', 'Lato', 'Lato Bold', 'Montserrat', 'Montserrat Bold', 'Open Sans', 'Open Sans Bold', 'PT Sans', 'PT Sans Bold', 'Quantico', 'Quantico Bold', 'Roboto', 'Roboto Bold', 'Source Sans Pro', 'Source Sans Pro Bold', 'Karla', 'Karla Bold', 'Raleway', 'Raleway Bold', 'Strait', 'Strait Bold', 'Josefin Slab', 'Josefin Slab Bold', 'Oxygen', 'Oxygen Bold');

	$shopifySelectFontStyles_Serif_array = array('Big Caslon', 'Calisto MT', 'Baskerville', 'Garamond', 'Times New Roman', 'Arvo', 'Arvo Bold', 'Crimson Text', 'Crimson Text Bold', 'Droid Serif', 'Droid Serif Bold', 'Lora', 'Lora Bold', 'Old Standard', 'Old Standard Bold', 'PT Serif', 'PT Serif Bold', 'Vollkorn', 'Vollkorn Bold', 'Playfair', 'Playfair Bold');

	$shopifySelectFontStyles_SansSerif = '';
	$shopifySelectFontStyles_Serif = '';

	foreach ($shopifySelectFontStyles_SansSerif_array as $key => $val) {
		if ($shopifyFontStyle == $val) {
			$selected = ' selected';
			$fontGroup = 'Sans Serif';
		} else {
			$selected = '';
		}
		$shopifySelectFontStyles_SansSerif .= '<option value="' . $val . '"' . $selected . '>' . $val . '</option>';
	}
	foreach ($shopifySelectFontStyles_Serif_array as $key => $val) {
		if ($shopifyFontStyle == $val) {
			$selected = ' selected';
			$fontGroup = 'Serif';
		} else {
			$selected = '';
		}
		$shopifySelectFontStyles_Serif .= '<option value="' . $val . '"' . $selected . '>' . $val . '</option>';
	}
	if ($result == 'fontStyle') {
		echo '<select name="' . $name . '"><optgroup label="Sans Serif">' . $shopifySelectFontStyles_SansSerif . '</optgroup><optgroup label="Serif">' . $shopifySelectFontStyles_Serif . '</optgroup></select>';
	} elseif ($result == 'fontGroup') {
		return $fontGroup;
	}
}

/* 商品の削除 */
function connect_products_with_shopify_delete_all_products()
{
	$arr = array(
		'post_type'   => array('product'), //投稿タイプ指定
		'post_status' => 'any',
		'numberposts' => -1, //表示数指定（-1は全取得）
		'meta_query' => array(
			array(
				'key' => 'shopify_product',
				'value' => true,
				'compare' => '=' //Shopifyの商品のみ
			)
		)
	);
	$arrPosts = get_posts($arr);
	if($arrPosts):foreach($arrPosts as $post):setup_postdata($post);
	$postID = $post->ID;
	wp_delete_post( $postID, true );
	endforeach;endif;wp_reset_postdata();

	$arr = array(
		'post_type'   => array('product'), //投稿タイプ指定
		'post_status' => 'trash', //ゴミ箱
		'numberposts' => -1, //表示数指定（-1は全取得）
		'meta_query' => array(
			array(
				'key' => 'shopify_product',
				'value' => true,
				'compare' => '=' //Shopifyの商品のみ
			)
		)
	);
	$arrPosts = get_posts($arr);
	if($arrPosts):foreach($arrPosts as $post):setup_postdata($post);
	$postID = $post->ID;
	wp_delete_post( $postID, true );
	endforeach;endif;wp_reset_postdata();
}

/* タームの削除 */
function connect_products_with_shopify_delete_all_taxonomy()
{
	//タクソノミーを再登録
	register_taxonomy('product_cat','product');
	register_taxonomy('product_tag','product');
	$termArr = get_terms('product_cat');
	foreach ($termArr as $key => $val){
		wp_delete_term($val->term_id, 'product_cat');
	}
	$termArr = get_terms('product_tag');
	foreach ($termArr as $key => $val){
		wp_delete_term($val->term_id, 'product_tag');
	}
}

/* 連携した全商品を削除ボタンクリックで実行 */
function connect_products_with_shopify_ajax_shopifyDeleteFunc()
{
	$trapInput = sanitize_email($_POST['email_t']);

	//削除成功
	if (empty($trapInput) && (!isset($_POST['nonce connectFormNonce']) || !wp_verify_nonce($_POST['nonce connectFormNonce'], 'connectForm'))) {
		connect_products_with_shopify_delete_all_products(); //商品の削除
		$resultMessage .= '<div class="resultMessage resultMessageSuccess">';
		$resultMessage .= '<img src="' . CONNECT_PRODUCTS_WITH_SHOPIFY__PLUGIN_URL . '/img/check.svg" width="64" height="64"><span>'.$post_product_count.esc_html__(' All products have been deleted', 'mainichi-shopify-products-connect').'</span>'; //全商品を削除しました
		$resultMessage .= '</div>';
	} else { //削除失敗
		$resultMessage .= '<div class="resultMessage resultMessageError">';
		$resultMessage .= '<img src="' . CONNECT_PRODUCTS_WITH_SHOPIFY__PLUGIN_URL . '/img/exclamation.svg" width="64" height="64"><span>'.esc_html__('Failed to delete', 'mainichi-shopify-products-connect').'</span>'; //削除に失敗しました
		$resultMessage .= '</div>';
	}

	echo $resultMessage;
	die(); // 「0」付与防止
}
add_action('wp_ajax_shopifyDelete', 'connect_products_with_shopify_ajax_shopifyDeleteFunc');
add_action('wp_ajax_nopriv_shopifyDelete', 'connect_products_with_shopify_ajax_shopifyDeleteFunc');

/* 価格を3桁区切りでカンマ＆通貨記号付与 */
function connect_products_with_shopify_number_format($price)
{
	$ConnectProductsShopifyShopData = get_option('ConnectProductsShopifyShopData'); //オプションを取得
	$money_format = $ConnectProductsShopifyShopData['money_format_unencode'];

	if(strstr($money_format,'amount_no_decimals') == true){
		//小数点なし・3桁毎に「カンマ」
		$format_price = number_format($price);
		$display_price = str_replace('{{amount_no_decimals}}', $format_price, $money_format);
	}
	elseif(strstr($money_format,'amount_with_comma_separator') == true){
		//小数点2桁・桁の区切り「ドット」・小数点を「カンマ」・3桁毎に「ドット」
		$format_price = number_format($price, 2, ',', '.');
		$display_price = str_replace('{{amount_with_comma_separator}}', $format_price, $money_format);
	}
	else{ //amount
		//小数点2桁・3桁毎に「カンマ」
		$format_price = number_format($price, 2);
		$display_price = str_replace('{{amount}}', $format_price, $money_format);
	}
	return $display_price;
}

/* METAクエリー展開 */
function connect_products_with_shopify_array_meta_query($attsName,$attsKey,$relation) {
	$valueArr = explode(',',esc_html($attsName)); //カンマで区切って配列化
	$valueQueryArr = array(array('relation' => $relation));

	foreach ($valueArr as $key => $val){
		$valueQueryArr[0][] = array(
			'key' => $attsKey,
			'value' => $val,
			'compare' => '='
		);
	}
	return $valueQueryArr;
}

/* タクソノミー（商品タイプ・タグ）のクエリー */
function connect_products_with_shopify_array_tax_query($taxonomy,$taxArr) {
			$taxQueryArrChild = array(
				'taxonomy' => $taxonomy, //タクソノミーを指定
				'field' => 'slug', //スラッグで指定
				'terms' => $taxArr, //タームを指定
				'operator' => 'IN' //指定タームのいずれかに一致
			);
	return $taxQueryArrChild;
}

/* dns-prefetchをhead内に出力 */
function connect_products_with_shopify_add_to_head() {
	echo "
		<meta http-equiv='x-dns-prefetch-control' content='on'>
		<link rel='dns-prefetch' href='//cdn.shopify.com' />
		<link rel='dns-prefetch' href='//sdks.shopifycdn.com' />"."\n"."\n";
}
add_action( 'wp_enqueue_scripts', 'connect_products_with_shopify_add_to_head' );

/* 管理画面ファイル読み込み */
function connect_products_with_shopify_enqueue_admin_style_script()
{
	wp_enqueue_style('cps_admin-style', CONNECT_PRODUCTS_WITH_SHOPIFY__PLUGIN_URL . '/css/style_admin.css', array(), date("ymdHis", filemtime(CONNECT_PRODUCTS_WITH_SHOPIFY__PLUGIN_DIR . '/css/style_admin.css')), 'all');
}
add_action('admin_enqueue_scripts', 'connect_products_with_shopify_enqueue_admin_style_script');

/* AjaxリクエストURL */
function connect_products_with_shopify_add_my_ajaxurl()
{
?><script>
	var ajaxurl = '<?php echo admin_url('admin-ajax.php'); ?>';
</script><?php
}
?>