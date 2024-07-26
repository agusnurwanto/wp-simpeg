<?php
global $wpdb;

$input = shortcode_atts(array(
    'tahun_anggaran' => '2022',
    'id_skpd' => '',
    'id' => ''
), $atts);

$skpd = $wpdb->get_row(
    $wpdb->prepare("
    SELECT 
        nama_skpd
    FROM data_unit_lembur
    WHERE id_skpd=%d
      AND tahun_anggaran=%d
      AND active = 1
", $input['id_skpd'], $input['tahun_anggaran']),
    ARRAY_A
);

$idtahun = $wpdb->get_results("select distinct tahun_anggaran from data_unit_lembur", ARRAY_A);
$tahun = "<option value='-1'>Pilih Tahun</option>";
foreach($idtahun as $val){
    $tahun .= "<option value='$val[tahun_anggaran]'>$val[tahun_anggaran]</option>";
}

$user_id = um_user( 'ID' );
$user_meta = get_userdata($user_id);
$disabled = 'disabled';
?>
<style type="text/css">
    .wrap-table{
        overflow: auto;
        max-height: 100vh; 
        width: 100%; 
}
</style>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
<div class="cetak">
    <div style="padding: 10px;margin:0 0 3rem 0;">
        <input type="hidden" value="<?php echo get_option( SIMPEG_APIKEY ); ?>" id="api_key">
        <h2 class="text-center" style="margin:3rem;">Input Data Absensi Pegawai<br> Tahun <?php echo $input['tahun_anggaran']; ?><br><?php echo $skpd['nama_skpd']; ?></h2>
            <div style="margin-bottom: 25px;">
                <button class="btn btn-primary" onclick="tambah_data_absensi_lembur();"><i class="dashicons dashicons-plus"></i> Tambah Data</button>
            </div>
        </div>
        <div class="wrap-table">
            <table id="management_data_table" cellpadding="2" cellspacing="0" style="font-family:\'Open Sans\',-apple-system,BlinkMacSystemFont,\'Segoe UI\',sans-serif; border-collapse: collapse; width:100%; overflow-wrap: break-word;" class="table table-bordered">
                <thead>
                    <tr>
                        <th class="text-center">Nama Pegawai</th>
                        <th class="text-center">Waktu Mulai</th>
                        <th class="text-center">Waktu Selesai</th>
                        <th class="text-center">Jumlah Jam</th>
                        <th class="text-center">Total Nilai</th>
                        <th class="text-center">Keterangan Lembur</th>
                        <th class="text-center" style="width: 250px;">Foto Kegiatan</th>
                        <th class="text-center">Status</th>
                        <th class="text-center" style="width: 35px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>          
</div>

<div class="modal fade mt-4" id="modalTambahDataAbsensiLembur" role="dialog" aria-hidden="true">
    <div class="modal-dialog" style="min-width: 90vw;" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTambahDataAbsensiLemburLabel">Tambah Data Absensi</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="form-absensi">
                    <input type='hidden' id='id_data' name="id_data"/>
                    <div class="form-group">
                        <label>Pilih Tahun Anggaran</label>
                        <select class="form-control" id="tahun_anggaran" name="tahun_anggaran" onchange="get_skpd();">
                        <?php echo $tahun; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="nama_skpd">Nama SKPD</label>
                        <input type="text" class="form-control" id="nama_skpd" name="nama_skpd"  style="text-transform: uppercase;" value="<?php echo $skpd['nama_skpd']; ?>" disabled>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" id="id_skpd" name="id_skpd" onchange="get_pegawai_absensi();">
                    </div>
                    <div class="form-group">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th class="text-center" style="width: 35%;">Tanggal Mulai</th>
                                    <th class="text-center" style="width: 35%;">Tanggal Selesai</th>
                                    <th class="text-center">Jumlah</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="waktu_spt">
                                    <td><input type="date" class="text-center form-control time-start" name="waktu_mulai_spt" id="waktu_mulai_spt" onchange="cek_time(this);" /></td>
                                    <td><input type="date" class="text-center form-control time-end" name="waktu_selesai_spt" id="waktu_selesai_spt" onchange="cek_time(this);" /></td>
                                    <th class="text-center" id="jml_hari_spt"></th>
                                </tr>
                            </tbody>
                        </table>
                        <input type="hidden" name="jml_hari" id="jml_hari"/>
                    </div>
                    <table class="table table-bordered" id="daftar_pegawai">
                        <thead>
                            <tr>
                                <th class="text-center" style="width: 32px;">No</th>
                                <th class="text-center" style="width: 320px;">Nama Pegawai</th>
                                <th class="text-center" style="width: 220px;">Waktu</th>
                                <th class="text-center" style="width: 220px;">Total</th>
                                <th class="text-center">Keterangan</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                    <div class="form-group" style="display: none;">
                        <label for="">Foto Kegiatan</label>
                        <input type="file" name="file" class="form-control-file" id="lampiran" accept="application/pdf, .png, .jpg, .jpeg">
                        <div style="padding-top: 10px; padding-bottom: 10px;"><a id="file_lampiran_existing"></a></div>
                        <div><small>Upload file maksimal 5 Mb, berformat .pdf .png .jpg .jpeg</small></div>
                    </div>
                    <div class="form-group" style="display: none;">
                        <label>Keterangan</label>
                        <textarea class="form-control" id="ket_lembur" name="ket_lembur"></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="submit" onclick="submitTambahDataFormAbsensiLembur();" class="btn btn-primary send_data">Simpan</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal" aria-label="Close">Tutup</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade mt-4" id="modalVerifikasiAdmin" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Verifikasi oleh Admin</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form>
                    <input type='hidden' name="id_data"/>
                    <input type='hidden' name='tipe_verifikasi' value="admin"/>
                    <div class="form-group">
                        <label class="form-check-label"><input value="1" type="checkbox" id="status_admin" name="status_admin"> Disetujui (Anggaran Tersedia)</label>
                    </div>
                    <div class="form-group keterangan_ditolak">
                        <label>Keterangan</label>
                        <textarea class="form-control" id="keterangan_status_admin" name="keterangan_status_admin"></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="submit" onclick="submitVerifikasiLembur(this);" class="btn btn-primary send_data">Simpan</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal" aria-label="Close">Tutup</button>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript" src="<?php echo SIMPEG_PLUGIN_URL; ?>admin/js/jszip.js"></script>
<script type="text/javascript" src="<?php echo SIMPEG_PLUGIN_URL; ?>admin/js/xlsx.js"></script>
<script>    
jQuery(document).ready(function(){
    // penyesuaian thema wp full width page
    jQuery('.mg-card-box').parent().removeClass('col-md-8').addClass('col-md-12');
    jQuery('#secondary').parent().remove();
    
    get_data_absensi_lembur();
    window.global_file_upload = "<?php echo SIMPEG_PLUGIN_URL . 'public/media/simpeg/'; ?>";
});

function submitVerifikasiLembur(that){
    if(!jQuery('#status_admin').is(':checked')){
        var ket = jQuery('#keterangan_status_admin').val();
        if(ket == ''){
            return alert('Keterangan harus diisi jika status ditolak');
        }
    }
    if(confirm('Apakah anda yakin untuk memverifikasi data ini?')){
        jQuery("#wrap-loading").show();
        var form = getFormData(jQuery(that).closest('.modal').find('.modal-body form'));
        jQuery.ajax({
            method:'post',
            url:'<?php echo admin_url('admin-ajax.php'); ?>',
            dataType: 'json',
            data: {
                'action': 'verifikasi_absensi_lembur',
                'api_key': jQuery('#api_key').val(),
                'data': JSON.stringify(form)
            },
            success:function(response){
                jQuery('#wrap-loading').hide();
                alert(response.message);
                if(response.status == 'success'){
                    jQuery('#modalVerifikasiAdmin').modal('hide');
                    get_data_absensi_lembur();
                }
            }
        });
    }
}

function submit_data(id){
    if(confirm('Apakah anda yakin untuk mengirim data ini ke proses selanjutnya?')){
        jQuery('#wrap-loading').show();
        jQuery.ajax({
            method: 'post',
            url: '<?php echo admin_url('admin-ajax.php'); ?>',
            dataType: 'json',
            data:{
                'action': 'verifikasi_absensi_lembur',
                'api_key': jQuery('#api_key').val(),
                'data': JSON.stringify({
                    id_data: id,
                    tipe_verifikasi: 'pegawai'
                })
            },
            success: function(res){
                jQuery('#wrap-loading').hide();
                alert(res.message);
                if(res.status == 'success'){
                    get_data_absensi_lembur();
                }
            }
        });
    }
}

function set_keterangan(that){
    if(jQuery(that).is(':checked')){
        jQuery(that).closest('form').find('.keterangan_ditolak').show();
    }else{
        jQuery(that).closest('form').find('.keterangan_ditolak').hide();
    }
}

function verifikasi_admin(id){
    jQuery('#wrap-loading').show();
    jQuery.ajax({
        method: 'post',
        url: '<?php echo admin_url('admin-ajax.php'); ?>',
        dataType: 'json',
        data:{
            'action': 'get_data_absensi_lembur_by_id',
            'api_key': '<?php echo get_option( SIMPEG_APIKEY ); ?>',
            'id': id,
        },
        success: function(res){
            if(res.status == 'success'){
                jQuery('#modalVerifikasiAdmin input[name="id_data"]').val(res.data.id);
                if(res.data.status_ver_admin == 1){
                    jQuery('#status_admin').prop('checked', true);
                }else{
                    jQuery('#status_admin').prop('checked', false);
                }
                jQuery('#modalVerifikasiAdmin #keterangan_status_admin').val(res.data.ket_ver_admin);
                jQuery('#modalVerifikasiAdmin').modal('show');
            }else{
                alert(res.message);
            }
            jQuery('#wrap-loading').hide();
        }
    });
}

function get_skpd(no_loading=false) {
    return new Promise(function(resolve, reject){
        var tahun = jQuery('#tahun_anggaran').val();
        if(tahun == '-1'){
            jQuery('#id_skpd').html('').trigger('change');
            alert('Tahun anggaran tidak boleh kosong!');
            return resolve();
        }
        
        if(!no_loading){
            jQuery("#wrap-loading").show();
        }

        var today = new Date();
        today = today.toJSON().split('T')[0].split('-');
        jQuery('#waktu_mulai_spt').val(tahun+'-'+today[1]+'-'+today[2]).trigger('change');
        jQuery('#waktu_selesai_spt').val(tahun+'-'+today[1]+'-'+today[2]).trigger('change');

        jQuery('#waktu_mulai_spt').attr('min', tahun+'-01-01');
        jQuery('#waktu_mulai_spt').attr('max', tahun+'-12-31');
        jQuery('#waktu_selesai_spt').attr('min', tahun+'-01-01');
        jQuery('#waktu_selesai_spt').attr('max', tahun+'-12-31');
        if(typeof global_response_skpd == 'undefined'){
            global_response_skpd = {};
        }
        if(!global_response_skpd[tahun]){
            jQuery.ajax({
                url: '<?php echo admin_url('admin-ajax.php'); ?>',
                type:'post',
                data:{
                    'action' : 'get_skpd_simpeg',
                    'api_key': '<?php echo get_option( SIMPEG_APIKEY ); ?>',
                    'tahun_anggaran': tahun
                },
                dataType: 'json',
                success:function(response){
                    if(!no_loading){
                        jQuery("#wrap-loading").hide();
                    }
                    if(response.status == 'success'){
                        global_response_skpd[tahun] = response;
                        jQuery('#id_skpd').html(global_response_skpd[tahun].html).trigger('change');
                        return resolve();
                    }else{
                        alert(`GAGAL! \n${response.message}`);
                    }
                }
            });
        }else{
            jQuery('#id_skpd').html(global_response_skpd[tahun].html).trigger('change');
            return resolve();
        }
    });
}

function cek_time(that){
    var is_start = jQuery(that).hasClass('time-start');
    var tr = jQuery(that).closest('tr');
    var start_asli = tr.find('.time-start').val();
    var start = new Date(start_asli);
    var end_asli = tr.find('.time-end').val();
    var end = new Date(end_asli);
    var diffTime = end - start;
    if(isNaN(diffTime)){
        return;
    }
    console.log('diffTime', diffTime, is_start, start_asli, end_asli);
    if(diffTime < 0){
        if(is_start){
            end_asli = start_asli;
            tr.find('.time-end').val(start_asli).trigger('change');
        }else{
            start_asli = end_asli;
            tr.find('.time-start').val(end_asli).trigger('change');
        }
    }

    if(tr.hasClass('waktu_spt')){
        start = new Date(start_asli);
        end = new Date(end_asli);
        diffTime = end - start;
        var jml_hari = Math.ceil(diffTime / (1000 * 60 * 60 * 24)) + 1;
        jQuery('#jml_hari_spt').html(jml_hari+' Hari');
        jQuery('#jml_hari').val(jml_hari);

        jQuery('#daftar_pegawai .time-start').attr('min', start_asli+'T00:00');
        jQuery('#daftar_pegawai .time-start').attr('max', end_asli+'T23:59');

        jQuery('#daftar_pegawai .time-end').attr('min', start_asli+'T00:00');
        jQuery('#daftar_pegawai .time-end').attr('max', end_asli+'T23:59');

        jQuery('#daftar_pegawai .time-start').map(function(i, b){
            var tr_peg = jQuery(b).closest('tr');
            var start_peg_asli = tr_peg.find('.time-start').val();
            var end_peg_asli = tr_peg.find('.time-end').val();
            if(start_peg_asli == ''){
                start_peg_asli = '0000-01-01T16:00';
            }
            var start_peg = new Date(start_peg_asli);

            if(end_peg_asli == ''){
                end_peg_asli = '0000-01-01T23:00';
            }
            var end_peg = new Date(end_peg_asli);

            console.log('start_peg_asli, end_peg_asli, start_asli, end_asli', start_peg_asli, end_peg_asli, start_asli, end_asli);

            // jika start pegawai lebih dulu dari start Absensi
            if(start_peg < start){
                var new_val = start_asli+'T'+start_peg_asli.split('T')[1];
                tr_peg.find('.time-start').val(new_val).trigger('change');
                console.log('start_peg < start new_val start_peg', new_val);
            }else if(start_peg > end){
                var new_val = end_asli+'T'+start_peg_asli.split('T')[1];
                tr_peg.find('.time-start').val(new_val).trigger('change');
                console.log('start_peg > end new_val start_peg', new_val);
            }

            // jika end pegawai lebih lama dari end Absensi
            if(end_peg > end){
                var new_val = end_asli+'T'+end_peg_asli.split('T')[1];
                tr_peg.find('.time-end').val(new_val).trigger('change');
                console.log('end_peg > end new_val end_peg', new_val);
            }else if(end_peg < start){
                var new_val = start_asli+'T'+end_peg_asli.split('T')[1];
                tr_peg.find('.time-end').val(new_val).trigger('change');
                console.log('end_peg < start new_val end_peg', new_val);
            }
        });
    }
}

function html_pegawai(opsi){
    var start_asli = jQuery('#waktu_mulai_spt').val()+'T00:00';
    var end_asli = jQuery('#waktu_selesai_spt').val()+'T23:59';
    var html = ''+
        '<tr data-id="'+opsi.id+'">'+
            '<td class="text-center">'+opsi.id+'</td>'+
            '<td class="text-center">'+
                '<select class="form-control" name="id_pegawai['+opsi.id+']" id="id_pegawai_'+opsi.id+'" onchange="get_uang_lembur(this);">'+opsi.html+'</select>'+
                '<input type="hidden" name="id_spt_detail['+opsi.id+']" id="id_spt_detail_'+opsi.id+'"/>'+
                '<br>'+
                '<br>'+
                '<label style="display: block;">Jenis Hari'+
                    '<br>'+
                    '<select class="form-control" name="jenis_hari['+opsi.id+']" id="jenis_hari_'+opsi.id+'" onchange="get_uang_lembur(this);">'+
                        '<option value="2">Hari Kerja</option>'+
                        '<option value="1">Hari Libur</option>'+
                    '</select>'+
                '</label>'+
            '</td>'+
            '<td class="text-center">'+
                '<label>Waktu Mulai<br><input type="datetime-local" class="form-control time-start" name="waktu_mulai['+opsi.id+']" id="waktu_mulai_'+opsi.id+'" onchange="cek_time(this); get_uang_lembur(this);" min="'+start_asli+'" max="'+end_asli+'" value="'+start_asli+'"/></label>'+
                '<label>Waktu Selesai<br><input type="datetime-local" class="form-control time-end" name="waktu_selesai['+opsi.id+']" id="waktu_selesai_'+opsi.id+'" onchange="cek_time(this); get_uang_lembur(this);" min="'+start_asli+'" max="'+end_asli+'" value="'+start_asli+'"/></label>'+
                '<table class="table table-bordered" style="margin: 0;">'+
                    '<tbody>'+
                        '<tr>'+
                            '<td style="width: 115px;">Jumlah jam</td>'+
                            '<td id="jumlah_jam_'+opsi.id+'" class="text-center">0 jam</td>'+
                        '</tr>'+
                    '</tbody>'+
                '</table>'+
            '</td>'+
            '<td class="text-center">'+
                '<label>Uang Lembur<br><input type="text" disabled class="form-control text-right" name="uang_lembur['+opsi.id+']" id="uang_lembur_'+opsi.id+'"/></label>'+
                '<label><input type="checkbox" value="1" name="uang_makan_set['+opsi.id+']" id="uang_makan_set_'+opsi.id+'" onchange="get_uang_lembur(this);" checked> Uang Makan</label><br>'
                +'<input type="text" disabled class="form-control text-right" name="uang_makan['+opsi.id+']" id="uang_makan_'+opsi.id+'"/>'+
                '<table class="table table-bordered" style="margin: 0;">'+
                    '<tbody>'+
                        '<tr>'+
                            '<td style="width: 115px;">Pajak</td>'+
                            '<td id="pajak_'+opsi.id+'" class="text-center">0</td>'+
                        '</tr>'+
                    '</tbody>'+
                '</table>'+
                '<input type="hidden" name="jml_pajak['+opsi.id+']" id="jml_pajak_'+opsi.id+'"/>'+
                '<input type="hidden" name="jml_jam_lembur['+opsi.id+']" id="jml_jam_lembur_'+opsi.id+'"/>'+
                '<input type="hidden" name="jml_hari_lembur['+opsi.id+']" id="jml_hari_lembur_'+opsi.id+'"/>'+
                '<input type="hidden" name="id_standar_harga_lembur['+opsi.id+']" id="id_standar_harga_lembur_'+opsi.id+'"/>'+
                '<input type="hidden" name="id_standar_harga_makan['+opsi.id+']" id="id_standar_harga_makan_'+opsi.id+'"/>'+
            '</td>'+
            '<td class="text-center">'+
                // '<textarea class="form-control" name="keterangan['+opsi.id+']" id="keterangan_'+opsi.id+'"></textarea>'+
                '<table class="table table-bordered" style="margin: 0;">'+
                    '<tbody>'+
                        '<tr>'+
                            '<td style="width: 115px;">SBU uang lembur</td>'+
                            '<td id="sbu_lembur_'+opsi.id+'" class="text-center">-</td>'+
                        '</tr>'+
                        '<tr>'+
                            '<td>SBU uang makan</td>'+
                            '<td id="sbu_makan_'+opsi.id+'" class="text-center">-</td>'+
                        '</tr>'+
                    '</tbody>'+
                '</table>'+
            '</td>'+
        '</tr>';
    return html;
}

function get_pegawai_absensi(no_loading=false) {
    return new Promise(function(resolve, reject){
        var id_skpd = jQuery('#id_skpd').val();
        if(id_skpd == ''){
            jQuery('#daftar_pegawai tbody').html('');
            return;
        }
        if(!no_loading){
            jQuery("#wrap-loading").show();
        }
        if(typeof global_response_pegawai == 'undefined'){
            global_response_pegawai = {};
        }
        if(!global_response_pegawai[id_skpd]){
            jQuery.ajax({
                url: '<?php echo admin_url('admin-ajax.php'); ?>',
                type:'post',
                data:{
                    'action' : 'get_pegawai_absensi_simpeg',
                    'api_key': '<?php echo get_option( SIMPEG_APIKEY ); ?>',
                    'id_skpd': id_skpd,
                    id: "<?php echo $input['id']; ?>",
                    'tahun_anggaran': jQuery('#tahun_anggaran').val()
                },
                dataType: 'json',
                success:function(response){
                    if(!no_loading){
                        jQuery("#wrap-loading").hide();
                    }
                    if(response.status == 'success'){
                        window.global_response_pegawai[id_skpd] = response;
                        var html = html_pegawai({
                            id: 1, 
                            html: global_response_pegawai[id_skpd].html
                        });
                        jQuery('#daftar_pegawai tbody').html(html);
                        jQuery('#id_pegawai_1').html(global_response_pegawai[id_skpd].html);
                        jQuery('#id_pegawai_1').select2({'width': '100%'});
                        return resolve();
                    }else{
                        alert(`GAGAL! \n${response.message}`);
                    }
                }
            });
        }else{
            var html = html_pegawai({
                id: 1, 
                html: global_response_pegawai[id_skpd].html
            });
            jQuery('#daftar_pegawai tbody').html(html);
            jQuery('#id_pegawai_1').html(global_response_pegawai[id_skpd].html);
            jQuery('#id_pegawai_1').select2({'width': '100%'});
            return resolve();
        }
    });
}

function escapeRegExp(string) {
    return string.replace(/[.*+?^${}()|[\]\\]/g, '\\$&'); // $& means the whole matched string
}

function set_keterangan(that){
    var id = jQuery(that).attr('id');
    if(jQuery(that).is(':checked')){
        jQuery('#keterangan_'+id).closest('.form-group').hide();
    }else{
        jQuery('#keterangan_'+id).closest('.form-group').show();
    }
}

function get_data_absensi_lembur() {
    if (typeof data_absensi_lembur == 'undefined') {
        window.data_absensi_lembur = jQuery('#management_data_table').on('preXhr.dt', function(e, settings, data) {
            jQuery("#wrap-loading").show();
        }).DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": {
                url: '<?php echo admin_url('admin-ajax.php'); ?>',
                type: 'post',
                dataType: 'json',
                data: {
                'action': 'get_datatable_data_absensi_lembur',
                'api_key': '<?php echo get_option( SIMPEG_APIKEY ); ?>',
                'id': '<?php echo $input['id']; ?>',
                }
            },
            lengthMenu: [
                [10, 25, 50, 100, -1],
                [10, 25, 50, 100, "All"]
            ],
            order: [
                [0, 'asc']
            ],
            "drawCallback": function(settings) {
                jQuery("#wrap-loading").hide();
            },
            "columns": [
                {
                    "data": 'nama_lengkap',
                    className: "text-center"
                },
                {
                    "data": 'waktu_mulai',
                    className: "text-center"
                },
                {
                    "data": 'waktu_akhir',
                    className: "text-center"
                },
                {
                    "data": 'jml_jam',
                    className: "text-center"
                },
                {
                    "data": 'total_nilai',
                    className: "text-center"
                },
                {
                    "data": 'ket_lembur',
                    className: "text-center"
                },
                {
                    "data": 'file_lampiran',
                    className: "text-center"
                },
                {
                    "data": 'status',
                    className: "text-center"
                },

                {
                    "data": 'aksi',
                    className: "text-center"
                }
            ]
        });
    } else {
        data_absensi_lembur.draw();
    }
}

