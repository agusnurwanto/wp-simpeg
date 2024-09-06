<?php
global $wpdb;

$input = shortcode_atts(array(
    'tahun' => date('Y'),
    'id_skpd' => '',
    'bulan' => date('m') * 1
), $atts);

if (!empty($_GET) && !empty($_GET['tahun'])) {
    $input['tahun'] = $_GET['tahun'];
}
if (!empty($_GET) && !empty($_GET['bulan'])) {
    $input['bulan'] = $_GET['bulan'];
}
if (!empty($_GET) && !empty($_GET['id_skpd'])) {
    $input['id_skpd'] = $_GET['id_skpd'];
}

$tahun = $wpdb->get_results('
    SELECT 
        tahun_anggaran 
    FROM data_unit_lembur
    GROUP BY tahun_anggaran 
    ORDER BY tahun_anggaran ASC
', ARRAY_A);

$select_tahun = "<option value=''>Pilih Tahun</option>";
foreach ($tahun as $tahun_value) {
    $select = $tahun_value['tahun_anggaran'] == $input['tahun'] ? 'selected' : '';
    $select_tahun .= "<option value='" . $tahun_value['tahun_anggaran'] . "' " . $select . ">" . $tahun_value['tahun_anggaran'] . "</option>";
}

$skpd = $wpdb->get_results($wpdb->prepare('
    SELECT 
        *
    FROM data_unit_lembur
    WHERE tahun_anggaran=%d
        AND id_skpd=%d
        AND active=1
', $input['tahun'], $input['id_skpd']), ARRAY_A);

$select_skpd = '<option value="">Pilih SKPD</option>';
foreach ($skpd as $get_skpd) {
    $select = $get_skpd['id_skpd'] == $input['id_skpd'] ? 'selected' : '';
    $select_skpd .= '<option value="' . $get_skpd['id_skpd'] . '" ' . $select . '>' . $get_skpd['kode_skpd'] . ' ' . $get_skpd['nama_skpd'] . '</option>';
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

function translate_day($day)
{
    $days = [
        'Monday' => 'Senin',
        'Tuesday' => 'Selasa',
        'Wednesday' => 'Rabu',
        'Thursday' => 'Kamis',
        'Friday' => 'Jumat',
        'Saturday' => 'Sabtu',
        'Sunday' => 'Minggu'
    ];
    return isset($days[$day]) ? $days[$day] : $day;
}

$sbu_lembur_db = $wpdb->get_results($wpdb->prepare('
    SELECT
        *
    FROM data_sbu_lembur
    WHERE tahun=%d
        AND active=1
', $input['tahun']), ARRAY_A);

$sbu_lembur = array();
foreach ($sbu_lembur_db as $sbu) {
    if (empty($sbu_lembur[$sbu['jenis_sbu']])) {
        $sbu_lembur[$sbu['jenis_sbu']] = array();
    }
    if (empty($sbu_lembur[$sbu['jenis_sbu']][$sbu['jenis_hari']])) {
        $sbu_lembur[$sbu['jenis_sbu']][$sbu['jenis_hari']] = array();
    }
    if (empty($sbu_lembur[$sbu['jenis_sbu']][$sbu['jenis_hari']][$sbu['id_golongan']])) {
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
        s.update_at,
        s.jml_pajak,
        p.gelar_depan,
        p.nama,
        p.gelar_belakang,
        p.kode_gol,
        p.gol_ruang,
        s.created_at,
        s.ket_lembur,
        s.jml_peg,
        DAYNAME(d.waktu_mulai) as get_hari,
        d.jml_jam as jml_jam_gol
    FROM data_absensi_lembur_detail d
    INNER JOIN data_absensi_lembur s ON d.id_spt = s.id
        AND s.active=d.active
    INNER JOIN data_pegawai_lembur p ON d.id_pegawai = p.id
        AND p.active=d.active
        AND p.tahun=s.tahun_anggaran
    WHERE s.tahun_anggaran=%d
        AND s.id_skpd=%d
        AND d.active=1
        AND s.status = 2
        AND MONTH(s.created_at)= %d
    ORDER BY s.created_at ASC, d.waktu_mulai ASC
', $input['tahun'], $input['id_skpd'], $input['bulan']), ARRAY_A);

$hari_aktif = array(); 
$hari_libur = array(); 
foreach ($lap_bulanan_pegawai as $peg) {
    $hari_lembur = $peg['waktu_mulai'].'-'.$peg['waktu_akhir'];
    if(empty($hari_aktif[$hari_lembur]) && $peg['tipe_hari'] == 2){
        $hari_aktif[$hari_lembur] = array(
            'total' => 0,
            'nama_hari' => translate_day($peg['get_hari']),
            'waktu_mulai' => $peg['waktu_mulai'],
            'waktu_akhir' => $peg['waktu_akhir'],
            'ket_lembur' => $peg['ket_lembur'],
            'uang_makan' => $peg['uang_makan'],
            'data' => array()
        );
    }else if(empty($hari_libur[$hari_lembur]) && $peg['tipe_hari'] == 1){
        $hari_libur[$hari_lembur] = array(
            'total' => 0,
            'nama_hari' => translate_day($peg['get_hari']),
            'waktu_mulai' => $peg['waktu_mulai'],
            'waktu_akhir' => $peg['waktu_akhir'],
            'ket_lembur' => $peg['ket_lembur'],
            'uang_makan' => $peg['uang_makan'],
            'data' => array()
        );
    }

    if($peg['tipe_hari'] == 2 &&  empty($hari_aktif[$hari_lembur]['data'][$peg['kode_gol']])){
        $hari_aktif[$hari_lembur]['data'][$peg['kode_gol']] = array(
            'total' => 0,
            'data' => array()
        );
    }else if($peg['tipe_hari'] == 1 &&  empty($hari_libur[$hari_lembur]['data'][$peg['kode_gol']])){
        $hari_libur[$hari_lembur]['data'][$peg['kode_gol']] = array(
            'total' => 0,
            'data' => array()
        );
    }
    if($peg['tipe_hari'] == 2 ){
        $hari_aktif[$hari_lembur]['total'] += $peg['uang_lembur']+$peg['uang_makan'];
        $hari_aktif[$hari_lembur]['data'][$peg['kode_gol']]['total'] += $peg['uang_lembur']+$peg['uang_makan'];
        $hari_aktif[$hari_lembur]['data'][$peg['kode_gol']]['data'][] = $peg;
    }else if($peg['tipe_hari'] == 1){
        $hari_libur[$hari_lembur]['total'] += $peg['uang_lembur']+$peg['uang_makan'];
        $hari_libur[$hari_lembur]['data'][$peg['kode_gol']]['total'] += $peg['uang_lembur']+$peg['uang_makan'];
        $hari_libur[$hari_lembur]['data'][$peg['kode_gol']]['data'][] = $peg;
    }
}

$body = '';
$nomor = 0;
$total_all_4 = 0;
$total_all_5 = 0;
$total_all_makan = 0;
$total_all = 0;
$total_all_2 = 0;
$total_all_3 = 0;
foreach ($hari_aktif as $tanggal => $tanggal_val) {
    $nomor++;
    $hari = '';
    $total_jml_peg = 0;
    $tgl_lembur = date('d-m-Y', strtotime($peg['waktu_mulai']));
    $waktu_mulai = date('H:i', strtotime($tanggal_val['waktu_mulai']));
    $waktu_akhir = date('H:i', strtotime($tanggal_val['waktu_akhir']));
    $keterangan = $tanggal_val['ket_lembur'];
    $uang_makan = $tanggal_val['uang_makan'];

    $jml_peg_4 = 0;
    $total_jam_4 = 0;
    $harga_4 = 0;
    $total_harga_4 = 0;
    if (
        !empty($sbu_lembur['uang_lembur'])
        && !empty($sbu_lembur['uang_lembur'][2][4])
    ) {
        $harga_4 = $sbu_lembur['uang_lembur'][2][4]['harga'];
    }
    if(!empty($tanggal_val['data'][4]['data'])){
        foreach($tanggal_val['data'][4]['data'] as $peg){
            $jml_peg_4++;
            $total_jam_4 = $peg['jml_jam_gol']; 
        }
        $total_harga_4 = $harga_4*$total_jam_4;
    }
    $jml_peg_3 = 0;
    $total_jam_3 = 0;
    $harga_3 = 0;
    $total_harga_3 = 0;
    if (
        !empty($sbu_lembur['uang_lembur'])
        && !empty($sbu_lembur['uang_lembur'][2][3])
    ) {
        $harga_3 = $sbu_lembur['uang_lembur'][2][3]['harga'];
    }
    if(!empty($tanggal_val['data'][3]['data'])){
        foreach($tanggal_val['data'][3]['data'] as $peg){
            $jml_peg_3++;
            $total_jam_3 = $peg['jml_jam_gol']; 
        }
        $total_harga_3 = $harga_3*$total_jam_3;
    }
    $jml_peg_2 = 0;
    $total_jam_2 = 0;
    $harga_2 = 0;
    $total_harga_2 = 0;
    if (
        !empty($sbu_lembur['uang_lembur'])
        && !empty($sbu_lembur['uang_lembur'][2][2])
    ) {
        $harga_2 = $sbu_lembur['uang_lembur'][1][2]['harga'];
    }
    if(!empty($tanggal_val['data'][2]['data'])){
        foreach($tanggal_val['data'][2]['data'] as $peg){
            $jml_peg_2++;
            $total_jam_2 = $peg['jml_jam_gol']; 
        }
        $total_harga_2 = $harga_2*$total_jam_2;
    }
    $jml_peg_5 = 0;
    $total_jam_5 = 0;
    $harga_5 = 0;
    $total_harga_5 = 0;
    if (
        !empty($sbu_lembur['uang_lembur'])
        && !empty($sbu_lembur['uang_lembur'][2][5])
    ) {
        $harga_5 = $sbu_lembur['uang_lembur'][2][5]['harga'];
    }
    if(!empty($tanggal_val['data'][5]['data'])){
        foreach($tanggal_val['data'][5]['data'] as $peg){
            $jml_peg_5++;
            $total_jam_5 = $peg['jml_jam_gol']; 
        }
        $total_harga_5 = $harga_5*$total_jam_5;
    }
    $total_jml_peg = $jml_peg_2+$jml_peg_3+$jml_peg_4+$jml_peg_5;
    $total_jam_makan = 0;
    if (!empty($total_jam_2)) {
        $total_jam_makan = $total_jam_2;
    } elseif (!empty($total_jam_3)) {
        $total_jam_makan = $total_jam_3;
    } elseif (!empty($total_jam_4)) {
        $total_jam_makan = $total_jam_4;
    } elseif (!empty($total_jam_5)) {
        $total_jam_makan = $total_jam_5;
    }
    if ($total_jam_makan < 2) {
        $total_harga_makan = '0';
    } else {
        $total_harga_makan = ($total_jml_peg + $total_jam_makan) * $uang_makan;
    }
    $total = 0;
    $total = $total_harga_4 + $total_harga_3 + $total_harga_2 + $total_harga_5 + $total_harga_makan;
    $total_all_2 += $total_harga_2;
    $total_all_3 += $total_harga_3;
    $total_all_4 += $total_harga_4;
    $total_all_5 += $total_harga_5;
    $total_all_makan += $total_harga_makan;
    $total_all += $total;
    $body .= '
    <tr>
        <td class="kiri atas bawah kanan text-center">' . $nomor . '</td>
        <td class="kiri atas bawah kanan text-left">' . $tanggal_val['nama_hari'] . ', ' . $tgl_lembur . '</td>
        <td class="kiri atas bawah kanan text-center">' . $waktu_mulai . '</td>
        <td class="kiri atas bawah kanan text-center">' . $waktu_akhir . '</td>
        <td class="kiri atas bawah kanan text-left">' . $keterangan . '</td>
        <td class="kiri atas bawah kanan text-center">' . $jml_peg_4 .'</td>
        <td class="kiri atas bawah kanan text-center">' . $this->rupiah($total_jam_4) .'</td>
        <td class="kiri atas bawah kanan text-right">' . $this->rupiah($harga_4) .'</td>
        <td class="kiri atas bawah kanan text-right">' . $this->rupiah($total_harga_4) .'</td>
        <td class="kiri atas bawah kanan text-center">' . $jml_peg_3 .'</td>
        <td class="kiri atas bawah kanan text-center">' . $this->rupiah($total_jam_3) .'</td>
        <td class="kiri atas bawah kanan text-right">' . $this->rupiah($harga_3) .'</td>
        <td class="kiri atas bawah kanan text-right">' . $this->rupiah($total_harga_3) .'</td>
        <td class="kiri atas bawah kanan text-center">' . $jml_peg_2 .'</td>
        <td class="kiri atas bawah kanan text-center">' . $this->rupiah($total_jam_2) .'</td>
        <td class="kiri atas bawah kanan text-right">' . $this->rupiah($harga_2) .'</td>
        <td class="kiri atas bawah kanan text-right">' . $this->rupiah($total_harga_2) .'</td>
        <td class="kiri atas bawah kanan text-center">' . $jml_peg_5 .'</td>
        <td class="kiri atas bawah kanan text-center">' . $this->rupiah($total_jam_5) .'</td>
        <td class="kiri atas bawah kanan text-right">' . $this->rupiah($harga_5) .'</td>
        <td class="kiri atas bawah kanan text-right">' . $this->rupiah($total_harga_5) .'</td>
        <td class="kiri atas bawah kanan text-center">' . $total_jml_peg .'</td>
        <td class="kiri atas bawah kanan text-center">' . $total_jam_makan.'</td>
        <td class="kiri atas bawah kanan text-right">' . $uang_makan .'</td>
        <td class="kiri atas bawah kanan text-right">' . $this->rupiah($total_harga_makan) .'</td>
        <td class="kiri atas bawah kanan text-right">' . $this->rupiah($total) .'</td>
    </tr>
    ';
}

$body2 = '';
$nomor = 0;
$total_all_4_libur = 0;
$total_all_5_libur = 0;
$total_all_makan_libur = 0;
$total_all_libur = 0;
$total_all_2_libur = 0;
$total_all_3_libur = 0;
foreach ($hari_libur as $tanggal2 => $tanggal_val2) {
    $nomor++;
    $hari = '';
    $total_jml_peg = 0;
    $tgl_lembur = date('d-m-Y', strtotime($tanggal_val2['waktu_mulai']));
    $waktu_mulai = date('H:i', strtotime($tanggal_val2['waktu_mulai']));
    $waktu_akhir = date('H:i', strtotime($tanggal_val2['waktu_akhir']));
    $keterangan = $tanggal_val2['ket_lembur'];

    $jml_peg_4 = 0;
    $total_jam_4 = 0;
    $harga_4 = 0;
    $total_harga_4 = 0;
    if (
        !empty($sbu_lembur['uang_lembur'])
        && !empty($sbu_lembur['uang_lembur'][1][4])
    ) {
        $harga_4 = $sbu_lembur['uang_lembur'][1][4]['harga'];
    }
    if(!empty($tanggal_val2['data'][4]['data'])){
        foreach($tanggal_val2['data'][4]['data'] as $peg){
            $jml_peg_4++;
            $total_jam_4 = $peg['jml_jam_gol']; 
        }
        $total_harga_4 = $harga_4*$total_jam_4;
    }
    $jml_peg_3 = 0;
    $total_jam_3 = 0;
    $harga_3 = 0;
    $total_harga_3 = 0;
    if (
        !empty($sbu_lembur['uang_lembur'])
        && !empty($sbu_lembur['uang_lembur'][1][3])
    ) {
        $harga_3 = $sbu_lembur['uang_lembur'][1][3]['harga'];
    }
    if(!empty($tanggal_val2['data'][3]['data'])){
        foreach($tanggal_val2['data'][3]['data'] as $peg){
            $jml_peg_3++;
            $total_jam_3 = $peg['jml_jam_gol']; 
        }
        $total_harga_3 = $harga_3*$total_jam_3;
    }
    $jml_peg_2 = 0;
    $total_jam_2 = 0;
    $harga_2 = 0;
    $total_harga_2 = 0;
    if (
        !empty($sbu_lembur['uang_lembur'])
        && !empty($sbu_lembur['uang_lembur'][1][2])
    ) {
        $harga_2 = $sbu_lembur['uang_lembur'][1][2]['harga'];
    }
    if(!empty($tanggal_val2['data'][1]['data'])){
        foreach($tanggal_val2['data'][1]['data'] as $peg){
            $jml_peg_2++;
            $total_jam_2 = $peg['jml_jam_gol']; 
        }
        $total_harga_2 = $harga_2*$total_jam_2;
    }
    $jml_peg_5 = 0;
    $total_jam_5 = 0;
    $harga_5 = 0;
    $total_harga_5 = 0;
    if (
        !empty($sbu_lembur['uang_lembur'])
        && !empty($sbu_lembur['uang_lembur'][1][5])
    ) {
        $harga_5 = $sbu_lembur['uang_lembur'][1][5]['harga'];
    }
    if(!empty($tanggal_val2['data'][5]['data'])){
        foreach($tanggal_val2['data'][5]['data'] as $peg){
            $jml_peg_5++;
            $total_jam_5 = $peg['jml_jam_gol']; 
        }
        $total_harga_5 = $harga_5*$total_jam_5;
    }
    $total_jml_peg = $jml_peg_2+$jml_peg_3+$jml_peg_4+$jml_peg_5;
    $total_jam_makan = 0;
    if (!empty($total_jam_2)) {
        $total_jam_makan = $total_jam_2;
    } elseif (!empty($total_jam_3)) {
        $total_jam_makan = $total_jam_3;
    } elseif (!empty($total_jam_4)) {
        $total_jam_makan = $total_jam_4;
    } elseif (!empty($total_jam_5)) {
        $total_jam_makan = $total_jam_5;
    }
    if ($total_jam_makan < 2) {
        $total_harga_makan = '0';
    } else {
        $total_harga_makan = ($total_jml_peg + $total_jam_makan) * $peg['uang_makan'];
    }
    $total = $total_harga_4 + $total_harga_3 + $total_harga_2 + $total_harga_5 + $total_harga_makan;
    $total_all_2_libur += $total_harga_2;
    $total_all_3_libur += $total_harga_3;
    $total_all_4_libur += $total_harga_4;
    $total_all_5_libur += $total_harga_5;
    $total_all_makan_libur += $total_harga_makan;
    $total_all_libur += $total;
    $body2 .= '
    <tr>
        <td class="kiri atas bawah kanan text-center">' . $nomor . '</td>
        <td class="kiri atas bawah kanan text-left">' . $tanggal_val2['nama_hari'] . ', ' . $tgl_lembur . '</td>
        <td class="kiri atas bawah kanan text-center">' . $waktu_mulai . '</td>
        <td class="kiri atas bawah kanan text-center">' . $waktu_akhir . '</td>
        <td class="kiri atas bawah kanan text-left">' . $keterangan . '</td>
        <td class="kiri atas bawah kanan text-center">' . $jml_peg_4 .'</td>
        <td class="kiri atas bawah kanan text-center">' . $this->rupiah($total_jam_4) .'</td>
        <td class="kiri atas bawah kanan text-right">' . $this->rupiah($harga_4) .'</td>
        <td class="kiri atas bawah kanan text-right">' . $this->rupiah($total_harga_4) .'</td>
        <td class="kiri atas bawah kanan text-center">' . $jml_peg_3 .'</td>
        <td class="kiri atas bawah kanan text-center">' . $this->rupiah($total_jam_3) .'</td>
        <td class="kiri atas bawah kanan text-right">' . $this->rupiah($harga_3) .'</td>
        <td class="kiri atas bawah kanan text-right">' . $this->rupiah($total_harga_3) .'</td>
        <td class="kiri atas bawah kanan text-center">' . $jml_peg_2 .'</td>
        <td class="kiri atas bawah kanan text-center">' . $this->rupiah($total_jam_2) .'</td>
        <td class="kiri atas bawah kanan text-right">' . $this->rupiah($harga_2) .'</td>
        <td class="kiri atas bawah kanan text-right">' . $this->rupiah($total_harga_2) .'</td>
        <td class="kiri atas bawah kanan text-center">' . $jml_peg_5 .'</td>
        <td class="kiri atas bawah kanan text-center">' . $this->rupiah($total_jam_5) .'</td>
        <td class="kiri atas bawah kanan text-right">' . $this->rupiah($harga_5) .'</td>
        <td class="kiri atas bawah kanan text-right">' . $this->rupiah($total_harga_5) .'</td>
        <td class="kiri atas bawah kanan text-center">' . $total_jml_peg .'</td>
        <td class="kiri atas bawah kanan text-center">' . $total_jam_makan.'</td>
        <td class="kiri atas bawah kanan text-right">' . $peg['uang_makan'] .'</td>
        <td class="kiri atas bawah kanan text-right">' . $this->rupiah($total_harga_makan) .'</td>
        <td class="kiri atas bawah kanan text-right">' . $this->rupiah($total) .'</td>
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
    #tabel-absensi-pegawai-per-skpd-lembur {
        font-family:\'Open Sans\',-apple-system,BlinkMacSystemFont,\'Segoe UI\',sans-serif; 
        border-collapse: collapse; 
        font-size: 70%; 
        border: 0; 
        table-layout: fixed;
    }
    #tabel-absensi-pegawai-per-skpd-lembur thead{
        position: sticky;
        top: -6px;
        background: #ffc491;
    }
    #tabel-absensi-pegawai-per-skpd-lembur tfoot{
        position: sticky;
        bottom: -6px;
        background: #ffc491;
    }
</style>

<div id="wrap-action"></div>
<div class="text-center" style="max-width: 700px; margin: auto; margin-top: 30px;">
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
    <label style="margin-left: 10px; margin-top: 30px;" for="skpd">SKPD:</label>
    <select style="width: 400px;" name="skpd" id="skpd">
        <?php echo $select_skpd; ?>
    </select>
    <button style="margin-left: 10px; height: 45px; width: 75px;" onclick="sumbitBulanTahun(); return false;" class="btn btn-sm btn-primary">Cari</button>
</div>
<h3 style="margin-top: 20px;" class="text-center">Uang Lembur Hari Kerja<br>Bulan <?php echo $namaBulan[$input['bulan']]; ?> Tahun <?php echo $input['tahun']; ?></h3 style="margin-top: 20px;">
<div id="cetak" style="padding: 5px; overflow: auto; max-height: 80vh;">
    <table id="tabel-absensi-pegawai-per-skpd" cellpadding="2" cellspacing="0" contenteditable="false">
        <thead>
            <tr>
                <th class="kiri atas bawah kanan text-center" style="vertical-align: middle; width: 40px;" rowspan="3">No</th>
                <th class="kiri atas bawah kanan text-center" style="vertical-align: middle; width: 125px;" rowspan="3">Hari/Tanggal</th>
                <th class="kiri atas bawah kanan text-center" style="vertical-align: middle;" colspan="2" rowspan="2">Pukul</th>
                <th class="kiri atas bawah kanan text-center" style="vertical-align: middle; width: 200px;" rowspan="3">Kegiatan</th>
                <!-- <th class="kiri atas bawah kanan text-center" style="vertical-align: middle;" rowspan="3">Lokasi</th> -->
                <th class="kiri atas bawah kanan text-center" style="vertical-align: middle;" colspan="20">Perincian</th>
                <th class="kiri atas bawah kanan text-center" style="vertical-align: middle; width: 100px;" rowspan="3">Total</th>
            </tr>
            <tr>
                <th class="kiri atas bawah kanan text-center" colspan="4">Golongan IV</th>
                <th class="kiri atas bawah kanan text-center" colspan="4">Golongan III</th>
                <th class="kiri atas bawah kanan text-center" colspan="4">Golongan II</th>
                <th class="kiri atas bawah kanan text-center" colspan="4">Non ASN</th>
                <th class="kiri atas bawah kanan text-center" colspan="4">Makan Minum Lembur</th>
            </tr>
            <tr>
                <th class="kiri atas bawah kanan text-center">Mulai</th>
                <th class="kiri atas bawah kanan text-center">Selesai</th>
                <th class="kiri atas bawah kanan text-center">Jumlah Pegawai</th>
                <th class="kiri atas bawah kanan text-center">Total Jam</th>
                <th class="kiri atas bawah kanan text-center">Harga</th>
                <th class="kiri atas bawah kanan text-center">Total Harga</th>
                <th class="kiri atas bawah kanan text-center">Jumlah Pegawai</th>
                <th class="kiri atas bawah kanan text-center">Total Jam</th>
                <th class="kiri atas bawah kanan text-center">Harga</th>
                <th class="kiri atas bawah kanan text-center">Total Harga</th>
                <th class="kiri atas bawah kanan text-center">Jumlah Pegawai</th>
                <th class="kiri atas bawah kanan text-center">Total Jam</th>
                <th class="kiri atas bawah kanan text-center">Harga</th>
                <th class="kiri atas bawah kanan text-center">Total Harga</th>
                <th class="kiri atas bawah kanan text-center">Jumlah Pegawai</th>
                <th class="kiri atas bawah kanan text-center">Total Jam</th>
                <th class="kiri atas bawah kanan text-center">Harga</th>
                <th class="kiri atas bawah kanan text-center">Total Harga</th>
                <th class="kiri atas bawah kanan text-center">Jumlah Pegawai</th>
                <th class="kiri atas bawah kanan text-center">Total Jam</th>
                <th class="kiri atas bawah kanan text-center">Harga</th>
                <th class="kiri atas bawah kanan text-center">Total Harga</th>
            </tr>
            <tr>
                <th class="kiri atas bawah kanan text-center">1</th>
                <th class="kiri atas bawah kanan text-center">2</th>
                <th class="kiri atas bawah kanan text-center">3</th>
                <th class="kiri atas bawah kanan text-center">4</th>
                <th class="kiri atas bawah kanan text-center">5</th>
                <th class="kiri atas bawah kanan text-center">6</th>
                <th class="kiri atas bawah kanan text-center">7</th>
                <th class="kiri atas bawah kanan text-center">8</th>
                <th class="kiri atas bawah kanan text-center">9</th>
                <th class="kiri atas bawah kanan text-center">10</th>
                <th class="kiri atas bawah kanan text-center">11</th>
                <th class="kiri atas bawah kanan text-center">12</th>
                <th class="kiri atas bawah kanan text-center">13</th>
                <th class="kiri atas bawah kanan text-center">14</th>
                <th class="kiri atas bawah kanan text-center">15</th>
                <th class="kiri atas bawah kanan text-center">16</th>
                <th class="kiri atas bawah kanan text-center">17</th>
                <th class="kiri atas bawah kanan text-center">18</th>
                <th class="kiri atas bawah kanan text-center">19</th>
                <th class="kiri atas bawah kanan text-center">20</th>
                <th class="kiri atas bawah kanan text-center">21</th>
                <th class="kiri atas bawah kanan text-center">22</th>
                <th class="kiri atas bawah kanan text-center">23</th>
                <th class="kiri atas bawah kanan text-center">24</th>
                <th class="kiri atas bawah kanan text-center">25</th>
                <th class="kiri atas bawah kanan text-center">26</th>
            </tr>
        </thead>
        <tbody>
            <?php echo $body; ?>
        </tbody>
        <tfoot>
            <tr>
                <th class="kiri kanan bawah text_blok text_kanan" colspan="8">TOTAL</th>
                <th class="kiri kanan bawah text_blok text_kanan"><?php echo number_format($total_all_4,0,",","."); ?></th></th>
                <th class="kiri kanan bawah text_blok text_kanan" colspan="4"><?php echo number_format($total_all_3,0,",","."); ?></th></th>
                <th class="kiri kanan bawah text_blok text_kanan" colspan="4"><?php echo number_format($total_all_2,0,",","."); ?></th></th>
                <th class="kiri kanan bawah text_blok text_kanan" colspan="4"><?php echo number_format($total_all_5,0,",","."); ?></th></th>
                <th class="kiri kanan bawah text_blok text_kanan" colspan="4"><?php echo number_format($total_all_makan,0,",","."); ?></th></th>
                <th class="kiri kanan bawah text_blok text_kanan"><?php echo number_format($total_all,0,",","."); ?></th></th>
            </tr>
        </tfoot>
    </table>      
</div>
<h3 style="margin-top: 20px;" class="text-center">Uang Lembur Hari Libur<br>Bulan <?php echo $namaBulan[$input['bulan']]; ?> Tahun <?php echo $input['tahun']; ?></h3 style="margin-top: 20px;">
<div id="cetak" style="padding: 5px; overflow: auto; max-height: 80vh;">
    <table id="tabel-absensi-pegawai-per-skpd-lembur" cellpadding="2" cellspacing="0" contenteditable="false">
        <thead>
            <tr>
                <th class="kiri atas bawah kanan text-center" style="vertical-align: middle; width: 40px;" rowspan="3">No</th>
                <th class="kiri atas bawah kanan text-center" style="vertical-align: middle; width: 125px;" rowspan="3">Hari/Tanggal</th>
                <th class="kiri atas bawah kanan text-center" style="vertical-align: middle;" colspan="2" rowspan="2">Pukul</th>
                <th class="kiri atas bawah kanan text-center" style="vertical-align: middle; width: 200px;" rowspan="3">Kegiatan</th>
                <!-- <th class="kiri atas bawah kanan text-center" style="vertical-align: middle;" rowspan="3">Lokasi</th> -->
                <th class="kiri atas bawah kanan text-center" style="vertical-align: middle;" colspan="20">Perincian</th>
                <th class="kiri atas bawah kanan text-center" style="vertical-align: middle; width: 100px;" rowspan="3">Total</th>
            </tr>
            <tr>
                <th class="kiri atas bawah kanan text-center" colspan="4">Golongan IV</th>
                <th class="kiri atas bawah kanan text-center" colspan="4">Golongan III</th>
                <th class="kiri atas bawah kanan text-center" colspan="4">Golongan II</th>
                <th class="kiri atas bawah kanan text-center" colspan="4">Non ASN</th>
                <th class="kiri atas bawah kanan text-center" colspan="4">Makan Minum Lembur</th>
            </tr>
            <tr>
                <th class="kiri atas bawah kanan text-center">Mulai</th>
                <th class="kiri atas bawah kanan text-center">Selesai</th>
                <th class="kiri atas bawah kanan text-center">Jumlah Pegawai</th>
                <th class="kiri atas bawah kanan text-center">Total Jam</th>
                <th class="kiri atas bawah kanan text-center">Harga</th>
                <th class="kiri atas bawah kanan text-center">Total Harga</th>
                <th class="kiri atas bawah kanan text-center">Jumlah Pegawai</th>
                <th class="kiri atas bawah kanan text-center">Total Jam</th>
                <th class="kiri atas bawah kanan text-center">Harga</th>
                <th class="kiri atas bawah kanan text-center">Total Harga</th>
                <th class="kiri atas bawah kanan text-center">Jumlah Pegawai</th>
                <th class="kiri atas bawah kanan text-center">Total Jam</th>
                <th class="kiri atas bawah kanan text-center">Harga</th>
                <th class="kiri atas bawah kanan text-center">Total Harga</th>
                <th class="kiri atas bawah kanan text-center">Jumlah Pegawai</th>
                <th class="kiri atas bawah kanan text-center">Total Jam</th>
                <th class="kiri atas bawah kanan text-center">Harga</th>
                <th class="kiri atas bawah kanan text-center">Total Harga</th>
                <th class="kiri atas bawah kanan text-center">Jumlah Pegawai</th>
                <th class="kiri atas bawah kanan text-center">Total Jam</th>
                <th class="kiri atas bawah kanan text-center">Harga</th>
                <th class="kiri atas bawah kanan text-center">Total Harga</th>
            </tr>
            <tr>
                <th class="kiri atas bawah kanan text-center">1</th>
                <th class="kiri atas bawah kanan text-center">2</th>
                <th class="kiri atas bawah kanan text-center">3</th>
                <th class="kiri atas bawah kanan text-center">4</th>
                <th class="kiri atas bawah kanan text-center">5</th>
                <th class="kiri atas bawah kanan text-center">6</th>
                <th class="kiri atas bawah kanan text-center">7</th>
                <th class="kiri atas bawah kanan text-center">8</th>
                <th class="kiri atas bawah kanan text-center">9</th>
                <th class="kiri atas bawah kanan text-center">10</th>
                <th class="kiri atas bawah kanan text-center">11</th>
                <th class="kiri atas bawah kanan text-center">12</th>
                <th class="kiri atas bawah kanan text-center">13</th>
                <th class="kiri atas bawah kanan text-center">14</th>
                <th class="kiri atas bawah kanan text-center">15</th>
                <th class="kiri atas bawah kanan text-center">16</th>
                <th class="kiri atas bawah kanan text-center">17</th>
                <th class="kiri atas bawah kanan text-center">18</th>
                <th class="kiri atas bawah kanan text-center">19</th>
                <th class="kiri atas bawah kanan text-center">20</th>
                <th class="kiri atas bawah kanan text-center">21</th>
                <th class="kiri atas bawah kanan text-center">22</th>
                <th class="kiri atas bawah kanan text-center">23</th>
                <th class="kiri atas bawah kanan text-center">24</th>
                <th class="kiri atas bawah kanan text-center">25</th>
                <th class="kiri atas bawah kanan text-center">26</th>
            </tr>
        </thead>
        <tbody>
            <?php echo $body2; ?>
        </tbody>
        <tfoot>
            <tr>
                <th class="kiri kanan bawah text_blok text_kanan" colspan="8">TOTAL</th>
                <th class="kiri kanan bawah text_blok text_kanan"><?php echo number_format($total_all_4_libur,0,",","."); ?></th></th>
                <th class="kiri kanan bawah text_blok text_kanan" colspan="4"><?php echo number_format($total_all_3_libur,0,",","."); ?></th></th>
                <th class="kiri kanan bawah text_blok text_kanan" colspan="4"><?php echo number_format($total_all_2_libur,0,",","."); ?></th></th>
                <th class="kiri kanan bawah text_blok text_kanan" colspan="4"><?php echo number_format($total_all_5_libur,0,",","."); ?></th></th>
                <th class="kiri kanan bawah text_blok text_kanan" colspan="4"><?php echo number_format($total_all_makan_libur,0,",","."); ?></th></th>
                <th class="kiri kanan bawah text_blok text_kanan"><?php echo number_format($total_all_libur,0,",","."); ?></th></th>
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
        url = updateURLParameter(url, 'tahun', tahun);
        url = updateURLParameter(url, 'bulan', bulan);
        url = updateURLParameter(url, 'id_skpd', skpd);
        location.href = url;
    }
</script>