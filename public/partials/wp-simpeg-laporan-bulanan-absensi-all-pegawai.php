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
    'bulan' => date('m')*1
), $atts );

if(!empty($_GET) && !empty($_GET['tahun'])){
    $input['tahun'] = $_GET['tahun'];
}
if(!empty($_GET) && !empty($_GET['bulan'])){
    $input['bulan'] = $_GET['bulan'];
}
if(!empty($_GET) && !empty($_GET['id_skpd'])){
    $input['id_skpd'] = $_GET['id_skpd'];
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

$skpd = $wpdb->get_results($wpdb->prepare('
    SELECT 
        *
    FROM data_unit_lembur
    WHERE tahun_anggaran=%d
        AND active=1
', $input['tahun']), ARRAY_A);
$select_skpd = '<option value="">Pilih SKPD</option>';
foreach($skpd as $get_skpd){
    $select = $get_skpd['id_skpd'] == $input['id_skpd'] ? 'selected' : '';
    $select_skpd .= '<option value="'.$get_skpd['id_skpd'].'" '.$select.'>'.$get_skpd['kode_skpd'].' '.$get_skpd['nama_skpd'].'</option>';
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

$lap_bulanan_pegawai = $wpdb->get_results($wpdb->prepare('
    SELECT 
        d.*,
        s.tahun_anggaran,
        s.id_skpd,
        s.jml_jam,
        s.jml_pajak,
        p.gelar_depan,
        p.nama,
        p.gelar_belakang,
        p.kode_gol,
        p.gol_ruang
    from data_absensi_lembur_detail d
    INNER JOIN data_absensi_lembur s on d.id_spt = s.id
        AND s.active=d.active
    INNER JOIN data_pegawai_lembur p on d.id_pegawai = p.id
        AND p.active=d.active
        AND p.tahun=s.tahun_anggaran
    WHERE s.tahun_anggaran=%d
        and s.id_skpd=%d
        and d.active=1
        AND s.status = 2
        AND MONTH(s.created_at)= %d
    order by p.nama ASC
', $input['tahun'], $input['id_skpd'], $input['bulan']), ARRAY_A);
$data_all = array();
foreach($lap_bulanan_pegawai as $peg){
    if(empty($data_all[$peg['id_pegawai']])){
        $data_all[$peg['id_pegawai']] = array();
    }
    $data_all[$peg['id_pegawai']][] = $peg;
}

$nomor = 0;
$body = '';
foreach($data_all as $peg_all){
    $nomor++;
    $peg_nama = '';
    $peg_gol = '';
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
    foreach($peg_all as $peg){
        $peg_nama = $peg['gelar_depan'].' '.$peg['nama'].' '.$peg['gelar_belakang'];
        $peg_gol = $peg['gol_ruang'];
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
            $total_uang_makan_lembur += $uang_makan_lembur;
        }

        if($peg['tipe_hari'] == 2){
            $total_uang_lembur_hari_kerja += $peg['jml_jam']*$uang_lembur_hari_kerja;
            $peg_jam_kerja += $peg['jml_jam'];
            $jumlah_hari_kerja += $peg['jml_hari'];
        }else if($peg['tipe_hari'] == 1){
            $total_uang_lembur_hari_libur += $peg['jml_jam']*$uang_lembur_hari_libur;
            $peg_jam_libur += $peg['jml_jam'];
            $jumlah_hari_libur += $peg['jml_hari'];
        }
        $total_pajak += $peg['jml_pajak'];
    }
    $penerimaan_kotor = $total_uang_lembur_hari_kerja + $total_uang_lembur_hari_libur + $total_uang_makan_lembur;
    $penerimaan_bersih = $penerimaan_kotor - $total_pajak;
    $body .= '
        <tr>
            <td class="kiri atas bawah kanan text-center">'.$nomor.'</td>
            <td class="kiri atas bawah kanan text-center">'.$peg_nama.'</td>
            <td class="kiri atas bawah kanan text-center">'.$peg_gol.'</td>
            <td class="kiri atas bawah kanan text-right">'.$this->rupiah($uang_lembur_hari_libur).'</td>
            <td class="kiri atas bawah kanan text-center">'.$this->rupiah($jumlah_hari_kerja).'</td>
            <td class="kiri atas bawah kanan text-center">'.$this->rupiah($peg_jam_kerja).'</td>
            <td class="kiri atas bawah kanan text-right">'.$this->rupiah($total_uang_lembur_hari_kerja).'</td>
            <td class="kiri atas bawah kanan text-right">'.$this->rupiah($uang_lembur_hari_kerja).'</td>
            <td class="kiri atas bawah kanan text-center">'.$this->rupiah($jumlah_hari_libur).'</td>
            <td class="kiri atas bawah kanan text-center">'.$this->rupiah($peg_jam_libur).'</td>
            <td class="kiri atas bawah kanan text-right">'.$this->rupiah($total_uang_lembur_hari_libur).'</td>
            <td class="kiri atas bawah kanan text-right">'.$this->rupiah($total_uang_makan_lembur).'</td>
            <td class="kiri atas bawah kanan text-right">'.$this->rupiah($penerimaan_kotor).'</td>
            <td class="kiri atas bawah kanan text-right">'.$this->rupiah($total_pajak).'</td>
            <td class="kiri atas bawah kanan text-right">'.$this->rupiah($penerimaan_bersih).'</td>
        </tr>
    ';
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
    #tabel-absensi-pegawai-per-skpd {
        font-family:\'Open Sans\',-apple-system,BlinkMacSystemFont,\'Segoe UI\',sans-serif; 
        border-collapse: collapse; 
        font-size: 70%; 
        border: 0; 
        table-layout: fixed;
    }
    #tabel-absensi-pegawai-per-skpd thead{
        position: sticky;
        top: -6px;
        background: #ffc491;
    }
    #tabel-absensi-pegawai-per-skpd tfoot{
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
    <label style="margin-left: 10px;" for="skpd">SKPD:</label>
    <select style="width: 400px;" name="skpd" id="skpd">
        <?php echo $select_skpd; ?>
    </select>
    <button style="margin-left: 10px; height: 45px; width: 75px;"onclick="sumbitBulanTahun();" class="btn btn-sm btn-primary">Cari</button>
</div>
<<h3 style="margin-top: 20px;" class="text-center">Laporan Absensi per SKPD<br>Bulan <?php echo $namaBulan[$input['bulan']]; ?> Tahun <?php echo $input['tahun']; ?></h3 style="margin-top: 20px;">
<div id="cetak" style="padding: 5px; overflow: auto; max-height: 80vh;">
    <table id="tabel-absensi-pegawai-per-skpd" cellpadding="2" cellspacing="0" contenteditable="false">
        <thead>
            <tr>
                <th class="kiri atas bawah kanan text-center" style="vertical-align: middle;" rowspan="2">No</th>
                <th class="kiri atas bawah kanan text-center" style="vertical-align: middle;" rowspan="2">Nama</th>
                <th class="kiri atas bawah kanan text-center" style="vertical-align: middle;" rowspan="2">Golongan</th>
                <th class="kiri atas bawah kanan text-center" style="vertical-align: middle;" colspan="4">Hari Kerja</th>
                <th class="kiri atas bawah kanan text-center" style="vertical-align: middle;" colspan="4">Hari Libur</th>
                <th class="kiri atas bawah kanan text-center" style="vertical-align: middle;"rowspan="2">Uang Makan</th>
                <th class="kiri atas bawah kanan text-center" style="vertical-align: middle;"rowspan="2">Penerimaan Kotor</th>
                <th class="kiri atas bawah kanan text-center" style="vertical-align: middle;"rowspan="2">Pajak</th>
                <th class="kiri atas bawah kanan text-center" style="vertical-align: middle;"rowspan="2">Penerimaan Bersih</th>
            </tr>
            <tr>
                <th class="kiri atas bawah kanan text-center">Harga Satuan</th>
                <th class="kiri atas bawah kanan text-center">Hari</th>
                <th class="kiri atas bawah kanan text-center">Jam</th>
                <th class="kiri atas bawah kanan text-center">Total</th>
                <th class="kiri atas bawah kanan text-center">Harga Satuan</th>
                <th class="kiri atas bawah kanan text-center">Hari</th>
                <th class="kiri atas bawah kanan text-center">Jam</th>
                <th class="kiri atas bawah kanan text-center">Total</th>
            </tr>
            <tr>
                <th class="kiri atas bawah kanan text-center">1</th>
                <th class="kiri atas bawah kanan text-center">2</th>
                <th class="kiri atas bawah kanan text-center">3</th>
                <th class="kiri atas bawah kanan text-center">4</th>
                <th class="kiri atas bawah kanan text-center">5</th>
                <th class="kiri atas bawah kanan text-center">6</th>
                <th class="kiri atas bawah kanan text-center">7=4x6</th>
                <th class="kiri atas bawah kanan text-center">8</th>
                <th class="kiri atas bawah kanan text-center">9</th>
                <th class="kiri atas bawah kanan text-center">10</th>
                <th class="kiri atas bawah kanan text-center">11=8x10</th>
                <th class="kiri atas bawah kanan text-center">12</th>
                <th class="kiri atas bawah kanan text-center">13=7+11+12</th>
                <th class="kiri atas bawah kanan text-center">14</th>
                <th class="kiri atas bawah kanan text-center">15=13-14</th>
            </tr>
        </thead>
        <tbody>
            <?php echo $body; ?>
        </tbody>
    </table>      
</div>
<script type="text/javascript">
    jQuery(document).ready(function(){
        run_download_excel_simpeg();

        // penyesuaian thema wp full width page
        jQuery('.mg-card-box').parent().removeClass('col-md-8').addClass('col-md-12');
        jQuery('#secondary').parent().remove();
        
        jQuery('#skpd').select2();
    });
    function sumbitBulanTahun(){
        var tahun = jQuery('#tahun').val();
        var bulan = jQuery('#bulan').val();
        var skpd = jQuery('#skpd').val();
        if(tahun == ''){
            return alert('Tahun tidak boleh kosong!');
        }else if(bulan == ''){
            return alert('Bulan tidak boleh kosong!');
        }else if(skpd == ''){
            return alert('SKPD tidak boleh kosong!');
        }
        var url = window.location.href;
        url = url.split('?')[0]+'?tahun='+tahun+'&bulan='+bulan+'&id_skpd='+skpd;
        location.href = url;
    }
</script>