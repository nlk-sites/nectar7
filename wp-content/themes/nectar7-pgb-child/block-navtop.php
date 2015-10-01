<?php
/**
* block-navtop.php
*
* The NavTop block is visible on SM and larger screen sizes.On XS screens, menu items are moved into main nav.
*
* @return string
*/
$menuleftright = 'navbar-' . pgb_get_option('topmenu_align', 'left');
$fixed = pgb_get_option( 'topnav_position', 'static' );
$topmenustyle = '';
$datafix = '';

if ( 'fixed' === $fixed ) {
	$topmenustyle = 'navbar-fixed-top';
	$datafix = 'data-spy="affix" data-offset-top="135"';
}

$topnav_width = pgb_get_option( 'topnav_width', 'container-fluid' );
switch ($topnav_width) {
	case 'container-fluid':
		$topmenustyle = 'navbar-static-top';
		$topnav_width_inner = 'container';
		break;
	case 'full':
		$topmenustyle = 'navbar-static-top';
		$topnav_width_inner = 'container-fluid';
		break;
	case 'container':
	default:
		$topnav_width_inner = 'container-fluid';
		break;
}


?>
<nav id="top-nav" class="navbar navbar-inverse site-navigation hidden-xs <?=$topmenustyle; ?> <?=$topnav_width; ?>" <?php echo $datafix; ?> >
	<div  class="<?=$topnav_width_inner; ?> nav-contain" role="navigation">
		<div class="navbar-header"> 
			<!-- .navbar-toggle is used as the toggle for collapsed navbar content -->
			<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-responsive-collapse">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<!-- Your site title as branding in the menu --> 
			<a class="navbar-brand" href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><?php echo pgb_get_logo(); ?></a>
		</div>
		<div class="collapse navbar-collapse navbar-responsive-collapse navbar-inner">
			<?php if( '1' === pgb_get_option( 'nav_search' ) ) get_template_part( 'searchform', 'nav' ); // Show search form ?>
			<?php // Main Menu
			wp_nav_menu(
				array(
					'theme_location' => 'secondary',
					'container' => false,
					'menu_class' => 'nav navbar-nav '. esc_attr( $menuleftright ),
					'fallback_cb' => '',
					'menu_id' => 'top-menu',
					'walker' => new wp_bootstrap_navwalker()
				)
			);
			?>
			<?php echo get_woo_cart_menu(); ?>
		</div>
	</div>
</nav>
