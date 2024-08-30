<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://https://lumel.com/
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
 * @author     kgkrishnalmt, puneetlumel <info@lumel.com>
 */
class Wp_Lazyload_Public {

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
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
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

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/wp-lazyload-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
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

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/wp-lazyload-public.js', array( 'jquery' ), $this->version, false );

	}

	public function add_lazy_load_shortcode() { 
		add_shortcode( 'wp_lazyload' , array( $this , 'wp_lazyload_shortcode_callback' ) );
	}


	/**
	 * Lazy load shortcode callback
	 *
	 * @since    1.0.0
	 */
	public function wp_lazyload_shortcode_callback( $atts ) { 

		$atts = shortcode_atts(
			array(
				'type' => '',
				'mode' => 'inline',
				'provider' => '',
				'url' => '',
				'poster' => '',
				'poster_lazy_loading' => 'true',
				'play_icon' => '',
				'icon' => 'button',
				'provider_width' => '100%',
				'provider_height' => '100%',
	        ) , 
	     	$atts , 
	     	'wp_lazyload' 
	    );

		$pageid = get_the_ID();
		$type 		= $atts[ 'type' ];	
		$mode 		= $atts[ 'mode' ];	
		$provider 	= $atts[ 'provider' ];
		$url 		= $atts[ 'url' ];
		$poster 	= $atts[ 'poster' ];
		$loading	= $atts[ 'poster_lazy_loading' ];
		$pagetitle	= get_the_title($pageid);
		$icon	= $atts[ 'icon' ];
		$play_icon	= $atts[ 'play_icon' ];
		$provider_width	= $atts[ 'provider_width' ];
		$provider_height	= $atts[ 'provider_height' ];
		
		
		if( $url == "" ) {
			$output = '<p style="color:red;">[url] - Video/iframe/gif URL is a required parameter';
			return $output;
		}

		if($type == "video" && $provider == "youtube" && $poster == "" ) {
			$video_code = explode( "=", $url )[1];
			$poster = "https://i.ytimg.com/vi/$video_code/maxresdefault.jpg";
		}

		if($type == "video" && $provider == "wistia" && $poster == "" ) {
			$response = wp_remote_get( "https://fast.wistia.net/oembed?url=$url&&embedType=async" );
			$response = json_decode( $response[ 'body' ], true );
			$poster = $response[ 'thumbnail_url' ];
		}

		if($type == "video" && $provider == "vimeo" && $poster == "" ) {
			$video_code = explode( "/", $url )[3];
			$poster = "https://vumbnail.com/$video_code.jpg";
		}

		if( $type == "gif" && $poster == "" ) {
			$poster = $url;
		}

		if($poster=="") {
			$output = '<p style="color:red;">[poster] - Poster is a required parameter';
			return $output;
		}
		
		$wp_lazyload_textcolor = get_option('wp_lazyload_textcolor');
		$wp_lazyload_bgcolor = get_option('wp_lazyload_bgcolor');
		$wp_lazyload_hover_textcolor = get_option('wp_lazyload_hover_textcolor');
		$wp_lazyload_hover_bgcolor = get_option('wp_lazyload_hover_bgcolor');

		ob_start();
		$dimentions = '';
		if($wp_lazyload_textcolor!="" && $wp_lazyload_bgcolor!="") {
		?>
		<style>
		.lazy-iframe-button {
			color: <?php echo $wp_lazyload_textcolor ?>;
			background: <?php echo $wp_lazyload_bgcolor ?>;
		}
		</style>
		<?php } if($wp_lazyload_hover_textcolor!="" && $wp_lazyload_hover_bgcolor!="") { ?>
		<style>
		.lazy-iframe-button:hover {
			color: <?php echo $wp_lazyload_hover_textcolor ?>;
			background: <?php echo $wp_lazyload_hover_bgcolor ?>;
		}
		</style>
		<?php
		}
		if(!empty($provider_width) && !empty($provider_height)) { 
		$dimentions = "width=".$provider_width. " height=".$provider_height;
		?>
		<style>
			.lazy-video-container {
				width: <?php echo $provider_width; ?>;
				height: <?php echo $provider_height; ?>;
			}
		</style>
		<?php } else if(!empty($provider_width)) { 
		$dimentions = "width=".$provider_width;
		?>
		<style>
			.lazy-video-container {
				width: <?php echo $provider_width; ?>;
			}
		</style>	
		<?php } else if(!empty($provider_height)) { 
		$dimentions = "height=".$provider_height;
		?>
		<style>
			.lazy-video-container {
				height: <?php echo $provider_height; ?>;
			}
		</style>
		<?php } else { ?>
		<style>
			.lazy-video-container {
				width: 100%;
				height: 100%;
			}
		</style>
		<?php } ?>	
		<div class="lazy-video-container <?php if($type=="gif") { echo "video-grid-layout"; } ?>" data-mode="<?php echo $mode; ?>" data-type="<?php echo $type; ?>" data-provider="<?php echo $provider; ?>" data-url="<?php echo $url; ?>" <?php if( $type == "gif") { ?> data-title="<?php echo $pagetitle; ?>" <?php } ?>>
			<div class="lazy-video-box">
				<div class="lazy-video-wrapper" style="padding-top:56.2963%"></div>
			</div>
			<div class="lazy-overlay <?php if( $type == "gif") {  echo "gif-image";  } ?>">
				<img class="lazy-overlay-image" alt="<?php echo $pagetitle; ?>" src="<?php echo $poster; ?>" <?php echo $dimentions; ?> <?php echo ( $loading == "true" ) ? 'loading="lazy"' : '';  ?> />
				<?php if($icon=="play") { ?>
					<div class="lazy-overlay-hover <?php if($play_icon=="hide") { echo "icon-hide"; } ?> <?php if($play_icon=="hover") { echo "icon-hover"; } ?>"></div>	
					<div class="lazy-play-icon <?php if($play_icon=="hide") { echo "icon-hide"; } ?> <?php if($play_icon=="hover") { echo "icon-hover"; } ?>"></div>
				<?php } ?>

				<?php if($icon=="button") { ?><div class="lazy-iframe-button"><?php echo "View interactive content"; ?></div><?php } ?>
			</div>	
		</div>
		<?php
		$output = ob_get_clean();
		return $output;
	}
}
