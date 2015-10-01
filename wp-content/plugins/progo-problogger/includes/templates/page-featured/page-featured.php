<?php
/**
 * Template Name: Featured Posts
 *
 * This is the template that displays featured posts.
 *
 * @package pgb
 */

get_header(); ?>

	<div id="content" class="main-content-inner col-sm-12 col-md-8 col-lg-9">

		<?php tha_content_top(); ?>

		<?php if ( have_posts() ) : ?>

			<?php while ( have_posts() ) : the_post(); ?>

				<?php tha_entry_before(); ?>

				<article id="post-<?php the_ID(); ?>" <?php post_class( 'row' ); ?>>

					<?php tha_entry_top(); ?>

					<?php get_template_part( 'posts', 'header' ); ?>

					<div class="col-md-12">
						<div class="row">

							<?php get_template_part( 'content', get_post_format() ); ?>

						</div>
					</div>


					<?php

					$args = array( 'posts_per_page' => 3, 'category' => get_cat_ID( 'Featured' ) );

					$featured_posts = get_posts( $args );

					foreach ( $featured_posts as $post ) : setup_postdata( $post ); ?>

						<?php get_template_part( 'posts', 'header' ); ?>

						<div class="col-md-12">
							<div class="row">

								<?php get_template_part( 'content', get_post_format() ); ?>

							</div>
						</div>

					<?php endforeach; wp_reset_postdata(); ?>

					<?php get_template_part( 'posts', 'footer' ); ?>

					<?php tha_entry_bottom(); ?>

				</article><!-- #post-## -->

				<?php tha_entry_after(); ?>

				<?php
					// If comments are open or we have at least one comment, load up the comment template
					if ( comments_open() || '0' != get_comments_number() )
						comments_template();
				?>

			<?php endwhile; // end of the loop. ?>

		<?php endif; ?>

		<?php tha_content_bottom(); ?>

	</div>

	<?php get_sidebar(); ?>

<?php get_footer(); ?>
