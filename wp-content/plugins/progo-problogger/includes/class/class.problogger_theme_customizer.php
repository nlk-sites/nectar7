<?php
/**
 * class ProBlogger Theme Customizer
 *
 */
add_action( 'customize_register' , array( 'ProBlogger_Theme_Customizer' , 'register' ) );
//add_action( 'wp_head' , array( 'ProBlogger_Theme_Customizer' , 'header_output' ) );
//add_action( 'customize_preview_init' , array( 'ProBlogger_Theme_Customizer' , 'live_preview' ) );
/**
 * the Class
 */
class ProBlogger_Theme_Customizer extends ProBlogger {
	/**
	* This hooks into 'customize_register' (available as of WP 3.4) and allows
	* you to add new sections and controls to the Theme Customize screen.
	* 
	* Note: To enable instant preview, we have to actually write a bit of custom
	* javascript. See live_preview() for more.
	*	
	* @see add_action('customize_register',$func)
	* @param \WP_Customize_Manager $wp_customize
	* @link http://ottopress.com/2012/how-to-leverage-the-theme-customizer-in-your-own-themes/
	* @since problogger 1.0
	*/
	public static function register ( $wp_customize ) {

		// ================== Layout Options ===================

			// ProBlogger Options Panel
			$wp_customize->add_panel( 'problogger_panel_options', 
				array(
						'title' => __( 'ProBlogger Options', 'problogger' ),
						'priority' => 11,
						'capability' => 'edit_theme_options',
				) 
			);

			// ================== Top Nav ===================
				/*
				// Section - Top Nav Options
				$wp_customize->add_section( 'problogger_section_topnav',
					array(
							'title' => __( 'Top Navbar', 'problogger' ),
							'panel' => 'problogger_panel_options',
							'priority' => 10,
							'capability' => 'edit_theme_options',
							'description' => __('', 'problogger'),
					) 
				);
				// Setting - Top Nav - Show
				$wp_customize->add_setting( 'problogger_settings[show_topnav]',
					array(
							'default' => '1',
							'type' => 'theme_mod',
							'capability' => 'edit_theme_options',
							'transport' => 'refresh',
							'sanitize_callback' => '',
					) 
				);
				// Setting - Top Nav - All Pages
				$wp_customize->add_setting( 'problogger_settings[show_topnav_all]',
					array(
							'default' => '',
							'type' => 'theme_mod',
							'capability' => 'edit_theme_options',
							'transport' => 'refresh',
							'sanitize_callback' => '',
					) 
				);
				// Setting - Top Nav - Alignment
				$wp_customize->add_setting( 'problogger_settings[topnav_alignment]',
					array(
							'default' => 'left',
							'type' => 'theme_mod',
							'capability' => 'edit_theme_options',
							'transport' => 'refresh',
							'sanitize_callback' => '',
					) 
				);
				// Control - Top Nav - Show
				$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'problogger_settings[show_topnav]',
					array(
							'label' => __( 'Show Top Navbar', 'problogger' ),
							'priority' => 10,
							'section' => 'problogger_section_topnav',
							'settings' => 'problogger_settings[show_topnav]',
							'type' => 'checkbox',
					) 
				) );
				// Control - Top Nav - All Pages
				$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'problogger_settings[show_topnav_all]',
					array(
							'label' => __( 'Include Top Navbar on All Pages', 'problogger' ),
							'priority' => 10,
							'section' => 'problogger_section_topnav',
							'settings' => 'problogger_settings[show_topnav_all]',
							'type' => 'checkbox',
					) 
				) );
				// Control - Top Nav - Alignment
				$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'problogger_settings[topnav_alignment]', 
					array(
						'label' => __( 'Menu Align', 'problogger' ),
						'priority' => 10,
						'section' => 'problogger_section_topnav',
						'settings' => 'problogger_settings[topnav_alignment]',
						'description' => __( '', 'problogger' ),
						'type' => 'radio',
						'choices' => array(
							'left' => 'Left',
							'right' => 'Right'
							),
					)
				) );
				*/

			// ================== Masthead ===================

				// Section - Masthead Options
				$wp_customize->add_section( 'problogger_section_masthead',
					array(
							'title' => __( 'Masthead', 'problogger' ),
							'panel' => 'problogger_panel_options',
							'priority' => 10,
							'capability' => 'edit_theme_options',
							'description' => __('', 'problogger'),
					) 
				);
				// Setting - Masthead - Show
				$wp_customize->add_setting( 'problogger_settings[show_masthead]',
					array(
							'default' => '1',
							'type' => 'theme_mod',
							'capability' => 'edit_theme_options',
							'transport' => 'refresh',
							'sanitize_callback' => '',
					) 
				);
				// Control - Masthead - Show
				$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'problogger_settings[show_masthead]',
					array(
							'label' => __( 'Use Custom Masthead', 'problogger' ),
							'priority' => 10,
							'section' => 'problogger_section_masthead',
							'settings' => 'problogger_settings[show_masthead]',
							'type' => 'checkbox',
					) 
				) );
				// Setting - Masthead - Post
				$wp_customize->add_setting( 'problogger_settings[masthead_post]',
					array(
							'default' => problogger_option( 'masthead_post' ),
							'type' => 'theme_mod',
							'capability' => 'edit_theme_options',
							'transport' => 'refresh',
							'sanitize_callback' => '',
					) 
				);
				// Control - Masthead - Post
				$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'problogger_settings[masthead_post]', 
					array(
						'label' => __( 'Select Custom Masthead', 'problogger' ),
						'priority' => 10,
						'section' => 'problogger_section_masthead',
						'settings' => 'problogger_settings[masthead_post]',
						'type' => 'select',
						'choices' => parent::problogger_get_masthead_posts(),
					)
				) );
				// Setting - Masthead - Width
				$wp_customize->add_setting( 'problogger_settings[masthead_width]',
					array(
							'default' => 'container',
							'type' => 'theme_mod',
							'capability' => 'edit_theme_options',
							'transport' => 'refresh',
							'sanitize_callback' => '',
					) 
				);
				// Control - Masthead - Width
				$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'problogger_settings[masthead_width]', 
					array(
						'label' => __( 'Masthead Width', 'problogger' ),
						'priority' => 10,
						'section' => 'problogger_section_masthead',
						'settings' => 'problogger_settings[masthead_width]',
						'description' => __( 'Default is Container Width. Other Options are Full Width with Container Width Content, or Full Width with Full Width Content.', 'problogger' ),
						'type' => 'select',
						'choices' => array(
							'container' => 'Container Width',
							'fullcontain' => 'Full Width + Container',
							'full' => 'Full Width'
							),
					)
				) );



			// ================== Jumbotron ===================

				// Section - Jumbotron Options
				$wp_customize->add_section( 'problogger_section_jumbotron',
					array(
							'title' => __( 'Jumbotron', 'problogger' ),
							'panel' => 'problogger_panel_options',
							'priority' => 10,
							'capability' => 'edit_theme_options',
							'description' => __('The Jumbotron is Bootstrap\'s version of the Hero area. Use this to show a default Jumbotron on all pages. Jumbotron settings can also be over-written page by page for greater control.<br />', 'problogger') . '<a href="'.admin_url('edit.php?post_type=progo_jumbotron').'">Add a new Jumbotron</a>',
					) 
				);
				// Setting - Jumbotron - Width
				$wp_customize->add_setting( 'problogger_settings[jumbotron_width]',
					array(
							'default' => 'container',
							'type' => 'theme_mod',
							'capability' => 'edit_theme_options',
							'transport' => 'refresh',
							'sanitize_callback' => '',
					) 
				);
				// Control - Jumbotron - Width
				$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'problogger_settings[jumbotron_width]', 
					array(
						'label' => __( 'Jumbotron Width', 'problogger' ),
						'priority' => 10,
						'section' => 'problogger_section_jumbotron',
						'settings' => 'problogger_settings[jumbotron_width]',
						'description' => __( 'Default is Container Width. Other Options are Full Width with Container Width Content, or Full Width with Full Width Content.', 'problogger' ),
						'type' => 'select',
						'choices' => array(
							'container' => 'Container Width',
							'fullcontain' => 'Full Width + Container',
							'full' => 'Full Width'
							),
					)
				) );

			// ================== Featured In ===================

				// Setting - Featured In - Show
				$wp_customize->add_setting( 'problogger_settings[show_featuredin]',
					array(
							'default' => '1',
							'type' => 'theme_mod',
							'capability' => 'edit_theme_options',
							'transport' => 'refresh',
							'sanitize_callback' => '',
					) 
				);

	
		// ================== CTA Widget Options ===================

			// Panel - ProBlogger CTA Widget
			$wp_customize->add_panel( 'problogger_panel_cta', 
				array(
						'title' => __( 'Call-To-Action Widget', 'problogger' ),
						'priority' => 115,
						'capability' => 'edit_theme_options',
				) 
			);

			// Section - CTA Widget - Options
			$wp_customize->add_section( 'problogger_section_cta_widget',
				array(
						'title' => __( 'Display', 'problogger' ),
						'panel' => 'problogger_panel_cta',
						'priority' => 10,
						'capability' => 'edit_theme_options',
				) 
			);
			// Section - CTA Widget - Content
			$wp_customize->add_section( 'problogger_section_cta_content',
				array(
						'title' => __( 'Content', 'problogger' ),
						'panel' => 'problogger_panel_cta',
						'priority' => 11,
						'capability' => 'edit_theme_options',
						'description' => __('Customize your Call-To-Action Widget content.', 'problogger'),
				) 
			);
			// Section - CTA Widget - Form
			$wp_customize->add_section( 'problogger_section_cta_form',
				array(
						'title' => __( 'Contact Form', 'problogger' ),
						'panel' => 'problogger_panel_cta',
						'priority' => 12,
						'capability' => 'edit_theme_options',
						'description' => __('Select the form options to display in the widget.', 'problogger'),
				) 
			);

			// Setting - CTA Widget - Show
			$wp_customize->add_setting( 'problogger_settings[cta_show]',
				array(
						'default' => '1',
						'type' => 'theme_mod',
						'capability' => 'edit_theme_options',
						'transport' => 'refresh',
						'sanitize_callback' => '',
				) 
			);
			// Setting - CTA Widget - Guests Only
			$wp_customize->add_setting( 'problogger_settings[cta_guest_mode]',
				array(
						'default' => '1',
						'type' => 'theme_mod',
						'capability' => 'edit_theme_options',
						'transport' => 'refresh',
						'sanitize_callback' => '',
				) 
			);
			// Setting - CTA Widget - Form Type (radio: Custom, Gravity Form)
			$wp_customize->add_setting( 'problogger_settings[cta_form_type]',
				array(
						'default' => 'custom',
						'type' => 'theme_mod',
						'capability' => 'edit_theme_options',
						'transport' => 'refresh',
						'sanitize_callback' => '',
				) 
			);
			// Setting - CTA Widget - Form Custom HTML
			$wp_customize->add_setting( 'problogger_settings[cta_form_custom]',
				array(
						'default' => '',
						'type' => 'theme_mod',
						'capability' => 'edit_theme_options',
						'transport' => 'refresh',
						'sanitize_callback' => '',
				) 
			);
			// Setting - CTA Widget - Form GForms ID
			$wp_customize->add_setting( 'problogger_settings[cta_form_gform_id]',
				array(
						'default' => '',
						'type' => 'theme_mod',
						'capability' => 'edit_theme_options',
						'transport' => 'refresh',
						'sanitize_callback' => '',
				) 
			);
			// Setting - CTA Widget - Header Text
			$wp_customize->add_setting( 'problogger_settings[cta_header_text]',
				array(
						'default' => 'ProBlogger Header Text',
						'type' => 'theme_mod',
						'capability' => 'edit_theme_options',
						'transport' => 'refresh',
						'sanitize_callback' => '',
				) 
			);
			// Setting - CTA Widget - Sub-Header Text
			$wp_customize->add_setting( 'problogger_settings[cta_subheader_text]',
				array(
						'default' => 'Your professional blog sub-header text',
						'type' => 'theme_mod',
						'capability' => 'edit_theme_options',
						'transport' => 'refresh',
						'sanitize_callback' => '',
				) 
			);
			// Setting - CTA Widget - Testimonial text
			$wp_customize->add_setting( 'problogger_settings[cta_testimonial_text]',
				array(
						'default' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras efficitur nisi sit amet turpis porta, id aliquam mauris eleifend. Aliquam feugiat augue ut consequat laoreet.',
						'type' => 'theme_mod',
						'capability' => 'edit_theme_options',
						'transport' => 'refresh',
						'sanitize_callback' => '',
				) 
			);
			// Setting - CTA Widget - Testimonial Citation
			$wp_customize->add_setting( 'problogger_settings[cta_testimonial_citation]',
				array(
						'default' => 'The ProGo Team',
						'type' => 'theme_mod',
						'capability' => 'edit_theme_options',
						'transport' => 'refresh',
						'sanitize_callback' => '',
				) 
			);
			// Setting - CTA Widget - Testimonial Image
			$wp_customize->add_setting( 'problogger_settings[cta_testimonial_image]',
				array(
						'default' => '',
						'type' => 'theme_mod',
						'capability' => 'edit_theme_options',
						'transport' => 'refresh',
						'sanitize_callback' => '',
				) 
			);
			// Setting - CTA Widget - Footer / Privacy Policy
			$wp_customize->add_setting( 'problogger_settings[cta_footer]',
				array(
						'default' => 'Powered by ProGo ProBlogger. Add your <a href="#">Privacy Policy</a> here.',
						'type' => 'theme_mod',
						'capability' => 'edit_theme_options',
						'transport' => 'refresh',
						'sanitize_callback' => '',
				) 
			);
			// Setting - CTA Widget - Color Arrow
			$wp_customize->add_setting( 'problogger_settings[cta_color_arrow]',
				array(
						'default' => 'custom',
						'type' => 'theme_mod',
						'capability' => 'edit_theme_options',
						'transport' => 'refresh',
						'sanitize_callback' => '',
				) 
			);
			// Setting - CTA Widget - Color Arrow Text
			$wp_customize->add_setting( 'problogger_settings[cta_color_text]',
				array(
						'default' => 'custom',
						'type' => 'theme_mod',
						'capability' => 'edit_theme_options',
						'transport' => 'refresh',
						'sanitize_callback' => '',
				) 
			);
			// Setting - CTA Widget - Color Background
			$wp_customize->add_setting( 'problogger_settings[cta_color_background]',
				array(
						'default' => 'custom',
						'type' => 'theme_mod',
						'capability' => 'edit_theme_options',
						'transport' => 'refresh',
						'sanitize_callback' => '',
				) 
			);
			// Setting - CTA Widget - Color Testimonial
			$wp_customize->add_setting( 'problogger_settings[cta_color_testimonial]',
				array(
						'default' => 'custom',
						'type' => 'theme_mod',
						'capability' => 'edit_theme_options',
						'transport' => 'refresh',
						'sanitize_callback' => '',
				) 
			);

			// Control - CTA Widget - Show
			$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'problogger_settings[cta_show]',
				array(
						'label' => __( 'Show CTA Widget', 'problogger' ),
						'priority' => 10,
						'section' => 'problogger_section_cta_widget',
						'settings' => 'problogger_settings[cta_show]',
						'type' => 'checkbox',
				) 
			) );
			// Control - CTA Widget - Guest Mode
			$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'problogger_settings[cta_guest_mode]',
				array(
						'label' => __( 'Guest Mode', 'problogger' ),
						'priority' => 11,
						'section' => 'problogger_section_cta_widget',
						'settings' => 'problogger_settings[cta_guest_mode]',
						'type' => 'checkbox',
						'description' => __( 'Hides widget from logged in users. Only site guests will see Call-To-Action widget.', 'problogger' ),
				) 
			) );
			// Control - CTA Widget - Form type
			$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'problogger_settings[cta_form_type]',
				array(
						'label' => __( 'Conversion Form Type', 'problogger' ),
						'priority' => 10,
						'section' => 'problogger_section_cta_form',
						'settings' => 'problogger_settings[cta_form_type]',
						'type' => 'radio',
						'choices' => array(
							'custom' => 'Custom Code',
							'gforms' => 'Gravity Forms'
							),
						'description' => __( 'Add your own custom form code, or use Gravity Forms.', 'problogger' ),
				) 
			) );
			// Control - CTA Widget - Custom Form Settings
			$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'problogger_settings[cta_form_custom]',
				array(
						'label' => __( 'Custom Form HTML', 'problogger' ),
						'priority' => 12,
						'section' => 'problogger_section_cta_form',
						'settings' => 'problogger_settings[cta_form_custom]',
						'type' => 'textarea',
						'description' => __( 'Add your custom form HTML <code>&lt;form&gt;</code>', 'problogger' ),
				) 
			) );
			// Control - CTA Widget - Gravity Form ID
			$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'problogger_settings[cta_form_gform_id]',
				array(
						'label' => __( 'Gravity Form ID', 'problogger' ),
						'priority' => 12,
						'section' => 'problogger_section_cta_form',
						'settings' => 'problogger_settings[cta_form_gform_id]',
						'type' => 'number',
						'description' => __( 'Add the ID number of the Gravity Form you would like to use in the widget.', 'problogger' ),
				) 
			) );
			// Control - CTA Widget - Header Text
			$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'problogger_settings[cta_header_text]',
				array(
						'label' => __( 'Header Text', 'problogger' ),
						'priority' => 10,
						'section' => 'problogger_section_cta_content',
						'settings' => 'problogger_settings[cta_header_text]',
						'type' => 'text',
						'description' => __( 'This <b>bold</b> text appears at the top of the CTA widget.', 'problogger' ),
				) 
			) );
			// Control - CTA Widget - Sub-Header Text
			$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'problogger_settings[cta_subheader_text]',
				array(
						'label' => __( 'Sub-Header Text', 'problogger' ),
						'priority' => 11,
						'section' => 'problogger_section_cta_content',
						'settings' => 'problogger_settings[cta_subheader_text]',
						'type' => 'text',
						'description' => __( 'This text will appear directly below the Header text above.', 'problogger' ),
				) 
			) );
			// Control - CTA Widget - Testimonial Text
			$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'problogger_settings[cta_testimonial_text]',
				array(
						'label' => __( 'Testimonial / Quote', 'problogger' ),
						'priority' => 12,
						'section' => 'problogger_section_cta_content',
						'settings' => 'problogger_settings[cta_testimonial_text]',
						'type' => 'textarea',
						'description' => __( 'Add your favorite testimonial or quote. Or add more copy to your Call-To-Action.', 'problogger' ),
				) 
			) );
			// Control - CTA Widget - Testimonial Citation
			$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'problogger_settings[cta_testimonial_citation]',
				array(
						'label' => __( 'Citation', 'problogger' ),
						'priority' => 13,
						'section' => 'problogger_section_cta_content',
						'settings' => 'problogger_settings[cta_testimonial_citation]',
						'type' => 'text',
						'description' => __( 'For testimonials and quotes. Ex: Mr. &amp; Mrs. John Smith', 'problogger' ),
				) 
			) );
			// Control - CTA Widget - Testimonial Image
			$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'problogger_settings[cta_testimonial_image]',
				array(
						'label' => __( 'Image', 'problogger' ),
						'priority' => 14,
						'section' => 'problogger_section_cta_content',
						'settings' => 'problogger_settings[cta_testimonial_image]',
						'description' => __( 'Call-To-Action image. For example, add a headshot for testimonials or quotes, or add a product image, etc.', 'problogger' ),
				) 
			) );
			// Control - CTA Widget - Footer
			$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'problogger_settings[cta_footer]',
				array(
						'label' => __( 'Footer / Privacy Policy', 'problogger' ),
						'priority' => 15,
						'section' => 'problogger_section_cta_content',
						'settings' => 'problogger_settings[cta_footer]',
						'type' => 'textarea',
						'description' => __( 'Add footer text and a link to your privacy policy here. Accepts basic HTML markup.', 'problogger' ),
				) 
			) );

		// ================== Footer Options ===================		
			/*
			// Setting - Footer - Powered By
			$wp_customize->add_setting( 'problogger_settings[footer_powered_by]', //No need to use a SERIALIZED name, as `theme_mod` settings already live under one db record
				array(
						'default' => false, //Default setting/value to save
						'type' => 'theme_mod', //Is this an 'option' or a 'theme_mod'?
						'capability' => 'edit_theme_options', //Optional. Special permissions for accessing this setting.
						'transport' => 'postMessage', //What triggers a refresh of the setting? 'refresh' or 'postMessage' (instant)?
				) 
			);

			// Control - Footer - Powered By
			$wp_customize->add_control( new WP_Customize_Control( //Instantiate the color control class
				$wp_customize, //Pass the $wp_customize object (required)
				'problogger_settings[footer_powered_by]', //Set a unique ID for the control
				array(
						'label' => __( 'Show "Powered By..." Bar', 'problogger' ), //Admin-visible name of the control
						'priority' => 20, //Determines the order this control appears in for the specified section
						'section' => 'pgb_options[footer]', //ID of the section this control should render in (can be one of yours, or a WordPress default section)
						'settings' => 'problogger_settings[footer_powered_by]', //Which setting to load and manipulate (serialized is okay)
						'type' => 'checkbox',
				) 
			) );
			*/



		//4. We can also change built-in settings by modifying properties. For instance, let's make some stuff use live preview JS...
		//$wp_customize->get_setting( 'blogname' )->transport = 'postMessage';
		//$wp_customize->get_setting( 'blogdescription' )->transport = 'postMessage';
		//$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';
		//$wp_customize->get_setting( 'background_color' )->transport = 'postMessage';
	}

	/**
	* This will output the custom WordPress settings to the live theme's WP head.
	* 
	* Used by hook: 'wp_head'
	* 
	* @see add_action('wp_head',$func)
	* @since problogger 1.0
	*/
	public static function header_output() {
		?>
		<!--Customizer CSS--> 
		<style type="text/css">
				<?php self::generate_css('#site-title a', 'color', 'header_textcolor', '#'); ?> 
				<?php self::generate_css('body', 'background-color', 'background_color', '#'); ?> 
				<?php self::generate_css('a', 'color', 'link_textcolor'); ?>
		</style> 
		<!--/Customizer CSS-->
		<?php
	}

	/**
	* This outputs the javascript needed to automate the live settings preview.
	* Also keep in mind that this function isn't necessary unless your settings 
	* are using 'transport'=>'postMessage' instead of the default 'transport'
	* => 'refresh'
	* 
	* Used by hook: 'customize_preview_init'
	* 
	* @see add_action('customize_preview_init',$func)
	* @since problogger 1.0
	*/
	public static function live_preview() {
		wp_enqueue_script( 
				'problogger-themecustomizer', // Give the script a unique ID
				get_template_directory_uri() . '/assets/js/theme-customizer.js', // Define the path to the JS file
				array(	'jquery', 'customize-preview' ), // Define dependencies
				'', // Define a version (optional) 
				true // Specify whether to put in footer (leave this true)
		);
	}

	/**
	 * This will generate a line of CSS for use in header output. If the setting
	 * ($mod_name) has no defined value, the CSS will not be output.
	 * 
	 * @uses get_theme_mod()
	 * @param string $selector CSS selector
	 * @param string $style The name of the CSS *property* to modify
	 * @param string $mod_name The name of the 'theme_mod' option to fetch
	 * @param string $prefix Optional. Anything that needs to be output before the CSS property
	 * @param string $postfix Optional. Anything that needs to be output after the CSS property
	 * @param bool $echo Optional. Whether to print directly to the page (default: true).
	 * @return string Returns a single line of CSS with selectors and a property.
	 * @since problogger 1.0
	 */
	public static function generate_css( $selector, $style, $mod_name, $prefix='', $postfix='', $echo=true ) {
		$return = '';
		$mod = get_theme_mod($mod_name);
		if ( ! empty( $mod ) ) {
			$return = sprintf('%s { %s:%s; }',
					$selector,
					$style,
					$prefix.$mod.$postfix
			);
			if ( $echo ) {
					echo $return;
			}
		}
		return $return;
	}

}
