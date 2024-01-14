<?php
/**
 * Plugin Name: WP Tinylytics
 * Description: A custom plugin for embedding Tinylytics script.
 * Version: 1.0.0
 * Author: Jim Mitchell
 */

 if (!defined('ABSPATH')) die();

 // Hook functions into WordPress
add_action('admin_init', 'wp_tinylytics_register_settings');
add_action('admin_menu', 'wp_tinylytics_add_menu_page');

// Register the settings
function wp_tinylytics_register_settings() {

    register_setting('wp_tinylytics_settings_group', 'wp_tinylytics_settings', 'wp_tinylytics_sanitize_options');
    
    add_settings_section('wp_tinylytics_general_section', 'General Settings', 'wp_tinylytics_general_section_callback', 'wp-tinylytics');
    add_settings_section('wp_tinylytics_options_section', 'Tinylytics Options', 'wp_tinylytics_options_section_callback', 'wp-tinylytics');
    
    add_settings_field('site_id', 'Site ID', 'wp_tinylytics_site_id_callback', 'wp-tinylytics', 'wp_tinylytics_general_section');
    add_settings_field('display_hits', 'Display hits?', 'wp_tinylytics_display_hits_callback', 'wp-tinylytics', 'wp_tinylytics_options_section');
    add_settings_field('display_stats', 'Link to your public stats?', 'wp_tinylytics_display_stats_callback', 'wp-tinylytics', 'wp_tinylytics_options_section');
    add_settings_field('display_uptime', 'Display uptime?', 'wp_tinylytics_display_uptime_callback', 'wp-tinylytics', 'wp_tinylytics_options_section');
    add_settings_field('display_kudos', 'Display Kudos?', 'wp_tinylytics_display_kudos_callback', 'wp-tinylytics', 'wp_tinylytics_options_section');
    add_settings_field('kudos_label', 'Kudos label', 'wp_tinylytics_kudos_label_callback', 'wp-tinylytics', 'wp_tinylytics_options_section');
    add_settings_field('display_webring', 'Display webring?', 'wp_tinylytics_display_webring_callback', 'wp-tinylytics', 'wp_tinylytics_options_section');
    add_settings_field('webring_label', 'Webring label', 'wp_tinylytics_webring_label_callback', 'wp-tinylytics', 'wp_tinylytics_options_section');
    add_settings_field('display_avatars', 'Display webring avatars?', 'wp_tinylytics_display_avatars_callback', 'wp-tinylytics', 'wp_tinylytics_options_section');
    add_settings_field('display_flags', 'Display country flags?', 'wp_tinylytics_display_flags_callback', 'wp-tinylytics', 'wp_tinylytics_options_section');

}

// Sanitize options
function wp_tinylytics_sanitize_options($input) {

    $sanitized_input = array();

    if (isset($input['site_id'])) {
        $sanitized_input['site_id'] = sanitize_text_field($input['site_id']);
    }
    if (isset($input['kudos_label'])) {
        $sanitized_input['kudos_label'] = sanitize_text_field($input['kudos_label']);
    }
    if (isset($input['webring_label'])) {
        $sanitized_input['webring_label'] = sanitize_text_field($input['webring_label']);
    }

    $sanitized_input['display_hits'] = isset($input['display_hits']) ? true : false;
    $sanitized_input['display_stats'] = isset($input['display_stats']) ? true : false;
    $sanitized_input['display_uptime'] = isset($input['display_uptime']) ? true : false;
    $sanitized_input['display_kudos'] = isset($input['display_kudos']) ? true : false;
    $sanitized_input['display_webring'] = isset($input['display_webring']) ? true : false;
    $sanitized_input['display_avatars'] = isset($input['display_avatars']) ? true : false;
    $sanitized_input['display_flags'] = isset($input['display_flags']) ? true : false;

    return $sanitized_input;

}

// Section callbacks
function wp_tinylytics_general_section_callback() {
    echo '<p class="section-note">Your unique site id can be found on the <a href="https://tinylytics.app" target="_blank">Tinylytics</a> site page.</p>';
}

function wp_tinylytics_options_section_callback() {
    echo '<p class="section-note">These settings enable the various tracking features of <a href="https://tinylytics.app" target="_blank">Tinylytics</a>.</p>';
}

// Site ID callback
function wp_tinylytics_site_id_callback() {
    $options = get_option('wp_tinylytics_settings');
    echo '<input type="text" id="site_id" size="40" name="wp_tinylytics_settings[site_id]" placeholder="Enter your Tinylytics unique site id..." value="' . esc_attr($options['site_id'] ?? '') . '" />';
}

// Kudos label callback
function wp_tinylytics_kudos_label_callback() {
    $options = get_option('wp_tinylytics_settings');
    echo '<input type="text" id="kudos_label" size="40" name="wp_tinylytics_settings[kudos_label]" placeholder="Enter any combination of text or emoji 👋" value="' . esc_attr($options['kudos_label'] ?? '') . '" />';
}

// Webring label callback
function wp_tinylytics_webring_label_callback() {
    $options = get_option('wp_tinylytics_settings');
    echo '<input type="text" id="webring_label" size="40" name="wp_tinylytics_settings[webring_label]" placeholder="Enter any combination of text or emoji 🕸️💍" value="' . esc_attr($options['webring_label'] ?? '') . '" />';
}

// Display Hits callback
function wp_tinylytics_display_hits_callback() {
    $options = get_option('wp_tinylytics_settings');
    echo '<input type="checkbox" id="display_hits" name="wp_tinylytics_settings[display_hits]" ' . checked(true, $options['display_hits'] ?? false, false) . ' />';
}

