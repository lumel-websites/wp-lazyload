# WP Lazyload

* **Contributors:** kgkrishnalmt, puneetlumel  
* **Tags:** videos, lazy-loading, youtube, vimeo, wistia, gif, iframe, button customization, shortcode generator  
* **Requires at least:** 5.8.1  
* **Tested up to:** 5.8.1  
* **Stable tag:** 1.0.0  
* **License:** GPLv2 or later  
* **License URI:** http://www.gnu.org/licenses/gpl-2.0.html  

This is a WordPress plugin that can lazy load videos, GIFs, and iframes to increase your Google PageSpeed score.

---

### Description

This plugin lazy loads videos, GIFs, and iframes using a placeholder image. The content loads **only when the placeholder is clicked**, improving your site's performance and boosting PageSpeed and GTMetrix scores.

**WP Lazyload** supports:
- YouTube, Vimeo, Wistia videos  
- GIFs  
- Custom iframes  

**Admin Feature**:  
- An intuitive **Shortcode Generator** in the admin dashboard makes it easy to generate shortcodes without manual coding.  

---

### Key Features:
* Lazy load YouTube, Vimeo, Wistia videos, GIFs, and iframes.  
* User-friendly shortcode generator tool in the admin panel.  
* Override default placeholder images.  
* Play icon modes: `show`, `hide`, or `hover`.  
* Customizable button overlays with label, color, and styles.  
* Popup or inline display modes.

---

### Installation

1. Upload `lazy-videos-1.0.0.zip` to the `/wp-content/plugins/` directory.  
2. Activate the plugin via the 'Plugins' menu in WordPress.  

---

### Shortcode Examples  

Below are usage examples. Replace placeholders (`URL`, `POSTER`, etc.) with your data.

---

#### 1. YouTube Video Embed  
Embed a YouTube video with a placeholder:  
```markdown
[wp_lazyload url="URL_TO_YOUTUBE_VIDEO" poster="URL_TO_POSTER_IMAGE"]
```

Example:  
```markdown
[wp_lazyload url="https://www.youtube.com/watch?v=XXXXXXXX" poster="https://example.com/image.jpg"]
```

---

#### 2. Lazy Load GIF  
Embed a GIF with lazy loading:  
```markdown
[wp_lazyload type="gif" url="URL_TO_GIF" poster="URL_TO_POSTER_IMAGE"]
```

Example:  
```markdown
[wp_lazyload type="gif" url="https://example.com/image.gif" poster="https://example.com/poster.jpg"]
```

---

#### 3. Custom Iframe Embed  
Embed a lazy-loaded iframe:  
```markdown
[wp_lazyload type="iframe" url="URL_TO_IFRAME" poster="URL_TO_POSTER_IMAGE"]
```

Example:  
```markdown
[wp_lazyload type="iframe" url="https://app.powerbi.com/view?r=XXXXXXXX" poster="https://example.com/poster.jpg"]
```

---

#### 4. Popup Display Mode with Button  
Embed an iframe using a popup button:  
```markdown
[wp_lazyload mode="popup" provider="youtube" type="iframe" url="URL_TO_IFRAME" poster="URL_TO_POSTER_IMAGE" play_icon="hover" button="show" button_label="Watch Now" button_text_color="#ffffff" button_bg_color="#0073e6"]
```

---

### Admin Shortcode Generator  
Quickly generate shortcodes with the built-in Shortcode Generator located in the WordPress admin. This tool allows you to:
- Select content type: Video, Iframe, or GIF.  
- Choose providers: YouTube, Vimeo, Wistia, or Custom.  
- Set placeholder images, play icon styles, button customization, and more.  

The generated shortcode can be copied and used on any page or post.

---

### Notes  
- **`type`**: Define content type (video, iframe, or gif).  
- **`poster`**: Placeholder image for lazy loading.  
- **`mode`**: Set `popup` for modal display.  
- **`button`**: Show or hide buttons (`show`/`hide`).  
- **`play_icon`**: Modes available: `show`, `hide`, or `hover`.

---

### Changelog  

**1.0.0**  
* Initial Release.  
* **Feat:** Lazy load YouTube, Vimeo, Wistia videos, GIFs, and iframes.  
* **Feat:** New Shortcode Generator added to WordPress admin.  
* **Feat:** Override default placeholder image.  
* **Feat:** Play icon customization: show, hide, or hover.  
* **Feat:** Button customization with custom text and styles.


