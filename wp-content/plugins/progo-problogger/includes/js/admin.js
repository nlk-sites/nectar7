/* admin.js */

(function($){
	
	/**
	 * ProBlogger Meta Boxes control
	 */
	$('ul#problogger-meta-tabs li a').bind('click', function( event ){
		event.preventDefault();
		var tab = $(this).attr('href').slice(1);
		$(this).parent('li').addClass('tabs').siblings().removeClass('tabs');
		$('#problogger-meta-options div.tabs-panel').hide();
		$('#problogger-meta-options div#' + tab).show();
	});


	/**
	 * Sometimes you just have to trigger things on window load...
	 */
	$(window).load(function(){

		/**
		 * Customizer JavaScripts
		 */
		if ( $('body').hasClass('wp-customizer') ) {
			var customForm = $('#customize-control-problogger_settings-cta_form_custom'),
				gravityForm = $('#customize-control-problogger_settings-cta_form_gform_id');
			
			gravityForm.hide();
			
			$('input[name="customize-control-problogger_settings-cta_form_type"]').on('change', function(){
				var formtype = $('input[name="_customize-radio-problogger_cta_form_type"]:checked').val();
				if ( formtype == 'custom' ) {
					customForm.show();
					gravityForm.hide();
				}
				if ( formtype == 'gforms' ) {
					gravityForm.show();
					customForm.hide();
				}
			});
		}

	});

})(jQuery);