function hapus_data(id){
    let confirmDelete = confirm("Apakah anda yakin akan menghapus data ini?");
    if(confirmDelete){
        jQuery('#wrap-loading').show();
        jQuery.ajax({
            url: '<?php echo admin_url('admin-ajax.php'); ?>',
            type:'post',
            data:{
                'action' : 'hapus_data_absensi_lembur_by_id',
                'api_key': '<?php echo get_option( SIMPEG_APIKEY ); ?>',
                'id'     : id
            },
            dataType: 'json',
            success:function(response){
                jQuery('#wrap-loading').hide();
                if(response.status == 'success'){
                    get_data_absensi_lembur(); 
                }else{
                    alert(`GAGAL! \n${response.message}`);
                }
            }
        });
    }
}

function detail_data(_id){
    jQuery('#wrap-loading').show();
    jQuery.ajax({
        method: 'post',
        url: '<?php echo admin_url('admin-ajax.php'); ?>',
        dataType: 'json',
        data:{
            'action': 'get_data_absensi_lembur_by_id',
            'api_key': '<?php echo get_option( SIMPEG_APIKEY ); ?>',
            'id': _id,
        },
        success: function(res){
            if(res.status == 'success'){
                jQuery('#id_data').val(res.data.id).prop('disabled', false);
                jQuery('#tahun_anggaran').val(res.data.tahun_anggaran).prop('disabled', true);
                jQuery('#ket_lembur').val(res.data.ket_lembur).prop('disabled', true);
                jQuery('#dasar_lembur').val(res.data.dasar_lembur).prop('disabled', true);

                get_sbu(true)
                .then(function(){
                    get_skpd(true)
                    .then(function(){
                        jQuery('#id_skpd').val(res.data.id_skpd).trigger('change').prop('disabled', true).hide();
                        jQuery('#waktu_mulai_spt').val(res.data.waktu_mulai_spt).trigger('change').prop('disabled', true);
                        jQuery('#waktu_selesai_spt').val(res.data.waktu_selesai_spt).trigger('change').prop('disabled', true);
                        get_pegawai_absensi(true)
                        .then(function(){
                            res.data_detail.map(function(b, i){
                                if(i >= 1){
                                    jQuery('tr[data-id="1"] .tambah-pegawai').click();
                                }
                            });
                            setTimeout(function(){
                                res.data_detail.map(function(b, i){
                                    var id = i+1;
                                    jQuery('#id_pegawai_'+id).val(b.id_pegawai).trigger('change').prop('disabled', true);
                                    jQuery('#id_spt_detail_'+id).val(b.id).prop('disabled', true);
                                    jQuery('#jenis_hari_'+id).val(b.tipe_hari).trigger('change').prop('disabled', true);
                                    jQuery('#waktu_mulai_'+id).val(b.waktu_mulai).trigger('change').prop('disabled', true);
                                    jQuery('#waktu_selesai_'+id).val(b.waktu_akhir).trigger('change').prop('disabled', true);
                                    jQuery('#keterangan_'+id).val(b.keterangan).prop('disabled', true);
                                    if(b.id_standar_harga_makan == '0'){
                                        jQuery('#uang_makan_set_'+id).prop('checked', false).prop('disabled', true);
                                    }else{
                                        jQuery('#uang_makan_set_'+id).prop('checked', true).prop('disabled', true);
                                    }
                                });
                                jQuery('#lampiran').val('').hide();
                                jQuery('#file_lampiran_existing').attr('href', global_file_upload + res.data.file_lampiran).html(res.data.file_lampiran).show().prop('disabled', true);
                                jQuery('.aksi-pegawai .btn').hide();
                                jQuery('#modalTambahDataAbsensiLembur .send_data').hide();
                                jQuery('#modalTambahDataAbsensiLembur').modal('show');
                                jQuery('#wrap-loading').hide();
                            }, 1000);
                        });
                    });
                });
            }else{
                alert(res.message);
                jQuery('#wrap-loading').hide();
            }
        }
    });
}
function edit_data(_id){
    jQuery('#wrap-loading').show();
    jQuery.ajax({
        method: 'post',
        url: '<?php echo admin_url('admin-ajax.php'); ?>',
        dataType: 'json',
        data:{
            'action': 'get_data_absensi_lembur_by_id',
            'api_key': '<?php echo get_option(SIMPEG_APIKEY); ?>',
            'id': _id,
        },
        success: function(res){
            if(res.status == 'success'){
                jQuery('#id_data').val(res.data.id).prop('disabled', false);
                jQuery('#tahun_anggaran').val(res.data.tahun_anggaran).prop('disabled', true);

                get_sbu(true)
                .then(function(){
                    get_skpd(true)
                    .then(function(){
                        jQuery('#id_skpd').val(res.data.id_skpd).trigger('change').prop('disabled', true).hide();
                        jQuery('#waktu_mulai_spt').val(res.data.waktu_mulai_spt).trigger('change').prop('disabled', true);
                        jQuery('#waktu_selesai_spt').val(res.data.waktu_selesai_spt).trigger('change').prop('disabled', true);
                        get_pegawai_absensi(true)
                        .then(function(){
                            res.data_detail.map(function(b, i){
                                if(i >= 1){
                                    jQuery('tr[data-id="1"] .tambah-pegawai').click();
                                }
                            });
                            setTimeout(function(){
                                res.data_detail.map(function(b, i){
                                    var id = i+1;
                                    jQuery('#id_pegawai_'+id).val(b.id_pegawai).trigger('change').prop('disabled', true);
                                    jQuery('#id_spt_detail_'+id).val(b.id).prop('disabled', true);
                                    jQuery('#jenis_hari_'+id).val(b.tipe_hari).trigger('change').prop('disabled', false);
                                    jQuery('#waktu_mulai_'+id).val(b.waktu_mulai).trigger('change').prop('disabled', false);
                                    jQuery('#waktu_selesai_'+id).val(b.waktu_akhir).trigger('change').prop('disabled', false);
                                    jQuery('#keterangan_'+id).val(b.keterangan).prop('disabled', true);
                                    jQuery('#keterangan_'+id).val(b.keterangan).prop('disabled', true);
                                    if(b.id_standar_harga_makan == '0'){
                                        jQuery('#uang_makan_set_'+id).prop('checked', false).prop('disabled', false);
                                    }else{
                                        jQuery('#uang_makan_set_'+id).prop('checked', true).prop('disabled', false);
                                    }
                                });

                                jQuery("#modalTambahDataAbsensiLembur #lampiran").val("").closest('.form-group').show();
                                jQuery("#modalTambahDataAbsensiLembur #ket_lembur").val("").closest('.form-group').show();
                                if (res.data.file_lampiran) {
                                    var fileLink = global_file_upload + res.data.file_lampiran;
                                    jQuery('#file_lampiran_existing')
                                        .attr('href', fileLink)
                                        .html(res.data.file_lampiran)
                                        .show()
                                        .prop('disabled', false);
                                    jQuery('#file_lampiran_existing').closest('.form-group').show();
                                    jQuery('#lampiran').val('').show();
                                } else {
                                    jQuery('#file_lampiran_existing').hide();
                                    jQuery('#file_lampiran_existing').closest('.form-group').find('input').show();
                                }

                                jQuery('#ket_lembur').val(res.data.ket_lembur).prop('disabled', false).show();
                                jQuery('#modalTambahDataAbsensiLembur .send_data').show();
                                jQuery('#modalTambahDataAbsensiLembur').modal('show');
                                jQuery('#wrap-loading').hide();
                            }, 1000);
                        });
                    });
                });
            } else {
                alert(res.message);
                jQuery('#wrap-loading').hide();
            }
        }
    });
}

