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
	public function __construct( $plugin_name, $version, $functions ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
		$this->functions = $functions;

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

		wp_enqueue_script( $this->plugin_name.'jszip', plugin_dir_url( __FILE__ ) . 'js/jszip.js', array( 'jquery' ), $this->version, false );
		wp_enqueue_script( $this->plugin_name.'xlsx', plugin_dir_url( __FILE__ ) . 'js/xlsx.js', array( 'jquery' ), $this->version, false );
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
	function crb_simpeg_options(){

		$management_data_pegawai = $this->functions->generatePage(array(
			'nama_page' => 'Management Data Pegawai',
			'content' => '[management_data_pegawai_simpeg]',
			'show_header' => 1,
			'no_key' => 1,
			'post_status' => 'private'
		));
		$input_spt_lembur = $this->functions->generatePage(array(
			'nama_page' => 'Input SPT Lembur',
			'content' => '[input_spt_lembur]',
			'show_header' => 1,
			'no_key' => 1,
			'post_status' => 'private'
		));
		$input_spj_lembur = $this->functions->generatePage(array(
			'nama_page' => 'Input SPJ Lembur',
			'content' => '[input_spj_lembur]',
			'show_header' => 1,
			'no_key' => 1,
			'post_status' => 'private'
		));
		$management_data_sbu_lembur = $this->functions->generatePage(array(
			'nama_page' => 'Management Data SBU Lembur',
			'content' => '[management_data_sbu_lembur]',
			'show_header' => 1,
			'no_key' => 1,
			'post_status' => 'private'
		));
		$laporan_bulanan_lembur = $this->functions->generatePage(array(
			'nama_page' => 'Laporan Bulanan Lembur',
			'content' => '[laporan_bulanan_lembur]',
			'show_header' => 1,
			'no_key' => 1,
			'post_status' => 'private'
		));
		$laporan_spt_lembur = $this->functions->generatePage(array(
			'nama_page' => 'Laporan Surat Perintah Tugas',
			'content' => '[laporan_spt_lembur]',
			'show_header' => 1,
			'no_key' => 1,
			'post_status' => 'private'
		));
		$url_sql_migrate = $this->functions->generatePage(array(
			'nama_page' => 'Monitoring SQL migrate WP-SIMPEG',
			'content' => '[monitoring_sql_migrate_wp_simpeg]',
			'show_header' => 1,
			'no_key' => 1,
			'post_status' => 'private'
		));

		$api_key = get_option(SIMPEG_APIKEY);
		if(empty($api_key)){
			$api_key = $this->functions->generateRandomString();
			update_option(SIMPEG_APIKEY, $api_key);
		}

		$basic_options_container = Container::make( 'theme_options', __( 'SIMPEG Options' ) )
			->set_page_menu_position( 4 )
			->add_fields( array(
	        	Field::make( 'html', 'crb_simpeg_html' )
	        		->set_html( 'Settings SIMPEG'),
	        Field::make( 'html', 'crb_simpeg_halaman_terkait' )
	        	->set_html( '
				<h5>HALAMAN TERKAIT</h5>
            	<ol>
            		<li><a target="_blank" href="'.$laporan_bulanan_lembur['url'].'">'.$laporan_bulanan_lembur['title'].'</a></li>
            		<li><a target="_blank" href="'.$laporan_spt_lembur['url'].'">'.$laporan_spt_lembur['title'].'</a></li>
            		<li><a target="_blank" href="'.$input_spt_lembur['url'].'">'.$input_spt_lembur['title'].'</a></li>
            		<li><a target="_blank" href="'.$input_spj_lembur['url'].'">'.$input_spj_lembur['title'].'</a></li>
            	</ol>
	        	' ),
	            Field::make( 'text', 'crb_apikey_simpeg', 'API KEY' )
	            	->set_default_value($api_key)
	            	->set_help_text('Wajib diisi. API KEY digunakan untuk integrasi data.'),
	            Field::make( 'html', 'crb_sql_migrate_simpeg' )
	            	->set_html( '<a target="_blank" href="'.$url_sql_migrate['url'].'" class="button button-primary button-large">'.$url_sql_migrate['title'].'</a>' )
	            	->set_help_text('Status SQL migrate WP-SIMPEG jika ada update struktur database.'),
	        ) );

		Container::make( 'theme_options', __( 'Data Pegawai' ) )
			->set_page_parent( $basic_options_container )
			->add_fields( array(
		    	Field::make( 'html', 'crb_simpeg_pegawai_hide_sidebar' )
		        	->set_html( '
		        		<style>
		        			.postbox-container { display: none; }
		        			#poststuff #post-body.columns-2 { margin: 0 !important; }
		        		</style>
		        	' ),
		        Field::make( 'html', 'crb_simpeg_halaman_terkait_pegawai' )
		        	->set_html( '
					<h5>HALAMAN TERKAIT</h5>
	            	<ol>
	            		<li><a target="_blank" href="'.$management_data_pegawai['url'].'">'.$management_data_pegawai['title'].'</a></li>
	            	</ol>
		        	' ),
		        Field::make( 'html', 'crb_simpeg_pegawai_upload_html' )
	            	->set_html( '<h3>Import EXCEL data Pegawai</h3>Pilih file excel .xlsx : <input type="file" id="file-excel" onchange="filePickedSatset(event);"><br>Contoh format file excel bisa <a target="_blank" href="'.SIMPEG_PLUGIN_URL. 'excel/contoh_simpeg_pegawai.xlsx">download di sini</a>. Sheet file excel yang akan diimport harus diberi nama <b>data</b>. Untuk kolom nilai angka ditulis tanpa tanda titik.' ),
		        Field::make( 'html', 'crb_simpeg_pegawai' )
	            	->set_html( 'Data JSON : <textarea id="data-excel" class="cf-select__input"></textarea>' ),
		        Field::make( 'html', 'crb_simpeg_pegawai_save_button' )
	            	->set_html( '<a onclick="import_excel_simpeg_pegawai(); return false" href="javascript:void(0);" class="button button-primary">Import WP</a>' )
	        ) );

        Container::make( 'theme_options', __( 'Import SBU Lembur' ) )
		->set_page_parent( $basic_options_container )
		->add_fields( array(
	    	Field::make( 'html', 'crb_sbu_lembur_hide_sidebar' )
	        	->set_html( '
	        		<style>
	        			.postbox-container { display: none; }
	        			#poststuff #post-body.columns-2 { margin: 0 !important; }
	        		</style>
	        	' ),
	        Field::make( 'html', 'crb_simpeg_halaman_terkait_sbu_lembur' )
	        	->set_html( '
				<h5>HALAMAN TERKAIT</h5>
            	<ol>
            		<li><a target="_blank" href="'.$management_data_sbu_lembur['url'].'">'.$management_data_sbu_lembur['title'].'</a></li>
            	</ol>
	        	' ),
	        Field::make( 'html', 'crb_sbu_lembur_upload_html' )
            	->set_html( '<h3>Import EXCEL data SBU Lembur</h3>Pilih file excel .xlsx : <input type="file" id="file-excel" onchange="filePickedSatset(event);"><br>Contoh format file excel bisa <a target="_blank" href="'.SIMPEG_PLUGIN_URL. 'excel/contoh_sbu_lembur.xlsx">download di sini</a>. Sheet file excel yang akan diimport harus diberi nama <b>data</b>. Untuk kolom nilai angka ditulis tanpa tanda titik.' ),
	        Field::make( 'html', 'crb_sbu_lembur' )
            	->set_html( 'Data JSON : <textarea id="data-excel" class="cf-select__input"></textarea>' ),
	        Field::make( 'html', 'crb_sbu_lembur_save_button' )
            	->set_html( '<a onclick="import_excel_sbu_lembur(); return false" href="javascript:void(0);" class="button button-primary">Import WP</a>' )
	        ) );

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

public function import_excel_simpeg_pegawai(){
	global $wpdb;
	$ret = array(
		'status'	=> 'success',
		'message'	=> 'Berhasil import excel!'
	);
		if (!empty($_POST)) {
			$ret['data'] = array(
				'insert' => 0, 
				'update' => 0,
				'error' => array()
		);
			foreach ($_POST['data'] as $k => $data) {
				$newData = array();
				foreach($data as $kk => $vv){
					$newData[trim(preg_replace('/\s+/', ' ', $kk))] = trim(preg_replace('/\s+/', ' ', $vv));
			}
				$data_db = array(
					'id_skpd' => $newData['id_skpd'],
				    'nik' => $newData['nik'],
				    'nip' => $newData['nip'],
				    'nama' => $newData['nama'],
				    'tempat_lahir' => $newData['tempat_lahir'],
				    'tanggal_lahir' => $newData['tanggal_lahir'],
				    'status' => $newData['status'],
				    'gol_ruang' => $newData['gol_ruang'],
				    'tmt_pangkat' => $newData['tmt_pangkat'],
				    'eselon' => $newData['eselon'],
				    'jabatan' => $newData['jabatan'],
				    'tipe_pegawai' => $newData['tipe_pegawai'],
				    'tmt_jabatan' => $newData['tmt_jabatan'],
				    'agama' => $newData['agama'],
				    'no_hp' => $newData['no_hp'],
				    'alamat' => $newData['alamat'],
				    'satuan_kerja' => $newData['satuan_kerja'],
				    'unit_kerja_induk' => $newData['unit_kerja_induk'],
				    'tmt_pensiun' => $newData['tmt_pensiun'],
				    'pendidikan' => $newData['pendidikan'],
				    'kode_pendidikan' => $newData['kode_pendidikan'],
				    'nama_sekolah' => $newData['nama_sekolah'],
				    'nama_pendidikan' => $newData['nama_pendidikan'],
				    'lulus' => $newData['lulus'],
				    'karpeg' => $newData['karpeg'],
				    'karis_karsu' => $newData['karis_karsu'],
				    'nilai_prestasi' => $newData['nilai_prestasi'],
				    'email' => $newData['email'],
				    'tahun' => $newData['tahun']
			);
				$wpdb->last_error = "";
				$cek_id = $wpdb->get_var($wpdb->prepare("
					SELECT 
						id 
					from data_pegawai_lembur 
					where nip=%s"
					, $newData['nip']));
				if(empty($cek_id)){
					$wpdb->insert("data_pegawai_lembur", $data_db);
					$ret['data']['insert']++;
				}else{
					$wpdb->update("data_pegawai_lembur", $data_db, array(
						"id" => $cek_id
					));
					$ret['data']['update']++;
				}
				if(!empty($wpdb->last_error)){
					$ret['data']['error'][] = array($wpdb->last_error, $data_db);
				};

			}
		}else {
			$ret['status'] = 'error';
			$ret['message'] = 'Format Salah!';
		}
		die(json_encode($ret));
	}

public function import_excel_sbu_lembur(){
	global $wpdb;
	$ret = array(
		'status'	=> 'success',
		'message'	=> 'Berhasil import excel!'
	);
		if (!empty($_POST)) {
			$ret['data'] = array(
				'insert' => 0, 
				'update' => 0,
				'error' => array()
		);
			foreach ($_POST['data'] as $k => $data) {
				$newData = array();
				foreach($data as $kk => $vv){
					$newData[trim(preg_replace('/\s+/', ' ', $kk))] = trim(preg_replace('/\s+/', ' ', $vv));
			}
				$data_db = array(
					'kode_standar_harga' => $newData ['kode_standar_harga'],
					'nama' => $newData ['nama'],
					'uraian' => $newData ['uraian'],
					'satuan' => $newData ['satuan'],
					'harga' => $newData ['harga'],
					'id_golongan' => $newData ['id_golongan'],
					'tahun' => $newData ['tahun'],
					'no_aturan' => $newData ['no_aturan'],
					'pph_21' => $newData ['pph_21'],
					'jenis_hari' => $newData ['jenis_hari']
			);
				$wpdb->last_error = "";
				$cek_id = $wpdb->get_var($wpdb->prepare("
					SELECT 
						id 
					from data_sbu_lembur 
					where kode_standar_harga=%s"
					, $newData['kode_standar_harga']));
				if(empty($cek_id)){
					$wpdb->insert("data_sbu_lembur", $data_db);
					$ret['data']['insert']++;
				}else{
					$wpdb->update("data_sbu_lembur", $data_db, array(
						"id" => $cek_id
					));
					$ret['data']['update']++;
				}
				if(!empty($wpdb->last_error)){
					$ret['data']['error'][] = array($wpdb->last_error, $data_db);
				};

			}
		}else {
			$ret['status'] = 'error';
			$ret['message'] = 'Format Salah!';
		}
		die(json_encode($ret));
	}

	function wp_simpeg_admin_notice(){
        $versi = get_option('_wp_simpeg_db_version');
        if($versi !== $this->version){
        	$url_sql_migrate = $this->functions->generatePage(array(
			'nama_page' => 'Monitoring SQL migrate WP-SIMPEG',
			'content' => '[monitoring_sql_migrate_wp_simpeg]',
			'show_header' => 1,
			'no_key' => 1,
			'post_status' => 'private'
		));
        	echo '
        		<div class="notice notice-warning is-dismissible">
	        		<p>Versi database WP-SIMPEG tidak sesuai! harap dimutakhirkan. Versi saat ini=<b>'.$this->version.'</b> dan versi WP-SIMPEG kamu=<b>'.$versi.'</b>. Silahkan update di halaman <a href="'.$url_sql_migrate['url'].'" class="button button-primary button-large">'.$url_sql_migrate['title'].'</a></p>
	         	</div>
	         ';
        }
	}

}
