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
?>
<h1 class="text-center">Laporan Lembur<br>Bulan <?php echo $namaBulan[$input['bulan']]; ?> Tahun <?php echo $input['tahun']; ?></h1>
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
<button style="margin-left: 20px; height: 45px; width: 75px;"onclick="sumbitBulanTahun();" class="btn btn-sm btn-primary">Cari</button>
<div class="cetak container-fluid"><br>
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
                <th></th>
            </tr>
        </tbody>
    </table>      
</div>