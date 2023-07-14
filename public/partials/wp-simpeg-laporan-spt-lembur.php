<?php 
// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
    die;
}
global $wpdb;
$user_id = um_user( 'ID' );
$user_meta = get_userdata($user_id);
$disabled = 'disabled';
if(in_array("administrator", $user_meta->roles)){
    $disabled = '';
}
$input = shortcode_atts( array(
    'tahun' => date('Y'),
    'bulan' => date('m')*1
), $atts );

if(!empty($_GET) && !empty($_GET['tahun'])){
    $input['tahun'] = $_GET['tahun'];
}
if(!empty($_GET) && !empty($_GET['bulan'])){
    $input['bulan'] = $_GET['bulan'];
}

$tahun = $wpdb->get_results('
    SELECT 
        tahun_anggaran 
    from data_unit_lembur
    group by tahun_anggaran 
    order by tahun_anggaran ASC
', ARRAY_A);
$select_tahun = "<option value=''>Pilih Tahun</option>";
foreach($tahun as $tahun_value){
    $select = $tahun_value['tahun_anggaran'] == $input['tahun'] ? 'selected' : '';
    $select_tahun .= "<option value='".$tahun_value['tahun_anggaran']."' ".$select.">Tahun Anggaran ".$tahun_value['tahun_anggaran']."</option>";
}

$nomor = 1;
?>
<h1 class="text-center">Laporan Surat Perintah Tugas<br> Tahun <?php echo $input['tahun']; ?></h1>
<div class="cetak container-fluid"><br>
    <table class="table table-bordered">
        <thead>
            <tr>
                <td class="atas kanan bawah kiri text-center text_blok" style="vertical-align: middle;" rowspan="2">No</td>
                <td class="atas kanan bawah text-center text_blok" style="vertical-align: middle;" rowspan="2">Dasar</td>
                <td class="atas kanan bawah text-center text_blok" style="vertical-align: middle;" colspan="4">Kepada</td>
                <td class="atas kanan bawah text-center text_blok" style="vertical-align: middle;" colspan="6">Untuk</td>
                <td class="atas kanan bawah text-center text_blok" style="vertical-align: middle;" rowspan ="2">Aksi</td>
            </tr>
            <tr>
                <td class="kanan bawah text-center text_blok" rowspan="2">Nama</td>
                <td class="kanan bawah text-center text_blok" rowspan="2">NIP</td>
                <td class="kanan bawah text-center text_blok" rowspan="2">Pangkat/ Gol. Ruang</td>
                <td class="kanan bawah text-center text_blok" rowspan="2">Jabatan</td>
                <td class="kanan bawah text-center text_blok" rowspan="2">Keterangan</td>
                <td class="kanan bawah text-center text_blok" rowspan="2">Hari</td>
                <td class="kanan bawah text-center text_blok" rowspan="2">Tanggal</td>
                <td class="kanan bawah text-center text_blok" rowspan="2">Pukul</td>
                <td class="kanan bawah text-center text_blok" rowspan="2">Tempat</td>
                <td class="kanan bawah text-center text_blok" rowspan="2">Pakaian</td>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td class="text-center"><?php echo $nomor++; ?></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
            </tr>
        </tbody>
    </table>      
</div>