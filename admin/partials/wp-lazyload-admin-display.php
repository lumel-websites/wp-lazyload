<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://github.com/lumel-websites
 * @since      1.0.0
 *
 * @package    WP_Lazyload
 * @subpackage WP_Lazyload/admin/partials
 */
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
                <div class="color-input-container">
                    <input
                        type="text"
                        id="shortcode-button-text-color-input"
                        name="shortcode-button-text-color-input"
                        value="#3a3a3a"
                        data-default-color="#3a3a3a" />
                </div>
            </td>
        </tr>
        <tr>
            <th scope="row">Button Background Color</th>
            <td>
                <div class="color-input-container">
                    <input
                        type="text"
                        id="shortcode-button-bg-color-input"
                        name="shortcode-button-bg-color-input"
                        value="#ffcd3d"
                        data-default-color="#ffcd3d" />
                </div>
            </td>
        </tr>
    </table>

    <div class="shortcode-preview">
        <h3>Generated Shortcode</h3>
        <pre id="generated-shortcode">[wp_lazyload url="..." type="video"]</pre>
        <button type="button" id="copy-shortcode" class="button button-secondary">Copy Shortcode</button>
    </div>
</div>