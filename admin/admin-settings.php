<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

// Add top-level menu page for the plugin
function rcf7_voice_input_add_admin_menu() {
    add_menu_page(
        'Voice Input Settings',   // Page title
        'Voice Input',        		   // Menu title
        'manage_options',              // Capability
        'rcf7-voice-input',            // Menu slug
        'rcf7_voice_input_settings_page', // Callback function
        'dashicons-microphone',        // Icon (optional)
        25                             // Position (optional)
    );
}
add_action('admin_menu', 'rcf7_voice_input_add_admin_menu');

// Register settings
function rcf7_voice_input_settings_init() {
    register_setting('rcf7_voice_input', 'rcf7_voice_input_settings');
    add_settings_section(
        'rcf7_voice_input_section',
        __('General Settings', 'rcf7-voice-input'),
        '',
        'rcf7_voice_input'
    );
    add_settings_field(
        'rcf7_voice_input_language',
        __('Voice Input Language', 'rcf7-voice-input'),
        'rcf7_voice_input_language_render',
        'rcf7_voice_input',
        'rcf7_voice_input_section'
    );
    add_settings_field(
        'rcf7_voice_input_disable',
        __('Disable Microphone', 'rcf7-voice-input'),
        'rcf7_voice_input_disable_render',
        'rcf7_voice_input',
        'rcf7_voice_input_section'
    );
}
add_action('admin_init', 'rcf7_voice_input_settings_init');

// Language input field (with additional languages)
function rcf7_voice_input_language_render() {
    $options = get_option('rcf7_voice_input_settings');
    $selected_language = isset($options['language']) ? $options['language'] : 'en-US';
    ?>
    <div class="rcf7-settings-row">
    <label for="rcf7_voice_input_language" class="rcf7-settings-label"><?php esc_html_e('Select Language:', 'rcf7-voice-input'); ?></label>
    <select name="rcf7_voice_input_settings[language]" id="rcf7_voice_input_language">
    <option value="en-US" <?php selected($selected_language, 'en-US'); ?>>
    <?php echo esc_html(__('English (United States)', 'rcf7-voice-input')); ?>
</option>
<option value="es-ES" <?php selected($selected_language, 'es-ES'); ?>>
    <?php echo esc_html(__('Spanish (Spain)', 'rcf7-voice-input')); ?>
</option>
<option value="fr-FR" <?php selected($selected_language, 'fr-FR'); ?>>
    <?php echo esc_html(__('French (France)', 'rcf7-voice-input')); ?>
</option>
<option value="de-DE" <?php selected($selected_language, 'de-DE'); ?>>
    <?php echo esc_html(__('German (Germany)', 'rcf7-voice-input')); ?>
</option>
<option value="it-IT" <?php selected($selected_language, 'it-IT'); ?>>
    <?php echo esc_html(__('Italian (Italy)', 'rcf7-voice-input')); ?>
</option>
<option value="pt-PT" <?php selected($selected_language, 'pt-PT'); ?>>
    <?php echo esc_html(__('Portuguese (Portugal)', 'rcf7-voice-input')); ?>
</option>
<option value="ar-SA" <?php selected($selected_language, 'ar-SA'); ?>>
    <?php echo esc_html(__('Arabic (KSA, UAE & Others)', 'rcf7-voice-input')); ?>
</option>
<option value="hi-IN" <?php selected($selected_language, 'hi-IN'); ?>>
    <?php echo esc_html(__('Hindi (India)', 'rcf7-voice-input')); ?>
</option>
<option value="bn-BD" <?php selected($selected_language, 'bn-BD'); ?>>
    <?php echo esc_html(__('Bangla (Bangladesh)', 'rcf7-voice-input')); ?>
</option>
<option value="zh-CN" <?php selected($selected_language, 'zh-CN'); ?>>
    <?php echo esc_html(__('Chinese (Simplified)', 'rcf7-voice-input')); ?>
</option>
<option value="ja-JP" <?php selected($selected_language, 'ja-JP'); ?>>
    <?php echo esc_html(__('Japanese (Japan)', 'rcf7-voice-input')); ?>
</option>
<option value="en-GB" <?php selected($selected_language, 'en-GB'); ?>>
    <?php echo esc_html(__('English (United Kingdom)', 'rcf7-voice-input')); ?>
</option>
<option value="ko-KR" <?php selected($selected_language, 'ko-KR'); ?>>
    <?php echo esc_html(__('Korean (South Korea)', 'rcf7-voice-input')); ?>
</option>
<option value="custom" <?php selected($selected_language, 'custom'); ?>>
    <?php echo esc_html(__('Custom', 'rcf7-voice-input')); ?>
</option>

</select>
    </div>
    <div id="custom_language_field" class="rcf7-settings-row" style="display: <?php echo ($selected_language === 'custom') ? 'block' : 'none'; ?>;">
    <input type="text" name="rcf7_voice_input_settings[custom_language]" value="<?php echo esc_attr(isset($options['custom_language']) ? $options['custom_language'] : ''); ?>" placeholder="en-US, bn-BD, etc." class="rcf7-settings-input" />
    <p class="description"><?php echo esc_html(__('Enter the custom language code if "Custom" is selected.', 'rcf7-voice-input')); ?></p>
</div>

    
    <?php
}

