# WP Lazyload

* **Contributors:** kgkrishnalmt, puneetlumel
* **Tags:** videos, lazy-loading, youtube, vimeo, wistia, iframe, button customization
* **Requires at least:** 5.8.1
* **Tested up to:** 5.8.1
* **Stable tag:** 1.0.0
* **License:** GPLv2 or later
* **License URI:** http://www.gnu.org/licenses/gpl-2.0.html

This is a WordPress plugin that can lazy load single videos, iframes, and increase your Google PageSpeed Score.

---

### Description

This plugin lazy loads videos and iframes on your page by using a placeholder preview image in place of the content. The video or iframe loads only when the preview image is clicked. All the scripts and styles for the content are loaded only when the placeholder image is clicked, thus improving your site performance as well as increasing your Google PageSpeed/GTMetrix Score.

WP Lazyload currently supports loading videos from YouTube, Vimeo, and Wistia. Support for more providers will be added in the future.

Key Features:
* Lazy load YouTube, Vimeo, Wistia videos, and iframes.
* Override default placeholder image.
* Customize play icon color.
* Button customization for iframe overlays, including label, text color, and background color.

---

### Installation

1. Upload `lazy-videos-1.0.0.zip` to the `/wp-content/plugins/` directory.
2. Activate the plugin through the 'Plugins' menu in WordPress.

---
### How to Use the Lazy Video Embed Plugin  

This plugin provides an easy way to embed videos and iframes with lazy loading. Below are usage examples to copy and modify based on your requirements. Replace placeholders (`URL`, `POSTER`, etc.) with your data.

---

### Basic YouTube Embed  
Embed a YouTube video with a poster image.  
```markdown
[wp_lazyload url="URL_TO_YOUTUBE_VIDEO" poster="URL_TO_POSTER_IMAGE"]
```

Example:  
```markdown
[wp_lazyload url="https://www.youtube.com/watch?v=XXXXXXXX" poster="https://example.com/path-to-image.png"]
```

---

### Wistia Video Embed  
Embed a video from Wistia with a poster image.  
```markdown
[wp_lazyload type="video" url="URL_TO_WISTIA_VIDEO" poster="URL_TO_POSTER_IMAGE"]
```

Example:  
```markdown
[wp_lazyload type="video" url="https://wistia.com/medias/YYYYYYYY" poster="https://example.com/path-to-image.png"]
```

---

### Power BI Iframe Embed  
Lazy load a Power BI iframe with a poster image.  
```markdown
[wp_lazyload type="iframe" url="URL_TO_IFRAME" poster="URL_TO_POSTER_IMAGE"]
```

Example:  
```markdown
[wp_lazyload type="iframe" url="https://app.powerbi.com/view?r=XXXXXXXX" poster="https://example.com/path-to-image.png"]
```

---

### Popup Mode with Customization  
Embed a lazy-loaded iframe that opens in a popup with a button and custom styles.  
```markdown
[wp_lazyload mode="popup" provider="PROVIDER_NAME" type="iframe" url="URL_TO_IFRAME" poster="URL_TO_POSTER_IMAGE" play_icon="show" button="show" button_label="BUTTON_TEXT" button_text_color="#COLOR_CODE" button_bg_color="#COLOR_CODE"]
```

Example:  
```markdown
[wp_lazyload mode="popup" provider="youtube" type="iframe" url="https://app.powerbi.com/view?r=XXXXXXXX" poster="https://example.com/path-to-image.png" play_icon="show" button="show" button_label="Watch Now" button_text_color="#ffffff" button_bg_color="#0073e6"]
```

---

### Notes  
- **`url`**: The source URL of the video or iframe.  
- **`poster`**: URL for the placeholder image shown before the video loads.  
- **`mode`**: Set to `popup` for opening the video/iframe in a popup.  
- **`button`**: Set to `show` to enable a button overlay.  
- **`button_label`**: Text displayed on the button (e.g., "Watch Now").  
- **`button_text_color`**: Customizes the button's text color.  
- **`button_bg_color`**: Customizes the button's background color.  

### Changelog

**1.0.0**
* Initial Release.
* **Feat:** Lazy load YouTube, Vimeo, Wistia videos, and iframes via the `[wp_lazyload]` shortcode.
* **Feat:** Override default placeholder image.
* **Feat:** Customize play icon color.
* **Feat:** Button customization for iframes.

