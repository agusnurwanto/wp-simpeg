<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://github.com/agusnurwanto
 * @since      1.0.0
 *
 * @package    Wp_Simpeg
 * @subpackage Wp_Simpeg/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Wp_Simpeg
 * @subpackage Wp_Simpeg/public
 * @author     Agus Nurwanto <agusnurwantomuslim@gmail.com>
 */
require_once SIMPEG_PLUGIN_PATH . "/public/trait/CustomTrait.php";
class Wp_Simpeg_Public {

	use CustomTraitSimpeg;

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
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version, $functions ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
		$this->functions = $functions;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
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

		wp_enqueue_style($this->plugin_name . 'select2', plugin_dir_url(__FILE__) . 'css/select2.min.css', array(), $this->version, 'all');
		wp_enqueue_style($this->plugin_name . 'datatables', plugin_dir_url(__FILE__) . 'css/datatables.min.css', array(), $this->version, 'all');

		wp_enqueue_style( 'dashicons' );

	}

	public function prefix_add_footer_styles() {
		wp_enqueue_style($this->plugin_name . 'bootstrap', plugin_dir_url(__FILE__) . 'css/bootstrap.min.css', array(), $this->version, 'all');
		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/wp-simpeg-public.css', array(), $this->version, 'all' );
	}


	/**
	 * Register the JavaScript for the public-facing side of the site.
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
		
		wp_enqueue_script($this->plugin_name . 'bootstrap', plugin_dir_url(__FILE__) . 'js/bootstrap.bundle.min.js', array('jquery'), $this->version, false);
		wp_enqueue_script($this->plugin_name . 'select2', plugin_dir_url(__FILE__) . 'js/select2.min.js', array('jquery'), $this->version, false);
		wp_enqueue_script($this->plugin_name . 'datatables', plugin_dir_url(__FILE__) . 'js/datatables.min.js', array('jquery'), $this->version, false);
		wp_enqueue_script($this->plugin_name . 'chart', plugin_dir_url(__FILE__) . 'js/chart.min.js', array('jquery'), $this->version, false);
		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/wp-simpeg-public.js', array( 'jquery' ), $this->version, false );
		wp_localize_script($this->plugin_name, 'ajax', array(
			'api_key' => get_option(SIMPEG_APIKEY),
			'url' => admin_url('admin-ajax.php')
		));
	}

    public function monitoring_sql_migrate_wp_simpeg($atts){
        if(!empty($_GET) && !empty($_GET['post'])){
            return '';
        }
        require_once plugin_dir_path(dirname(__FILE__)) . 'public/partials/wp-simpeg-sql-migrate.php';
    }

    public function management_data_pegawai_simpeg($atts){
        if(!empty($_GET) && !empty($_GET['post'])){
            return '';
        }
        require_once plugin_dir_path(dirname(__FILE__)) . 'public/partials/wp-simpeg-management-data-pegawai.php';
    }

    public function management_data_sbu_lembur($atts){
        if(!empty($_GET) && !empty($_GET['post'])){
            return '';
        }
        require_once plugin_dir_path(dirname(__FILE__)) . 'public/partials/wp-simpeg-management-data-sbu-lembur.php';
    }

    public function input_spt_lembur($atts){
        if(!empty($_GET) && !empty($_GET['post'])){
            return '';
        }
        require_once plugin_dir_path(dirname(__FILE__)) . 'public/partials/wp-simpeg-input-spt-lembur.php';
    }

    public function input_spj_lembur($atts){
        if(!empty($_GET) && !empty($_GET['post'])){
            return '';
        }
        require_once plugin_dir_path(dirname(__FILE__)) . 'public/partials/wp-simpeg-input-spj-lembur.php';
    }


    public function menu_absensi_pegawai_lembur($atts){
        if(!empty($_GET) && !empty($_GET['post'])){
            return '';
        }
        require_once plugin_dir_path(dirname(__FILE__)) . 'public/partials/wp-simpeg-absensi-pegawai-lembur.php';
    }

    public function laporan_bulanan_lembur($atts){
        if(!empty($_GET) && !empty($_GET['post'])){
            return '';
        }
        require_once plugin_dir_path(dirname(__FILE__)) . 'public/partials/wp-simpeg-laporan-bulanan-lembur.php';
    }

    public function laporan_spt_lembur($atts){
        if(!empty($_GET) && !empty($_GET['post'])){
            return '';
        }
        require_once plugin_dir_path(dirname(__FILE__)) . 'public/partials/wp-simpeg-laporan-spt-lembur.php';
    }

    public function laporan_pegawai_lembur($atts){
        if(!empty($_GET) && !empty($_GET['post'])){
            return '';
        }
        require_once plugin_dir_path(dirname(__FILE__)) . 'public/partials/wp-simpeg-laporan-pegawai-lembur.php';
    }

    public function laporan_bulanan_absensi($atts){
        if(!empty($_GET) && !empty($_GET['post'])){
            return '';
        }
        require_once plugin_dir_path(dirname(__FILE__)) . 'public/partials/wp-simpeg-laporan-bulanan-absensi.php';
    }

   public function laporan_bulanan_absensi_pegawai($atts){
       if(!empty($_GET) && !empty($_GET['post'])){
           return '';
       }
       require_once plugin_dir_path(dirname(__FILE__)) . 'public/partials/wp-simpeg-laporan-bulanan-absensi-pegawai.php';
   }

   public function laporan_bulanan_absensi_all($atts){
       if(!empty($_GET) && !empty($_GET['post'])){
           return '';
       }
       require_once plugin_dir_path(dirname(__FILE__)) . 'public/partials/wp-simpeg-laporan-bulanan-absensi-all-pegawai.php';
   }

    public function input_absensi_pegawai($atts){
        if(!empty($_GET) && !empty($_GET['post'])){
            return '';
        }
        require_once plugin_dir_path(dirname(__FILE__)) . 'public/partials/wp-simpeg-input-absensi-pegawai.php';
    }

	function get_simpeg_map_url()
	{
		$api_googlemap = get_option('_crb_google_api_simpeg');
		$api_googlemap = "https://maps.googleapis.com/maps/api/js?key=$api_googlemap&callback=initMapSiks&libraries=places&libraries=drawing";
		return $api_googlemap;
	}

	public function crb_get_gmaps_api_key_simpeg($value = '')
	{
		return get_option('_crb_google_api_simpeg');
	}

	public function get_center()
	{
		$center_map_default = get_option('_crb_google_map_center_simpeg');
		$ret = array(
			'lat' => 0,
			'lng' => 0
		);
		if (!empty($center_map_default)) {
			$center_map_default = explode(',', $center_map_default);
			$ret['lat'] = $center_map_default[0];
			$ret['lng'] = $center_map_default[1];
		}
		return $ret;
	}

	public function get_skpd_simpeg(){
	    global $wpdb;
	    $ret = array(
	        'status' => 'success',
	        'message' => 'Berhasil get data!',
	        'data' => array()
	    );
	    if(!empty($_POST)){
	        if(!empty($_POST['api_key']) && $_POST['api_key'] == get_option( SIMPEG_APIKEY )) {
	            $ret['data'] = $wpdb->get_results($wpdb->prepare('
	                SELECT 
	                    *
	                FROM data_unit_lembur
	                WHERE tahun_anggaran=%d
	                	AND active=1
	            ', $_POST['tahun_anggaran']), ARRAY_A);
	            $html = '<option value="">Pilih SKPD</option>';
	            foreach($ret['data'] as $skpd){
	            	$html .= '<option value="'.$skpd['id_skpd'].'">'.$skpd['kode_skpd'].' '.$skpd['nama_skpd'].' ( ID = '.$skpd['id_skpd'].')</option>';
	            }
	            $ret['html'] = $html;
	        }else{
	            $ret['status']  = 'error';
	            $ret['message'] = 'Api key tidak ditemukan!';
	        }
	    }else{
	        $ret['status']  = 'error';
	        $ret['message'] = 'Format Salah!';
	    }

	    die(json_encode($ret));
	}
	public function get_pegawai_simpeg(){
	    global $wpdb;
	    $ret = array(
	        'status' => 'success',
	        'message' => 'Berhasil get data!',
	        'data' => array()
	    );
	    if(!empty($_POST)){
	        if(!empty($_POST['api_key']) && $_POST['api_key'] == get_option(SIMPEG_APIKEY)) {
	            $tahun_anggaran = $_POST['tahun_anggaran'];
	            $ret['data'] = $wpdb->get_results($wpdb->prepare('
	                SELECT 
	                    *
	                FROM data_pegawai_lembur
	                WHERE id_skpd=%d
	                    AND active=1
	                    AND tahun=%d
	            ', $_POST['id_skpd'], $tahun_anggaran), ARRAY_A);
	            $html = '<option value="">Pilih Pegawai</option>';
	            foreach($ret['data'] as $pegawai){
	                $html .= '<option golongan="'.$pegawai['kode_gol'].'" value="'.$pegawai['id'].'">'.$pegawai['gelar_depan'].' '.$pegawai['nama'].' '.$pegawai['gelar_belakang'].' (ID = '.$pegawai['id'].')</option>';
	            }
	            $ret['html'] = $html;
	        }else{
	            $ret['status']  = 'error';
	            $ret['message'] = 'Api key tidak ditemukan!';
	        }
	    }else{
	        $ret['status']  = 'error';
	        $ret['message'] = 'Format Salah!';
	    }

	    die(json_encode($ret));
	}

	public function get_data_sbu_lembur(){
	    global $wpdb;
	    $ret = array(
	        'status' => 'success',
	        'message' => 'Berhasil get data!',
	        'data' => array()
	    );
	    if(!empty($_POST)){
	        if(!empty($_POST['api_key']) && $_POST['api_key'] == get_option( SIMPEG_APIKEY )) {
	        	$tahun_anggaran = $_POST['tahun_anggaran'];
	            $ret['data'] = $wpdb->get_results($wpdb->prepare('
	                SELECT 
	                    *
	                FROM data_sbu_lembur
	                WHERE active=1
	                	AND tahun=%d
	            ', $tahun_anggaran), ARRAY_A);
	        }else{
	            $ret['status']  = 'error';
	            $ret['message'] = 'Api key tidak ditemukan!';
	        }
	    }else{
	        $ret['status']  = 'error';
	        $ret['message'] = 'Format Salah!';
	    }

	    die(json_encode($ret));
	}

	public function get_data_pegawai_by_id(){
	    global $wpdb;
	    $ret = array(
	        'status' => 'success',
	        'message' => 'Berhasil get data!',
	        'data' => array()
	    );
	    if(!empty($_POST)){
	        if(!empty($_POST['api_key']) && $_POST['api_key'] == get_option( SIMPEG_APIKEY )) {
	            $ret['data'] = $wpdb->get_row($wpdb->prepare('
	                SELECT 
	                    *
	                FROM data_pegawai_lembur
	                WHERE id=%d
	            ', $_POST['id']), ARRAY_A);
	        }else{
	            $ret['status']  = 'error';
	            $ret['message'] = 'Api key tidak ditemukan!';
	        }
	    }else{
	        $ret['status']  = 'error';
	        $ret['message'] = 'Format Salah!';
	    }

	    die(json_encode($ret));
	}

	public function hapus_data_pegawai_by_id(){
	    global $wpdb;
	    $ret = array(
	        'status' => 'success',
	        'message' => 'Berhasil hapus data!',
	        'data' => array()
	    );
	    if(!empty($_POST)){
	        if(!empty($_POST['api_key']) && $_POST['api_key'] == get_option( SIMPEG_APIKEY )) {
	            $ret['data'] = $wpdb->update('data_pegawai_lembur', array('active' => 0), array(
	                'id' => $_POST['id']
	            ));
	        }else{
	            $ret['status']  = 'error';
	            $ret['message'] = 'Api key tidak ditemukan!';
	        }
	    }else{
	        $ret['status']  = 'error';
	        $ret['message'] = 'Format Salah!';
	    }

	    die(json_encode($ret));
	}

	public function tambah_data_pegawai(){
	    global $wpdb;
	    $ret = array(
	        'status' => 'success',
	        'message' => 'Berhasil simpan data!',
	        'data' => array()
	    );
	    if(!empty($_POST)){
	        if(!empty($_POST['api_key']) && $_POST['api_key'] == get_option( SIMPEG_APIKEY )) {
				if (empty($_POST['gelar_depan'])) {
				    $ret['status'] = 'error';
				    $ret['message'] = 'Data gelar_depan tidak boleh kosong!';
				} else if (empty($_POST['gelar_belakang'])) {
				    $ret['status'] = 'error';
				    $ret['message'] = 'Data gelar_belakang tidak boleh kosong!';
				} else if (empty($_POST['nama_lengkap'])) {
				    $ret['status'] = 'error';
				    $ret['message'] = 'Data nama_lengkap tidak boleh kosong!';
				} else if (empty($_POST['jenis_kelamin'])) {
				    $ret['status'] = 'error';
				    $ret['message'] = 'Data jenis_kelamin tidak boleh kosong!';
				} else if (empty($_POST['kode_jenis_kelamin'])) {
				    $ret['status'] = 'error';
				    $ret['message'] = 'Data kode_jenis_kelamin tidak boleh kosong!';
				} else if (empty($_POST['kode_gol'])) {
				    $ret['status'] = 'error';
				    $ret['message'] = 'Data kode_gol tidak boleh kosong!';
				} else if (empty($_POST['id_skpd'])) {
                    $ret['status'] = 'error';
                    $ret['message'] = 'Data id_skpd tidak boleh kosong!';
                } else if (empty($_POST['nik'])) {
                    $ret['status'] = 'error';
                    $ret['message'] = 'Data nik tidak boleh kosong!';
                } else if (empty($_POST['nip'])) {
                    $ret['status'] = 'error';
                    $ret['message'] = 'Data nip tidak boleh kosong!';
                } else if (empty($_POST['nama'])) {
                    $ret['status'] = 'error';
                    $ret['message'] = 'Data nama tidak boleh kosong!';
                } else if (empty($_POST['tempat_lahir'])) {
                    $ret['status'] = 'error';
                    $ret['message'] = 'Data tempat_lahir tidak boleh kosong!';
                } else if (empty($_POST['tanggal_lahir'])) {
                    $ret['status'] = 'error';
                    $ret['message'] = 'Data tanggal_lahir tidak boleh kosong!';
                } else if (empty($_POST['status'])) {
                    $ret['status'] = 'error';
                    $ret['message'] = 'Data status tidak boleh kosong!';
                } else if (empty($_POST['gol_ruang'])) {
                    $ret['status'] = 'error';
                    $ret['message'] = 'Data gol_ruang tidak boleh kosong!';
                } else if (empty($_POST['tmt_pangkat'])) {
                    $ret['status'] = 'error';
                    $ret['message'] = 'Data tmt_pangkat tidak boleh kosong!';
                } else if (empty($_POST['eselon'])) {
                    $ret['status'] = 'error';
                    $ret['message'] = 'Data eselon tidak boleh kosong!';
                } else if (empty($_POST['jabatan'])) {
                    $ret['status'] = 'error';
                    $ret['message'] = 'Data jabatan tidak boleh kosong!';
                } else if (empty($_POST['tipe_pegawai'])) {
                    $ret['status'] = 'error';
                    $ret['message'] = 'Data tipe_pegawai tidak boleh kosong!';
                } else if (empty($_POST['tmt_jabatan'])) {
                    $ret['status'] = 'error';
                    $ret['message'] = 'Data tmt_jabatan tidak boleh kosong!';
                } else if (empty($_POST['agama'])) {
                    $ret['status'] = 'error';
                    $ret['message'] = 'Data agama tidak boleh kosong!';
                } else if (empty($_POST['alamat'])) {
                    $ret['status'] = 'error';
                    $ret['message'] = 'Data alamat tidak boleh kosong!';
                } else if (empty($_POST['no_hp'])) {
                    $ret['status'] = 'error';
                    $ret['message'] = 'Data no_hp tidak boleh kosong!';
                } else if (empty($_POST['satuan_kerja'])) {
                    $ret['status'] = 'error';
                    $ret['message'] = 'Data satuan_kerja tidak boleh kosong!';
                } else if (empty($_POST['unit_kerja_induk'])) {
                    $ret['status'] = 'error';
                    $ret['message'] = 'Data unit_kerja_induk tidak boleh kosong!';
                } else if (empty($_POST['tmt_pensiun'])) {
                    $ret['status'] = 'error';
                    $ret['message'] = 'Data tmt_pensiun tidak boleh kosong!';
                } else if (empty($_POST['pendidikan'])) {
                    $ret['status'] = 'error';
                    $ret['message'] = 'Data pendidikan tidak boleh kosong!';
                } else if (empty($_POST['kode_pendidikan'])) {
                    $ret['status'] = 'error';
                    $ret['message'] = 'Data kode_pendidikan tidak boleh kosong!';
                } else if (empty($_POST['nama_sekolah'])) {
                    $ret['status'] = 'error';
                    $ret['message'] = 'Data nama_sekolah tidak boleh kosong!';
                } else if (empty($_POST['nama_pendidikan'])) {
                    $ret['status'] = 'error';
                    $ret['message'] = 'Data nama_pendidikan tidak boleh kosong!';
                } else if (empty($_POST['lulus'])) {
                    $ret['status'] = 'error';
                    $ret['message'] = 'Data lulus tidak boleh kosong!';
                } else if (empty($_POST['karpeg'])) {
                    $ret['status'] = 'error';
                    $ret['message'] = 'Data karpeg tidak boleh kosong!';
                } else if (empty($_POST['karis_karsu'])) {
                    $ret['status'] = 'error';
                    $ret['message'] = 'Data karis_karsu tidak boleh kosong!';
                } else if (empty($_POST['nilai_prestasi'])) {
                    $ret['status'] = 'error';
                    $ret['message'] = 'Data nilai_prestasi tidak boleh kosong!';
                } else if (empty($_POST['email'])) {
                    $ret['status'] = 'error';
                    $ret['message'] = 'Data email tidak boleh kosong!';
                } else if (empty($_POST['tahun'])) {
                    $ret['status'] = 'error';
                    $ret['message'] = 'Data tahun tidak boleh kosong!';
                } else if (empty($_POST['user_role'])) {
                    $ret['status'] = 'error';
                    $ret['message'] = 'Data user_role tidak boleh kosong!';
                } else {
                	$id_skpd = $_POST['id_skpd'];
		            $nik = $_POST['nik'];
		            $nip = $_POST['nip'];
		            $nama = $_POST['nama'];
		            $tempat_lahir = $_POST['tempat_lahir'];
		            $tanggal_lahir = $_POST['tanggal_lahir'];
		            $status = $_POST['status'];
		            $gol_ruang = $_POST['gol_ruang'];
		            $tmt_pangkat = $_POST['tmt_pangkat'];
		            $eselon = $_POST['eselon'];
		            $jabatan = $_POST['jabatan'];
		            $tipe_pegawai = $_POST['tipe_pegawai'];
		            $tmt_jabatan = $_POST['tmt_jabatan'];
		            $agama = $_POST['agama'];
		            $alamat = $_POST['alamat'];
		            $no_hp = $_POST['no_hp'];
		            $satuan_kerja = $_POST['satuan_kerja'];
		            $unit_kerja_induk = $_POST['unit_kerja_induk'];
		            $tmt_pensiun = $_POST['tmt_pensiun'];
		            $pendidikan = $_POST['pendidikan'];
		            $kode_pendidikan = $_POST['kode_pendidikan'];
		            $nama_sekolah = $_POST['nama_sekolah'];
		            $nama_pendidikan = $_POST['nama_pendidikan'];
		            $lulus = $_POST['lulus'];
		            $karpeg = $_POST['karpeg'];
		            $karis_karsu = $_POST['karis_karsu'];
		            $nilai_prestasi = $_POST['nilai_prestasi'];
		            $email = $_POST['email'];
		            $tahun = $_POST['tahun'];
		            $user_role = $_POST['user_role'];
					$gelar_depan = $_POST['gelar_depan'];
					$gelar_belakang = $_POST['gelar_belakang'];
					$nama_lengkap = $_POST['nama_lengkap'];
					$jenis_kelamin = $_POST['jenis_kelamin'];
					$kode_jenis_kelamin = $_POST['kode_jenis_kelamin'];
					$kode_gol = $_POST['kode_gol'];
	                $data = array(
	                    'id_skpd' => $id_skpd,
	                    'nik' => $nik,
	                    'nip' => $nip,
	                    'nama' => $nama,
	                    'tempat_lahir' => $tempat_lahir,
	                    'tanggal_lahir' => $tanggal_lahir,
	                    'status' => $status,
	                    'gol_ruang' => $gol_ruang,
	                    'tmt_pangkat' => $tmt_pangkat,
	                    'eselon' => $eselon,
	                    'jabatan' => $jabatan,
	                    'tipe_pegawai' => $tipe_pegawai,
	                    'tmt_jabatan' => $tmt_jabatan,
	                    'agama' => $agama,
	                    'alamat' => $alamat,
	                    'no_hp' => $no_hp,
	                    'satuan_kerja' => $satuan_kerja,
	                    'unit_kerja_induk' => $unit_kerja_induk,
	                    'tmt_pensiun' => $tmt_pensiun,
	                    'pendidikan' => $pendidikan,
	                    'kode_pendidikan' => $kode_pendidikan,
	                    'nama_sekolah' => $nama_sekolah,
	                    'nama_pendidikan' => $nama_pendidikan,
	                    'lulus' => $lulus,
	                    'karpeg' => $karpeg,
	                    'karis_karsu' => $karis_karsu,
	                    'nilai_prestasi' => $nilai_prestasi,
	                    'email' => $email,
	                    'tahun' => $tahun,
	                    'user_role' => $user_role,
	                    'gelar_depan' => $gelar_depan,
						'gelar_belakang' => $gelar_belakang,
						'nama_lengkap' => $nama_lengkap,
						'jenis_kelamin' => $jenis_kelamin,
						'kode_jenis_kelamin' => $kode_jenis_kelamin,
						'kode_gol' => $kode_gol,
	                    'active' => 1,
	                    'update_at' => current_time('mysql')
	                );
	                if(!empty($_POST['id_data'])){
	                    $wpdb->update('data_pegawai_lembur', $data, array(
	                        'id' => $_POST['id_data']
	                    ));
	                    $ret['message'] = 'Berhasil update data!';
	                }else{
	                    $cek_id = $wpdb->get_row($wpdb->prepare('
	                        SELECT
	                            id,
	                            active
	                        FROM data_pegawai_lembur
	                        WHERE id_pegawai=%s
	                    ', $id_pegawai), ARRAY_A);
	                    if(empty($cek_id)){
	                        $wpdb->insert('data_pegawai_lembur', $data);
	                    }else{
	                        if($cek_id['active'] == 0){
	                            $wpdb->update('data_pegawai_lembur', $data, array(
	                                'id' => $cek_id['id']
	                            ));
	                        }else{
	                            $ret['status'] = 'error';
	                            $ret['message'] = 'Gagal disimpan. Data pegawai_lembur dengan id_pegawai="'.$id_pegawai.'" sudah ada!';
	                        }
	                    }
	                }
	            }
	        }else{
	            $ret['status']  = 'error';
	            $ret['message'] = 'Api key tidak ditemukan!';
	        }
	    }else{
	        $ret['status']  = 'error';
	        $ret['message'] = 'Format Salah!';
	    }

	    die(json_encode($ret));
	}

	public function get_datatable_pegawai(){
        global $wpdb;
        $ret = array(
            'status' => 'success',
            'message' => 'Berhasil get data!',
            'data'  => array()
        );

        if(!empty($_POST)){
            if (!empty($_POST['api_key']) && $_POST['api_key'] == get_option( SIMPEG_APIKEY )) {
                $user_id = um_user( 'ID' );
                $user_meta = get_userdata($user_id);
                $params = $columns = $totalRecords = $data = array();
                $params = $_REQUEST;
                $columns = array( 
				   0 => 'id_skpd',
				   1 => 'nik',
				   2 => 'nip',
				   3 => 'gelar_depan',
				   4 => 'nama',
				   5 => 'gelar_belakang',
				   6 => 'nama_lengkap',
				   7 => 'tempat_lahir',
				   8 => 'tanggal_lahir',
				   9 => 'jenis_kelamin',
				   10 => 'kode_jenis_kelamin',
				   11 => 'status',
				   12 => 'gol_ruang',
				   13 => 'kode_gol',
				   14 => 'tmt_pangkat',
				   15 => 'eselon',
				   16 => 'jabatan',
				   17 => 'tipe_pegawai',
				   18 => 'tmt_jabatan',
				   19 => 'agama',
				   20 => 'alamat',
				   21 => 'no_hp',
				   22 => 'satuan_kerja',
				   23 => 'unit_kerja_induk',
				   24 => 'tmt_pensiun',
				   25 => 'pendidikan',
				   26 => 'kode_pendidikan',
				   27 => 'nama_sekolah',
				   28 => 'nama_pendidikan',
				   29 => 'lulus',
				   30 => 'karpeg',
				   31 => 'karis_karsu',
				   32 => 'nilai_prestasi',
				   33 => 'email',
				   34 => 'tahun',
                   35 => 'user_role',
                   36 => 'id'
                );
                $where = $sqlTot = $sqlRec = "";

                // check search value exist
                if( !empty($params['search']['value']) ) {
                    $where .=" AND ( id_pegawai LIKE ".$wpdb->prepare('%s', "%".$params['search']['value']."%");  
                    $where .=" OR total LIKE ".$wpdb->prepare('%s', "%".$params['search']['value']."%");
                }

                // getting total number records without any search
                $sql_tot = "SELECT count(id) as jml FROM `data_pegawai_lembur`";
                $sql = "SELECT ".implode(', ', $columns)." FROM `data_pegawai_lembur`";
                $where_first = " WHERE 1=1 AND active=1";
                $sqlTot .= $sql_tot.$where_first;
                $sqlRec .= $sql.$where_first;
                if(isset($where) && $where != '') {
                    $sqlTot .= $where;
                    $sqlRec .= $where;
                }

                $limit = '';
                if($params['length'] != -1){
                    $limit = "  LIMIT ".$wpdb->prepare('%d', $params['start'])." ,".$wpdb->prepare('%d', $params['length']);
                }
                $sqlRec .=  " ORDER BY ". $columns[$params['order'][0]['column']]."   ".$params['order'][0]['dir'].$limit;

                $queryTot = $wpdb->get_results($sqlTot, ARRAY_A);
                $totalRecords = $queryTot[0]['jml'];
                $queryRecords = $wpdb->get_results($sqlRec, ARRAY_A);

                foreach($queryRecords as $recKey => $recVal){
                    $btn = '<a class="btn btn-sm btn-warning" onclick="edit_data(\''.$recVal['id'].'\'); return false;" href="#" title="Edit Data"><i class="dashicons dashicons-edit"></i></a>';
                    $btn .= '<a class="btn btn-sm btn-danger" onclick="hapus_data(\''.$recVal['id'].'\'); return false;" href="#" title="Edit Data"><i class="dashicons dashicons-trash"></i></a>';
                    $queryRecords[$recKey]['aksi'] = $btn;
                }

                $json_data = array(
                    "draw"            => intval( $params['draw'] ),   
                    "recordsTotal"    => intval( $totalRecords ),  
                    "recordsFiltered" => intval($totalRecords),
                    "data"            => $queryRecords,
                    "sql"             => $sqlRec
                );

                die(json_encode($json_data));
            }else{
                $return = array(
                    'status' => 'error',
                    'message'   => 'Api Key tidak sesuai!'
                );
            }
        }else{
            $return = array(
                'status' => 'error',
                'message'   => 'Format tidak sesuai!'
            );
        }
        die(json_encode($return));
    }

	public function get_data_spt_lembur_by_id(){
	    global $wpdb;
	    $ret = array(
	        'status' => 'success',
	        'message' => 'Berhasil get data!',
	        'data' => array()
	    );
	    if(!empty($_POST)){
	        if(!empty($_POST['api_key']) && $_POST['api_key'] == get_option( SIMPEG_APIKEY )) {
	            $ret['data'] = $wpdb->get_row($wpdb->prepare('
	                 SELECT 
                        *
                    FROM data_spt_lembur
                    WHERE id=%d
                    	AND active=1
	            ', $_POST['id']), ARRAY_A);
	            $ret['data_detail'] = $wpdb->get_results($wpdb->prepare('
	                 SELECT 
                        *
                    FROM data_spt_lembur_detail
                    WHERE id_spt=%d
                    	AND active=1
	            ', $_POST['id']), ARRAY_A);
	        }else{
	            $ret['status']  = 'error';
	            $ret['message'] = 'Api key tidak ditemukan!';
	        }
	    }else{
	        $ret['status']  = 'error';
	        $ret['message'] = 'Format Salah!';
	    }

	    die(json_encode($ret));   
	}

	public function hapus_data_spt_lembur_by_id(){
	    global $wpdb;
	    $ret = array(
	        'status' => 'success',
	        'message' => 'Berhasil hapus data!',
	        'data' => array()
	    );
	    if(!empty($_POST)){
	        if(!empty($_POST['api_key']) && $_POST['api_key'] == get_option( SIMPEG_APIKEY )) {
	            $ret['data'] = $wpdb->update('data_spt_lembur', array('active' => 0), array(
	                'id' => $_POST['id']
	            ));
	        }else{
	            $ret['status']  = 'error';
	            $ret['message'] = 'Api key tidak ditemukan!';
	        }
	    }else{
	        $ret['status']  = 'error';
	        $ret['message'] = 'Format Salah!';
	    }

	    die(json_encode($ret));
	}

	public function tambah_data_spt_lembur(){
	    global $wpdb;
	    $ret = array(
	        'status' => 'success',
	        'message' => 'Berhasil simpan data!',
	        'error' => array(),
	        'data' => array()
	    );
	    if(!empty($_POST)){
	        if(!empty($_POST['api_key']) && $_POST['api_key'] == get_option( SIMPEG_APIKEY )) {
	        	$data = json_decode(stripslashes($_POST['data']), true);
	            if($ret['status'] != 'error' && empty($data['nomor_spt'])){
	                $ret['status'] = 'error';
	                $ret['message'] = 'Isi nomor SPT dulu!';
	            }
	            if($ret['status'] != 'error' && empty($data['tahun_anggaran'])){
	                $ret['status'] = 'error';
	                $ret['message'] = 'Pilih Tahun dulu!';
	            }
	            if($ret['status'] != 'error' && empty($data['id_skpd'])){
	                $ret['status'] = 'error';
	                $ret['message'] = 'Pilih SKPD dulu!';
	            }
	            if($ret['status'] != 'error' && empty($data['dasar_lembur'])){
	                $ret['status'] = 'error';
	                $ret['message'] = 'Isi dasar Lembur dulu!';
	            }
	            if($ret['status'] != 'error' && empty($data['ket_lembur'])){
	                $ret['status'] = 'error';
	                $ret['message'] = 'Isi peruntukan Lembur dulu!';
	            }
	            if($ret['status'] != 'error' && empty($data['waktu_mulai_spt'])){
	                $ret['status'] = 'error';
	                $ret['message'] = 'Isi waktu mulai SPT dulu!';
	            }
	            if($ret['status'] != 'error' && empty($data['waktu_selesai_spt'])){
	                $ret['status'] = 'error';
	                $ret['message'] = 'Isi waktu selesai SPT dulu!';
	            }
	            $ket_ver_ppk = '';
	            $ket_ver_kepala = '';
	            $tipe_verifikasi = '';
	            if($ret['status'] != 'error' && !empty($data['tipe_verifikasi'])){
	            	$tipe_verifikasi = $data['tipe_verifikasi'];
	            	if($tipe_verifikasi == 'ppk'){
	                	$ket_ver_ppk = $data['ket_ver_ppk'];
	                	if(empty($ket_ver_ppk)){
	                		$ret['status'] = 'error';
	                		$ret['message'] = 'Keterangan verifikasi PPK SKPD diisi dulu!';
	                	}
	            	}else if($tipe_verifikasi == 'kepala'){
	                	$ket_ver_kepala = $data['ket_ver_kepala'];
	                	if(empty($ket_ver_kepala)){
	                		$ret['status'] = 'error';
	                		$ret['message'] = 'Keterangan verifikasi kepala SKPD diisi dulu!';
	                	}
	            	}
	            }

	            if($ret['status'] != 'error' && !empty($data['id_pegawai'])){
	            	$pesan = array();
	            	foreach($data['id_pegawai'] as $key => $pegawai){
	            		if(empty($data['id_pegawai'][$key])){
	            			$ret['status'] = 'error';
	            			$pesan[] = 'Nama pegawai no '.$key.' diisi dulu!';
	            		}
	            		if(empty($data['waktu_mulai'][$key])){
	            			$ret['status'] = 'error';
	            			$pesan[] = 'Waktu mulai pegawai no '.$key.' diisi dulu!';
	            		}
	            		if(empty($data['waktu_selesai'][$key])){
	            			$ret['status'] = 'error';
	            			$pesan[] = 'Waktu selesai pegawai no '.$key.' diisi dulu!';
	            		}
	            	}
	            	if($ret['status'] == 'error'){
	            		$ret['message'] = implode(', ', $pesan);
	            	}
	            }
	            if($ret['status'] != 'error'){
	                $nomor_spt = $data['nomor_spt'];
	                $tahun_anggaran = $data['tahun_anggaran'];
	                $id_skpd = $data['id_skpd'];
	                $dasar_lembur = $data['dasar_lembur'];
	                $ket_lembur = $data['ket_lembur'];
	                $waktu_mulai_spt = $data['waktu_mulai_spt'];
	                $waktu_selesai_spt = $data['waktu_selesai_spt'];
		            $user_id = um_user( 'ID' );
		            $user_meta = get_userdata($user_id);
	                $uang_makan = 0;
	                $uang_lembur = 0;
	                $jml_jam = 0;
	                $jml_peg = array();
	                $jml_pajak = 0;
	                $data_opsi_detail = array();
	                foreach($data['id_pegawai'] as $key => $pegawai){
	                	$jml_peg[$data['id_pegawai'][$key]] = '';
	                	$jml_jam += $data['jml_jam_lembur'][$key];
	                	$jml_pajak += $data['jml_pajak'][$key];
	                	$uang_lembur += $data['uang_lembur'][$key];
	                	$uang_makan += $data['uang_makan'][$key];
	                	$data_opsi_detail[] = array(
	                		'id' => $data['id_spt_detail'][$key],
	                		'id_spt' => '',
							'id_pegawai' => $data['id_pegawai'][$key],
							'id_standar_harga_lembur' => $data['id_standar_harga_lembur'][$key],
							'id_standar_harga_makan' => $data['id_standar_harga_makan'][$key],
							'uang_lembur' => $data['uang_lembur'][$key],
							'uang_makan' => $data['uang_makan'][$key],
							'jml_hari' => $data['jml_hari_lembur'][$key],
							'jml_jam' => $data['jml_jam_lembur'][$key],
							'jml_pajak' => $data['jml_pajak'][$key],
							'waktu_mulai' => $data['waktu_mulai'][$key],
							'waktu_akhir' => $data['waktu_selesai'][$key],
							'waktu_mulai_ppk' => $data['waktu_mulai'][$key],
							'waktu_akhir_ppk' => $data['waktu_selesai'][$key],
							'waktu_mulai_hadir' => '',
							'waktu_akhir_hadir' => '',
							'tipe_hari' => $data['jenis_hari'][$key],
							'keterangan' => $data['keterangan'][$key],
							'keterangan_ppk' => $data['keterangan'][$key],
							'file_lampiran' => '',
							'update_at' => current_time('mysql'),
							'active' => 1
	                	);
	                }
	                $data_opsi = array(
	                    'id_skpd'=> $id_skpd,
	                    'tahun_anggaran'=> $tahun_anggaran,
	                    'nomor_spt'=> $nomor_spt,
	                    'waktu_mulai_spt'=> $data['waktu_mulai_spt'],
	                    'waktu_selesai_spt'=> $data['waktu_selesai_spt'],
	                    'nomor_spt'=> $nomor_spt,
			            'uang_makan'=> $uang_makan, 
			            'uang_lembur'=> $uang_lembur, 
			            'dasar_lembur'=> $dasar_lembur, 
			            'ket_lembur'=> $ket_lembur, 
			            'jml_hari'=> $data['jml_hari'], 
			            'jml_jam'=> $jml_jam, 
			            'jml_peg'=> count($jml_peg), 
			            'jml_pajak'=> $jml_pajak,
	                    'user' => $user_meta->display_name,
	                    'update_at' => current_time('mysql'),
						'active' => 1
	                );
	                if($tipe_verifikasi == 'ppk'){
	                	$ret_ver = $this->verifikasi_spt_lembur(true);
	                	if($ret_ver['status'] == 'error'){
	                		die(json_encode($ret_ver));
	                	}
	                	$data_opsi['ket_ver_ppk'] = $ket_ver_ppk;
	                }
	                if($tipe_verifikasi == 'kepala'){
	                	$ret_ver = $this->verifikasi_spt_lembur(true);
	                	if($ret_ver['status'] == 'error'){
	                		die(json_encode($ret_ver));
	                	}
	                	$data_opsi['ket_ver_kepala'] = $ket_ver_kepala;
	                }
	                if(!empty($data['id_data'])){
	                    $wpdb->update('data_spt_lembur', $data_opsi, array(
	                        'id' => $data['id_data']
	                    ));
	                    if(empty($tipe_verifikasi)){
	                    	$ret['message'] = 'Berhasil update data!';
	                    }else{
	                		$ret = $ret_ver;
	                    }
	                }else{
	                	$data_opsi['status'] = 0;
	                    $cek_id = $wpdb->get_row($wpdb->prepare('
	                        SELECT
	                            id,
	                            nomor_spt,
	                            active
	                        FROM data_spt_lembur
	                        WHERE nomor_spt=%s
	                        	AND tahun_anggaran=%d
	                    ', $nomor_spt, $tahun_anggaran), ARRAY_A);
	                    if(empty($cek_id)){
	                        $cek = $wpdb->insert('data_spt_lembur', $data_opsi);
	                        if(!empty($cek)){
	                        	$data['id_data'] = $wpdb->insert_id;
	                        }
	                    }else{
	                        if($cek_id['active'] == 0){
	                        	$data['id_data'] = $cek_id['id'];
	                            $wpdb->update('data_spt_lembur', $data_opsi, array(
	                                'id' => $cek_id['id']
	                            ));
	                        }else{
	                            $ret['status'] = 'error';
	                            $ret['message'] = 'Gagal disimpan. Data SPT dengan nomor_spt="'.$cek_id['nomor_spt'].'" sudah ada!';
	                        }
	                    }
	                }
	            }
	            if($ret['status'] != 'error'){
                    $wpdb->update('data_spt_lembur_detail', array('active' => 0), array(
                        'id_spt' => $data['id_data']
                    ));
	            	foreach($data_opsi_detail as $opsi){
	            		$opsi['id_spt'] = $data['id_data'];
	                    if(empty($opsi['id'])){
	                        $wpdb->insert('data_spt_lembur_detail', $opsi);
	                    }else{
                            $wpdb->update('data_spt_lembur_detail', $opsi, array(
                                'id' => $opsi['id']
                            ));
                        }
                        if(!empty($wpdb->last_error)){
                        	$ret['error'][] = $wpdb->last_error;
                        }
	            	}
	            }
	        }else{
	            $ret['status']  = 'error';
	            $ret['message'] = 'Api key tidak ditemukan!';
	        }
	    }else{
	        $ret['status']  = 'error';
	        $ret['message'] = 'Format Salah!';
	    }

	    die(json_encode($ret));
	}
	    
	public function get_datatable_data_spt_lembur(){
	    global $wpdb;
	    $ret = array(
	        'status' => 'success',
	        'message' => 'Berhasil get data!',
	        'data'  => array()
	    );

	    if(!empty($_POST)){
	        if (!empty($_POST['api_key']) && $_POST['api_key'] == get_option( SIMPEG_APIKEY )) {
	            $user_id = um_user( 'ID' );
	            $user_meta = get_userdata($user_id);
	            $params = $columns = $totalRecords = $data = array();
	            $params = $_REQUEST;
	            $columns = array( 
	            	'u.nama_skpd',
	            	's.nomor_spt',
	            	's.jml_peg',
	            	's.jml_jam',
	            	's.uang_makan',
	            	's.uang_lembur',
	            	's.jml_pajak',
	            	's.ket_lembur',
	            	's.ket_ver_ppk',
	            	's.status',
	            	's.status_ver_bendahara', 
	            	's.ket_ver_bendahara',
	            	's.status_ver_bendahara_spj', 
	            	's.ket_ver_bendahara_spj',
	            	's.ket_ver_kepala',
	              	's.id'
	            );
	            $where = $sqlTot = $sqlRec = "";

	            if( !empty($params['search']['value']) ) { 
	                $where .=" OR u.nama_skpd LIKE ".$wpdb->prepare('%s', "%".$params['search']['value']."%");
	                $where .=" OR s.nomor_spt LIKE ".$wpdb->prepare('%s', "%".$params['search']['value']."%");
	                $where .=" OR s.ket_lembur LIKE ".$wpdb->prepare('%s', "%".$params['search']['value']."%");
	            }

	            // getting total number records without any search
	            $sql_tot = "SELECT count(id) as jml FROM `data_spt_lembur` s";
	            $sql = "
	            	SELECT 
	            		".implode(', ', $columns)." 
	            	FROM `data_spt_lembur` s
	            	LEFT JOIN data_unit_lembur as u on s.id_skpd=u.id_skpd
	            		AND s.tahun_anggaran=u.tahun_anggaran
	            		AND s.active=u.active";
	            $where_first = " WHERE 1=1 AND s.active=1";
	            $sqlTot .= $sql_tot.$where_first;
	            $sqlRec .= $sql.$where_first;
	            if(isset($where) && $where != '') {
	                $sqlTot .= $where;
	                $sqlRec .= $where;
	            }

                $limit = '';
                if($params['length'] != -1){
                    $limit = "  LIMIT ".$wpdb->prepare('%d', $params['start'])." ,".$wpdb->prepare('%d', $params['length']);
                }
                $sqlRec .=  " ORDER BY ". $columns[$params['order'][0]['column']]."   ".str_replace("'", '', $wpdb->prepare('%s', $params['order'][0]['dir'])).$limit;

                $queryTot = $wpdb->get_results($sqlTot, ARRAY_A);
                $totalRecords = $queryTot[0]['jml'];
                $queryRecords = $wpdb->get_results($sqlRec, ARRAY_A);

                $is_admin = in_array("administrator", $user_meta->roles);
                $is_pptk = in_array("pptk", $user_meta->roles);
                $is_kasubag = in_array("kasubag_keuangan", $user_meta->roles);
                $is_ppk = in_array("ppk", $user_meta->roles);
                $is_kepala = in_array("kepala", $user_meta->roles);

				$laporan_spt_lembur = $this->functions->generatePage(array(
					'nama_page' => 'Laporan Surat Perintah Tugas',
					'content' => '[laporan_spt_lembur]',
					'show_header' => 1,
					'post_status' => 'private'
				));

                foreach($queryRecords as $recKey => $recVal){
                    $btn = '<a class="btn btn-sm btn-primary" onclick="detail_data(\''.$recVal['id'].'\'); return false;" href="#" title="Detail Data"><i class="dashicons dashicons-search"></i></a>';
	                if($recVal['status'] == 0){
                    	$btn .= '<a style="margin-top: 5px;" class="btn btn-sm btn-warning" onclick="edit_data(\''.$recVal['id'].'\'); return false;" href="#" title="Edit Data"><i class="dashicons dashicons-edit"></i></a>';
                        $btn .= '<a style="margin-top: 5px;" class="btn btn-sm btn-danger" onclick="hapus_data(\''.$recVal['id'].'\'); return false;" href="#" title="Hapus Data"><i class="dashicons dashicons-trash"></i></a>';
                        $btn .= '<a style="margin-top: 5px;" class="btn btn-sm btn-primary" onclick="submit_data(\''.$recVal['id'].'\'); return false;" href="#" title="Submit Data"><i class="dashicons dashicons-migrate"></i></a>';

	                    if ($recVal['status_ver_bendahara'] == '0'){
	                        $pesan = '<br><b>Keterangan:</b> '.$recVal['ket_ver_bendahara']; 
	                    	$queryRecords[$recKey]['status'] = '<span class="btn btn-danger btn-sm">SPT Ditolak</span>'.$pesan;
	                    }else{
	                    	$queryRecords[$recKey]['status'] = '<span class="btn btn-primary btn-sm">Menunggu Submit</span>';
	                    }
	                }else if($recVal['status'] == 1) {
                    	$btn .= '<a style="margin-top: 5px;" class="btn btn-sm btn-success" onclick="verifikasi_kasubag_keuangan(\''.$recVal['id'].'\'); return false;" href="#" title="Verifikasi Kasubag Keuangan"><i class="dashicons dashicons-yes"></i></a>';
	                    $queryRecords[$recKey]['status'] = '<span class="btn btn-success btn-sm">Menunggu verifikasi Kasubag Keuangan</span>';
	                }elseif($recVal['status'] == 2) {
                    	$btn .= '<a style="margin-top: 5px;" class="btn btn-sm btn-success" onclick="verifikasi_ppk(\''.$recVal['id'].'\'); return false;" href="#" title="Verifikasi PPK"><i class="dashicons dashicons-yes"></i></a>';
	                    $queryRecords[$recKey]['status'] = '<span class="btn btn-success btn-sm">Menunggu verifikasi PPK</span>';
	                }elseif($recVal['status'] == 3) {
                    	$btn .= '<a style="margin-top: 5px;" class="btn btn-sm btn-success" onclick="verifikasi_kepala(\''.$recVal['id'].'\'); return false;" href="#" title="Verifikasi Kepala"><i class="dashicons dashicons-yes"></i></a>';
	                    $queryRecords[$recKey]['status'] = '<span class="btn btn-success btn-sm">Menunggu verifikasi Kepala</span>';
	                }elseif($recVal['status'] == 4) {
	                    if ($recVal['status_ver_bendahara_spj'] == '0'){
	                        $pesan = '<br><b>Keterangan:</b> '.$recVal['ket_ver_bendahara_spj']; 
	                    	$queryRecords[$recKey]['status'] = '<span class="btn btn-danger btn-sm">SPJ Ditolak</span>'.$pesan;
	                    }else{
	                    	$queryRecords[$recKey]['status'] = '<span class="btn btn-primary btn-sm">Menunggu Submit SPJ</span>';
	                    }
	                }elseif($recVal['status'] == 5) {
	                    $queryRecords[$recKey]['status'] = '<span class="btn btn-success btn-sm">SPJ Menunggu verifikasi Kasubag Keuangan</span>';
	                }elseif($recVal['status'] == 6) {
	                    $queryRecords[$recKey]['status'] = '<span class="btn btn-primary btn-sm">Selesai</span>';
	                }else{
	                    $queryRecords[$recKey]['status'] = '<span class="btn btn-danger btn-sm">Not Found</span>';
	                }

                    $btn .= '<a style="margin-top: 5px;" class="btn btn-sm btn-primary" target="_blank" href="'.$laporan_spt_lembur['url'].'&id_spt='.$recVal['id'].'" title="Print SPT"><i class="dashicons dashicons-printer"></i></a>';
	                $queryRecords[$recKey]['aksi'] = $btn;
	                $queryRecords[$recKey]['uang_lembur'] = $this->rupiah($recVal['uang_lembur']);
	                $queryRecords[$recKey]['uang_makan'] = $this->rupiah($recVal['uang_makan']);
	                $queryRecords[$recKey]['jml_pajak'] = $this->rupiah($recVal['jml_pajak']);
	            }
	     
	            $json_data = array(
	                "draw"            => intval( $params['draw'] ),   
	                "recordsTotal"    => intval( $totalRecords ),  
	                "recordsFiltered" => intval($totalRecords),
	                "data"            => $queryRecords,
	                "sql"             => $sqlRec
	            );

	            die(json_encode($json_data));
	        }else{
	            $return = array(
	                'status' => 'error',
	                'message'   => 'Api Key tidak sesuai!'
	            );
	        }
	    }else{
	        $return = array(
	            'status' => 'error',
	            'message'   => 'Format tidak sesuai!'
	        );
	    }
	    die(json_encode($return));
	} 

	public function get_data_spj_by_id(){
	    global $wpdb;
	    $ret = array(
	        'status' => 'success',
	        'message' => 'Berhasil get data!',
	        'data' => array()
	    );
	    if(!empty($_POST)){
	        if(!empty($_POST['api_key']) && $_POST['api_key'] == get_option( SIMPEG_APIKEY )) {
	            $ret['data'] = $wpdb->get_row($wpdb->prepare('
	                SELECT 
	                    s.*,
	                    t.id as id_spt,
	                    t.nomor_spt,
	                    t.waktu_mulai_spt,
	                    t.waktu_selesai_spt,
	                    t.id_skpd,
	                    u.nama_skpd
	                FROM data_spt_lembur t
	                INNER JOIN data_unit_lembur u ON t.id_skpd=u.id_skpd
	                	AND u.active=t.active
	                	AND u.tahun_anggaran=t.tahun_anggaran
	                LEFT JOIN data_spj_lembur s ON s.id_spt=t.id
	                	AND s.active=t.active
	                WHERE t.id=%d
	            ', $_POST['id']), ARRAY_A);
	            $ret['sql'] = $wpdb->last_query;
	        }else{
	            $ret['status']  = 'error';
	            $ret['message'] = 'Api key tidak ditemukan!';
	        }
	    }else{
	        $ret['status']  = 'error';
	        $ret['message'] = 'Format Salah!';
	    }

	    die(json_encode($ret));
	}

	public function hapus_data_spj_by_id(){
	    global $wpdb;
	    $ret = array(
	        'status' => 'success',
	        'message' => 'Berhasil hapus data!',
	        'data' => array()
	    );
	    if(!empty($_POST)){
	        if(!empty($_POST['api_key']) && $_POST['api_key'] == get_option( SIMPEG_APIKEY )) {
	            $ret['data'] = $wpdb->update('data_spj_lembur', array('active' => 0), array(
	                'id' => $_POST['id']
	            ));
	        }else{
	            $ret['status']  = 'error';
	            $ret['message'] = 'Api key tidak ditemukan!';
	        }
	    }else{
	        $ret['status']  = 'error';
	        $ret['message'] = 'Format Salah!';
	    }

	    die(json_encode($ret));
	}

	public function edit_data_spj_lembur(){
	    global $wpdb;
	    $ret = array(
	        'status' => 'success',
	        'message' => 'Berhasil simpan data!',
	        'data' => array()
	    );
	    if(!empty($_POST)){
	        if(!empty($_POST['api_key']) && $_POST['api_key'] == get_option(SIMPEG_APIKEY)) {
	            if($ret['status'] != 'error' && empty($_POST['id_spt'])){
	                $ret['status'] = 'error';
	                $ret['message'] = 'Data id spt tidak boleh kosong!';
	            }
	            if($ret['status'] != 'error' && empty($_FILES['file_daftar_hadir'])){
	                $ret['status'] = 'error';
	                $ret['message'] = 'file daftar hadir tidak boleh kosong!';
	            }
	            if($ret['status'] != 'error' && empty($_FILES['foto_lembur'])){
	                $ret['status'] = 'error';
	                $ret['message'] = 'foto lembur tidak boleh kosong!';
	            }
	            if($ret['status'] != 'error'){
	            	$id_spt = $_POST['id_spt'];
	            	$user_id = um_user( 'ID' );
	            	$user_meta = get_userdata($user_id);
	                $data = array(
	                    'id_spt' => $id_spt,
	                    'user' => $user->display_name,
	                    'active' => 1,
	                    'update_at' => current_time('mysql')
	                );

	                $cek_file_all = array();
		            $path = SIMPEG_PLUGIN_PATH.'public/media/simpeg/';

		            $upload = $this->functions->uploadFile($_POST['api_key'], $path, $_FILES['file_daftar_hadir'], ['jpg', 'jpeg', 'png', 'pdf']);
		            if($upload['status']){
		                $data['file_daftar_hadir'] = $upload['filename'];
		            	$cek_file_all[] = $data['file_daftar_hadir'];
		            }else{
		            	$ret['status'] = 'error';
		            	$ret['message'] = $upload['message'];
		            }

		            if($ret['status'] != 'error'){
			            $upload = $this->functions->uploadFile($_POST['api_key'], $path, $_FILES['foto_lembur'], ['jpg', 'jpeg', 'png', 'pdf']);
			            if($upload['status']){
			                $data['foto_lembur'] = $upload['filename'];
			            	$cek_file_all[] = $data['foto_lembur'];
			            }else{
			            	$ret['status'] = 'error';
			            	$ret['message'] = $upload['message'];
			            }
		            }

		            if($ret['status'] == 'error'){
		            	foreach($cek_file_all as $file){
		            		if(is_file($path.$file)){
		            			unlink($path.$file);
		            		}
		            	}
		            }else{
		                if(!empty($_POST['id_data'])){
		                    $file_lama = $wpdb->get_row($wpdb->prepare('
		                        SELECT
		                            file_daftar_hadir,
		                            foto_lembur
		                        FROM data_spj_lembur
		                        WHERE id=%d
		                    ', $_POST['id_data']), ARRAY_A);
		                    if(
		                    	$file_lama['file_daftar_hadir'] != $data['file_daftar_hadir']
		                    	&& is_file($path.$file_lama['file_daftar_hadir'])
		                    ){
		                    	unlink($path.$file_lama['file_daftar_hadir']);
		                    }
		                    if(
		                    	$file_lama['foto_lembur'] != $data['foto_lembur']
		                    	&& is_file($path.$file_lama['foto_lembur'])
		                    ){
		                    	unlink($path.$file_lama['foto_lembur']);
		                    }
		                }
		                if(!empty($_POST['id_data'])){
		                    $wpdb->update('data_spj_lembur', $data, array(
		                        'id' => $_POST['id_data']
		                    ));
		                    $ret['message'] = 'Berhasil update data!';
		                }else{
		                    $cek_id = $wpdb->get_row($wpdb->prepare('
		                        SELECT
		                            id,
		                            active
		                        FROM data_spj_lembur
		                        WHERE id_spt=%s
		                    ', $id_spt), ARRAY_A);
		                    if(empty($cek_id)){
		                        $wpdb->insert('data_spj_lembur', $data);
		                    }else{
		                        if($cek_id['active'] == 0){
		                            $wpdb->update('data_spj_lembur', $data, array(
		                                'id' => $cek_id['id']
		                            ));
		                        }else{
		                            $ret['status'] = 'error';
		                            $ret['message'] = 'Gagal disimpan. Data SPJ_lembur dengan id_spt="'.$id_spt.'" sudah ada!';
		                        }
		                    }
		                }
		            }
	            }
	        }else{
	            $ret['status']  = 'error';
	            $ret['message'] = 'Api key tidak ditemukan!';
	        }
	    }else{
	        $ret['status']  = 'error';
	        $ret['message'] = 'Format Salah!';
	    }

	    die(json_encode($ret));
	}

	public function get_datatable_spj_lembur(){
	    global $wpdb;
	    $ret = array(
	        'status' => 'success',
	        'message' => 'Berhasil get data!',
	        'data'  => array()
	    );

	    if(!empty($_POST)){
	        if (!empty($_POST['api_key']) && $_POST['api_key'] == get_option( SIMPEG_APIKEY )) {
	            $user_id = um_user( 'ID' );
	            $user_meta = get_userdata($user_id);
	            $params = $columns = $totalRecords = $data = array();
	            $params = $_REQUEST;
	            $columns = array(  
	        	's.nomor_spt',
				'u.nama_skpd',
	        	's.waktu_mulai_spt',
	        	's.waktu_selesai_spt',
				'p.file_daftar_hadir',
				'p.foto_lembur',
	        	's.status',
	          	's.id',
	          	's.status_ver_bendahara_spj',
	          	's.ket_ver_bendahara_spj'
	        );
	        $where = $sqlTot = $sqlRec = "";

	        if( !empty($params['search']['value']) ) { 
	            $where .=" OR u.nama_skpd LIKE ".$wpdb->prepare('%s', "%".$params['search']['value']."%").")";
	            $where .=" OR s.nomor_spt LIKE ".$wpdb->prepare('%s', "%".$params['search']['value']."%").")";
	        }

	        // getting total number records without any search
	        $sql_tot = "SELECT count(id) as jml FROM `data_spt_lembur` s";
	        $sql = "
	        	SELECT 
	        		".implode(', ', $columns)." 
	        	FROM `data_spt_lembur` s
	        	LEFT JOIN data_unit_lembur as u on s.id_skpd=u.id_skpd
	        		AND s.tahun_anggaran=u.tahun_anggaran
	        		AND s.active=u.active
	        	LEFT JOIN data_spj_lembur as p on s.id=p.id_spt";
	        $where_first = " WHERE 1=1 AND s.active=1 AND s.status>=4";
	        $sqlTot .= $sql_tot.$where_first;
	        $sqlRec .= $sql.$where_first;
	        if(isset($where) && $where != '') {
	            $sqlTot .= $where;
	            $sqlRec .= $where;
	        }
	        $limit = ''; 
	        if($params['length'] != -1){
	            $limit = "  LIMIT ".$wpdb->prepare('%d', $params['start'])." ,".$wpdb->prepare('%d', $params['length']);
	        }
	        $sqlRec .=  " ORDER BY ". $columns[$params['order'][0]['column']]."   ".$params['order'][0]['dir'].$limit;

	        $queryTot = $wpdb->get_results($sqlTot, ARRAY_A);
	        $totalRecords = $queryTot[0]['jml'];
	        $queryRecords = $wpdb->get_results($sqlRec, ARRAY_A);

	        foreach($queryRecords as $recKey => $recVal){
	            $queryRecords[$recKey]['file_daftar_hadir'] = '<a href="'.SIMPEG_PLUGIN_URL.'public/media/simpeg/'.$recVal['file_daftar_hadir'].'" target="_blank">'.$recVal['file_daftar_hadir'].'</a>';
	            $queryRecords[$recKey]['foto_lembur'] = '<a href="'.SIMPEG_PLUGIN_URL.'public/media/simpeg/'.$recVal['foto_lembur'].'" target="_blank">'.$recVal['foto_lembur'].'</a>';
	            $btn = '';
		        if($recVal['status'] == 4) {
		            $btn = '<a class="btn btn-sm btn-warning" onclick="edit_data(\''.$recVal['id'].'\'); return false;" href="#" title="Edit Data"><i class="dashicons dashicons-edit"></i></a>';
		            $btn .= '<a class="btn btn-sm btn-primary" onclick="submit_data(\''.$recVal['id'].'\'); return false;" href="#" title="Submit Data"><i class="dashicons dashicons-migrate"></i></a>';
		            if ($recVal['status_ver_bendahara_spj'] == '0'){
		                $pesan = '<br><b>Keterangan:</b> '.$recVal['ket_ver_bendahara_spj']; 
		            	$queryRecords[$recKey]['status'] = '<span class="btn btn-danger btn-sm">SPJ Ditolak</span>'.$pesan;
		            }else{
		            	$queryRecords[$recKey]['status'] = '<span class="btn btn-primary btn-sm">Menunggu Submit SPJ</span>';
		            }
		        }elseif($recVal['status'] == 5) {
		            $btn .= '<a class="btn btn-sm btn-success" onclick="verifikasi_kasubag_keuangan_spj(\''.$recVal['id'].'\'); return false;" href="#" title="Verifikasi SPJ Kasubag Keuangan"><i class="dashicons dashicons-yes"></i></a>';
		            $queryRecords[$recKey]['status'] = '<span class="btn btn-success btn-sm">SPJ Menunggu Verifikasi Kasubag Keuangan</span>';
		        }elseif($recVal['status'] == 6) {
		            $queryRecords[$recKey]['status'] = '<span class="btn btn-primary btn-sm">Selesai</span>';
		        }else{
		            $queryRecords[$recKey]['status'] = '<span class="btn btn-danger btn-sm">Not Found</span>';
		        }
	            $queryRecords[$recKey]['aksi'] = $btn;
	        }
	        $json_data = array(
	            "draw"            => intval( $params['draw'] ),   
	            "recordsTotal"    => intval( $totalRecords ),  
	            "recordsFiltered" => intval($totalRecords),
	            "data"            => $queryRecords,
	            "sql"             => $sqlRec
	        );

	        die(json_encode($json_data));
	      }else{
	            $return = array(
	                'status' => 'error',
	                'message'   => 'Api Key tidak sesuai!'
	            );
	        }
	    }else{
	        $return = array(
	    		'status' => 'error',
	        	'message'   => 'Format tidak sesuai!'
	    	);
		}
	    die(json_encode($return));
	}  

	public function get_data_sbu_lembur_by_id(){
	    global $wpdb;
	    $ret = array(
	        'status' => 'success',
	        'message' => 'Berhasil get data!',
	        'data' => array()
	    );
	    if(!empty($_POST)){
	        if(!empty($_POST['api_key']) && $_POST['api_key'] == get_option( SIMPEG_APIKEY )) {
	            $ret['data'] = $wpdb->get_row($wpdb->prepare('
	                SELECT 
	                    *
	                FROM data_sbu_lembur
	                WHERE id=%d
	            ', $_POST['id']), ARRAY_A);
	        }else{
	            $ret['status']  = 'error';
	            $ret['message'] = 'Api key tidak ditemukan!';
	        }
	    }else{
	        $ret['status']  = 'error';
	        $ret['message'] = 'Format Salah!';
	    }

	    die(json_encode($ret));
	}

	public function hapus_data_sbu_lembur_by_id(){
	    global $wpdb;
	    $ret = array(
	        'status' => 'success',
	        'message' => 'Berhasil hapus data!',
	        'data' => array()
	    );
	    if(!empty($_POST)){
	        if(!empty($_POST['api_key']) && $_POST['api_key'] == get_option( SIMPEG_APIKEY )) {
	            $ret['data'] = $wpdb->update('data_sbu_lembur', array('active' => 0), array(
	                'id' => $_POST['id']
	            ));
	        }else{
	            $ret['status']  = 'error';
	            $ret['message'] = 'Api key tidak ditemukan!';
	        }
	    }else{
	        $ret['status']  = 'error';
	        $ret['message'] = 'Format Salah!';
	    }

	    die(json_encode($ret));
	}

	public function tambah_data_sbu_lembur(){
	    global $wpdb;
	    $ret = array(
	        'status' => 'success',
	        'message' => 'Berhasil simpan data!',
	        'data' => array()
	    );
	    if(!empty($_POST)){
	        if(!empty($_POST['api_key']) && $_POST['api_key'] == get_option( SIMPEG_APIKEY )) {
	            if($ret['status'] != 'error' && !empty($_POST['no_aturan'])){
	                $no_aturan = $_POST['no_aturan'];
	            }else{
	                $ret['status'] = 'error';
	                $ret['message'] = 'Data no_aturan tidak boleh kosong!';
	            }
	            if($ret['status'] != 'error' && !empty($_POST['uraian'])){
	                $uraian = $_POST['uraian'];
	            }
	            // else{
	            //  $ret['status'] = 'error';
	            //  $ret['message'] = 'Data uraian tidak boleh kosong!';
	            // }
	            if($ret['status'] != 'error' && !empty($_POST['nama'])){
	                $nama = $_POST['nama'];
	            }
	            // else{
	            //  $ret['status'] = 'error';
	            //  $ret['message'] = 'Data nama tidak boleh kosong!';
	            // }
	            if($ret['status'] != 'error' && !empty($_POST['kode_standar_harga'])){
	                $kode_standar_harga = $_POST['kode_standar_harga'];
	            }
	            // else{
	            //  $ret['status'] = 'error';
	            //  $ret['message'] = 'Data kode_standar_harga tidak boleh kosong!';
	            // }
	            if($ret['status'] != 'error' && !empty($_POST['satuan'])){
	                $satuan = $_POST['satuan'];
	            }
	            // else{
	            //  $ret['status'] = 'error';
	            //  $ret['message'] = 'Data satuan tidak boleh kosong!';
	            // }
	            if($ret['status'] != 'error' && !empty($_POST['harga'])){
	                $harga = $_POST['harga'];
	             }
	            // else{
	            //  $ret['status'] = 'error';
	            //  $ret['message'] = 'Data harga tidak boleh kosong!';
	            // }
	            if($ret['status'] != 'error' && !empty($_POST['id_golongan'])){
	                $id_golongan = $_POST['id_golongan'];
	             }
	            // else{
	            //  $ret['status'] = 'error';
	            //  $ret['message'] = 'Data id_golongan tidak boleh kosong!';
	            // }
	            if($ret['status'] != 'error' && !empty($_POST['jenis_hari'])){
	                $jenis_hari = $_POST['jenis_hari'];
	             }
	            // else{
	            //  $ret['status'] = 'error';
	            //  $ret['message'] = 'Data jenis_hari tidak boleh kosong!';
	            // }
	            if($ret['status'] != 'error' && !empty($_POST['pph_21'])){
	                $pph_21 = $_POST['pph_21'];
	             }
	            // else{
	            //  $ret['status'] = 'error';
	            //  $ret['message'] = 'Data pph_21 tidak boleh kosong!';
	            // }
	            // if($ret['status'] != 'error' && !empty($_POST['tahun'])){
	            //     $tahun = $_POST['tahun'];
	            //  }
	            // else{
	            //  $ret['status'] = 'error';
	            //  $ret['message'] = 'Data tahun tidak boleh kosong!';
	            // }
	            if($ret['status'] != 'error'){
	                $data = array(
	                    'no_aturan' => $no_aturan,
	                    'uraian' => $uraian,
	                    'nama' => $nama,
	                    'kode_standar_harga' => $kode_standar_harga,
	                    'satuan' => $satuan,
	                    'harga' => $harga,
	                    'id_golongan' => $id_golongan,
	                    'jenis_hari' => $jenis_hari,
	                    'pph_21' => $pph_21,
	                    // 'tahun' => $tahun,
	                    'active' => 1,
	                    'update_at' => current_time('mysql')
	                );
	                if(!empty($_POST['id_data'])){
	                    $wpdb->update('data_sbu_lembur', $data, array(
	                        'id' => $_POST['id_data']
	                    ));
	                    $ret['message'] = 'Berhasil update data!';
	                }else{
	                    $cek_id = $wpdb->get_row($wpdb->prepare('
	                        SELECT
	                            id,
	                            active
	                        FROM data_sbu_lembur
	                        WHERE id_sbu_lembur=%s
	                    ', $id_sbu_lembur), ARRAY_A);
	                    if(empty($cek_id)){
	                        $wpdb->insert('data_sbu_lembur', $data);
	                    }else{
	                        if($cek_id['active'] == 0){
	                            $wpdb->update('data_sbu_lembur', $data, array(
	                                'id' => $cek_id['id']
	                            ));
	                        }else{
	                            $ret['status'] = 'error';
	                            $ret['message'] = 'Gagal disimpan. Data sbu_lembur dengan id_sbu_lembur="'.$id_sbu_lembur.'" sudah ada!';
	                        }
	                    }
	                }
	            }
	        }else{
	            $ret['status']  = 'error';
	            $ret['message'] = 'Api key tidak ditemukan!';
	        }
	    }else{
	        $ret['status']  = 'error';
	        $ret['message'] = 'Format Salah!';
	    }

	    die(json_encode($ret));
	}

	public function get_datatable_sbu_lembur(){
        global $wpdb;
        $ret = array(
            'status' => 'success',
            'message' => 'Berhasil get data!',
            'data'  => array()
        );

        if(!empty($_POST)){
            if (!empty($_POST['api_key']) && $_POST['api_key'] == get_option( SIMPEG_APIKEY )) {
                $user_id = um_user( 'ID' );
                $user_meta = get_userdata($user_id);
                $params = $columns = $totapRecords = $data = array();
                $params = $_REQUEST;
                $columns = array( 
                  0 => 'kode_standar_harga',
                  1 => 'no_aturan',
                  2 => 'nama',
                  3 => 'uraian',
                  4 => 'satuan',
                  5 => 'harga',
                  6 => 'id_golongan',
                  7 => 'jenis_hari',
                  8 => 'pph_21',
                  //  => 'tahun',
                  9 => 'id'
                );
                $where = $sqlTot = $sqlRec = "";

                // check search value exist
                if( !empty($params['search']['value']) ) {
                    $where .=" AND ( id_sbu_lembur LIKE ".$wpdb->prepare('%s', "%".$params['search']['value']."%");  
                    $where .=" OR total LIKE ".$wpdb->prepare('%s', "%".$params['search']['value']."%");
                }

                // getting total number records without any search
                $sql_tot = "SELECT count(id) as jml FROM `data_sbu_lembur`";
                $sql = "SELECT ".implode(', ', $columns)." FROM `data_sbu_lembur`";
                $where_first = " WHERE 1=1 AND active = 1";
                $sqlTot .= $sql_tot.$where_first;
                $sqlRec .= $sql.$where_first;
                if(isset($where) && $where != '') {
                    $sqlTot .= $where;
                    $sqlRec .= $where;
                }

                $limit = '';
                if($params['length'] != -1){
                    $limit = "  LIMIT ".$wpdb->prepare('%d', $params['start'])." ,".$wpdb->prepare('%d', $params['length']);
                }
                $sqlRec .=  " ORDER BY ". $columns[$params['order'][0]['column']]."   ".$params['order'][0]['dir'].$limit;

                $queryTot = $wpdb->get_results($sqlTot, ARRAY_A);
                $totapRecords = $queryTot[0]['jml'];
                $queryRecords = $wpdb->get_results($sqlRec, ARRAY_A);

                foreach($queryRecords as $recKey => $recVal){
                    $btn = '<a class="btn btn-sm btn-warning" onclick="edit_data(\''.$recVal['id'].'\'); return false;" href="#" title="Edit Data"><i class="dashicons dashicons-edit"></i></a>';
                    $btn .= '<a style="margin-left: 10px;" class="btn btn-sm btn-danger" onclick="hapus_data(\''.$recVal['id'].'\'); return false;" href="#" title="Edit Data"><i class="dashicons dashicons-trash"></i></a>';
                    $queryRecords[$recKey]['aksi'] = $btn;
                }

                $json_data = array(
                    "draw"            => intval( $params['draw'] ),   
                    "recordsTotao"    => intval( $totapRecords ),  
                    "recordsFiltered" => intval($totapRecords),
                    "data"            => $queryRecords,
                    "sql"             => $sqlRec
                );

                die(json_encode($json_data));
            }else{
                $return = array(
                    'status' => 'error',
                    'message'   => 'Api Key tidak sesuai!'
                );
            }
        }else{
            $return = array(
                'status' => 'error',
                'message'   => 'Format tidak sesuai!'
            );
        }
        die(json_encode($return));
    }

	public function run_sql_migrate_wp_simpeg(){
		global $wpdb;
		$ret = array(
			'status'	=> 'success',
			'message'	=> 'Berhasil menjalankan SQL migrate!'
		);
		if (!empty($_POST)) {
			if (!empty($_POST['api_key']) && $_POST['api_key'] == get_option( SIMPEG_APIKEY )) {
				$file = basename($_POST['file']);
				$ret['value'] = $file.' (tgl: '.date('Y-m-d H:i:s').')';
				if($file == 'tabel.sql'){
					$path = SIMPEG_PLUGIN_PATH.'/'.$file;
				}else{
					$path = SIMPEG_PLUGIN_PATH.'/sql-migrate/'.$file;
				}
				if(file_exists($path)){
					$sql = file_get_contents($path);
					$ret['sql'] = $sql;
					if($file == 'tabel.sql'){
						require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
						$wpdb->hide_errors();
						$rows_affected = dbDelta($sql);
						if(empty($rows_affected)){
							$ret['status'] = 'error';
							$ret['message'] = $wpdb->last_error;
						}else{
							$ret['message'] = implode(' | ', $rows_affected);
						}
					}else{
						$wpdb->hide_errors();
						$res = $wpdb->query($sql);
						if(empty($res)){
							$ret['status'] = 'error';
							$ret['message'] = $wpdb->last_error;
						}else{
							$ret['message'] = $res;
						}
					}
					if($ret['status'] == 'success'){
						$ret['version'] = $this->version;
						update_option('_last_update_sql_migrate_wp_simpeg', $ret['value']);
						update_option('_wp_simpeg_db_version', $this->version);
					}
				}else{
					$ret['status'] = 'error';
					$ret['message'] = 'File '.$file.' tidak ditemukan!';
				}
			}else{
				$ret = array(
					'status' => 'error',
					'message'	=> 'Api Key tidak sesuai!'
				);
			}
		}else{
			$ret = array(
				'status' => 'error',
				'message'	=> 'Format tidak sesuai!'
			);
		}
		die(json_encode($ret));
	}

	function rupiah($total){
		return number_format($total, 0, ',', '.');
	}

	public function tanggalan(string $tanggal){
		
		$tanggal = explode("-", $tanggal);

		$bulan = $this->get_bulan($tanggal[1]);

		return $tanggal[2] . " " . $bulan . " " . $tanggal[0];		
	}

	public function get_bulan($bulan) {
		if(!empty($bulan)){
			$bulan = (int) $bulan;
		}
		if(empty($bulan)){
			$bulan = date('m');
		}
		$nama_bulan = array(
			"Januari", 
			"Februari", 
			"Maret", 
			"April", 
			"Mei", 
			"Juni", 
			"Juli", 
			"Agustus", 
			"September", 
			"Oktober", 
			"November", 
			"Desember"
		);
		return $nama_bulan[$bulan-1];
	}

	public function pilih_tahun_anggaran_lembur()
	{
		global $wpdb;
		$tahun_aktif = false;
		$class_hide = '';
		if (!empty($_GET) && !empty($_GET['tahun'])) {
			$tahun_aktif = $_GET['tahun'];
			$class_hide = 'display: none;';
		}
		$tahun = $wpdb->get_results('select tahun_anggaran from data_unit_lembur group by tahun_anggaran', ARRAY_A);
		echo "
		<h5 class='text-center' style='" . $class_hide . "'>PILIH TAHUN ANGGARAN</h5>
		<ul class='daftar-tahun-lembur text-center' style='margin: 0 0 10px 0;'>";
		foreach ($tahun as $k => $v) {
			$class = 'btn-primary';
			if ($tahun_aktif == $v['tahun_anggaran']) {
				$class = 'btn-success';
			}
			echo "<a href='?tahun=" . $v['tahun_anggaran'] . "' class='btn " . $class . "'>" . $v['tahun_anggaran'] . "</a>";
		}
		echo "</ul>";
	}

	function menu_spt_lembur(){
		global $wpdb;
		$user_id = um_user( 'ID' );
		$user_meta = get_userdata($user_id);
		$html = '';
		if (!empty($_GET) && !empty($_GET['tahun'])) {
			echo '<h1 class="text-center">TAHUN ANGGARAN TERPILIH<br>' . $_GET['tahun'] . '</h1>';
		}
		if(empty($user_meta->roles)){
			echo 'User ini tidak dapat akses sama sekali :)';
		}
		$this->pilih_tahun_anggaran_lembur();
		if (empty($_GET) || empty($_GET['tahun'])) {
			return;
		}

		$pegawai = $wpdb->get_results("
			SELECT 
				id,
				nip,
				nik,
				id_skpd
			FROM data_pegawai_lembur
			WHERE active = 1
			and nip='".$user_meta->data->user_login."' OR nik='".$user_meta->data->user_login."'
			", ARRAY_A
		);
		foreach ($pegawai as $peg) {
			if(
				in_array("pegawai", $user_meta->roles)
			){
				$menu_laporan_absensi = '';
				$id_pegawai_lembur = get_user_meta($user_id, 'id_pegawai_lembur');
				if(!empty($id_pegawai_lembur)){
					$menu_absensi_pegawai_lembur = $this->functions->generatePage(array(
						'nama_page' => 'Menu Absensi Pegawai Lembur '.$peg['id'].' '.$peg['id_skpd'].' '.$_GET['tahun'],
						'content' => '[menu_absensi_pegawai_lembur id='.$peg['id'].' id_skpd='.$peg['id_skpd'].' tahun_anggaran='.$_GET['tahun'].']',
						'show_header' => 1,
						'post_status' => 'private'
					));

                    $menu_laporan = $this->functions->generatePage(array(
                            'nama_page' => 'Laporan Absensi Pegawai '.$peg['id'],
                            'content' => '[laporan_bulanan_absensi_pegawai id='.$peg['id'].']',
                            'show_header' => 1,
                            'post_status' => 'private'
                    ));
                    $menu_laporan_absensi = '<li style="display: inline-block"> <a style="margin-left: 10px;" href="'.$menu_laporan['url'].'" target="_blank" class="btn btn-info">Menu Laporan Absensi</a></li>';
					echo '
					<ul class="aksi-lembur text-center">
						<li style="list-style: none; display: inline-block"><a href="'.$menu_absensi_pegawai_lembur['url'].'" target="_blank" class="btn btn-info">Menu Absensi</a></li>
						'.$menu_laporan_absensi.'
					</ul>';
				}else{
					echo 'User ID pegawai tidak ditemukan!';
				}
			}
		}
	
		if(
			in_array("kepala", $user_meta->roles)
			|| in_array("ppk", $user_meta->roles)
			|| in_array("kasubag_keuangan", $user_meta->roles)
			|| in_array("pptk", $user_meta->roles)
		){
			
			$id_pegawai_lembur = get_user_meta($user_id, 'id_pegawai_lembur');
			if(!empty($id_pegawai_lembur)){
				$input_spt_lembur = $this->functions->generatePage(array(
					'nama_page' => 'Input SPT Lembur',
					'content' => '[input_spt_lembur]',
					'show_header' => 1,
					'post_status' => 'private'
				));
				$menu_spj = '';
				if(
					in_array("kasubag_keuangan", $user_meta->roles)
					|| in_array("pptk", $user_meta->roles)
				){
					$input_spj_lembur = $this->functions->generatePage(array(
						'nama_page' => 'Input SPJ Lembur',
						'content' => '[input_spj_lembur]',
						'show_header' => 1,
						'post_status' => 'private'
					));
					$menu_spj = '<li style="display: inline-block"> <a style="margin-left: 10px;" href="'.$input_spj_lembur['url'].'" target="_blank" class="btn btn-info">SPJ Lembur</a></li>';
				}
				echo '
				<ul class="aksi-lembur text-center">
					<li style="list-style: none; display: inline-block"><a href="'.$input_spt_lembur['url'].'" target="_blank" class="btn btn-info">SPT Lembur</a></li>
					'.$menu_spj.'
				</ul>';
			}else{
				echo 'User ID pegawai tidak ditemukan!';
			}
		}
	}

	function verifikasi_spt_lembur($no_return=false){
		global $wpdb;
		$ret = array(
			'status'	=> 'success',
			'message'	=> 'Berhasil verifikasi SPT!'
		);
		if (!empty($_POST)) {
			if (!empty($_POST['api_key']) && $_POST['api_key'] == get_option( SIMPEG_APIKEY )) {
				$user_id = um_user( 'ID' );
				$user_meta = get_userdata($user_id);
				$data = json_decode(stripslashes($_POST['data']), true);
				if(empty($data['tipe_verifikasi'])){
					$ret['status'] = 'error';
					$ret['message'] = 'Tipe verifikasi tidak boleh kosong!';
				}else if(empty($data['id_data'])){
					$ret['status'] = 'error';
					$ret['message'] = 'ID SPT tidak boleh kosong!';
				}else{
					$id_spt = $data['id_data'];
					$tipe_verifikasi = $data['tipe_verifikasi'];
					$spt = $wpdb->get_row($wpdb->prepare("
						select 
							* 
						from data_spt_lembur 
						where id=%d
					", $id_spt), ARRAY_A);
					$spt_detail = $wpdb->get_results($wpdb->prepare("
						select 
							* 
						from data_spt_lembur_detail 
						where active=1
							AND id_spt=%d
					", $id_spt), ARRAY_A);
					$spt_detail_all = array();
					foreach($spt_detail as $detail){
						$spt_detail_all[] = array(
							'jenis_user' => 'pptk',
							'id_spt' => $id_spt,
							'id_pegawai' => $detail['id_pegawai'],
							'id_standar_harga_lembur' => $detail['id_standar_harga_lembur'],
							'id_standar_harga_makan' => $detail['id_standar_harga_makan'],
							'uang_lembur' => $detail['uang_lembur'],
							'uang_makan' => $detail['uang_makan'],
							'jml_hari' => $detail['jml_hari'],
							'jml_jam' => $detail['jml_jam'],
							'jml_pajak' => $detail['jml_pajak'],
							'waktu_mulai' => $detail['waktu_mulai'],
							'waktu_akhir' => $detail['waktu_akhir'],
							'waktu_mulai_hadir' => $detail['waktu_mulai_hadir'],
							'waktu_akhir_hadir' => $detail['waktu_akhir_hadir'],
							'tipe_hari' => $detail['tipe_hari'],
							'update_user' => $user_meta->display_name,
							'update_at' => current_time('mysql')
						);
					}
					$option_spt = array(
						'jenis_user' => 'pptk',
						'id_spt' => $id_spt,
						'nomor_spt' => $spt['nomor_spt'],
						'waktu_mulai_spt' => $spt['waktu_mulai_spt'],
						'waktu_selesai_spt' => $spt['waktu_selesai_spt'],
						'tahun_anggaran' => $spt['tahun_anggaran'],
						'id_skpd' => $spt['id_skpd'],
						'jml_hari' => $spt['jml_hari'],
						'jml_peg' => $spt['jml_peg'],
						'jml_jam' => $spt['jml_jam'],
						'uang_makan' => $spt['uang_makan'],
						'uang_lembur' => $spt['uang_lembur'],
						'jml_pajak' => $spt['jml_pajak'],
						'dasar_lembur' => $spt['dasar_lembur'],
						'ket_lembur' => $spt['ket_lembur'],
						'update_user' => $user_meta->display_name,
						'update_at' => current_time('mysql')
					);
					if(
						$tipe_verifikasi == 'pptk'
						&& (
							in_array("pptk", $user_meta->roles)
							||in_array("administrator", $user_meta->roles)
						)
					){
						$option_spt['jenis_user'] = $tipe_verifikasi;
						$wpdb->delete('data_spt_lembur_history', array( 
							'id_spt' => $id_spt ,
							'jenis_user' => $option_spt['jenis_user']
						));
						$wpdb->insert('data_spt_lembur_history', $option_spt);
						$wpdb->delete('data_spt_lembur_detail_history', array( 
							'id_spt' => $id_spt ,
							'jenis_user' => $option_spt['jenis_user']
						));
						foreach($spt_detail_all as $detail){
							$detail['jenis_user'] = $option_spt['jenis_user'];
							$wpdb->insert('data_spt_lembur_detail_history', $detail);
						}
						$wpdb->update('data_spt_lembur', array(
							'status' => 1 // status SPT menjadi verifikasi kasubag keuangan
						), array(
							'id' => $id_spt
						));
						$ret['message'] = 'Berhasil submit data SPT oleh PPTK!';
					}else if(
						$tipe_verifikasi == 'kasubag_keuangan'
						&& (
							in_array("kasubag_keuangan", $user_meta->roles)
							||in_array("administrator", $user_meta->roles)
						)
					){
						$status_ver = 0;
						$status_spt = 0;
						if(!empty($data['status_bendahara'])){
							$status_ver = 1;
							$status_spt = 2; // status SPT menjadi verifikasi PPK
						}else{
							if(empty($data['keterangan_status_bendahara'])){
								$ret['status'] = 'error';
								$ret['message'] = 'Keterangan harus diisi jika status ditolak';
							}else{
								$ret['message'] = 'Berhasil tidak menyetujui pengajuan SPT oleh Kasubag Keuangan!';
							}
						}
						if($ret['status'] != 'error'){
							$options = array(
								'status' => $status_spt,
								'status_ver_bendahara' => $status_ver,
								'ket_ver_bendahara' => $data['keterangan_status_bendahara']
							);
							$wpdb->update('data_spt_lembur', $options, array(
								'id' => $id_spt
							));
						}
					}else if(
						$tipe_verifikasi == 'ppk'
						&& (
							in_array("ppk", $user_meta->roles)
							||in_array("administrator", $user_meta->roles)
						)
					){
						$option_spt['jenis_user'] = $tipe_verifikasi;
						$wpdb->delete('data_spt_lembur_history', array( 
							'id_spt' => $id_spt ,
							'jenis_user' => $option_spt['jenis_user']
						));
						$wpdb->insert('data_spt_lembur_history', $option_spt);
						$wpdb->delete('data_spt_lembur_detail_history', array( 
							'id_spt' => $id_spt ,
							'jenis_user' => $option_spt['jenis_user']
						));
						foreach($spt_detail_all as $detail){
							$detail['jenis_user'] = $option_spt['jenis_user'];
							$wpdb->insert('data_spt_lembur_detail_history', $detail);
						}
						// status SPT menjadi verifikasi kepala
						$wpdb->update('data_spt_lembur', array(
							'status' => 3
						), array(
							'id' => $id_spt
						));
						$ret['message'] = 'Berhasil verifikasi data SPT oleh PPK SKPD!';
					}else if(
						$tipe_verifikasi == 'kepala'
						&& (
							in_array("kepala", $user_meta->roles)
							||in_array("administrator", $user_meta->roles)
						)
					){
						// status SPT menjadi menunggu submit SPJ
						$wpdb->update('data_spt_lembur', array(
							'status' => 4
						), array(
							'id' => $id_spt
						));
						$ret['message'] = 'Berhasil verifikasi data SPT oleh kepala SKPD!';
					}else if(
						$tipe_verifikasi == 'pptk_spj'
						&& (
							in_array("pptk", $user_meta->roles)
							||in_array("administrator", $user_meta->roles)
						)
					){
						$spj = $wpdb->get_row($wpdb->prepare("
							select 
								* 
							from data_spj_lembur 
							where id_spt=%d
						", $id_spt), ARRAY_A);
						// print_r($spj); die($wpdb->last_query);
						if(empty($spj)){
							$ret['status'] = 'error';
							$ret['message'] = 'SPJ untuk nomor SPT '.$spt['nomor_spt'].' belum dibuat!';
						}else if(empty($spj['file_daftar_hadir'])){
							$ret['status'] = 'error';
							$ret['message'] = 'File daftar hadir tidak boleh kosong!';
						}else if(empty($spj['foto_lembur'])){
							$ret['status'] = 'error';
							$ret['message'] = 'File foto lembur tidak boleh kosong!';
						}
						if($ret['status'] != 'error'){
							// status SPT menjadi SPJ Diverifikasi kasubag keuangan
							$wpdb->update('data_spt_lembur', array(
								'status' => 5
							), array(
								'id' => $id_spt
							));
							$ret['message'] = 'Berhasil submit data SPJ oleh PPTK!';
						}
					}else if(
						$tipe_verifikasi == 'kasubag_keuangan_spj'
						&& (
							in_array("kasubag_keuangan", $user_meta->roles)
							||in_array("administrator", $user_meta->roles)
						)
					){
						$spj = $wpdb->get_row($wpdb->prepare("
							select 
								* 
							from data_spj_lembur 
							where id_spt=%d
						", $id_spt), ARRAY_A);
						if(empty($spj)){
							$ret['status'] = 'error';
							$ret['message'] = 'SPJ untuk nomor SPT '.$spt['nomor_spt'].' belum dibuat!';
						}else if(empty($spj['file_daftar_hadir'])){
							$ret['status'] = 'error';
							$ret['message'] = 'File daftar hadir tidak boleh kosong!';
						}else if(empty($spj['foto_lembur'])){
							$ret['status'] = 'error';
							$ret['message'] = 'File foto lembur tidak boleh kosong!';
						}
						if($ret['status'] != 'error'){
							$status_ver = 0;
							$status_spt = 4;
							if(!empty($data['status_bendahara'])){
								$status_ver = 1;
								$status_spt = 6; // status SPT menjadi selesai
								$ret['message'] = 'Berhasil melakukan verifikasi SPJ oleh Kasubag Keuangan!';
							}else{
								if(empty($data['keterangan_status_bendahara'])){
									$ret['status'] = 'error';
									$ret['message'] = 'Keterangan harus diisi jika pengajuan SPJ ditolak';
								}else{
									$ret['message'] = 'Berhasil tidak menyetujui pengajuan SPJ oleh Kasubag Keuangan!';
								}
							}
						}
						if($ret['status'] != 'error'){
							$options = array(
								'status' => $status_spt,
								'status_ver_bendahara_spj' => $status_ver,
								'ket_ver_bendahara_spj' => $data['keterangan_status_bendahara']
							);
							$wpdb->update('data_spt_lembur', $options, array(
								'id' => $id_spt
							));
						}
					}else{
						$ret['status'] = 'error';
						$ret['message'] = 'Sistem tidak dapat melakukan verifikasi, hubungi admin!';
					}
				}
			}else{
				$ret = array(
					'status' => 'error',
					'message'	=> 'Api Key tidak sesuai!'
				);
			}
		}else{
			$ret = array(
				'status' => 'error',
				'message'	=> 'Format tidak sesuai!'
			);
		}
		if($no_return){
			return $ret;
		}else{
			die(json_encode($ret));
		}
	}

	public function import_data_spt_lembur(){
		global $wpdb;
		$ret = array(
			'status'	=> 'success',
				'message'	=> 'Berhasil import excel!'
		);
		if (!empty($_POST)) {
			if (!empty($_POST['api_key']) && $_POST['api_key'] == get_option( SIMPEG_APIKEY )) {
				$user_id = um_user( 'ID' );
				$user_meta = get_userdata($user_id);
				$data = json_decode(stripslashes($_POST['import_data']), true);

        		$date1 = new DateTime($data[0]['tanggal_mulai_spt'].'T00:00:00');
				$date2 = new DateTime($data[0]['tanggal_selesai_spt'].'T00:00:00');
				$diff = $date2->diff($date1);
				$hari = $diff->days+1;

				$data_db = array(
                    'nomor_spt'=> $data[0]['nomor_spt'],
					'id_skpd'=> $data[0]['id_skpd'],
                    'tahun_anggaran'=> $data[0]['tahun_anggaran'],
                    'waktu_mulai_spt'=> $data[0]['tanggal_mulai_spt'],
                    'waktu_selesai_spt'=> $data[0]['tanggal_selesai_spt'],
		            'uang_lembur'=> 0, 
		            'uang_makan'=> 0, 
		            'dasar_lembur'=> $data[0]['dasar_lembur'], 
		            'ket_lembur'=> $data[0]['ket_lembur'], 
		            'jml_hari'=> $hari, 
		            'jml_jam'=> 0, 
		            'jml_peg'=> 0, 
		            'jml_pajak'=> 0,
                    'user' => $user_meta->display_name,
                    'update_at' => current_time('mysql'),
					'active' => 1
				);
                $data_detail_lembur = array();

            	$sbu = $wpdb->get_results($wpdb->prepare("
            		SELECT 
            			* 
            		from data_sbu_lembur 
            		where tahun=%d
            			AND active=1
            	", $data[0]['tahun_anggaran']), ARRAY_A);
            	$newSbu = array();
            	foreach($sbu as $val){
            		if(empty($newSbu[$val['jenis_sbu']])){
            			$newSbu[$val['jenis_sbu']] = array();
            		}
            		if(empty($newSbu[$val['jenis_sbu']][$val['id_golongan']])){
            			$newSbu[$val['jenis_sbu']][$val['id_golongan']] = array();
            		}
            		if(empty($newSbu[$val['jenis_sbu']][$val['id_golongan']][$val['jenis_hari']])){
            			$newSbu[$val['jenis_sbu']][$val['id_golongan']][$val['jenis_hari']] = $val;
            		}
            	}

            	$uang_lembur_all = 0;
            	$uang_makan_all = 0;
            	$jml_jam_all = 0;
            	$pajak_all = 0;
            	$jml_peg = array();
	            foreach($data as $key => $pegawai){
	            	$sbu = array();
	            	$detail_peg = $wpdb->get_row($wpdb->prepare("
	            		SELECT 
	            			* 
	            		from data_pegawai_lembur 
	            		where id=%d
	            	", $pegawai['id_pegawai']), ARRAY_A);
            		$date1 = new DateTime(str_replace(' ', 'T', $pegawai['waktu_mulai']));
					$date2 = new DateTime(str_replace(' ', 'T', $pegawai['waktu_selesai']));
					$diff = $date2->diff($date1);
					$hours = $diff->h;
					$hours = $hours + ($diff->days*24);
					$jml_jam_all += $hours;
					$hari_pegawai = $diff->days+1;

	            	$jml_peg[$pegawai['id_pegawai']] = true;
	            	$sbu_lembur = $newSbu['uang_lembur'][$detail_peg['kode_gol']][$pegawai['jenis_hari']];
	                $uang_lembur = $sbu_lembur['harga'] * $hours;
	                $id_standar_harga_lembur = $sbu_lembur['id'];
	            	$pajak = 0;
                	if(!empty($sbu_lembur['pph_21'])){
            			$pajak += ($uang_lembur*$sbu_lembur['pph_21'])/100;
                	}

            		$uang_lembur_all += $uang_lembur;
	            	
	            	$id_standar_harga_makan = 0;
	            	$uang_makan = 0;
					if($hours >= 2){
	            		if($pegawai['uang_makan'] == 1){
	            			$sbu_makan = $newSbu['uang_makan'][$detail_peg['kode_gol']][0];
		  		            $id_standar_harga_makan = $sbu_makan['id'];
		                	$uang_makan = $sbu_makan['harga'];
		                	if(!empty($sbu_makan['pph_21'])){
		            			$pajak += ($uang_makan*$sbu_makan['pph_21'])/100;
		                	}
	            			$uang_makan_all += $uang_makan;
	            		}
					}
            		$pajak_all += $pajak;
	            	$data_detail_lembur[] = array(
	            		'id_spt' => '',
						'id_pegawai' => $pegawai['id_pegawai'],
						'id_standar_harga_lembur' => $id_standar_harga_lembur,
						'id_standar_harga_makan' => $id_standar_harga_makan,
						'uang_lembur' => $uang_lembur,
						'uang_makan' => $uang_makan,
						'jml_hari' => $hari_pegawai,
						'jml_jam' => $hours,
						'jml_pajak' => $pajak,
						'waktu_mulai' => $pegawai['waktu_mulai'],
						'waktu_akhir' => $pegawai['waktu_selesai'],
						'tipe_hari' => $pegawai['jenis_hari'],
						'update_at' => current_time('mysql'),
						'active' => 1
	            	);
	            }
				$data_db['uang_lembur'] = $uang_lembur_all;
				$data_db['uang_makan'] = $uang_makan_all;
				$data_db['jml_pajak'] = $pajak_all;
				$data_db['jml_jam'] = $jml_jam_all;
				$data_db['jml_peg'] = count($jml_peg);

	            $data_db['status'] = 0;
                $cek_id = $wpdb->get_row($wpdb->prepare('
                    SELECT
                        id,
                        nomor_spt,
                        active
                    FROM data_spt_lembur
                    WHERE nomor_spt=%s
                    	AND tahun_anggaran=%d
                ', $nomor_spt, $tahun_anggaran), ARRAY_A);
                if(empty($cek_id)){
                    $cek = $wpdb->insert('data_spt_lembur', $data_db);
                    if(!empty($cek)){
                    	$data['id_data'] = $wpdb->insert_id;
                    }else{
                        $ret['status'] = 'error';
                        $ret['message'] = 'Gagal disimpan. '.$wpdb->last_error;
                    }
                }else{
                    if($cek_id['active'] == 0){
                    	$data['id_data'] = $cek_id['id'];
                        $wpdb->update('data_spt_lembur', $data_db, array(
                            'id' => $cek_id['id']
                        ));
                    }else{
                        $ret['status'] = 'error';
                        $ret['message'] = 'Gagal disimpan. Data SPT dengan nomor_spt="'.$cek_id['nomor_spt'].'" sudah ada!';
                    }
                }
	            if($ret['status'] != 'error'){
                    $wpdb->update('data_spt_lembur_detail', array('active' => 0), array(
                        'id_spt' => $data['id_data']
                    ));
	            	foreach($data_detail_lembur as $detail_lembur){
	            		$detail_lembur['id_spt'] = $data['id_data'];
	                    if(empty($detail_lembur['id'])){
	                        $wpdb->insert('data_spt_lembur_detail', $detail_lembur);
	                    }else{
                            $wpdb->update('data_spt_lembur_detail', $detail_lembur, array(
                                'id' => $detail_lembur['id']
                            ));
                        }
                        if(!empty($wpdb->last_error)){
                        	$ret['error'][] = $wpdb->last_error.' '.$wpdb->last_query;
                        }
	            	}
	            }
			}else{
				$ret = array(
					'status' => 'error',
					'message'	=> 'Api Key tidak sesuai!'
				);
			}
		}else {
			$ret['status'] = 'error';
			$ret['message'] = 'Format Salah!';
		}
		die(json_encode($ret));
	}
	public function get_pegawai_absensi_simpeg(){
	    global $wpdb;
	    $ret = array(
	        'status' => 'success',
	        'message' => 'Berhasil get data!',
	        'data' => array()
	    );
	    if(!empty($_POST)){
	        if(!empty($_POST['api_key']) && $_POST['api_key'] == get_option(SIMPEG_APIKEY)) {
	            $tahun_anggaran = $_POST['tahun_anggaran'];
	            $ret['data'] = $wpdb->get_results($wpdb->prepare('
	                SELECT 
	                    *
	                FROM data_pegawai_lembur
	                WHERE id_skpd=%d
	                    AND active=1
	                    AND tahun=%d
	                    AND id=%d
	            ', $_POST['id_skpd'], $tahun_anggaran, $_POST['id']), ARRAY_A);
	            foreach($ret['data'] as $pegawai){
	                $html = '<option golongan="'.$pegawai['kode_gol'].'" value="'.$pegawai['id'].'">'.$pegawai['gelar_depan'].' '.$pegawai['nama'].' '.$pegawai['gelar_belakang'].' (ID = '.$pegawai['id'].')</option>';
	            }
	            $ret['html'] = $html;
	        }else{
	            $ret['status']  = 'error';
	            $ret['message'] = 'Api key tidak ditemukan!';
	        }
	    }else{
	        $ret['status']  = 'error';
	        $ret['message'] = 'Format Salah!';
	    }

	    die(json_encode($ret));
	}

	public function get_data_absensi_lembur_by_id(){
	    global $wpdb;
	    $ret = array(
	        'status' => 'success',
	        'message' => 'Berhasil get data!',
	        'data' => array()
	    );
	    if(!empty($_POST)){
	        if(!empty($_POST['api_key']) && $_POST['api_key'] == get_option( SIMPEG_APIKEY )) {
	            $ret['data'] = $wpdb->get_row($wpdb->prepare('
	                 SELECT 
                        *
                    FROM data_absensi_lembur
                    WHERE id=%d
                    	AND active=1
	            ', $_POST['id']), ARRAY_A);
	            $ret['data_detail'] = $wpdb->get_results($wpdb->prepare('
	                 SELECT 
                        *
                    FROM data_absensi_lembur_detail
                    WHERE id_spt=%d
                    	AND active=1
	            ', $_POST['id']), ARRAY_A);
	        }else{
	            $ret['status']  = 'error';
	            $ret['message'] = 'Api key tidak ditemukan!';
	        }
	    }else{
	        $ret['status']  = 'error';
	        $ret['message'] = 'Format Salah!';
	    }

	    die(json_encode($ret));   
	}	

	public function get_datatable_data_absensi_lembur(){
	    global $wpdb;
	    $ret = array(
	        'status' => 'success',
	        'message' => 'Berhasil get data!',
	        'data'  => array()
	    );

	    if(!empty($_POST)){
	        if (!empty($_POST['api_key']) && $_POST['api_key'] == get_option( SIMPEG_APIKEY )) {
	            $user_id = um_user( 'ID' );
	            $user_meta = get_userdata($user_id);
	            $params = $columns = $totalRecords = $data = array();
	            $params = $_REQUEST;
	            $columns = array( 
	            	'u.nama_skpd',
	            	's.user',
	            	's.jml_peg',
	            	's.jml_jam',
	            	's.uang_makan',
	            	's.uang_lembur',
	            	's.jml_pajak',
	            	's.ket_lembur',
	            	's.file_lampiran',
	            	's.update_at',
	            	's.status',
	            	's.total_nilai',
	            	's.status_ver_admin', 
	            	's.ket_ver_admin',
	            	'p.nama_lengkap',
	            	's.created_at',
	            	'd.waktu_mulai',
	            	'd.waktu_akhir',
	              	's.id'
	            );
	            $where = $sqlTot = $sqlRec = "";

	            if( !empty($params['search']['value']) ) { 
	                $where .=" OR u.nama_skpd LIKE ".$wpdb->prepare('%s', "%".$params['search']['value']."%");
	                $where .=" OR s.ket_lembur LIKE ".$wpdb->prepare('%s', "%".$params['search']['value']."%");
	            }

	            // getting total number records without any search
	            $sql_tot = "SELECT count(id) as jml FROM `data_absensi_lembur` s";
	            $sql = "
	            	SELECT 
	            		".implode(', ', $columns)." 
	            	FROM `data_absensi_lembur` s
				    INNER JOIN data_absensi_lembur_detail d on d.id_spt = s.id
				        AND s.active = d.active
				    INNER JOIN data_pegawai_lembur p on d.id_pegawai = p.id
				        AND p.active = d.active
				        AND p.tahun = s.tahun_anggaran
	            	INNER JOIN data_unit_lembur as u on s.id_skpd=u.id_skpd
	            		AND s.tahun_anggaran=u.tahun_anggaran
	            		AND s.active=u.active";
	            $where_first = " WHERE s.active=1 ";
	            $sqlTot = $sql_tot.$where_first;
	            $where_first .= "AND p.id=".$_POST['id'];
	            $sqlRec = $sql.$where_first;
	            if(isset($where) && $where != '') {
	                $sqlTot .= $where;
	                $sqlRec .= $where;
	            }

                $limit = '';
                if($params['length'] != -1){
                    $limit = "  LIMIT ".$wpdb->prepare('%d', $params['start'])." ,".$wpdb->prepare('%d', $params['length']);
                }
            	$sqlRec .=  " ORDER BY s.created_at DESC".$limit;

                $queryTot = $wpdb->get_results($sqlTot, ARRAY_A);
                $totalRecords = $queryTot[0]['jml'];
                $queryRecords = $wpdb->get_results($sqlRec, ARRAY_A);
                $is_admin = in_array("administrator", $user_meta->roles);

                foreach($queryRecords as $recKey => $recVal){
                	$queryRecords[$recKey]['total_nilai'] = $recVal['uang_makan'] + $recVal['uang_lembur'] - $recVal['jml_pajak'];

                    $btn = '<a class="btn btn-sm btn-primary" onclick="detail_data(\''.$recVal['id'].'\'); return false;" href="#" title="Detail Data"><i class="dashicons dashicons-search"></i></a>';
					if($recVal['status'] == 0){
                    $btn .= '<a class="btn btn-sm btn-warning" onclick="edit_data(\''.$recVal['id'].'\'); return false;" href="#" title="Edit Data"><i class="dashicons dashicons-edit"></i></a>';
                    $btn .= '<a class="btn btn-sm btn-danger" onclick="hapus_data(\''.$recVal['id'].'\'); return false;" href="#" title="Edit Data"><i class="dashicons dashicons-trash"></i></a>';
                        $btn .= '<a style="margin-top: 5px;" class="btn btn-sm btn-primary" onclick="submit_data(\''.$recVal['id'].'\'); return false;" href="#" title="Submit Data"><i class="dashicons dashicons-migrate"></i></a>';
	                    if ($recVal['status_ver_admin'] == '0'){
	                        $pesan = '<br><b>Keterangan:</b> '.$recVal['ket_ver_admin']; 
	                    	$queryRecords[$recKey]['status'] = '<span class="btn btn-danger btn-sm">Absensi Ditolak</span>'.$pesan;
	                    }else{
	                    	$queryRecords[$recKey]['status'] = '<span class="btn btn-primary btn-sm">Menunggu Submit</span>';
	                    }
	                }else if($recVal['status'] == 1) {
	                	if($is_admin) {
	                    	$btn .= '<a style="margin-top: 5px;" class="btn btn-sm btn-success" onclick="verifikasi_admin(\''.$recVal['id'].'\'); return false;" href="#" title="Verifikasi Admin"><i class="dashicons dashicons-yes"></i></a>';
	                    	$btn .= '<a class="btn btn-sm btn-warning" onclick="edit_data(\''.$recVal['id'].'\'); return false;" href="#" title="Edit Data"><i class="dashicons dashicons-edit"></i></a>';
                    		$btn .= '<a class="btn btn-sm btn-danger" onclick="hapus_data(\''.$recVal['id'].'\'); return false;" href="#" title="Edit Data"><i class="dashicons dashicons-trash"></i></a>';
	                	}
		                $queryRecords[$recKey]['status'] = '<span class="btn btn-success btn-sm">Menunggu verifikasi Admin</span>';
	                }elseif($recVal['status'] == 2) {
	                    $queryRecords[$recKey]['status'] = '<span class="btn btn-primary btn-sm">Selesai</span>';
	                }else{
	                    $queryRecords[$recKey]['status'] = '<span class="btn btn-danger btn-sm">Not Found</span>';
	                }
	                $queryRecords[$recKey]['aksi'] = $btn;
	                $queryRecords[$recKey]['file_lampiran'] = '<a href="' . SIMPEG_PLUGIN_URL . 'public/media/simpeg/' . $recVal['file_lampiran'] . '" target="_blank"><img src="' . SIMPEG_PLUGIN_URL . 'public/media/simpeg/' . $recVal['file_lampiran'] . '" alt="' . $recVal['file_lampiran'] . '" style="max-width:100%;height:auto;"></a>';
	                $queryRecords[$recKey]['uang_lembur'] = $this->rupiah($recVal['uang_lembur']);
	                $queryRecords[$recKey]['uang_makan'] = $this->rupiah($recVal['uang_makan']);
	                $queryRecords[$recKey]['jml_pajak'] = $this->rupiah($recVal['jml_pajak']);
	                $queryRecords[$recKey]['total_nilai'] = $this->rupiah($queryRecords[$recKey]['total_nilai']);
	            }
	     
	            $json_data = array(
	                "draw"            => intval( $params['draw'] ),   
	                "recordsTotal"    => intval( $totalRecords ),  
	                "recordsFiltered" => intval($totalRecords),
	                "data"            => $queryRecords,
	                "sql"             => $sqlRec
	            );

	            die(json_encode($json_data));
	        }else{
	            $return = array(
	                'status' => 'error',
	                'message'   => 'Api Key tidak sesuai!'
	            );
	        }
	    }else{
	        $return = array(
	            'status' => 'error',
	            'message'   => 'Format tidak sesuai!'
	        );
	    }
	    die(json_encode($return));
	} 


	public function tambah_data_absensi_lembur() {
		global $wpdb;
		$ret = array(
			'status' => 'success',
			'message' => 'Berhasil simpan data!',
			'error' => array(),
			'data' => array()
		);

		if (!empty($_POST)) {
			if (!empty($_POST['api_key']) && $_POST['api_key'] == get_option(SIMPEG_APIKEY)) {
				$data = json_decode(stripslashes($_POST['data']), true);
				
				if ($ret['status'] != 'error' && empty($data['tahun_anggaran'])) {
					$ret['status'] = 'error';
					$ret['message'] = 'Pilih Tahun dulu!';
				}
				if ($ret['status'] != 'error' && empty($data['id_skpd'])) {
					$ret['status'] = 'error';
					$ret['message'] = 'Pilih SKPD dulu!';
				}
				if ($ret['status'] != 'error' && empty($data['waktu_mulai_spt'])) {
					$ret['status'] = 'error';
					$ret['message'] = 'Isi waktu mulai SPT dulu!';
				}
				if ($ret['status'] != 'error' && empty($data['waktu_selesai_spt'])) {
					$ret['status'] = 'error';
					$ret['message'] = 'Isi waktu selesai SPT dulu!';
				}
				if ($ret['status'] != 'error' && empty($data['id_data']) && empty($_FILES['lampiran'])) {
					$ret['status'] = 'error';
					$ret['message'] = 'Lampiran tidak boleh kosong!';
				}

				if ($ret['status'] != 'error' && !empty($data['id_pegawai'])) {
					$pesan = array();
					foreach ($data['id_pegawai'] as $key => $pegawai) {
						if (empty($data['id_pegawai'][$key])) {
							$ret['status'] = 'error';
							$pesan[] = 'Nama pegawai no ' . $key . ' diisi dulu!';
						}
						if (empty($data['waktu_mulai'][$key])) {
							$ret['status'] = 'error';
							$pesan[] = 'Waktu mulai pegawai no ' . $key . ' diisi dulu!';
						}
						if (empty($data['waktu_selesai'][$key])) {
							$ret['status'] = 'error';
							$pesan[] = 'Waktu selesai pegawai no ' . $key . ' diisi dulu!';
						}
					}
					if ($ret['status'] == 'error') {
						$ret['message'] = implode(', ', $pesan);
					}
				}

				if ($ret['status'] != 'error') {
					$tahun_anggaran = $data['tahun_anggaran'];
					$id_skpd = $data['id_skpd'];
					$ket_lembur = $data['ket_lembur'];
					$waktu_mulai_spt = $data['waktu_mulai_spt'];
					$waktu_selesai_spt = $data['waktu_selesai_spt'];
					$latitude = $data['lat'];
					$longitude = $data['lng'];
					$user_id = um_user('ID');
					$user_meta = get_userdata($user_id);
					$uang_makan = 0;
					$uang_lembur = 0;
					$jml_jam = 0;
					$jml_peg = array();
					$jml_pajak = 0;
					$data_opsi_detail = array();
					$data_opsi['status'] = 0;
					foreach ($data['id_pegawai'] as $key => $pegawai) {
						$jml_peg[$data['id_pegawai'][$key]] = '';
						$jml_jam += $data['jml_jam_lembur'][$key];
						$jml_pajak += $data['jml_pajak'][$key];
						$uang_lembur += $data['uang_lembur'][$key];
						$uang_makan += $data['uang_makan'][$key];
						$data_opsi_detail[] = array(
							'id' => $data['id_spt_detail'][$key],
							'id_spt' => '',
							'id_pegawai' => $data['id_pegawai'][$key],
							'id_standar_harga_lembur' => $data['id_standar_harga_lembur'][$key],
							'id_standar_harga_makan' => $data['id_standar_harga_makan'][$key],
							'uang_lembur' => $data['uang_lembur'][$key],
							'uang_makan' => $data['uang_makan'][$key],
							'jml_hari' => $data['jml_hari_lembur'][$key],
							'jml_jam' => $data['jml_jam_lembur'][$key],
							'jml_pajak' => $data['jml_pajak'][$key],
							'waktu_mulai' => $data['waktu_mulai'][$key],
							'waktu_akhir' => $data['waktu_selesai'][$key],
							'waktu_mulai_hadir' => '',
							'waktu_akhir_hadir' => '',
							'tipe_hari' => $data['jenis_hari'][$key],
							'keterangan' => $data['keterangan'][$key],
							'file_lampiran' => '',
							'update_at' => current_time('mysql'),
							'active' => 1
						);
					}

					$data_opsi = array(
						'id_skpd' => $id_skpd,
						'tahun_anggaran' => $tahun_anggaran,
						'waktu_mulai_spt' => $data['waktu_mulai_spt'],
						'waktu_selesai_spt' => $data['waktu_selesai_spt'],
						'uang_makan' => $uang_makan,
						'uang_lembur' => $uang_lembur,
						'ket_lembur' => $ket_lembur,
						'jml_hari' => $data['jml_hari'],
						'jml_jam' => $jml_jam,
						'jml_peg' => count($jml_peg),
						'jml_pajak' => $jml_pajak,
						'lng' => $longitude,
						'lat' => $latitude,
						'user' => $user_meta->display_name,
						'update_at' => current_time('mysql'),
						'active' => 1
					);

					$path = SIMPEG_PLUGIN_PATH . 'public/media/simpeg/';
					$cek_file = array();

					if ($ret['status'] != 'error' && !empty($_FILES['lampiran'])) {
						$upload = CustomTraitSimpeg::uploadFileSimpeg($_POST['api_key'], $path, $_FILES['lampiran'], ['jpg', 'jpeg', 'png', 'pdf']);
						if ($upload['status'] == true) {
							$data_opsi['file_lampiran'] = $upload['filename'];
							$cek_file['file_lampiran'] = $data_opsi['file_lampiran'];
						} else {
							$ret['status'] = 'error';
							$ret['message'] = $upload['message'];
						}
					}

					if ($ret['status'] == 'error') {
						// Hapus file yang sudah terlanjur upload karena ada file yang gagal upload
						foreach ($cek_file as $newfile) {
							if (is_file($path . $newfile)) {
								unlink($path . $newfile);
							}
						}
					}

					if ($ret['status'] != 'error') {
						if (!empty($data['id_data'])) {
							$file_lama = $wpdb->get_row($wpdb->prepare('
								SELECT 
									file_lampiran 
								FROM data_absensi_lembur 
								WHERE id=%d
							', $data['id_data']), ARRAY_A);
							if ($file_lama['file_lampiran'] != $data_opsi['file_lampiran']
                            	&& is_file($path . $file_lama['file_lampiran'])) {
								unlink($path . $file_lama['file_lampiran']);
							}
							$wpdb->update('data_absensi_lembur', $data_opsi, array('id' => $data['id_data']));
							$ret['message'] = 'Berhasil update data!';
						} else {
                        	$data_opsi['created_at'] = current_time('mysql');
							$wpdb->insert('data_absensi_lembur', $data_opsi);
							$data['id_data'] = $wpdb->insert_id;
						}
					}

					if ($ret['status'] != 'error') {
						$wpdb->update('data_absensi_lembur_detail', array('active' => 0), array('id_spt' => $data['id_data']));
						foreach ($data_opsi_detail as $opsi) {
							$opsi['id_spt'] = $data['id_data'];
							if (empty($opsi['id'])) {
								$wpdb->insert('data_absensi_lembur_detail', $opsi);
							} else {
								$wpdb->update('data_absensi_lembur_detail', $opsi, array('id' => $opsi['id']));
							}
						}
					}
				}
			} else {
				$ret['status'] = 'error';
				$ret['message'] = 'API Key tidak ditemukan!';
			}
		}

		wp_send_json($ret);
	}

	public function hapus_data_absensi_lembur_by_id(){
	    global $wpdb;
	    $ret = array(
	        'status' => 'success',
	        'message' => 'Berhasil hapus data!',
	        'data' => array()
	    );
	    if(!empty($_POST)){
	        if(!empty($_POST['api_key']) && $_POST['api_key'] == get_option( SIMPEG_APIKEY )) {
	            $ret['data'] = $wpdb->update('data_absensi_lembur', array('active' => 0), array(
	                'id' => $_POST['id']
	            ));
	        }else{
	            $ret['status']  = 'error';
	            $ret['message'] = 'Api key tidak ditemukan!';
	        }
	    }else{
	        $ret['status']  = 'error';
	        $ret['message'] = 'Format Salah!';
	    }

	    die(json_encode($ret));
	}

	function verifikasi_absensi_lembur($no_return=false) {
    global $wpdb;
    $ret = array(
        'status' => 'success',
        'message' => 'Berhasil verifikasi!'
    );

    if (!empty($_POST)) {
        if (!empty($_POST['api_key']) && $_POST['api_key'] == get_option(SIMPEG_APIKEY)) {
            $user_id = um_user('ID');
            $user_meta = get_userdata($user_id);
            $data = json_decode(stripslashes($_POST['data']), true);

            if (empty($data['tipe_verifikasi'])) {
                $ret['status'] = 'error';
                $ret['message'] = 'Tipe verifikasi tidak boleh kosong!';
            } else if (empty($data['id_data'])) {
                $ret['status'] = 'error';
                $ret['message'] = 'ID tidak boleh kosong!';
            } else {
                $id = $data['id_data'];
                $tipe_verifikasi = $data['tipe_verifikasi'];

                $absensi = $wpdb->get_row($wpdb->prepare("
                    SELECT * 
                    FROM data_absensi_lembur 
                    WHERE id = %d
                ", $id), ARRAY_A);

                if (!$absensi) {
                    $ret['status'] = 'error';
                    $ret['message'] = 'Data absensi tidak ditemukan!';
                } else {
                    $absensi_detail = $wpdb->get_results($wpdb->prepare("
                        SELECT * 
                        FROM data_absensi_lembur_detail 
                        WHERE active = 1
                          AND id = %d
                    ", $id), ARRAY_A);

                    $absensi_detail_all = array();
                    foreach ($absensi_detail as $detail) {
                        $absensi_detail_all[] = array(
                            'id' => $id,
                            'id_pegawai' => $detail['id_pegawai'],
                            'id_standar_harga_lembur' => $detail['id_standar_harga_lembur'],
                            'id_standar_harga_makan' => $detail['id_standar_harga_makan'],
                            'uang_lembur' => $detail['uang_lembur'],
                            'uang_makan' => $detail['uang_makan'],
                            'jml_hari' => $detail['jml_hari'],
                            'jml_jam' => $detail['jml_jam'],
                            'jml_pajak' => $detail['jml_pajak'],
                            'waktu_mulai' => $detail['waktu_mulai'],
                            'waktu_akhir' => $detail['waktu_akhir'],
                            'waktu_mulai_hadir' => $detail['waktu_mulai_hadir'],
                            'waktu_akhir_hadir' => $detail['waktu_akhir_hadir'],
                            'tipe_hari' => $detail['tipe_hari'],
                            'id_spt' => $detail['id_spt'],
                            'update_user' => $user_meta->display_name,
                            'update_at' => current_time('mysql')
                        );
                    }

                    $option_absensi = array(
                        'id' => $id,
                        'waktu_mulai_spt' => $absensi['waktu_mulai_spt'],
                        'waktu_selesai_spt' => $absensi['waktu_selesai_spt'],
                        'tahun_anggaran' => $absensi['tahun_anggaran'],
                        'id_skpd' => $absensi['id_skpd'],
                        'user' => $absensi['user'],
                        'jml_hari' => $absensi['jml_hari'],
                        'jml_peg' => $absensi['jml_peg'],
                        'jml_jam' => $absensi['jml_jam'],
                        'uang_makan' => $absensi['uang_makan'],
                        'uang_lembur' => $absensi['uang_lembur'],
                        'jml_pajak' => $absensi['jml_pajak'],
                        'ket_lembur' => $absensi['ket_lembur'],
                        'file_lampiran' => $absensi['file_lampiran'],
                        'created_at' => $absensi['created_at'],
                        'update_user' => $user_meta->display_name,
                        'update_at' => current_time('mysql')
                    );

                    if (
                        $tipe_verifikasi == 'pegawai' && (
                            in_array("pegawai", $user_meta->roles) ||
                            in_array("administrator", $user_meta->roles)
                        )
                    ) {
                        $wpdb->delete('data_absensi_lembur', array(
                            'id' => $id,
                        ));

                        $wpdb->insert('data_absensi_lembur', $option_absensi);

                        $wpdb->delete('data_absensi_lembur_detail', array(
                            'id' => $id,
                        ));

                        foreach ($absensi_detail_all as $detail) {
                            $wpdb->insert('data_absensi_lembur_detail', $detail);
                        }

                        $wpdb->update('data_absensi_lembur', array(
                            'status' => 1, // status Absensi menjadi verifikasi admin
                            'update_at' => current_time('mysql')
                        ), array(
                            'id' => $id
                        ));

                        $ret['message'] = 'Berhasil submit data Absensi!';
                    } else if ($tipe_verifikasi == 'admin' && in_array('administrator', $user_meta->roles)) {
                        $status_ver = 0;
                        $status_absensi = 0;

                        if (!empty($data['status_admin'])) {
                            $status_ver = 1;
                            $status_absensi = 2; // status Absensi menjadi Selesai
                        } else {
                            if (empty($data['keterangan_status_admin'])) {
                                $ret['status'] = 'error';
                                $ret['message'] = 'Keterangan harus diisi jika status ditolak';
                            } else {
                                $ret['message'] = 'Berhasil tidak menyetujui pengajuan Absensi oleh Admin!';
                            }
                        }

                        if ($ret['status'] != 'error') {
                            $options = array(
                                'status' => $status_absensi,
                                'status_ver_admin' => $status_ver,
                                'ket_ver_admin' => $data['keterangan_status_admin'],
                                'update_at' => current_time('mysql')
                            );

                            $wpdb->update('data_absensi_lembur', $options, array(
                                'id' => $id
                            ));
                        }
                    } else {
                        $ret['status'] = 'error';
                        $ret['message'] = 'Sistem tidak dapat melakukan verifikasi, hubungi admin!';
                    }
                }
            }
        } else {
            $ret = array(
                'status' => 'error',
                'message' => 'Api Key tidak sesuai!'
            );
        }
    } else {
        $ret = array(
            'status' => 'error',
            'message' => 'Format tidak sesuai!'
        );
    }

    if ($no_return) {
        return $ret;
    } else {
        die(json_encode($ret));
    }
}
    
	public function get_datatable_data_absensi_lembur_admin(){
	    global $wpdb;
	    $ret = array(
	        'status' => 'success',
	        'message' => 'Berhasil get data!',
	        'data'  => array()
	    );

	    if(!empty($_POST)){
	        if (!empty($_POST['api_key']) && $_POST['api_key'] == get_option( SIMPEG_APIKEY )) {
	            $user_id = um_user( 'ID' );
	            $user_meta = get_userdata($user_id);
	            $params = $columns = $totalRecords = $data = array();
	            $params = $_REQUEST;
	            $columns = array( 
	            	'u.nama_skpd',
	            	's.jml_peg',
	            	's.jml_jam',
	            	's.uang_makan',
	            	's.uang_lembur',
	            	's.jml_pajak',
	            	's.ket_lembur',
	            	's.file_lampiran',
	            	's.update_at',
	            	's.created_at',
	            	's.status',
	            	's.status_ver_admin', 
	            	's.total_nilai', 
	            	's.ket_ver_admin',
	            	'p.nama_lengkap',
	            	'd.waktu_mulai',
	            	'd.waktu_akhir',
	              	's.id'
	            );
	            $where = $sqlTot = $sqlRec = "";

	            if( !empty($params['search']['value']) ) { 
	                $where .=" OR u.nama_skpd LIKE ".$wpdb->prepare('%s', "%".$params['search']['value']."%");
	                $where .=" OR s.ket_lembur LIKE ".$wpdb->prepare('%s', "%".$params['search']['value']."%");
	            }

	            // getting total number records without any search
	            $sql_tot = "SELECT count(id) as jml FROM `data_absensi_lembur` s";
	            $sql = "
	            	SELECT 
	            		".implode(', ', $columns)." 
	            	FROM `data_absensi_lembur` s
				    INNER JOIN data_absensi_lembur_detail d on d.id_spt = s.id
				        AND s.active = d.active
				    INNER JOIN data_pegawai_lembur p on d.id_pegawai = p.id
				        AND p.active = d.active
				        AND p.tahun = s.tahun_anggaran
	            	INNER JOIN data_unit_lembur as u on s.id_skpd=u.id_skpd
	            		AND s.tahun_anggaran=u.tahun_anggaran
	            		AND s.active=u.active";
	            $where_first = " WHERE 1=1 AND s.active=1";
	            $sqlTot .= $sql_tot.$where_first;
	            $sqlRec .= $sql.$where_first;
	            if(isset($where) && $where != '') {
	                $sqlTot .= $where;
	                $sqlRec .= $where;
	            }

                $limit = '';
                if($params['length'] != -1){
                    $limit = "  LIMIT ".$wpdb->prepare('%d', $params['start'])." ,".$wpdb->prepare('%d', $params['length']);
                }
            	$sqlRec .=  " ORDER BY s.created_at DESC".$limit;

                $queryTot = $wpdb->get_results($sqlTot, ARRAY_A);
                $totalRecords = $queryTot[0]['jml'];
                $queryRecords = $wpdb->get_results($sqlRec, ARRAY_A);

                $is_admin = in_array("administrator", $user_meta->roles);

                foreach($queryRecords as $recKey => $recVal){
                	$queryRecords[$recKey]['total_nilai'] = $recVal['uang_makan'] + $recVal['uang_lembur'] - $recVal['jml_pajak'];
                    $btn = '<a class="btn btn-sm btn-primary" onclick="detail_data(\''.$recVal['id'].'\'); return false;" href="#" title="Detail Data"><i class="dashicons dashicons-search"></i></a>';
					if($recVal['status'] == 0){
	                    $btn .= '<a class="btn btn-sm btn-warning" onclick="edit_data(\''.$recVal['id'].'\'); return false;" href="#" title="Edit Data"><i class="dashicons dashicons-edit"></i></a>';
	                    $btn .= '<a class="btn btn-sm btn-danger" onclick="hapus_data(\''.$recVal['id'].'\'); return false;" href="#" title="Edit Data"><i class="dashicons dashicons-trash"></i></a>';	        
                        $btn .= '<a style="margin-top: 5px;" class="btn btn-sm btn-primary" onclick="submit_data(\''.$recVal['id'].'\'); return false;" href="#" title="Submit Data"><i class="dashicons dashicons-migrate"></i></a>';          
	                    if ($recVal['status_ver_admin'] == '0'){
	                        $pesan = '<br><b>Keterangan:</b> '.$recVal['ket_ver_admin']; 
	                    	$queryRecords[$recKey]['status'] = '<span class="btn btn-danger btn-sm">Absensi Ditolak</span>'.$pesan;
	                    }else{
	                    	$queryRecords[$recKey]['status'] = '<span class="btn btn-primary btn-sm">Menunggu Submit</span>';
	                    }
	                }else if($recVal['status'] == 1) {
	                	if($is_admin) {
	                    	$btn .= '<a style="margin-top: 5px;" class="btn btn-sm btn-success" onclick="verifikasi_admin(\''.$recVal['id'].'\'); return false;" href="#" title="Verifikasi Admin"><i class="dashicons dashicons-yes"></i></a>';
	                    	$btn .= '<a class="btn btn-sm btn-warning" onclick="edit_data(\''.$recVal['id'].'\'); return false;" href="#" title="Edit Data"><i class="dashicons dashicons-edit"></i></a>';
                    		$btn .= '<a class="btn btn-sm btn-danger" onclick="hapus_data(\''.$recVal['id'].'\'); return false;" href="#" title="Edit Data"><i class="dashicons dashicons-trash"></i></a>';
	                	}
		                $queryRecords[$recKey]['status'] = '<span class="btn btn-success btn-sm">Menunggu verifikasi Admin</span>';
	                }elseif($recVal['status'] == 2) {
	                    $btn .= '<a style="margin-top: 5px;" class="btn btn-sm btn-success" onclick="verifikasi_admin(\''.$recVal['id'].'\'); return false;" href="#" title="Verifikasi Admin"><i class="dashicons dashicons-yes"></i></a>';
	                    $queryRecords[$recKey]['status'] = '<span class="btn btn-primary btn-sm">Selesai</span>';
	                }else{
	                    $queryRecords[$recKey]['status'] = '<span class="btn btn-danger btn-sm">Not Found</span>';
	                }
	                $queryRecords[$recKey]['aksi'] = $btn;
	                $queryRecords[$recKey]['file_lampiran'] = '<a href="' . SIMPEG_PLUGIN_URL . 'public/media/simpeg/' . $recVal['file_lampiran'] . '" target="_blank"><img src="' . SIMPEG_PLUGIN_URL . 'public/media/simpeg/' . $recVal['file_lampiran'] . '" alt="' . $recVal['file_lampiran'] . '" style="max-width:100%;height:auto;"></a>';
	                $queryRecords[$recKey]['uang_lembur'] = $this->rupiah($recVal['uang_lembur']);
	                $queryRecords[$recKey]['uang_makan'] = $this->rupiah($recVal['uang_makan']);
	                $queryRecords[$recKey]['jml_pajak'] = $this->rupiah($recVal['jml_pajak']);
	                $queryRecords[$recKey]['total_nilai'] = $this->rupiah($queryRecords[$recKey]['total_nilai']);
	            }
	     
	            $json_data = array(
	                "draw"            => intval( $params['draw'] ),   
	                "recordsTotal"    => intval( $totalRecords ),  
	                "recordsFiltered" => intval($totalRecords),
	                "data"            => $queryRecords,
	                "sql"             => $sqlRec
	            );

	            die(json_encode($json_data));
	        }else{
	            $return = array(
	                'status' => 'error',
	                'message'   => 'Api Key tidak sesuai!'
	            );
	        }
	    }else{
	        $return = array(
	            'status' => 'error',
	            'message'   => 'Format tidak sesuai!'
	        );
	    }
	    die(json_encode($return));
	} 
}