function tambah_data_absensi_lembur(){
    jQuery('#id_data').val('');
    jQuery('#tahun_anggaran').val('<?php echo date('Y'); ?>').trigger('change').prop('disabled', false);
    jQuery('#id_skpd').val('<?php echo $input['id_skpd']; ?>').trigger('change').hide();
    get_pegawai_absensi(true).then(function(){
        jQuery('#uang_makan').val('0').prop('disabled', true);
        jQuery('#uang_lembur').val('0').prop('disabled', true);
        jQuery('#sbu_makan').val('').prop('disabled', false);
        jQuery('#sbu_lembur').val('').prop('disabled', false);
        jQuery('#id_pegawai_1').val('<?php echo $input['id']; ?>').trigger('change').prop('disabled', false);
    })
    jQuery('#keterangan_status_admin').closest('.form-group').hide().prop('disabled', false);
    jQuery('#id_admin').val('').prop('disabled', false);
    jQuery('#status_ver_admin').val('').prop('disabled', false);
    jQuery('#status_admin').prop('checked', false);
    jQuery('#keterangan_status_admin').val('').prop('disabled', false);
    jQuery('#ket_lembur').closest('.form-group').val('').prop('disabled', false).hide();
    jQuery('#waktu_mulai_spt').trigger('change').prop('disabled', true);
    jQuery('#waktu_selesai_spt').trigger('change').prop('disabled', true);
    jQuery('#lampiran').closest('.form-group').val('').hide();
    jQuery('#file_lampiran_existing').closest('.form-group').hide();
    jQuery('#file_lampiran_existing').closest('.form-group').find('input').hide();
    jQuery('#modalTambahDataAbsensiLembur .send_data').show();
    jQuery('#modalTambahDataAbsensiLembur').modal('show');
}