// Disable microphone button field
function rcf7_voice_input_disable_render() {
    $options = get_option('rcf7_voice_input_settings');
    $checked = isset($options['disable']) ? $options['disable'] : '';
    ?>
   <div class="rcf7-settings-row">
    <input type="checkbox" name="rcf7_voice_input_settings[disable]" value="1" <?php checked(esc_attr($checked), '1'); ?> class="rcf7-settings-checkbox" />
    <label for="rcf7_voice_input_disable" class="rcf7-settings-label"><?php esc_html_e('Disable Microphone', 'rcf7-voice-input'); ?></label>
</div>
<p class="description"><?php esc_html_e('Check this box to disable the microphone on the form.', 'rcf7-voice-input'); ?></p>

    <?php
}

// Settings page content
function rcf7_voice_input_settings_page() {
    ?>
    <div class="wrap">
        <h1 class="rcf7-settings-title"><?php esc_html_e('Voice Input for Contact Form 7', 'rcf7-voice-input'); ?></h1>
           <!-- Display Settings Saved Message -->
        <?php if (isset($_GET['settings-updated'])): ?>
            <div id="message" class="updated notice is-dismissible">
                <p><?php esc_html_e('Settings Saved', 'rcf7-voice-input'); ?></p>
            </div>
        <?php endif; ?>
		<form action="<?php echo esc_url(admin_url('options.php')); ?>" method="post" class="rcf7-settings-form">
            <?php
            settings_fields('rcf7_voice_input');
            do_settings_sections('rcf7_voice_input');
            submit_button();
            ?>
        </form>
		 <div class="rcf7-footer">
        <div class="rcf7-footer-left">
            <a href="https://facebook.com/cxrana" target="_blank" class="dashicons dashicons-facebook-alt"></a>
            <a href="https://www.linkedin.com/in/ahrana/" target="_blank" class="dashicons dashicons-linkedin"></a>
            <a href="https://cxrana.wordpress.com/" target="_blank" class="dashicons dashicons-wordpress"></a>
        </div>
       <div class="rcf7-footer-right">
    <?php 
    $logo_url = plugins_url('assets/logo.png', __FILE__); 
    ?>
    <img src="<?php echo esc_url($logo_url); ?>" alt="Developer Logo" class="rcf7-footer-logo" />
</div>


    </div>
    </div>

<div>
    <!-- Upgrade Button -->
    <button class="upgrade-btn" id="upgradeBtn">Pro Features</button>

    <!-- Paid Features Section (Initially hidden) -->
    <div class="paid-features-section" id="paidFeaturesSection">
        <!-- Close Button -->
        <button class="close-btn" id="closeBtn">&times;</button>

        <!-- Email Subscription Form -->
        <div id="email_subscribe_form" style="padding: 20px 0; text-align: center;">
            <form action="https://wordpress.us17.list-manage.com/subscribe/post?u=09850da976d016723b7061db4&amp;id=2bf13bc64e&amp;f_id=004c9de0f0" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate" target="_blank">
                <h3>if you want pro version for free,enter your email.</h3>
                <div class="mc-field-group">
                    <input type="email" name="EMAIL" class="required email" id="mce-EMAIL" required="" placeholder="Enter your email">
                </div>
                <div id="mce-responses" class="clear foot">
                    <div class="response" id="mce-error-response" style="display: none;"></div>
                    <div class="response" id="mce-success-response" style="display: none;"></div>
                </div>
                <div class="clear">
                    <input type="submit" value="Subscribe" name="subscribe" id="mc-embedded-subscribe" class="button">
                </div>
            </form>
        </div>

        <!-- List of Paid Features Section with Image on the Right -->
        <div class="section" style="display: flex; align-items: flex-start;">
            <div style="flex: 1;">
                <h3>Pro Features</h3>
                <ul>
                    <li>Save and Resume Form: Easily save your progress and complete the form later.</li>
                    <li>Voice-Activated CAPTCHA: No need for extra plugins, solve CAPTCHA with voice commands. </li>
                    <li>Extended Recording Duration: Increase the voice listening time for longer inputs.</li>
                    <li>Voice Automation: Automatically fill out forms using voice commands..</li>
                </ul>
            </div>
            <div style="flex: 1; text-align: right;">
    <img src="<?php echo esc_url(plugins_url('assets/pro.png', __FILE__)); ?>" alt="<?php esc_attr_e('Pro', 'rcf7-voice-input'); ?>" class="rcf7-ads-logo" />
</div>

        </div>

        <!-- Must Feature Section -->
        <div class="section">
            <h3>Essential Features</h3>
            <ul>
                <li>Enable/Disable Voice Commands: Manage voice commands without disabling the voice input.</li>
                <li>Unlimited Voice Input: Use voice input for all Contact Form 7 fields without restrictions.</li>
                <li>Priority Updates: Get faster access to updates and new features.</li>
            </ul>
        </div>

        <!-- Call to Action Buttons -->
<a href="<?php echo esc_url('#'); ?>" target="_blank" class="cta-btn youtube"><?php esc_html_e('See Video', 'rcf7-voice-input'); ?></a>
<a href="<?php echo esc_url('https://cxrana.wordpress.com/2024/10/06/voice-input-for-contact-form-7/'); ?>" target="_blank" class="cta-btn buy"><?php esc_html_e('Get Pro', 'rcf7-voice-input'); ?></a>

    </div>
</div>


    <?php
}

// Developer footer section
function rcf7_voice_input_footer() {
    ?>
   
	
    <?php
}
add_action('admin_footer', 'rcf7_voice_input_footer');

?>
