<?php
/**
 * Footer Copyright Area
 *
 */

$show_footer_copyright = pgb_get_option( 'footer_show_copyright', false );
$default_copyright = 'Copyright &copy; ' . date( 'Y' ) . ' - ' . get_bloginfo( 'name' );

if( !empty( $show_footer_copyright ) && '1' === $show_footer_copyright ) { ?>
<footer id="colophon" class="site-footer" role="contentinfo">
	<?php tha_footer_top(); ?>
	<div class="container">
		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-8 pull-right text-right">
				<?php 
				wp_nav_menu( 
					array( 
						'theme_location' => 'footer',
						'container' => false,
						'menu_class' => 'nav navbar-nav list-inline',
						'fallback_cb' => '',
						'depth' => 1,
						'walker' => new wp_bootstrap_navwalker()
						) 
					); 
				?>
			</div>
			<div class="col-xs-12 col-sm-12 col-md-4 pull-left">
				<div class="site-copyright">
					<?php echo pgb_get_option( 'footer_copyright_text', $default_copyright ); ?>
				</div><!-- close .site-info -->
			</div>
		</div>
	</div><!-- close .container -->
	<?php tha_footer_bottom(); ?>
</footer><!-- close #colophon -->
<?php } ?>
