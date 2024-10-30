<?php
/*
Template Name: ShopifyインラインCSS
*/

if(!defined('ABSPATH')) exit;

/* 一覧表示 */
function connect_products_with_shopify_list_inline_css($column,$alignment,$number,$quantity)
{
	//設定情報
	$ConnectProductsShopifySettingsData = get_option('ConnectProductsShopifySettingsData');
	foreach ($ConnectProductsShopifySettingsData as $key => $val) {
		$$key = esc_html($val);
	}
	ob_start();
?>
#shopifyProductsListWrap {
width: 94%;
margin: 120px auto;
}

#shopifyProductsListWrap .shopifyProductsList {
display: flex;
display: -webkit-flex;
justify-content: flex-start;
-webkit-justify-content: flex-start;
flex-wrap: wrap;
-webkit-flex-wrap: wrap;
margin: 0 -1.25% -5%;
width: calc(100% + 2.5%);
}

#shopifyProductsListWrap .shopifyProductsList .shopifyProductListItem {
width: calc(100% / <?php echo $column; ?> - 2.5%);
margin: 0 1.25% 5%;
}
#shopifyProductsListWrap .shopifyProductsList .shopifyProductListItemImage {
width: 100%;
height: auto;
margin-bottom: 24px;
}

#shopifyProductsListWrap .shopify-buy__product {
max-width: 100%;
margin: 0;
}

#shopifyPagination {
display: flex;
display: -webkit-flex;
align-items: center;
-webkit-align-items: center;
justify-content: center;
-webkit-justify-content: center;
width: 94%;
margin: 0 auto 80px;
}

#shopifyPagination * {
-webkit-transition: all 200ms linear;
-moz-transition: all 200ms linear;
-ms-transition: all 200ms linear;
-o-transition: all 200ms linear;
transition: all 200ms linear;
}

#shopifyPagination .paginationNav {
display: flex;
display: -webkit-flex;
align-items: center;
-webkit-align-items: center;
justify-content: center;
-webkit-justify-content: center;
font-size: <?php echo $shopifyButtonFontSize; ?>px;
width: <?php echo $shopifyButtonFontSize * 2; ?>px;
height:  <?php echo $shopifyButtonFontSize * 2; ?>px;
line-height: 100%;
margin-right: <?php echo $shopifyButtonFontSize * 0.25; ?>px;
margin-left: <?php echo $shopifyButtonFontSize * 0.25; ?>px;
border-radius: 3px;
box-sizing: border-box;
padding: 0;
}

#shopifyPagination .paginationActive {
font-weight: bold;
border: 1px solid <?php echo $shopifyButtonBackgroundColor; ?>;
}

#shopifyPagination .paginationPrev,
#shopifyPagination .paginationNext {
margin: 0;
}

#shopifyPagination a.paginationNav:link,
#shopifyPagination a.paginationNav:visited,
#shopifyPagination a.paginationNav:active {
color: <?php echo $shopifyButtonFontColor; ?>;
background: <?php echo $shopifyButtonBackgroundColor; ?>;
}

#shopifyPagination a.paginationNav:hover {
opacity: 1;
filter: alpha(opacity=100);
-ms-filter: "alpha(opacity=100)";
-khtml-opacity: 1;
-moz-opacity: 1;
background: <?php echo $shopifyButtonHoverBackgroundColor; ?>;
}

#shopifyPagination .paginationNav svg {
width: <?php echo $shopifyButtonFontSize * 0.75; ?>px;
height: <?php echo $shopifyButtonFontSize * 0.75; ?>px;
}

#shopifyPagination .paginationNav path {
fill: <?php echo $shopifyButtonFontColor; ?>;
}

@media screen and (max-width: 1080px) {
#shopifyProductsListWrap {
margin: 108px auto;
}

#shopifyProductsListWrap .shopifyProductsList .shopifyProductListItem {
width: calc(100% / 3 - 2.5%);
}
}

@media screen and (max-width: 800px) {
#shopifyProductsListWrap {
margin: 96px auto;
}

#shopifyProductsListWrap .shopifyProductsList .shopifyProductListItem {
width: calc(100% / 2 - 2.5%);
margin-bottom: 7.5%;
}

#shopifyPagination {
margin-bottom: 72px;
}
}

@media screen and (max-width: 480px) {
#shopifyProductsListWrap {
margin: 72px auto;
}

#shopifyProductsListWrap .shopifyProductsList .shopifyProductListItem {
width: calc(100% / 1 - 2.5%);
margin-bottom: 15%;
}

#shopifyPagination {
margin-bottom: 64px;
}
}
<?php
	$css = ob_get_clean();
	$css = connect_products_with_shopify_css_simple_minify($css); //CSS圧縮

	return $css;
}

/* 個別 */
function connect_products_with_shopify_single_inline_css()
{
	//設定情報
	$ConnectProductsShopifySettingsData = get_option('ConnectProductsShopifySettingsData');
	foreach ($ConnectProductsShopifySettingsData as $key => $val) {
		$$key = esc_html($val);
	}
	ob_start();
?>
<?php
	$css = ob_get_clean();
	$css = connect_products_with_shopify_css_simple_minify($css); //CSS圧縮

	return $css;
}
?>