<?php
/*
Template Name: Shopify購入ボタンCSS
*/

if(!defined('ABSPATH')) exit;

function connect_products_with_shopify_buy_button_css($alignment,$maxWidth)
{
	//設定情報
	$ConnectProductsShopifySettingsData = get_option('ConnectProductsShopifySettingsData');
	foreach ($ConnectProductsShopifySettingsData as $key => $val) {
		$$key = esc_html($val);
	}

	if(empty($alignment)){
		$alignment = $displayAlignment;
	}

	if(!empty($maxWidth)){
		$displayClassicImageSize = $maxWidth;
	}

	ob_start();
?>
*[id*="product-component-"] *,
#shopifyProductsListWrap * {
font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
-webkit-box-sizing: border-box;
box-sizing: border-box;
-webkit-transition: all 200ms linear;
-moz-transition: all 200ms linear;
-ms-transition: all 200ms linear;
-o-transition: all 200ms linear;
transition: all 200ms linear;
}

*[id*="product-component-"],
#shopifyProductsListWrap {
text-rendering: optimizeLegibility;
-webkit-font-smoothing: antialiased;
-moz-osx-font-smoothing: grayscale;
}

*[id*="product-component-"] {
<?php
	if($maxWidth != 'unset'){
		echo 'max-width:'.$displayClassicImageSize.'px;';
	}
?>
width: 100%;
}

*[id*="product-component-"] select,
#shopifyProductsListWrap select {
text-rendering: auto !important;
}

*[id*="product-component-"] ul,
#shopifyProductsListWrap ul {
list-style: none;
padding-left: 0;
margin: 0;
}

*[id*="product-component-"] img,
#shopifyProductsListWrap img {
display: block;
max-width: 100%;
width: 100%;
}

*[id*="product-component-"] input,
#shopifyProductsListWrap input {
-webkit-appearance: textfield;
margin: 0;
}

.clearfix:after {
content: "";
display: table;
clear: both;
}

.visuallyhidden {
border: 0;
height: 1px;
margin: -1px;
overflow: hidden;
padding: 0;
position: absolute;
width: 1px;
}

.component-container {
overflow: hidden;
}

.shopify-buy__type--center {
text-align: center;
}

.shopify-buy--visually-hidden {
position: absolute !important;
clip: rect(1px, 1px, 1px, 1px);
padding: 0 !important;
border: 0 !important;
height: 1px !important;
width: 1px !important;
overflow: hidden;
}

.shopify-buy__quantity-decrement,
.shopify-buy__quantity-increment {
display: block;
height: 30px;
float: left;
line-height: 16px;
font-family: monospace;
width: 26px;
padding: 0;
border: none;
background: transparent;
-webkit-box-shadow: none;
box-shadow: none;
cursor: pointer;
font-size: 18px;
text-align: center;
border: 1px solid #767676;
position: relative
}

.shopify-buy__quantity-decrement svg,
.shopify-buy__quantity-increment svg {
width: 14px;
height: 14px;
position: absolute;
top: 50%;
left: 50%;
margin-top: -6px;
margin-left: -7px;
fill: currentColor;
}

.shopify-buy__quantity-decrement {
border-radius: 3px 0 0 3px;
}

.shopify-buy__quantity-increment {
border-radius: 0 3px 3px 0;
}

.shopify-buy__quantity {
color: black;
width: 45px;
height: 30px;
font-size: 16px;
border: none;
text-align: center;
-webkit-appearance: none;
-moz-appearance: textfield;
display: inline-block;
padding: 0;
border-radius: 0;
border-top: 1px solid #767676;
border-bottom: 1px solid #767676;
}

input[type=number]::-webkit-inner-spin-button,
input[type=number]::-webkit-outer-spin-button {
-webkit-appearance: none;
margin: 0;
}

.shopify-buy__quantity-container.shopify-buy__quantity-with-btns {
overflow: hidden
}

.shopify-buy__quantity-container.shopify-buy__quantity-with-btns .shopify-buy__quantity {
border-left: 0;
border-right: 0;
float: left;
}

