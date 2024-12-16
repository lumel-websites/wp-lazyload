<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://github.com/kgkrishnalmt
 * @since      1.0.0
 *
 * @package    WP_Lazyload
 * @subpackage WP_Lazyload/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    WP_Lazyload
 * @subpackage WP_Lazyload/admin
 * @author     K Gopal Krishna <kg@lumel.com>
 */
class Wp_Lazyload_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Wp_Lazyload_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Wp_Lazyload_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/wp-lazyload-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Wp_Lazyload_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Wp_Lazyload_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/wp-lazyload-admin.js', array( 'jquery' ), $this->version, false );

	}
	
    public function lazy_load_settings_init() {
    // Existing section
	add_settings_section("wp_lazyload", "General Settings", null, "wp-lazy-load-settings");

	// Existing button configuration fields
	add_settings_field("button_label", "Button Label", array( $this, "button_label_callback" ), "wp-lazy-load-settings", "wp_lazyload");
	add_settings_field("button_text_color", "Button Text Color", array( $this, "button_text_color_callback" ), "wp-lazy-load-settings", "wp_lazyload");
	add_settings_field("button_bg_color", "Button Background Color", array( $this, "button_bg_color_callback" ), "wp-lazy-load-settings", "wp_lazyload");

	// New fields for extended configuration
	add_settings_field("play_icon", "Play Icon Visibility", array( $this, "play_icon_callback" ), "wp-lazy-load-settings", "wp_lazyload");
	// add_settings_field("loading", "Loading", array( $this, "loading_callback" ), "wp-lazy-load-settings", "wp_lazyload");
	add_settings_field("provider_width", "Provider Width", array( $this, "provider_width_callback" ), "wp-lazy-load-settings", "wp_lazyload");
	add_settings_field("provider_height", "Provider Height", array( $this, "provider_height_callback" ), "wp-lazy-load-settings", "wp_lazyload");
	add_settings_field("mode", "Display Mode", array( $this, "mode_callback" ), "wp-lazy-load-settings", "wp_lazyload");

	// Register new settings
	register_setting( 'wp-lazy-load-settings' , 'button_label');
	register_setting( 'wp-lazy-load-settings' , 'button_text_color');
	register_setting( 'wp-lazy-load-settings' , 'button_bg_color');
	
	// Register extended configuration settings
	register_setting( 'wp-lazy-load-settings' , 'play_icon');
	register_setting( 'wp-lazy-load-settings' , 'loading');
	register_setting( 'wp-lazy-load-settings' , 'provider_width');
	register_setting( 'wp-lazy-load-settings' , 'provider_height');
	register_setting( 'wp-lazy-load-settings' , 'mode');
    }

    public function button_label_callback() {
        $button_label = get_option('button_label', 'View interactive content');
        ?>
        <input 
            type="text" 
            id="button_label" 
            name="button_label" 
            value="<?php echo esc_attr($button_label); ?>" 
            class="regular-text"
        />
        <?php
    }

    public function button_text_color_callback() {
        $button_text_color = get_option('button_text_color', '#3a3a3a');
        ?>
        <input 
            type="color" 
            id="button_text_color" 
            name="button_text_color" 
            value="<?php echo esc_attr($button_text_color); ?>"
        />
        <?php
    }

    public function button_bg_color_callback() {
        $button_bg_color = get_option('button_bg_color', '#ffcd3d');
        ?>
        <input 
            type="color" 
            id="button_bg_color" 
            name="button_bg_color" 
            value="<?php echo esc_attr($button_bg_color); ?>"
        />
        <?php
    }

	public function play_icon_callback() {
        $play_icon = get_option('play_icon', 'show');
        ?>
        <select id="play_icon" name="play_icon">
            <option value="show" <?php selected($play_icon, 'show'); ?>>Show</option>
            <option value="hide" <?php selected($play_icon, 'hide'); ?>>Hide</option>
            <option value="hover" <?php selected($play_icon, 'hover'); ?>>Hover</option>
        </select>
        <p class="description">Configure play icon visibility.</p>
        <?php
    }

    public function loading_callback() {
        $loading = get_option('loading', 'true');
        ?>
        <select id="loading" name="loading">
            <option value="true" <?php selected($loading, 'true'); ?>>Enabled</option>
            <option value="false" <?php selected($loading, 'false'); ?>>Disabled</option>
        </select>
        <p class="description">Enable or disable loading indicator.</p>
        <?php
    }

    public function provider_width_callback() {
        $provider_width = get_option('provider_width', '');
        ?>
        <input 
            type="text" 
            id="provider_width" 
            name="provider_width" 
            value="<?php echo esc_attr($provider_width); ?>" 
            placeholder="e.g., 100%, 500px"
            class="regular-text"
        />
        <p class="description">Set the width of the content provider (e.g., 100%, 500px).</p>
        <?php
    }

    public function provider_height_callback() {
        $provider_height = get_option('provider_height', '');
        ?>
        <input 
            type="text" 
            id="provider_height" 
            name="provider_height" 
            value="<?php echo esc_attr($provider_height); ?>" 
            placeholder="e.g., 100%, 300px"
            class="regular-text"
        />
        <p class="description">Set the height of the content provider (e.g., 100%, 300px).</p>
        <?php
    }

    public function mode_callback() {
        $mode = get_option('mode', 'inline');
        ?>
        <select id="mode" name="mode">
            <option value="inline" <?php selected($mode, 'inline'); ?>>Inline</option>
            <option value="popup" <?php selected($mode, 'popup'); ?>>Popup</option>
        </select>
        <p class="description">Choose how the content will be displayed.</p>
        <?php
    }

    public function lazy_load_settings_page() {
        add_options_page(
            'wp lazy load Settings', 
            'wp lazy load', 
            'administrator', 
            'wp-lazy-load-settings', 
            array( $this, 'lazy_load_settings' ) 
        );
    }

    public function lazy_load_settings() {
        ?>
        <div class="wrap">
            <h1>wp lazy load - Settings</h1>
            <div class="wp-lazy-load-settings">
                <form method="post" action="options.php">
                    <?php
                    settings_fields("wp-lazy-load-settings");
                    do_settings_sections("wp-lazy-load-settings");
                    submit_button();
                    ?>
                </form>
            </div>
        </div>
        <?php
    }
}
