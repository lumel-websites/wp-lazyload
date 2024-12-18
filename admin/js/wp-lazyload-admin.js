(function ($) {
	'use strict';

	// Debug log function for consistency

	const posterInput = $('#shortcode-poster');
	const uploadButton = $('#upload-poster-button');
	const removeButton = $('#remove-poster-button');
	const posterPreview = $('#poster-preview');
	const previewImg = $('#poster-preview-img');

	const mediaUploader = wp.media({
		title: 'Select or Upload a Poster Image',
		button: {
			text: 'Use This Image'
		},
		multiple: false
	});

	uploadButton.on('click', function (e) {
		e.preventDefault();
		mediaUploader.open();
	});

	mediaUploader.on('select', function () {
		const attachment = mediaUploader.state().get('selection').first().toJSON();
		posterInput.val(attachment.url);
		previewImg.attr('src', attachment.url);
		posterPreview.show();
		removeButton.show();
		updateShortcode(); // Update shortcode when the image is selected
	});

	removeButton.on('click', function (e) {
		e.preventDefault();
		posterInput.val('');
		previewImg.attr('src', '');
		posterPreview.hide();
		$(this).hide();
		updateShortcode(); // Update shortcode when the image is removed
	});

	function updateShortcode() {

		var attrs = [];
		var url = $('#shortcode-url').val();
		var type = $('#shortcode-type').val();
		var provider = $('#shortcode-provider').val();
		var poster = $('#shortcode-poster').val() || $('#shortcode-poster-url').val();

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

		var shortcode = `[wp_lazyload ${attrs.join(' ')}]`;
		$('#generated-shortcode').text(shortcode);
	}

	// Update shortcode on any input change
	$('#shortcode-url, #shortcode-type, #shortcode-provider, #shortcode-poster, ' +
		'#shortcode-mode, #shortcode-poster-lazy, #shortcode-play-icon, #shortcode-poster-url,' +
		'#shortcode-width, #shortcode-height, #shortcode-button, ' +
		'#shortcode-button-label, #shortcode-button-text-color, #shortcode-button-bg-color')
		.on('input change', function (event) {
			updateShortcode();
		});

	// Copy shortcode to clipboard
	$('#copy-shortcode').click(function () {
		var $temp = $("<textarea>");
		$("body").append($temp);
		$temp.val($('#generated-shortcode').text()).select();
		document.execCommand("copy");
		$temp.remove();
		alert('Shortcode copied to clipboard!');
	});

	// Initial shortcode generation
	updateShortcode();

})(jQuery);
