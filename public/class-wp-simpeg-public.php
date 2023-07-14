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

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/wp-simpeg-public.js', array( 'jquery' ), $this->version, false );

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/wp-simpeg-public.css', array(), $this->version, 'all' );		
		// wp_enqueue_script($this->plugin_name . 'bootstrap', plugin_dir_url(__FILE__) . 'js/bootstrap.bundle.min.js', array('jquery'), $this->version, false);
		// wp_enqueue_script($this->plugin_name . 'select2', plugin_dir_url(__FILE__) . 'js/select2.min.js', array('jquery'), $this->version, false);
		// wp_enqueue_script($this->plugin_name . 'datatables', plugin_dir_url(__FILE__) . 'js/jquery.dataTables.min.js', array('jquery'), $this->version, false);
		// wp_enqueue_script($this->plugin_name . 'chart', plugin_dir_url(__FILE__) . 'js/chart.min.js', array('jquery'), $this->version, false);
		wp_localize_script( $this->plugin_name, 'ajax', array(
		    'url' => admin_url( 'admin-ajax.php' )
		));
		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/wp-satset-public.js', array( 'jquery' ), $this->version, false );
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
	            $ret['data'] = $wpdb->get_results($wpdb->prepare('
	                SELECT 
	                    *
	                FROM data_pegawai_lembur
	                WHERE id_skpd=%d
	                	AND active=1
	            ', $_POST['id_skpd']), ARRAY_A);
	            $html = '<option value="">Pilih Pegawai</option>';
	            foreach($ret['data'] as $pegawai){
	            	$html .= '<option value="'.$pegawai['id'].'">'.$pegawai['gelar_depan'].' '.$pegawai['nama'].' '.$pegawai['gelar_belakang'].'</option>';
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
	            $data = $wpdb->get_row($wpdb->prepare('
	                 SELECT 
                        *
                    FROM data_spt_lembur
                    WHERE id=%d
	            ', $_POST['id']), ARRAY_A);
	            $ret['data'] = $data;
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
	            $ret['data'] = $wpdb->update('data_spt_lembur', array('status' => 3), array(
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
	        'data' => array()
	    );
	    if(!empty($_POST)){
	        if(!empty($_POST['api_key']) && $_POST['api_key'] == get_option( SIMPEG_APIKEY )) {
	            if($ret['status'] != 'error' && !empty($_POST['id_skpd'])){
	                $id_skpd = $_POST['id_skpd'];
	            }
	            // else{
	            //     $ret['status'] = 'error';
	            //     $ret['message'] = 'Pilih Id SKPD Dulu!';
	            // }
	            if($ret['status'] != 'error' && !empty($_POST['id_ppk'])){
	                $id_ppk = $_POST['id_ppk'];
	            }
	            // else{
	            //     $ret['status'] = 'error';
	            //     $ret['message'] = 'Pilih Id PPK Dulu!';
	            // }
	            if($ret['status'] != 'error' && !empty($_POST['id_bendahara'])){
	                $id_bendahara = $_POST['id_bendahara'];
	            }
	            // else{
	            //     $ret['status'] = 'error';
	            //     $ret['message'] = 'Pilih Id Bendahara Dulu!';
	            // }
	            if($ret['status'] != 'error' && !empty($_POST['uang_makan'])){
	                $uang_makan = $_POST['uang_makan'];
	            }
	            // else{
	            //     $ret['status'] = 'error';
	            //     $ret['message'] = 'Pilih Uang Makan Dulu!';
	            // }
	            if($ret['status'] != 'error' && !empty($_POST['uang_lembur'])){
	                $uang_lembur = $_POST['uang_lembur'];
	            }
	            // else{
	            //     $ret['status'] = 'error';
	            //     $ret['message'] = 'Pilih Uang Lembur Dulu!';
	            // }
	            if($ret['status'] != 'error' && !empty($_POST['ket_lembur'])){
	                $ket_lembur = $_POST['ket_lembur'];
	            }
	            // else{
	            //     $ret['status'] = 'error';
	            //     $ret['message'] = 'Pilih Keterangan Lembur Dulu!';
	            // }
	            if($ret['status'] != 'error' && !empty($_POST['ket_ver_ppk'])){
	                $ket_ver_ppk = $_POST['ket_ver_ppk'];
	            }
	            // else{
	            //     $ret['status'] = 'error';
	            //     $ret['message'] = 'Pilih Keterangan Verifikasi PPK Dulu!';
	            // }
	            if($ret['status'] != 'error' && !empty($_POST['ket_ver_kepala'])){
	                $ket_ver_kepala = $_POST['ket_ver_kepala'];
	            }
	            // else{
	            //     $ret['status'] = 'error';
	            //     $ret['message'] = 'Pilih  Keterangan Verifikasi Kepala Dulu!';
	            // }
	            if($ret['status'] != 'error' && !empty($_POST['status_ver_bendahara'])){
	                $status_ver_bendahara = $_POST['status_ver_bendahara'];
	            }
	            // else{
	            //     $ret['status'] = 'error';
	            //     $ret['message'] = 'Pilih Status Verifikasi Bendahara Dulu!';
	            // }
	            if($ret['status'] != 'error' && !empty($_POST['ket_ver_bendahara'])){
	                $ket_ver_bendahara = $_POST['ket_ver_bendahara'];
	            }
	            // else{
	            //     $ret['status'] = 'error';
	            //     $ret['message'] = 'Pilih  Keterangan Verifikasi Bendahara Dulu!';
	            // }
	            $_POST['id'] = $id_skpd;
	            $status_ver_bendahara = $_POST['status_ver_bendahara'];
	            $ket_ver_bendahara = $_POST['ket_ver_bendahara'];
	            if($ret['status'] != 'error'){
	                if(empty($_POST['id_data'])){
	                    $status = 0;
	                }else{
	                    $status = 1;
	                    if($status_pagu == 0){
	                        $status = 2;
	                    }
	                }
	                $data = array(
	                    `id_skpd`=> $id_skpd, 
			            `id_ppk`=> $id_ppk, 
			            `id_bendahara`=> $id_bendahara, 
			            `uang_makan`=> $uang_makan, 
			            `uang_lembur`=> $uang_lembur, 
			            `ket_lembur`=> $ket_lembur, 
			            `ket_ver_ppk`=> $ket_ver_ppk, 
			            `ket_ver_kepala`=> $ket_ver_kepala, 
			            `status_ver_bendahara`=> $status_ver_bendahara,
			            `ket_ver_bendahara`=> $ket_ver_bendahara, 
	                    'status' => $status,
	                    'update_at' => current_time('mysql')
	                );
	                if(!empty($_POST['id_data'])){
	                    $wpdb->update('data_spt_lembur', $data, array(
	                        'id' => $_POST['id_data']
	                    ));
	                    $ret['message'] = 'Berhasil update data!';
	                }else{
	                    $cek_id = $wpdb->get_row($wpdb->prepare('
	                        SELECT
	                            id,
	                            active
	                        FROM data_spt_lembur
	                        WHERE id_spt=%s
	                    ', $id_spt), ARRAY_A);
	                    if(empty($cek_id)){
	                        $wpdb->insert('data_spt_lembur', $data);
	                    }else{
	                        if($cek_id['active'] == 0){
	                            $wpdb->update('data_spt_lembur', $data, array(
	                                'id' => $cek_id['id']
	                            ));
	                        }else{
	                            $ret['status'] = 'error';
	                            $ret['message'] = 'Gagal disimpan. Data SPT dengan id_spt="'.$id_spt.'" sudah ada!';
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
	               0 => `id_skpd`,
	               1 => `id_ppk`,
	               2 => `id_bendahara`,
	               3 => `uang_makan`,
	               4 => `uang_lembur`,
	               5 => `ket_lembur`,
	               6 => `ket_ver_ppk`,
	               7 => `ket_ver_kepala`,
	               8 => `status_ver_bendahara`, 
	               9 => `ket_ver_bendahara`,
	              10 => 'id'
	            );
	            $where = $sqlTot = $sqlRec = "";

	            // check search value exist
	            // if( !empty($params['search']['value']) ) { 
	            //     $where .=" OR  LIKE ".$wpdb->prepare('%s', "%".$params['search']['value']."%");
	            // }

	            // getting total number records without any search
	            $sql_tot = "SELECT count(p.id) as jml FROM `data_spt_lembur`";
	            $sql = "SELECT ".implode(', ', $columns)." FROM `data_spt_lembur`";
	            $where_first = " WHERE 1=1 AND status != 3";
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

	            foreach($queryRecords as $recKey => $recVal){
	                $btn = '<a class="btn btn-sm btn-primary" onclick="detail_data(\''.$recVal['id'].'\'); return false;" href="#" title="Detail Data"><i class="dashicons dashicons-search"></i></a>';
	                if ($recVal['status'] != 1) {
	                    $btn .= '<a style="margin-left: 10px;" class="btn btn-sm btn-warning" onclick="edit_data(\''.$recVal['id'].'\'); return false;" href="#" title="Edit Data"><i class="dashicons dashicons-edit"></i></a>';
	                    $btn .= '<a style="margin-left: 10px;" class="btn btn-sm btn-danger" onclick="hapus_data(\''.$recVal['id'].'\'); return false;" href="#" title="Edit Data"><i class="dashicons dashicons-trash"></i></a>';
	                }
	                $queryRecords[$recKey]['aksi'] = $btn;
	                if($recVal['status'] == 0){
	                    $queryRecords[$recKey]['status'] = '<span class="btn btn-primary btn-sm">Belum dicek</span>';
	                }elseif ($recVal['status'] == 1) {
	                    $queryRecords[$recKey]['status'] = '<span class="btn btn-success btn-sm">Diterima</span>';
	                }elseif ($recVal['status'] == 2) {
	                    $pesan = '';
	                    if ($recVal['status_ver_bendahara'] == 0){
	                        $pesan .= '<br>Keterangan Verifikasi: '.$recVal['ket_ver_bendahara']; 
	                    }
	                    $queryRecords[$recKey]['status'] = '<span class="btn btn-danger btn-sm">Ditolak</span>'.$pesan;
	                }
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
                    $btn .= '<a class="btn btn-sm btn-danger" onclick="hapus_data(\''.$recVal['id'].'\'); return false;" href="#" title="Edit Data"><i class="dashicons dashicons-trash"></i></a>';
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
}