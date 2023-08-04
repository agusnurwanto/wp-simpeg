<?php
global $wpdb;
$idtahun = $wpdb->get_results("select distinct tahun_anggaran from data_unit_lembur", ARRAY_A);
$tahun = "<option value='-1'>Pilih Tahun</option>";
foreach($idtahun as $val){
    $tahun .= "<option value='$val[tahun_anggaran]'>$val[tahun_anggaran]</option>";
}

$user_id = um_user( 'ID' );
$user_meta = get_userdata($user_id);
$disabled = 'disabled';
if(in_array("administrator", $user_meta->roles)){
    $disabled = '';
}
// print_r($total_pencairan); die($wpdb->last_query);
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
        <h1 class="text-center" style="margin:3rem;">Input Data Surat Perintah Tugas (SPT)</h1>
        <div style="margin-bottom: 25px;">
            <button class="btn btn-primary" onclick="tambah_data_spt_lembur();"><i class="dashicons dashicons-plus"></i> Tambah Data</button>
        </div>
        <div class="wrap-table">
            <table id="management_data_table" cellpadding="2" cellspacing="0" style="font-family:\'Open Sans\',-apple-system,BlinkMacSystemFont,\'Segoe UI\',sans-serif; border-collapse: collapse; width:100%; overflow-wrap: break-word;" class="table table-bordered">
                <thead>
                    <tr>
                        <th class="text-center">Nomor SPT</th>
                        <th class="text-center">SKPD</th>
                        <!-- <th class="text-center">Nama Pegawai</th> -->
                        <th class="text-center">Jumlah Pegawai</th>
                        <th class="text-center">Jumlah Jam</th>
                        <th class="text-center">Uang Makan</th>
                        <th class="text-center">Uang Lembur</th>
                        <th class="text-center">Total Pajak</th>
                        <th class="text-center">Keterangan Lembur</th>
                        <th class="text-center">Keterangan Verifikasi</th>
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

<div class="modal fade mt-4" id="modalTambahDataSPTLembur" role="dialog" aria-hidden="true">
    <div class="modal-dialog" style="min-width: 90vw;" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTambahDataSPTLemburLabel">Tambah Data Surat Perintah Tugas (SPT)</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="form-spt">
                    <input type='hidden' id='id_data' name="id_data" placeholder=''>
                    <div class="form-group">
                        <label>Nomor SPT</label>
                        <input type="text" class="form-control" id="nomor_spt" name="nomor_spt"/>
                    </div>
                    <div class="form-group">
                        <label>Pilih Tahun Anggaran</label>
                        <select class="form-control" id="tahun_anggaran" name="tahun_anggaran" onchange="get_skpd();">
                        <?php echo $tahun; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Pilih SKPD</label>
                        <select class="form-control" id="id_skpd" name="id_skpd" onchange="get_pegawai();">
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Keterangan Lembur</label>
                        <textarea class="form-control" id="ket_lembur" name="ket_lembur"></textarea>
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
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                    <!-- <div class="form-group hide">
                        <label>Keterangan Verifikasi PPK</label>
                        <select class="form-control" id="ket_ver_ppk" onchange="">
                        </select>
                    </div>
                    <div class="form-group hide">
                        <label>Keterangan Verifikasi Kepala</label>
                        <select class="form-control" id="ket_ver_kepala" onchange="">
                        </select>
                    </div>
                    <div class="form-group hide">
                        <label>Status Verifikasi Bendahara</label>
                        <input type="number" class="form-control" id="status_ver_bendahara" onchange="" />
                    </div>
                    <div class="form-check form-switch hide">
                        <input class="form-check-input" value="1" type="checkbox" id="status_bendahara" onclick="set_keterangan(this);" <?php echo $disabled; ?>>
                        <label class="form-check-label" for="status_bendahara">Disetujui</label>
                    </div>
                    <div class="form-group" style="display:none;">
                        <label>Keterangan ditolak</label>
                        <textarea class="form-control" id="keterangan_status_bendahara" <?php echo $disabled; ?>></textarea>
                    </div> -->
                </form>
            </div>
            <div class="modal-footer">
                <button type="submit" onclick="submitTambahDataFormSPTLembur();" class="btn btn-primary send_data">Simpan</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal" aria-label="Close">Tutup</button>
            </div>
        </div>
    </div>
