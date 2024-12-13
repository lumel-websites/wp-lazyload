<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://https://github.com/kgkrishnalmt
 * @since      1.0.0
 *
 * @package    Wp_Lazyload
 * @subpackage Wp_Lazyload/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Wp_Lazyload
 * @subpackage Wp_Lazyload/public
 * @author     K Gopal Krishna <kg@lumel.com>
 */
class Wp_Lazyload_Public
{

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
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct($plugin_name, $version)
	{

		$this->plugin_name = $plugin_name;
		$this->version = $version;
	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles()
	{

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

		wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/wp-lazyload-public.css', array(), $this->version, 'all');
	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts()
	{

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

		wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__) . 'js/wp-lazyload-public.js', array('jquery'), $this->version, false);
	}

	/**
	 * Common wp lazy loading Shortcode Definition
	 *
	 * @since 1.0.0
	 */
	public function add_lazy_load_shortcode()
	{
		add_shortcode('lazy_load', array($this, 'lazy_loading_shortcode_callback'));
	}

	/**
	 * Common wp lazy loading Shortcode Callback
	 *
	 * @since 1.0.0
	 */
	public function lazy_loading_shortcode_callback($atts)
	{

    // Merge shortcode attributes with global settings
    $atts = shortcode_atts(
        array(
            'mode' => get_option('mode', 'inline'),
            'provider' => 'youtube',
            'url' => '',
            'poster' => '',
            'lazy_loading' => get_option('loading', 'true'),
            'play_icon' => get_option('play_icon', 'show'),
            'provider_width' => get_option('provider_width', ''),
            'provider_height' => get_option('provider_height', ''),
            'type' => 'video',
            'button' => 'show',
            'button_label' => get_option('button_label', 'View interactive content'),
            'button_text_color' => get_option('button_text_color', '#3a3a3a'),
            'button_bg_color' => get_option('button_bg_color', '#ffcd3d'),
        ),
        $atts,
        'wp_lazyload'
    );

    // Extract attributes
    $mode = $atts['mode'];
    $provider = $atts['provider'];
    $url = $atts['url'];
    $type = $atts['type'];
    $poster = $atts['poster'];
    $loading = $atts['lazy_loading'];
    $play_icon = $atts['play_icon'];
    $provider_width = $atts['provider_width'];
    $provider_height = $atts['provider_height'];
    $button = $atts['button'];
    $button_label = $atts['button_label'];
    $button_text_color = $atts['button_text_color'];
    $button_bg_color = $atts['button_bg_color'];

    $pageid = get_the_ID();
    $pagetitle = get_the_title($pageid);

		if ($url == "") {
			$output = '<p style="color:red;">[url] - Video URL is a required parameter';
			return $output;
		}
	
		if ($provider == "gif") {
			if ($poster == "") {
				$output = '<p style="color:red;">[poster] - Poster image is a required parameter';
				return $output;
			}
		}
	
		if ($provider == "youtube" && $poster == "") {
			$video_code = explode("=", $url)[1];
			$poster = "https://i.ytimg.com/vi/$video_code/maxresdefault.jpg";
		}
	
		if ($provider == "wistia" && $poster == "") {
			$response = wp_remote_get("https://fast.wistia.net/oembed?url=$url&&embedType=async");
			$response = json_decode($response['body'], true);
			$poster = $response['thumbnail_url'];
		}
	
		if ($provider == "vimeo" && $poster == "") {
			$video_code = explode("/", $url)[3];
			$poster = "https://vumbnail.com/$video_code.jpg";
		}
	
		if ($provider == "gif" && $poster != "") {
			$gif_code = $url;
			$poster = $atts['poster'];
		}
	
		ob_start();
		$dimentions = '';
	
		if ($button_text_color) { ?>
			<style>
				.lazy-iframe-overlay .lazy-iframe-button {
					color: <?php echo $button_text_color; ?>
				}
			</style>
		<?php }
	
		if ($button_bg_color) { ?>
			<style>
				.lazy-iframe-overlay .lazy-iframe-button {
					background: <?php echo $button_bg_color; ?>
				}
			</style>
		<?php }
	
		if (!empty($provider_width) && !empty($provider_height)) {
			$dimentions = "width=" . $provider_width . " height=" . $provider_height; ?>
			<style>
				.lazy-video-container {
					width: <?php echo $provider_width; ?>;
					height: <?php echo $provider_height; ?>;
				}
			</style>
		<?php } else if (!empty($provider_width)) {
			$dimentions = "width=" . $provider_width; ?>
			<style>
				.lazy-video-container {
					width: <?php echo $provider_width; ?>;
				}
			</style>
		<?php } else if (!empty($provider_height)) {
			$dimentions = "height=" . $provider_height; ?>
			<style>
				.lazy-video-container {
					height: <?php echo $provider_height; ?>;
				}
			</style>
		<?php } ?>
	
		<?php if ($type == "video") : ?>
			<div class="lazy-video-container 
				<?php if ($provider == "gif") {
					echo "video-grid-layout";
				} ?>"
				data-mode="<?php echo $mode; ?>"
				data-provider="<?php echo $provider; ?>"
				data-url="<?php echo $url; ?>"
				<?php if ($provider == "gif") : ?>
				data-title="<?php echo $pagetitle; ?>"
				<?php endif; ?>>
	
				<div class="lazy-video-box">
					<div class="lazy-video-wrapper" style="padding-top:56.2963%"></div>
				</div>
	
				<div class="lazy-overlay 
					<?php if ($provider == "gif") {
						echo "gif-image";
					} ?>">
	
					<img class="lazy-overlay-image"
						alt="<?php echo $pagetitle; ?>"
						src="<?php echo $poster; ?>"
						<?php echo $dimentions; ?>
						<?php echo ($loading == "true") ? 'loading="lazy"' : ''; ?> />
	
					<div class="lazy-overlay-hover 
						<?php if ($play_icon == "hide") {
							echo "icon-hide";
						} ?>
						<?php if ($play_icon == "hover") {
							echo "icon-hover";
						} ?>">
					</div>
	
					<div class="lazy-play-icon 
						<?php if ($play_icon == "hide") {
							echo "icon-hide";
						} ?>
						<?php if ($play_icon == "hover") {
							echo "icon-hover";
						} ?>">
					</div>
	
				</div>
			</div>
		<?php elseif ($type == "iframe") : ?>
			<div class="lazy-iframe-container" data-url="<?php echo $url; ?>">
				<div class="lazy-iframe-box">
					<div class="lazy-iframe-wrapper" style="padding-top:56.2963%"></div>
				</div>
				<div class="lazy-iframe-overlay">
					<img class="lazy-iframe-overlay-image"
						src="<?php echo $poster; ?>"
						width="100%"
						<?php echo ($loading == "true") ? 'loading="lazy"' : ''; ?> />
	
					<?php if ($button == "show") : ?>
						<div class="lazy-iframe-button"
						style="color: <?php echo $button_text_color; ?>;background-color: <?php echo $button_bg_color; ?>;">
						<?php echo $button_label; ?></div>
					<?php endif; ?>
				</div>
			</div>
		<?php endif; ?>
		
		<?php
		$output = ob_get_clean();
		return $output;

	}
}