.shopify-buy__btn {
font-family: <?php echo $shopifyButtonFontStyleFamily; ?>;
font-weight: <?php echo $shopifyButtonFontStyleWeight; ?>;
font-size: <?php echo $shopifyButtonFontSize; ?>px;
padding: <?php echo $shopifyButtonPaddingHeight; ?>px <?php echo $shopifyButtonPadding; ?>px;
display: inline-block;
color: <?php echo $shopifyButtonFontColor; ?>;
background-color: <?php echo $shopifyButtonBackgroundColor; ?>;
letter-spacing: .3px;
display: block;
border-radius: <?php echo $shopifyButtonRound; ?>px;
cursor: pointer;
-webkit-transition: background 200ms ease;
transition: background 200ms ease;
max-width: 100%;
text-overflow: ellipsis;
overflow: hidden;
line-height: 1.2;
border: 0;
-moz-appearance: none;
-webkit-appearance: none
}

*[id*="product-component-"] .shopify-buy__btn,
#shopifyProductsListWrap .shopify-buy__btn {
<?php
	if($alignment == 'right'){
		echo 'margin-right: 0; margin-left: auto;';
	}
	elseif($alignment == 'left'){
		echo 'margin-right: auto; margin-left: 0;';
	}
	else{
		echo 'margin-right: auto; margin-left: auto;';
	}
?>
}

.shopify-buy__btn--parent {
background-color: transparent;
border: 0;
padding: 0;
cursor: pointer
}

.shopify-buy__btn--parent:hover .product__variant-img,
.shopify-buy__btn--parent:focus .product__variant-img {
opacity: .7;
}

.shopify-buy__btn--cart-tab {
padding: 5px 11px;
border-radius: 3px 0 0 3px;
position: fixed;
right: 0;
top: 50%;
-webkit-transform: translate(100%, -50%);
transform: translate(100%, -50%);
opacity: 0;
min-width: inherit;
width: auto;
height: auto;
z-index: 2147483647
}

.shopify-buy__btn--cart-tab.is-active {
-webkit-transform: translateY(-50%);
transform: translateY(-50%);
opacity: 1;
}

.shopify-buy__btn__counter {
display: block;
margin: 0 auto 10px auto;
font-size: 18px;
}

.shopify-buy__icon-cart--side {
height: 20px;
width: 20px;
}

.shopify-buy__btn[disabled] {
background-color: #999;
pointer-events: none;
}

.shopify-buy__btn--close {
position: absolute;
right: 9px;
top: 8px;
font-size: 35px;
color: #767676;
border: none;
background-color: transparent;
-webkit-transition: color 100ms ease, -webkit-transform 100ms ease;
transition: color 100ms ease, -webkit-transform 100ms ease;
transition: transform 100ms ease, color 100ms ease;
transition: transform 100ms ease, color 100ms ease, -webkit-transform 100ms ease;
cursor: pointer;
font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
padding-right: 9px
}

.shopify-buy__btn--close:hover {
-webkit-transform: scale(1.2);
transform: scale(1.2);
color: hsl(0, 0%, 41.2745098039%);
}

.shopify-buy__option-select-wrapper {
border: 1px solid #d3dbe2;
border-radius: 3px;
-webkit-box-sizing: border-box;
box-sizing: border-box;
position: relative;
background: #fff;
overflow: hidden;
vertical-align: bottom;
}

.shopify-buy__select-icon {
cursor: pointer;
display: block;
fill: #798c9c;
position: absolute;
right: 10px;
top: 50%;
margin-top: -6px;
pointer-events: none;
width: 12px;
height: 12px;
vertical-align: middle;
}

.shopify-buy__option-select+.shopify-buy__option-select {
margin-top: 2.5%;
}

.shopify-buy__btn--parent .shopify-buy__option-select__label {
cursor: pointer;
}

.shopify-buy__option-select__select::-ms-expand {
display: none;
}

.shopify-buy__btn--parent .shopify-buy__option-select__select {
cursor: pointer;
}

