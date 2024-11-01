<?php
/*
Plugin Name: WC Checkout Custom Billing Phone Field
Plugin URI: https://github.com/FunkeMakanjuola/WC-Checkout-Custom-Billing-Phone-Field
Description: Plugin will customize WooCommerce checkout phone field
Version: 1.0.2
Author: Funke Makanjuola
Author URI:
License: GNU General Public License v2 or later

WC CHECKOUT CUSTOM BILLING PHONE FIELD
Copyright (C) 2018, https://github.com/FunkeMakanjuola/WC-Checkout-Custom-Billing-Phone-Field
*/
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

add_action( 'wp_enqueue_scripts', 'cbpf_plugin_scripts' );
function cbpf_plugin_scripts()
{
    wp_register_script('maskinput', plugins_url('assets/js/jquery.maskinput.js', __FILE__), array('jquery'), '1.4.1', true);
    wp_enqueue_script('maskinput');
    wp_register_script('maskphone', plugins_url('assets/js/maskphone.js', __FILE__), array('jquery'), '1.0.0', true);
    wp_enqueue_script('maskphone');
}

//Validate  phone number
add_action('woocommerce_checkout_process', 'cbpf_validate_billing_phone_number');
function cbpf_validate_billing_phone_number()
{
    $is_correct = preg_match('/^(\+1[\(]{1}[0-9]{3}[\)]{1}[ |\-]{0,1}|^[0-9]{3}[\-| ])?[0-9]{3}(\-| ){1}[0-9]{4}$/', $_POST['billing_phone']);
    if ($_POST['billing_phone'] && !$is_correct) {
        wc_add_notice(__('Valid phone number format is  +1(xxx) xxx-xxxx'), 'error');
    }
}

//add placeholder
add_filter( 'woocommerce_billing_fields', 'cbpf_phone_placeholder', 10, 1 );
function cbpf_phone_placeholder( $address_fields ) {
    $address_fields['billing_phone']['placeholder'] = '+1(xxx) xxx-xxxx';
    return $address_fields;


}
