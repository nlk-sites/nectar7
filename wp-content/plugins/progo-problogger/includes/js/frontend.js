/* Front End JS */

(function( $ ){

	$(window).load(function(){

		$('#main-nav.navbar-fixed-top').affix({
			offset: {
				top: function() {
					return (this.top = $('.jumbotron').outerHeight(true) + $('#masthead').outerHeight(true) + $('#top-nav-wrapper').outerHeight(true))
				}
			}
		});

	});

}( jQuery ));
