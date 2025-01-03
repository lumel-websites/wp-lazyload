<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://github.com/lumel-websites
 * @since      1.0.0
 *
 * @package    WP_Lazyload
 * @subpackage WP_Lazyload/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    WP_Lazyload
 * @subpackage WP_Lazyload/public
 * @author     Lumel Technologies <webmasters@lumel.com>
 */
class WP_Lazyload_Public
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
		wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/wp-lazyload-public.css', array(), $this->version, 'all');
	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts()
	{
		wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__) . 'js/wp-lazyload-public.js', array('jquery'), $this->version, false);
	}

	/**
	 * Common wp lazy loading Shortcode Definition
	 *
	 * @since 1.0.0
	 */
	public function add_wp_lazyload_shortcode()
	{
		add_shortcode('wp_lazyload', array($this, 'wp_lazy_loading_shortcode_callback'));
	}

	/**
	 * Common wp lazy loading Shortcode Callback
	 *
	 * @since 1.0.0
	 */
	public function wp_lazy_loading_shortcode_callback($atts)
	{
		$defaults = [
			'mode' => get_option('mode', 'inline'),
			'provider' => 'youtube',
			'url' => '',
			'poster' => '',
			'lazy_loading' => 'true',
			'play_icon' => get_option('play_icon', 'show'),
			'provider_width' => get_option('provider_width', ''),
			'provider_height' => get_option('provider_height', ''),
			'type' => 'video',
			'button' => 'show',
			'button_label' => get_option('button_label', 'View interactive content'),
			'button_text_color' => get_option('button_text_color', '#3a3a3a'),
			'button_bg_color' => get_option('button_bg_color', '#ffcd3d'),
		];

		$atts = shortcode_atts($defaults, $atts, 'wp_lazyload');

		if (empty($atts['url'])) {
			return '<p style="color:red;">[url] - Video URL is a required parameter</p>';
		}

		if ($atts['type'] === 'iframe' && empty($atts['poster'])) {
			return '<p style="color:red;">[poster] - Poster image is a required parameter for iframe type</p>';
		}

		if ($atts['type'] === 'video' && empty($atts['poster'])) {
			$atts['poster'] = $this->generate_poster($atts['provider'], $atts['url']);
		}

		ob_start();
		$dimensions = $this->generate_dimensions_styles($atts['provider_width'], $atts['provider_height']);

		switch ($atts['type']) {
			case 'gif':
				echo $this->render_lazy_gif_container($atts, $dimensions);
				break;
			case 'video':
				echo $this->render_lazy_video_container($atts, $dimensions);
				break;
			case 'iframe':
				echo $this->render_lazy_iframe_container($atts);
				break;
		}

		return ob_get_clean();
	}

	private function generate_dimensions_styles($width, $height)
	{
		$styles = '';

		if ($width) {
			$styles .= "width: {$width};";
		}

		if ($height) {
			$styles .= "height: {$height};";
		}

		return $styles ? "style='{$styles}'" : '';
	}

	private function generate_poster($provider, $url)
	{
		switch ($provider) {
			case 'youtube':
				$parsed_url = parse_url($url);
				$video_code = '';
				if (isset($parsed_url['host']) && $parsed_url['host'] === 'youtu.be') {
					$video_code = ltrim($parsed_url['path'], '/');
				} else {
					parse_str($parsed_url['query'] ?? '', $query_params);
					$video_code = $query_params['v'] ?? '';
				}
				return "https://i.ytimg.com/vi/{$video_code}/maxresdefault.jpg";

			case 'wistia':
				$response = wp_remote_get("https://fast.wistia.net/oembed?url={$url}&embedType=async");
				$response_body = json_decode(wp_remote_retrieve_body($response), true);
				return $response_body['thumbnail_url'] ?? '';

			case 'vimeo':
				$video_code = explode('/', $url)[3];
				return "https://vumbnail.com/{$video_code}.jpg";

			default:
				return '';
		}
	}

	private function render_lazy_video_container($atts, $dimensions)
	{
		return "
            <div class='wp-lazy-video-container " . ($atts['provider'] === 'gif' ? 'video-grid-layout' : '') . "'
                data-mode='{$atts['mode']}'
                data-provider='{$atts['provider']}'
                data-url='{$atts['url']}'
                data-title='{$atts['title']}'
                {$dimensions}>
                <div class='wp-lazy-video-box'>
                    <div class='wp-lazy-video-wrapper' style='padding-top:56.2963%;'></div>
                </div>
                <div class='wp-lazy-overlay " . ($atts['provider'] === 'gif' ? 'gif-image' : '') . "'>
                    <img class='wp-lazy-overlay-image' 
                        width='100%'
                        alt='{$atts['title']}' 
                        src='{$atts['poster']}' 
                        " . (!empty($atts['lazy_loading']) ? 'loading="lazy"' : '') . ">
                    <div class='wp-lazy-overlay-hover " .
			($atts['play_icon'] === 'hide' ? 'icon-hide' : ($atts['play_icon'] === 'hover' ? 'icon-hover' : '')) . "'></div>
                    <div class='wp-lazy-play-icon " .
			($atts['play_icon'] === 'hide' ? 'icon-hide' : ($atts['play_icon'] === 'hover' ? 'icon-hover' : '')) . "'></div>
                </div>
            </div>";
	}

	private function render_lazy_iframe_container($atts)
	{
		$button_html = $atts['button'] === 'show' ? "
            <div class='wp-lazy-iframe-button' 
                style='color: {$atts['button_text_color']}; background-color: {$atts['button_bg_color']};'>
                {$atts['button_label']}
            </div>" : '';

		return "
            <div class='wp-lazy-iframe-container' data-url='{$atts['url']}' data-mode='{$atts['mode']}'>
                <div class='wp-lazy-iframe-box'>
                    <div class='wp-lazy-iframe-wrapper' style='padding-top:56.2963%'></div>
                </div>
                <div class='wp-lazy-iframe-overlay'>
                    <img class='wp-lazy-iframe-overlay-image'
                        src='{$atts['poster']}'
                        alt='iframe preview'
                        " . (!empty($atts['lazy_loading']) ? 'loading="lazy"' : '') . ">
                    {$button_html}
                </div>
            </div>";
	}

	private function render_lazy_gif_container($atts, $dimensions)
	{
		return "
            <div class='wp-lazy-gif-container' 
                data-url='{$atts['url']}' 
                data-mode='{$atts['mode']}' 
                data-title='{$atts['title']}' 
                {$dimensions}>
                <div class='wp-lazy-gif-box'>
                    <div class='wp-lazy-gif-wrapper'>
                        <img class='wp-lazy-gif-poster' src='{$atts['poster']}' alt='{$atts['title']}' loading='lazy'>
                    </div>
                </div>
                <div class='wp-lazy-gif-overlay'>
                    <span class='gif-label'>GIF</span>
                </div>
            </div>";
	}
}
