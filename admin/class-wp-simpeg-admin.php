<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://github.com/agusnurwanto
 * @since      1.0.0
 *
 * @package    Wp_Simpeg
 * @subpackage Wp_Simpeg/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Wp_Simpeg
 * @subpackage Wp_Simpeg/admin
 * @author     Agus Nurwanto <agusnurwantomuslim@gmail.com>
 */

use Carbon_Fields\Container;
use Carbon_Fields\Field;

class Wp_Simpeg_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Wp_Simpeg_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Wp_Simpeg_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/wp-simpeg-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Wp_Simpeg_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Wp_Simpeg_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/wp-simpeg-admin.js', array( 'jquery' ), $this->version, false );

	}

	// https://www.wpbeginner.com/wp-tutorials/how-to-create-custom-post-types-in-wordpress/
	function simpeg_create_posttype() {
	    register_post_type( 'Instansi',
	        array(
	            'labels' => array(
	                'name' => __( 'Instansi' ),
	                'singular_name' => __( 'Instansi' )
	            ),
	            'hierarchical'        => false,
		        'public'              => true,
		        'show_ui'             => true,
		        'show_in_menu'        => true,
		        'show_in_nav_menus'   => true,
		        'show_in_admin_bar'   => true,
		        'menu_position'       => 5,
		        'can_export'          => true,
		        'has_archive'         => true,
		        'exclude_from_search' => false,
		        'publicly_queryable'  => true,
		        'capability_type'     => 'post',
		        'show_in_rest' 		  => true,
	            'rewrite' 			  => array('slug' => 'instansi'),
        		'supports'            => array( 'title', 'editor', 'author', 'thumbnail', 'comments', 'revisions', 'custom-fields', ),
	        )
	    );
	}

	// https://docs.carbonfields.net/#/fields/select
	function simpeg_istansi_meta(){
		$user_all = get_users();
		$users = array();
		foreach ($user_all as $k => $v) {
			$users[$v->ID] = $v->data->display_name.' ('.implode(',', $v->roles).')';
		}
		Container::make( 'post_meta', __( 'Detail Instansi' ) )
	    ->add_fields( array(
	        Field::make( 'select', 'simpeg_instansi_kepala', __( 'Kepala Instansi' ) )
	        ->add_options( $users ),
	        Field::make( 'html', 'simpeg_instansi', __( '' ) )
	    ) );
	}

	function nama_kepala(){
		$id_kepala = carbon_get_post_meta( get_the_ID(), 'simpeg_instansi_kepala' );
		$kepala = get_user_by('id', $id_kepala);
		return $kepala->display_name;
	}

}
