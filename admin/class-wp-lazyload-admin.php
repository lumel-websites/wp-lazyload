<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://github.com/lumel-websites
 * @since      1.0.0
 *
 * @package    WP_Lazyload
 * @subpackage WP_Lazyload/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and admin settings including shortcode generator.
 *
 * @package    WP_Lazyload
 * @subpackage WP_Lazyload/admin
 * @author     Lumel Technologies <webmasters@lumel.com>
 */
class WP_Lazyload_Admin
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
     * @param string $plugin_name The name of this plugin.
     * @param string $version     The version of this plugin.
     */
    public function __construct($plugin_name, $version)
    {
        $this->plugin_name = $plugin_name;
        $this->version     = $version;
    }

    /**
     * Register the stylesheets for the admin area.
     *
     * @since    1.0.0
     */
    public function enqueue_styles()
    {
        wp_enqueue_style(
            $this->plugin_name,
            plugin_dir_url(__FILE__) . 'css/wp-lazyload-admin.css',
            array(),
            $this->version,
            'all'
        );
    }

    /**
     * Register the JavaScript for the admin area.
     *
     * @since    1.0.0
     */
    public function enqueue_scripts()
    {
        wp_enqueue_script(
            'select2',
            'https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js',
            array('jquery'),
            '4.0.13',
            true
        );
        wp_enqueue_script(
            'jquery-validate',
            'https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js',
            array('jquery'),
            '1.19.3',
            true
        );
        wp_enqueue_script(
            'jquery-validate-methods',
            'https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/additional-methods.min.js',
            array('jquery', 'jquery-validate'),
            '1.19.3',
            true
        );
        wp_enqueue_media();
        wp_enqueue_script(
            $this->plugin_name,
            plugin_dir_url(__FILE__) . 'js/wp-lazyload-admin.js',
            array('jquery', 'media-editor', 'select2','wp-color-picker'), // Specify 'media-editor' as a dependency
            $this->version,
            true
        );
        wp_enqueue_style('wp-color-picker'); // Add the color picker stylesheet

    }

    /**
     * Initialize lazy load settings.
     */
    public function lazy_load_settings_init()
    {
        add_settings_section('wp_lazyload', 'General Settings', null, 'wp-lazy-load-settings');

        add_settings_field(
            'button_label',
            'Button Label',
            array($this, 'button_label_callback'),
            'wp-lazy-load-settings',
            'wp_lazyload'
        );
        add_settings_field(
            'button_text_color',
            'Button Text Color',
            array($this, 'button_text_color_callback'),
            'wp-lazy-load-settings',
            'wp_lazyload'
        );
        add_settings_field(
            'button_bg_color',
            'Button Background Color',
            array($this, 'button_bg_color_callback'),
            'wp-lazy-load-settings',
            'wp_lazyload'
        );
        add_settings_field(
            'play_icon',
            'Play Icon Visibility',
            array($this, 'play_icon_callback'),
            'wp-lazy-load-settings',
            'wp_lazyload'
        );
        add_settings_field(
            'provider_width',
            'Provider Width',
            array($this, 'provider_width_callback'),
            'wp-lazy-load-settings',
            'wp_lazyload'
        );
        add_settings_field(
            'provider_height',
            'Provider Height',
            array($this, 'provider_height_callback'),
            'wp-lazy-load-settings',
            'wp_lazyload'
        );
        add_settings_field(
            'mode',
            'Display Mode',
            array($this, 'mode_callback'),
            'wp-lazy-load-settings',
            'wp_lazyload'
        );

        register_setting('wp-lazy-load-settings', 'button_label');
        register_setting('wp-lazy-load-settings', 'button_text_color');
        register_setting('wp-lazy-load-settings', 'button_bg_color');
        register_setting('wp-lazy-load-settings', 'play_icon');
        register_setting('wp-lazy-load-settings', 'provider_width');
        register_setting('wp-lazy-load-settings', 'provider_height');
        register_setting('wp-lazy-load-settings', 'mode');
    }

    /**
     * Callback for button label setting
     */
    public function button_label_callback()
    {
        $button_label = get_option('button_label', 'View interactive content');
?>
        <input
            type="text"
            id="button_label"
            name="button_label"
            value="<?php echo esc_attr($button_label); ?>"
            class="regular-text" />
    <?php
    }

    /**
     * Callback for button text color setting
     */
    public function button_text_color_callback()
    {
        $button_text_color = get_option('button_text_color', '#3a3a3a');
    ?>
        <input
            type="text"
            id="button_text_color"
            name="button_text_color"
            value="<?php echo esc_attr($button_text_color); ?>"
            class="color-field"
            data-default-color="#3a3a3a" />
        <p class="description">Choose or enter the color for button text.</p>
    <?php
    }
    

    /**
     * Callback for button background color setting
     */
    public function button_bg_color_callback()
    {
        $button_bg_color = get_option('button_bg_color', '#ffcd3d');
    ?>
        <input
            type="text"
            id="button_bg_color"
            name="button_bg_color"
            value="<?php echo esc_attr($button_bg_color); ?>"
            class="color-field"
            data-default-color="#ffcd3d" />
        <p class="description">Choose or enter the background color for the button.</p>
    <?php
    }
    

    /**
     * Callback for play icon visibility setting
     */
    public function play_icon_callback()
    {
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

    /**
     * Callback for provider width setting
     */
    public function provider_width_callback()
    {
        $provider_width = get_option('provider_width', '');
    ?>
        <input
            type="text"
            id="provider_width"
            name="provider_width"
            value="<?php echo esc_attr($provider_width); ?>"
            placeholder="e.g., 100%, 500px"
            class="regular-text" />
        <p class="description">Set the width of the content provider (e.g., 100%, 500px).</p>
    <?php
    }

    /**
     * Callback for provider height setting
     */
    public function provider_height_callback()
    {
        $provider_height = get_option('provider_height', '');
    ?>
        <input
            type="text"
            id="provider_height"
            name="provider_height"
            value="<?php echo esc_attr($provider_height); ?>"
            placeholder="e.g., 100%, 300px"
            class="regular-text" />
        <p class="description">Set the height of the content provider (e.g., 100%, 300px).</p>
    <?php
    }

    /**
     * Callback for display mode setting
     */
    public function mode_callback()
    {
        $mode = get_option('mode', 'inline');
    ?>
        <select id="mode" name="mode">
            <option value="inline" <?php selected($mode, 'inline'); ?>>Inline</option>
            <option value="popup" <?php selected($mode, 'popup'); ?>>Popup</option>
        </select>
        <p class="description">Choose how the content will be displayed.</p>
    <?php
    }

    /**
     * Add admin menu for plugin settings.
     */
    public function lazy_load_settings_page()
    {
        add_options_page(
            'WP Lazy Load Settings',
            'WP Lazy Load',
            'administrator',
            'wp-lazy-load-settings',
            array($this, 'lazy_load_settings_page_html')
        );
    }

    /**
     * Render settings page with tabs.
     */
    public function lazy_load_settings_page_html()
    {
        if (! current_user_can('manage_options')) {
            return;
        }

        $active_tab = isset($_GET['tab']) ? sanitize_text_field($_GET['tab']) : 'general';
    ?>
        <div class="wrap">
            <h1><?php echo esc_html(get_admin_page_title()); ?></h1>
            <nav class="nav-tab-wrapper">
                <a href="?page=wp-lazy-load-settings&tab=general" class="nav-tab <?php echo $active_tab == 'general' ? 'nav-tab-active' : ''; ?>">General Settings</a>
                <a href="?page=wp-lazy-load-settings&tab=shortcode" class="nav-tab <?php echo $active_tab == 'shortcode' ? 'nav-tab-active' : ''; ?>">Shortcode Generator</a>
            </nav>
            <form method="post" action="options.php">
                <?php
                if ('general' === $active_tab) {
                    settings_fields('wp-lazy-load-settings');
                    do_settings_sections('wp-lazy-load-settings');
                    submit_button('Save General Settings');
                } else {
                    include plugin_dir_path(__FILE__) . 'partials/wp-lazyload-admin-display.php';
                }
                ?>
            </form>
        </div>
<?php
    }
}
