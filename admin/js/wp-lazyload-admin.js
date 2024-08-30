(function( $ ) {
	'use strict';

	/**
	 * All of the code for your admin-facing JavaScript source
	 * should reside in this file.
	 *
	 * Note: It has been assumed you will write jQuery code here, so the
	 * $ function reference has been prepared for usage within the scope
	 * of this function.
	 *
	 * This enables you to define handlers, for when the DOM is ready:
	 *
	 * $(function() {
	 *
	 * });
	 *
	 * When the window is loaded:
	 *
	 * $( window ).load(function() {
	 *
	 * });
	 *
	 * ...and/or other possibilities.
	 *
	 * Ideally, it is not considered best practise to attach more than a
	 * single DOM-ready or window-load handler for a particular page.
	 * Although scripts in the WordPress core, Plugins and Themes may be
	 * practising this, we should strive to set a better example in our own work.
	 */

	 $(document).ready(function(e){
		var selectConfig = {
			placeholder:"Select an option", 
			width:"25em", 
		};

		$('#wp_lazyload-type-selector').select2( selectConfig );
	 	$('#wp_lazyload-mode-selector').select2( selectConfig );
		$('#wp_lazyload-lazyload-selector').select2( selectConfig );
		$('#wp_lazyload-icon-selector').select2( selectConfig );


		var buildShortcode = function(ee){
			var type      = $('#wp_lazyload-type-selector').val();
			var mode      = $('#wp_lazyload-mode-selector').val();
			var urlprovider       = $('#wp_lazyload-url').val();
			var poster    = $('#lazyload_upload_image').val();
			var lazyload  = $('#wp_lazyload-lazyload-selector').val();
			var icon      = $('#wp_lazyload-icon-selector').val();

			function checkUrl(test_url) {
				var testLoc = document.createElement('a');
					testLoc.href = test_url.toLowerCase();
				url = testLoc.hostname;
				var what;
				var url;
				if (url.indexOf('youtube.com') !== -1) {
					what='youtube';
				} else if (url.indexOf('vimeo.com') !== -1) {
					what='vimeo';
				} else {
					what='none';
				}
				return what;
			}


			var provider = checkUrl(urlprovider);


		    var shortcode = '[wp_lazyload';
		
			if( type !== '' ){
				shortcode += ' type="' + type + '"';
			}

			if( mode !== '' ){
				shortcode += ' mode="' + mode + '"';
			}

			if( urlprovider !== '' && type == 'video') {
				shortcode += ' provider="' + provider + '"';
			}

			if( urlprovider !== '' ){
				shortcode += ' url="' + urlprovider + '"';
			}

			if( provider == 'youtube' && poster=="") {
				var regExp = /^.*(youtu\.be\/|v\/|u\/\w\/|embed\/|watch\?v=|\&v=)([^#\&\?]*).*/;
				var match = urlprovider.match(regExp);
				if (match && match[2].length == 11) {
					var id = match[2];
					var poster = 'http://img.youtube.com/vi/'+id+'/0.jpg';
				} 
			}

			if( provider == 'vimeo' && poster=="") {
				var match = urlprovider.match(/vimeo\.com.*[\\\/](\d+)/); 
				if (match && match[1].length > 0) {
					var id = match[1];
					var poster = 'https://vumbnail.com/'+id+'/.jpg';
				} 
			}

			if( poster !== '' ){
				shortcode += ' poster="' + poster + '"';
			}

			if( lazyload !== '' ){
				shortcode += ' lazy_loading="' + lazyload + '"';
			}

			if( icon !== '' ){
				shortcode += ' icon="' + icon + '"';
			}

			shortcode += ']';
			$('#wp_lazyload-shortcode').html( shortcode );

			
		}
		
		$('#wp_lazyload-type-selector').change( buildShortcode );
		$('#wp_lazyload-mode-selector').change( buildShortcode );
		$('#wp_lazyload-url').keyup( buildShortcode );
		
		$('#wp_lazyload-lazyload-selector').change( buildShortcode );
		$('#wp_lazyload-icon-selector').change( buildShortcode );

		







		var custom_uploader;
		$('#upload_lazyload_poster').click(function(e) {
			e.preventDefault();
			//If the uploader object has already been created, reopen the dialog
			if (custom_uploader) {
				custom_uploader.open();
				return;
			}
			//Extend the wp.media object
			custom_uploader = wp.media.frames.file_frame = wp.media({
				title: 'Choose Image',
				button: {
					text: 'Choose Image'
				},
				multiple: false
			});
			//When a file is selected, grab the URL and set it as the text field's value
			custom_uploader.on('select', function() {
				var attachment = custom_uploader.state().get('selection').first().toJSON();
				$('#lazyload_upload_image').val(attachment.url);
				buildShortcode();
			});
			//Open the uploader dialog
			custom_uploader.open();
		});

	});
})( jQuery );
