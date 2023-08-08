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
class Wp_Simpeg_Public {

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

		wp_enqueue_style($this->plugin_name . 'bootstrap', plugin_dir_url(__FILE__) . 'css/bootstrap.min.css', array(), $this->version, 'all');
		wp_enqueue_style($this->plugin_name . 'select2', plugin_dir_url(__FILE__) . 'css/select2.min.css', array(), $this->version, 'all');
		wp_enqueue_style($this->plugin_name . 'datatables', plugin_dir_url(__FILE__) . 'css/datatables.min.css', array(), $this->version, 'all');

		wp_enqueue_style( 'dashicons' );
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
		wp_localize_script( $this->plugin_name, 'ajax', array(
		    'url' => admin_url( 'admin-ajax.php' )
		));
		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/wp-simpeg-public.js', array( 'jquery' ), $this->version, false );
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
	            	$html .= '<option value="'.$skpd['id_skpd'].'">'.$skpd['kode_skpd'].' '.$skpd['nama_skpd'].'</option>';
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
	        if(!empty($_POST['api_key']) && $_POST['api_key'] == get_option( SIMPEG_APIKEY )) {
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
	            	$html .= '<option golongan="'.$pegawai['kode_gol'].'" value="'.$pegawai['id'].'">'.$pegawai['gelar_depan'].' '.$pegawai['nama'].' '.$pegawai['gelar_belakang'].'</option>';
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
	            if($ret['status'] != 'error' && !empty($_POST['id_skpd'])){
	                $id_skpd = $_POST['id_skpd'];
	            }
	            // else{
	            //     $ret['status'] = 'error';
	            //     $ret['message'] = 'Data id_skpd tidak boleh kosong!';
	            // }
	            if($ret['status'] != 'error' && !empty($_POST['nik'])){
	                $nik = $_POST['nik'];
	            }
	            // else{
	            //     $ret['status'] = 'error';
	            //     $ret['message'] = 'Data nik tidak boleh kosong!';
	            // }
	            if($ret['status'] != 'error' && !empty($_POST['nip'])){
	                $nip = $_POST['nip'];
	            }
	            // else{
	            //     $ret['status'] = 'error';
	            //     $ret['message'] = 'Data nip tidak boleh kosong!';
	            // }
	            if($ret['status'] != 'error' && !empty($_POST['nama'])){
	                $nama = $_POST['nama'];
	            }
	            // else{
	            //     $ret['status'] = 'error';
	            //     $ret['message'] = 'Data nama tidak boleh kosong!';
	            // }
	            if($ret['status'] != 'error' && !empty($_POST['tempat_lahir'])){
	                $tempat_lahir = $_POST['tempat_lahir'];
	            }
	            // else{
	            //     $ret['status'] = 'error';
	            //     $ret['message'] = 'Data tempat_lahir tidak boleh kosong!';
	            // }
	            if($ret['status'] != 'error' && !empty($_POST['tanggal_lahir'])){
	                $tanggal_lahir = $_POST['tanggal_lahir'];
	            }
	            // else{
	            //     $ret['status'] = 'error';
	            //     $ret['message'] = 'Data tanggal_lahir tidak boleh kosong!';
	            // }
	            if($ret['status'] != 'error' && !empty($_POST['status'])){
	                $status = $_POST['status'];
	            }
	            // else{
	            //     $ret['status'] = 'error';
	            //     $ret['message'] = 'Data status tidak boleh kosong!';
	            // }
	            if($ret['status'] != 'error' && !empty($_POST['gol_ruang'])){
	                $gol_ruang = $_POST['gol_ruang'];
	            }
	            // else{
	            //     $ret['status'] = 'error';
	            //     $ret['message'] = 'Data gol_ruang tidak boleh kosong!';
	            // }
	            if($ret['status'] != 'error' && !empty($_POST['tmt_pangkat'])){
	                $tmt_pangkat = $_POST['tmt_pangkat'];
	            }
	            // else{
	            //     $ret['status'] = 'error';
	            //     $ret['message'] = 'Data tmt_pangkat tidak boleh kosong!';
	            // }
	            if($ret['status'] != 'error' && !empty($_POST['eselon'])){
	                $eselon = $_POST['eselon'];
	            }
	            // else{
	            //     $ret['status'] = 'error';
	            //     $ret['message'] = 'Data eselon tidak boleh kosong!';
	            // }
	            if($ret['status'] != 'error' && !empty($_POST['jabatan'])){
	                $jabatan = $_POST['jabatan'];
	            }
	            // else{
	            //     $ret['status'] = 'error';
	            //     $ret['message'] = 'Data jabatan tidak boleh kosong!';
	            // }
	            if($ret['status'] != 'error' && !empty($_POST['tipe_pegawai'])){
	                $tipe_pegawai = $_POST['tipe_pegawai'];
	            }
	            // else{
	            //     $ret['status'] = 'error';
	            //     $ret['message'] = 'Data tipe_pegawai tidak boleh kosong!';
	            // }
	            if($ret['status'] != 'error' && !empty($_POST['tmt_jabatan'])){
	                $tmt_jabatan = $_POST['tmt_jabatan'];
	            }
	            // else{
	            //     $ret['status'] = 'error';
	            //     $ret['message'] = 'Data tmt_jabatan tidak boleh kosong!';
	            // }
	            if($ret['status'] != 'error' && !empty($_POST['agama'])){
	                $agama = $_POST['agama'];
	            }
	            // else{
	            //     $ret['status'] = 'error';
	            //     $ret['message'] = 'Data agama tidak boleh kosong!';
	            // }
	            if($ret['status'] != 'error' && !empty($_POST['alamat'])){
	                $alamat = $_POST['alamat'];
	            }
	            // else{
	            //     $ret['status'] = 'error';
	            //     $ret['message'] = 'Data alamat tidak boleh kosong!';
	            // }
	            if($ret['status'] != 'error' && !empty($_POST['no_hp'])){
	                $no_hp = $_POST['no_hp'];
	            }
	            // else{
	            //     $ret['status'] = 'error';
	            //     $ret['message'] = 'Data no_hp tidak boleh kosong!';
	            // }
	            if($ret['status'] != 'error' && !empty($_POST['satuan_kerja'])){
	                $satuan_kerja = $_POST['satuan_kerja'];
	            }
	            // else{
	            //     $ret['status'] = 'error';
	            //     $ret['message'] = 'Data satuan_kerja tidak boleh kosong!';
	            // }
	            if($ret['status'] != 'error' && !empty($_POST['unit_kerja_induk'])){
	                $unit_kerja_induk = $_POST['unit_kerja_induk'];
	            }
	            // else{
	            //     $ret['status'] = 'error';
	            //     $ret['message'] = 'Data unit_kerja_induk tidak boleh kosong!';
	            // }
	            if($ret['status'] != 'error' && !empty($_POST['tmt_pensiun'])){
	                $tmt_pensiun = $_POST['tmt_pensiun'];
	            }
	            // else{
	            //     $ret['status'] = 'error';
	            //     $ret['message'] = 'Data tmt_pensiun tidak boleh kosong!';
	            // }
	            if($ret['status'] != 'error' && !empty($_POST['pendidikan'])){
	                $pendidikan = $_POST['pendidikan'];
	            }
	            // else{
	            //     $ret['status'] = 'error';
	            //     $ret['message'] = 'Data pendidikan tidak boleh kosong!';
	            // }
	            if($ret['status'] != 'error' && !empty($_POST['kode_pendidikan'])){
	                $kode_pendidikan = $_POST['kode_pendidikan'];
	            }
	            // else{
	            //     $ret['status'] = 'error';
	            //     $ret['message'] = 'Data kode_pendidikan tidak boleh kosong!';
	            // }
	            if($ret['status'] != 'error' && !empty($_POST['nama_sekolah'])){
	                $nama_sekolah = $_POST['nama_sekolah'];
	            }
	            // else{
	            //     $ret['status'] = 'error';
	            //     $ret['message'] = 'Data nama_sekolah tidak boleh kosong!';
	            // }
	            if($ret['status'] != 'error' && !empty($_POST['nama_pendidikan'])){
	                $nama_pendidikan = $_POST['nama_pendidikan'];
	            }
	            // else{
	            //     $ret['status'] = 'error';
	            //     $ret['message'] = 'Data nama_pendidikan tidak boleh kosong!';
	            // }
	            if($ret['status'] != 'error' && !empty($_POST['lulus'])){
	                $lulus = $_POST['lulus'];
	            }
	            // else{
	            //     $ret['status'] = 'error';
	            //     $ret['message'] = 'Data lulus tidak boleh kosong!';
	            // }
	            if($ret['status'] != 'error' && !empty($_POST['karpeg'])){
	                $karpeg = $_POST['karpeg'];
	            }
	            // else{
	            //     $ret['status'] = 'error';
	            //     $ret['message'] = 'Data karpeg tidak boleh kosong!';
	            // }
	            if($ret['status'] != 'error' && !empty($_POST['karis_karsu'])){
	                $karis_karsu = $_POST['karis_karsu'];
	            }
	            // else{
	            //     $ret['status'] = 'error';
	            //     $ret['message'] = 'Data karis_karsu tidak boleh kosong!';
	            // }
	            if($ret['status'] != 'error' && !empty($_POST['nilai_prestasi'])){
	                $nilai_prestasi = $_POST['nilai_prestasi'];
	            }
	            // else{
	            //     $ret['status'] = 'error';
	            //     $ret['message'] = 'Data nilai_prestasi tidak boleh kosong!';
	            // }
	            if($ret['status'] != 'error' && !empty($_POST['email'])){
	                $email = $_POST['email'];
	            }
	            // else{
	            //     $ret['status'] = 'error';
	            //     $ret['message'] = 'Data email tidak boleh kosong!';
	            // }
	            if($ret['status'] != 'error' && !empty($_POST['tahun'])){
	                $tahun = $_POST['tahun'];
	            }
	            // else{
	            //     $ret['status'] = 'error';
	            //     $ret['message'] = 'Data tahun tidak boleh kosong!';
	            // }
	            if($ret['status'] != 'error'){
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
				   3 => 'nama',
				   4 => 'tempat_lahir',
				   5 => 'tanggal_lahir',
				   6 => 'status',
				   7 => 'gol_ruang',
				   8 => 'tmt_pangkat',
				   9 => 'eselon',
				   10 => 'jabatan',
				   11 => 'tipe_pegawai',
				   12 => 'tmt_jabatan',
				   13 => 'agama',
				   14 => 'alamat',
				   15 => 'no_hp',
				   16 => 'satuan_kerja',
				   17 => 'unit_kerja_induk',
				   18 => 'tmt_pensiun',
				   19 => 'pendidikan',
				   20 => 'kode_pendidikan',
				   21 => 'nama_sekolah',
				   22 => 'nama_pendidikan',
				   23 => 'lulus',
				   24 => 'karpeg',
				   25 => 'karis_karsu',
				   26 => 'nilai_prestasi',
				   27 => 'email',
				   28 => 'tahun',
                   29 => 'id'
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
	            if($ret['status'] != 'error' && !empty($data['nomor_spt'])){
	                $nomor_spt = $data['nomor_spt'];
	            }else{
	                $ret['status'] = 'error';
	                $ret['message'] = 'Isi nomor SPT dulu!';
	            }
	            if($ret['status'] != 'error' && !empty($data['tahun_anggaran'])){
	                $tahun_anggaran = $data['tahun_anggaran'];
	            }else{
	                $ret['status'] = 'error';
	                $ret['message'] = 'Pilih Tahun dulu!';
	            }
	            if($ret['status'] != 'error' && !empty($data['id_skpd'])){
	                $id_skpd = $data['id_skpd'];
	            }else{
	                $ret['status'] = 'error';
	                $ret['message'] = 'Pilih SKPD dulu!';
	            }
	            if($ret['status'] != 'error' && !empty($data['dasar_lembur'])){
	                $dasar_lembur = $data['dasar_lembur'];
	            }else{
	                $ret['status'] = 'error';
	                $ret['message'] = 'Isi dasar Lembur dulu!';
	            }
	            if($ret['status'] != 'error' && !empty($data['ket_lembur'])){
	                $ket_lembur = $data['ket_lembur'];
	            }else{
	                $ret['status'] = 'error';
	                $ret['message'] = 'Isi peruntukan Lembur dulu!';
	            }
	            if($ret['status'] != 'error' && !empty($data['waktu_mulai_spt'])){
	                $waktu_mulai_spt = $data['waktu_mulai_spt'];
	            }
	            else{
	                $ret['status'] = 'error';
	                $ret['message'] = 'Isi waktu mulai SPT dulu!';
	            }
	            if($ret['status'] != 'error' && !empty($data['waktu_selesai_spt'])){
	                $waktu_selesai_spt = $data['waktu_selesai_spt'];
	            }
	            else{
	                $ret['status'] = 'error';
	                $ret['message'] = 'Isi waktu selesai SPT dulu!';
	            }
	            if($ret['status'] != 'error' && !empty($data['id_ppk'])){
	                $id_ppk = $data['id_ppk'];
	            }
	            // else{
	            //     $ret['status'] = 'error';
	            //     $ret['message'] = 'Pilih Id PPK dulu!';
	            // }
	            if($ret['status'] != 'error' && !empty($data['id_bendahara'])){
	                $id_bendahara = $data['id_bendahara'];
	            }
	            // else{
	            //     $ret['status'] = 'error';
	            //     $ret['message'] = 'Pilih Id Bendahara dulu!';
	            // }
	            if($ret['status'] != 'error' && !empty($data['ket_ver_ppk'])){
	                $ket_ver_ppk = $data['ket_ver_ppk'];
	            }
	            // else{
	            //     $ret['status'] = 'error';
	            //     $ret['message'] = 'Pilih Keterangan Verifikasi PPK dulu!';
	            // }
	            if($ret['status'] != 'error' && !empty($data['ket_ver_kepala'])){
	                $ket_ver_kepala = $data['ket_ver_kepala'];
	            }
	            // else{
	            //     $ret['status'] = 'error';
	            //     $ret['message'] = 'Pilih  Keterangan Verifikasi Kepala dulu!';
	            // }
	            if($ret['status'] != 'error' && !empty($data['status_ver_bendahara'])){
	                $status_ver_bendahara = $data['status_ver_bendahara'];
	            }
	            // else{
	            //     $ret['status'] = 'error';
	            //     $ret['message'] = 'Pilih Status Verifikasi Bendahara dulu!';
	            // }
	            if($ret['status'] != 'error' && !empty($data['ket_ver_bendahara'])){
	                $ket_ver_bendahara = $data['ket_ver_bendahara'];
	            }
	            // else{
	            //     $ret['status'] = 'error';
	            //     $ret['message'] = 'Pilih  Keterangan Verifikasi Bendahara dulu!';
	            // }

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
	            	// 0=belum diverifikasi, 1=disetujui kasubag keuangan, 2=disetujui ppk, 3=selesai
	                if(empty($data['id_data'])){
	                    $status = 0;
	                }else{
	                    $status = 3;
	                }
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
			            'id_ppk'=> '', 
			            'id_bendahara'=> '', 
			            'uang_makan'=> $uang_makan, 
			            'uang_lembur'=> $uang_lembur, 
			            'dasar_lembur'=> $dasar_lembur, 
			            'ket_lembur'=> $ket_lembur, 
			            'jml_hari'=> $data['jml_hari'], 
			            'jml_jam'=> $jml_jam, 
			            'jml_peg'=> count($jml_peg), 
			            'jml_pajak'=> $jml_pajak, 
			            'ket_ver_ppk'=> '', 
			            'ket_ver_kepala'=> '', 
			            'status_ver_bendahara'=> '',
			            'ket_ver_bendahara'=> '', 
	                    'status' => $status,
	                    'update_at' => current_time('mysql'),
						'active' => 1
	                );
	                if(!empty($id_ppk)){
	                	$data_opsi['id_ppk'] = $id_ppk;
	                	$data_opsi['ket_ver_ppk'] = $ket_ver_ppk;
	                }
	                if(!empty($id_bendahara)){
	                	$data_opsi['id_bendahara'] = $id_bendahara;
	                	$data_opsi['status_ver_bendahara'] = $status_ver_bendahara;
	                	$data_opsi['ket_ver_bendahara'] = $ket_ver_bendahara;
	                }
	                if(!empty($ket_ver_kepala)){
	                	$data_opsi['ket_ver_kepala'] = $ket_ver_kepala;
	                }
	                if(!empty($data['id_data'])){
	                    $wpdb->update('data_spt_lembur', $data_opsi, array(
	                        'id' => $data['id_data']
	                    ));
	                    $ret['message'] = 'Berhasil update data!';
	                }else{
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
					'no_key' => 1,
					'post_status' => 'private'
				));

