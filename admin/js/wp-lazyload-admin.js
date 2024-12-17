(function( $ ) {
	'use strict';

	// Debug log function for consistency
	function debugLog(message, data = null) {
		console.log(`[DEBUG]: ${message}`, data);
	}

	function updateShortcode() {
		debugLog('updateShortcode function triggered');

		var attrs = [];
		var url = $('#shortcode-url').val();
		var type = $('#shortcode-type').val();
		var provider = $('#shortcode-provider').val();
		var poster = $('#shortcode-poster').val();

		debugLog('Initial Values', { url, type, provider, poster });

		attrs.push(`url="${url}"`);
		attrs.push(`type="${type}"`);

		if (provider !== 'custom') {
			attrs.push(`provider="${provider}"`);
		}

		if (poster) {
			attrs.push(`poster="${poster}"`);
		}

		var mode = $('#shortcode-mode').val();
		if (mode !== 'inline') {
			attrs.push(`mode="${mode}"`);
		}

		var posterLazy = $('#shortcode-poster-lazy').val();
		if (posterLazy === 'false') {
			attrs.push(`poster_lazy="${posterLazy}"`);
		}

		var playIcon = $('#shortcode-play-icon').val();
		if (playIcon !== 'show') {
			attrs.push(`play_icon="${playIcon}"`);
		}

		var width = $('#shortcode-width').val();
		if (width) {
			attrs.push(`provider_width="${width}"`);
		}

		var height = $('#shortcode-height').val();
		if (height) {
			attrs.push(`provider_height="${height}"`);
		}

		var buttonVisibility = $('#shortcode-button').val();
		if (buttonVisibility === 'hide') {
			attrs.push('button="hide"');
		}

		var buttonLabel = $('#shortcode-button-label').val();
		if (buttonLabel !== 'View interactive content') {
			attrs.push(`button_label="${buttonLabel}"`);
		}

		var buttonTextColor = $('#shortcode-button-text-color').val();
		if (buttonTextColor !== '#3a3a3a') {
			attrs.push(`button_text_color="${buttonTextColor}"`);
		}

		var buttonBgColor = $('#shortcode-button-bg-color').val();
		if (buttonBgColor !== '#ffcd3d') {
			attrs.push(`button_bg_color="${buttonBgColor}"`);
		}

		debugLog('Generated Attributes', attrs);

		var shortcode = `[wp_lazyload ${attrs.join(' ')}]`;
		$('#generated-shortcode').text(shortcode);
		debugLog('Final Shortcode', shortcode);
	}

	// Update shortcode on any input change
	$('#shortcode-url, #shortcode-type, #shortcode-provider, #shortcode-poster, ' +
	  '#shortcode-mode, #shortcode-poster-lazy, #shortcode-play-icon, ' +
	  '#shortcode-width, #shortcode-height, #shortcode-button, ' +
	  '#shortcode-button-label, #shortcode-button-text-color, #shortcode-button-bg-color')
	.on('input change', function(event) {
		debugLog(`Input/Change event detected on`, event.target.id);
		updateShortcode();
	});

	// Copy shortcode to clipboard
	$('#copy-shortcode').click(function() {
		debugLog('Copy shortcode button clicked');
		var $temp = $("<textarea>");
		$("body").append($temp);
		$temp.val($('#generated-shortcode').text()).select();
		document.execCommand("copy");
		$temp.remove();
		alert('Shortcode copied to clipboard!');
	});

	// Initial shortcode generation
	debugLog('Script initialized, generating initial shortcode');
	updateShortcode();

})( jQuery );