.shopify-buy__product {
overflow: hidden;
width: 100%;
margin-bottom: 5%;
}

.shopify-buy__product__variant-img {
margin: 0 auto 3.75% auto;
-webkit-transition: opacity 0.3s ease;
transition: opacity 0.3s ease;
opacity: 1
}

.shopify-buy__product__variant-img.is-transitioning {
opacity: 0;
}

.shopify-buy__is-button {
cursor: pointer;
}

.shopify-buy__no-image .shopify-buy__product__variant-img {
display: none;
}

.shopify-buy__product__title {
display: block;
font-family: <?php echo $shopifyProductNameFontStyleFamily; ?>;
font-weight: <?php echo $shopifyProductNameFontStyleWeight; ?>;
font-size: <?php echo $shopifyProductNameFontSize; ?>px;
color: <?php echo $shopifyProductNameFontColor; ?>;
line-height: 150%;
margin-bottom: 1.25%;
}

.shopify-buy__layout-horizontal .shopify-buy__product__title {
margin-top: 1.25%;
}

.shopify-buy__product__variant-title {
font-size: 18px;
color: #666;
font-weight: 400;
text-align: center;
margin-bottom: 1.25%;
}

.shopify-buy__product__price {
margin-bottom: 1.25%;
}

.shopify-buy__product-description p,
.shopify-buy__product-description ul,
.shopify-buy__product-description ol,
.shopify-buy__product-description img {
margin-bottom: 10px
}

.shopify-buy__product-description p:last-child,
.shopify-buy__product-description ul:last-child,
.shopify-buy__product-description ol:last-child,
.shopify-buy__product-description img:last-child {
margin-bottom: 0;
}

.shopify-buy__product-description a {
color: inherit;
}

.shopify-buy__product-description img {
max-width: 100%;
}

.shopify-buy__product-description h1 {
font-size: 20px;
}

.shopify-buy__product-description h2 {
font-size: 18px;
}

.shopify-buy__product-description h3 {
font-size: 17px;
}

.shopify-buy__product-description ul,
.shopify-buy__product-description ol {
margin-left: 2em;
}

.shopify-buy__product-description ul {
list-style-type: disc;
}

.shopify-buy__layout-vertical {
text-align: center;
}

.shopify-buy__product__variant-selectors {
text-align: left;
font-size: 14px;
margin-bottom: 3.75%;
}

.shopify-buy__layout-vertical .shopify-buy__product__variant-selectors {
width: 100%;
max-width: 280px;
display: inline-block;
}

.shopify-buy__quantity {
border-left: 1px solid;
border-right: 1px solid;
border-radius: 3px;
}

.shopify-buy__quantity,
.shopify-buy__quantity-increment,
.shopify-buy__quantity-decrement {
border-color: #d3dbe2;
line-height: 1.2;
font-size: 15px;
height: auto;
padding-top: 12px;
padding-bottom: 12px;
}

.shopify-buy__btn-wrapper {
margin-top: 20px;
}

.shopify-buy__btn.shopify-buy__beside-quantity {
display: inline-block;
vertical-align: top;
border-top-left-radius: 0;
border-bottom-left-radius: 0;
border: 1px solid transparent;
}

.shopify-buy__btn-and-quantity .shopify-buy__quantity {
border-right: 0;
border-top-right-radius: 0;
border-bottom-right-radius: 0;
background: #fff;
}

.shopify-buy__btn-and-quantity .shopify-buy__quantity-container {
display: inline-block;
vertical-align: top;
}

.shopify-buy__btn-and-quantity .shopify-buy__btn-wrapper {
display: inline-block;
vertical-align: top;
margin: 0;
}

.shopify-buy__cart-item__quantity-container {
margin-top: 20px;
display: inline-block;
}

.shopify-buy__layout-vertical .shopify-buy__btn,
.shopify-buy__layout-vertical .shopify-buy__quantity-container,
.shopify-buy__layout-horizontal .shopify-buy__btn,
.shopify-buy__layout-horizontal .shopify-buy__quantity-container {
margin-top: 20px;
}