                foreach($queryRecords as $recKey => $recVal){
                    $btn = '<a class="btn btn-sm btn-primary" onclick="detail_data(\''.$recVal['id'].'\'); return false;" href="#" title="Detail Data"><i class="dashicons dashicons-search"></i></a>';
	                if(
	                	$recVal['status'] == 0
	                	|| $is_admin
	                ){
                    	$btn .= '<a class="btn btn-sm btn-warning" onclick="edit_data(\''.$recVal['id'].'\'); return false;" href="#" title="Edit Data"><i class="dashicons dashicons-edit"></i></a>';
                        $btn .= '<a class="btn btn-sm btn-danger" onclick="hapus_data(\''.$recVal['id'].'\'); return false;" href="#" title="Hapus Data"><i class="dashicons dashicons-trash"></i></a>';
                        $btn .= '<a class="btn btn-sm btn-primary" onclick="submit_data(\''.$recVal['id'].'\'); return false;" href="#" title="Submit Data"><i class="dashicons dashicons-migrate"></i></a>';
	                    $queryRecords[$recKey]['status'] = '<span class="btn btn-primary btn-sm">Menunggu Submit</span>';
	                }

	                if($recVal['status'] == 1) {
                    	$btn .= '<a class="btn btn-sm btn-success" onclick="verifikasi_kasubag_keuangan(\''.$recVal['id'].'\'); return false;" href="#" title="Verifikasi Kasubag Keuangan"><i class="dashicons dashicons-yes"></i></a>';
	                    $queryRecords[$recKey]['status'] = '<span class="btn btn-success btn-sm">Diverifikasi Kasubag Keuangan</span>';
	                }elseif($recVal['status'] == 2) {
                    	$btn .= '<a class="btn btn-sm btn-success" onclick="verifikasi_ppk(\''.$recVal['id'].'\'); return false;" href="#" title="Verifikasi PPK"><i class="dashicons dashicons-yes"></i></a>';
	                    $queryRecords[$recKey]['status'] = '<span class="btn btn-success btn-sm">Diverifikasi PPK</span>';
	                }elseif($recVal['status'] == 3) {
                    	$btn .= '<a class="btn btn-sm btn-success" onclick="verifikasi_kepala(\''.$recVal['id'].'\'); return false;" href="#" title="Verifikasi Kepala"><i class="dashicons dashicons-yes"></i></a>';
	                    $queryRecords[$recKey]['status'] = '<span class="btn btn-success btn-sm">Diverifikasi Kepala</span>';
	                }elseif($recVal['status'] == 4) {
	                    $queryRecords[$recKey]['status'] = '<span class="btn btn-success btn-sm">Selesai</span>';
	                // status ditolak masih dalam pengembangan
	                }elseif($recVal['status'] == 5) {
	                    $pesan = '';
	                    if ($recVal['status_ver_bendahara'] == 0){
	                        $pesan .= '<br>Keterangan Verifikasi: '.$recVal['ket_ver_bendahara']; 
	                    }
	                    $queryRecords[$recKey]['status'] = '<span class="btn btn-danger btn-sm">Ditolak</span>'.$pesan;
	                }

                    $btn .= '<a class="btn btn-sm btn-primary" target="_blank" href="'.$laporan_spt_lembur['url'].'?id_spt='.$recVal['id'].'" title="Print SPT"><i class="dashicons dashicons-printer"></i></a>';
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
                        *
                    FROM data_spj_lembur
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

public function hapus_data_spj_by_id(){
    global $wpdb;
    $ret = array(
        'status' => 'success',
        'message' => 'Berhasil hapus data!',
        'data' => array()
    );
    if(!empty($_POST)){
        if(!empty($_POST['api_key']) && $_POST['api_key'] == get_option( SIMPEG_APIKEY )) {
            $ret['data'] = $wpdb->update('spj_lembur', array('active' => 0), array(
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

public function tambah_data_spj(){
    global $wpdb;
    $ret = array(
        'status' => 'success',
        'message' => 'Berhasil simpan data!',
        'data' => array()
    );
    if(!empty($_POST)){
        if(!empty($_POST['api_key']) && $_POST['api_key'] == get_option( SIMPEG_APIKEY )) {
            if($ret['status'] != 'error' && !empty($_POST['id_skpd'])){
                $id_skpd = $_POST['id_skpd'];
            }
            // else{
            //     $ret['status'] = 'error';
            //     $ret['message'] = 'Data id_skpd tidak boleh kosong!';
            // }
            if($ret['status'] != 'error' && !empty($_POST['file_daftar_hadir'])){
                $file_daftar_hadir = $_POST['file_daftar_hadir'];
            }
            // else{
            //     $ret['status'] = 'error';
            //     $ret['message'] = 'Data file_daftar_hadir tidak boleh kosong!';
            // }
            if($ret['status'] != 'error' && !empty($_POST['foto_lembur'])){
                $foto_lembur = $_POST['foto_lembur'];
            }
            if($ret['status'] != 'error'){
                $data = array(
                    'id_skpd' => $id_skpd,
                    'file_daftar_hadir' => $file_daftar_hadir,
                    'foto_lembur' => $foto_lembur,
                    'active' => 1,
                    'update_at' => current_time('mysql')
                );
                $path = WPSIMPEG_PLUGIN_PATH.'public/media/simpeg/';
                $upload = CustomTrait::uploadFile($_POST['api_key'], $path, $_FILES['file_daftar_hadir'], ['jpg', 'jpeg', 'png', 'pdf']);

                if($upload['status']){
                    $data['file_daftar_hadir'] = $upload['filename'];
                    if(!empty($_POST['id_data'])){
                        $file_lama = $wpdb->get_var($wpdb->prepare('
                            SELECT
                                file_daftar_hadir
                            FROM data_spj_lembur
                            WHERE id=%d
                        ', $_POST['id_data']));
                    }
                    $data2['foto_lembur'] = $upload['filename'];
                    if(!empty($_POST['id_data'])){
                        $file_sebelumnya = $wpdb->get_var($wpdb->prepare('
                            SELECT
                                foto_lembur
                            FROM data_spj_lembur
                            WHERE id=%d
                        ', $_POST['id_data']));
                    	}

                        // hapus file lama daftar hadir
                    if(
                        $upload['status'] 
                        && $file_lama != $upload['filename'] 
                        && is_file($path.$file_lama) 
                        && $file_sebelumnya != $upload['filename'] 
                        && is_file($path.$file_sebelumnya)
                    ){
                        unlink($path.$file_lama);
                        unlink($path.$file_sebelumnya);
                    }
               }
                if(!empty($_POST['id_data'])){
                    $wpdb->update('spj_lembur', $data, array(
                        'id' => $_POST['id_data']
                    ));
                    $ret['message'] = 'Berhasil update data!';
                }else{
                    $cek_id = $wpdb->get_row($wpdb->prepare('
                        SELECT
                            id,
                            active
                        FROM data_spj_lembur
                        WHERE id_spj=%s
                    ', $id_spj), ARRAY_A);
                    if(empty($cek_id)){
                        $wpdb->insert('spj_lembur', $data);
                    }else{
                        if($cek_id['active'] == 0){
                            $wpdb->update('spj_lembur', $data, array(
                                'id' => $cek_id['id']
                            ));
                        }else{
                            $ret['status'] = 'error';
                            $ret['message'] = 'Gagal disimpan. Data spj_lembur dengan id_spj="'.$id_spj.'" sudah ada!';
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

public function get_datatable_data_spj(){
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
                   1 => 'file_daftar_hadir',
                   2 => 'foto_lembur',
                   3 => 'id'
                );
                $where = $sqlTot = $sqlRec = "";

                // check search value exist
                if( !empty($params['search']['value']) ) {
                    $where .=" AND ( id_spj LIKE ".$wpdb->prepare('%s', "%".$params['search']['value']."%");  
                    $where .=" OR total LIKE ".$wpdb->prepare('%s', "%".$params['search']['value']."%");
                }

                // getting total number records without any search
                $sql_tot = "SELECT count(id) as jml FROM `data_spj_lembur`";
                $sql = "SELECT ".implode(', ', $columns)." FROM `data_spj_lembur`";
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
                $totalRecords = $queryTot[0]['jml'];
                $queryRecords = $wpdb->get_results($sqlRec, ARRAY_A);

                foreach($queryRecords as $recKey => $recVal){
                    $btn = '<a class="btn btn-sm btn-warning" onclick="edit_data(\''.$recVal['id'].'\'); return false;" href="#" title="Edit Data"><i class="dashicons dashicons-edit"></i></a>';
                    $btn .= '<a class="btn btn-sm btn-danger" onclick="hapus_data(\''.$recVal['id'].'\'); return false;" href="#" title="Edit Data"><i class="dashicons dashicons-trash"></i></a>';
                }
                    $queryRecords[$recKey]['file_daftar_hadir'] = '<a href="'.esc_url(plugin_dir_url(__DIR__).'public/media/simpeg/').$recVal['file_daftar_hadir'].'" target="_blank">'.$recVal['file_daftar_hadir'].'</a>';
                    $queryRecords[$recKey]['aksi'] = $btn;

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

	function menu_spt_lembur(){
		global $wpdb;
		$user_id = um_user( 'ID' );
		$user_meta = get_userdata($user_id);
		if(empty($user_meta->roles)){
			echo 'User ini tidak dapat akses sama sekali :)';
		}else if(
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
				echo '
				<ul class="aksi-lembur text-center">
					<li><a href="'.$input_spt_lembur['url'].'" target="_blank" class="btn btn-info">SPT Lembur</a></li>
				</ul>';
			}else{
				echo 'User ID pegawai tidak ditemukan!';
			}
		}
	}

	function verifikasi_spt_lembur(){
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
				if(empty($data['type_verifikasi'])){
					$ret['status'] = 'error';
					$ret['message'] = 'Tipe verifikasi tidak boleh kosong!';
				}else if(empty($data['id_data'])){
					$ret['status'] = 'error';
					$ret['message'] = 'ID SPT tidak boleh kosong!';
				}else{
					$id_spt = $data['id_data'];
					$type_verifikasi = $data['type_verifikasi'];
					if(
						$type_verifikasi == 'pptk'
						&& (
							in_array("pptk", $user_meta->roles)
							||in_array("administrator", $user_meta->roles)
						)
					){
						$wpdb->update('data_spt_lembur', array(
							'status' => 1
						), array(
							'id' => $id_spt
						));
						$ret['message'] == 'Berhasil submit data SPT!';
					}else if(
						$type_verifikasi == 'kasubag_keuangan'
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
								$ret['message'] = 'Berhasil tidak menyetujui pengajuan SPT!';
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
					}else{
						$ret['status'] == 'error';
						$ret['message'] == 'Sistem tidak dapat melakukan verifikasi, hubungi admin!';
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
		die(json_encode($ret));
	}
}