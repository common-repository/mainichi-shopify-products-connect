<?php
/*
	Template Name: Shopify連携
*/

if(!defined('ABSPATH')) exit;

/* API情報 */
$ConnectProductsShopifyApiData = get_option('ConnectProductsShopifyApiData');
$apiDataNameArr = array('shopifyStoreUrl','shopifyApiKey','shopifyPassword','shopifySecretShare','shopifyStorefrontAccessToken');
foreach ($apiDataNameArr as $key => $val){
	if(!empty($_POST['submit_shopify_data'])){
		if(!empty($_REQUEST[$val])){
			$ConnectProductsShopifyApiData[$val] = sanitize_text_field($_REQUEST[$val]);
		}else{
			unset($ConnectProductsShopifyApiData[$val]);
		}
	}
	if(!empty($ConnectProductsShopifyApiData[$val])){
		$$val = $ConnectProductsShopifyApiData[$val]; //可変変数
	}else{
		$$val = '';
	}
}

//API URL
$shopifyApiUrl = 'https://' . $shopifyApiKey . ':' . $shopifyPassword . '@' . $shopifyStoreUrl;
$ConnectProductsShopifyApiData['shopifyApiUrl'] = esc_url($shopifyApiUrl);

//連携確認
$access_tokens_obj_url = $shopifyApiUrl . '/admin/storefront_access_tokens.json';
$access_tokens_content = wp_remote_get($access_tokens_obj_url);
if (!is_wp_error($access_tokens_content) && $access_tokens_content['response']['code'] === 200){
	$access_tokens_json = json_decode($access_tokens_content['body'], true);
	$access_tokens = $access_tokens_json['storefront_access_tokens'];
	$storefront_access_token_tmp = $access_tokens[0]['access_token'];
}else{
	$storefront_access_token_tmp = '';
}
if($shopifyStorefrontAccessToken == $storefront_access_token_tmp && !empty($shopifyStoreUrl) && !empty($shopifyApiKey) && !empty($shopifyPassword) && !empty($shopifySecretShare) && !empty($shopifyStorefrontAccessToken)){
	$status = 'connect';
	$statusMessage = '<div class="updated"><p><img src="'.CONNECT_PRODUCTS_WITH_SHOPIFY__PLUGIN_URL.'/img/logo-shopify_em.svg" class="shopifyIcon" width="151" height="169" decoding="async" loading="lazy">
'.esc_html__('You have been connected to the Shopify store.', 'mainichi-shopify-products-connect').'</p></div>'; //Shopifyストアと連携されています。
	if(isset($_POST['submit_settings'])){
		$saveMessage = '<div class="saveMessage updated"><p>'.sprintf(esc_html__('%s saved.', 'mainichi-shopify-products-connect'), $_POST['submit_settings']).'</p></div>'; // ～を保存しました。
	}
}else{
	$status = 'disconnect';
	$cpsManualUrl = 'https://mainichi-web.com/how-to-connect-products-with-shopify/';
	$statusMessage = '<div class="error"><p>'.esc_html__('You are not connected to the Shopify store.Please go to "Shopify Connection Settings".', 'mainichi-shopify-products-connect').esc_html__('Please see the "Manual" tab for details on how to connect.', 'mainichi-shopify-products-connect').'</p></div>'; //Shopifyストアと連携されていません。「Shopify連携設定」を行ってください。連携方法は「マニュアル」タブをご覧ください。
}
$ConnectProductsShopifyApiData['shopifyConnectStatus'] = sanitize_text_field($status);
update_option('ConnectProductsShopifyApiData',$ConnectProductsShopifyApiData);


/* ボタン表示設定 */
$ConnectProductsShopifySettingsData = get_option('ConnectProductsShopifySettingsData');
//デフォルト値
$displayDataNameArr = array(
	//基本
	'displayLayoutStyle' => 'basic',
	'displayButtonDestination' => 'cart',
	'displayWithQuantity' => 'hide',
	'displayAlignment' => 'left',
	'displayClassicImageSize' => 'small',
	'displayClassicOtherImages' => 'hide',
	//ショッピングカート
	'cartDisplayNoteDescription' => 'show',
	//高度な設定
	'checkoutAction' => 'popup'
);

foreach($displayDataNameArr as $key => $val){
	if(!empty($_POST['submit_shopify_display'])){
		if(!empty($_REQUEST[$key])){
			$ConnectProductsShopifySettingsData[$key] = sanitize_text_field($_REQUEST[$key]);
		}else{
			$ConnectProductsShopifySettingsData[$key] = sanitize_text_field($val);
		}
	}else{
		if(empty($ConnectProductsShopifySettingsData[$key])){
			$ConnectProductsShopifySettingsData[$key] = sanitize_text_field($val);
		}
	}
	if(!empty($ConnectProductsShopifySettingsData[$key])){
		$$key = $ConnectProductsShopifySettingsData[$key]; //可変変数
	}else{
		$$key = '';
	}
}

//表示方法追加
if($ConnectProductsShopifySettingsData['displayLayoutStyle']  == 'fullview'){
	$ConnectProductsShopifySettingsData['displayLayoutStyleHorV'] = 'horizontal';
}else{
	$ConnectProductsShopifySettingsData['displayLayoutStyleHorV'] = 'vertical';
}
//画像サイズ数値化
if($ConnectProductsShopifySettingsData['displayClassicImageSize'] == 'large'){
	$ConnectProductsShopifySettingsData['displayClassicImageSize'] = '580';
}elseif($ConnectProductsShopifySettingsData['displayClassicImageSize'] == 'middle'){
	$ConnectProductsShopifySettingsData['displayClassicImageSize'] = '380';
}else{
	$ConnectProductsShopifySettingsData['displayClassicImageSize'] = '280';
}

/* CSS */
//デフォルト値
$cssDataNameArr = array(
	//ボタン
	'shopifyButtonRound' => '5',
	'shopifyButtonPadding' => '24',
	'shopifyButtonBackgroundColor' => '#333333',
	'shopifyButtonHoverBackgroundColor' => '#111111',
	'shopifyButtonFontColor' => '#ffffff',
	'shopifyButtonFontStyle' => 'Helvetica Neue Bold',
	'shopifyButtonFontSize' => '16',
	//ショッピングカート
	'shopifyCartBackgroundColor' => '#ffffff',
	'shopifyCartFontColor' => '#333333',
	//レイアウト
	'shopifyProductNameFontColor' => '#333333',
	'shopifyPriceFontColor' => '#333333',
	'shopifyVariationFontColor' => '#333333',
	'shopifyProductDescriptionFontColor' => '#333333',
	'shopifyProductNameFontStyle' => 'Helvetica Neue Bold',
	'shopifyPriceFontStyle' => 'Helvetica Neue',
	'shopifyVariationFontStyle' => 'Helvetica Neue Bold',
	'shopifyProductDescriptionFontStyle' => 'Helvetica Neue',
	'shopifyProductNameFontSize' => '16',
	'shopifyPriceFontSize' => '14',
	'shopifyVariationFontSize' => '14',
	'shopifyProductDescriptionFontSize' => '14'
);

foreach($cssDataNameArr as $key => $val){
	if(!empty($_POST['submit_shopify_css'])){
		if(!empty($_REQUEST[$key])){
			$ConnectProductsShopifySettingsData[$key] = sanitize_text_field($_REQUEST[$key]);
		}else{
			$ConnectProductsShopifySettingsData[$key] = sanitize_text_field($val);
		}
	}else{
		if(empty($ConnectProductsShopifySettingsData[$key])){
			$ConnectProductsShopifySettingsData[$key] = sanitize_text_field($val);
		}
	}
	if(!empty($ConnectProductsShopifySettingsData[$key])){
		$$key = $ConnectProductsShopifySettingsData[$key]; //可変変数
	}else{
		$$key = '';
	}
}

//ボタンの高さ
$ConnectProductsShopifySettingsData['shopifyButtonPaddingHeight'] = $ConnectProductsShopifySettingsData['shopifyButtonFontSize'] + ($ConnectProductsShopifySettingsData['shopifyButtonFontSize'] * -0.5 + 8);
//ユニット価格の文字サイズ
$ConnectProductsShopifySettingsData['shopifyUnitPriceFontSize'] = $ConnectProductsShopifySettingsData['shopifyPriceFontSize'] * 0.85;
//フォント
$cssFontStyleArr = array('shopifyButtonFontStyle','shopifyProductNameFontStyle','shopifyPriceFontStyle','shopifyVariationFontStyle','shopifyProductDescriptionFontStyle');
foreach($cssFontStyleArr as $key => $val){
	//フォントウエイト
	if (strpos($ConnectProductsShopifySettingsData[$val], 'Bold') !== false) {
		$ConnectProductsShopifySettingsData[$val.'Weight'] = 'bold';
		$wpShopifyConnectFontStyle = str_replace(' Bold', '', $ConnectProductsShopifySettingsData[$val]); //保存するフォントスタイルの値を変えない為に代入
	} else {
		$ConnectProductsShopifySettingsData[$val.'Weight'] = 'normal';
		$wpShopifyConnectFontStyle = $ConnectProductsShopifySettingsData[$val];
	}
	//フォントファミリー
	$fontGroup = connect_products_with_shopify_shopify_fontstyles_select('getFontGroup',$wpShopifyConnectFontStyle,'fontGroup');
	if($fontGroup == 'Sans Serif'){
		$ConnectProductsShopifySettingsData[$val.'Family'] = $wpShopifyConnectFontStyle.', sans-serif';
	}elseif($fontGroup == 'Serif'){
		$ConnectProductsShopifySettingsData[$val.'Family'] = $wpShopifyConnectFontStyle.', serif';
	}else{
		$ConnectProductsShopifySettingsData[$val.'Family'] = $wpShopifyConnectFontStyle;
	}
}