.shopify-buy__layout-vertical .shopify-buy__btn:first-child,
.shopify-buy__layout-horizontal .shopify-buy__btn:first-child {
margin-top: 0;
}

.shopify-buy__layout-vertical .shopify-buy__btn-and-quantity .shopify-buy__btn,
.shopify-buy__layout-vertical .shopify-buy__btn-and-quantity .shopify-buy__quantity-container,
.shopify-buy__layout-horizontal .shopify-buy__btn-and-quantity .shopify-buy__btn,
.shopify-buy__layout-horizontal .shopify-buy__btn-and-quantity .shopify-buy__quantity-container {
margin: 0 auto;
}

.shopify-buy__layout-vertical .shopify-buy__btn-and-quantity:first-child,
.shopify-buy__layout-horizontal .shopify-buy__btn-and-quantity:first-child {
margin: 0 auto;
}

.shopify-buy__layout-vertical .shopify-buy__product__variant-img,
.shopify-buy__layout-horizontal .shopify-buy__product__variant-img {
max-width: 100%;
}

@media (min-width: 500px) {
.shopify-buy__layout-horizontal:not(.no-image) {
text-align: left;
margin-bottom: 0;
margin-left: 0
}

.shopify-buy__layout-horizontal:not(.no-image) .shopify-buy__product-img-wrapper {
float: left;
width: 40%;
}

.shopify-buy__layout-horizontal:not(.no-image) .shopify-buy__product__variant-title {
text-align: left;
}

.shopify-buy__layout-horizontal:not(.no-image) .shopify-buy__product__title,
.shopify-buy__layout-horizontal:not(.no-image) .shopify-buy__product__variant-title,
.shopify-buy__layout-horizontal:not(.no-image) .shopify-buy__product__price,
.shopify-buy__layout-horizontal:not(.no-image) .shopify-buy__product-description,
.shopify-buy__layout-horizontal:not(.no-image) .shopify-buy__btn-and-quantity,
.shopify-buy__layout-horizontal:not(.no-image)>.shopify-buy__btn-wrapper,
.shopify-buy__layout-horizontal:not(.no-image)>.shopify-buy__quantity-container,
.shopify-buy__layout-horizontal:not(.no-image) .shopify-buy__product__variant-selectors {
margin-left: calc(40% + 25px);
}
}

@media (min-width: 680px) {
.shopify-buy__layout-horizontal:not(.no-image) .shopify-buy__product-img-wrapper {
width: 50%;
}

.shopify-buy__layout-horizontal:not(.no-image) .shopify-buy__product__title,
.shopify-buy__layout-horizontal:not(.no-image) .shopify-buy__product__variant-title,
.shopify-buy__layout-horizontal:not(.no-image) .shopify-buy__product__price,
.shopify-buy__layout-horizontal:not(.no-image) .shopify-buy__product-description,
.shopify-buy__layout-horizontal:not(.no-image) .shopify-buy__btn-and-quantity,
.shopify-buy__layout-horizontal:not(.no-image)>.shopify-buy__btn-wrapper,
.shopify-buy__layout-horizontal:not(.no-image)>.shopify-buy__quantity-container,
.shopify-buy__layout-horizontal:not(.no-image) .shopify-buy__product__variant-selectors {
margin-left: calc(50% + 25px);
}
}

.no-image .shopify-buy__product-img-wrapper {
display: none;
}

@-webkit-keyframes dash {
to {
stroke-dashoffset: 0;
}
}

@keyframes dash {
to {
stroke-dashoffset: 0;
}
}

.shopify-buy__carousel {
font-size: 0;
text-align: center;
min-height: 90px;
margin-left: -15px;
margin-top: 15px;
margin-bottom: 2.5%;
}

.shopify-buy__carousel-item {
width: calc(16.666% - 15px);
margin-left: 15px;
display: inline-block;
vertical-align: middle;
cursor: pointer;
position: relative;
background-size: cover;
background-position: center;
padding: 0;
border: none
}

.shopify-buy__carousel-item:nth-child(n+7) {
margin-top: 15px;
}

