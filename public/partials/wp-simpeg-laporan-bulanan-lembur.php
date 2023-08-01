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
    $select_tahun .= "<option value='".$tahun_value['tahun_anggaran']."' ".$select.">Tahun Anggaran ".$tahun_value['tahun_anggaran']."</option>";
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
        s.nomor_spt,
        s.tahun_anggaran,
        s.id_skpd,
        p.gelar_depan,
        p.nama,
        p.gelar_belakang,
        p.kode_gol,
        p.gol_ruang
    from data_spt_lembur_detail d
    INNER JOIN data_spt_lembur s on d.id_spt = s.id
        AND s.active=d.active
    INNER JOIN data_pegawai_lembur p on d.id_pegawai = p.id
        AND p.active=d.active
        AND p.tahun=s.tahun_anggaran
    WHERE s.tahun_anggaran=%d
        and s.id_skpd=%d
        and s.status=4
        and d.active=1
    order by p.nama ASC
', $input['tahun'], $input['id_skpd']), ARRAY_A);
$data_all = array();
foreach($lap_bulanan_pegawai as $peg){
    if(empty($data_all[$peg['id_pegawai']])){
        $data_all[$peg['id_pegawai']] = $peg;
    }
}

$nomor = 0;
$body = '';
foreach($data_all as $peg){
    $nomor++;
    $uang_lembur_hari_kerja = 0;
    if(
        !empty($sbu_lembur['uang_lembur'])
        && !empty($sbu_lembur['uang_lembur'][2])
        && !empty($sbu_lembur['uang_lembur'][2][$peg['kode_gol']])
    ){
        $uang_lembur_hari_kerja = $sbu_lembur['uang_lembur'][2][$peg['kode_gol']]['harga'];
    }
    $uang_lembur_hari_libur = 0;
    if(
        !empty($sbu_lembur['uang_lembur'])
        && !empty($sbu_lembur['uang_lembur'][1])
        && !empty($sbu_lembur['uang_lembur'][1][$peg['kode_gol']])
    ){
        $uang_lembur_hari_libur = $sbu_lembur['uang_lembur'][1][$peg['kode_gol']]['harga'];
    }
    $body .= '
        <tr>
            <td class="text-center">'.$nomor.'</td>
            <td>'.$peg['gelar_depan'].' '.$peg['nama'].' '.$peg['gelar_belakang'].'</td>
            <td class="text-center">'.$peg['gol_ruang'].'</td>
            <td class="text-right">'.number_format($uang_lembur_hari_kerja, 0, ',', '.').'</td>
            <td></td>
            <td></td>
            <td></td>
            <td class="text-right">'.number_format($uang_lembur_hari_libur, 0, ',', '.').'</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
    ';
}
?>
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
<div class="cetak container-fluid">
    <h1 class="text-center">Laporan Lembur<br>Bulan <?php echo $namaBulan[$input['bulan']]; ?> Tahun <?php echo $input['tahun']; ?></h1>
    <table class="table table-bordered">
        <thead>
            <tr>
                <td class="atas kanan bawah kiri text-center text_blok" style="vertical-align: middle;" rowspan="2">No</td>
                <td class="atas kanan bawah text-center text_blok" style="vertical-align: middle;" rowspan="2">Nama</td>
                <td class="atas kanan bawah text-center text_blok" style="vertical-align: middle;" rowspan="3">Golongan</td>
                <td class="atas kanan bawah text-center text_blok" style="vertical-align: middle;" colspan="4">Hari Libur</td>
                <td class="atas kanan bawah text-center text_blok" style="vertical-align: middle;" colspan="4">Hari Kerja</td>
                <td class="atas kanan bawah text-center text_blok" style="vertical-align: middle;"rowspan="2">Uang Makan</td>
                <td class="atas kanan bawah text-center text_blok" style="vertical-align: middle;"rowspan="2">Penerimaan Kotor</td>
                <td class="atas kanan bawah text-center text_blok" style="vertical-align: middle;"rowspan="2">Pajak</td>
                <td class="atas kanan bawah text-center text_blok" style="vertical-align: middle;"rowspan="2">Penerimaan Bersih</td>
            </tr>
            <tr>
                <td class="kanan bawah text-center text_blok" rowspan="2">Harga Satuan</td>
                <td class="kanan bawah text-center text_blok" rowspan="2">Hari</td>
                <td class="kanan bawah text-center text_blok" rowspan="2">Jam</td>
                <td class="kanan bawah text-center text_blok" rowspan="2">Total</td>
                <td class="kanan bawah text-center text_blok" rowspan="2">Harga Satuan</td>
                <td class="kanan bawah text-center text_blok" rowspan="2">Hari</td>
                <td class="kanan bawah text-center text_blok" rowspan="2">Jam</td>
                <td class="kanan bawah text-center text_blok" rowspan="2">Total</td>
            </tr>
        </thead>
        <tbody>
            <?php echo $body; ?>
        </tbody>
    </table>      
</div>
<script type="text/javascript">
    jQuery('document').ready(function(){
        jQuery('select').select2();
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