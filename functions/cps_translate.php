<?php
/*
Template Name: 翻訳
*/

if(!defined('ABSPATH')) exit;

use GoogleTranslateForConnectProductsWithShopify\GoogleTranslate;
require "GoogleTranslate.php";
	function connect_products_with_shopify_google_translate($from,$to,$text){
		$st = new GoogleTranslate($text, $from, $to);
		$result = $st->exec();
		return $result;
	}
?>