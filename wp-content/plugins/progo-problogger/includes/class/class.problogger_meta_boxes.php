<?php
/**
 * class ProBlogger Meta Boxes - Add ProBlogger meta box to the main column on the Post and Page edit screens
 *
 * @package problogger
 */
function call_ProBlogger_Meta_Boxes() {
	new ProBlogger_Meta_Boxes();
}
if ( is_admin() ) {
	add_action( 'load-post.php', 'call_ProBlogger_Meta_Boxes' );
	add_action( 'load-post-new.php', 'call_ProBlogger_Meta_Boxes' );
}

/**
 * start Class
 */
class ProBlogger_Meta_boxes extends ProBlogger {

	public function __construct() {
		add_action( 'add_meta_boxes', array( $this, 'add_meta_boxes' ) );
		add_action( 'save_post', array( $this, 'save_problogger' ) );
		add_action( 'save_post', array( $this, 'save_jumbotron' ) );
	}

	/**
	 * Adds the meta box container.
	 */
	public function add_meta_boxes( $post_type ) {
		if ( $post_type == 'page' ) {
			add_meta_box(
				'problogger_meta_box',
				__( 'ProBlogger Display Options', 'problogger' ),
				array( $this, 'render_meta_box_content' ),
				$post_type,
				'side',
				'core'
			);
		}
		if ( $post_type == 'progo_jumbotron' ) {
			add_meta_box(
				'jumbotron_meta_box',
				__( 'Jumbotron Options', 'problogger' ),
				array( $this, 'render_jumbo_meta_box_content' ),
				$post_type,
				'side',
				'core'
			);
		}

	}

	/**
	 * When ProBlogger post is saved, save our custom meta data.
	 *
	 * @param int $post_id The ID of the post being saved.
	 */
	public function save_problogger( $post_id ) {
		// Check if our nonce is set.
		if ( ! isset( $_POST['problogger_meta_box_nonce'] ) ) {
			return;
		}
		// Verify that the nonce is valid.
		if ( ! wp_verify_nonce( $_POST['problogger_meta_box_nonce'], 'problogger_meta_box' ) ) {
			return;
		}
		// If this is an autosave, our form has not been submitted, so we don't want to do anything.
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return;
		}
		// Check the user's permissions.
		if ( isset( $_POST['post_type'] ) && 'page' == $_POST['post_type'] ) {
			if ( ! current_user_can( 'edit_page', $post_id ) ) {
				return;
			}
		} else {
			if ( ! current_user_can( 'edit_post', $post_id ) ) {
				return;
			}
		}
		/* OK, it's safe for us to save the data now. */

		$jumbotron_show = wp_kses_post( ( isset( $_POST['problogger_jumbotron_show_field'] ) ) ? $_POST['problogger_jumbotron_show_field'] : '' );
		update_post_meta( $post_id, '_problogger_meta_jumbotron_show_key', $jumbotron_show );

		$jumbotron_id = wp_kses_post( ( isset( $_POST['problogger_jumbotron_post_id'] ) ) ? $_POST['problogger_jumbotron_post_id'] : '' );
		update_post_meta( $post_id, '_problogger_meta_jumbotron_post_id', $jumbotron_id );

		$featuredin_show = wp_kses_post( ( isset( $_POST['problogger_featuredin_show_field'] ) ) ? $_POST['problogger_featuredin_show_field'] : '' );
		update_post_meta( $post_id, '_problogger_meta_featuredin_show_key', $featuredin_show );

		$featuredin_id = wp_kses_post( ( isset( $_POST['problogger_featuredin_post_id'] ) ) ? $_POST['problogger_featuredin_post_id'] : '' );
		update_post_meta( $post_id, '_problogger_meta_featuredin_post_id', $featuredin_id );

		$top_nav_show = wp_kses_post( ( isset( $_POST['problogger_top_nav_show_field'] ) ) ? $_POST['problogger_top_nav_show_field'] : '' );
		update_post_meta( $post_id, '_problogger_meta_top_nav_show_key', $top_nav_show );

		$masthead_show = wp_kses_post( ( isset( $_POST['problogger_masthead_show_field'] ) ) ? $_POST['problogger_masthead_show_field'] : '' );
		update_post_meta( $post_id, '_problogger_meta_masthead_show_key', $masthead_show );

