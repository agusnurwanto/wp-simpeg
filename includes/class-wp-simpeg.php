<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       https://github.com/agusnurwanto
 * @since      1.0.0
 *
 * @package    Wp_Simpeg
 * @subpackage Wp_Simpeg/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Wp_Simpeg
 * @subpackage Wp_Simpeg/includes
 * @author     Agus Nurwanto <agusnurwantomuslim@gmail.com>
 */
class Wp_Simpeg {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Wp_Simpeg_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {
		if ( defined( 'WP_SIMPEG_VERSION' ) ) {
			$this->version = WP_SIMPEG_VERSION;
		} else {
			$this->version = '1.0.0';
		}
		$this->plugin_name = 'wp-simpeg';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();

	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Wp_Simpeg_Loader. Orchestrates the hooks of the plugin.
	 * - Wp_Simpeg_i18n. Defines internationalization functionality.
	 * - Wp_Simpeg_Admin. Defines all hooks for the admin area.
	 * - Wp_Simpeg_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-wp-simpeg-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-wp-simpeg-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-wp-simpeg-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-wp-simpeg-public.php';

		$this->loader = new Wp_Simpeg_Loader();

		// Functions tambahan
		require_once plugin_dir_path(dirname(__FILE__)) . 'includes/class-wp-simpeg-functions.php';

		$this->functions = new SIMPEG_Functions( $this->plugin_name, $this->version );

		$this->loader->add_action('template_redirect', $this->functions, 'allow_access_private_post', 0);

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Wp_Simpeg_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Wp_Simpeg_i18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		$plugin_admin = new Wp_Simpeg_Admin( $this->get_plugin_name(), $this->get_version(), $this->functions );

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );
		$this->loader->add_action( 'init', $plugin_admin, 'simpeg_create_posttype' );
		$this->loader->add_action('carbon_fields_register_fields', $plugin_admin, 'crb_simpeg_options');
		$this->loader->add_action('admin_notices',  $plugin_admin, 'wp_simpeg_admin_notice');

		$this->loader->add_action('wp_ajax_import_excel_simpeg_pegawai',  $plugin_admin, 'import_excel_simpeg_pegawai');
		$this->loader->add_action('wp_ajax_import_excel_sbu_lembur',  $plugin_admin, 'import_excel_sbu_lembur');
		$this->loader->add_action('wp_ajax_generate_user_simpeg',  $plugin_admin, 'generate_user_simpeg');

		add_shortcode('nama_kepala', array($plugin_admin, 'nama_kepala'));
	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new Wp_Simpeg_Public( $this->get_plugin_name(), $this->get_version(), $this->functions );

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );

		$this->loader->add_action('wp_ajax_get_datatable_pegawai', $plugin_public, 'get_datatable_pegawai');
		$this->loader->add_action('wp_ajax_hapus_data_pegawai_by_id', $plugin_public, 'hapus_data_pegawai_by_id');
		$this->loader->add_action('wp_ajax_get_data_pegawai_by_id', $plugin_public, 'get_data_pegawai_by_id');
		$this->loader->add_action('wp_ajax_tambah_data_pegawai', $plugin_public, 'tambah_data_pegawai');

		$this->loader->add_action('wp_ajax_get_datatable_sbu_lembur', $plugin_public, 'get_datatable_sbu_lembur');
		$this->loader->add_action('wp_ajax_hapus_data_sbu_lembur_by_id', $plugin_public, 'hapus_data_sbu_lembur_by_id');
		$this->loader->add_action('wp_ajax_get_data_sbu_lembur_by_id', $plugin_public, 'get_data_sbu_lembur_by_id');
		$this->loader->add_action('wp_ajax_tambah_data_sbu_lembur', $plugin_public, 'tambah_data_sbu_lembur');

		$this->loader->add_action('wp_ajax_get_datatable_data_spt_lembur', $plugin_public, 'get_datatable_data_spt_lembur');
		$this->loader->add_action('wp_ajax_hapus_data_spt_lembur_by_id', $plugin_public, 'hapus_data_spt_lembur_by_id');
		$this->loader->add_action('wp_ajax_get_data_spt_lembur_by_id', $plugin_public, 'get_data_spt_lembur_by_id');
		$this->loader->add_action('wp_ajax_tambah_data_spt_lembur', $plugin_public, 'tambah_data_spt_lembur');

		$this->loader->add_action('wp_ajax_get_datatable_data_spj', $plugin_public, 'get_datatable_data_spj');
		$this->loader->add_action('wp_ajax_hapus_data_spj_by_id', $plugin_public, 'hapus_data_spj_by_id');
		$this->loader->add_action('wp_ajax_get_data_spj_by_id', $plugin_public, 'get_data_spj_by_id');
		$this->loader->add_action('wp_ajax_tambah_data_spj', $plugin_public, 'tambah_data_spj');

		$this->loader->add_action('wp_ajax_get_skpd_simpeg', $plugin_public, 'get_skpd_simpeg');
		$this->loader->add_action('wp_ajax_get_pegawai_simpeg', $plugin_public, 'get_pegawai_simpeg');
		$this->loader->add_action('wp_ajax_get_data_sbu_lembur', $plugin_public, 'get_data_sbu_lembur');

		$this->loader->add_action('wp_ajax_run_sql_migrate_wp_simpeg', $plugin_public, 'run_sql_migrate_wp_simpeg');

		add_shortcode('management_data_pegawai_simpeg', array($plugin_public, 'management_data_pegawai_simpeg'));
		add_shortcode('management_data_sbu_lembur', array($plugin_public, 'management_data_sbu_lembur'));
		add_shortcode('laporan_bulanan_lembur', array($plugin_public, 'laporan_bulanan_lembur'));
		add_shortcode('laporan_spt_lembur', array($plugin_public, 'laporan_spt_lembur'));
		add_shortcode('input_spt_lembur', array($plugin_public, 'input_spt_lembur'));
		add_shortcode('input_spj_lembur', array($plugin_public, 'input_spj_lembur'));
		add_shortcode('monitoring_sql_migrate_wp_simpeg', array($plugin_public, 'monitoring_sql_migrate_wp_simpeg'));

	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Wp_Simpeg_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

}