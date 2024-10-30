<?php
/* Template Name: カスタムクリエイト */

if(!defined('ABSPATH')) exit;

/* カスタム投稿タイプ追加 */
function connect_products_with_shopify_shopify_create_post_type()
{
	/* 商品 */
	register_post_type(
		'product', //post-type
		array(
			'labels' => array(
				'name' => esc_html__('Product', 'mainichi-shopify-products-connect'), //商品
				'singular_name' => esc_html__('Product', 'mainichi-shopify-products-connect') //商品
			),
			'public' => true,
			'has_archive' => true,
			'show_in_rest' => true,
			'menu_position' => 4,
			'supports' => array(
				'title', 'editor', 'thumbnail',
				'custom-fields', 'excerpt', 'author', 'trackbacks',
				'comments', 'revisions', 'page-attributes'
			)
		)
	);

	register_taxonomy(
		'product_cat',
		'product',
		array(
			'hierarchical' => true,
			'update_count_callback' => '_update_post_term_count',
			'label' => esc_html__('Product Type', 'mainichi-shopify-products-connect'), //商品タイプ
			'singular_label' => esc_html__('Product Type', 'mainichi-shopify-products-connect'), //商品タイプ
			'public' => true,
			'show_ui' => true,
			'show_in_rest' => true
		)
	);

	register_taxonomy(
		'product_tag',
		'product',
		array(
			'hierarchical' => true,
			'update_count_callback' => '_update_post_term_count',
			'label' => esc_html__('Tags', 'mainichi-shopify-products-connect'), //タグ
			'singular_label' => esc_html__('Tags', 'mainichi-shopify-products-connect'), //タグ
			'public' => true,
			'show_ui' => true,
			'show_in_rest' => true
		)
	);
}
add_action('init', 'connect_products_with_shopify_shopify_create_post_type');

/* 管理画面商品一覧ページに項目追加 */
function connect_products_with_shopify_shopify_add_posts_columns_thumbnail($columns) {
	$columns = array(
		'cb' => '<input type="checkbox" />',
		'product_thumbnail' => esc_html__('Product Image', 'mainichi-shopify-products-connect'), //商品画像
		'product_id' => esc_html__('Product ID', 'mainichi-shopify-products-connect'), //商品ID
		'title' => esc_html__('Product Name', 'mainichi-shopify-products-connect'), //商品名
		'price' => esc_html__('Price', 'mainichi-shopify-products-connect'), //価格
		'total_stock' => esc_html__('Total stock quantity', 'mainichi-shopify-products-connect'), //合計在庫数
		'product_type' => esc_html__('Product type', 'mainichi-shopify-products-connect'), //商品タイプ
		'author' => esc_html__('Author', 'mainichi-shopify-products-connect'), //投稿者
		'date' => esc_html__('Date', 'mainichi-shopify-products-connect'), //日付
	);
	return $columns;
}
function connect_products_with_shopify_shopify_add_posts_columns_thumbnail_row($column_name, $post_id) {
	if ('product_thumbnail' == $column_name) {
		$image = esc_url(get_post_meta($post_id, 'product_first_image', true));
		if(!empty($image)){
			$html = '<img src="'.$image.'" class="thumbnailImage" width="120" height="auto" decoding="async" loading="lazy">';
		}else{
			$html = '—';
		}
	}elseif('product_id' == $column_name){
		$product_id = esc_html(get_post_meta($post_id, 'product_id', true));
		if(!empty($product_id)){
			$html = $product_id;
		}else{
			$html = '—';
		}
	}elseif('total_stock' == $column_name){
		$total_stock = esc_html(get_post_meta($post_id, 'total_stock', true));
		if(!empty($total_stock)){
			$html = $total_stock;
		}else{
			$html = '—';
		}
	}elseif('price' == $column_name){
		$min_price = esc_html(get_post_meta($post_id, 'min_price', true));
		$max_price = esc_html(get_post_meta($post_id, 'max_price', true));

		if(!empty($min_price) || !empty($max_price)){
			if(!empty($min_price)){$min_price = connect_products_with_shopify_number_format($min_price);}
			if(!empty($max_price)){$max_price = connect_products_with_shopify_number_format($max_price);}
			if($min_price == $max_price){
				$html = $min_price;
			}else{
				$html = $min_price.' - '.$max_price;
			}
		}else{
			$html = '—';
		}
	}elseif('product_type' == $column_name){
		$taxonomy_name = 'product_cat';
		$category_term = wp_get_post_terms($post_id, $taxonomy_name, array('orderby' => 'slug'));
		if ($category_term){
			$category = '';
			foreach ( $category_term as $val ){
				$category .= $val->name;
				if ($val !== end($category_term)) {
					$category .= ',';
				}
			}
		}
		if(!empty($category)){
			$html = $category;
		}else{
			$html = '—';
		}
	}

	echo $html;
}
add_filter('manage_product_posts_columns', 'connect_products_with_shopify_shopify_add_posts_columns_thumbnail', 1);
add_action('manage_product_posts_custom_column', 'connect_products_with_shopify_shopify_add_posts_columns_thumbnail_row', 10, 2);

/* ダッシュボードにメニューの追加 */
function connect_products_with_shopify_shopify_create_custom_menu_page()
{
	require CONNECT_PRODUCTS_WITH_SHOPIFY__PLUGIN_DIR . 'shopify_settings.php';
}
function connect_products_with_shopify_shopify_register_custom_menu_page()
{
	add_menu_page( esc_html__('Shopify Connection', 'mainichi-shopify-products-connect'), esc_html__('Shopify Connection', 'mainichi-shopify-products-connect'), 'administrator', 'shopify_settings', 'connect_products_with_shopify_shopify_create_custom_menu_page', 'dashicons-cart', 3);
}
add_action('admin_menu', 'connect_products_with_shopify_shopify_register_custom_menu_page');