/* テキスト */
//デフォルト値
$textDataNameArr = array(
	//ショッピングカート
	'cartTitleText' => esc_html__('Cart', 'mainichi-shopify-products-connect'),
	'cartTotalText' => esc_html__('SUBTOTAL', 'mainichi-shopify-products-connect'),
	'cartEmptyText' => esc_html__('Cart is empty.', 'mainichi-shopify-products-connect'),
	'cartNoticeText' => '',
	'cartcheckoutButtonText' => esc_html__('Checkout', 'mainichi-shopify-products-connect'),
	'cartNoteDescriptionText' => esc_html__('Memo', 'mainichi-shopify-products-connect'),
	//ボタン
	'addToCartButtonText' => esc_html__('Add to cart', 'mainichi-shopify-products-connect'),
	'buyNowButtonText' => esc_html__('Buy now', 'mainichi-shopify-products-connect'),
	'viewProductButtonText' => esc_html__('View product', 'mainichi-shopify-products-connect'),
	'outOfStockText' => esc_html__('Out of Stock', 'mainichi-shopify-products-connect')
);

foreach($textDataNameArr as $key => $val){
	if(!empty($_POST['submit_shopify_text'])){
		if(!empty($_REQUEST[$key])){
			$ConnectProductsShopifySettingsData[$key] = sanitize_text_field($_REQUEST[$key]);
		}else{
			$ConnectProductsShopifySettingsData[$key] = sanitize_text_field($val);
		}
	}else{
		if(empty($ConnectProductsShopifySettingsData[$key])){
			$ConnectProductsShopifySettingsData[$key] = sanitize_text_field($val);
		}
	}
	if(!empty($ConnectProductsShopifySettingsData[$key])){
		$$key = $ConnectProductsShopifySettingsData[$key]; //可変変数
	}else{
		$$key = '';
	}
}

update_option('ConnectProductsShopifySettingsData',$ConnectProductsShopifySettingsData);


/* ショップ情報取得＆登録 */
if($status == 'connect'){
	//取得
	$shop_obj_url = $shopifyApiUrl . '/admin/shop.json';
	$shop_content = wp_remote_get($shop_obj_url);
	if (!is_wp_error($shop_content) && $shop_content['response']['code'] === 200){
		$shop_json = json_decode($shop_content['body'], true);
		$shop = $shop_json['shop'];
	}

	if($shop['primary_locale'] == 'ja'){
		//翻訳
		$from = "en";
		$to   = "ja";
		$shop['country_name'] = connect_products_with_shopify_google_translate($from,$to,$shop['country_name']);
		$shop['province'] = connect_products_with_shopify_google_translate($from,$to,$shop['province']);

		if($shop['province'] == '東京'){
			$prefecture = '都';
		}elseif($shop['province'] == '北海道'){
			$prefecture = '';
		}elseif($shop['province'] == '大阪' || $shop['province'] == '京都'){
			$prefecture = '府';
		}else{
			$prefecture = '県';
		}

		$shop['zip'] = '〒'.$shop['zip'];
		$shop['province'] = $shop['province'].$prefecture;
		$shop['address'] = $shop['province'].$shop['city'].$shop['address1'];

		if(!empty($shop['address2'])){
			$shop['address'] .= ' '.$shop['address2'];
		}
	}else{
		$shop['address'] = $shop['address1'].' '.$shop['city'].' '.$shop['province'];
		if(!empty($shop['address2'])){
			$shop['address'] = $shop['address2'].' '.$shop['address'];
		}
	}

	$shopDataNameArr = array('name','phone','customer_email','shop_owner','primary_locale','money_format','zip','country_name','province','city','address1','address2','address');
	foreach ($shopDataNameArr as $key => $val){
		if(!empty($shop[$val])){
			if($val == 'money_format'){
				$ConnectProductsShopifyShopData['money_format_unencode'] = $shop[$val]; //エンコード前
				$shop[$val] = urlencode($shop[$val]); //エンコード
				$ConnectProductsShopifyShopData[$val] = $shop[$val];
			}else{
				$ConnectProductsShopifyShopData[$val] = sanitize_text_field($shop[$val]);
			}
		}else{
			unset($ConnectProductsShopifyShopData[$val]);
		}
		if(!empty($ConnectProductsShopifyShopData[$val])){
			$$val = $ConnectProductsShopifyShopData[$val]; //可変変数
		}else{
			$$val = '';
		}
	}
	update_option('ConnectProductsShopifyShopData',$ConnectProductsShopifyShopData);
}
?>

