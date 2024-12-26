<?php

/**
 * Plugin Name: WooCommerce Custom Pricing & Delivery Frequency
 * Description: Adds custom fields for Autoship & Save price, One-Time purchase price, and Delivery Frequency dropdown for WooCommerce products.
 * Version: 1.1
 * Author: Saiful Islam Akash
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

// Add custom fields to product edit page
add_action('woocommerce_product_options_pricing', 'add_custom_pricing_fields');
function add_custom_pricing_fields()
{
    // Autoship & Save Price
    woocommerce_wp_text_input(array(
        'id' => '_autoship_price',
        'label' => __('Autoship & Save Price', 'woocommerce'),
        'desc_tip' => true,
        'description' => __('Enter the price for Autoship & Save.', 'woocommerce'),
        'type' => 'text',
    ));

    // One-Time Purchase Price
    woocommerce_wp_text_input(array(
        'id' => '_one_time_price',
        'label' => __('One-Time Purchase Price', 'woocommerce'),
        'desc_tip' => true,
        'description' => __('Enter the price for One-Time Purchase.', 'woocommerce'),
        'type' => 'text',
    ));

    // Delivery Frequency Options
    echo '<div class="options_group">';
    echo '<p class="form-field"><strong>' . __('Delivery Frequency Options', 'woocommerce') . '</strong></p>';
    $frequencies = array(
        '1 Day',
        '2 Day',
        '3 Day',
        'After 1 Week',
        'After 2 Week',
        'After 3 Week',
        'After 1 Month',
        'After 3 Month'
    );

    foreach ($frequencies as $key => $freq) {
        woocommerce_wp_checkbox(array(
            'id' => '_delivery_frequency_' . $key,
            'label' => $freq,
            'description' => __('Enable this delivery frequency option.', 'woocommerce'),
            'value' => 'yes', // default to checked
        ));
    }
    echo '</div>';
}

// Save custom fields when the product is updated
add_action('woocommerce_process_product_meta', 'save_custom_pricing_fields');
function save_custom_pricing_fields($post_id)
{
    // Save Autoship & Save Price
    $autoship_price = isset($_POST['_autoship_price']) ? sanitize_text_field($_POST['_autoship_price']) : '';
    update_post_meta($post_id, '_autoship_price', $autoship_price);

    // Save One-Time Purchase Price
    $one_time_price = isset($_POST['_one_time_price']) ? sanitize_text_field($_POST['_one_time_price']) : '';
    update_post_meta($post_id, '_one_time_price', $one_time_price);

    // Save Delivery Frequency Options
    $frequencies = array(
        '1 Day',
        '2 Day',
        '3 Day',
        'After 1 Week',
        'After 2 Week',
        'After 3 Week',
        'After 1 Month',
        'After 3 Month'
    );

    foreach ($frequencies as $key => $freq) {
        $enabled = isset($_POST['_delivery_frequency_' . $key]) ? 'yes' : 'no';
        update_post_meta($post_id, '_delivery_frequency_' . $key, $enabled);
    }
}

// Display custom pricing and delivery frequency dropdown on product page
add_action('woocommerce_single_product_summary', 'display_custom_pricing_and_frequency', 25);
function display_custom_pricing_and_frequency()
{
    global $product;

    $autoship_price = get_post_meta($product->get_id(), '_autoship_price', true);
    $one_time_price = get_post_meta($product->get_id(), '_one_time_price', true);

    // Delivery Frequencies
    $frequencies = array(
        '1 Day',
        '2 Day',
        '3 Day',
        'After 1 Week',
        'After 2 Week',
        'After 3 Week',
        'After 1 Month',
        'After 3 Month'
    );

    $enabled_frequencies = array();
    foreach ($frequencies as $key => $freq) {
        $is_enabled = get_post_meta($product->get_id(), '_delivery_frequency_' . $key, true);
        if ($is_enabled === 'yes') {
            $enabled_frequencies[] = $freq;
        }
    }

    if ($autoship_price || $one_time_price || !empty($enabled_frequencies)) {
        echo '<div class="custom-prices" style="margin-top: 20px;">';

        if ($autoship_price) {
            echo '<p><strong>Autoship & Save Price:</strong> $' . esc_html($autoship_price) . '</p>';
        }
        if ($one_time_price) {
            echo '<p><strong>One-Time Purchase Price:</strong> $' . esc_html($one_time_price) . '</p>';
        }

        if (!empty($enabled_frequencies)) {
            echo '<p><strong>Delivery Frequency:</strong></p>';
            echo '<select name="delivery_frequency" id="delivery_frequency">';
            foreach ($enabled_frequencies as $freq) {
                echo '<option value="' . esc_attr($freq) . '">' . esc_html($freq) . '</option>';
            }
            echo '</select>';
        }

        echo '</div>';
    }
}
