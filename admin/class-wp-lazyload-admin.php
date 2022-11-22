<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://https://lumel.com/
 * @since      1.0.0
 *
 * @package    Wp_Lazyload
 * @subpackage Wp_Lazyload/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Wp_Lazyload
 * @subpackage Wp_Lazyload/admin
 * @author     kgkrishnalmt, puneetlumel <info@lumel.com>
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
		wp_enqueue_style( 'select2', 'https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css', array(), '4.0.13', 'all' );
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
		wp_enqueue_script( 'select2', 'https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js', array( 'jquery' ), '4.0.13', true );
		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/wp-lazyload-admin.js', array( 'jquery' ), $this->version, false );
	}



	public function wp_lazyload_settings_init() {

		add_settings_section("wplazyload_settings", "General Settings", null, "wp-lazy-load-settings");
		add_settings_field("wp_lazyload_textcolor", "Button Text Color", array( $this, "wp_lazyload_textcolor_callback" ), "wp-lazy-load-settings", "wplazyload_settings");
		add_settings_field("wp_lazyload_bgcolor", "Button Background Color", array( $this, "wp_lazyload_bgcolor_callback" ), "wp-lazy-load-settings", "wplazyload_settings");
		add_settings_field("wp_lazyload_hover_textcolor", "Button Hover Text Color", array( $this, "wp_lazyload_hover_textcolor_callback" ), "wp-lazy-load-settings", "wplazyload_settings");
		add_settings_field("wp_lazyload_hover_bgcolor", "Button Hover Background Color", array( $this, "wp_lazyload_hover_bgcolor_callback" ), "wp-lazy-load-settings", "wplazyload_settings");
		
		register_setting( 'wp-lazy-load-settings' , 'wp_lazyload_textcolor');
		register_setting( 'wp-lazy-load-settings' , 'wp_lazyload_bgcolor');
		register_setting( 'wp-lazy-load-settings' , 'wp_lazyload_hover_textcolor');
		register_setting( 'wp-lazy-load-settings' , 'wp_lazyload_hover_bgcolor');

	}

	public function wp_lazyload_textcolor_callback() {
		?>
		<input type="text" id="wp_lazyload_textcolor" class="regular-text" name="wp_lazyload_textcolor" value="<?php echo get_option('wp_lazyload_textcolor'); ?>" />
		<?php

	}

	public function wp_lazyload_bgcolor_callback() {
		?>
		<input type="text" id="wp_lazyload_bgcolor" class="regular-text" name="wp_lazyload_bgcolor" value="<?php echo get_option('wp_lazyload_bgcolor'); ?>" />
		<?php

	}

	public function wp_lazyload_hover_textcolor_callback() {
		?>
		<input type="text" id="wp_lazyload_hover_textcolor" class="regular-text" name="wp_lazyload_hover_textcolor" value="<?php echo get_option('wp_lazyload_hover_textcolor'); ?>" />
		<?php

	}

	public function wp_lazyload_hover_bgcolor_callback() {
		?>
		<input type="text" id="wp_lazyload_hover_bgcolor" class="regular-text" name="wp_lazyload_hover_bgcolor" value="<?php echo get_option('wp_lazyload_hover_bgcolor'); ?>" />
		<?php

	}

	public function wp_lazyload_settings_page() {
		add_options_page('Wp LazyLoad Settings', 'WP LazyLoad', 'edit_posts', 'wp-lazy-load-settings', array( $this, 'wp_lazy_load_settings' ) );
	}

	public function wp_lazy_load_settings() { ?>

		<div class="wrap wp_lazyload-settings">
			<h2>
				<span class="main_title" tabindex="1"><?php _e( 'WP LazyLoad for WordPress', 'wp_lazyload' ); ?></span>
			</h2>
			
			<form method="post" action="options.php">
				<?php
					settings_fields("wp-lazy-load-settings");
					do_settings_sections("wp-lazy-load-settings");
					submit_button();
				?>
			</form>
			
			<hr>
			
			<div class="wp_lazyload-shortcode-generator">
				<h2><?php _e( 'Shortcode Generator', 'wp_lazyload' ); ?></h2>
				<p><?php _e( 'The', 'wp_lazyload' ); ?> <strong>[wp_lazyload]</strong> <?php _e( 'Please select the appropriate options from below. Your shortcode will be auto-generated for you which can be added to any web page on your site.', 'wp_lazyload' ); ?></p>
			</div>
			
			<form id="wp_lazyload-shortcode-generator-form">
				<table class="form-table">
					<tbody>
						
						<tr>
							<th scope="row"><?php _e( 'Type', 'wp_lazyload' ); ?></th>
							<td>
								<select id="wp_lazyload-type-selector">
									<option value="video"><?php _e( 'Video', 'wp_lazyload' ); ?></option>
									<option value="iframe"><?php _e( 'Iframe', 'wp_lazyload' ); ?></option>
									<option value="gif"><?php _e( 'GIF', 'wp_lazyload' ); ?></option>
								</select>
							</td>
						</tr>

						<tr>
							<th scope="row"><?php _e( 'Mode', 'wp_lazyload' ); ?></th>
							<td>
								<select id="wp_lazyload-mode-selector">
									<option value="popup"><?php _e( 'Popup', 'wp_lazyload' ); ?></option>
									<option value="inline"><?php _e( 'Inline', 'wp_lazyload' ); ?></option>
								</select>
							</td>
						</tr>
						
						<tr>
							<th scope="row"><?php _e( 'Url', 'wp_lazyload' ); ?></th>
							<td><input type="text" id="wp_lazyload-url" class="regular-text" placeholder="Url"></td>
						</tr>

						<tr>
							<th scope="row"><?php _e( 'Poster', 'wp_lazyload' ); ?></th>
							<td>
							<input id="lazyload_upload_image" type="text" size="36" name="demo_management_form_logo" class="regular-text" placeholder="Poster"> 
							<input id="upload_lazyload_poster" class="button" type="button" value="Upload Poster" />
						</td>
						</tr>
						
						<tr>
							<th scope="row"><?php _e( 'LazyLoad Poster', 'wp_lazyload' ); ?></th>
							<td>
								<select id="wp_lazyload-lazyload-selector">
									<option value="true"><?php _e( 'True', 'wp_lazyload' ); ?></option>
									<option value="false"><?php _e( 'False', 'wp_lazyload' ); ?></option>
								</select>
							</td>
						</tr>
						
						<tr>
							<th scope="row"><?php _e( 'Icon', 'wp_lazyload' ); ?></th>
							<td>
								<select id="wp_lazyload-icon-selector">
									<option value="button"><?php _e( 'Button', 'wp_lazyload' ); ?></option>
									<option value="play"><?php _e( 'Play', 'wp_lazyload' ); ?></option>
									<option value="hidden"><?php _e( 'Hidden', 'wp_lazyload' ); ?></option>
								</select>
							</td>
						</tr>
					</tbody>
				</table>
			</form>
			
			<hr>
			
			<table class="wp_lazyload-shortcode-view form-table">
				<tbody>
					<tr>
						<th scope="row"><?php _e( 'Your Shortcode', 'wp_lazyload' ); ?></th>
						<td>
							<div class="wp_lazyload-shortcode-container">
								<div id="wp_lazyload-shortcode">[wp_lazyload]</div>
							</div>
							<div class="clear"></div>
							<p class="wp_lazyload-shortcode-view-description"><?php _e( 'Copy the above shortcode and then paste it anywhere on the website.', 'wp_lazyload' ); ?></p>
						</td>
					</tr>
				</tbody>
			</table>
		</div>
		<?php
	}

}
