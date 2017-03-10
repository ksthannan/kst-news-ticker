<?php

/**
 * WordPress settings API demo class
 *
 * @author Tareq Hasan
 */
if ( !class_exists('WeDevs_Settings_API_Test' ) ):
class WeDevs_Settings_API_Test {

    private $settings_api;

    function __construct() {
        $this->settings_api = new WeDevs_Settings_API;

        add_action( 'admin_init', array($this, 'admin_init') );
        add_action( 'admin_menu', array($this, 'admin_menu') );
    }

    function admin_init() {

        //set the settings
        $this->settings_api->set_sections( $this->get_settings_sections() );
        $this->settings_api->set_fields( $this->get_settings_fields() );

        //initialize settings
        $this->settings_api->admin_init();
    }

    function admin_menu() {
        add_options_page( 'KST News Ticker Setting', 'KST News Ticker Setting', 'delete_posts', 'settings_api_test', array($this, 'plugin_page') );
    }

    function get_settings_sections() {
        $sections = array(
            array(
                'id'    => 'kst_ticker_basics',
                'title' => __( 'Basic Settings', 'wedevs' )
            ),
            array(
                'id'    => 'kst_ticker_color',
                'title' => __( 'Color Setting', 'wedevs' )
            )

        );
        return $sections;
    }

    /**
     * Returns all the settings fields
     *
     * @return array settings fields
     */

    function get_settings_fields() {


		
        $settings_fields = array(
            'kst_ticker_basics' => array(

                array(
                    'name'              => 'text_val',
                    'label'             => __( 'Post type name', 'wedevs' ),
                    'desc'              => __( 'Please write here post type name', 'wedevs' ),
                    'placeholder'       => __( 'example : post', 'wedevs' ),
                    'type'              => 'text',
                    'default'           => 'post',
                    'sanitize_callback' => 'sanitize_text_field'
                ),
                array(
                    'name'              => 'number_input',
                    'label'             => __( 'Post per page', 'wedevs' ),
                    'desc'              => __( 'Write here post per page that you want to show', 'wedevs' ),
                    'placeholder'       => __( 'example : 10', 'wedevs' ),
                    'min'               => 0,
                    'max'               => 1000,
                    'step'              => '1',
                    'type'              => 'number',
                    'default'           => 10,
                    'sanitize_callback' => 'floatval'
                ),
                array(
                    'name'              => 'head_text',
                    'label'             => __( 'Headline static text', 'wedevs' ),
                    'desc'              => __( 'Please write here Headline static text', 'wedevs' ),
                    'placeholder'       => __( 'example : Headline', 'wedevs' ),
                    'type'              => 'text',
                    'default'           => 'Headline',
                    'sanitize_callback' => 'sanitize_text_field'
                ),	
                array(
                    'name'              => 'head_text_none',
                    'label'             => __( 'Post not found text', 'wedevs' ),
                    'desc'              => __( 'Please write here text if post not found', 'wedevs' ),
                    'placeholder'       => __( 'example : Opps, No content are available', 'wedevs' ),
                    'type'              => 'text',
                    'default'           => 'Opps, No content are available',
                    'sanitize_callback' => 'sanitize_text_field'
                )				
            ),
            'kst_ticker_color' => array(
	
                array(
                    'name'    => 'headline_fonts_color',
                    'label'   => __( 'Headline fonts color', 'wedevs' ),
                    'desc'    => __( 'Set here new headline fonts color', 'wedevs' ),
                    'type'    => 'color',
                    'default' => '#fff'
                ),					
                array(
                    'name'    => 'background_color',
                    'label'   => __( 'Headline background color', 'wedevs' ),
                    'desc'    => __( 'Set here Headline background color', 'wedevs' ),
                    'type'    => 'color',
                    'default' => '#3B94CF'
                ),	

                array(
                    'name'    => 'kst_text_fonts_color',
                    'label'   => __( 'Scroll line fonts color', 'wedevs' ),
                    'desc'    => __( 'Set here new Text fonts color', 'wedevs' ),
                    'type'    => 'color',
                    'default' => '#3B94CF'
                ),
                array(
                    'name'    => 'kst_text_fonts_background_color',
                    'label'   => __( 'Text fonts background color', 'wedevs' ),
                    'desc'    => __( 'Set here new Text fonts background color', 'wedevs' ),
                    'type'    => 'color',
                    'default' => '#fff'
                ),	
                array(
                    'name'    => 'kst_text_hover_color',
                    'label'   => __( 'Text hover color', 'wedevs' ),
                    'desc'    => __( 'Set here new Text hover color', 'wedevs' ),
                    'type'    => 'color',
                    'default' => '#2693D5'
                ),	
                array(
                    'name'    => 'kst_total_background_color',
                    'label'   => __( 'KST News Ticker extra background color', 'wedevs' ),
                    'desc'    => __( 'Set here new Text extra background color', 'wedevs' ),
                    'type'    => 'color',
                    'default' => '#fff'
                ),		
                array(
                    'name'    => 'kst_bullet_file',
                    'label'   => __( 'Bullet Image', 'wedevs' ),
                    'desc'    => __( 'Bullet Image (max size must be 10*10)', 'wedevs' ),
                    'type'    => 'file',
                    'default' => TICKER_PLUGIN_URL.'img/bullet.png',
                    'options' => array(
                        'button_label' => 'Choose Image'
                    )
                )				
            ),

            
			
        );

        return $settings_fields;
    }

    function plugin_page() {
        echo '<div class="wrap">';

        $this->settings_api->show_navigation();
        $this->settings_api->show_forms();

        echo '</div>';
    }

    /**
     * Get all the pages
     *
     * @return array page names with key value pairs
     */
    function get_pages() {
        $pages = get_pages();
        $pages_options = array();
        if ( $pages ) {
            foreach ($pages as $page) {
                $pages_options[$page->ID] = $page->post_title;
            }
        }

        return $pages_options;
    }

}
endif;



