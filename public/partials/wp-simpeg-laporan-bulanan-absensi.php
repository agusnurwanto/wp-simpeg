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
    'id_skpd' => 0,
    'id' => '',
    'bulan' => date('m')*1
), $atts );

if(!empty($_GET) && !empty($_GET['tahun'])){
    $input['tahun'] = $_GET['tahun'];
}
if(!empty($_GET) && !empty($_GET['id_skpd'])){
    $input['id_skpd'] = $_GET['id_skpd'];
} 
if(!empty($_GET) && !empty($_GET['bulan'])){
    $input['bulan'] = $_GET['bulan'];
}
if(!empty($_GET) && !empty($_GET['id'])){
    $input['id'] = $_GET['id'];
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
    $select_tahun .= "<option value='".$tahun_value['tahun_anggaran']."' ".$select.">".$tahun_value['tahun_anggaran']."</option>";
}

$namaBulan = array(
    1 => 'Januari',
    2 => 'Februari',
    3 => 'Maret',
    4 => 'April',
    5 => 'Mei',
    6 => 'Juni',
    7 => 'Juli',
    8 => 'Agustus',
    9 => 'September',
    10 => 'Oktober',
    11 => 'November',
    12 => 'Desember'
);

$pegawai = $wpdb->get_results($wpdb->prepare('
    SELECT 
        *
    FROM data_pegawai_lembur
    WHERE tahun=%d
        AND active=1
', $input['tahun']), ARRAY_A);
$select_pegawai = '<option value="">Pilih Pegawai</option>';
foreach($pegawai as $get_peg){
    $selected = '';
    if($get_peg['id'] == $input['id']){
        $selected = 'selected';
    }
    $select_pegawai .= '<option value="'.$get_peg['id'].'" '.$selected.'>'.$get_peg['gelar_depan'].' '.$get_peg['nama'].' '.$get_peg['gelar_belakang'].'</option>';
}

$set_peg = $wpdb->get_row($wpdb->prepare('
    SELECT 
        *
    FROM data_pegawai_lembur
    WHERE tahun=%d
        AND id=%d
', $input['tahun'], $input['id']), ARRAY_A);

$sbu_lembur_db = $wpdb->get_results($wpdb->prepare('
    SELECT
        *
    FROM data_sbu_lembur
    WHERE tahun=%d
        AND active=1
', $input['tahun']), ARRAY_A);
$sbu_lembur = array();
foreach($sbu_lembur_db as $sbu){
    if(empty($sbu_lembur[$sbu['jenis_sbu']])){
        $sbu_lembur[$sbu['jenis_sbu']] = array();
    }
    if(empty($sbu_lembur[$sbu['jenis_sbu']][$sbu['jenis_hari']])){
        $sbu_lembur[$sbu['jenis_sbu']][$sbu['jenis_hari']] = array();
    }
    if(empty($sbu_lembur[$sbu['jenis_sbu']][$sbu['jenis_hari']][$sbu['id_golongan']])){
        $sbu_lembur[$sbu['jenis_sbu']][$sbu['jenis_hari']][$sbu['id_golongan']] = array();
    }
    $sbu_lembur[$sbu['jenis_sbu']][$sbu['jenis_hari']][$sbu['id_golongan']] = $sbu;
}

$uang_lembur_hari_kerja_2 = 0;
if(
    !empty($sbu_lembur['uang_lembur'])
    && !empty($sbu_lembur['uang_lembur'][2])
    && !empty($set_peg['kode_gol'])
    && !empty($sbu_lembur['uang_lembur'][2][$set_peg['kode_gol']])
){
    $uang_lembur_hari_kerja_2 = $sbu_lembur['uang_lembur'][2][$set_peg['kode_gol']]['harga'];
}

$uang_lembur_hari_libur_2 = 0;
if(
    !empty($sbu_lembur['uang_lembur'])
    && !empty($sbu_lembur['uang_lembur'][1])
    && !empty($set_peg['kode_gol'])
    && !empty($sbu_lembur['uang_lembur'][1][$set_peg['kode_gol']])
){
    $uang_lembur_hari_libur_2 = $sbu_lembur['uang_lembur'][1][$set_peg['kode_gol']]['harga'];
}

$uang_makan_lembur_2 = 0;
if(
    !empty($sbu_lembur['uang_makan'][0])
    && !empty($sbu_lembur['uang_makan'][0])
    && !empty($set_peg['kode_gol'])
    && !empty($sbu_lembur['uang_makan'][0][$set_peg['kode_gol']])
){
    $uang_makan_lembur_2 = $sbu_lembur['uang_makan'][0][$set_peg['kode_gol']]['harga'];
}

$absensi_lembur = $wpdb->get_results($wpdb->prepare('
    SELECT 
        d.*,
        s.*,
        p.*,
        s.update_at as update_at_absensi
    from data_absensi_lembur s
    INNER JOIN data_absensi_lembur_detail d on d.id_spt = s.id
        AND s.active = d.active
    INNER JOIN data_pegawai_lembur p on d.id_pegawai = p.id
        AND p.active = d.active
        AND p.tahun = s.tahun_anggaran
    WHERE s.tahun_anggaran = %d
        AND p.id = %d
        AND d.active = 1
        AND s.status = 2
        AND MONTH(s.update_at) = %d
', $input['tahun'], $input['id'], $input['bulan']), ARRAY_A);

// print_r($absensi_lembur);die($wpdb->last_query);

$nomor = 0;
$body = '';
$peg_jam_kerja = 0;
$peg_jam_libur = 0;
$uang_lembur_hari_kerja = 0;
$uang_lembur_hari_libur = 0;
$uang_makan_lembur = 0;
$total_uang_lembur_hari_kerja = 0;
$total_uang_lembur_hari_libur = 0;
$total_uang_makan_lembur = 0;
$penerimaan_kotor = 0;
$penerimaan_bersih= 0;
$total_pajak= 0;
$jumlah_hari_kerja= 0;
$jumlah_hari_libur= 0;

$total_all_hari_kerja= 0;
$total_all_jam_kerja= 0;
$total_all_uang_lembur_hari_kerja= 0;
$total_all_hari_libur= 0;
$total_all_jam_libur= 0;
$total_all_uang_lembur_hari_libur= 0;
$total_all_uang_makan_lembur= 0;
$total_all_penerimaan_kotor= 0;
$total_all_pajak= 0;
$total_all_penerimaan_bersih= 0;
foreach($absensi_lembur as $peg){
    $nomor++;
    if(
        !empty($sbu_lembur['uang_lembur'])
        && !empty($sbu_lembur['uang_lembur'][1])
        && !empty($sbu_lembur['uang_lembur'][1][$peg['kode_gol']])
    ){
        $uang_lembur_hari_kerja = $sbu_lembur['uang_lembur'][1][$peg['kode_gol']]['harga'];
    }
    if(
        !empty($sbu_lembur['uang_lembur'])
        && !empty($sbu_lembur['uang_lembur'][2])
        && !empty($sbu_lembur['uang_lembur'][2][$peg['kode_gol']])
    ){
        $uang_lembur_hari_libur = $sbu_lembur['uang_lembur'][2][$peg['kode_gol']]['harga'];
    }
    if(
        !empty($sbu_lembur['uang_makan'][0])
        && !empty($sbu_lembur['uang_makan'][0])
        && !empty($sbu_lembur['uang_makan'][0][$peg['kode_gol']])
    ){
        $uang_makan_lembur = $sbu_lembur['uang_makan'][0][$peg['kode_gol']]['harga'];
    }
    // dikasih kondisi jika jam lembur dapat uang makan
    if(!empty($peg['id_standar_harga_makan'])){
        $total_uang_makan_lembur = $uang_makan_lembur;
    }

    if($peg['tipe_hari'] == 2){
        $total_uang_lembur_hari_kerja = $peg['jml_jam']*$uang_lembur_hari_libur;
        $peg_jam_kerja = $peg['jml_jam'];
        $jumlah_hari_kerja = $peg['jml_hari'];
    }else if($peg['tipe_hari'] == 1){
        $total_uang_lembur_hari_libur = $peg['jml_jam']*$uang_lembur_hari_kerja;
        $peg_jam_libur = $peg['jml_jam'];
        $jumlah_hari_libur = $peg['jml_hari'];
    }
    $total_pajak = $peg['jml_pajak'];
    $penerimaan_kotor = $total_uang_lembur_hari_kerja + $total_uang_lembur_hari_libur + $total_uang_makan_lembur;
    $penerimaan_bersih = $penerimaan_kotor - $total_pajak;
    $body .= '
        <tr>
            <td class="atas kanan bawah kiri text-center">'.$nomor.'</td>
            <td class="atas kanan bawah text-center">'.$peg['gelar_depan'].' '.$peg['nama'].' '.$peg['gelar_belakang'].'</td>
            <td class="atas kanan bawah text-center">'.$peg['gol_ruang'].'</td>
            <td class="atas kanan bawah text-right">'.$this->rupiah($uang_lembur_hari_libur).'</td>
            <td class="atas kanan bawah text-center">'.$this->rupiah($jumlah_hari_kerja).'</td>
            <td class="atas kanan bawah text-center">'.$this->rupiah($peg_jam_kerja).'</td>
            <td class="atas kanan bawah text-right">'.$this->rupiah($total_uang_lembur_hari_kerja).'</td>
            <td class="atas kanan bawah text-right">'.$this->rupiah($uang_lembur_hari_kerja).'</td>
            <td class="atas kanan bawah text-center">'.$this->rupiah($jumlah_hari_libur).'</td>
            <td class="atas kanan bawah text-center">'.$this->rupiah($peg_jam_libur).'</td>
            <td class="atas kanan bawah text-right">'.$this->rupiah($total_uang_lembur_hari_libur).'</td>
            <td class="atas kanan bawah text-right">'.$this->rupiah($total_uang_makan_lembur).'</td>
            <td class="atas kanan bawah text-right">'.$this->rupiah($penerimaan_kotor).'</td>
            <td class="atas kanan bawah text-right">'.$this->rupiah($total_pajak).'</td>
            <td class="atas kanan bawah text-right">'.$this->rupiah($penerimaan_bersih).'</td>
            <td class="atas kanan bawah text-center">'.$peg['ket_lembur'].'</td>
            <td class="atas kanan bawah text-center">'.$peg['update_at_absensi'].'</td>
            <td class="atas kanan bawah"><a href="'.SIMPEG_PLUGIN_URL.'public/media/simpeg/'.$peg['file_lampiran'].'" target="_blank">Foto Kegiatan</a></td>
        </tr>
    ';

    $total_all_hari_kerja += $jumlah_hari_kerja;
    $total_all_jam_kerja += $peg_jam_kerja;
    $total_all_uang_lembur_hari_kerja += $total_uang_lembur_hari_kerja;
    $total_all_hari_libur += $jumlah_hari_libur;
    $total_all_jam_libur += $peg_jam_libur;
    $total_all_uang_lembur_hari_libur += $total_uang_lembur_hari_libur;
    $total_all_uang_makan_lembur += $total_uang_makan_lembur;
    $total_all_penerimaan_kotor += $penerimaan_kotor;
    $total_all_pajak += $total_pajak;
    $total_all_penerimaan_bersih += $penerimaan_bersih;
}

?>
<style type="text/css">
    .wrap-table {
        overflow: auto;
        max-height: 100vh;
        width: 100%;
    }

    .btn-action-group {
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .btn-action-group .btn {
        margin: 0 5px;
    }
    #tabel-absensi-pegawai {
        font-family:\'Open Sans\',-apple-system,BlinkMacSystemFont,\'Segoe UI\',sans-serif; 
        border-collapse: collapse; 
        font-size: 70%; 
        border: 0; 
        table-layout: fixed;
    }
    #tabel-absensi-pegawai thead{
        position: sticky;
        top: -6px;
        background: #ffc491;
    }
    #tabel-absensi-pegawai tfoot{
        position: sticky;
        bottom: -6px;
        background: #ffc491;
    }
</style>
<div id="wrap-action"></div>
<div class="text-center" style="margin-top: 30px;">
    <label for="bulan">Bulan:  </label>
    <select style="margin-left: 10px;" name="bulan" id="bulan">
        <?php
        foreach ($namaBulan as $angkaBulan => $nama) {
            $select = '';
            if($angkaBulan == $input['bulan']){
                $select = 'selected';
            }
            echo "<option value=\"$angkaBulan\" $select>$nama</option>";
        }
        ?>
    </select>
    <label style="margin-left: 10px;" for="tahun">Tahun:</label>
    <select style="margin-left: 10px;" name="tahun" id="tahun">
        <?php echo $select_tahun; ?>
    </select>
    <label style="margin-left: 10px;" for="pegawai">Pegawai:</label>
    <select style="width: 400px;" name="pegawai" id="pegawai">
        <?php echo $select_pegawai; ?>
    </select>
    <button style="margin-left: 10px; height: 45px; width: 75px;" onclick="submit();" class="btn btn-sm btn-primary">Cari</button>
</div>

<h3 style="margin-top: 20px;" class="text-center">Laporan Absensi<br>Bulan <?php echo $namaBulan[$input['bulan']]; ?> Tahun <?php echo $input['tahun']; ?></h3 style="margin-top: 20px;">
<div id="cetak" title="Laporan MONEV RENJA" style="padding: 5px; overflow: auto; max-height: 80vh;">
    <table id="tabel-absensi-pegawai" cellpadding="2" cellspacing="0" contenteditable="false">
        <thead>
            <tr>
                <th class="atas kanan bawah kiri text-center" style="vertical-align: middle;" rowspan="2">No</th>
                <th class="atas kanan bawah text-center" style="vertical-align: middle;" rowspan="2">Nama</th>
                <th class="atas kanan bawah text-center" style="vertical-align: middle;" rowspan="2">Golongan</th>
                <th class="atas kanan bawah text-center" style="vertical-align: middle;" colspan="4">Hari Kerja</th>
                <th class="atas kanan bawah text-center" style="vertical-align: middle;" colspan="4">Hari Libur</th>
                <th class="atas kanan bawah text-center" style="vertical-align: middle;"rowspan="2">Uang Makan</th>
                <th class="atas kanan bawah text-center" style="vertical-align: middle;"rowspan="2">Penerimaan Kotor</th>
                <th class="atas kanan bawah text-center" style="vertical-align: middle;"rowspan="2">Pajak</th>
                <th class="atas kanan bawah text-center" style="vertical-align: middle;"rowspan="2">Penerimaan Bersih</th>
                <th class="atas kanan bawah text-center" style="vertical-align: middle;"rowspan="2">Keterangan</th>
                <th class="atas kanan bawah text-center" style="vertical-align: middle;"rowspan="2">Dibuat</th>
                <th class="atas kanan bawah text-center" style="vertical-align: middle;"rowspan="2">Foto Kegiatan</th>
            </tr>
            <tr>
                <th class="atas kanan bawah kiri text-center">Harga Satuan</th>
                <th class="atas kanan bawah text-center">Hari</th>
                <th class="atas kanan bawah text-center">Jam</th>
                <th class="atas kanan bawah text-center">Total</th>
                <th class="atas kanan bawah text-center">Harga Satuan</th>
                <th class="atas kanan bawah text-center">Hari</th>
                <th class="atas kanan bawah text-center">Jam</th>
                <th class="atas kanan bawah text-center">Total</th>
            </tr>
            <tr>
                <th class="atas kanan bawah kiri text-center">1</th>
                <th class="atas kanan bawah text-center">2</th>
                <th class="atas kanan bawah text-center">3</th>
                <th class="atas kanan bawah text-center">4</th>
                <th class="atas kanan bawah text-center">5</th>
                <th class="atas kanan bawah text-center">6</th>
                <th class="atas kanan bawah text-center">7=4x6</th>
                <th class="atas kanan bawah text-center">8</th>
                <th class="atas kanan bawah text-center">9</th>
                <th class="atas kanan bawah text-center">10</th>
                <th class="atas kanan bawah text-center">11=8x10</th>
                <th class="atas kanan bawah text-center">12</th>
                <th class="atas kanan bawah text-center">13=7+11+12</th>
                <th class="atas kanan bawah text-center">14</th>
                <th class="atas kanan bawah text-center">15=13-14</th>
                <th class="atas kanan bawah text-center">16</th>
                <th class="atas kanan bawah text-center">17</th>
                <th class="atas kanan bawah text-center">18</th>
            </tr>
        </thead>
        <tbody>
            <?php echo $body; ?>
        </tbody>
        <tfoot>
            <tr>
                <th class='atas kanan bawah kiri text_kanan text_blok' colspan="4">Total</th>
                <th class='atas kanan bawah text_tengah text_blok' ><?php echo number_format($total_all_hari_kerja,0,",","."); ?></th>
                <th class='atas kanan bawah text_tengah text_blok' ><?php echo number_format($total_all_jam_kerja,0,",","."); ?></th>
                <th class='atas kanan bawah text_kanan text_blok' ><?php echo number_format($total_all_uang_lembur_hari_kerja,0,",","."); ?></th>
                <th class='atas kanan bawah kiri text_kanan text_blok'></th>
                <th class='atas kanan bawah text_tengah text_blok' ><?php echo number_format($total_all_hari_libur,0,",","."); ?></th>
                <th class='atas kanan bawah text_tengah text_blok' ><?php echo number_format($total_all_jam_libur,0,",","."); ?></th>
                <th class='atas kanan bawah text_kanan text_blok' ><?php echo number_format($total_all_uang_lembur_hari_libur,0,",","."); ?></th>
                <th class='atas kanan bawah text_kanan text_blok' ><?php echo number_format($total_all_uang_makan_lembur,0,",","."); ?></th>
                <th class='atas kanan bawah text_kanan text_blok' ><?php echo number_format($total_all_penerimaan_kotor,0,",","."); ?></th>
                <th class='atas kanan bawah text_kanan text_blok' ><?php echo number_format($total_all_pajak,0,",","."); ?></th>
                <th class='atas kanan bawah text_kanan text_blok' ><?php echo number_format($total_all_penerimaan_bersih,0,",","."); ?></th>
                <th class='atas kanan bawah kiri text_kanan text_blok' colspan="3"></th>
            </tr>
        </tfoot>
    </table>      
</div>
<script type="text/javascript">
jQuery(document).ready(function(){
    run_download_excel_simpeg();
    // penyesuaian thema wp full width page
    jQuery('.mg-card-box').parent().removeClass('col-md-8').addClass('col-md-12');
    jQuery('#secondary').parent().remove();
    
    jQuery('#pegawai').select2();
});
function submit(){
        var tahun = jQuery('#tahun').val();
        var bulan = jQuery('#bulan').val();
        var pegawai = jQuery('#pegawai').val();
        if(tahun == ''){
            return alert('Tahun tidak boleh kosong!');
        }else if(bulan == ''){
            return alert('Bulan tidak boleh kosong!');
        }else if(pegawai == ''){
            return alert('pegawai tidak boleh kosong!');
        }
        var url = window.location.href;
        url = url.split('?')[0]+'?tahun='+tahun+'&bulan='+bulan+'&id='+pegawai;
        location.href = url;
    }
</script>