function submitTambahDataFormAbsensiLembur(){
    var tahun_anggaran = jQuery('#tahun_anggaran').val();
    if(tahun_anggaran == ''){
        return alert('Pilih tahun anggaran dulu!');
    }
    var id_skpd = jQuery('#id_skpd').val();
    if(id_skpd == ''){
        return alert('Pilih SKPD dulu!');
    }
    var ket_lembur = jQuery('#ket_lembur').val();
    var waktu_mulai_spt = jQuery('#waktu_mulai_spt').val();
    if(waktu_mulai_spt == ''){
        return alert('Tanggal Mulai Absensi diisi dulu!');
    }
    var waktu_selesai_spt = jQuery('#waktu_selesai_spt').val();
    if(waktu_selesai_spt == ''){
        return alert('Tanggal Selesai Absensi diisi dulu!');
    }
    var lampiran = jQuery('#lampiran')[0].files[0];
    var pegawai_all = {};
    var error = [];
    jQuery('#daftar_pegawai tbody tr').map(function(i, b){
        var id = jQuery(b).attr('data-id');
        var id_pegawai = jQuery('#id_pegawai_'+id).val();
        if(id_pegawai == ''){
            error.push('Nama pegawai no '+id+' diisi dulu!');
        }
        var waktu_mulai = jQuery('#waktu_mulai_'+id).val();
        if(waktu_mulai == ''){
            error.push('Waktu mulai no '+id+' diisi dulu!');
        }
        var waktu_selesai = jQuery('#waktu_selesai_'+id).val();
        if(waktu_selesai == ''){
            error.push('Waktu selesai no '+id+' diisi dulu!');
        }
        var key = id_pegawai;
        if(!pegawai_all[key]){
            pegawai_all[key] = [];
        }
        var waktu_mulai_time = new Date(waktu_mulai);
        var waktu_selesai_time = new Date(waktu_selesai);
        pegawai_all[key].map(function(b, i){
            var start_peg = new Date(b.waktu_mulai);
            var end_peg = new Date(b.waktu_selesai);
            if(
                waktu_mulai_time >= start_peg
                && waktu_mulai_time <= end_peg
            ){
                error.push('Waktu mulai pegawai no '+id+' tidak boleh di dalam waktu lembur pegawai no '+b.nomor+'!');
            }
            if(
                waktu_selesai_time <= end_peg
                && waktu_selesai_time >= start_peg
            ){
                error.push('Waktu selesai pegawai no '+id+' tidak boleh di dalam waktu lembur pegawai no '+b.nomor+'!');
            }
        });
        pegawai_all[key].push({
            id_pegawai: id_pegawai,
            nomor: id,
            waktu_mulai: waktu_mulai,
            waktu_selesai: waktu_selesai
        });
    });
    if(error.length >= 1){
        console.log('error', error);
        return alert('Kesalahan input pegawai! ( '+error.join(', ')+' )');
    }
    if(confirm('Apakah anda yakin untuk menyimpan data ini?')){
        jQuery("#wrap-loading").show();
        let form = new FormData();
        form.append('action', 'tambah_data_absensi_lembur');
        form.append('api_key', jQuery('#api_key').val());
        form.append('data', JSON.stringify(getFormData(jQuery("#form-absensi"))));
        if (typeof lampiran != 'undefined') {
            form.append('lampiran', lampiran);
        }
        jQuery.ajax({
            method: 'post',
            url: '<?php echo admin_url('admin-ajax.php'); ?>',
            dataType: 'json',
            data: form,
            processData: false,
            contentType: false,
            cache: false,
            success: function(response){
                jQuery('#wrap-loading').hide();
                alert(response.message);
                if(response.status == 'success'){
                    jQuery('#modalTambahDataAbsensiLembur').modal('hide');
                    get_data_absensi_lembur();
                }
            }
        });
    }
}

