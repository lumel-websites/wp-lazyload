(function ($) {
	'use strict';

	// Helper function to extract video code from URL
	const extractVideoCode = (url, provider) => {
		if (!url || !provider) return '';

		if (provider === 'youtube') {
			if (url.includes('youtu.be')) {
				return url.split('/').pop().split('?')[0];
			}
			if (url.includes('youtube.com/watch')) {
				const params = new URLSearchParams(url.split('?')[1]);
				return params.get('v');
			}
		} else if (provider === 'wistia') {
			return url.split('/').pop();
		} else if (provider === 'vimeo') {
			const vimeoParts = url.split('/');
			const mainPart = vimeoParts.pop().split('?')[0];
			if (!isNaN(mainPart)) {
				return mainPart;
			} else {
				return vimeoParts.pop();
			}
		}

		return '';
	};

	// Helper function to generate embed code
	const generateEmbedCode = (videoCode, url, provider, title = '') => {
		switch (provider) {
			case 'youtube':
				return `
					<iframe 
						loading="lazy" 
						src="https://www.youtube.com/embed/${videoCode}?autoplay=1&feature=oembed" 
						allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
						allowfullscreen 
						title="${title}">
					</iframe>`;
			case 'wistia':
				return `
					<iframe 
						loading="lazy" 
						src="https://fast.wistia.net/embed/iframe/${videoCode}?autoPlay=true&volume=1" 
						frameborder="0" 
						scrolling="no" 
						class="wistia_embed" 
						allowfullscreen 
						allow="autoplay"
						title="${title}">
					</iframe>`;
			case 'vimeo':
				return `
					<iframe 
						loading="lazy" 
						src="https://player.vimeo.com/video/${videoCode}?autoplay=1&volume=1" 
						frameborder="0" 
						scrolling="no" 
						class="vimeo_embed" 
						allow="autoplay"
						allowfullscreen 
						title="${title}">
					</iframe>`;
			default:
				return '';
		}
	};

	// Helper function to handle popup mode
	const openPopup = (embedCode) => {
		if (!embedCode) return;

		const popupHTML = `
			<div class="wp-lazy-videos-popup-overlay">
				<div class="wp-lazy-videos-popup">
					${embedCode}
					<button class="wp-lazy-videos-popup-close">
						<img 
							alt="Click to close video" 
							style="height: 34px;" 
							src="data:image/gif;base64,R0lGODlhRABEAIABAP///////yH5BAEAAAEALAAAAABEAEQAAAKVjI+py+0Po5y02oszBPxyoGFfR41gWJlnpKJWu5muJzvw/NbLjefjruvRfgiecPg5GI/IzpLZfEKjyelMtbKisFoXltQVfcHhkkxaZtzQ6WIwwG4/42E03Rq/M+/6Xr9/RTTxVkc2aNiWqLjI2Oj4CBkpOUlZaXmJmam5ydnp+QkaKjpKWmp6ipqqusra6voKGyvbUwAAOw==">
					</button>
				</div>
			</div>`;

		$('body')
			.append(popupHTML)
			.on('click', '.wp-lazy-videos-popup-overlay, .wp-lazy-videos-popup-close', () => {
				$('.wp-lazy-videos-popup-overlay').remove();
			});
	};

	$(document).ready(() => {
		$('.wp-lazy-overlay-hover, .wp-lazy-play-icon').on('click', function () {
			const parent = $(this).closest('[data-mode]');
			const mode = parent.data('mode');
			const provider = parent.data('provider');
			const url = parent.data('url');
			const title = parent.data('title');

			const videoCode = extractVideoCode(url, provider);
			const embedCode = generateEmbedCode(videoCode, url, provider, title);

			if (mode === 'inline') {
				parent.find('.wp-lazy-video-wrapper').html(embedCode);
				parent.find('.wp-lazy-overlay, .wp-lazy-play-icon').hide();
			} else if (mode === 'popup') {
				openPopup(embedCode);
			}
		});

		$('.wp-lazy-iframe-overlay, .wp-lazy-iframe-button').on('click', function () {
			const parent = $(this).closest('[data-mode]');
			const url = parent.data('url');
			const mode = parent.data('mode');

			if (url) {
				const embedCode = `
					<iframe 
						loading="lazy" 
						src="${url}&autoplay=1&volume=1" 
						frameborder="0" 
						scrolling="no" 
						allow="autoplay" 
						allowfullscreen 
						class="iframe_embed">
					</iframe>`;
				if (mode === 'inline') {
					parent.find('.wp-lazy-iframe-wrapper').html(embedCode);
					parent.find('.wp-lazy-iframe-overlay').hide();
				} else if (mode === 'popup') {
					openPopup(embedCode);
				}
			}
		});

		$('.wp-lazy-gif-overlay').on('click', function () {
			const parent = $(this).closest('.wp-lazy-gif-container');
			const url = parent.data('url');
			if (url) {
				const gifHTML = `
					<img class="wp-lazy-gif" src="${url}" alt="GIF" loading="lazy">
				`;
				parent.find('.wp-lazy-gif-wrapper').html(gifHTML);
				parent.find('.wp-lazy-gif-overlay').hide();
			}
		});

		$('.wp-lazy-video-link').click(function (ee) {
			ee.preventDefault();

			const url = $(this).attr('href');
			let provider = '';
			let video_code = '';
			let embed_code = '';

			if (url.includes('youtube') || url.includes('youtu.be')) {
				provider = "youtube";
				if (url.includes('youtu.be')) {
					video_code = url.split('/').pop().split('?')[0];
				} else if (url.includes('youtube.com/watch')) {
					const params = new URLSearchParams(url.split('?')[1]);
					video_code = params.get('v');
				}
				embed_code = `<iframe loading="lazy" src="https://www.youtube.com/embed/${video_code}?autoplay=1&feature=oembed" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>`;
			} else if (url.includes('wistia')) {
				provider = "wistia";
				video_code = url.split('/').pop();
				embed_code = `<iframe loading="lazy" src="https://fast.wistia.net/embed/iframe/${video_code}?autoPlay=true&volume=1" allowtransparency="true" frameborder="0" scrolling="no" class="wistia_embed" allowfullscreen></iframe>`;
			} else if (url.includes('vimeo')) {
				provider = "vimeo";
				const vimeoParts = url.split('/');
				const mainPart = vimeoParts.pop().split('?')[0];
				if (!isNaN(mainPart)) {
					video_code = mainPart;
				} else {
					video_code = vimeoParts.pop();
				}
				embed_code = `<iframe loading="lazy" src="https://player.vimeo.com/video/${video_code}?autoplay=1&volume=1" allow="autoplay" frameborder="0" scrolling="no" allowfullscreen></iframe>`;
			} else {
				return; // Exit if provider is unknown
			}

			const popup_code = `
				<div class="wp-lazy-videos-popup-overlay">
					<div class="wp-lazy-videos-popup">
						${embed_code}
						<button class="wp-lazy-videos-popup-close">
							<img alt="Click to close video" style="height: 34px;" src="data:image/gif;base64,R0lGODlhRABEAIABAP///////yH5BAEAAAEALAAAAABEAEQAAAKVjI+py+0Po5y02oszBPxyoGFfR41gWJlnpKJWu5muJzvw/NbLjefjruvRfgiecPg5GI/IzpLZfEKjyelMtbKisFoXltQVfcHhkkxaZtzQ6WIwwG4/42E03Rq/M+/6Xr9/RTTxVkc2aNiWqLjI2Oj4CBkpOUlZaXmJmam5ydnp+QkaKjpKWmp6ipqqusra6voKGyvbUwAAOw==">
						</button>
					</div>
				</div>`;

			$('body').append(popup_code).on('click', '.wp-lazy-videos-popup-overlay, .wp-lazy-videos-popup-close', function () {
				$('.wp-lazy-videos-popup-overlay').remove();
			});
		});

	});
})(jQuery);
