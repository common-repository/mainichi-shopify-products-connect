=== Connect Products with Shopify ===
Contributors: mainichiweb
Donate link:
Tags: shopify,product,connect
Requires at least: 5.0
Tested up to: 6.4
Stable tag: 1.1.6
Requires PHP: 7.0
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

You can connect Shopify to retrieve all the products in your store and automatically register them in a custom WordPress post.

== Description ==

"Connect Products with Shopify" allows you to easily connect products from your Shopify store to WordPress.

The product information retrieved includes the product title and description, as well as the price, image path, etc., and is stored in the custom field value of the WordPress custom post. The product type and tags will also be registered as terms and associated with the product.

Buy button and products list for the product can be displayed with a shortcode. You can customize the layout and design of the buy button according to shopify's rules on the plugin's configuration page.

This is a plugin that works well with the shopify starter plan ($5.00 USD).

== Installation ==

1. Upload `plugin-name.php` to the `/wp-content/plugins/` directory
1. Activate the plugin through the 'Plugins' menu in WordPress
1. Place `<?php do_action('plugin_name_hook'); ?>` in your templates

== Frequently asked questions ==

= How to connect WordPress with Shopify =

First, you need to create a "Private App" on Shopify side.
 * Check "Allow this app to access your storefront data using the Storefront API".
 * Check all items in "STOREFRONT API PERMISSIONS".
 * Click "Show inactive Admin API permissions".
 * All items should be set to "Read access" or "Read and write".

Next, let's configure the WordPress side "Connect Products with Shopify".
 * Enter the information you found on the Shopify page earlier.
 * After entering the information, click the "Save the connection settings" button.
 * When you see the message "You have been connected to the Shopify store.", the integration is complete.

Next, let's link the products.
 * Click the "Connect products" button.
 * When you see the message "~ Products have been connected", the linkage is complete.

= Shortcode to display products list =
You can use a shortcode to display a list of products.
[shopifyProductsList]

Code for use in template files.
echo do_shortcode('[shopifyProductsList]');

You can customize the display by setting the attributes.
Example : [shopifyProductsList limit="6" column="2" type="category-a,category-b,category-c" sort="low-price"]

= Shortcode to display a buy button =

You can display a buy button for a specific product by specifying the product ID.
[shopifyBuyButton id={product-id}]

You don't need to specify the ID as long as it is within the loop of the product page.
[shopifyBuyButton]

You can customize the display by setting the attributes.
Example : [shopifyBuyButton id="0000000000000" alignment="center" image="580" quantity="show"]

== Screenshots ==

1.Products can be connected with a single click.
2.Easy-to-read list of products to register.
3.Register most of your product information as a post.
4.This is an example of displaying a buy button.
5.Attributes available in the shortcode.

== Changelog ==

1.0.0
Initial working version.

1.0.1
Fixed so that custom post (product) other than Shopify will not disappear when uninstalling the plugin.

1.0.2
I fixed it, hoping the translation will work.

1.1.0
Added a short tag for displaying the products list and a bulk delete button.

1.1.1
Minor CSS fixes.

1.1.2
Eliminated errors in debug mode.

1.1.3
WP5.9 support.

1.1.4
WP6.2 support.

1.1.5
Fixed a bug that prevented plugin from being deleted.

1.1.6
WP6.4 support.

== Upgrade notice ==



== Arbitrary section 1 ==