<section class="cpsSettingsSection">
	<?php
	if(!empty($statusMessage)){
		echo $statusMessage;
	}
	if(!empty($saveMessage)){
		echo $saveMessage;
	}
	?>

	<input id="connectSettingsTab" type="radio" name="tab_settings" checked><label for="connectSettingsTab"><span class="tabLabel"><?php esc_html_e('Connection Settings', 'mainichi-shopify-products-connect'); //連携設定 ?></span></label>
	<?php if($status == 'connect'): //連携時に表示 ?>
	<input id="buttonSettingsTab" type="radio" name="tab_settings"><label for="buttonSettingsTab"><span class="tabLabel"><?php esc_html_e('Button Settings', 'mainichi-shopify-products-connect'); //ボタン表示設定 ?></span></label>
	<input id="cssSettingsTab" type="radio" name="tab_settings"><label for="cssSettingsTab"><span class="tabLabel"><?php esc_html_e('CSS Settings', 'mainichi-shopify-products-connect'); //CSS設定 ?></span></label>
	<input id="textSettingsTab" type="radio" name="tab_settings"><label for="textSettingsTab"><span class="tabLabel"><?php esc_html_e('Text Settings', 'mainichi-shopify-products-connect'); //テキスト設定 ?></span></label>
	<?php endif; //連携時に表示 END ?>
	<input id="manualsTab" type="radio" name="tab_settings"><label for="manualsTab"><span class="tabLabel"><?php esc_html_e('Manuals', 'mainichi-shopify-products-connect'); //マニュアル ?></span></label>

	<div id="connectSettings" class="tab_content">
		<h2><?php esc_html_e('Shopify Connection Settings', 'mainichi-shopify-products-connect'); //Shopify連携設定 ?></h2>
		<form class="shopifySettingsForm" method="post" action="admin.php?page=shopify_settings">
			<div class="cpsGrayBackground">
				<table class="form-table">
					<tr valign="top">
						<th scope="row"><label for="shopifyStoreUrl"><?php esc_html_e('Store Domain', 'mainichi-shopify-products-connect'); //ストアURL ?></label></th>
						<td><input name="shopifyStoreUrl" type="text" value="<?php echo $shopifyStoreUrl; ?>" class="regular-text"></td>
					</tr>
					<tr valign="top">
						<th scope="row"><label for="shopifyApiKey"><?php esc_html_e('API key', 'mainichi-shopify-products-connect'); //APIキー ?></label></th>
						<td><input name="shopifyApiKey" type="text" value="<?php echo $shopifyApiKey; ?>" class="regular-text"></td>
					</tr>
					<tr valign="top">
						<th scope="row"><label for="shopifyPassword"><?php esc_html_e('Password', 'mainichi-shopify-products-connect'); //パスワード ?></label></th>
						<td><input name="shopifyPassword" type="text" value="<?php echo $shopifyPassword; ?>" class="regular-text"></td>
					</tr>
					<tr valign="top">
						<th scope="row"><label for="shopifySecretShare"><?php esc_html_e('Shared Secret', 'mainichi-shopify-products-connect'); //共有秘密 ?></label></th>
						<td><input name="shopifySecretShare" type="text" value="<?php echo $shopifySecretShare; ?>" class="regular-text"></td>
					</tr>
					<tr valign="top">
						<th scope="row"><label for="shopifyStorefrontAccessToken"><?php esc_html_e('Storefront access token', 'mainichi-shopify-products-connect'); //ストアフロントのアクセストークン ?></label></th>
						<td><input name="shopifyStorefrontAccessToken" type="text" value="<?php echo $shopifyStorefrontAccessToken; ?>" class="regular-text"></td>
					</tr>
				</table>
			</div>
			<input type="hidden" name="submit_settings" id="submit_settings" value="<?php esc_html_e('Connection settings', 'mainichi-shopify-products-connect'); //連携設定 ?>">
			<p class="submit">
				<input type="submit" name="submit_shopify_data" id="submit_shopify_data" class="button-primary" value="<?php esc_html_e('Save the connection settings', 'mainichi-shopify-products-connect'); //連携設定を保存 ?>">
			</p>
		</form>

		<h2><?php esc_html_e('Shopify products connection', 'mainichi-shopify-products-connect'); //Shopify商品連携 ?></h2>
		<form id="shopifyConnectForm">
			<p class="description"><?php esc_html_e('Retrieve all products registered in the Shopify store and automatically register them in a custom WordPress post (product).', 'mainichi-shopify-products-connect'); //Shopifyストアに登録されている全商品を取得し、WordPressのカスタム投稿（商品）に自動登録します。 ?></p>
			<span class="displayNone"><label class="email_t"><?php esc_html_e('Do not enter', 'mainichi-shopify-products-connect'); //入力しないでください ?></label><input type="text" name="email_t" value="" tabindex="-1" autocomplete="nope"></span>
			<?php wp_nonce_field( 'connectForm', 'connectFormNonce' ); //CSRF対策用 ?>
			<p class="submit">
				<input type="submit" name="submit_shopify_connect" id="submit_shopify_connect" class="button-primary" value="<?php esc_html_e('Connect products', 'mainichi-shopify-products-connect'); //商品を連携する ?>"<?php if($status == 'disconnect'){echo ' disabled=""';} ?>>
			</p>
		</form>

		<h2><?php esc_html_e('Delete all connected products', 'mainichi-shopify-products-connect'); //連携した全商品を削除 ?></h2>
		<form id="shopifyDeleteProducts">
			<p class="description"><?php esc_html_e('Delete all the products information of the Shopify store registered in the WordPress custom post (product).', 'mainichi-shopify-products-connect'); //WordPressのカスタム投稿（商品）に登録したShopifyストアの全商品情報を削除します。 ?></p>
			<span class="displayNone"><label class="email_t"><?php esc_html_e('Do not enter', 'mainichi-shopify-products-connect'); //入力しないでください ?></label><input type="text" name="email_t" value="" tabindex="-1" autocomplete="nope"></span>
			<?php
			wp_nonce_field( 'connectForm', 'connectFormNonce' ); //CSRF対策用

			//全商品削除ボタンアクティブ分岐用に登録商品状況取得
			$arr = array(
				'post_type'   => array('product'), //投稿タイプ指定
				'post_status' => 'any',
				'numberposts' => 1, //表示数指定
				'meta_query' => array(
					array(
						'key' => 'shopify_product',
						'value' => true,
						'compare' => '=' //Shopifyの商品のみ
					)
				)
			);
			$arrPostsAny = get_posts($arr);

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
			$arrPostsTrash = get_posts($arr);
			?>
			<p class="submit">
				<input type="submit" name="submit_shopify_delete" id="submit_shopify_delete" class="button-primary" value="<?php esc_html_e('Delete all products', 'mainichi-shopify-products-connect'); //全商品を削除する ?>"<?php if(empty($arrPostsAny) && empty($arrPostsTrash)){echo ' disabled=""';} ?>>
				<span class="noConnectedProductsMessage marginLeft16"><?php if(empty($arrPostsAny) && empty($arrPostsTrash)){esc_html_e('*No connected products', 'mainichi-shopify-products-connect');} //※連携されている商品はありません ?></span>
			</p>
		</form>

		<?php /* 結果表示 */ ?>
		<div id="loading" class="displayNone">
			<img src="<?php echo CONNECT_PRODUCTS_WITH_SHOPIFY__PLUGIN_URL; ?>/img/loading.gif" width="64" height="64" decoding="async" loading="lazy">
			<span class="loadingMessage"></span>
		</div>
		<div id="resultArea" class="displayNone"></div>

		<?php if($status == 'connect'): //連携時に表示 ?>
		<div class="cpsGrayBackground marginBottom24">
			<h2><?php esc_html_e('Store Information', 'mainichi-shopify-products-connect'); //ショップ情報 ?></h2>
			<table class="shopDataTable">
				<tr valign="top">
					<th scope="row"><?php esc_html_e('Store Name', 'mainichi-shopify-products-connect'); //ショップ名 ?></th>
					<td><?php echo $name; ?></td>
				</tr>
				<tr valign="top">
					<th scope="row"><?php esc_html_e('Operation Manager', 'mainichi-shopify-products-connect'); //運営責任者 ?></th>
					<td><?php echo $shop_owner; ?></td>
				</tr>
				<tr valign="top">
					<th scope="row"><?php esc_html_e('Address', 'mainichi-shopify-products-connect'); //住所 ?></th>
					<td><?php echo $zip.' '.$address; ?></td>
				</tr>
				<tr valign="top">
					<th scope="row"><?php esc_html_e('Phone', 'mainichi-shopify-products-connect'); //電話番号 ?></th>
					<td><?php echo $phone; ?></td>
				</tr>
				<tr valign="top">
					<th scope="row"><?php esc_html_e('Email', 'mainichi-shopify-products-connect'); //メールアドレス ?></th>
					<td><?php echo $customer_email; ?></td>
				</tr>
			</table>
		</div>
		<?php endif; //連携時に表示 END ?>
	</div>

	<?php if($status == 'connect'): //連携時に表示 ?>
	<div id="buttonSettings" class="tab_content">
		<h2><?php esc_html_e('Button Settings', 'mainichi-shopify-products-connect'); //ボタン表示設定 ?></h2>
		<form class="shopifySettingsForm" method="post" action="admin.php?page=shopify_settings">
			<div class="cpsGrayBackground">
				<h3><?php esc_html_e('General', 'mainichi-shopify-products-connect'); //基本 ?></h3>
				<div class="tableWrap">
					<table class="form-table">
						<tr valign="top">
							<th scope="row"><label for="displayLayoutStyle"><?php esc_html_e('Layout Style', 'mainichi-shopify-products-connect'); //レイアウトスタイル ?></label></th>
							<td>
								<select name="displayLayoutStyle">
									<option value="basic"<?php if($displayLayoutStyle == 'basic'){echo ' selected';} ?>><?php esc_html_e('Basic', 'mainichi-shopify-products-connect'); //ベーシック ?></option>
									<option value="classic"<?php if($displayLayoutStyle == 'classic'){echo ' selected';} ?>><?php esc_html_e('Classic', 'mainichi-shopify-products-connect'); //クラシック ?></option>
									<option value="fullview"<?php if($displayLayoutStyle == 'fullview'){echo ' selected';} ?>><?php esc_html_e('Full view', 'mainichi-shopify-products-connect');//フルビュー  ?></option>
								</select>
							</td>
						</tr>
						<tr valign="top">
							<th scope="row"><label for="displayButtonDestination"><?php esc_html_e('Action when people click', 'mainichi-shopify-products-connect'); //クリック時のアクション ?></label></th>
							<td>
								<select name="displayButtonDestination">
									<option value="cart"<?php if($displayButtonDestination == 'cart'){echo ' selected';} ?>><?php esc_html_e('Add product to cart', 'mainichi-shopify-products-connect'); //カートに商品を追加するボタン ?></option>
									<option value="checkout"<?php if($displayButtonDestination == 'checkout'){echo ' selected';} ?>><?php esc_html_e('Direct to checkout', 'mainichi-shopify-products-connect'); //チェックアウトに移動するボタン ?></option>
									<option value="modal"<?php if($displayButtonDestination == 'modal'){echo ' selected';} ?>><?php esc_html_e('Open product details', 'mainichi-shopify-products-connect'); //商品の詳細を開く ?></option>
								</select>
							</td>
						</tr>
					</table>
				</div>
				<div class="tableWrap">
					<h3><?php esc_html_e('Layout', 'mainichi-shopify-products-connect'); //レイアウト ?></h3>
					<table class="form-table">
						<tr valign="top">
							<th scope="row"><label for="displayWithQuantity"><?php esc_html_e('Show quantity field', 'mainichi-shopify-products-connect'); //数量フィールドの表示 ?><br><?php echo esc_html__('(', 'mainichi-shopify-products-connect').esc_html__('Common to all layout styles', 'mainichi-shopify-products-connect').esc_html__(')', 'mainichi-shopify-products-connect'); //（全レイアウトスタイル共通） ?></label></th>
							<td>
								<select name="displayWithQuantity">
									<option value="show"<?php if($displayWithQuantity == 'show'){echo ' selected';} ?>><?php esc_html_e('Show', 'mainichi-shopify-products-connect'); //表示する ?></option>
									<option value="hide"<?php if($displayWithQuantity == 'hide'){echo ' selected';} ?>><?php esc_html_e('Hide', 'mainichi-shopify-products-connect'); //表示しない ?></option>
								</select>
							</td>
						</tr>
					</table>
					<table class="form-table">
						<tr valign="top">
							<th scope="row"><label for="displayAlignment"><?php esc_html_e('Alignment', 'mainichi-shopify-products-connect'); //アラインメント ?><br><?php echo esc_html__('(', 'mainichi-shopify-products-connect').esc_html__('Common to Basic & Classic', 'mainichi-shopify-products-connect').esc_html__(')', 'mainichi-shopify-products-connect'); //（ベーシック＆クラシック共通） ?></label></th>
							<td>
								<select name="displayAlignment">
									<option value="left"<?php if($displayAlignment == 'left'){echo ' selected';} ?>><?php esc_html_e('Left', 'mainichi-shopify-products-connect'); //左 ?></option>
									<option value="center"<?php if($displayAlignment == 'center'){echo ' selected';} ?>><?php esc_html_e('Center', 'mainichi-shopify-products-connect'); //中央 ?></option>
									<option value="right"<?php if($displayAlignment == 'right'){echo ' selected';} ?>><?php esc_html_e('Right', 'mainichi-shopify-products-connect'); //右 ?></option>
								</select>
							</td>
						</tr>
					</table>
					<table class="form-table">
						<tr valign="top">
							<th scope="row"><label for="displayClassicImageSize"><?php esc_html_e('Image size', 'mainichi-shopify-products-connect'); //画像サイズ ?><br><?php echo esc_html__('(', 'mainichi-shopify-products-connect').esc_html__('Classic', 'mainichi-shopify-products-connect').esc_html__(')', 'mainichi-shopify-products-connect'); //（クラシック） ?></label></th>
							<td>
								<select name="displayClassicImageSize">
									<option value="small"<?php if($displayClassicImageSize == 'small'){echo ' selected';} ?>><?php esc_html_e('Small', 'mainichi-shopify-products-connect'); //小 ?></option>
									<option value="middle"<?php if($displayClassicImageSize == 'middle'){echo ' selected';} ?>><?php esc_html_e('Medium', 'mainichi-shopify-products-connect'); //中 ?></option>
									<option value="large"<?php if($displayClassicImageSize == 'large'){echo ' selected';} ?>><?php esc_html_e('Large', 'mainichi-shopify-products-connect'); //大 ?></option>
								</select>
							</td>
						</tr>
						<tr valign="top">
							<th scope="row"><label for="displayClassicOtherImages"><?php esc_html_e('Show additional product images', 'mainichi-shopify-products-connect'); //他の商品画像の表示 ?><br><?php echo esc_html__('(', 'mainichi-shopify-products-connect').esc_html__('Classic', 'mainichi-shopify-products-connect').esc_html__(')', 'mainichi-shopify-products-connect'); //（クラシック） ?></label></th>
							<td>
								<select name="displayClassicOtherImages">
									<option value="show"<?php if($displayClassicOtherImages == 'show'){echo ' selected';} ?>><?php esc_html_e('Show', 'mainichi-shopify-products-connect'); //表示する ?></option>
									<option value="hide"<?php if($displayClassicOtherImages == 'hide'){echo ' selected';} ?>><?php esc_html_e('Hide', 'mainichi-shopify-products-connect'); //表示しない ?></option>
								</select>
							</td>
						</tr>
					</table>
				</div>
				<div class="tableWrap">
					<h3><?php esc_html_e('Shopping cart', 'mainichi-shopify-products-connect'); //ショッピングカート ?></h3>
					<table class="form-table">
						<tr valign="top">
							<th scope="row"><label for="cartDisplayNoteDescription"><?php esc_html_e('Show order note field', 'mainichi-shopify-products-connect'); //注文のメモフィールドの表示 ?></label></th>
							<td>
								<select name="cartDisplayNoteDescription">
									<option value="show"<?php if($cartDisplayNoteDescription == 'show'){echo ' selected';} ?>><?php esc_html_e('Show', 'mainichi-shopify-products-connect'); //表示する ?></option>
									<option value="hide"<?php if($cartDisplayNoteDescription == 'hide'){echo ' selected';} ?>><?php esc_html_e('Hide', 'mainichi-shopify-products-connect'); //表示しない ?></option>
								</select>
							</td>
						</tr>
					</table>
				</div>
				<div class="tableWrap">
					<h3><?php esc_html_e('Advanced settings', 'mainichi-shopify-products-connect'); //高度な設定 ?></h3>
					<table class="form-table">
						<tr valign="top">
							<th scope="row"><label for="checkoutAction"><?php esc_html_e('Checkout behaviour', 'mainichi-shopify-products-connect'); //チェックアウトの動作 ?></label></th>
							<td>
								<select name="checkoutAction">
									<option value="popup"<?php if($checkoutAction == 'popup'){echo ' selected';} ?>><?php esc_html_e('Open pop-up window', 'mainichi-shopify-products-connect'); //ポップアップウィンドウを開く?></option>
									<option value="transition"<?php if($checkoutAction == 'transition'){echo ' selected';} ?>><?php esc_html_e('Redirect in the same tab', 'mainichi-shopify-products-connect'); //同じタブでリダイレクト ?></option>
								</select>
							</td>
						</tr>
					</table>
				</div>
			</div>
			<input type="hidden" name="submit_settings" id="submit_settings" value="<?php esc_html_e('Button Settings', 'mainichi-shopify-products-connect'); //ボタン表示設定 ?>">
			<p class="submit">
				<input type="submit" name="submit_shopify_display" id="submit_shopify_display" class="button-primary" value="<?php esc_html_e('Save button settings', 'mainichi-shopify-products-connect'); //ボタン表示設定を保存 ?>">
			</p>
		</form>
	</div>

	<div id="cssSettings" class="tab_content">
		<h2><?php esc_html_e('CSS Settings', 'mainichi-shopify-products-connect'); //CSS設定 ?></h2>
		<form class="shopifySettingsForm" method="post" action="admin.php?page=shopify_settings">
			<div class="cpsGrayBackground">
				<div class="tableWrap">
					<h3><?php esc_html_e('Button', 'mainichi-shopify-products-connect'); //ボタン ?></h3>
					<table class="form-table">
						<tr valign="top">
							<th scope="row"><label for="shopifyButtonRound"><?php esc_html_e('Button corners', 'mainichi-shopify-products-connect'); //ボタンの角 ?><br><?php echo esc_html__('(', 'mainichi-shopify-products-connect').'border-radius'.esc_html__(')', 'mainichi-shopify-products-connect'); ?></label></th>
							<td><input name="shopifyButtonRound" type="number" value="<?php echo $shopifyButtonRound; ?>" min="0" max="40"></td>
						</tr>
						<tr valign="top">
							<th scope="row"><label for="shopifyButtonPadding"><?php esc_html_e('Button width', 'mainichi-shopify-products-connect'); //ボタンの幅 ?><br><?php echo esc_html__('(', 'mainichi-shopify-products-connect').'padding-right & padding-left'.esc_html__(')', 'mainichi-shopify-products-connect'); ?></label></th>
							<td><input name="shopifyButtonPadding" type="number" value="<?php echo $shopifyButtonPadding; ?>" min="0" max="100"></td>
						</tr>
						<tr valign="top">
							<th scope="row"><label for="shopifyButtonBackgroundColor"><?php esc_html_e('Button background color', 'mainichi-shopify-products-connect'); //ボタンの背景色 ?><br><?php echo esc_html__('(', 'mainichi-shopify-products-connect').'background-color'.esc_html__(')', 'mainichi-shopify-products-connect'); ?></label></th>
							<td><?php connect_products_with_shopify_genelate_color_picker_tag('shopifyButtonBackgroundColor', $shopifyButtonBackgroundColor); ?></td>
						</tr>
						<tr valign="top">
							<th scope="row"><label for="shopifyButtonHoverBackgroundColor"><?php esc_html_e('Button hover background color', 'mainichi-shopify-products-connect'); //マウスオーバー時のボタンの背景色 ?><br><?php echo esc_html__('(', 'mainichi-shopify-products-connect').'background-color'.esc_html__(')', 'mainichi-shopify-products-connect'); ?></label></th>
							<td><?php connect_products_with_shopify_genelate_color_picker_tag('shopifyButtonHoverBackgroundColor', $shopifyButtonHoverBackgroundColor); ?></td>
						</tr>
						<tr valign="top">
							<th scope="row"><label for="shopifyButtonFontColor"><?php esc_html_e('Button text color', 'mainichi-shopify-products-connect'); //ボタンの文字色 ?><br><?php echo esc_html__('(', 'mainichi-shopify-products-connect').'font-color'.esc_html__(')', 'mainichi-shopify-products-connect'); ?></label></th>
							<td><?php connect_products_with_shopify_genelate_color_picker_tag('shopifyButtonFontColor', $shopifyButtonFontColor); ?></td>
						</tr>
						<tr valign="top">
							<th scope="row"><label for="shopifyButtonFontStyle"><?php esc_html_e('Button text style', 'mainichi-shopify-products-connect'); //ボタンの文字スタイル ?><br><?php echo esc_html__('(', 'mainichi-shopify-products-connect').'font-family'.esc_html__(')', 'mainichi-shopify-products-connect'); ?></label></th>
							<td><?php connect_products_with_shopify_shopify_fontstyles_select('shopifyButtonFontStyle',$shopifyButtonFontStyle,'fontStyle'); ?></td>
						</tr>
						<tr valign="top">
							<th scope="row"><label for="shopifyButtonFontSize"><?php esc_html_e('Button text size', 'mainichi-shopify-products-connect'); //ボタンの文字サイズ ?><br><?php echo esc_html__('(', 'mainichi-shopify-products-connect').'font-size'.esc_html__(')', 'mainichi-shopify-products-connect'); ?></label></th>
							<td><input name="shopifyButtonFontSize" type="number" value="<?php echo $shopifyButtonFontSize; ?>" min="13" max="18"></td>
						</tr>
					</table>
				</div>
				<div class="tableWrap">
					<h3><?php esc_html_e('Cart', 'mainichi-shopify-products-connect'); //カート ?></h3>
					<table class="form-table">
						<tr valign="top">
							<th scope="row"><label for="shopifyCartBackgroundColor"><?php esc_html_e('Cart background color', 'mainichi-shopify-products-connect'); //カートの背景色 ?><br><?php echo esc_html__('(', 'mainichi-shopify-products-connect').'background-color'.esc_html__(')', 'mainichi-shopify-products-connect'); ?></label></th>
							<td><?php connect_products_with_shopify_genelate_color_picker_tag('shopifyCartBackgroundColor', $shopifyCartBackgroundColor); ?></td>
						</tr>
						<tr valign="top">
							<th scope="row"><label for="shopifyCartFontColor"><?php esc_html_e('Cart body text color', 'mainichi-shopify-products-connect'); //カートの文字色 ?><br><?php echo esc_html__('(', 'mainichi-shopify-products-connect').'font-color'.esc_html__(')', 'mainichi-shopify-products-connect'); ?></label></th>
							<td><?php connect_products_with_shopify_genelate_color_picker_tag('shopifyCartFontColor', $shopifyCartFontColor); ?></td>
						</tr>
					</table>
				</div>
				<div class="tableWrap">
					<h3><?php esc_html_e('Layout', 'mainichi-shopify-products-connect'); //レイアウト ?></h3>
					<table class="form-table">
						<tr valign="top">
							<th scope="row"><label for="shopifyProductNameFontColor"><?php esc_html_e('Product title text color', 'mainichi-shopify-products-connect'); //商品名の文字色 ?><br><?php echo esc_html__('(', 'mainichi-shopify-products-connect').'font-color'.esc_html__(')', 'mainichi-shopify-products-connect'); ?></label></th>
							<td><?php connect_products_with_shopify_genelate_color_picker_tag('shopifyProductNameFontColor', $shopifyProductNameFontColor); ?></td>
						</tr>
						<tr valign="top">
							<th scope="row"><label for="shopifyPriceFontColor"><?php esc_html_e('Price text color', 'mainichi-shopify-products-connect'); //価格の文字色 ?><br><?php echo esc_html__('(', 'mainichi-shopify-products-connect').'font-color'.esc_html__(')', 'mainichi-shopify-products-connect'); ?></label></th>
							<td><?php connect_products_with_shopify_genelate_color_picker_tag('shopifyPriceFontColor', $shopifyPriceFontColor); ?></td>
						</tr>
						<tr valign="top">
							<th scope="row"><label for="shopifyVariationFontColor"><?php esc_html_e('Variant text color', 'mainichi-shopify-products-connect'); //バリエーションの文字色 ?><br><?php echo esc_html__('(', 'mainichi-shopify-products-connect').'font-color'.esc_html__(')', 'mainichi-shopify-products-connect'); ?></label></th>
							<td><?php connect_products_with_shopify_genelate_color_picker_tag('shopifyVariationFontColor', $shopifyVariationFontColor); ?></td>
						</tr>
						<tr valign="top">
							<th scope="row"><label for="shopifyProductDescriptionFontColor"><?php esc_html_e('Description text color', 'mainichi-shopify-products-connect'); //説明の文字色 ?><br><?php echo esc_html__('(', 'mainichi-shopify-products-connect').'font-color'.esc_html__(')', 'mainichi-shopify-products-connect'); ?></label></th>
							<td><?php connect_products_with_shopify_genelate_color_picker_tag('shopifyProductDescriptionFontColor', $shopifyProductDescriptionFontColor); ?></td>
						</tr>
						<tr valign="top">
							<th scope="row"><label for="shopifyProductNameFontStyle"><?php esc_html_e('Product title text style', 'mainichi-shopify-products-connect'); //商品名の文字スタイル ?><br><?php echo esc_html__('(', 'mainichi-shopify-products-connect').'font-family'.esc_html__(')', 'mainichi-shopify-products-connect'); ?></label></th>
							<td><?php connect_products_with_shopify_shopify_fontstyles_select('shopifyProductNameFontStyle',$shopifyProductNameFontStyle,'fontStyle'); ?></td>
						</tr>
						<tr valign="top">
							<th scope="row"><label for="shopifyPriceFontStyle"><?php esc_html_e('Price text style', 'mainichi-shopify-products-connect'); //価格の文字スタイル ?><br><?php echo esc_html__('(', 'mainichi-shopify-products-connect').'font-family'.esc_html__(')', 'mainichi-shopify-products-connect'); ?></label></th>
							<td><?php connect_products_with_shopify_shopify_fontstyles_select('shopifyPriceFontStyle',$shopifyPriceFontStyle,'fontStyle'); ?></td>
						</tr>
						<tr valign="top">
							<th scope="row"><label for="shopifyVariationFontStyle"><?php esc_html_e('Variant text style', 'mainichi-shopify-products-connect'); //バリエーションの文字スタイル ?><br><?php echo esc_html__('(', 'mainichi-shopify-products-connect').'font-family'.esc_html__(')', 'mainichi-shopify-products-connect'); ?></label></th>
							<td><?php connect_products_with_shopify_shopify_fontstyles_select('shopifyVariationFontStyle',$shopifyVariationFontStyle,'fontStyle'); ?></td>
						</tr>
						<tr valign="top">
							<th scope="row"><label for="shopifyProductDescriptionFontStyle"><?php esc_html_e('Description text style', 'mainichi-shopify-products-connect'); //説明の文字スタイル ?><br><?php echo esc_html__('(', 'mainichi-shopify-products-connect').'font-family'.esc_html__(')', 'mainichi-shopify-products-connect'); ?></label></th>
							<td><?php connect_products_with_shopify_shopify_fontstyles_select('shopifyProductDescriptionFontStyle',$shopifyProductDescriptionFontStyle,'fontStyle'); ?></td>
						</tr>
						<tr valign="top">
							<th scope="row"><label for="shopifyProductNameFontSize"><?php esc_html_e('Product title text size', 'mainichi-shopify-products-connect'); //商品名の文字サイズ ?><br><?php echo esc_html__('(', 'mainichi-shopify-products-connect').'font-size'.esc_html__(')', 'mainichi-shopify-products-connect'); ?></label></th>
							<td><input name="shopifyProductNameFontSize" type="number" value="<?php echo $shopifyProductNameFontSize; ?>" min="14" max="34"></td>
						</tr>
						<tr valign="top">
							<th scope="row"><label for="shopifyPriceFontSize"><?php esc_html_e('Price text size', 'mainichi-shopify-products-connect'); //価格の文字サイズ ?><br><?php echo esc_html__('(', 'mainichi-shopify-products-connect').'font-size'.esc_html__(')', 'mainichi-shopify-products-connect'); ?></label></th>
							<td><input name="shopifyPriceFontSize" type="number" value="<?php echo $shopifyPriceFontSize; ?>" min="14" max="26"></td>
						</tr>
						<tr valign="top">
							<th scope="row"><label for="shopifyVariationFontSize"><?php esc_html_e('Variant text size', 'mainichi-shopify-products-connect'); //バリエーションの文字サイズ ?><br><?php echo esc_html__('(', 'mainichi-shopify-products-connect').'font-size'.esc_html__(')', 'mainichi-shopify-products-connect'); ?></label></th>
							<td><input name="shopifyVariationFontSize" type="number" value="<?php echo $shopifyVariationFontSize; ?>" min="14" max="17"></td>
						</tr>
						<tr valign="top">
							<th scope="row"><label for="shopifyProductDescriptionFontSize"><?php esc_html_e('Description text size', 'mainichi-shopify-products-connect'); //説明の文字サイズ ?><br><?php echo esc_html__('(', 'mainichi-shopify-products-connect').'font-size'.esc_html__(')', 'mainichi-shopify-products-connect'); ?></label></th>
							<td><input name="shopifyProductDescriptionFontSize" type="number" value="<?php echo $shopifyProductDescriptionFontSize; ?>" min="14" max="17"></td>
						</tr>
					</table>
				</div>
			</div>
			<input type="hidden" name="submit_settings" id="submit_settings" value="<?php esc_html_e('CSS settings', 'mainichi-shopify-products-connect'); //CSS設定 ?>">
			<p class="submit">
				<input type="submit" name="submit_shopify_css" id="submit_shopify_css" class="button-primary" value="<?php esc_html_e('Save CSS settings', 'mainichi-shopify-products-connect'); //CSS設定を保存 ?>">
			</p>
		</form>
	</div>

	<div id="textSettings" class="tab_content">
		<h2><?php esc_html_e('Text Settings', 'mainichi-shopify-products-connect'); //テキスト設定 ?></h2>
		<form class="shopifySettingsForm" method="post" action="admin.php?page=shopify_settings">
			<div class="cpsGrayBackground">
				<h3><?php esc_html_e('Shopping cart', 'mainichi-shopify-products-connect'); //ショッピングカート ?></h3>
				<div class="tableWrap">
					<table class="form-table">
						<tr valign="top">
							<th scope="row"><label for="cartTitleText"><?php esc_html_e('Heading', 'mainichi-shopify-products-connect'); //見出し ?></label></th>
							<td><input name="cartTitleText" type="text" value="<?php echo $cartTitleText; ?>" class="regular-text"></td>
						</tr>
						<tr valign="top">
							<th scope="row"><label for="cartTotalText"><?php esc_html_e('Subtotal', 'mainichi-shopify-products-connect'); //小計 ?></label></th>
							<td><input name="cartTotalText" type="text" value="<?php echo $cartTotalText; ?>" class="regular-text"></td>
						</tr>
						<tr valign="top">
							<th scope="row"><label for="cartNoteDescriptionText"><?php esc_html_e('Order note', 'mainichi-shopify-products-connect'); //注文メモ ?></label></th>
							<td><input name="cartNoteDescriptionText" type="text" value="<?php echo $cartNoteDescriptionText; ?>" class="regular-text"></td>
						</tr>
						<tr valign="top">
							<th scope="row"><label for="cartNoticeText"><?php esc_html_e('Additional information', 'mainichi-shopify-products-connect'); //追加情報 ?></label></th>
							<td><input name="cartNoticeText" type="text" value="<?php echo $cartNoticeText; ?>" class="regular-text"></td>
						</tr>
						<tr valign="top">
							<th scope="row"><label for="cartcheckoutButtonText"><?php esc_html_e('Checkout button', 'mainichi-shopify-products-connect'); //チェックアウトボタン ?></label></th>
							<td><input name="cartcheckoutButtonText" type="text" value="<?php echo $cartcheckoutButtonText; ?>" class="regular-text"></td>
						</tr>
						<tr valign="top">
							<th scope="row"><label for="cartEmptyText"><?php esc_html_e('Empty cart', 'mainichi-shopify-products-connect'); //カートの中が空の場合 ?></label></th>
							<td><input name="cartEmptyText" type="text" value="<?php echo $cartEmptyText; ?>" class="regular-text"></td>
						</tr>
					</table>
				</div>
				<div class="tableWrap">
					<h3><?php esc_html_e('Cart button', 'mainichi-shopify-products-connect'); //カートボタン ?></h3>
					<table class="form-table">
						<tr valign="top">
							<th scope="row"><label for="addToCartButtonText"><?php esc_html_e('Add product to cart button', 'mainichi-shopify-products-connect'); //カートに商品を追加するボタン ?></label></th>
							<td><input name="addToCartButtonText" type="text" value="<?php echo $addToCartButtonText ; ?>" class="regular-text"></td>
						</tr>
						<tr valign="top">
							<th scope="row"><label for="buyNowButtonText"><?php esc_html_e('Direct to checkout button', 'mainichi-shopify-products-connect'); //チェックアウトに移動するボタン ?></label></th>
							<td><input name="buyNowButtonText" type="text" value="<?php echo $buyNowButtonText; ?>" class="regular-text"></td>
						</tr>
						<tr valign="top">
							<th scope="row"><label for="viewProductButtonText"><?php esc_html_e('Open product details button', 'mainichi-shopify-products-connect'); //商品の詳細を開くボタン ?></label></th>
							<td><input name="viewProductButtonText" type="text" value="<?php echo $viewProductButtonText; ?>" class="regular-text"></td>
						</tr>
						<tr valign="top">
							<th scope="row"><label for="outOfStockText"><?php esc_html_e('Out of stock', 'mainichi-shopify-products-connect'); //在庫切れの時 ?></label></th>
							<td><input name="outOfStockText" type="text" value="<?php echo $outOfStockText; ?>" class="regular-text"></td>
						</tr>
					</table>
				</div>
			</div>
			<input type="hidden" name="submit_settings" id="submit_settings" value="<?php esc_html_e('Text Settings', 'mainichi-shopify-products-connect'); //テキスト設定 ?>">
			<p class="submit">
				<input type="submit" name="submit_shopify_text" id="submit_shopify_text" class="button-primary" value="<?php esc_html_e('Save the text settings', 'mainichi-shopify-products-connect'); //テキスト設定を保存 ?>">
			</p>
		</form>
	</div>
	<?php endif; //連携時に表示 END ?>

	<div id="manuals" class="tab_content">
		<?php if($status != 'connect'): //連携後は非表示 ?>
		<h2><?php esc_html_e('How to Connect', 'mainichi-shopify-products-connect'); //連携方法 ?></h2>
		<div class="cpsGrayBackground">
			<div class="tableWrap">
				<h3><?php esc_html_e('Create Private app (Shopify side)', 'mainichi-shopify-products-connect'); //プライベートアプリを作成（Shopify側） ?></h3>
				<p><?php esc_html_e('First, you need to create a "Private App" on Shopify side.', 'mainichi-shopify-products-connect'); //始めに、Shopify側で「プライベートアプリ」を作成する必要があります。 ?></p>
				<ol class="maxWidth640">
					<li><?php esc_html_e('Click "Apps > Manage private apps"', 'mainichi-shopify-products-connect'); //「アプリ管理 ＞ プライベートアプリを管理する」をクリック ?></li>
					<li><?php esc_html_e('Click "Create private app"', 'mainichi-shopify-products-connect'); //「プライベートアプリを作成する」をクリック ?></li>
					<li><?php esc_html_e('Enter any "Private app name" and "Emergency developer email"', 'mainichi-shopify-products-connect'); //任意の「プライベートアプリ名」と「緊急連絡用開発者メール」を入力 ?></li>
					<li><?php esc_html_e('Check "Allow this app to access your storefront data using the Storefront API"', 'mainichi-shopify-products-connect'); //「このアプリがストアフロントAPIを使用してストアフロントデータにアクセスできるようにする」をチェック ?></li>
					<li><?php esc_html_e('Check all items in "STOREFRONT API PERMISSIONS"', 'mainichi-shopify-products-connect'); //「ストアフロントAPI権限」の項目を全てチェック ?></li>
					<li><?php esc_html_e('Click "Show inactive Admin API permissions"', 'mainichi-shopify-products-connect'); //「非アクティブなAdmin API権限を表示する」をクリック ?></li>
					<li><?php esc_html_e('Set all displayed items to "Read access" or "Read and write"', 'mainichi-shopify-products-connect'); //表示される項目を全て「読み取りアクセス」もしくは「読み取りおよび書き込み」にする ?></li>
					<li><?php esc_html_e('Click on the "Save" button', 'mainichi-shopify-products-connect'); //「保存」ボタンをクリック ?></li>
					<li><?php esc_html_e('Click on "Create App" in the pop-up that appears and your app is ready to be created', 'mainichi-shopify-products-connect'); //表示されるポップアップの「アプリを作成する」をクリックしてアプリの作成完了 ?></li>
				</ol>
			</div>
			<div class="tableWrap">
				<h3><?php esc_html_e('Plugin Settings (WordPress side)', 'mainichi-shopify-products-connect'); //プラグインの設定（WordPress側） ?></h3>
				<p><?php esc_html_e('Next, let\'s configure the WordPress side "Connect Products with Shopify".', 'mainichi-shopify-products-connect'); echo '<br>'; esc_html_e('Enter the information you found on the Shopify page earlier.', 'mainichi-shopify-products-connect'); //続いて、WordPress側「Connect Products with Shopify 」の設定を行います。先程のShopifyページにあった情報を入力します。 ?></p>
				<ol class="maxWidth640">
					<li><?php esc_html_e('Enter the "Store URL"', 'mainichi-shopify-products-connect'); echo '<br>'; _e('The "Store URL" is the domain of the store. For example, if the "Example URL" on the private app page is "https://d2bdf71x8e271e3b09x078841d20aac9:shppa_13d6e67f8a6b5x83d6f10702e95865d6@xxxxxx-xxxxxxxxx. myshopify.com/admin/api/2021-07/orders.json" is the "<code>xxxxxx-xxxxxxxxx.myshopify.com</code>" part.', 'mainichi-shopify-products-connect'); //「ストアURL」を入力、「ストアURL」はショップのドメインです。例えば、プライベートアプリページ記載の「URLの例」が「https://d2bdf71x8e271e3b09x078841d20aac9:shppa_13d6e67f8a6b5x83d6f10702e95865d6@xxxxxx-xxxxxxxxx.myshopify.com/admin/api/2021-07/orders.json」の場合「xxxxxx-xxxxxxxxx.myshopify.com」の部分にあたります。 ?></li>
					<li><?php esc_html_e('Enter the "API key," "Password," "Shared Secret," and "Storefront access token" from the private app page in the "Connection Settings" section of the plugin settings page', 'mainichi-shopify-products-connect'); //プラグインの設定ページの「連携設定」の項目に、プライベートアプリページにある「APIキー」・「パスワード」・「共有秘密」・「ストアフロントのアクセストークン」を入力 ?></li>
					<li><?php esc_html_e('Click the "Save the connection settings" button', 'mainichi-shopify-products-connect'); echo '<br>' ; esc_html_e('If you see the message "You have been connected to the Shopify store.", the connection is complete.', 'mainichi-shopify-products-connect'); //「連携設定を保存」ボタンをクリック、「Shopifyストアと連携されています」と表示されれば連携完了です。 ?></li>
				</ol>
			</div>
			<div class="tableWrap">
				<h3><?php esc_html_e('Products Connection (WordPress side)', 'mainichi-shopify-products-connect'); //商品連携（WordPress側） ?></h3>
				<p><?php esc_html_e('With just one click, you can add all your Shopify products to WordPress as a custom post.', 'mainichi-shopify-products-connect'); //ワンクリックでShopifyの全商品を、WordPressにカスタム投稿として登録できます。 ?></p>
				<ol class="maxWidth640">
					<li><?php esc_html_e('Click the "Shopify products connection" button', 'mainichi-shopify-products-connect'); //「商品を連携する」ボタンをクリック ?></li>
					<li><?php esc_html_e('Click "Products" in the left sidebar of the admin panel and check if your Shopify products are registered.', 'mainichi-shopify-products-connect'); //管理画面の左サイドバーの「商品」をクリックし、商品が登録さているか確認しましょう。 ?></li>
				</ol>
				<p>
					<?php
					$manualVideoUrl = 'https://youtu.be/dURppWmyHRE';
					echo sprintf(__('<a href="%s" target="_blank" rel="noopener">Click here to see a video on how to connect.</a>', 'mainichi-shopify-products-connect'), esc_url($manualVideoUrl)); //説明動画はこちらをご覧ください。
					?>
				</p>
			</div>
		</div>
		<?php endif; ?>
		<h2><?php esc_html_e('How to display Products list', 'mainichi-shopify-products-connect'); //商品一覧の表示方法 ?></h2>
		<div class="cpsGrayBackground">
			<div class="tableWrap">
				<h3><?php esc_html_e('Shortcode', 'mainichi-shopify-products-connect'); //ショートコード ?></h3>
				<p><?php esc_html_e('You can use a shortcode to display a list of products.', 'mainichi-shopify-products-connect'); //ショートコードを使い商品一覧を表示できます。 ?></p>
				<code>[shopifyProductsList]</code>
				<p><?php esc_html_e('Code for use in template files.', 'mainichi-shopify-products-connect'); //テンプレートファイルで使用する場合のコード ?></p>
				<code>echo do_shortcode('[shopifyProductsList]');</code>
			</div>
			<div class="tableWrap">
				<h3><?php esc_html_e('Available Attributes', 'mainichi-shopify-products-connect'); //利用可能な属性 ?></h3>
				<p><?php esc_html_e('You can customize the products list display by setting the attributes.', 'mainichi-shopify-products-connect'); //属性を設定することで商品一覧表示をカスタマイズできます。 ?></p>
				<table class="attributesTable">
					<thead>
						<tr>
							<th><?php esc_html_e('Attributes', 'mainichi-shopify-products-connect'); //属性 ?></th>
							<td><?php esc_html_e('Possible values', 'mainichi-shopify-products-connect'); //可能な値 ?></td>
							<td><?php esc_html_e('Description', 'mainichi-shopify-products-connect'); //説明 ?></td>
						</tr>
					</thead>
					<tbody>
						<tr>
							<th><code>limit</code></th>
							<td><?php esc_html_e('Any number (integer)', 'mainichi-shopify-products-connect'); //任意の（整数） ?></td>
							<td>
								<?php esc_html_e('Number of products to display per page', 'mainichi-shopify-products-connect'); //1ページに表示する商品数を指定 ?>
								<br><?php esc_html_e('Default : ', 'mainichi-shopify-products-connect'); //初期値： ?>9
							</td>
						</tr>
						<tr>
							<th><code>action</code></th>
							<td>cart<br>checkout<br>modal</td>
							<td>
								<?php esc_html_e('Action when the buy button is click', 'mainichi-shopify-products-connect'); //購入ボタンクリック時のアクションを指定 ?>
								<br><?php esc_html_e('Default : ', 'mainichi-shopify-products-connect'); //初期値： ?>modal
							</td>
						</tr>
						<tr>
							<th><code>alignment</code></th>
							<td>right<br>left<br>center</td>
							<td>
								<?php esc_html_e('Alignment of the content', 'mainichi-shopify-products-connect'); //コンテンツの整列を指定 ?>
								<br><?php esc_html_e('Default : ', 'mainichi-shopify-products-connect'); //初期値： ?>center
							</td>
						</tr>
						<tr>
							<th><code>column</code></th>
							<td><?php esc_html_e('Any number (integer)', 'mainichi-shopify-products-connect'); //任意の（整数） ?></td>
							<td>
								<?php esc_html_e('Number of columns in the list', 'mainichi-shopify-products-connect'); //一覧のカラム数を指定 ?>
								<br><?php esc_html_e('Default : ', 'mainichi-shopify-products-connect'); //初期値： ?>3
							</td>
						</tr>
						<tr>
							<th><code>variation</code></th>
							<td>show<br>hide</td>
							<td>
								<?php esc_html_e('Show or hide variation selection', 'mainichi-shopify-products-connect'); //バリエーション選択の表示・非表示を指定 ?>
								<br><?php esc_html_e('Default : ', 'mainichi-shopify-products-connect'); //初期値： ?>hide
							</td>
						</tr>
						<tr>
							<th><code>quantity</code></th>
							<td>show<br>hide</td>
							<td>
								<?php esc_html_e('Show or hide the quantity field', 'mainichi-shopify-products-connect'); //数量フィールドの表示・非表示を指定 ?>
								<br><?php esc_html_e('Default : ', 'mainichi-shopify-products-connect'); //初期値： ?>hide
							</td>
						</tr>
						<tr>
							<th><code>text</code></th>
							<td><?php esc_html_e('Any string', 'mainichi-shopify-products-connect'); //任意の文字列 ?></td>
							<td>
								<?php esc_html_e('Text for the Buy button', 'mainichi-shopify-products-connect'); //購入ボタンの文字を指定 ?>
								<br><?php
								esc_html_e('Default : ', 'mainichi-shopify-products-connect'); //初期値：
								esc_html_e('Set value', 'mainichi-shopify-products-connect'); //設定されている値
								?>
							</td>
						</tr>
						<tr>
							<th><code>type</code></th>
							<td><?php esc_html_e('Product type slug', 'mainichi-shopify-products-connect'); //商品タイプのスラッグ ?><br><?php esc_html_e('Multiple OK (comma separated)', 'mainichi-shopify-products-connect'); //複数指定可能（カンマ区切り） ?></td>
							<td>
								<?php esc_html_e('Product type to display', 'mainichi-shopify-products-connect'); //表示する商品タイプを指定 ?>
								<br><?php esc_html_e('Default : ', 'mainichi-shopify-products-connect'); //初期値：
								esc_html_e('All Product types', 'mainichi-shopify-products-connect'); //全商品タイプ ?>
							</td>
						</tr>
						<tr>
							<th><code>tag</code></th>
							<td><?php esc_html_e('Tag slug', 'mainichi-shopify-products-connect'); //タグのスラッグ ?><br><?php esc_html_e('Multiple OK (comma separated)', 'mainichi-shopify-products-connect'); //複数指定可能（カンマ区切り） ?></td>
							<td>
								<?php esc_html_e('Tags to display', 'mainichi-shopify-products-connect'); //表示するタグを指定 ?>
								<br><?php esc_html_e('Default : ', 'mainichi-shopify-products-connect'); //初期値：
								esc_html_e('All Tags', 'mainichi-shopify-products-connect'); //全タグ ?>
							</td>
						</tr>
						<tr>
							<th><code>vendor</code></th>
							<td><?php esc_html_e('Vendor name', 'mainichi-shopify-products-connect'); //販売元の名前 ?><br><?php esc_html_e('Multiple OK (comma separated)', 'mainichi-shopify-products-connect'); //複数指定可能（カンマ区切り） ?></td>
							<td>
								<?php esc_html_e('Vendor to display', 'mainichi-shopify-products-connect'); //表示する販売元を指定 ?>
								<br><?php esc_html_e('Default : ', 'mainichi-shopify-products-connect'); //初期値：
								esc_html_e('All Vendors', 'mainichi-shopify-products-connect'); //全販売元 ?>
							</td>
						</tr>
						<tr>
							<th><code>id</code></th>
							<td><?php esc_html_e('Product ID', 'mainichi-shopify-products-connect'); //商品ID ?><br><?php esc_html_e('Multiple OK (comma separated)', 'mainichi-shopify-products-connect'); //複数指定可能（カンマ区切り） ?></td>
							<td>
								<?php esc_html_e('Product ID to display', 'mainichi-shopify-products-connect'); //表示する商品IDを指定 ?>
								<br><?php esc_html_e('Default : ', 'mainichi-shopify-products-connect'); //初期値：
								esc_html_e('All Products', 'mainichi-shopify-products-connect'); //全商品 ?>
							</td>
						</tr>
						<tr>
							<th><code>stock</code></th>
							<td>show<br>hide</td>
							<td>
								<?php esc_html_e('Show or hide out-of-stock products', 'mainichi-shopify-products-connect'); //在庫切れ商品の表示・非表示を指定 ?>
								<br><?php esc_html_e('Default : ', 'mainichi-shopify-products-connect'); //初期値： ?>hide
							</td>
						</tr>
						<tr>
							<th><code>sort</code></th>
							<td>new<br>old<br>low-price<br>high-price</td>
							<td>
								<?php esc_html_e('Display order', 'mainichi-shopify-products-connect'); //表示順を指定 ?>
								<br><?php esc_html_e('Default : ', 'mainichi-shopify-products-connect'); //初期値： ?>new
							</td>
						</tr>
						<tr>
							<th><code>pagination</code></th>
							<td>show<br>hide</td>
							<td>
								<?php esc_html_e('Show or hide pagination', 'mainichi-shopify-products-connect'); //ページネーションの表示・非表示を指定 ?>
								<br><?php esc_html_e('Default : ', 'mainichi-shopify-products-connect'); //初期値： ?>show
								<br><br><?php esc_html_e('*Pagination can be displayed only on Page (is_page) and archive page (is_archive).', 'mainichi-shopify-products-connect'); //※ページネーションは固定ページ（is_page）・アーカイブページ（is_archive）でのみ表示可能です。 ?>
							</td>
						</tr>
						<tr>
							<th><code>pagination-range</code></th>
							<td><?php esc_html_e('Any number (integer)', 'mainichi-shopify-products-connect'); //任意の（整数） ?></td>
							<td>
								<?php esc_html_e('Number of pagination ranges to display', 'mainichi-shopify-products-connect'); //表示するページネーション範囲数を指定 ?>
								<br><?php esc_html_e('Default : ', 'mainichi-shopify-products-connect'); //初期値： ?>3
							</td>
						</tr>
					</tbody>
				</table>
				<p><?php esc_html_e('Example of attribute use : ', 'mainichi-shopify-products-connect'); //属性の使用例： ?><code>[shopifyProductsList limit="6" column="2" type="category-a,category-b,category-c" sort="low-price"]</code></p>
			</div>
		</div>
		<h2><?php esc_html_e('How to display Buy button', 'mainichi-shopify-products-connect'); //購入ボタンの表示方法 ?></h2>
		<div class="cpsGrayBackground marginBottom40">
			<div class="tableWrap">
				<h3><?php esc_html_e('Shortcode', 'mainichi-shopify-products-connect'); //ショートコード ?></h3>
				<p>
					<?php esc_html_e('You can use a shortcode to display a buy button.', 'mainichi-shopify-products-connect'); //ショートコードを使い購入ボタンを表示できます。 ?>
					<br><?php esc_html_e('You need to specify the "Product ID".', 'mainichi-shopify-products-connect'); //「商品ID」を指定する必要があります。 ?>
				</p>
				<code>[shopifyBuyButton id="0000000000000"]</code>
				<p><?php esc_html_e('Code for use in template files.', 'mainichi-shopify-products-connect'); //テンプレートファイルで使用する場合のコード ?></p>
				<code>echo do_shortcode('[shopifyBuyButton id="0000000000000"]');</code>
			</div>
			<div class="tableWrap">
				<h3><?php esc_html_e('Available Attributes', 'mainichi-shopify-products-connect'); //利用可能な属性 ?></h3>
				<p>
					<?php esc_html_e('You can customize the buy button by setting attributes.', 'mainichi-shopify-products-connect'); //属性を設定することで購入ボタンをカスタマイズできます。 ?><br>
					<?php esc_html_e('If the attribute is not used, the value set in "Button Settings" will be applied.', 'mainichi-shopify-products-connect'); //属性を使用しない場合、「ボタン表示設定」で設定した値が適用されます。 ?>
				</p>
				<table class="attributesTable">
					<thead>
						<tr>
							<th><?php esc_html_e('Attributes', 'mainichi-shopify-products-connect'); //属性 ?></th>
							<td><?php esc_html_e('Possible values', 'mainichi-shopify-products-connect'); //可能な値 ?></td>
							<td><?php esc_html_e('Description', 'mainichi-shopify-products-connect'); //説明 ?></td>
						</tr>
					</thead>
					<tbody>
						<tr>
							<th><code>layout</code></th>
							<td>basic<br>classic<br>fullview</td>
							<td>
								<?php esc_html_e('Display layout', 'mainichi-shopify-products-connect'); //表示レイアウトを指定 ?>
								<br><?php
								esc_html_e('Default : ', 'mainichi-shopify-products-connect'); //初期値：
								esc_html_e('Set value', 'mainichi-shopify-products-connect'); //設定されている値
								?>
							</td>
						</tr>
						<tr>
							<th><code>action</code></th>
							<td>cart<br>checkout<br>modal</td>
							<td>
								<?php esc_html_e('Action when the buy button is click', 'mainichi-shopify-products-connect'); //購入ボタンクリック時のアクションを指定 ?>
								<br><?php
								esc_html_e('Default : ', 'mainichi-shopify-products-connect'); //初期値：
								esc_html_e('Set value', 'mainichi-shopify-products-connect'); //設定されている値
								?>
							</td>
						</tr>
						<tr>
							<th><code>alignment</code></th>
							<td>right<br>left<br>center</td>
							<td>
								<?php esc_html_e('Alignment of the content', 'mainichi-shopify-products-connect'); //コンテンツの整列を指定 ?>
								<br><?php
								esc_html_e('Default : ', 'mainichi-shopify-products-connect'); //初期値：
								esc_html_e('Set value', 'mainichi-shopify-products-connect'); //設定されている値
								?>
							</td>
						</tr>
						<tr>
							<th><code>image</code></th>
							<td><?php esc_html_e('Any number (integer)', 'mainichi-shopify-products-connect'); //任意の（整数） ?></td>
							<td>
								<?php esc_html_e('Image width', 'mainichi-shopify-products-connect'); //画像の幅を指定 ?>
								<br><?php
								esc_html_e('Default : ', 'mainichi-shopify-products-connect'); //初期値：
								esc_html_e('Set value', 'mainichi-shopify-products-connect'); //設定されている値
								?>
							</td>
						</tr>
						<tr>
							<th><code>variation</code></th>
							<td>show<br>hide</td>
							<td>
								<?php esc_html_e('Show or hide variation selection', 'mainichi-shopify-products-connect'); //バリエーション選択の表示・非表示を指定 ?>
								<br><?php esc_html_e('Default : ', 'mainichi-shopify-products-connect'); //初期値： ?>cart <?php esc_html_e('or', 'mainichi-shopify-products-connect'); //または ?> checkout / show<br>modal / hide
							</td>
						</tr>
						<tr>
							<th><code>quantity</code></th>
							<td>show<br>hide</td>
							<td>
								<?php esc_html_e('Show or hide the quantity field', 'mainichi-shopify-products-connect'); //数量フィールドの表示・非表示を指定 ?>
								<br><?php
								esc_html_e('Default : ', 'mainichi-shopify-products-connect'); //初期値：
								esc_html_e('Set value', 'mainichi-shopify-products-connect'); //設定されている値
								?>
							</td>
						</tr>
						<tr>
							<th><code>text</code></th>
							<td><?php esc_html_e('Any string', 'mainichi-shopify-products-connect'); //任意の文字列 ?></td>
							<td>
								<?php esc_html_e('Text for the Buy button', 'mainichi-shopify-products-connect'); //購入ボタンの文字を指定 ?>
								<br><?php
								esc_html_e('Default : ', 'mainichi-shopify-products-connect'); //初期値：
								esc_html_e('Set value', 'mainichi-shopify-products-connect'); //設定されている値
								?>
							</td>
						</tr>
						<tr>
							<th><code>css</code></th>
							<td>load<br>no-load</td>
							<td>
								<?php esc_html_e('load the CSS for the Buy button', 'mainichi-shopify-products-connect'); //購入ボタン用のCSSを読み込むかを指定 ?>
								<br><?php esc_html_e('Default : ', 'mainichi-shopify-products-connect'); //初期値： ?>load
							</td>
						</tr>
					</tbody>
				</table>
				<p><?php esc_html_e('Example of attribute use : ', 'mainichi-shopify-products-connect'); //属性の使用例： ?><code>[shopifyBuyButton id="0000000000000" alignment="center" image="580" quantity="show"]</code></p>
			</div>
		</div>
	</div>

