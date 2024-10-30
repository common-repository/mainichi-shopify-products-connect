<?php
/* Template Name: 購入ボタン */

if (!defined('ABSPATH')) exit;

/* ショートコード */
function connect_products_with_shopify_shopify_buy_button_shortcode($atts)
{
	/* API情報 */
	$ConnectProductsShopifyApiData = get_option('ConnectProductsShopifyApiData');
	foreach ($ConnectProductsShopifyApiData as $key => $val) {
		$$key = esc_html($val);
	}

	$errorStyle = 'display: table; color: white; background: red; font-weight: bold; padding: 4px 16px; border-radius: 3px; -webkit-border-radius: 3px; -moz-border-radius: 3px;';
	if ($shopifyConnectStatus != 'connect') { //連携されていない場合
		return '<div style="' . $errorStyle . '">' . esc_html__('It is not connected to Shopify.', 'mainichi-shopify-products-connect') . '</div>'; //Shopifyと連携されていません。
	}

	/* ショートコードの引数から取得 */
	//ID
	if (!empty($atts['id'])) {
		$productID = esc_html($atts['id']);
	}

	if (is_singular('product') && empty($productID)) { //商品投稿ページの場合
		$post_obj = get_queried_object(); //投稿情報取得
		$post_id = $post_obj->ID; //投稿ID取得
		$productID = esc_html(get_post_meta($post_id, 'product_id', true)); //カスタムフィールドからID取得
	}

	if (empty($productID)) {
		return '<div style="' . $errorStyle . '">' . esc_html__('Please specify the product ID.', 'mainichi-shopify-products-connect') . '</div>'; //商品IDを指定してください。
	}

	/* 設定情報 */
	$ConnectProductsShopifySettingsData = get_option('ConnectProductsShopifySettingsData');
	foreach ($ConnectProductsShopifySettingsData as $key => $val) {
		if(!empty($val)){
			$$key = esc_html($val);
		}else{
			$$key = '';
		}
	}
	/* ショップ情報 */
	$ConnectProductsShopifyShopData = get_option('ConnectProductsShopifyShopData');
	foreach ($ConnectProductsShopifyShopData as $key => $val) {
		if(!empty($val)){
			$$key = esc_html($val);
		}else{
			$$key = '';
		}
	}

	/* ショートコードの引数から取得 */
	//レイアウト
	if (!empty($atts['layout']) && ($atts['layout'] == 'basic' || $atts['layout'] == 'classic' || $atts['layout'] == 'fullview')) {
		$displayLayoutStyle = $atts['layout'];
		if($atts['layout'] == 'basic' || $atts['layout'] == 'classic'){
			$displayLayoutStyleHorV = 'vertical';
		}else{
			$displayLayoutStyleHorV = 'horizontal';
		}
	}
	//クリック時のアクション
	if (!empty($atts['action']) && ($atts['action'] == 'cart' || $atts['action'] == 'checkout' || $atts['action'] == 'modal')) {
		$displayButtonDestination = $atts['action'];
	}
	//アラインメント
	if (!empty($atts['alignment']) && ($atts['alignment'] == 'right' || $atts['alignment'] == 'left' || $atts['alignment'] == 'center')) {
		$displayAlignment = $atts['alignment'];
	}
	//画像サイズ
	if (!empty($atts['image']) && preg_match('/^[0-9]+$/', $atts['image'])) {
		$displayClassicImageSize = $atts['image'];
	}
	//数量フィールド付きボタン
	if (!empty($atts['quantity']) && $atts['quantity'] == 'show') {
		$displayWithQuantity = 'show';
	}
	//ボタンテキスト
	if (!empty($atts['text'])) {
		$addToCartButtonText = esc_html($atts['text']);
		$buyNowButtonText = esc_html($atts['text']);
		$viewProductButtonText = esc_html($atts['text']);
	}

	//アクションフック
	do_action('cps_buy_button_after_global_load', $ConnectProductsShopifySettingsData);

	ob_start();

	//CSS読み込み（ショートコードの引数で表示・非表示分岐）
	if (!empty($atts['css'])){
		$cssLoad = $atts['css'];
	}else{
		$cssLoad = '';
	}
	if (empty($cssLoad) && $cssLoad != 'no-load') {
		if($displayLayoutStyle == 'fullview'){
			$displayClassicImageSize = 'unset';
		}
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
		echo '<style type="text/css">'.connect_products_with_shopify_font_style_css($fontStyle).connect_products_with_shopify_buy_button_css($displayAlignment,$displayClassicImageSize).'</style>';
	}

?>
<div id="product-component-<?php echo $productID; ?>"></div>
<script type="text/javascript">
	/*<![CDATA[*/
	(function() {
		var scriptURL = 'https://sdks.shopifycdn.com/buy-button/latest/buy-button-storefront.min.js'; //スクリプトURL
		var storeURL = '<?php echo $shopifyStoreUrl; ?>'; //ストアURL
		var storefrontAccessToken = '<?php echo $shopifyStorefrontAccessToken; ?>'; //ストアフロントのアクセストークン
		var productID = '<?php echo $productID; ?>'; //商品ID
		var shopifyShopMoneyFormat = '<?php echo $money_format; ?>'; //通貨
		/* 基本 */
		var displayLayoutStyle = '<?php echo $displayLayoutStyle; ?>'; //レイアウトスタイル
		var displayLayoutStyleHorV = '<?php echo $displayLayoutStyleHorV; ?>'; //表示方法
		var displayButtonDestination = '<?php echo $displayButtonDestination; ?>'; //クリック時のアクション
		/* バリエーション */
		if (displayButtonDestination == 'modal') {
			var displayVariation = false; //バリエーションの表示
		} else{
			var displayVariation = true; //バリエーションの表示
		}
		<?php
	//バリエーションの表示（引数）
	if(!empty($atts['variation'])){
		if ($atts['variation'] == 'hide') {
			$displayVariation = 'false';
		}else{
			$displayVariation = 'true';
		}
		echo 'var displayVariation = '.$displayVariation.';';
	}
		?>

		if ('<?php echo $displayWithQuantity; ?>' == 'show') {
			var displayWithQuantity = true; //数量フィールド付きボタン
			var displayButton = false; //通常ボタン
		} else {
			var displayWithQuantity = false; //数量フィールド付きボタン
			var displayButton = true; //通常ボタン
		}
		var displayAlignment = '<?php echo $displayAlignment; ?>'; //アラインメント
		var displayClassicImageSize = '<?php echo $displayClassicImageSize; ?>'; //画像サイズ
		/* レイアウトスタイルによる表示分岐 */
		if (displayLayoutStyle == 'basic') {
			var displayTitle = false; //タイトル
			var displayPrice = false; //価格
			var displayDescription = false; //説明
			var displayClassicOtherImages = false; //その他を含む画像ギャラリー
			var displayClassicMainImage = false; //メイン画像
			var productMaxWidth = 'calc(25% - 20px)'; //表示最大幅
			var productMarginLeft = '20px'; //マージンレフト
		} else {
			var displayTitle = true; //タイトル
			var displayPrice = true; //価格
			if (displayLayoutStyle == 'classic') {
				var displayDescription = false; //説明
				var productMaxWidth = 'calc(25% - 20px)'; //表示最大幅
				var productMarginLeft = '20px'; //マージンレフト
				if ('<?php echo $displayClassicOtherImages; ?>' == 'show') {
					var displayClassicOtherImages = true; //その他を含む画像ギャラリー
					var displayClassicMainImage = false; //メイン画像
				} else {
					var displayClassicOtherImages = false; //その他を含む画像ギャラリー
					var displayClassicMainImage = true; //メイン画像
				}
			} else if (displayLayoutStyle == 'fullview') {
				var displayDescription = true; //説明
				var productMaxWidth = '100%'; //表示最大幅
				var productMarginLeft = '0'; //マージンレフト
				var displayClassicOtherImages = true; //その他を含む画像ギャラリー
				var displayClassicMainImage = false; //メイン画像
			}
		}
		/* CSS：ボタン */
		var shopifyButtonRound = '<?php echo $shopifyButtonRound; ?>'; //ボタンの角
		var shopifyButtonPadding = '<?php echo $shopifyButtonPadding; ?>'; //ボタンの幅
		var shopifyButtonBackgroundColor = '<?php echo $shopifyButtonBackgroundColor; ?>'; //ボタンの背景色
		var shopifyButtonHoverBackgroundColor = '<?php echo $shopifyButtonHoverBackgroundColor; ?>'; //マウスオーバー時のボタンの背景色
		var shopifyButtonFontColor = '<?php echo $shopifyButtonFontColor; ?>'; //ボタンの文字色
		var shopifyButtonFontStyle = '<?php echo $shopifyButtonFontStyle; ?>'; //ボタンの文字スタイル
		var shopifyButtonFontFamily = '<?php echo $shopifyButtonFontStyleFamily; ?>'; //ボタンのフォントファミリー
		var shopifyButtonFontWeight = '<?php echo $shopifyButtonFontStyleWeight; ?>'; //ボタンのフォントウエイト
		var shopifyButtonFontSize = '<?php echo $shopifyButtonFontSize; ?>'; //ボタンの文字サイズ
		var shopifyButtonPaddingHeight = '<?php echo $shopifyButtonPaddingHeight; ?>'; //ボタンの高さ
		/* CSS：ショッピングカート */
		var shopifyCartBackgroundColor = '<?php echo $shopifyCartBackgroundColor; ?>'; //カートの背景色
		var shopifyCartFontColor = '<?php echo $shopifyCartFontColor; ?>'; //カートの文字色
		/* CSS：レイアウト */
		var shopifyProductNameFontColor = '<?php echo $shopifyProductNameFontColor; ?>'; //商品名の文字色
		var shopifyPriceFontColor = '<?php echo $shopifyPriceFontColor; ?>'; //価格の文字色
		var shopifyVariationFontColor = '<?php echo $shopifyVariationFontColor; ?>'; //バリエーションの文字色
		var shopifyProductDescriptionFontColor = '<?php echo $shopifyProductDescriptionFontColor; ?>'; //説明の文字色
		var shopifyProductNameFontStyle = '<?php echo $shopifyProductNameFontStyle; ?>'; //商品名の文字スタイル
		var shopifyPriceFontStyle = '<?php echo $shopifyPriceFontStyle; ?>'; //価格の文字スタイル
		var shopifyVariationFontStyle = '<?php echo $shopifyVariationFontStyle; ?>'; //バリエーションの文字スタイル
		var shopifyProductDescriptionFontStyle = '<?php echo $shopifyProductDescriptionFontStyle; ?>'; //説明の文字スタイル
		var shopifyProductNameFontFamily = '<?php echo $shopifyProductNameFontStyleFamily; ?>'; //商品名のフォントファミリー
		var shopifyPriceFontFamily = '<?php echo $shopifyPriceFontStyleFamily; ?>'; //価格のフォントファミリー
		var shopifyVariationFontFamily = '<?php echo $shopifyVariationFontStyleFamily; ?>'; //バリエーションのフォントファミリー
		var shopifyProductDescriptionFontFamily = '<?php echo $shopifyProductDescriptionFontStyleFamily; ?>'; //説明のフォントファミリー
		var shopifyProductNameFontWeight = '<?php echo $shopifyProductNameFontStyleWeight; ?>'; //商品名のフォントウエイト
		var shopifyPriceFontWeight = '<?php echo $shopifyPriceFontStyleWeight; ?>'; //価格のフォントウエイト
		var shopifyVariationFontWeight = '<?php echo $shopifyVariationFontStyleWeight; ?>'; //バリエーションのフォントウエイト
		var shopifyProductDescriptionFontWeight = '<?php echo $shopifyProductDescriptionFontStyleWeight; ?>'; //説明のフォントウエイト
		var shopifyProductNameFontSize = '<?php echo $shopifyProductNameFontSize; ?>'; //商品名の文字サイズ
		var shopifyPriceFontSize = '<?php echo $shopifyPriceFontSize; ?>'; //価格の文字サイズ
		var shopifyUnitPriceFontSize = '<?php echo $shopifyUnitPriceFontSize; ?>'; //ユニット価格の文字サイズ
		var shopifyVariationFontSize = '<?php echo $shopifyVariationFontSize; ?>'; //バリエーションの文字サイズ
		var shopifyProductDescriptionFontSize = '<?php echo $shopifyProductDescriptionFontSize; ?>'; //説明の文字サイズ
		/* ショッピングカート */
		if ('<?php echo $cartDisplayNoteDescription; ?>' == 'show') {
			var cartDisplayNoteDescription = true; //注文のメモフィールドの表示
		} else {
			var cartDisplayNoteDescription = false; //注文のメモフィールドの表示
		}
		/* 高度な設定 */
		if ('<?php echo $checkoutAction; ?>' == 'popup') {
			var checkoutAction = true; //チェックアウトの動作
		} else {
			var checkoutAction = false; //チェックアウトの動作
		}
		/* テキスト：ショッピングカート */
		var cartTitleText = '<?php echo $cartTitleText; ?>'; //見出し
		var cartTotalText = '<?php echo $cartTotalText; ?>'; //小計
		var cartEmptyText = '<?php echo $cartEmptyText; ?>'; //注文メモ
		var cartNoticeText = '<?php echo $cartNoticeText; ?>'; //追加情報
		var cartcheckoutButtonText = '<?php echo $cartcheckoutButtonText; ?>'; //チェックアウトボタン
		var cartNoteDescriptionText = '<?php echo $cartNoteDescriptionText; ?>'; //カートの中が空の場合
		/* テキスト：ボタン */
		var addToCartButtonText = '<?php echo $addToCartButtonText; ?>'; //カートに商品を追加するボタン
		var buyNowButtonText = '<?php echo $buyNowButtonText; ?>'; //チェックアウトに移動するボタン
		var viewProductButtonText = '<?php echo $viewProductButtonText; ?>'; //商品の詳細を開くボタン
		var outOfStockText = '<?php echo $outOfStockText; ?>'; //在庫切れの時
		if (displayButtonDestination == 'cart') {
			var buttonText = addToCartButtonText; //ボタンのテキスト
		} else if (displayButtonDestination == 'checkout') {
			var buttonText = buyNowButtonText; //ボタンのテキスト
		} else if (displayButtonDestination == 'modal') {
			var buttonText = viewProductButtonText; //ボタンのテキスト
		}
		/* Googleフォント */
		var googleFonts = new Array();
		var googleFontButton = new Array();
		var googleFontsList = ['Quantico', 'Droid Sans', 'Montserrat', 'Open Sans', 'PT Sans', 'Roboto', 'Source Sans Pro', 'Karla', 'Raleway', 'Strait', 'Josefin Slab', 'Oxygen', 'Arvo', 'Crimson Text', 'Droid Serif', 'Lora', 'PT Serif', 'Old Standard TT', 'Vollkorn', 'Playfair Display'];

		var googleFontStyle = googleFontsList.indexOf(shopifyButtonFontStyle);
		if (googleFontStyle !== -1) {
			googleFontButton.push(shopifyButtonFontStyle);
			googleFonts.push(shopifyButtonFontStyle);
		}
		googleFontStyle = googleFontsList.indexOf(shopifyProductNameFontStyle);
		if (googleFontStyle !== -1) {
			googleFonts.push(shopifyProductNameFontStyle);
		}
		googleFontStyle = googleFontsList.indexOf(shopifyPriceFontStyle);
		if (googleFontStyle !== -1) {
			googleFonts.push(shopifyPriceFontStyle);
		}
		googleFontStyle = googleFontsList.indexOf(shopifyVariationFontStyle);
		if (googleFontStyle !== -1) {
			googleFonts.push(shopifyVariationFontStyle);
		}
		googleFontStyle = googleFontsList.indexOf(shopifyProductDescriptionFontStyle);
		if (googleFontStyle !== -1) {
			googleFonts.push(shopifyProductDescriptionFontStyle);
		}
		googleFonts = googleFonts.filter(function(x, i, self) { //重複削除
			return self.indexOf(x) === i;
		});

		if (window.ShopifyBuy) {
			if (window.ShopifyBuy.UI) {
				ShopifyBuyInit();
			} else {
				loadScript();
			}
		} else {
			loadScript();
		}

		function loadScript() {
			var script = document.createElement('script');
			script.async = true;
			script.src = scriptURL;
			(document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(script);
			script.onload = ShopifyBuyInit;
		}

		function ShopifyBuyInit() {
			var client = ShopifyBuy.buildClient({
				domain: storeURL,
				storefrontAccessToken: storefrontAccessToken,
			});
			ShopifyBuy.UI.onReady(client).then(function(ui) {
				ui.createComponent('product', {
					id: productID,
					node: document.getElementById('product-component-' + productID),
					moneyFormat: shopifyShopMoneyFormat,
					options: {
						"product": {
							"iframe": false,
							"styles": {
								"product": {
									"@media (min-width: 601px)": {
										"max-width": productMaxWidth,
										"margin-left": productMarginLeft,
										"margin-bottom": "50px" //固定
									},
									"text-align": displayAlignment //アライメント
								},
								"title": {
									"font-family": shopifyProductNameFontFamily,
									"font-weight": shopifyProductNameFontWeight,
									"font-size": shopifyProductNameFontSize + "px",
									"color": shopifyProductNameFontColor
								},
								"button": {
									"font-family": shopifyButtonFontFamily, //ボタンフォントスタイル
									"font-weight": shopifyButtonFontWeight, //ボタンのフォントウエイト
									"font-size": shopifyButtonFontSize + "px", //ボタンフォントサイズ
									"padding-top": shopifyButtonPaddingHeight + "px", //ボタン高さ
									"padding-bottom": shopifyButtonPaddingHeight + "px", //ボタン高さ
									"color": shopifyButtonFontColor, //ボタン文字色
									":hover": {
										"color": shopifyButtonFontColor, //オーバー文字色
										"background-color": shopifyButtonHoverBackgroundColor //オーバー背景色
									},
									"background-color": shopifyButtonBackgroundColor, //ボタン背景色
									":focus": {
										"background-color": shopifyButtonBackgroundColor //フォーカス背景色
									},
									"border-radius": shopifyButtonRound + "px", //ボタン角
									"padding-left": shopifyButtonPadding + "px", //ボタン幅
									"padding-right": shopifyButtonPadding + "px" //ボタン幅
								},
								"quantityInput": {
									"font-size": shopifyButtonFontSize + "px", //数量フォントサイズ
									"padding-top": shopifyButtonPaddingHeight + "px", //数量高さ
									"padding-bottom": shopifyButtonPaddingHeight + "px" //数量高さ
								},
								"price": {
									"font-family": shopifyPriceFontFamily,
									"font-weight": shopifyPriceFontWeight,
									"font-size": shopifyPriceFontSize + "px",
									"color": shopifyPriceFontColor
								},
								"compareAt": {
									"font-family": shopifyPriceFontFamily,
									"font-weight": shopifyPriceFontWeight,
									"font-size": shopifyUnitPriceFontSize + "px",
									"color": shopifyPriceFontColor
								},
								"unitPrice": {
									"font-family": shopifyPriceFontFamily,
									"font-weight": shopifyPriceFontWeight,
									"font-size": shopifyUnitPriceFontSize + "px",
									"color": shopifyPriceFontColor
								},
								"description": {
									"font-family": shopifyProductDescriptionFontFamily,
									"font-weight": shopifyProductDescriptionFontWeight,
									"font-size": shopifyProductDescriptionFontSize + "px",
									"color": shopifyProductDescriptionFontColor
								}
							},
							"buttonDestination": displayButtonDestination, //「カートに入れる=cart」「チェックアウトに移動=checkout」「商品の詳細を開く=modal」
							"layout": displayLayoutStyleHorV, //「フルビュー」にする場合記述「horizontal」、それ以外は「vertical」
							"contents": { //レイアウトスタイル（記述ない場合は「true」）
								"img": displayClassicMainImage, //画像の表示
								"imgWithCarousel": displayClassicOtherImages, //その他の画像の表示
								"button": displayButton, //数量フィールドを表示する場合はfalse
								"buttonWithQuantity": displayWithQuantity, //数量フィールド表示
								"title": displayTitle, //タイトルの表示
								"price": displayPrice, //価格の表示
								"description": displayDescription, //説明の表示
								"options": displayVariation //バリエーションの表示
							},
							"width": displayClassicImageSize + "px", //画像の大きさ「280px（記述なし）＝小」「380px＝中」「580px＝大」
							"text": {
								"button": buttonText, //ボタンテキスト
								"outOfStock": outOfStockText //在庫切れ時のテキスト
							},
							"googleFonts": googleFonts //Googleフォント読み込み
						},
						"productSet": {
							"styles": {
								"products": {
									"@media (min-width: 601px)": { //固定
										"margin-left": "-20px"
									}
								}
							}
						},
						"modalProduct": { //ポップアップの表示内容
							"contents": {
								"img": false, //画像の表示（固定）
								"imgWithCarousel": true, //その他の画像の表示（固定）
								"button": displayButton, //数量フィールドを表示する場合はfalse
								"buttonWithQuantity": displayWithQuantity, //数量フィールド表示
								"title": true, //タイトルの表示（固定）
								"price": true, //価格の表示（固定）
								"description": true, //説明の表示（固定）
								"options": true //バリエーションの表示（固定）
							},
							"styles": {
								"product": {
									"@media (min-width: 601px)": { //固定
										"max-width": "100%",
										"margin-left": "0px",
										"margin-bottom": "0px"
									}
								},
								"button": {
									"font-family": shopifyButtonFontFamily,
									"font-weight": shopifyButtonFontWeight,
									"font-size": shopifyButtonFontSize + "px",
									"padding-top": shopifyButtonPaddingHeight + "px",
									"padding-bottom": shopifyButtonPaddingHeight + "px",
									"color": shopifyButtonFontColor,
									":hover": {
										"color": shopifyButtonFontColor,
										"background-color": shopifyButtonHoverBackgroundColor
									},
									"background-color": shopifyButtonBackgroundColor,
									":focus": {
										"background-color": shopifyButtonBackgroundColor
									},
									"border-radius": shopifyButtonRound + "px",
									"padding-left": shopifyButtonPadding + "px",
									"padding-right": shopifyButtonPadding + "px"
								},
								"quantityInput": {
									"font-size": shopifyButtonFontSize + "px",
									"padding-top": shopifyButtonPaddingHeight + "px",
									"padding-bottom": shopifyButtonPaddingHeight + "px"
								},
								"title": {
									"font-family": shopifyProductNameFontFamily,
									"font-weight": shopifyProductNameFontWeight,
									"font-size": shopifyProductNameFontSize + "px",
									"color": shopifyProductNameFontColor
								},
								"price": {
									"color": shopifyPriceFontColor
								},
								"compareAt": {
									"color": shopifyPriceFontColor
								},
								"unitPrice": {
									"color": shopifyPriceFontColor
								},
								"description": {
									"color": shopifyProductDescriptionFontColor
								}
							},
							"text": {
								"button": addToCartButtonText, //ポップアップボタンのテキスト
								"outOfStock": outOfStockText //在庫切れ時のテキスト
							}
						},
						"modal": {
							"styles": {
								"modal": {
									"background-color": shopifyCartBackgroundColor //ポップアップ背景色
								}
							}
						},
						"option": {
							"styles": {
								"label": {
									"font-family": shopifyVariationFontFamily, //バリエーションフォントスタイル
									"font-weight": shopifyVariationFontWeight, //バリエーションフォントウエイト
									"font-size": shopifyVariationFontSize + "px", //バリエーションフォントサイズ
									"color": shopifyVariationFontColor //バリエーション文字色
								},
								"select": {
									"font-family": shopifyVariationFontFamily //バリエーションフォントスタイル
								}
							}
						},
						"cart": {
							"styles": {
								"button": { //ボタンスタイル同じ
									"font-family": shopifyButtonFontFamily,
									"font-weight": shopifyButtonFontWeight,
									"font-size": shopifyButtonFontSize + "px",
									"padding-top": shopifyButtonPaddingHeight + "px",
									"padding-bottom": shopifyButtonPaddingHeight + "px",
									"color": shopifyButtonFontColor,
									":hover": {
										"color": shopifyButtonFontColor,
										"background-color": shopifyButtonHoverBackgroundColor
									},
									"background-color": shopifyButtonBackgroundColor,
									":focus": {
										"background-color": shopifyButtonBackgroundColor
									},
									"border-radius": shopifyButtonRound + "px"
								},
								"title": {
									"color": shopifyCartFontColor //カート内文字色統一
								},
								"header": {
									"color": shopifyCartFontColor //カート内文字色統一
								},
								"lineItems": {
									"color": shopifyCartFontColor //カート内文字色統一
								},
								"subtotalText": {
									"color": shopifyCartFontColor //カート内文字色統一
								},
								"subtotal": {
									"color": shopifyCartFontColor //カート内文字色統一
								},
								"notice": {
									"color": shopifyCartFontColor //カート内文字色統一
								},
								"currency": {
									"color": shopifyCartFontColor //カート内文字色統一
								},
								"close": {
									"color": shopifyCartFontColor, //カート内文字色統一
									":hover": {
										"color": shopifyCartFontColor
									}
								},
								"empty": {
									"color": shopifyCartFontColor //カート内文字色統一
								},
								"noteDescription": {
									"color": shopifyCartFontColor //カート内文字色統一
								},
								"discountText": {
									"color": shopifyCartFontColor //カート内文字色統一
								},
								"discountIcon": {
									"fill": shopifyCartFontColor //カート内文字色統一
								},
								"discountAmount": {
									"color": shopifyCartFontColor //カート内文字色統一
								},
								"cart": {
									"background-color": shopifyCartBackgroundColor //カート背景色
								},
								"footer": {
									"background-color": shopifyCartBackgroundColor //カート背景色
								}
							},
							"text": {
								"title": cartTitleText, //見出し
								"total": cartTotalText, //小計
								"empty": cartEmptyText, //空の場合
								"notice": cartNoticeText, //追加情報
								"button": cartcheckoutButtonText, //ボタン
								"noteDescription": cartNoteDescriptionText //注文メモ
							},
							"popup": checkoutAction, //「同じタブでリダイレクト」の場合「false」
							"contents": {
								"note": cartDisplayNoteDescription //「注文のメモフィールドを表示する」場合「true」
							},
							"googleFonts": googleFontButton //Googleフォント読み込み
						},
						"toggle": {
							"styles": {
								"toggle": {
									"font-family": shopifyButtonFontFamily, //ボタンフォントと同じ
									"font-weight": shopifyButtonFontWeight,
									"background-color": shopifyButtonBackgroundColor, //ボタン背景色と同じ
									":hover": {
										"background-color": shopifyButtonHoverBackgroundColor
									},
									":focus": {
										"background-color": shopifyButtonBackgroundColor
									}
								},
								"count": { //ボタンスタイル同じ
									"font-size": shopifyButtonFontSize + "px",
									"color": shopifyButtonFontColor,
									":hover": {
										"color": shopifyButtonFontColor
									}
								},
								"iconPath": { //ボタンスタイル同じ
									"fill": shopifyButtonFontColor
								},
								"googleFonts": googleFontButton //Googleフォント読み込み
							}
						},
						"lineItem": {
							"styles": {
								"variantTitle": {
									"color": shopifyCartFontColor //カート内文字色統一
								},
								"title": {
									"color": shopifyCartFontColor //カート内文字色統一
								},
								"price": {
									"color": shopifyCartFontColor //カート内文字色統一
								},
								"fullPrice": {
									"color": shopifyCartFontColor //カート内文字色統一
								},
								"discount": {
									"color": shopifyCartFontColor //カート内文字色統一
								},
								"discountIcon": {
									"fill": shopifyCartFontColor //カート内文字色統一
								},
								"quantity": {
									"color": shopifyCartFontColor //カート内文字色統一
								},
								"quantityIncrement": {
									"color": shopifyCartFontColor, //カート内文字色統一
									"border-color": shopifyCartFontColor //カート内文字色統一
								},
								"quantityDecrement": {
									"color": shopifyCartFontColor, //カート内文字色統一
									"border-color": shopifyCartFontColor //カート内文字色統一
								},
								"quantityInput": {
									"color": shopifyCartFontColor, //カート内文字色統一
									"border-color": shopifyCartFontColor //カート内文字色統一
								}
							}
						}
					},
				});
			});
		}
	})();
	/*]]>*/
</script>
<?php
	$buyButton = ob_get_clean();
	$buyButton = str_replace("\t", '', $buyButton);
	$buyButton = preg_replace('#/\* .* \*/\n#', '', $buyButton);
	$buyButton = preg_replace('# //.*#', '', $buyButton);
	$buyButton = str_replace("\r", '', $buyButton);
	$buyButton = str_replace("\n", '', $buyButton);
	$buyButton = str_replace("\t", '', $buyButton);

	return apply_filters('cps_buy_button_html',$buyButton)."\n";
}
add_shortcode('shopifyBuyButton', 'connect_products_with_shopify_shopify_buy_button_shortcode');
?>