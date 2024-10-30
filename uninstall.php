<?php
if(!defined('WP_UNINSTALL_PLUGIN')){exit();}

/* 商品の削除 */
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

/* タームの削除 */
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

/* オプションの削除 */
//API情報
delete_option('ConnectProductsShopifyApiData');
//設定情報
delete_option('ConnectProductsShopifySettingsData');
//ショップ情報
delete_option('ConnectProductsShopifyShopData');
?>