function get_uang_lembur(that){
    var id = jQuery(that).closest('tr').attr('data-id');
    var golongan = jQuery('#id_pegawai_'+id+' option:selected').attr('golongan');
    var waktu_mulai = jQuery('#waktu_mulai_'+id).val();
    var waktu_selesai = jQuery('#waktu_selesai_'+id).val();
    var jam = (new Date(waktu_selesai)).getTime() - (new Date(waktu_mulai)).getTime();
    jam = Math.round(jam / (1000 * 60 * 60));
    var jenis_hari = jQuery('#jenis_hari_'+id).val();
    jQuery('#uang_lembur_'+id).val(0);
    jQuery('#uang_makan_'+id).val(0);
    if(isNaN(jam)){
        jam = 0;
    }
    jQuery('#jumlah_jam_'+id).html(jam+' jam');
    jQuery('#jml_jam_lembur_'+id).val(jam);
    jQuery('#jml_hari_lembur_'+id).val(jam);
    jQuery('#pajak_'+id).html('-');
    jQuery('#jml_pajak_'+id).val(0);
    jQuery('#sbu_lembur_'+id).html('-');
    jQuery('#sbu_makan_'+id).html('-');
    jQuery('#id_standar_harga_lembur_'+id).val('');
    jQuery('#id_standar_harga_makan_'+id).val('');
    if(
        golongan
        && jam >= 1
    ){
        get_sbu()
        .then(function(sbu){
            var sbu_selected = false;
            var sbu_makan_selected = false;
            sbu.map(function(b, i){
                if(
                    b.id_golongan == golongan
                    && b.jenis_hari == jenis_hari
                    && b.jenis_sbu == 'uang_lembur'
                ){
                    sbu_selected = b;
                }else if(
                    b.id_golongan == golongan
                    && b.jenis_sbu == 'uang_makan'
                ){
                    sbu_makan_selected = b;
                }
            });
            console.log('sbu_selected, sbu_makan_selected, golongan, jam, jenis_hari', sbu_selected, sbu_makan_selected, golongan, jam, jenis_hari);
            var jml_pajak = 0;
            if(sbu_selected){
                var uang_lembur = sbu_selected.harga*jam;
                jQuery('#id_standar_harga_lembur_'+id).val(sbu_selected.id);
                jQuery('#uang_lembur_'+id).val(uang_lembur);
                jQuery('#sbu_lembur_'+id).html(sbu_selected.nama+' ('+sbu_selected.uraian+') | '+sbu_selected.harga+' | '+sbu_selected.satuan);
                if(
                    sbu_selected.pph_21
                    && sbu_selected.pph_21 > 0
                ){
                    jQuery('#pajak_'+id).html(sbu_selected.pph_21 + '%');
                    jml_pajak += (uang_lembur*sbu_selected.pph_21)/100;
                }
            }
            if(
                sbu_makan_selected
                && jam >= 2
                && jQuery('#uang_makan_set_'+id).is(':checked')
            ){
                jQuery('#id_standar_harga_makan_'+id).val(sbu_makan_selected.id);
                jQuery('#uang_makan_'+id).val(sbu_makan_selected.harga);
                jQuery('#sbu_makan_'+id).html(sbu_makan_selected.nama+' ('+sbu_makan_selected.uraian+') | '+sbu_makan_selected.harga+' | '+sbu_makan_selected.satuan);
                if(
                    sbu_makan_selected.pph_21
                    && sbu_makan_selected.pph_21 > 0
                ){
                    jml_pajak += (sbu_makan_selected.harga*sbu_makan_selected.pph_21)/100;
                }
            }

            jQuery('#jml_pajak_'+id).val(jml_pajak);
        });
    }
}

