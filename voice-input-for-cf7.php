<?php
/**
* Plugin Name: Voice Input for Contact Form 7
* Description: Voice Input for Contact Form 7 lets users fill out Contact Form 7 forms easily by using their voice,providing powerful voice recognition features.
* Version: 1.0
* Author: Anowar Hossain Rana
* Author URI: https://cxrana.wordpress.com/
* License: GPL-2.0+
* License URI: http://www.gnu.org/licenses/gpl-2.0.txt
* Text Domain: rcf7-voice-input
*/

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


// Enqueue frontend scripts and styles
function rcf7_voice_input_enqueue_scripts() {
    // Enqueue frontend JavaScript file
    wp_enqueue_script('rcf7-voice-input', plugin_dir_url(__FILE__) . 'voice-input.js', array('jquery'), null, true);

    // Load Dashicons
    wp_enqueue_style('dashicons'); // Enqueue WordPress Dashicons

    // Load custom CSS for the frontend
    wp_enqueue_style('rcf7-voice-input-style', plugin_dir_url(__FILE__) . 'style.css'); // Replace 'style.css' with your frontend CSS file if applicable

    // Localize script for passing settings from PHP to JS
    $settings = get_option('rcf7_voice_input_settings');
    wp_localize_script('rcf7-voice-input', 'rcf7VoiceInput', array(
        'language' => isset($settings['language']) ? $settings['language'] : 'en-US',
        'disable' => isset($settings['disable']) ? $settings['disable'] : ''
    ));
}

// Enqueue admin scripts and styles
function rcf7_voice_input_admin_enqueue_scripts() {
    // Enqueue admin-specific JavaScript file
    wp_enqueue_script('rcf7-voice-admin-js', plugin_dir_url(__FILE__) . 'js/admin.js', array('jquery'), null, true);
    
    // Load custom CSS for the admin
    wp_enqueue_style('rcf7-voice-input-admin-style', plugin_dir_url(__FILE__) . 'css/admin-style.css'); // Load custom CSS for admin

    // Localize admin script if needed
    $settings = get_option('rcf7_voice_input_settings');
    wp_localize_script('rcf7-voice-admin-js', 'rcf7VoiceInputAdmin', array(
        'language' => isset($settings['language']) ? $settings['language'] : 'en-US',
        'disable' => isset($settings['disable']) ? $settings['disable'] : ''
    ));
}

// Hook for frontend scripts
add_action('wp_enqueue_scripts', 'rcf7_voice_input_enqueue_scripts');

// Hook for admin scripts
add_action('admin_enqueue_scripts', 'rcf7_voice_input_admin_enqueue_scripts');


// Add voice input class to Contact Form 7 fields
add_filter('wpcf7_form_elements', 'rcf7_add_voice_input_class');
function rcf7_add_voice_input_class($form) {
    // Add class to input text fields
    $form = preg_replace('/(<input.*?class=".*?)(wpcf7-form-control wpcf7-text)(.*?")/i', '$1$2 rcf7-voice-input$3', $form);
    
    // Add class to textarea fields
    $form = preg_replace('/(<textarea.*?class=".*?)(wpcf7-form-control wpcf7-textarea)(.*?")/i', '$1$2 rcf7-voice-input$3', $form);

	    // Add class to email fields
    $form = preg_replace('/(<input.*?class=".*?)(wpcf7-form-control wpcf7-email)(.*?")/i', '$1$2 rcf7-voice-input$3', $form);
	
	// Add class to telephone fields
    $form = preg_replace('/(<input.*?class=".*?)(wpcf7-form-control wpcf7-tel)(.*?")/i', '$1$2 rcf7-voice-input$3', $form);
	
    return $form;
}




// Admin settings page
require_once(plugin_dir_path(__FILE__) . 'admin/admin-settings.php');
