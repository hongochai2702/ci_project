<?php
// Heading
$lang['heading_title']                = 'Stores';

// Text
$lang['text_settings']                = 'Settings';
$lang['text_success']                 = 'Success: You have modified Stores!';
$lang['text_list']                    = 'Store List';
$lang['text_add']                     = 'Add Store';
$lang['text_edit']                    = 'Edit Store';
$lang['text_items']                   = 'Items';
$lang['text_tax']                     = 'Taxes';
$lang['text_account']                 = 'Account';
$lang['text_checkout']                = 'Checkout';
$lang['text_stock']                   = 'Stock';
$lang['text_shipping']                = 'Shipping Address';
$lang['text_payment']                 = 'Payment Address';

// Column
$lang['column_name']                  = 'Store Name';
$lang['column_url']	               = 'Store URL';
$lang['column_action']                = 'Action';

// Entry
$lang['entry_url']                    = 'Store URL';
$lang['entry_ssl']                    = 'SSL URL';
$lang['entry_meta_title']             = 'Meta Title';
$lang['entry_meta_description']       = 'Meta Tag Description';
$lang['entry_meta_keyword']           = 'Meta Tag Keywords';
$lang['entry_layout']                 = 'Default Layout';
$lang['entry_theme']                  = 'Theme';
$lang['entry_name']                   = 'Store Name';
$lang['entry_owner']                  = 'Store Owner';
$lang['entry_address']                = 'Address';
$lang['entry_geocode']                = 'Geocode';
$lang['entry_email']                  = 'E-Mail';
$lang['entry_telephone']              = 'Telephone';
$lang['entry_fax']                    = 'Fax';
$lang['entry_image']                  = 'Image';
$lang['entry_open']                   = 'Opening Times';
$lang['entry_comment']                = 'Comment';
$lang['entry_location']               = 'Store Location';
$lang['entry_country']                = 'Country';
$lang['entry_zone']                   = 'Region / State';
$lang['entry_language']               = 'Language';
$lang['entry_currency']               = 'Currency';
$lang['entry_tax']                    = 'Display Prices With Tax';
$lang['entry_tax_default']            = 'Use Store Tax Address';
$lang['entry_tax_customer']           = 'Use Customer Tax Address';
$lang['entry_customer_group']         = 'Customer Group';
$lang['entry_customer_group_display'] = 'Customer Groups';
$lang['entry_customer_price']         = 'Login Display Prices';
$lang['entry_account']                = 'Account Terms';
$lang['entry_cart_weight']            = 'Display Weight on Cart Page';
$lang['entry_checkout_guest']         = 'Guest Checkout';
$lang['entry_checkout']               = 'Checkout Terms';
$lang['entry_order_status']           = 'Order Status';
$lang['entry_stock_display']          = 'Display Stock';
$lang['entry_stock_checkout']         = 'Stock Checkout';
$lang['entry_logo']                   = 'Store Logo';
$lang['entry_icon']                   = 'Icon';
$lang['entry_secure']                 = 'Use SSL';

// Help
$lang['help_url']                     = 'Include the full URL to your store. Make sure to add \'/\' at the end. Example: http://www.yourdomain.com/path/<br /><br />Don\'t use directories to create a new store. You should always point another domain or sub domain to your hosting.';
$lang['help_ssl']                     = 'SSL URL to your store. Make sure to add \'/\' at the end. Example: http://www.yourdomain.com/path/<br /><br />Don\'t use directories to create a new store. You should always point another domain or sub domain to your hosting.';
$lang['help_geocode']                 = 'Please enter your store location geocode manually.';
$lang['help_open']                    = 'Fill in your stores opening times.';
$lang['help_comment']                 = 'This field is for any special notes you would like to tell the customer i.e. Store does not accept cheques.';
$lang['help_location']                = 'The different store locations you have that you want displayed on the contact us form.';
$lang['help_currency']                = 'Change the default currency. Clear your browser cache to see the change and reset your existing cookie.';
$lang['help_tax_default']             = 'Use the store address to calculate taxes if customer is not logged in. You can choose to use the store address for the customer\'s shipping or payment address.';
$lang['help_tax_customer']            = 'Use the customers default address when they login to calculate taxes. You can choose to use the default address for the customer\'s shipping or payment address.';
$lang['help_customer_group']          = 'Default customer group.';
$lang['help_customer_group_display']  = 'Display customer groups that new customers can select to use such as wholesale and business when signing up.';
$lang['help_customer_price']          = 'Only show prices when a customer is logged in.';
$lang['help_account']                 = 'Forces people to agree to terms before an account can be created.';
$lang['help_checkout_guest']          = 'Allow customers to checkout without creating an account. This will not be available when a downloadable product is in the shopping cart.';
$lang['help_checkout']                = 'Forces people to agree to terms before an a customer can checkout.';
$lang['help_order_status']            = 'Set the default order status when an order is processed.';
$lang['help_stock_display']           = 'Display stock quantity on the product page.';
$lang['help_stock_checkout']          = 'Allow customers to still checkout if the products they are ordering are not in stock.';
$lang['help_icon']                    = 'The icon should be a PNG that is 16px x 16px.';
$lang['help_secure']                  = 'To use SSL check with your host if a SSL certificate is installed.';

// Error
$lang['error_warning']                = 'Warning: Please check the form carefully for errors!';
$lang['error_permission']             = 'Warning: You do not have permission to modify stores!';
$lang['error_url']                    = 'Store URL required!';
$lang['error_meta_title']             = 'Title must be between 3 and 32 characters!';
$lang['error_name']                   = 'Store Name must be between 3 and 32 characters!';
$lang['error_owner']                  = 'Store Owner must be between 3 and 64 characters!';
$lang['error_address']                = 'Store Address must be between 10 and 256 characters!';
$lang['error_email']                  = 'E-Mail Address does not appear to be valid!';
$lang['error_telephone']              = 'Telephone must be between 3 and 32 characters!';
$lang['error_customer_group_display'] = 'You must include the default customer group if you are going to use this feature!';
$lang['error_default']                = 'Warning: You can not delete your default store!';
$lang['error_store']                  = 'Warning: This Store cannot be deleted as it is currently assigned to %s orders!';