// Display Stats callback
function wp_tinylytics_display_stats_callback() {
    $options = get_option('wp_tinylytics_settings');
    echo '<input type="checkbox" id="display_stats" name="wp_tinylytics_settings[display_stats]" ' . checked(true, $options['display_stats'] ?? false, false) . ' />';
}

// Display Uptime callback
function wp_tinylytics_display_uptime_callback() {
    $options = get_option('wp_tinylytics_settings');
    echo '<input type="checkbox" id="display_uptime" name="wp_tinylytics_settings[display_uptime]" ' . checked(true, $options['display_uptime'] ?? false, false) . ' />';
}

// Display Kudos callback
function wp_tinylytics_display_kudos_callback() {
    $options = get_option('wp_tinylytics_settings');
    echo '<input type="checkbox" id="display_kudos" name="wp_tinylytics_settings[display_kudos]" ' . checked(true, $options['display_kudos'] ?? false, false) . ' />';
}

// Display Webring callback
function wp_tinylytics_display_webring_callback() {
    $options = get_option('wp_tinylytics_settings');
    echo '<input type="checkbox" id="display_webring" name="wp_tinylytics_settings[display_webring]" ' . checked(true, $options['display_webring'] ?? false, false) . ' />';
}

// Display Avatars callback
function wp_tinylytics_display_avatars_callback() {
    $options = get_option('wp_tinylytics_settings');
    echo '<input type="checkbox" id="display_avatars" name="wp_tinylytics_settings[display_avatars]" ' . checked(true, $options['display_avatars'] ?? false, false) . ' />';
}

// Display Flags callback
function wp_tinylytics_display_flags_callback() {
    $options = get_option('wp_tinylytics_settings');
    echo '<input type="checkbox" id="display_flags" name="wp_tinylytics_settings[display_flags]" ' . checked(true, $options['display_flags'] ?? false, false) . ' />';
}

// Add menu page with custom icon
function wp_tinylytics_add_menu_page() {
    
    add_menu_page('WP Tinylytics', 'WP Tinylytics', 'manage_options', 'wp-tinylytics', 'wp_tinylytics_settings_page', 'dashicons-chart-bar');

}

// Settings page callback
function wp_tinylytics_settings_page() {
    if ( ! current_user_can( 'manage_options' ) ) {
        return;
    }
    if ( isset( $_GET['settings-updated'] ) ) {
		// add settings saved message with the class of "updated"
		add_settings_error( 'tinylytics_messages', 'tinylytics_message', __( 'Settings Saved', 'wp-tinylytics' ), 'updated' );
	}
    settings_errors( 'tinylytics_messages' );

    $default_tab = null;
    $tab = isset($_GET['tab']) ? $_GET['tab'] : $default_tab;
    ?>
    <div class="wrap">
        <h1><?php echo esc_html( get_admin_page_title() ); ?></h1>

        <nav class="nav-tab-wrapper">
            <a href="?page=wp-tinylytics" class="nav-tab <?php if($tab===null):?>nav-tab-active<?php endif; ?>">Settings</a>
            <a href="?page=wp-tinylytics&tab=shortcode" class="nav-tab <?php if($tab==='shortcode'):?>nav-tab-active<?php endif; ?>">Shortcodes</a>
            <a href="?page=wp-tinylytics&tab=support" class="nav-tab <?php if($tab==='support'):?>nav-tab-active<?php endif; ?>">Make a Donation</a>
        </nav>

        <div class="tab-content">
        <?php switch($tab) :
            case 'shortcode':
                include plugin_dir_path( __FILE__ ) . '/inc/admin-shortcodes.php';
                break;
            case 'support':
                include plugin_dir_path( __FILE__ ) . '/inc/admin-support.php';
                break;
            default:
                include plugin_dir_path( __FILE__ ) . '/inc/admin-settings.php';
                break;
        endswitch; ?>
        </div>
    </div>
    <?php
}


function wp_tinylytics_output_script() {

    $options = get_option('wp_tinylytics_settings');

    $site_id = esc_attr($options['site_id'] ?? '');
    $hits = $options['display_hits'];
    $stats = $options['display_stats'];
    $uptime = $options['display_uptime'];
    $kudos = $options['display_kudos'];
    $kudos_label = esc_attr($options['kudos_label'] ?? '');
    $webring = $options['display_webring'];
    $webring_label = esc_attr($options['webring_label'] ?? '');
    $avatars = $options['display_avatars'];
	$flags = $options['display_flags'];
	
    if (!empty($site_id)) {
        $script_url = "https://tinylytics.app/embed/{$site_id}.js?";
        $script_url .= $hits ? 'hits&' : '';
        $script_url .= $stats ? 'publicstats&' : '';
        $script_url .= $uptime ? 'uptime&' : '';
        $script_url .= $kudos && !$kudos_label ? 'kudos&' : '';
        $script_url .= $kudos && $kudos_label ? 'kudos=' . $kudos_label . '&' : '';
        $script_url .= $webring && !$avatars ? 'webring&' : '';
        $script_url .= $webring && $avatars ? 'webring=avatars&' : '';
        $script_url .= $flags ? 'countries&' : '';
        $script_url = rtrim($script_url, '&?');
        
        echo '<script defer="defer" src="' . esc_url($script_url) . '"></script>' . PHP_EOL;
    }

}
add_action('wp_footer', 'wp_tinylytics_output_script');

// *** Enqueue user scripts
function wp_tinylytics_user_scripts() {
	$plugin_url = plugin_dir_url( __FILE__ );
	wp_enqueue_style( 'style',  $plugin_url . "/css/style.css");
}
add_action( 'admin_print_styles', 'wp_tinylytics_user_scripts' );

// *** Wordpress shortcodes to use in posts and pages
include plugin_dir_path( __FILE__ ) . '/inc/shortcodes.php';