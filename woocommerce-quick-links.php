<?php
/* @wordpress-plugin
 * Plugin Name:       EDD Quick Links
 * Plugin URI:        https://wpruby.com
 * Description:       Add all the important EDD links in a dashboard widget.
 * Version:           1.0.0
 * Author:            WPRuby
 * Author URI:        https://wpruby.com
 * Text Domain:       edd
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 */


if(eql_is_edd_active()){

	add_action('admin_bar_menu', 'edd_quicklinks_add_toolbar_items',100);

	function edd_quicklinks_add_toolbar_items($admin_bar){
		//In case the user has no capabilities
		if(!current_user_can('manage_options')) return;

		// Prepare payment gateways
		$available_gateways = edd_get_enabled_payment_gateways();

		//The main menu element
		$admin_bar->add_menu( array(
			'id'    => 'eql_quick_links_menu',
			'title' => 'Easy Digital Downloads',
			'href'  => '#',
		));
		//Products
		$admin_bar->add_menu( array(
			'id'    => 'eql_downloads_menu',
			'title' => __('Downloads','edd'),
			'href'  => admin_url('edit.php?post_type=download'),
			'parent'=> 'eql_quick_links_menu'
		));
		$admin_bar->add_menu( array(
			'id'    => 'eql_download_new_menu',
			'title' => __('Add New Download','edd'),
			'href'  => admin_url('post-new.php?post_type=download'),
			'parent'=> 'eql_downloads_menu'
		));
		$admin_bar->add_menu( array(
			'id'    => 'eql_categories_menu',
			'title' => __('Categories','edd'),
			'href'  => admin_url('edit-tags.php?taxonomy=download_category&post_type=download'),
			'parent'=> 'eql_downloads_menu'
		));
		$admin_bar->add_menu( array(
			'id'    => 'eql_tags_menu',
			'title' => __('Tags','edd'),
			'href'  => admin_url('edit-tags.php?taxonomy=download_tag&post_type=download'),
			'parent'=> 'eql_downloads_menu'
		));
		//Payment History
		$admin_bar->add_menu( array(
			'id'    => 'eql_payment_history_menu',
			'title' => __('Payment History','edd'),
			'href'  => admin_url('edit.php?post_type=download&page=edd-payment-history'),
			'parent'=> 'eql_quick_links_menu'
		));
		$admin_bar->add_menu( array(
			'id'    => 'eql_payment_history_completed_menu',
			'title' => __('Completed','edd'),
			'href'  => admin_url('edit.php?post_type=download&page=edd-payment-history&status=publish'),
			'parent'=> 'eql_payment_history_menu'
		));
		$admin_bar->add_menu( array(
			'id'    => 'eql_payment_history_pending_menu',
			'title' => __('Pending','edd'),
			'href'  => admin_url('edit.php?post_type=download&page=edd-payment-history&status=pending'),
			'parent'=> 'eql_payment_history_menu'
		));	
		$admin_bar->add_menu( array(
			'id'    => 'eql_payment_history_refunded_menu',
			'title' => __('Refunded','edd'),
			'href'  => admin_url('edit.php?post_type=download&page=edd-payment-history&status=refunded'),
			'parent'=> 'eql_payment_history_menu'
		));	
		$admin_bar->add_menu( array(
			'id'    => 'eql_payment_history_revoked_menu',
			'title' => __('Revoked','edd'),
			'href'  => admin_url('edit.php?post_type=download&page=edd-payment-history&status=revoked'),
			'parent'=> 'eql_payment_history_menu'
		));	
		$admin_bar->add_menu( array(
			'id'    => 'eql_payment_history_failed_menu',
			'title' => __('Failed','edd'),
			'href'  => admin_url('edit.php?post_type=download&page=edd-payment-history&status=failed'),
			'parent'=> 'eql_payment_history_menu'
		));							
		$admin_bar->add_menu( array(
			'id'    => 'eql_payment_history_abandoned_menu',
			'title' => __('Abandoned','edd'),
			'href'  => admin_url('edit.php?post_type=download&page=edd-payment-history&status=abandoned'),
			'parent'=> 'eql_payment_history_menu'
		));	
		//Customers
		$admin_bar->add_menu( array(
			'id'    => 'eql_customers_menu',
			'title' => __('Customers','edd'),
			'href'  => admin_url('edit.php?post_type=download&page=edd-customers'),
			'parent'=> 'eql_quick_links_menu'
		));
		//Discounts
		$admin_bar->add_menu( array(
			'id'    => 'eql_discount_codes_menu',
			'title' => __('Discount Codes','edd'),
			'href'  => admin_url('edit.php?post_type=download&page=edd-discounts'),
			'parent'=> 'eql_quick_links_menu'
		));	
		$admin_bar->add_menu( array(
			'id'    => 'eql_discount_codes_new_menu',
			'title' => __('Add New Discount','edd'),
			'href'  => admin_url('edit.php?post_type=download&page=edd-discounts&edd-action=add_discount'),
			'parent'=> 'eql_discount_codes_menu'
		));
		//Reports
		$admin_bar->add_menu( array(
			'id'    => 'eql_reports_menu',
			'title' => __('Reports','edd'),
			'href'  => admin_url('edit.php?post_type=download&page=edd-reports'),
			'parent'=> 'eql_quick_links_menu'
		));	
		$admin_bar->add_menu( array(
			'id'    => 'eql_reports_earnings_menu',
			'title' => __('Earnings','edd'),
			'href'  => admin_url('edit.php?view=earnings&post_type=download&page=edd-reports&submit=Show'),
			'parent'=> 'eql_reports_menu'
		));	
		$admin_bar->add_menu( array(
			'id'    => 'eql_reports_earnings_bycategory_menu',
			'title' => __('Earnings by Category','edd'),
			'href'  => admin_url('edit.php?view=categories&post_type=download&page=edd-reports&submit=Show'),
			'parent'=> 'eql_reports_menu'
		));	
		$admin_bar->add_menu( array(
			'id'    => 'eql_reports_earnings_downloads_menu',
			'title' => __('Downloads','edd'),
			'href'  => admin_url('edit.php?view=downloads&post_type=download&page=edd-reports&submit=Show'),
			'parent'=> 'eql_reports_menu'
		));
		$admin_bar->add_menu( array(
			'id'    => 'eql_reports_earnings_payment_methods_menu',
			'title' => __('Payment Methods','edd'),
			'href'  => admin_url('edit.php?view=gateways&category=all&post_type=download&page=edd-reports&submit=Show'),
			'parent'=> 'eql_reports_menu'
		));
		$admin_bar->add_menu( array(
			'id'    => 'eql_reports_earnings_taxes_menu',
			'title' => __('Taxes','edd'),
			'href'  => admin_url('edit.php?view=taxes&post_type=download&page=edd-reports&submit=Show'),
			'parent'=> 'eql_reports_menu'
		));
		$admin_bar->add_menu( array(
			'id'    => 'eql_reports_export_menu',
			'title' => __('Export','edd'),
			'href'  => admin_url('edit.php?post_type=download&page=edd-reports&tab=export'),
			'parent'=> 'eql_reports_menu'
		));
		$admin_bar->add_menu( array(
			'id'    => 'eql_reports_logs_menu',
			'title' => __('Logs','edd'),
			'href'  => admin_url('edit.php?post_type=download&page=edd-reports&tab=logs'),
			'parent'=> 'eql_reports_menu'
		));
		//Settings
		$admin_bar->add_menu( array(
			'id'    => 'eql_settings_menu',
			'title' => __('Settings','edd'),
			'href'  => admin_url('edit.php?post_type=download&page=edd-settings'),
			'parent'=> 'eql_quick_links_menu'
		));
		$admin_bar->add_menu( array(
			'id'    => 'eql_settings_general_menu',
			'title' => __('General','edd'),
			'href'  => admin_url('edit.php?post_type=download&page=edd-settings&tab=general'),
			'parent'=> 'eql_settings_menu'
		));
		$admin_bar->add_menu( array(
			'id'    => 'eql_settings_general_settings_menu',
			'title' => __('General Settings','edd'),
			'href'  => admin_url('edit.php?post_type=download&page=edd-settings&tab=general'),
			'parent'=> 'eql_settings_general_menu'
		));
		$admin_bar->add_menu( array(
			'id'    => 'eql_settings_currency_settings_menu',
			'title' => __('Currency Settings','edd'),
			'href'  => admin_url('edit.php?post_type=download&page=edd-settings&tab=currency'),
			'parent'=> 'eql_settings_general_menu'
		));
		$admin_bar->add_menu( array(
			'id'    => 'eql_settings_api_settings_menu',
			'title' => __('API Settings','edd'),
			'href'  => admin_url('edit.php?post_type=download&page=edd-settings&tab=api'),
			'parent'=> 'eql_settings_general_menu'
		));	
		$admin_bar->add_menu( array(
			'id'    => 'eql_settings_payment_gateways_menu',
			'title' => __('Payment Gateways','edd'),
			'href'  => admin_url('edit.php?post_type=download&page=edd-settings&tab=general'),
			'parent'=> 'eql_settings_menu'
		));	
		$admin_bar->add_menu( array(
			'id'    => 'eql_settings_payment_gateways_settings_menu',
			'title' => __('Gateways Settings','edd'),
			'href'  => admin_url('edit.php?post_type=download&page=edd-settings&tab=gateways&section=main'),
			'parent'=> 'eql_settings_payment_gateways_menu'
		));	
		foreach($available_gateways as $key => $gateway):
			$admin_bar->add_menu( array(
				'id'    => 'eql_settings_gateway_'. $key .'_menu',
				'title' => $gateway['admin_label'],
				'href'  => admin_url('edit.php?post_type=download&page=edd-settings&tab=gateways&section=' . $key),
				'parent'=> 'eql_settings_payment_gateways_menu'
			));	
		endforeach;	
		$admin_bar->add_menu( array(
			'id'    => 'eql_settings_emails_menu',
			'title' => __('Emails','edd'),
			'href'  => admin_url('edit.php?post_type=download&page=edd-settings&tab=emails'),
			'parent'=> 'eql_settings_menu'
		));
		$admin_bar->add_menu( array(
			'id'    => 'eql_settings_emails_settings_menu',
			'title' => __('Email Settings','edd'),
			'href'  => admin_url('edit.php?post_type=download&page=edd-settings&tab=emails'),
			'parent'=> 'eql_settings_emails_menu'
		));	
		$admin_bar->add_menu( array(
			'id'    => 'eql_settings_emails_purchase_receipts_menu',
			'title' => __('Purchase Receipts','edd'),
			'href'  => admin_url('edit.php?post_type=download&page=edd-settings&tab=emails&section=purchase_receipts'),
			'parent'=> 'eql_settings_emails_menu'
		));
		$admin_bar->add_menu( array(
			'id'    => 'eql_settings_emails_newsale_menu',
			'title' => __('New Sale Notifications','edd'),
			'href'  => admin_url('edit.php?post_type=download&page=edd-settings&tab=emails&section=sale_notifications'),
			'parent'=> 'eql_settings_emails_menu'
		));	
		$admin_bar->add_menu( array(
			'id'    => 'eql_settings_styles_menu',
			'title' => __('Style Settings','edd'),
			'href'  => admin_url('edit.php?post_type=download&page=edd-settings&tab=styles'),
			'parent'=> 'eql_settings_menu'
		));	
		$admin_bar->add_menu( array(
			'id'    => 'eql_settings_taxes_menu',
			'title' => __('Taxes Settings','edd'),
			'href'  => admin_url('edit.php?post_type=download&page=edd-settings&tab=taxes'),
			'parent'=> 'eql_settings_menu'
		));	
		$admin_bar->add_menu( array(
			'id'    => 'eql_settings_misc_menu',
			'title' => __('Misc','edd'),
			'href'  => admin_url('edit.php?post_type=download&page=edd-settings&tab=misc'),
			'parent'=> 'eql_settings_menu'
		));	
		$admin_bar->add_menu( array(
			'id'    => 'eql_settings_misc_settings_menu',
			'title' => __('Misc Settings','edd'),
			'href'  => admin_url('edit.php?post_type=download&page=edd-settings&tab=misc'),
			'parent'=> 'eql_settings_misc_menu'
		));	
		$admin_bar->add_menu( array(
			'id'    => 'eql_settings_misc_checkout_settings_menu',
			'title' => __('Checkout Settings','edd'),
			'href'  => admin_url('edit.php?post_type=download&page=edd-settings&tab=misc&section=checkout'),
			'parent'=> 'eql_settings_misc_menu'
		));	
		$admin_bar->add_menu( array(
			'id'    => 'eql_settings_misc_btn_text_menu',
			'title' => __('Button Text','edd'),
			'href'  => admin_url('edit.php?post_type=download&page=edd-settings&tab=misc&section=button_text'),
			'parent'=> 'eql_settings_misc_menu'
		));
		$admin_bar->add_menu( array(
			'id'    => 'eql_settings_misc_file_downloads_menu',
			'title' => __('File Downloads','edd'),
			'href'  => admin_url('edit.php?post_type=download&page=edd-settings&tab=misc&section=file_downloads'),
			'parent'=> 'eql_settings_misc_menu'
		));	
		$admin_bar->add_menu( array(
			'id'    => 'eql_settings_misc_account_menu',
			'title' => __('Accounting Settings','edd'),
			'href'  => admin_url('edit.php?post_type=download&page=edd-settings&tab=misc&section=accounting'),
			'parent'=> 'eql_settings_misc_menu'
		));	
		$admin_bar->add_menu( array(
			'id'    => 'eql_settings_misc_terms_agreement_menu',
			'title' => __('Terms of Agreement','edd'),
			'href'  => admin_url('edit.php?post_type=download&page=edd-settings&tab=misc&section=site_terms'),
			'parent'=> 'eql_settings_misc_menu'
		));	
		//Tools
		$admin_bar->add_menu( array(
			'id'    => 'eql_tools_menu',
			'title' => __('Tools','edd'),
			'href'  => admin_url('edit.php?post_type=download&page=edd-tools'),
			'parent'=> 'eql_quick_links_menu'
		));
		$admin_bar->add_menu( array(
			'id'    => 'eql_tools_general_menu',
			'title' => __('General','edd'),
			'href'  => admin_url('edit.php?post_type=download&page=edd-tools&tab=general'),
			'parent'=> 'eql_tools_menu'
		));
		$admin_bar->add_menu( array(
			'id'    => 'eql_tools_api_menu',
			'title' => __('API Keys','edd'),
			'href'  => admin_url('edit.php?post_type=download&page=edd-tools&tab=api_keys'),
			'parent'=> 'eql_tools_menu'
		));	
		$admin_bar->add_menu( array(
			'id'    => 'eql_tools_sys_info_menu',
			'title' => __('System Info','edd'),
			'href'  => admin_url('edit.php?post_type=download&page=edd-tools&tab=system_info'),
			'parent'=> 'eql_tools_menu'
		));
		$admin_bar->add_menu( array(
			'id'    => 'eql_tools_import_export_menu',
			'title' => __('Import/Export','edd'),
			'href'  => admin_url('edit.php?post_type=download&page=edd-tools&tab=import_export'),
			'parent'=> 'eql_tools_menu'
		));	
		//Extensions
		$admin_bar->add_menu( array(
			'id'    => 'eql_extensions_menu',
			'title' => __('Extensions','edd'),
			'href'  => admin_url('edit.php?post_type=download&page=edd-addons'),
			'parent'=> 'eql_quick_links_menu'
		));											
	}
}

// Check if edd is active
function eql_is_edd_active(){
	$active_plugins = (array) get_option( 'active_plugins', array() );
	if ( is_multisite() )
		$active_plugins = array_merge( $active_plugins, get_site_option( 'active_sitewide_plugins', array() ) );
	return in_array( 'easy-digital-downloads/easy-digital-downloads.php', $active_plugins ) || array_key_exists( 'easy-digital-downloads/easy-digital-downloads.php', $active_plugins );
}