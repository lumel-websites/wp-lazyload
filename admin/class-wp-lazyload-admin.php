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
 * Defines the plugin name, version, and admin settings including shortcode generator.
 *
 * @package    WP_Lazyload
 * @subpackage WP_Lazyload/admin
 * @author     K Gopal Krishna <kg@lumel.com>
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
     * @param      string    $plugin_name       The name of this plugin.
     * @param      string    $version    The version of this plugin.
     */
    public function __construct($plugin_name, $version)
    {
        $this->plugin_name = $plugin_name;
        $this->version = $version;
    }

    /**
     * Register the stylesheets for the admin area.
     *
     * @since    1.0.0
     */
    public function enqueue_styles()
    {

        /**
         * This function is provided for demonstration purposes only.
         *
         * An instance of this class should be passed to the run() function
         * defined in WP_Lazyload_Loader as all of the hooks are defined
         * in that particular class.
         *
         * The WP_Lazyload_Loader will then create the relationship
         * between the defined hooks and the functions defined in this
         * class.
         */

        wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/wp-lazyload-admin.css', array(), $this->version, 'all');
    }

    /**
     * Register the JavaScript for the admin area.
     *
     * @since    1.0.0
     */
    public function enqueue_scripts()
    {

        /**
         * This function is provided for demonstration purposes only.
         *
         * An instance of this class should be passed to the run() function
         * defined in WP_Lazyload_Loader as all of the hooks are defined
         * in that particular class.
         *
         * The WP_Lazyload_Loader will then create the relationship
         * between the defined hooks and the functions defined in this
         * class.
         */
        wp_enqueue_script('select2', 'https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js', array('jquery'), '4.0.13', true);
        wp_enqueue_script('jquery-validate', 'https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js', array('jquery'), '1.19.3', true);
        wp_enqueue_script('jquery-validate-methods', 'https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/additional-methods.min.js', array('jquery', 'jquery-validate'), '1.19.3', true);
        wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__) . 'js/wp-lazyload-admin.js', array('jquery', 'select2'), $this->version, true);
    }
    /**
     * Initialize lazy load settings
     */
    public function lazy_load_settings_init()
    {
        // Existing section
        add_settings_section("wp_lazyload", "General Settings", null, "wp-lazy-load-settings");

        // Existing button configuration fields
        add_settings_field("button_label", "Button Label", array($this, "button_label_callback"), "wp-lazy-load-settings", "wp_lazyload");
        add_settings_field("button_text_color", "Button Text Color", array($this, "button_text_color_callback"), "wp-lazy-load-settings", "wp_lazyload");
        add_settings_field("button_bg_color", "Button Background Color", array($this, "button_bg_color_callback"), "wp-lazy-load-settings", "wp_lazyload");

        // New fields for extended configuration
        add_settings_field("play_icon", "Play Icon Visibility", array($this, "play_icon_callback"), "wp-lazy-load-settings", "wp_lazyload");
        add_settings_field("provider_width", "Provider Width", array($this, "provider_width_callback"), "wp-lazy-load-settings", "wp_lazyload");
        add_settings_field("provider_height", "Provider Height", array($this, "provider_height_callback"), "wp-lazy-load-settings", "wp_lazyload");
        add_settings_field("mode", "Display Mode", array($this, "mode_callback"), "wp-lazy-load-settings", "wp_lazyload");

        // Register new settings
        register_setting('wp-lazy-load-settings', 'button_label');
        register_setting('wp-lazy-load-settings', 'button_text_color');
        register_setting('wp-lazy-load-settings', 'button_bg_color');

        // Register extended configuration settings
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
            type="color"
            id="button_text_color"
            name="button_text_color"
            value="<?php echo esc_attr($button_text_color); ?>" />
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
            type="color"
            id="button_bg_color"
            name="button_bg_color"
            value="<?php echo esc_attr($button_bg_color); ?>" />
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
     * Add admin menu for plugin settings
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
     * Render settings page with tabs
     */
    public function lazy_load_settings_page_html()
    {
        // Check user capabilities
        if (!current_user_can('manage_options')) {
            return;
        }

        // Get the active tab
        $active_tab = isset($_GET['tab']) ? sanitize_text_field($_GET['tab']) : 'general';
    ?>
        <div class="wrap">
            <h1><?php echo esc_html(get_admin_page_title()); ?></h1>

            <nav class="nav-tab-wrapper">
                <a href="?page=wp-lazy-load-settings&tab=general"
                    class="nav-tab <?php echo $active_tab == 'general' ? 'nav-tab-active' : ''; ?>">
                    General Settings
                </a>
                <a href="?page=wp-lazy-load-settings&tab=shortcode"
                    class="nav-tab <?php echo $active_tab == 'shortcode' ? 'nav-tab-active' : ''; ?>">
                    Shortcode Generator
                </a>
            </nav>

            <form method="post" action="options.php">
                <?php
                if ($active_tab == 'general') {
                    settings_fields("wp-lazy-load-settings");
                    do_settings_sections("wp-lazy-load-settings");
                    submit_button('Save General Settings');
                } else {
                    $this->render_shortcode_generator();
                }
                ?>
            </form>
        </div>
    <?php
    }


    /**
     * Render Shortcode Generator Tab
     */
    public function render_shortcode_generator()
    {
    ?>
        <div class="wp-lazy-load-shortcode-generator">
            <h2>Shortcode Generator</h2>

            <table class="form-table">
                <tr>
                    <th scope="row">Content Type</th>
                    <td>
                        <select id="shortcode-type">
                            <option value="video">Video</option>
                            <option value="iframe">Iframe</option>
                            <option value="gif">GIF</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <th scope="row">Provider</th>
                    <td>
                        <select id="shortcode-provider">
                            <option value="youtube">YouTube</option>
                            <option value="wistia">Wistia</option>
                            <option value="vimeo">Vimeo</option>
                            <option value="custom">Custom</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <th scope="row">URL</th>
                    <td>
                        <input type="text" id="shortcode-url" class="regular-text" placeholder="Enter video or iframe URL">
                    </td>
                </tr>
                <tr>
                    <th scope="row">Poster Image</th>
                    <td>
                        <div id="poster-image-container">
                            <input type="text" id="shortcode-poster-url" class="regular-text" placeholder="Enter poster image URL (optional)" />
                            <span style="margin: 10px;">or</span>
                            <input type="hidden" id="shortcode-poster" name="shortcode-poster" value="" />
                            <button type="button" id="upload-poster-button" class="button">Upload Image</button>
                            <button type="button" id="remove-poster-button" class="button" style="display:none;">Remove Image</button>
                            <div id="poster-preview" style="margin-top: 10px; display: none;">
                                <img id="poster-preview-img" src="" alt="Poster Image" style="max-width: 300px; max-height: 200px;" />
                            </div>
                        </div>
                    </td>
                </tr>
                <tr>
                    <th scope="row">Display Mode</th>
                    <td>
                        <select id="shortcode-mode">
                            <option value="inline">Inline</option>
                            <option value="popup">Popup</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <th scope="row">Poster Lazy Loading</th>
                    <td>
                        <select id="shortcode-poster-lazy">
                            <option value="true">Enabled</option>
                            <option value="false">Disabled</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <th scope="row">Play Icon</th>
                    <td>
                        <select id="shortcode-play-icon">
                            <option value="show">Show</option>
                            <option value="hide">Hide</option>
                            <option value="hover">Hover</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <th scope="row">Provider Width</th>
                    <td>
                        <input type="text" id="shortcode-width" class="regular-text" placeholder="e.g., 100%, 500px">
                    </td>
                </tr>
                <tr>
                    <th scope="row">Provider Height</th>
                    <td>
                        <input type="text" id="shortcode-height" class="regular-text" placeholder="e.g., 100%, 300px">
                    </td>
                </tr>
                <tr>
                    <th scope="row">Button Visibility</th>
                    <td>
                        <select id="shortcode-button">
                            <option value="show">Show</option>
                            <option value="hide">Hide</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <th scope="row">Button Label</th>
                    <td>
                        <input type="text" id="shortcode-button-label" class="regular-text" value="View interactive content">
                    </td>
                </tr>
                <tr>
                    <th scope="row">Button Text Color</th>
                    <td>
                        <input type="color" id="shortcode-button-text-color" value="#3a3a3a">
                    </td>
                </tr>
                <tr>
                    <th scope="row">Button Background Color</th>
                    <td>
                        <input type="color" id="shortcode-button-bg-color" value="#ffcd3d">
                    </td>
                </tr>
            </table>

            <div class="shortcode-preview">
                <h3>Generated Shortcode</h3>
                <pre id="generated-shortcode">[wp_lazyload url="..." type="video"]</pre>
                <button type="button" id="copy-shortcode" class="button button-secondary">Copy Shortcode</button>
            </div>
    <?php
    }
}