.shopify-buy__carousel-item:before {
content: "";
display: block;
padding-top: 100%;
}

.main-image-wrapper {
position: relative;
}

.carousel-button {
position: absolute;
width: 75px;
top: 0;
height: 100%;
border: none;
font-size: 0;
background-color: transparent;
opacity: 0.4;
cursor: pointer
}

.carousel-button:hover,
.carousel-button:focus {
opacity: 0.9;
outline: none;
}

*[id*="product-component-"] .carousel-button-arrow {
width: 20px;
display: inline-block;
margin-left: 25px;
}

.carousel-button--previous {
left: 0;
-webkit-transform: rotate(180deg);
transform: rotate(180deg);
}

.carousel-button--next {
right: 0;
}

.shopify-buy__carousel-item--selected {
opacity: 0.4;
}

.shopify-buy__product {
text-align: <?php echo $alignment; ?>;
}

.shopify-buy__btn:hover {
color: <?php echo $shopifyButtonFontColor; ?>;
background-color: <?php echo $shopifyButtonHoverBackgroundColor; ?>;
opacity: 1;
filter: alpha(opacity=100);
-ms-filter: "alpha(opacity=100)";
-khtml-opacity: 1;
-moz-opacity: 1;
}

.shopify-buy__btn:focus {
background-color: <?php echo $shopifyButtonBackgroundColor; ?>;
}

.shopify-buy__quantity {
font-size: <?php echo $shopifyButtonFontSize; ?>px;
padding-top: <?php echo $shopifyButtonPaddingHeight; ?>px;
padding-bottom: <?php echo $shopifyButtonPaddingHeight; ?>px;
}

.shopify-buy__product__actual-price,
.shopify-buy__product__compare-price,
.shopify-buy__product__unit-price {
font-family: <?php echo $shopifyPriceFontStyleFamily; ?>;
font-weight: <?php echo $shopifyPriceFontStyleWeight; ?>;
color: <?php echo $shopifyPriceFontColor; ?>;
}

.shopify-buy__product__actual-price,
.shopify-buy__product__compare-price {
display: inline-block;
}

.shopify-buy__product__actual-price {
font-size: <?php echo $shopifyPriceFontSize; ?>px;
}

.shopify-buy__product__compare-price,
.shopify-buy__product__unit-price {
font-size: <?php echo $shopifyUnitPriceFontSize; ?>px;
}

.shopify-buy__product__compare-price {
text-decoration: line-through;
padding-left: 5px;
opacity: 0.65;
}

.shopify-buy__product__unit-price {
padding-top: 5px;
opacity: 0.8;
}

.shopify-buy__product-description {
font-family: <?php echo $shopifyProductDescriptionFontStyleFamily; ?>;
font-weight: <?php echo $shopifyProductDescriptionFontStyleWeight; ?>;
font-size: <?php echo $shopifyProductDescriptionFontSize; ?>px;
color: <?php echo $shopifyProductDescriptionFontColor; ?>;
margin-top: 5%;
line-height: 150%;
}

.shopify-buy__option-select__label {
display: block;
font-family: <?php echo $shopifyVariationFontStyleFamily; ?>;
font-weight: <?php echo $shopifyVariationFontStyleWeight; ?>;
font-size: <?php echo $shopifyVariationFontSize; ?>px;
color: <?php echo $shopifyVariationFontColor; ?>;
margin-bottom: 0.75%;
}

.shopify-buy__option-select__select {
font-family: <?php echo $shopifyVariationFontStyleFamily; ?>;
font-size: inherit;
padding: 6px 32px 6px 8px;
border: 0;
width: 100%;
background: transparent;
-webkit-appearance: none;
-moz-appearance: none
}

@media screen and (max-width: 500px) {
.shopify-buy__carousel {
min-height: 17.5vw;
}
.shopify-buy__product__variant-selectors {
margin-bottom: 7.5%;
}
}

<?php
	$css = ob_get_clean();
	$css = connect_products_with_shopify_css_simple_minify($css); //CSS圧縮

	return $css;
}
?>