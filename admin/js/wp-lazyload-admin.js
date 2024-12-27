(function ($) {
	'use strict';
    // Initialize WordPress color picker
    $('.color-field').wpColorPicker();

	const elements = {
		posterInput: $('#shortcode-poster'),
		uploadButton: $('#upload-poster-button'),
		removeButton: $('#remove-poster-button'),
		posterPreview: $('#poster-preview'),
		previewImg: $('#poster-preview-img'),
		shortcodeFields: $('#shortcode-url, #shortcode-type, #shortcode-provider, #shortcode-poster,#shortcode-mode, #shortcode-poster-lazy, #shortcode-play-icon, #shortcode-poster-url,#shortcode-width, #shortcode-height, #shortcode-button, #shortcode-button-label, #shortcode-button-text-color, #shortcode-button-bg-color'),
		copyButton: $('#copy-shortcode'),
		shortcodeDisplay: $('#generated-shortcode'),
		colorInputs: {
			buttonTextInput: $('#shortcode-button-text-color-input'),
			buttonBgInput: $('#shortcode-button-bg-color-input')
		},
		contentType: $('#shortcode-type'),
		providerField: $('#shortcode-provider'),
		playIconField: $('#shortcode-play-icon')
	};

	const mediaUploader = wp.media({
		title: 'Select or Upload a Poster Image',
		button: { text: 'Use This Image' },
		multiple: false
	});

	// Handle Image Upload
	elements.uploadButton.on('click', function (e) {
		e.preventDefault();
		mediaUploader.open();
	});

	mediaUploader.on('select', function () {
		const attachment = mediaUploader.state().get('selection').first().toJSON();
		elements.posterInput.val(attachment.url);
		elements.previewImg.attr('src', attachment.url);
		elements.posterPreview.show();
		elements.removeButton.show();
		updateShortcode();
	});

	elements.removeButton.on('click', function (e) {
		e.preventDefault();
		elements.posterInput.val('');
		elements.previewImg.attr('src', '');
		elements.posterPreview.hide();
		$(this).hide();
		updateShortcode();
	});
// Update Shortcode
function updateShortcode() {
    const attrs = [];
    const url = $('#shortcode-url').val();
    const type = $('#shortcode-type').val();
    const provider = $('#shortcode-provider').val();
    const poster = elements.posterInput.val() || $('#shortcode-poster-url').val();

    if (url) attrs.push(`url="${url}"`);
    if (type) attrs.push(`type="${type}"`);
    if (provider && provider !== 'custom') attrs.push(`provider="${provider}"`);
    if (poster) attrs.push(`poster="${poster}"`);

    const optionalFields = {
        mode: $('#shortcode-mode').val(),
        posterLazy: $('#shortcode-poster-lazy').val(),
        playIcon: $('#shortcode-play-icon').val(),
        width: $('#shortcode-width').val(),
        height: $('#shortcode-height').val(),
        buttonVisibility: $('#shortcode-button').val(),
        buttonLabel: $('#shortcode-button-label').val(),
        buttonTextColor: $('#shortcode-button-text-color-input').val(),
        buttonBgColor: $('#shortcode-button-bg-color-input').val()
    };

    if (optionalFields.mode && optionalFields.mode !== 'inline') attrs.push(`mode="${optionalFields.mode}"`);
    if (optionalFields.posterLazy && optionalFields.posterLazy === 'false') attrs.push(`poster_lazy="${optionalFields.posterLazy}"`);
    if (optionalFields.playIcon && optionalFields.playIcon !== 'show') attrs.push(`play_icon="${optionalFields.playIcon}"`);
    if (optionalFields.width) attrs.push(`provider_width="${optionalFields.width}"`);
    if (optionalFields.height) attrs.push(`provider_height="${optionalFields.height}"`);
    if (optionalFields.buttonVisibility && optionalFields.buttonVisibility === 'hide') attrs.push('button="hide"');
    if (optionalFields.buttonLabel && optionalFields.buttonLabel !== 'View interactive content') attrs.push(`button_label="${optionalFields.buttonLabel}"`);
    if (optionalFields.buttonTextColor && optionalFields.buttonTextColor !== '#3a3a3a') attrs.push(`button_text_color="${optionalFields.buttonTextColor}"`);
    if (optionalFields.buttonBgColor && optionalFields.buttonBgColor !== '#ffcd3d') attrs.push(`button_bg_color="${optionalFields.buttonBgColor}"`);

    elements.shortcodeDisplay.text(`[wp_lazyload ${attrs.join(' ')}]`);
}

	function updateFieldsBasedOnType() {

		const selectedType = $('#shortcode-type').val();

		const disableFields = (fields, value) => {
			fields.forEach(([selector, disableValue]) => {
				$(selector).prop('disabled', true).val(disableValue);
			});
		};
	
		const enableFields = (fields) => {
			fields.forEach(([selector, defaultValue]) => {
				$(selector).prop('disabled', false).val(defaultValue);
			});
		};

		const disableButtons = (selectors) => {
			selectors.forEach((selector) => {
				$(selector).prop('disabled', true).addClass('disabled'); // Optionally add a disabled class for styling
			});
		};

		const enableButtons = (selectors) => {
			selectors.forEach((selector) => {
				$(selector).prop('disabled', false).removeClass('disabled');
			});
		};

		const commonFields = [
			['#shortcode-button-label', 'View interactive content'],
			['#shortcode-provider', 'custom'],
			['#shortcode-play-icon', 'show'],
			['#shortcode-button', 'show'],
			['#shortcode-button-text-color-input', '#3a3a3a'],
			['#shortcode-button-bg-color-input', '#ffcd3d'],
			['#shortcode-mode', 'inline'],
		];

		const commonButtons = [
			'.wp-color-result'
		];

		// Reset all fields to the enabled state
		enableFields(commonFields);
		enableButtons(commonButtons);

		// Apply specific conditions
		if (selectedType === 'iframe') {
			disableFields([
				['#shortcode-provider', 'custom'],
				['#shortcode-play-icon', 'show']
			]);
		} else if (selectedType === 'video') {
			disableFields([
				['#shortcode-button', 'show'],
				['#shortcode-button-label', 'View interactive content'],
				['#shortcode-button-text-color-input', '#3a3a3a'],
				['#shortcode-button-bg-color-input', '#ffcd3d'],
			]);
			disableButtons(['.wp-color-result']);
		} else if (selectedType === 'gif') {
			disableFields([
				['#shortcode-provider', 'custom'],
				['#shortcode-play-icon', 'show'],
				['#shortcode-button', 'show'],
				['#shortcode-button-text-color-input', '#3a3a3a'],
				['#shortcode-button-bg-color-input', '#ffcd3d'],
				['#shortcode-mode', 'inline'],
			]);
			disableButtons(['.wp-color-result']);
		}
	}
	
	// Trigger on change
	$('#shortcode-type').on('change', function () {
		updateFieldsBasedOnType();
	});
	

	// Copy Shortcode to Clipboard
	elements.copyButton.on('click', function () {
		const temp = $('<textarea>');
		$('body').append(temp);
		temp.val(elements.shortcodeDisplay.text()).select();
		document.execCommand('copy');
		temp.remove();
		alert('Shortcode copied to clipboard!');
	});

	// Update Shortcode on Input Changes
	elements.shortcodeFields.on('input change', updateShortcode);

	// Initial Shortcode Generation
	updateShortcode();

	updateFieldsBasedOnType();

	$("#shortcode-button-bg-color-input").wpColorPicker(
		'option',
		'change',
		(event, ui) => {
			updateShortcode();
		}
	);

	$("#shortcode-button-text-color-input").wpColorPicker(
		'option',
		'change',
		(event, ui) => {
			updateShortcode();
		}
	);
})(jQuery);