</section>

<?php connect_products_with_shopify_add_my_ajaxurl(); ?>

<script>
	/* Shopify商品連携 */
	jQuery(function($){
		$("#shopifyConnectForm").submit( function(event){ //formの送信ボタンが押されたときの処理
			event.preventDefault(); //クリックイベントをこれ以上伝播させない
			var fd = new FormData(this); //フォームデータからサーバへ送信するデータを作成
			fd.append('action','shopifyConnect'); //サーバー側での処理を指定
			var loadingMessage = '<?php esc_html_e('Connecting products', 'mainichi-shopify-products-connect'); //商品を連携しています ?>';
			$(".loadingMessage").html(loadingMessage);
			$("#loading").fadeIn("600");
			$.ajax({ //ajaxの通信
				type: 'POST',
				url: ajaxurl,
				data: fd,
				processData: false,
				contentType: false,
				success: function(response){
					$("#loading").hide();
					$(".noConnectedProductsMessage").html("");
					$("#submit_shopify_delete").prop("disabled", false);
					$("#resultArea").html(response).fadeIn("600");
					setTimeout(function(){
						$(".resultMessage").html(response).fadeOut("600");
						$("#resultArea").html(response).fadeOut("600");
					},3000);
				},
				error: function( response ){
					$("#loading").hide();
					$("#resultArea").html(response).fadeIn("600");
					setTimeout(function(){
						$(".resultMessage").html(response).fadeOut("600");
						$("#resultArea").html(response).fadeOut("600");
					},3000);
				}
			});
			return false;
		});
	});

	/* 連携した全商品を削除 */
	jQuery(function($){
		$("#shopifyDeleteProducts").submit( function(event){ //formの送信ボタンが押されたときの処理
			event.preventDefault(); //クリックイベントをこれ以上伝播させない
			var fd = new FormData(this); //フォームデータからサーバへ送信するデータを作成
			fd.append('action','shopifyDelete'); //サーバー側での処理を指定
			var loadingMessage = '<?php esc_html_e('Deleting products', 'mainichi-shopify-products-connect'); //商品を削除しています ?>';
			$(".loadingMessage").html(loadingMessage);
			$("#loading").fadeIn("600");
			$.ajax({ //ajaxの通信
				type: 'POST',
				url: ajaxurl,
				data: fd,
				processData: false,
				contentType: false,
				success: function(response){
					var noConnectedProductsMessage = '<?php esc_html_e('*No connected products', 'mainichi-shopify-products-connect'); //※連携されている商品はありません ?>';
					$("#loading").hide();
					$(".noConnectedProductsMessage").html(noConnectedProductsMessage);
					$("#submit_shopify_delete").prop("disabled", true);
					$("#resultArea").html(response).fadeIn("600");
					setTimeout(function(){
						$(".resultMessage").html(response).fadeOut("600");
						$("#resultArea").html(response).fadeOut("600");
					},3000);
				},
				error: function( response ){
					$("#loading").hide();
					$("#resultArea").html(response).fadeIn("600");
					setTimeout(function(){
						$(".resultMessage").html(response).fadeOut("600");
						$("#resultArea").html(response).fadeOut("600");
					},3000);
				}
			});
			return false;
		});
	});

	/* 設定保存メッセージフェードアウト */
	jQuery(function($){
		setTimeout(function(){
			$(".saveMessage").fadeOut("600");
		},3000);
	});
</script>