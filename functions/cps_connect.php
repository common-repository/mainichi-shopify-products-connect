<?php
/* Template Name: 商品連携 */

if(!defined('ABSPATH')) exit;

/* Shopify商品連携ボタンクリックで実行 */
function connect_products_with_shopify_ajax_shopifyConnectFunc()
{
	/* API情報 */
	$ConnectProductsShopifyApiData = get_option('ConnectProductsShopifyApiData');
	if(!empty($ConnectProductsShopifyApiData)){
		foreach ($ConnectProductsShopifyApiData as $key => $val){
			$$key = esc_html($val);
		}
	}

	$trapInput = sanitize_email($_POST['email_t']);

	//連携成功
	if (!empty($shopifyStoreUrl) && !empty($shopifyApiKey) && !empty($shopifyPassword) && !empty($shopifySecretShare) && !empty($shopifyStorefrontAccessToken) && empty($trapInput) && (!isset($_POST['nonce connectFormNonce']) || !wp_verify_nonce($_POST['nonce connectFormNonce'], 'connectForm'))) {

		/* 商品連携 */
		//REST取得
		$products_obj_url = $shopifyApiUrl . '/admin/products.json';
		$products_content = wp_remote_get($products_obj_url);
		$products_json = json_decode($products_content['body'], true);
		$products = $products_json['products'];
		//レスポンスヘッダーから「link」の値を取得
		$producResponseHeaderLink = $products_content['headers']['link'];

		$checkouts_obj_url = $shopifyApiUrl . '/admin/checkouts.json';
		$checkouts_content = wp_remote_get($checkouts_obj_url);
		$checkouts_json = json_decode($checkouts_content['body'], true);
		$checkouts = $checkouts_json['checkouts'];

		$count_obj_url = $shopifyApiUrl . '/admin/products/count.json';
		$count_content = wp_remote_get($count_obj_url);
		$count_json = json_decode($count_content['body'], true);
		$count = $count_json['count'];

		//カテゴリー＆タグ作成用
		if (file_exists(ABSPATH . '/wp-admin/includes/taxonomy.php')) {
			require_once(ABSPATH . '/wp-admin/includes/taxonomy.php');
		}

		//登録数カウント用
		$post_product_count = 0;
		//制限対応用
		$i = 0;
		$pages = ceil($count / 50);
		for ($i = 0; $i < $pages; $i++) {

			//商品登録
			foreach ((array)$products as $product) {

				//カテゴリー作成＆登録
				$term_name = $product['product_type']; //商品タイプ取得
				if(!empty($term_name)){
					$term = get_term_by('name', $term_name, 'product_cat'); //商品タイプ名からターム情報取得
					$term_id = $term->term_id; //タームID取得

					if ($term_id != 0 || !$term_id) { //タームIDが存在しない場合、ターム（カテゴリー）作成
						//翻訳
						$text = sanitize_text_field($term_name);
						$from = "auto";
						$to   = "en";
						$result = connect_products_with_shopify_google_translate($from, $to, $text);

						$add_cat = array(
							'cat_name' => $term_name,
							'category_nicename' => $result,
							'taxonomy' => 'product_cat'
						);
						wp_insert_category($add_cat); //カテゴリーを作成

						$term = get_term_by('name', $term_name, 'product_cat'); //ターム情報再取得
						$term_id = $term->term_id; //タームID再取得
					}
				}

				//タグ
				$tags = $product['tags']; //タグ取得
				if(!empty($tags)){
					$tagsArr = explode(", ", $tags); //カンマ区切りで配列化
					$tagsSlug = array(); //配列初期化

					foreach ($tagsArr as $key => $val) {
						$tag = get_term_by('name', $val, 'product_tag'); //タグ名からターム情報取得
						$tag_id = $tag->term_id; //タームID取得

						if ($tag_id != 0 || !$tag_id) { //タームIDが存在しない場合、ターム（タグ）作成
							//翻訳
							$text = sanitize_text_field($val);
							$from = "auto";
							$to   = "en";
							$result = connect_products_with_shopify_google_translate($from, $to, $text);

							$add_tag = array(
								'cat_name' => $val,
								'category_nicename' => $result,
								'taxonomy' => 'product_tag'
							);
							wp_insert_category($add_tag); //タグを作成

						}
						$tag = get_term_by('name', $val, 'product_tag'); //ターム情報再取得
						$tagsSlug[] = $tag->slug; //タームスラッグ取得して配列に入れる
					}
				}

				$productID = sanitize_text_field($product['id']);
				$published = sanitize_text_field($product['status']);
				if ($published == 'active') {
					$published = 'publish';
				} else {
					$published = 'private';
				}

				$productData = get_page_by_path($productID, OBJECT, 'product'); //存在するスラッグか確認

				if (empty($productData)) {
					$add_product = array(
						'post_type'     => 'product', //投稿タイプ
						'post_title'    => sanitize_text_field($product['title']), //商品タイトル
						'post_content'  => sanitize_text_field($product['body_html']), //商品説明
						'post_name'     => $productID, //スラッグ
						'post_status'   => $published, //公開状態
						'post_date'     => sanitize_text_field($product['created_at']), //登録日
						'tax_input'     => array('product_cat' => array($term_id)), //カテゴリー
					);
					wp_insert_post($add_product);
					$productData = get_page_by_path($productID, OBJECT, 'product');
					$postID = $productData->ID; //スラッグからID取得
				} else {
					$postID = $productData->ID; //スラッグからID取得
					$update_product = array(
						'ID'            => $postID,
						'post_type'     => 'product',
						'post_title'    => sanitize_text_field($product['title']),
						'post_content'  => sanitize_text_field($product['body_html']),
						'post_status'   => $published,
						'post_date'     => sanitize_text_field($product['created_at']),
						'tax_input'     => array('product_cat' => array($term_id)),
					);
					wp_insert_post($update_product); //商品登録
				}

				wp_set_object_terms($postID, $tagsSlug, 'product_tag',true); //商品にタグ登録

				$vendor = $product['vendor']; //販売元取得
				if(!empty($vendor)){
					update_post_meta($postID, 'vendor', sanitize_text_field($vendor)); //販売元登録
				}

				update_post_meta($postID, 'product_id', sanitize_text_field($productID)); //商品ID登録

				$productImages = $product['images']; //商品画像取得
				if(!empty($productImages)){
					$productImagesSrc = "";

					foreach ($productImages as $key => $val) {
						$image = sanitize_text_field($val['src']);
						$productImagesSrc .= $image;
						if ($val === reset($productImages)) {
							update_post_meta($postID, 'product_first_image', $image); //最初の商品画像登録
						}
						if ($val !== end($productImages)) {
							$productImagesSrc .= "\n";
						}
					}

					if(!empty($productImagesSrc)){
						update_post_meta($postID, 'product_images', $productImagesSrc); //商品画像登録
					}
				}

				$productVariants = $product['variants']; //バリエーション取得
				if(!empty($productVariants)){
					$productVariantsData = "";
					$variationNum = 1;
					$productPriceArr = array();
					$productTotalStockArr = array();

					foreach ($productVariants as $key => $val) {
						$productVariantsData .= '[VARIATION-'.$variationNum.'] '; //ID
						$productVariantsData .= 'id:'.sanitize_text_field($val['id']).','; //ID

						$productVariantsData .= 'sku:'; //SKU
						$productVariantsSku = sanitize_text_field($val['sku']);
						if(empty($productVariantsSku)){
							$productVariantsData .= 'NULL,';
						}else{
							$productVariantsData .= $productVariantsSku.',';
						}

						$productVariantsData .= 'barcode:'; //バーコード
						$productVariantsBarcode = sanitize_text_field($val['barcode']);
						if(empty($productVariantsBarcode)){
							$productVariantsData .= 'NULL,';
						}else{
							$productVariantsData .= $productVariantsBarcode.',';
						}

						$productVariantsData .= 'option1:'; //オプション1
						$productVariantsOption1 = sanitize_text_field($val['option1']);
						if(empty($productVariantsOption1)){
							$productVariantsData .= 'NULL,';
						}else{
							$productVariantsData .= $productVariantsOption1.',';
						}

						$productVariantsData .= 'option2:'; //オプション2
						$productVariantsOption2 = sanitize_text_field($val['option2']);
						if(empty($productVariantsOption2)){
							$productVariantsData .= 'NULL,';
						}else{
							$productVariantsData .= $productVariantsOption2.',';
						}

						$productVariantsData .= 'option3:'; //オプション3
						$productVariantsOption3 = sanitize_text_field($val['option3']);
						if(empty($productVariantsOption3)){
							$productVariantsData .= 'NULL,';
						}else{
							$productVariantsData .= $productVariantsOption3.',';
						}

						$productVariantsData .= 'price:'.sanitize_text_field($val['price']).','; //価格

						$productVariantsData .= 'compare_at_price:'; //割引前の価格
						$productVariantsCompareAtPrice = sanitize_text_field($val['compare_at_price']);
						if(empty($productVariantsCompareAtPrice)){
							$productVariantsData .= 'NULL,';
						}else{
							$productVariantsData .= $productVariantsCompareAtPrice.',';
						}

						$productVariantsData .= 'taxable:'; //税の有無
						$productVariantsTaxable = sanitize_text_field($val['taxable']);
						if($productVariantsTaxable == true){
							$productVariantsData .= 'true,';
						}else{
							$productVariantsData .= 'false,';
						}

						$productVariantsData .= 'inventory_quantity:'.sanitize_text_field($val['inventory_quantity']).','; //在庫数
						$productVariantsData .= 'weight:'.sanitize_text_field($val['weight']).','; //重さ
						$productVariantsData .= 'weight_unit:'.sanitize_text_field($val['weight_unit']).','; //重さの単位

						$productVariantsData .= 'requires_shipping:'; //商品発送の有無
						$productVariantsRequiresShipping = sanitize_text_field($val['requires_shipping']);
						if($productVariantsRequiresShipping == true){
							$productVariantsData .= 'true';
						}else{
							$productVariantsData .= 'false';
						}

						$productPriceArr[] = sanitize_text_field($val['price']); //価格を配列に入れる

						$productTotalStockArr[] = sanitize_text_field($val['inventory_quantity']); //在庫数を配列に入れる

						if ($val !== end($productVariants)) {
							$productVariantsData .= "\n";
						}
						++$variationNum;
					}
					update_post_meta($postID, 'variants_data', $productVariantsData); //バリエーション情報登録
				}

				$productPriceArr = array_unique($productPriceArr); //重複した値を削除
				update_post_meta($postID, 'max_price', max($productPriceArr)); //最高価格登録
				update_post_meta($postID, 'min_price', min($productPriceArr)); //最低価格登録

				$productTotalStock = array_sum($productTotalStockArr); //在庫数の配列内の値を合計
				update_post_meta($postID, 'total_stock', $productTotalStock); //合計在庫数登録

				update_post_meta($postID, 'shopify_product', true); //Shopify商品判別用

				do_action('cps_connect_register', $product); //アクションフック

				++$post_product_count; //登録数カウント
			}

			//URL「/admin/」以下を配列に入れ最後（Next）だけ取得
			if (preg_match_all('(/admin/[-_.!~*\'()a-zA-Z0-9;/?:@&=+$,%#]+)', $producResponseHeaderLink, $result) !== false) {
				foreach ($result[0] as $value) {
					if ($value == end($result[0])) {
						$producResponseHeaderNextUrl .= $value;
					}
				}
			}
			//商品REST再取得
			$products_obj_url = $shopifyApiUrl . $producResponseHeaderNextUrl;
			$products_content = wp_remote_get($products_obj_url);
			$products_json = json_decode($products_content['body'], true);
			$products = $products_json['products'];
			//レスポンスヘッダーから「link」の値を再取得
			$producResponseHeaderLink = $products_content['headers']['link'];
		}

		$resultMessage = '';
		if($post_product_count == 0){
			$resultMessage .= '<div class="resultMessage resultMessageError">';
			$resultMessage .= '<img src="' . CONNECT_PRODUCTS_WITH_SHOPIFY__PLUGIN_URL . '/img/exclamation.svg" width="64" height="64"><span>'.esc_html__('No product available', 'mainichi-shopify-products-connect').'</span>'; //商品がありません
			$resultMessage .= '</div>';
		}else{
			$resultMessage .= '<div class="resultMessage resultMessageSuccess">';
			$resultMessage .= '<img src="' . CONNECT_PRODUCTS_WITH_SHOPIFY__PLUGIN_URL . '/img/check.svg" width="64" height="64"><span>'.$post_product_count.esc_html__(' Products have been connected', 'mainichi-shopify-products-connect').'</span>'; //商品を連携しました
			$resultMessage .= '</div>';
		}
	} else { //連携失敗
		$resultMessage .= '<div class="resultMessage resultMessageError">';
		$resultMessage .= '<img src="' . CONNECT_PRODUCTS_WITH_SHOPIFY__PLUGIN_URL . '/img/exclamation.svg" width="64" height="64"><span>'.esc_html__('Failed to connect', 'mainichi-shopify-products-connect').'</span>'; //連携に失敗しました
		$resultMessage .= '</div>';
	}

	echo $resultMessage;
	die(); // 「0」付与防止
}
add_action('wp_ajax_shopifyConnect', 'connect_products_with_shopify_ajax_shopifyConnectFunc');
add_action('wp_ajax_nopriv_shopifyConnect', 'connect_products_with_shopify_ajax_shopifyConnectFunc');
?>