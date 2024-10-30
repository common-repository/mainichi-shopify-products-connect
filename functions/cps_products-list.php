<?php
/* Template Name: 商品一覧 */

if (!defined('ABSPATH')) exit;

/* 商品一覧表示ショートコード */
function connect_products_with_shopify_shopify_products_list_shortcode($atts)
{
	$ConnectProductsShopifySettingsData = get_option('ConnectProductsShopifySettingsData'); //設定情報取得
	$queryPrice = 'min_price'; //一覧で表示する価格（最低OR最高）デフォルト設定

	/* ショートコードの引数から取得 */
	//表示件数
	if (!empty($atts['limit']) && preg_match('/^[0-9]+$/', $atts['limit'])) {
		$limit = $atts['limit'];
	}else{
		$limit = 9;
	}
	//クリック時のアクション
	if (!empty($atts['action']) && ($atts['action'] == 'cart' || $atts['action'] == 'checkout' || $atts['action'] == 'modal')) {
		$action = $atts['action'];
	}else{
		$action = 'modal';
	}
	//アラインメント
	if (!empty($atts['alignment']) && ($atts['alignment'] == 'right' || $atts['alignment'] == 'left' || $atts['alignment'] == 'center')) {
		$alignment = $atts['alignment'];
	}else{
		$alignment = 'center';
	}
	//カラム数
	if (!empty($atts['column']) && preg_match('/^[0-9]+$/', $atts['column'])) {
		$column = $atts['column'];
	}else{
		$column = '3';
	}
	//バリエーションの表示
	if (!empty($atts['variation']) && $atts['variation'] == 'show') {
		$variation = 'show';
	}else{
		$variation = 'hide';
	}
	//数量フィールド付きボタン
	if (!empty($atts['quantity']) && $atts['quantity'] == 'show') {
		$quantity = 'show';
	}else{
		$quantity = 'hide';
	}
	//ボタンテキスト
	if (!empty($atts['text'])) {
		$text = $atts['text'];
	}else{
		$text = '';
	}

	$paged = (get_query_var('paged')) ? get_query_var('paged') : 1; //現在のページ数取得

	$arr = array(
		'paged' => $paged,
		'post_type'   => array('product'), //投稿タイプ指定
		'post_status' => 'any',
		'posts_per_page' => $limit, //表示数指定
		'order' => 'DESC', //並び順
		'meta_query' => array(
			array(
				'key' => 'total_stock',
				'value' => '0',
				'compare' => '!=' //在庫なしは対象外
			),
			array(
				'key' => 'shopify_product',
				'value' => true,
				'compare' => '=' //Shopifyの商品のみ
			)
		)
	);

	/* 表示条件の追加（引数から取得） */
	//絞り込み
	//商品タイプ OR タグ
	if (!empty($atts['type']) || !empty($atts['tag'])) {
		$taxQueryArr = array(
			'tax_query' => array('relation' => 'OR')
		);
		if (!empty($atts['type'])) {
			$taxonomy = 'product_cat';
			$typeArr = explode(',',esc_html($atts['type'])); //カンマで区切って配列化
			$taxQueryArr['tax_query'][] = connect_products_with_shopify_array_tax_query($taxonomy,$typeArr); //from:functions/cps_other.php
		}
		if (!empty($atts['tag'])) {
			$taxonomy = 'product_tag';
			$tagArr = explode(',',esc_html($atts['tag'])); //カンマで区切って配列化
			$taxQueryArr['tax_query'][] = connect_products_with_shopify_array_tax_query($taxonomy,$tagArr); //from:functions/cps_other.php
		}

		$arr = array_merge($arr,$taxQueryArr);
	}
	//販売元
	if (!empty($atts['vendor'])) {
		$attsKey = 'vendor';
		$relation = 'OR';
		$valueQueryArr = connect_products_with_shopify_array_meta_query($atts['vendor'],$attsKey,$relation); //from:functions/cps_other.php
		$arr['meta_query'] = array_merge($arr['meta_query'],$valueQueryArr);
	}
	//商品ID
	if (!empty($atts['id'])) {
		$attsKey = 'product_id';
		$relation = 'OR';
		$valueQueryArr = connect_products_with_shopify_array_meta_query($atts['id'],$attsKey,$relation); //from:functions/cps_other.php
		$arr['meta_query'] = array_merge($arr['meta_query'],$valueQueryArr);
	}

	//並び順
	if (!empty($atts['sort'])) {
		//古い順
		if ($atts['sort'] == 'old') {
			$arr = str_replace('DESC', 'ASC', $arr);
		}
		//価格：安い順or高い順
		if ($atts['sort'] == 'low-price' || $atts['sort'] == 'high-price') {

			if ($atts['sort'] == 'low-price') {
				$arr = str_replace('DESC', 'ASC', $arr);
				$arr = array_merge($arr,array('orderby' => 'meta_value_num','meta_key' => 'min_price'));
			}elseif($atts['sort'] == 'high-price') {
				$arr = array_merge($arr,array('orderby' => 'meta_value_num','meta_key' => 'max_price'));
				$queryPrice = 'max_price'; //一覧で表示する価格を最高価格に変更
			}
		}
	}

	//在庫なしも表示
	if (!empty($atts['stock']) && $atts['stock'] == 'show') {
		array_shift($arr['meta_query']); //配列「meta_query」の先頭のキーを削除
	}

	$arrPosts = new WP_Query($arr);
	if($arrPosts->have_posts()){
		/* CSS */
		$fontStyle = '';
		if(!empty($shopifyButtonFontStyle)){
			$fontStyle .= $shopifyButtonFontStyle;
		}
		if(!empty($shopifyProductNameFontStyle)){
			$fontStyle .= $shopifyProductNameFontStyle;
		}
		if(!empty($shopifyPriceFontStyle)){
			$fontStyle .= $shopifyPriceFontStyle;
		}
		if(!empty($shopifyVariationFontStyle)){
			$fontStyle .= $shopifyVariationFontStyle;
		}
		if(!empty($shopifyProductDescriptionFontStyle)){
			$fontStyle .= $shopifyProductDescriptionFontStyle;
		}
		$css = '<style type="text/css">'.connect_products_with_shopify_font_style_css($fontStyle).connect_products_with_shopify_buy_button_css($alignment,'unset').connect_products_with_shopify_list_inline_css($column,$alignment,$limit,$quantity).'</style>';

		/* 商品一覧 */
		$productsList = '';
		while($arrPosts->have_posts()) {
			$arrPosts->the_post();
			$postID = get_the_ID();
			$productID = esc_html(get_post_meta($postID, 'product_id', true)); //商品ID取得
			$name = esc_html(get_the_title()); //商品名取得
			$thumbnail = esc_html(wp_get_attachment_url(get_post_thumbnail_id())); //アイキャッチ画像取得
			$image = esc_html(get_post_meta($postID, 'product_first_image', true)); //Shopifyの最初の画像取得
			if(!empty($thumbnail)){
				$image = $thumbnail;
			}
			if(!empty($image)){
				$image = '<img src="'.$image.'" class="shopifyProductListItemImage shopify-buy__product__variant-img" width="1" height="1" alt="'.$name.'" decoding="async" loading="lazy">';
			}else{
				$image = '';
			}

			$price = connect_products_with_shopify_number_format(esc_html(get_post_meta($postID, $queryPrice, true))); //最低価格取得
			$buyButton = do_shortcode('[shopifyBuyButton id="'.$productID.'" layout="basic" action="'.$action.'" alignment="'.$alignment.'" variation="'.$variation.'" quantity="'.$quantity.'" text="'.$text.'" css="no-load"]'); //BUYボタン取得


			$productsList .= '
<div class="shopifyProductListItem shopify-buy__product">
	'.$image.'
	<span class="shopify-buy__product__title">'.$name.'</span>
	<div class="shopify-buy__product__price"><span class="shopify-buy__product__actual-price">'.$price.'</span></div>
	'.$buyButton.'
</div>';
		}
	}else{
		$productsList = '<div style="text-align: center; margin: 48px 0;">'.esc_html__('No product available', 'mainichi-shopify-products-connect').'</div>'; //商品がありません
	}
	wp_reset_postdata();

	//ページネーション表示・非表示
	if (!empty($atts['pagination']) && $atts['pagination'] == 'hide') {
		$pagination = "";
	}elseif(is_page() || is_archive()){
		if (!empty($atts['pagination-range']) && preg_match('/^[0-9]+$/', $atts['pagination-range'])) {
			$paginationRange = $atts['pagination-range'];
		}else{
			$paginationRange = 3;
		}
		$pagination = connect_products_with_shopify_pagination($arrPosts->max_num_pages,$paged,$paginationRange);
	}else{
		$pagination = "";
	}

	$html = $css."\n".'<div id="shopifyProductsListWrap"><div class="shopifyProductsList">'."\n".$productsList.'</div></div>'.$pagination;
	return apply_filters('cps_products_list_html',$html);
}
add_shortcode('shopifyProductsList', 'connect_products_with_shopify_shopify_products_list_shortcode');

/* ページネーション */
function connect_products_with_shopify_pagination( $pages, $paged, $range = 3 ) {

	$pages = ( int ) $pages;
	$paged = $paged ?: 1;

	$text_prev = arrow_left('return','');
	$text_next = arrow_right('return','');

	$html = '';

	if ( 1 !== $pages ) {
		$html .= '<div id="shopifyPagination">';
		if ( $paged > 1 ) {
			$html .= '<a href="'. esc_url(get_pagenum_link( $paged - 1 )) .'" class="paginationPrev paginationNav">'. $text_prev .'</a>';
		}
		for ( $i = 1; $i <= $pages; $i++ ) {

			if ( $i <= $paged + $range && $i >= $paged - $range ) {
				if ( $paged === $i ) {
					$html .= '<span class="paginationActive paginationNav">'. $i .'</span>';
				} else {
					$html .= '<a href="'. esc_url(get_pagenum_link( $i )) .'" class="paginationNav">'. $i .'</a>';
				}
			}
		}
		if ( $paged < $pages ) {
			$html .= '<a href="'. esc_url(get_pagenum_link( $paged + 1 )) .'" class="paginationNext paginationNav">'. $text_next .'</a>';
		}
		$html .= '</div>';
	}
	return $html;
}
?>