		$main_nav_show = wp_kses_post( ( isset( $_POST['problogger_main_nav_show_field'] ) ) ? $_POST['problogger_main_nav_show_field'] : '' );
		update_post_meta( $post_id, '_problogger_meta_main_nav_show_key', $main_nav_show );

	}
	public function save_jumbotron( $post_id ) {
		// Check if our nonce is set.
		if ( ! isset( $_POST['jumbotron_meta_box_nonce'] ) ) {
			return;
		}
		// Verify that the nonce is valid.
		if ( ! wp_verify_nonce( $_POST['jumbotron_meta_box_nonce'], 'jumbotron_meta_box' ) ) {
			return;
		}
		// If this is an autosave, our form has not been submitted, so we don't want to do anything.
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return;
		}
		// Check the user's permissions.
		if ( isset( $_POST['post_type'] ) && 'progo_jumbotron' == $_POST['post_type'] ) {
			if ( ! current_user_can( 'edit_page', $post_id ) ) {
				return;
			}
		} else {
			if ( ! current_user_can( 'edit_post', $post_id ) ) {
				return;
			}
		}
		/* OK, it's safe for us to save the data now. */

		$jumbo_color = wp_kses_post( ( isset( $_POST['jumbotron_color_field'] ) ) ? $_POST['jumbotron_color_field'] : '' );
		update_post_meta( $post_id, '_jumbotron_meta_color_key', $jumbo_color );

	}

	/**
	 * Print ProBlogger meta box content.
	 * 
	 * @param WP_Post $post The object for the current post/page.
	 */
	static function render_meta_box_content( $post ) {
		// Add an nonce field so we can check for it later.
		wp_nonce_field( 'problogger_meta_box', 'problogger_meta_box_nonce' );

		$show_jumbo = get_post_meta( $post->ID, '_problogger_meta_jumbotron_show_key', true );
		$jumbo_id = get_post_meta( $post->ID, '_problogger_meta_jumbotron_post_id', true );

		$show_featuredin = get_post_meta( $post->ID, '_problogger_meta_featuredin_show_key', true );
		$featuredin_id = get_post_meta( $post->ID, '_problogger_meta_featuredin_post_id', true );

		$top_nav_show = get_post_meta( $post->ID, '_problogger_meta_top_nav_show_key', true );
		$main_nav_show = get_post_meta( $post->ID, '_problogger_meta_main_nav_show_key', true );
		$masthead_show = get_post_meta( $post->ID, '_problogger_meta_masthead_show_key', true );
		
		/*
		 * Meta Box HTML
		 */
		?>
		<div id="problogger-meta-options" class="problogger-meta-options categorydiv">
			<ul id="problogger-meta-tabs" class="category-tabs">
				<li class="tabs">
					<a href="#problogger-meta-jumbotron"><?php _e( 'Jumbotron', 'problogger' ); ?></a>
				</li>
				<li class="hide-if-no-js">
					<a href="#problogger-meta-menus"><?php _e( 'Menus', 'problogger' ); ?></a>
				</li>
				<li class="hide-if-no-js">
					<a href="#problogger-meta-masthead"><?php _e( 'Masthead', 'problogger' ); ?></a>
				</li>
			</ul>
			<div id="problogger-meta-jumbotron" class="tabs-panel">
				<p><?php _e( 'Use the following options to turn on/off hero and CTA content. Leave checkboxes blank to disable altogether.', 'problogger' ); ?></p>
				<fieldset class="primary">
					<h4><?php _e( 'Jumbotron Override', 'problogger' ); ?></h4>
					<label for="problogger_jumbotron_show_field">
						<input type="radio" id="problogger_jumbotron_show_field" class="field-toggle" name="problogger_jumbotron_show_field" value="1" <?php echo ( $show_jumbo == '1' ? 'checked="checked"' : ''); ?> />
						<?php _e( 'Show Jumbotron', 'problogger' ); ?>
					</label>
					<label for="problogger_jumbotron_show_field_false">
						<input type="radio" id="problogger_jumbotron_show_field_false" class="field-toggle" name="problogger_jumbotron_show_field" value="2" <?php echo ( $show_jumbo == '2' ? 'checked="checked"' : ''); ?> />
						<?php _e( 'Hide Jumbotron', 'problogger' ); ?>
					</label>
					<!-- Select Jumbo from Dropdown -->
					<label for="problogger_jumbotron_post_id"><?php _e( 'Select Jumbotron', 'problogger' ); ?>
						<select id="problogger_jumbotron_post_id" name="problogger_jumbotron_post_id" >
							<?php
							$args1 = array(
								'post_type' => 'progo_jumbotron',
								'posts_per_page' => -1,
							);
							$jumbos = get_posts( $args1 );
							$postcount = count( $jumbos );
							for ( $i = 0; $i < $postcount; $i++ ) { ?>
								<option value="<?php echo $jumbos[$i]->ID; ?>" <?php echo ( $jumbo_id == $jumbos[$i]->ID ? 'selected="selected"' : '' ); ?>><?php esc_attr_e($jumbos[$i]->post_title); ?></option>
							<?php
							}
							?>
						</select>
					</label>
				</fieldset>
				<fieldset class="primary">
					<h4><?php _e( 'Featured In...', 'problogger' ); ?></h4>
					<label for="problogger_featuredin_show_field">
						<input type="checkbox" id="problogger_featuredin_show_field" class="field-toggle" name="problogger_featuredin_show_field" value="1" <?php echo ( $show_featuredin ? 'checked="checked"' : ''); ?> />
						<?php _e( 'Show "Featured In" Block', 'problogger' ); ?>
					</label>
					<!-- Select Featured In from Dropdown -->
					<label for="problogger_featuredin_post_id" class="<?php echo ( $show_featuredin ? 'show' : 'hidden'); ?>" ><?php _e( 'Select "Featured In"', 'problogger' ); ?>
						<select id="problogger_featuredin_post_id" name="problogger_featuredin_post_id" >
							<option></option>
	                        <?php
							$args2 = array(
								'post_type' => 'pbl_featuredin',
								'posts_per_page' => -1,
							);
							$seens = get_posts( $args2 );
							$postcount = count( $seens );
							for ( $i = 0; $i < $postcount; $i++ ) { ?>
								<option value="<?php echo $seens[$i]->ID; ?>" <?php echo ( $featuredin_id == $seens[$i]->ID ? 'selected="selected"' : '' ); ?>><?php esc_attr_e($seens[$i]->post_title); ?></option>
							<?php
							}
							?>
						</select>
					</label>
				</fieldset>
			</div>
			<div id="problogger-meta-menus" class="tabs-panel" style="display: none;">
				<p><?php _e( 'Use the following checkboxes to disable elements. To create a squeeze page, disable both menus.', 'problogger' ); ?></p>
				<!-- Show top nav? -->
				<label for="problogger_top_nav_show_field" class="">
					<input type="checkbox" id="problogger_top_nav_show_field" name="problogger_top_nav_show_field" value="1" <?php echo $top_nav_show == '1' ? 'checked="checked" ' : ''; ?> />
					<?php _e( 'Disable Top Navbar', 'problogger' ); ?>
				</label>
				
				<!-- Show main nav? -->
				<label for="problogger_main_nav_show_field" class="">
					<input type="checkbox" id="problogger_main_nav_show_field" name="problogger_main_nav_show_field" value="1" <?php echo  $main_nav_show == '1' ? 'checked="checked" ' : ''; ?> />
					<?php _e( 'Disable Main Navbar', 'problogger' ); ?>
				</label>
			</div>
			<div id="problogger-meta-masthead" class="tabs-panel" style="display: none;">
				<p><?php _e( 'Disable Masthead on page. Also hides widgets assigned to Masthead widget areas.', 'problogger' ); ?></p>
				<!-- Show masthead? -->
				<label for="problogger_masthead_show_field" class="">
					<input type="checkbox" id="problogger_masthead_show_field" name="problogger_masthead_show_field" value="1" <?php echo $masthead_show == '1' ? 'checked="checked" ' : ''; ?>/>
					<?php _e( 'Disable Masthead', 'problogger' ); ?>
				</label>
			</div>
		</div>
		<?php
	}

	/**
	 * Print Jumbotron meta box content.
	 * 
	 * @param WP_Post $post The object for the current post/page.
	 */
	static function render_jumbo_meta_box_content( $post ) {
		// Add an nonce field so we can check for it later.
		wp_nonce_field( 'jumbotron_meta_box', 'jumbotron_meta_box_nonce' );

		$jumbo_color = get_post_meta( $post->ID, '_jumbotron_meta_color_key', true );

		/*
		 * Jumbotron Section
		 */
		?>
		<div id="jumbotron-meta-options" class="jumbotron-meta-options categorydiv">
			<ul id="jumbotron-meta-tabs" class="category-tabs">
				<li class="tabs">
					<a href="#jumbotron-meta-color"><?php _e( 'Color', 'problogger' ); ?></a>
				</li>
				<!--li class="hide-if-no-js">
					<a href="#jumbotron-meta-demo"><?php _e( 'Example', 'problogger' ); ?></a>
				</li-->
			</ul>
			<div id="jumotron-meta-color" class="tabs-panel">
				<p><?php _e( 'Select the Jumbotron background color.', 'problogger' ); ?></p>
				<fieldset class="primary">
					<label for="jumbotron_color_field">
						<input type="text" id="jumbotron_color_field" name="jumbotron_color_field" value="<?php echo $jumbo_color; ?>" class="wp-color-picker-field" />
					</label>
				</fieldset>
			</div>
		</div>
		<?php
	}
}


?>
