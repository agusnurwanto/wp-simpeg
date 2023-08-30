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
    'id' => ''
), $atts );

if(!empty($_GET) && !empty($_GET['tahun'])){
    $input['tahun'] = $_GET['tahun'];
}
if(!empty($_GET) && !empty($_GET['id_skpd'])){
    $input['id_skpd'] = $_GET['id_skpd'];
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

$uang_lembur_hari_kerja_2= 0;
if(
    !empty($sbu_lembur['uang_lembur'])
    && !empty($sbu_lembur['uang_lembur'][2])
    && !empty($sbu_lembur['uang_lembur'][2][$set_peg['kode_gol']])
){
    $uang_lembur_hari_kerja_2 = $sbu_lembur['uang_lembur'][2][$set_peg['kode_gol']]['harga'];
}

$uang_lembur_hari_libur_2= 0;
if(
    !empty($sbu_lembur['uang_lembur'])
    && !empty($sbu_lembur['uang_lembur'][1])
    && !empty($sbu_lembur['uang_lembur'][1][$set_peg['kode_gol']])
){
    $uang_lembur_hari_libur_2 = $sbu_lembur['uang_lembur'][1][$set_peg['kode_gol']]['harga'];
}

$uang_makan_lembur_2= 0;
if(
    !empty($sbu_lembur['uang_makan'][0])
    && !empty($sbu_lembur['uang_makan'][0])
    && !empty($sbu_lembur['uang_makan'][0][$set_peg['kode_gol']])
){
    $uang_makan_lembur_2 = $sbu_lembur['uang_makan'][0][$set_peg['kode_gol']]['harga'];
}

$lap_pegawai = $wpdb->get_results($wpdb->prepare('
    SELECT 
        d.*,
        s.*,
        p.*,
        j.*
    from data_spt_lembur_detail d
    INNER JOIN data_spt_lembur s on d.id_spt = s.id
        AND s.active=d.active
    INNER JOIN data_pegawai_lembur p on d.id_pegawai = p.id
        AND p.active=d.active
        AND p.tahun=s.tahun_anggaran
    INNER JOIN data_spj_lembur j on d.id_spt = j.id
        AND j.active=d.active
    WHERE s.tahun_anggaran=%d
        AND p.id=%d
        AND d.active=1
        AND s.status>=6
', $input['tahun'], $input['id']), ARRAY_A);
$data_all = array();
foreach($lap_pegawai as $peg){
    if(empty($data_all[$peg['nomor_spt']])){
        $data_all[$peg['nomor_spt']] = array();
    }
    $data_all[$peg['nomor_spt']][] = $peg;
}
// print_r($sbu_lembur);die($wpdb->last_query);


$total_hari_kerja= 0;
$total_jam_kerja= 0;
$total_lembur_hari_kerja= 0;
$total_hari_libur= 0;
$total_jam_libur= 0;
$total_lembur_hari_libur= 0;
$total_uang_makan= 0;
$total_penerimaan_kotor= 0;
$total_pajak_lembur= 0;
$total_penerimaan_bersih= 0;
$nomor = 0;
$body = '';
foreach($data_all as $peg_all){
    $nomor++;
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
        if(
            !empty($peg['tipe_hari'][1])
            && !empty($peg['tipe_hari'][1])
            && !empty($peg['tipe_hari'][1][$peg['kode_gol']])
        ){
            $peg_jam_kerja = $peg['tipe_hari'][1][$peg['kode_gol']][$peg['jml_jam']];
        }
        // dikasih kondisi jika jam lembur dapat uang makan
        if(!empty($peg['id_standar_harga_makan'])){
            $total_uang_makan_lembur += $uang_makan_lembur;
        }

        // if($peg['tipe_hari'] == 1){
        //     $total_uang_lembur_hari_kerja += $peg['jml_jam']*$uang_lembur_hari_kerja;
        //     $peg_jam_kerja += $peg['jml_jam'];
        //     $jumlah_hari_kerja += $peg['jml_hari'];
        // }else if($peg['tipe_hari'] == 2){
        //     $total_uang_lembur_hari_libur += $peg['jml_jam']*$uang_lembur_hari_libur;
        //     $peg_jam_libur = $peg['jml_jam'];
        //     $jumlah_hari_libur += $peg['jml_hari'];
        // }
        $total_pajak += $peg['jml_pajak'];
    }
    $penerimaan_kotor = $total_uang_lembur_hari_kerja + $total_uang_lembur_hari_libur + $total_uang_makan_lembur;
    $penerimaan_bersih = $penerimaan_kotor - $total_pajak;
    $body .= '
        <tr>
            <td class="text-center">'.$nomor.'</td>
            <td class="text-center">'.$peg['nomor_spt'].'</td>
            <td class="text-center">'.str_replace('T', ' ', $peg['waktu_mulai']).'</td>
            <td class="text-center">'.str_replace('T', ' ', $peg['waktu_akhir']).'</td>
            <td class="text-center">'.$this->rupiah($jumlah_hari_kerja).'</td>
            <td class="text-center">'.$this->rupiah($peg_jam_kerja).'</td>
            <td class="text-right">'.$this->rupiah($total_uang_lembur_hari_kerja).'</td>
            <td class="text-center">'.$this->rupiah($jumlah_hari_libur).'</td>
            <td class="text-center">'.$this->rupiah($peg_jam_libur).'</td>
            <td class="text-right">'.$this->rupiah($total_uang_lembur_hari_libur).'</td>
            <td class="text-right">'.$this->rupiah($total_uang_makan_lembur).'</td>
            <td class="text-right">'.$this->rupiah($penerimaan_kotor).'</td>
            <td class="text-right">'.$this->rupiah($total_pajak).'</td>
            <td class="text-right">'.$this->rupiah($penerimaan_bersih).'</td>
            <td><a href="'.SIMPEG_PLUGIN_URL.'public/media/simpeg/'.$peg['file_daftar_hadir'].'" target="_blank">File Daftar Hadir</a></td>
            <td><a href="'.SIMPEG_PLUGIN_URL.'public/media/simpeg/'.$peg['foto_lembur'].'" target="_blank">Foto Lembur</a></td>
        </tr>
    ';
    $total_hari_kerja += $jumlah_hari_kerja;
    $total_jam_kerja += $peg_jam_kerja;
    $total_lembur_hari_kerja += $total_uang_lembur_hari_kerja;
    $total_hari_libur += $jumlah_hari_libur;
    $total_jam_libur += $peg_jam_libur;
    $total_lembur_hari_libur += $total_uang_lembur_hari_libur;
    $total_uang_makan += $total_uang_makan_lembur;
    $total_penerimaan_kotor += $penerimaan_kotor;
    $total_pajak_lembur += $total_pajak;
    $total_penerimaan_bersih += $penerimaan_bersih;
}

?>
<div class="text-center" style="margin-top: 30px;">
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
<div class="cetak container-fluid" style="margin-top: 15px;">
    <h1 class="text-center">Detail Pegawai</h1>
    <div class="row">
        <div class="col-md-6">
            <table class="table table-bordered">
                <tbody>
                    <tr>
                        <td style="width: 160px;">Nama</td>
                        <td style="width: 20px;" class="text-center">:</td>
                        <td><?php echo $set_peg['gelar_depan']; ?> <?php echo $set_peg['nama']; ?> <?php echo $set_peg['gelar_belakang']; ?></td>
                    </tr>
                    <tr>
                        <td>NIP</td>
                        <td>:</td>
                        <td><?php echo $set_peg['nip']; ?></td>
                    </tr>
                    <tr>
                        <td>NIK</td>
                        <td>:</td>
                        <td><?php echo $set_peg['nik']; ?></td>
                    </tr>
                    <tr>
                        <td>Tempat, Tanggal Lahir</td>
                        <td>:</td>
                        <td><?php echo $set_peg['tempat_lahir']; ?>, <?php echo $set_peg['tanggal_lahir']; ?> </td>
                    </tr>
                    <tr>
                        <td>Agama</td>
                        <td>:</td>
                        <td><?php echo $set_peg['agama']; ?></td>
                    </tr>
                    <tr>
                        <td>Alamat</td>
                        <td>:</td>
                        <td><?php echo $set_peg['alamat']; ?></td>
                    <tr>
                        <td>Pendidikan Terakhir</td>
                        <td>:</td>
                        <td><?php echo $set_peg['pendidikan']; ?></td>
                    </tr>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="col-md-6">
            <table class="table table-bordered">
                <tbody>
                    <tr>
                        <td style="width: 150px;">Unit Kerja</td>
                        <td style="width: 20px;">:</td>
                        <td><?php echo $set_peg['unit_kerja_induk']; ?></td>
                    </tr>
                    <tr>
                        <td>Kartu Pegawai</td>
                        <td>:</td>
                        <td><?php echo $set_peg['karpeg']; ?></td>
                    </tr>
                    <tr>
                        <td>Jabatan</td>
                        <td>:</td>
                        <td><?php echo $set_peg['jabatan']; ?></td>
                    </tr>
                    <tr>
                        <td>Golongan</td>
                        <td>:</td>
                        <td><?php echo $set_peg['gol_ruang']; ?></td>
                    </tr>
                    <tr>
                        <td>Harga Satuan</td>
                        <td>:</td>
                        <td>Hari Kerja : <?php echo $uang_lembur_hari_kerja_2; ?><br>Hari Libur : <?php echo $uang_lembur_hari_libur_2; ?></td>
                    </tr>
                    <tr>
                        <td>Uang Makan</td>
                        <td>:</td>
                        <td><?php echo $uang_makan_lembur_2; ?></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
    <h2 class="text-center">Laporan Surat Perintah Tugas per Pegawai<br>Tahun <?php echo $input['tahun']; ?></h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th class="atas kanan bawah kiri text-center" style="vertical-align: middle;" rowspan="2">No</th>
                    <th class="atas kanan bawah text-center" style="vertical-align: middle;" rowspan="2">Nomor SPT</th>
                    <th class="atas kanan bawah text-center" style="vertical-align: middle;" colspan="2">Waktu SPT</th>
                    <th class="atas kanan bawah text-center" style="vertical-align: middle;" colspan="3">Hari Kerja</th>
                    <th class="atas kanan bawah text-center" style="vertical-align: middle;" colspan="3">Hari Libur</th>
                    <th class="atas kanan bawah text-center" style="vertical-align: middle;"rowspan="2">Uang Makan</th>
                    <th class="atas kanan bawah text-center" style="vertical-align: middle;"rowspan="2">Penerimaan Kotor</th>
                    <th class="atas kanan bawah text-center" style="vertical-align: middle;"rowspan="2">Pajak</th>
                    <th class="atas kanan bawah text-center" style="vertical-align: middle;"rowspan="2">Penerimaan Bersih</th>
                    <th class="atas kanan bawah text-center" style="vertical-align: middle;" colspan="2" >Lampiran SPJ</th>
                </tr>
                <tr>
                    <th class="kanan bawah text-center">Waktu Mulai</th>
                    <th class="kanan bawah text-center">Waktu Selesai</th>
                    <th class="kanan bawah text-center">Hari</th>
                    <th class="kanan bawah text-center">Jam</th>
                    <th class="kanan bawah text-center">Total</th>
                    <th class="kanan bawah text-center">Hari</th>
                    <th class="kanan bawah text-center">Jam</th>
                    <th class="kanan bawah text-center">Total</th>
                    <th style="width: 160px;" class="kanan bawah text-center">Daftar Hadir</th>
                    <th style="width: 160px;" class="kanan bawah text-center" >Foto Lembur</th>
                </tr>
                <tr style="">
                    <th class="text-center">1</th>
                    <th class="text-center">2</th>
                    <th class="text-center">3</th>
                    <th class="text-center">4</th>
                    <th class="text-center">5</th>
                    <th class="text-center">6</th>
                    <th class="text-center">7</th>
                    <th class="text-center">8</th>
                    <th class="text-center">9</th>
                    <th class="text-center">10</th>
                    <th class="text-center">11</th>
                    <th class="text-center">12=7+10+11</th>
                    <th class="text-center">13</th>
                    <th class="text-center">14=12-13</th>
                    <th class="text-center" style="w">15</th>
                    <th class="text-center">16</th>
                </tr>
                <tfoot>
                    <tr>
                        <th colspan="4">Total</th>
                        <th class="text-center"><?php echo $total_hari_kerja; ?></th>
                        <th class="text-center"><?php echo $total_jam_kerja; ?></th>
                        <th class="text-right"><?php echo number_format($total_lembur_hari_kerja,0,",","."); ?></th>
                        <th class="text-center"><?php echo $total_hari_libur; ?></th>
                        <th class="text-center"><?php echo $total_jam_libur; ?></th>
                        <th class="text-right"><?php echo number_format($total_lembur_hari_libur,0,",","."); ?></th>
                        <th class="text-right"><?php echo number_format($total_uang_makan,0,",","."); ?></th>
                        <th class="text-right"><?php echo number_format($total_penerimaan_kotor,0,",","."); ?></th>
                        <th class="text-right"><?php echo number_format($total_pajak_lembur,0,",","."); ?></th>
                        <th class="text-right"><?php echo number_format($total_penerimaan_bersih,0,",","."); ?></th>
                        <th class="text-right" colspan="2"></th>
                    </tr>
                </tfoot>
            </thead>
            <tbody>
                <?php echo $body; ?>
            </tbody>
        </table>
    </div>
</div>
<script type="text/javascript">
jQuery(document).ready(function(){
    // penyesuaian thema wp full width page
    jQuery('.mg-card-box').parent().removeClass('col-md-8').addClass('col-md-12');
    jQuery('#secondary').parent().remove();
    
    jQuery('#pegawai').select2();
});
function submit(){
        var tahun = jQuery('#tahun').val();
        var pegawai = jQuery('#pegawai').val();
        if(tahun == ''){
            return alert('Tahun tidak boleh kosong!');
        }else if(pegawai == ''){
            return alert('pegawai tidak boleh kosong!');
        }
        var url = window.location.href;
        url = url.split('?')[0]+'?tahun='+tahun+'&id='+pegawai;
        location.href = url;
    }
</script>