</div>   
<script>    
jQuery(document).ready(function(){
    get_data_spt_lembur();
    jQuery('#id_skpd').select2({
        'width': '100%'
    });
});

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

            // jika start pegawai lebih dulu dari start SPT
            if(start_peg < start){
                var new_val = start_asli+'T'+start_peg_asli.split('T')[1];
                tr_peg.find('.time-start').val(new_val).trigger('change');
                console.log('start_peg < start new_val start_peg', new_val);
            }else if(start_peg > end){
                var new_val = end_asli+'T'+start_peg_asli.split('T')[1];
                tr_peg.find('.time-start').val(new_val).trigger('change');
                console.log('start_peg > end new_val start_peg', new_val);
            }

            // jika end pegawai lebih lama dari end SPT
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
            '<td style="width: 75px;" class="text-center aksi-pegawai">'+
                '<button class="tambah-pegawai btn btn-warning btn-sm" onclick="tambah_pegawai(this); return false;"><i class="dashicons dashicons-plus"></i></button>'+
                '<button class="copy-pegawai btn btn-info btn-sm" onclick="tambah_pegawai(this, 1); return false;"><i class="dashicons dashicons-book"></i></button>'+
        '</td>'+
        '</tr>';
    return html;
}

function get_pegawai(no_loading=false) {
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
                    'action' : 'get_pegawai_simpeg',
                    'api_key': '<?php echo get_option( SIMPEG_APIKEY ); ?>',
                    'id_skpd': id_skpd,
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

function tambah_pegawai(that, copy=false){
    var id_skpd = jQuery('#id_skpd').val();
    if(id_skpd == ''){
        jQuery('#daftar_pegawai tbody').html('');
        return;
    }
    var tr = jQuery(that).closest('tbody').find('>tr').last();
    var id = +tr.attr('data-id');
    var newid = id + 1;
    var tr_html = html_pegawai({
        id: newid, 
        html: global_response_pegawai[id_skpd].html
    });
    jQuery('#daftar_pegawai > tbody').append(tr_html);
    jQuery('#id_pegawai_'+newid).select2({'width': '100%'});
    if(copy){
        var current_tr_id = jQuery(that).closest('tr').attr('data-id');
        jQuery('#id_pegawai_'+newid).val(jQuery('#id_pegawai_'+current_tr_id).val()).trigger('change');
        jQuery('#jenis_hari_'+newid).val(jQuery('#jenis_hari_'+current_tr_id).val()).trigger('change');
        jQuery('#waktu_mulai_'+newid).val(jQuery('#waktu_mulai_'+current_tr_id).val()).trigger('change');
        jQuery('#waktu_selesai_'+newid).val(jQuery('#waktu_selesai_'+current_tr_id).val()).trigger('change');
        jQuery('#uang_makan_set_'+newid).prop('checked', jQuery('#uang_makan_set_'+current_tr_id).is(':checked')).trigger('change');
    }
    jQuery('#daftar_pegawai > tbody > tr').map(function(i, b){
        if(i == 0){
            return;
            var html_hapus = ''+
                '<button class="btn btn-warning btn-sm" onclick="tambah_pegawai(this); return false;"><i class="dashicons dashicons-plus"></i></button>'+
                '<button class="copy-pegawai btn btn-info btn-sm" onclick="tambah_pegawai(this, 1); return false;"><i class="dashicons dashicons-book"></i></button>';
        }else{
            var html_hapus = ''+    
                '<button class="btn btn-danger btn-sm" onclick="hapus_pegawai(this); return false;"><i class="dashicons dashicons-trash"></i></button>'+
                '<button class="copy-pegawai btn btn-info btn-sm" onclick="tambah_pegawai(this, 1); return false;"><i class="dashicons dashicons-book"></i></button>';
        }
        jQuery(b).find('td').last().html(html_hapus);
    });
    jQuery('#id_spt_detail_'+newid).val('');
}

function hapus_pegawai(that){
    var id = jQuery(that).closest('tr').attr('data-id');
    jQuery('#daftar_pegawai tbody tr[data-id="'+id+'"]').remove();
}

function set_keterangan(that){
    var id = jQuery(that).attr('id');
    if(jQuery(that).is(':checked')){
        jQuery('#keterangan_'+id).closest('.form-group').hide();
    }else{
        jQuery('#keterangan_'+id).closest('.form-group').show();
    }
}

function get_data_spt_lembur(){
    if(typeof datapencairan_spt_lembur == 'undefined'){
        window.datapencairan_spt_lembur = jQuery('#management_data_table').on('preXhr.dt', function(e, settings, data){
            jQuery("#wrap-loading").show();
        }).DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": {
                url: '<?php echo admin_url('admin-ajax.php'); ?>',
                type: 'post',
                dataType: 'json',
                data:{
                    'action': 'get_datatable_data_spt_lembur',
                    'api_key': '<?php echo get_option( SIMPEG_APIKEY ); ?>',
                }
            },
            lengthMenu: [[20, 50, 100, -1], [20, 50, 100, "All"]],
            order: [[0, 'asc']],
            "aoColumnDefs": [
                { "bSortable": false, "aTargets": [ 8, 10 ] }
            ],
            "drawCallback": function( settings ){
                jQuery("#wrap-loading").hide();
            },
            "columns": [
                {
                    "data": 'nomor_spt',
                    className: "text-center"
                },
                {
                    "data": 'nama_skpd',
                    className: "text-center"
                },
                // {
                //     "data": 'nama_pegawai',
                //     className: "text-center"
                // },
                {
                    "data": 'jml_peg',
                    className: "text-center"
                },
                {
                    "data": 'jml_jam',
                    className: "text-center"
                },
                {
                    "data": 'uang_makan',
                    className: "text-center"
                },
                {
                    "data": 'uang_lembur',
                    className: "text-center"
                },
                {
                    "data": 'jml_pajak',
                    className: "text-center"
                },
                {
                    "data": 'ket_lembur',
                    className: "text-center"
                },
                {
                    "data": 'ket_ver_ppk',
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
    }else{
        datapencairan_spt_lembur.draw();
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
                'action' : 'hapus_data_spt_lembur_by_id',
                'api_key': '<?php echo get_option( SIMPEG_APIKEY ); ?>',
                'id'     : id
            },
            dataType: 'json',
            success:function(response){
                jQuery('#wrap-loading').hide();
                if(response.status == 'success'){
                    get_data_spt_lembur(); 
                }else{
                    alert(`GAGAL! \n${response.message}`);
                }
            }
        });
    }
}

