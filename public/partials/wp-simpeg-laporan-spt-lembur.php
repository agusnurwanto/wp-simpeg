<?php 
// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
    die;
}
global $wpdb;
$input = shortcode_atts( array(
    'id_spt' => ''
), $atts );

if(!empty($_GET) && !empty($_GET['id_spt'])){
    $input['id_spt'] = $wpdb->prepare('%d',$_GET['id_spt']);
}else{
    die('<h1 class="text-center">id spt tidak boleh kosong</h1>');
}

$spt = $wpdb->get_row($wpdb->prepare('
    SELECT 
        * 
    FROM data_spt_lembur
    WHERE id=%d
',$input['id_spt']), ARRAY_A);

if(empty($spt)){
    die('<h1 class="text-center">Data SPT tidak ditemukan</h1>');
}

$spj = $wpdb->get_row($wpdb->prepare('
    SELECT 
        * 
    FROM data_spj_lembur
    WHERE id_spt=%d
',$input['id_spt']), ARRAY_A);

if($spt['waktu_mulai_spt'] == $spt['waktu_selesai_spt']){
    if(empty($spt['waktu_mulai_spt'])){
        $waktu_spt = '-';    
    }else{
        $waktu_spt = $this->tanggalan($spt['waktu_mulai_spt']);
    }
}else{
    $waktu_spt = $this->tanggalan($spt['waktu_mulai_spt']).' sampai '.$this->tanggalan($spt['waktu_selesai_spt']);
}

if($spt['status'] == 0) {
    $spt['status'] = '<span class="btn-primary btn-sm">Menunggu Submit</span>';
}elseif($spt['status'] == 1) {
    $spt['status'] = '<span class="btn-success btn-sm">Diverifikasi Kasubag Keuangan</span>';
}elseif($spt['status'] == 2) {
    $spt['status'] = '<span class="btn-success btn-sm">Diverifikasi PPK</span>';
}elseif($spt['status'] == 3) {
    $spt['status'] = '<span class="btn-success btn-sm">Diverifikasi Kepala</span>';
}elseif($spt['status'] == 4) {
    $spt['status'] = '<span class="btn-danger btn-sm">SPJ Ditolak</span>';
}elseif($spt['status'] == 5) {
    $spt['status'] = '<span class="btn-success btn-sm">SPJ Diverifikasi Kasubag Keuangan</span>';
}elseif($spt['status'] == 6) {
    $spt['status'] = '<span class="btn-primary btn-sm">Selesai</span>';
}else
    $spt['status'] = '<span class="btn-danger btn-sm">Not Found</span>';

$laporan_spt = $wpdb->get_results($wpdb->prepare('
    SELECT 
        d.*,
        p.*
        -- p.gelar_depan,
        -- p.nama,
        -- p.gelar_belakang,
        -- p.kode_gol,
        -- p.nip,
        -- p.jabatan,
        -- p.gol_ruang
    from data_spt_lembur_detail d
    INNER JOIN data_spt_lembur s on d.id_spt = s.id
        AND s.active=d.active
    INNER JOIN data_pegawai_lembur p on d.id_pegawai = p.id
        AND p.active=d.active
        AND p.tahun=s.tahun_anggaran
    WHERE s.id=%d
    order by p.nama ASC
', $input['id_spt']), ARRAY_A);
$nomor = 0;
$body = '';
$body2 = '';
foreach($laporan_spt as $peg){
    $nomor++;
    $nama_pegawai = $peg['gelar_depan'].' '.$peg['nama'].' '.$peg['gelar_belakang'];
    $nip_pegawai = $peg['nip'];
    $golongan_pegawai = $peg['gol_ruang'];
    $body .= '
        <tr>
            <td class="text-center">'.$nomor.'</td>
            <td>'.$nama_pegawai.'</td>
            <td class="text-center">'.$nip_pegawai.'</td>
            <td class="text-center">'.$golongan_pegawai.'</td>
            <td>'.$peg['jabatan'].'</td>
            <td class="text-center">'.str_replace('T', ' ', $peg['waktu_mulai']).'</td>
            <td class="text-center">'.str_replace('T', ' ', $peg['waktu_akhir']).'</td>
            <td class="text-center">'.$peg['jml_jam'].' Jam</td>
        </tr>
    ';
}
?>
<div class="cetak" style="background-color: #ffff;">
    <div class="text-center" style="padding: 10px;">
        <div class="col-md-12">
            <h4>Status SPT Nomor : <?php echo $spt['nomor_spt']; ?><br><?php echo $spt['status']; ?></h4>      
    </div>
        </div> 
    <div class="cetak">
        <div style="padding: 10px;">
            <div class="laporan-surat break-print" id="content" contenteditable="true">
                <div class="no-surat text-center">
                    <div class="col-md-12">
                        <h5>SURAT PERINTAH TUGAS<br>Nomor : <?php echo $spt['nomor_spt']; ?></h5>
                    </div>
                </div>
                <div class="body-surat row">
                    <div class="col-md-12">
                        <table class="table table-borderless" style="width: 900px; margin: auto; border: 0;">
                            <tbody>
                                <tr>
                                    <td style="width: 100px;">DASAR</td>
                                    <td style="width: 30px;" class="text-center">:</td>
                                    <td><?php echo $spt['dasar_lembur']; ?></td>
                                </tr>
                                <tr>
                                    <td colspan="3" class="text-center">MEMERINTAHKAN</td>
                                </tr>
                                <tr>
                                    <td>KEPADA</td>
                                    <td class="text-center">:</td>
                                    <td>Nama-nama yang tertera dalam lampiran ini.</td>
                                </tr>
                                <tr>
                                    <td>UNTUK</td>
                                    <td class="text-center">:</td>
                                    <td>Melaksanakan <?php echo $spt['ket_lembur']; ?> pada tanggal <?php echo $waktu_spt; ?>.</td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td>Demikian Surat Perintah Tugas ini dibuat untuk digunakan sebagaimana mestinya.</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="cetak container-fluid" style="margin: 20px 0; overflow: auto;">
        <h5 class="text-center">Lampiran Surat Perintah Tugas<br>Nomor : <?php echo $spt['nomor_spt']; ?></h5>
        <table class="table table-bordered" style="width: 1200px; margin: auto;" >
            <thead>
                <tr>
                    <td class="text-center text_blok" style="vertical-align: middle; width: 40px;" rowspan="2">No</td>
                    <td class="text-center text_blok" style="vertical-align: middle; width: 340px;" rowspan="2">Nama</td>
                    <td class="text-center text_blok" style="vertical-align: middle; width: 300px;" rowspan="2">NIP</td>
                    <td class="text-center text_blok" style="vertical-align: middle; width: 100px;" rowspan="2">Pangkat/ Gol. Ruang</td>
                    <td class="text-center text_blok" style="vertical-align: middle;" rowspan="2">Jabatan</td>
                    <td class="text-center text_blok" style="vertical-align: middle;" colspan="3">Pelaksanaan</td>
                </tr>
                <tr>
                    <td class="kanan bawah text-center text_blok" rowspan="2" style="width: 140px;">Mulai</td>
                    <td class="kanan bawah text-center text_blok" rowspan="2" style="width: 140px;">Selesai</td>
                    <td class="kanan bawah text-center text_blok" rowspan="2" style="width: 140px;">Jumlah</td>
                </tr>
            </thead>
            <tbody>
                <?php echo $body; ?>
            </tbody>
        </table>      
    </div>
    <div class="cetak">
        <div class="text-center" style="padding: 10px;">
            <div class="col-md-12">
                <h5>Lampiran Surat Pertanggungjawaban<br>Nomor : <?php echo $spt['nomor_spt']; ?></h5>
                    <table class="table table-borderless" style="width: 900px; margin: auto; border: 0;">
                <tbody>
                <?php if(!empty($spj)): ?>
                    <tr>
                        <th class="text-center">Foto daftar hadir</th>
                    </tr>
                    <tr>
                        <td><img src="<?php echo SIMPEG_PLUGIN_URL.'public/media/simpeg/'.$spj['file_daftar_hadir'] ?>"></td>
                    </tr>
                    <tr>
                        <th class="text-center">Foto lembur</th>
                    </tr>
                    <tr>
                        <td><img src="<?php echo SIMPEG_PLUGIN_URL.'public/media/simpeg/'.$spj['foto_lembur'] ?>"></td>
                    </tr>
                <?php endif; ?>
                </tbody>
            </table>
            </div>
        </div> 
    </div> 
</div> 
<script type="text/javascript">
jQuery(document).ready(function(){
    // penyesuaian thema wp full width page
    jQuery('.mg-card-box').parent().removeClass('col-md-8').addClass('col-md-12');
    jQuery('#secondary').parent().remove();
    
})
</script>