function get_sbu(no_loading = false){
    return new Promise(function(resolve, reject){
        var tahun = jQuery('#tahun_anggaran').val();
        if(typeof data_sbu_global == 'undefined'){
            window.data_sbu_global = {};
        }
        if(!data_sbu_global[tahun]){
            if(!no_loading){
                jQuery('#wrap-loading').show();
            }
            jQuery.ajax({
                method: 'post',
                url: '<?php echo admin_url('admin-ajax.php'); ?>',
                dataType: 'json',
                data: {
                    'action': 'get_data_sbu_lembur',
                    'api_key': '<?php echo get_option( SIMPEG_APIKEY ); ?>',
                    'tahun_anggaran': tahun
                },
                success: function(res){
                    data_sbu_global[tahun] = res.data;
                    if(!no_loading){
                        jQuery('#wrap-loading').hide();
                    }
                    return resolve(data_sbu_global[tahun]);
                }
            });
        }else{
            return resolve(data_sbu_global[tahun]);
        }
    });
}
function set_keterangan(that){
    var id = jQuery(that).attr('id');
    if(jQuery(that).is(':checked')){
        jQuery('#keterangan_'+id).closest('.form-group').hide();
    }else{
        jQuery('#keterangan_'+id).closest('.form-group').show();
    }
}
</script>