function edit_data(_id){
    jQuery('#wrap-loading').show();
    jQuery.ajax({
        method: 'post',
        url: '<?php echo admin_url('admin-ajax.php'); ?>',
        dataType: 'json',
        data:{
            'action': 'get_data_spt_lembur_by_id',
            'api_key': '<?php echo get_option( SIMPEG_APIKEY ); ?>',
            'id': _id,
        },
        success: function(res){
            if(res.status == 'success'){
                jQuery('#id_data').val(res.data.id).prop('disabled', false);
                jQuery('#nomor_spt').val(res.data.nomor_spt).prop('disabled', false);
                jQuery('#tahun_anggaran').val(res.data.tahun_anggaran).prop('disabled', false);
                jQuery('#daftar_pegawai > tbody').html('');
                jQuery('#ket_lembur').val(res.data.ket_lembur).prop('disabled', false);
                jQuery('#ket_ver_ppk').val(res.data.ket_ver_ppk).prop('disabled', false);
                
                get_sbu(true)
                .then(function(){
                    get_skpd(true)
                    .then(function(){
                        jQuery('#id_skpd').val(res.data.id_skpd).trigger('change').prop('disabled', false);

                        // setting waktu SPT setelah get_skpd karena saat get_skpd data waktu direset
                        jQuery('#waktu_mulai_spt').val(res.data.waktu_mulai_spt).trigger('change').prop('disabled', false);
                        jQuery('#waktu_selesai_spt').val(res.data.waktu_selesai_spt).trigger('change').prop('disabled', false);
                        get_pegawai(true)
                        .then(function(){
                            res.data_detail.map(function(b, i){
                                if(i >= 1){
                                    jQuery('tr[data-id="1"] .tambah-pegawai').click();
                                }
                            });
                            setTimeout(function(){
                                res.data_detail.map(function(b, i){
                                    var id = i+1;
                                    jQuery('#id_pegawai_'+id).val(b.id_pegawai).trigger('change').prop('disabled', false);
                                    jQuery('#id_spt_detail_'+id).val(b.id).prop('disabled', false);
                                    jQuery('#jenis_hari_'+id).val(b.tipe_hari).trigger('change').prop('disabled', false);
                                    jQuery('#waktu_mulai_'+id).val(b.waktu_mulai).trigger('change').prop('disabled', false);
                                    jQuery('#waktu_selesai_'+id).val(b.waktu_akhir).trigger('change').prop('disabled', false);
                                    jQuery('#keterangan_'+id).val(b.keterangan).prop('disabled', false);
                                    if(b.id_standar_harga_makan == '0'){
                                        jQuery('#uang_makan_set_'+id).prop('checked', false).prop('disabled', false);
                                    }else{
                                        jQuery('#uang_makan_set_'+id).prop('checked', true).prop('disabled', false);
                                    }
                                });
                                // jQuery('#id_ppk').val(res.data.id_ppk).prop('disabled', false);
                                // jQuery('#id_bendahara').val(res.data.id_bendahara).prop('disabled', false);
                                // jQuery('#ket_ver_ppk').val(res.data.uang_lembur).prop('disabled', false);
                                // jQuery('#ket_ver_kepala').val(res.data.uang_lembur).prop('disabled', false);
                                // jQuery('#status_ver_bendahara').val(res.data.status_bendahara).prop('disabled', false);
                                // if(res.data.status_bendahara == 0){
                                //     jQuery('#keterangan_status_bendahara').closest('.form-group').show().prop('disabled', false);
                                //     jQuery('#status_bendahara').prop('checked', false);
                                // }else{
                                //     jQuery('#keterangan_status_bendahara').closest('.form-group').hide().prop('disabled', false);
                                //     jQuery('#status_bendahara').prop('checked', true);
                                // }
                                // jQuery('#status_bendahara').closest('.form-check').show().prop('disabled', false);
                                jQuery('#modalTambahDataSPTLembur .send_data').show();
                                jQuery('#modalTambahDataSPTLembur').modal('show');
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

function detail_data(_id){
    jQuery('#wrap-loading').show();
    jQuery.ajax({
        method: 'post',
        url: '<?php echo admin_url('admin-ajax.php'); ?>',
        dataType: 'json',
        data:{
            'action': 'get_data_spt_lembur_by_id',
            'api_key': '<?php echo get_option( SIMPEG_APIKEY ); ?>',
            'id': _id,
        },
        success: function(res){
            if(res.status == 'success'){
                jQuery('#id_data').val(res.data.id).prop('disabled', false);
                jQuery('#nomor_spt').val(res.data.nomor_spt).prop('disabled', true);
                jQuery('#tahun_anggaran').val(res.data.tahun_anggaran).prop('disabled', true);
                jQuery('#ket_lembur').val(res.data.ket_lembur).prop('disabled', true);
                jQuery('#ket_ver_ppk').val(res.data.ket_ver_ppk).prop('disabled', true);

                get_sbu(true)
                .then(function(){
                    get_skpd(true)
                    .then(function(){
                        jQuery('#id_skpd').val(res.data.id_skpd).trigger('change').prop('disabled', true);
                        jQuery('#waktu_mulai_spt').val(res.data.waktu_mulai_spt).trigger('change').prop('disabled', true);
                        jQuery('#waktu_selesai_spt').val(res.data.waktu_selesai_spt).trigger('change').prop('disabled', true);
                        get_pegawai(true)
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
                                // jQuery('#id_ppk').val(res.data.id_ppk).prop('disabled', true);
                                // jQuery('#id_bendahara').val(res.data.id_bendahara).prop('disabled', true);
                                // jQuery('#ket_ver_ppk').val(res.data.uang_lembur).prop('disabled', true);
                                // jQuery('#ket_ver_kepala').val(res.data.uang_lembur).prop('disabled', true);
                                // jQuery('#status_ver_bendahara').val(res.data.status_bendahara).prop('disabled', true);
                                // if(res.data.status_bendahara == 0){
                                //     jQuery('#keterangan_status_bendahara').closest('.form-group').show().prop('disabled', true);
                                //     jQuery('#status_bendahara').prop('checked', true);
                                // }else{
                                //     jQuery('#keterangan_status_bendahara').closest('.form-group').hide().prop('disabled', true);
                                //     jQuery('#status_bendahara').prop('checked', true);
                                // }
                                // jQuery('#status_bendahara').closest('.form-check').show().prop('disabled', true);
                                jQuery('.aksi-pegawai .btn').hide();
                                jQuery('#modalTambahDataSPTLembur .send_data').hide();
                                jQuery('#modalTambahDataSPTLembur').modal('show');
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

//show tambah data
function tambah_data_spt_lembur(){
    jQuery('#id_data').val('').prop('disabled', false);
    jQuery('#nomor_spt').val('').prop('disabled', false);
    jQuery('#tahun_anggaran').val('<?php echo date('Y'); ?>').trigger('change').prop('disabled', false);
    jQuery('#id_skpd').val('').trigger('change').prop('disabled', false);
    jQuery('#ket_lembur').val('').prop('disabled', false);
    jQuery('#id_ppk').val('').prop('disabled', false);
    jQuery('#id_bendahara').val('').prop('disabled', false);
    jQuery('#ket_ver_ppk').val('').prop('disabled', false);
    jQuery('#ket_ver_kepala').val('').prop('disabled', false);
    jQuery('#status_ver_bendahara').val('').prop('disabled', false);
    jQuery('#keterangan_status_bendahara').closest('.form-group').hide().prop('disabled', false);
    jQuery('#status_bendahara').prop('checked', false);
    jQuery('#keterangan_status_bendahara').val('').prop('disabled', false);
    jQuery('#waktu_mulai_spt').prop('disabled', false);
    jQuery('#waktu_selesai_spt').prop('disabled', false);
    jQuery('#modalTambahDataSPTLembur .send_data').show();
    jQuery('#modalTambahDataSPTLembur').modal('show');
}

function submitTambahDataFormSPTLembur(){
    var nomor_spt = jQuery('#nomor_spt').val();
    if(nomor_spt == ''){
        return alert('Nomor SPT wajib diisi!');
    }
    var tahun_anggaran = jQuery('#tahun_anggaran').val();
    if(tahun_anggaran == ''){
        return alert('Pilih tahun anggaran dulu!');
    }
    var id_skpd = jQuery('#id_skpd').val();
    if(id_skpd == ''){
        return alert('Pilih SKPD dulu!');
    }
    var ket_lembur = jQuery('#ket_lembur').val();
    if(ket_lembur == ''){
        return alert('Keterangan lembur diisi dulu!');
    }
    var waktu_mulai_spt = jQuery('#waktu_mulai_spt').val();
    if(waktu_mulai_spt == ''){
        return alert('Tanggal Mulai SPT diisi dulu!');
    }
    var waktu_selesai_spt = jQuery('#waktu_selesai_spt').val();
    if(waktu_selesai_spt == ''){
        return alert('Tanggal Selesai SPT diisi dulu!');
    }
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
        let form = getFormData(jQuery("#form-spt"));
        jQuery.ajax({
            method:'post',
            url:'<?php echo admin_url('admin-ajax.php'); ?>',
            dataType: 'json',
            data: {
                'action': 'tambah_data_spt_lembur',
                'api_key': jQuery('#api_key').val(),
                'data': JSON.stringify(form)
            },
            success:function(response){
                jQuery('#wrap-loading').hide();
                alert(response.message);
                if(response.status == 'success'){
                    jQuery('#modalTambahDataSPTLembur').modal('hide');
                    get_data_spt_lembur();
                }
            }
        });
    }
}

function getFormData($form){
    var disabled = $form.find('[disabled]');
    disabled.map(function(i, b){
        jQuery(b).attr('disabled', false);
    });
    let unindexed_array = $form.serializeArray();
    disabled.map(function(i, b){
        jQuery(b).attr('disabled', true);
    });
    var data = {};
    unindexed_array.map(function(b, i){
        var nama_baru = b.name.split('[');
        if(nama_baru.length > 1){
            nama_baru = nama_baru[0];
            if(!data[nama_baru]){
                data[nama_baru] = [];
            }
            data[nama_baru].push(b.value);
        }else{
            data[b.name] = b.value;
        }
    })
    console.log('data', data);
    return data;
}

function get_uang_lembur(that){
    var id = jQuery(that).closest('tr').attr('data-id');
    var golongan = jQuery('#id_pegawai_'+id+' option:selected').attr('golongan');
    var waktu_mulai = jQuery('#waktu_mulai_'+id).val();
    var waktu_selesai = jQuery('#waktu_selesai_'+id).val();
    var jam = (new Date(waktu_selesai)).getTime() - (new Date(waktu_mulai)).getTime();
    jam = Math.floor(jam / (1000 * 60 * 60));
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
</script>