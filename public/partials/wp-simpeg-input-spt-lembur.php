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
                        <th class="text-center">Id SKPD</th>
                        <th class="text-center">Id PPK</th>
                        <th class="text-center">Id Bendahara</th>
                        <th class="text-center">Uang Makan</th>
                        <th class="text-center">Uang Lembur</th>
                        <th class="text-center">Keterangan Lembur</th>
                        <th class="text-center">Keterangan Verifikasi PPK</th>
                        <th class="text-center">Keterangan Verifikasi Kepala</th>
                        <th class="text-center">Status Verifikasi Bendahara</th>
                        <th class="text-center">Keterangan Verifikasi Bendahara</th>
                        <th class="text-center">Status</th>
                        <th class="text-center" style="width: 150px;">Aksi</th>
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
                        <select class="form-control" id="tahun_anggaran" name="tahun_anggaran" onchange="get_skpd(this);">
                        <?php echo $tahun; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Pilih SKPD</label>
                        <select class="form-control" id="id_skpd" name="id_skpd" onchange="get_pegawai(this);">
                        </select>
                    </div>
                    <table class="table table-bordered" id="daftar_pegawai">
                        <thead>
                            <tr>
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
                    <div class="form-group">
                        <label>Keterangan Lembur</label>
                        <textarea class="form-control" id="ket_lembur" name="ket_lembur"></textarea>
                    </div>
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

function get_skpd(that) {
    var tahun = jQuery(that).val();
    if(tahun == ''){
        return alert('Tahun anggaran tidak boleh kosong!');
    }
    jQuery("#wrap-loading").show();
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
            jQuery('#wrap-loading').hide();
            if(response.status == 'success'){
                jQuery('#id_skpd').select2('destroy');
                jQuery('#id_skpd').html(response.html);
                jQuery('#id_skpd').select2();
            }else{
                alert(`GAGAL! \n${response.message}`);
            }
        }
    });
}

function get_pegawai(that) {
    var id_skpd = jQuery(that).val();
    if(id_skpd == ''){
        jQuery('#daftar_pegawai tbody').html('');
        return;
    }
    jQuery("#wrap-loading").show();
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
            jQuery('#wrap-loading').hide();
            if(response.status == 'success'){
                var html = ''+
                    '<tr data-id="1">'+
                        '<td class="text-center">'+
                            '<select class="form-control" name="id_pegawai[1]" id="id_pegawai_1" onchange="get_uang_lembur(this);">'+response.html+'</select>'+
                            '<input type="hidden" name="id_spt_detail[1]" id="id_spt_detail_1"/>'+
                            '<br>'+
                            '<br>'+
                            '<label style="display: block;">Jenis Hari'+
                                '<br>'+
                                '<select class="form-control" name="jenis_hari[1]" id="jenis_hari_1" onchange="get_uang_lembur(this);">'+
                                    '<option value="2">Hari Kerja</option>'+
                                    '<option value="1">Hari Libur</option>'+
                                '</select>'+
                            '</label>'+
                        '</td>'+
                        '<td class="text-center">'+
                            '<label>Waktu Mulai<br><input type="datetime-local" class="form-control" name="waktu_mulai[1]" id="waktu_mulai_1" onchange="get_uang_lembur(this);"/></label>'+
                            '<label>Waktu Selesai<br><input type="datetime-local" class="form-control" name="waktu_selesai[1]" id="waktu_selesai_1" onchange="get_uang_lembur(this);"/></label>'+
                            '<table class="table table-bordered" style="margin: 0;">'+
                                '<tbody>'+
                                    '<tr>'+
                                        '<td style="width: 115px;">Jumlah jam</td>'+
                                        '<td id="jumlah_jam_1" class="text-center">0 jam</td>'+
                                    '</tr>'+
                                '</tbody>'+
                            '</table>'+
                        '</td>'+
                        '<td class="text-center">'+
                            '<label>Uang Lembur<br><input type="text" disabled class="form-control text-right" name="uang_lembur[1]" id="uang_lembur_1"/></label>'+
                            '<label>Uang Makan<br><input type="text" disabled class="form-control text-right" name="uang_makan[1]" id="uang_makan_1"/></label>'+
                            '<input type="hidden" name="id_standar_harga_lembur[1]" id="id_standar_harga_lembur_1"/>'+
                            '<input type="hidden" name="id_standar_harga_makan[1]" id="id_standar_harga_makan_1"/>'+
                        '</td>'+
                        '<td class="text-center">'+
                            '<textarea class="form-control" name="keterangan[1]" id="keterangan_1"></textarea>'+
                            '<table class="table table-bordered" style="margin: 0;">'+
                                '<tbody>'+
                                    '<tr>'+
                                        '<td style="width: 115px;">SBU uang lembur</td>'+
                                        '<td id="sbu_lembur_1" class="text-center">-</td>'+
                                    '</tr>'+
                                    '<tr>'+
                                        '<td>SBU uang makan</td>'+
                                        '<td id="sbu_makan_1" class="text-center">-</td>'+
                                    '</tr>'+
                                '</tbody>'+
                            '</table>'+
                        '</td>'+
                        '<td style="width: 75px;" class="text-center">'+
                            '<button class="btn btn-warning btn-sm" onclick="tambah_pegawai(this); return false;"><i class="dashicons dashicons-plus"></i></button>'+
                    '</td>'+
                    '</tr>';
                jQuery('#daftar_pegawai tbody').html(html);
                jQuery('#id_pegawai_1').html(response.html);
                jQuery('#id_pegawai_1').select2({'width': '100%'});
            }else{
                alert(`GAGAL! \n${response.message}`);
            }
        }
    });
}

function escapeRegExp(string) {
    return string.replace(/[.*+?^${}()|[\]\\]/g, '\\$&'); // $& means the whole matched string
}

//show tambah data
function tambah_pegawai(that){
    var tr = jQuery(that).closest('tr');
    var id = +tr.attr('data-id');
    var newid = id + 1;
    var tr_html = tr.html();
    tr_html = tr_html.replace(new RegExp(escapeRegExp('_'+id+'"'), 'g'), '_'+newid+'"');
    tr_html = tr_html.replace(new RegExp(escapeRegExp('['+id+']'), 'g'), '['+newid+']');
    tr_html = '<tr data-id="'+newid+'">'+tr_html+'</tr>';
    jQuery('#daftar_pegawai > tbody').append(tr_html);

    jQuery('#daftar_pegawai > tbody > tr[data-id='+newid+'] .select2-container').remove();
    jQuery('#id_pegawai_'+newid).select2({'width': '100%'});
    
    jQuery('#daftar_pegawai > tbody > tr').map(function(i, b){
        if(i == 0){
            return;
        var html_hapus = ''+
            '<button class="btn btn-warning btn-sm" onclick="tambah_pegawai(this); return false;"><i class="dashicons dashicons-plus"></i></button>';
    }else{
        var html_hapus = ''+    
            '<button class="btn btn-danger btn-sm" onclick="hapus_pegawai(this); return false;"><i class="dashicons dashicons-trash"></i></button>';
        }

        jQuery(b).find('td').last().html(html_hapus);
    });
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
            "drawCallback": function( settings ){
                jQuery("#wrap-loading").hide();
            },
            "columns": [
                {
                    "data": 'id_skpd',
                    className: "text-center"
                },
                {
                    "data": 'id_ppk',
                    className: "text-center"
                },
                {
                    "data": 'id_bendahara',
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
                    "data": 'ket_lembur',
                    className: "text-center"
                },
                {
                    "data": 'ket_ver_ppk',
                    className: "text-center"
                },
                {
                    "data": 'ket_ver_kepala',
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
                get_spt_lembur()
                .then(function(){
                    jQuery('#id_skpd').val(res.data.id_skpd).prop('disabled', false);
                    jQuery('#id_ppk').val(res.data.id_ppk).prop('disabled', false);
                    jQuery('#id_bendahara').val(res.data.id_bendahara).prop('disabled', false);
                    jQuery('#uang_makan').val(res.data.uang_makan).prop('disabled', false);
                    jQuery('#uang_lembur').val(res.data.uang_lembur).prop('disabled', false);
                    jQuery('#ket_lembur').val(res.data.uang_lembur).prop('disabled', false);
                    jQuery('#ket_ver_ppk').val(res.data.uang_lembur).prop('disabled', false);
                    jQuery('#ket_ver_kepala').val(res.data.uang_lembur).prop('disabled', false);
                    jQuery('#status_ver_bendahara').val(res.data.status_bendahara).prop('disabled', false);
                    if(res.data.status_bendahara == 0){
                        jQuery('#keterangan_status_bendahara').closest('.form-group').show().prop('disabled', false);
                        jQuery('#status_bendahara').prop('checked', false);
                    }else{
                        jQuery('#keterangan_status_bendahara').closest('.form-group').hide().prop('disabled', false);
                        jQuery('#status_bendahara').prop('checked', true);
                    }
                    jQuery('#status_bendahara').closest('.form-check').show().prop('disabled', false);
                    jQuery('#modalTambahDataSPTLembur .send_data').show();
                    jQuery('#modalTambahDataSPTLembur').modal('show');
                })
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
                jQuery('#id_data').val(res.data.id);
                get_spt_lembur()
                .then(function(){
                    jQuery('#id_skpd').val(res.data.id_skpd).prop('disabled', true);
                    jQuery('#id_ppk').val(res.data.id_ppk).prop('disabled', true);
                    jQuery('#id_bendahara').val(res.data.id_bendahara).prop('disabled', true);
                    jQuery('#uang_makan').val(res.data.uang_makan).prop('disabled', true);
                    jQuery('#uang_lembur').val(res.data.uang_lembur).prop('disabled', true);
                    jQuery('#ket_lembur').val(res.data.ket_lembur).prop('disabled', true);
                    jQuery('#ket_ver_ppk').val(res.data.ket_ver_ppk).prop('disabled', true);
                    jQuery('#ket_ver_kepala').val(res.data.uang_lembur).prop('disabled', true);
                    jQuery('#status_ver_bendahara').val(res.data.status_bendahara).prop('disabled', true);
                    if(res.data.status_bendahara == 0){
                        jQuery('#keterangan_status_bendahara').closest('.form-group').show().prop('disabled', true);
                        jQuery('#status_bendahara').prop('checked', true);
                    }else{
                        jQuery('#keterangan_status_bendahara').closest('.form-group').hide().prop('disabled', true);
                        jQuery('#status_bendahara').prop('checked', true);
                    }
                    jQuery('#status_bendahara').closest('.form-check').show().prop('disabled', true);
                    jQuery('#modalTambahDataSPTLembur .send_data').show();
                    jQuery('#modalTambahDataSPTLembur').modal('show');
                })
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
    jQuery('#tahun').val('').prop('disabled', false);
    jQuery('#id_skpd').val('').prop('disabled', false);
    jQuery('#id_ppk').val('').prop('disabled', false);
    jQuery('#id_bendahara').val('').prop('disabled', false);
    jQuery('#uang_lembur').val('').prop('disabled', false);
    jQuery('#ket_ver_ppk').val('').prop('disabled', false);
    jQuery('#ket_ver_kepala').val('').prop('disabled', false);
    jQuery('#status_ver_bendahara').val('').prop('disabled', false);
    jQuery('#keterangan_status_bendahara').closest('.form-group').hide().prop('disabled', false);
    jQuery('#status_bendahara').prop('checked', false);
    jQuery('#keterangan_status_bendahara').val('').prop('disabled', false);
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
    jQuery('#sbu_lembur_'+id).html('-');
    jQuery('#sbu_makan_'+id).html('-');
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
            if(sbu_selected){
                jQuery('#id_standar_harga_lembur_'+id).val(sbu_selected.id);
                jQuery('#uang_lembur_'+id).val(sbu_selected.harga*jam);
                jQuery('#sbu_lembur_'+id).html(sbu_selected.nama+' ('+sbu_selected.uraian+') | '+sbu_selected.harga+' | '+sbu_selected.satuan);
            }
            if(
                sbu_makan_selected
                && jam >= 2
            ){
                jQuery('#id_standar_harga_makan_'+id).val(sbu_makan_selected.id);
                jQuery('#uang_makan_'+id).val(sbu_makan_selected.harga);
                jQuery('#sbu_makan_'+id).html(sbu_selected.nama+' ('+sbu_selected.uraian+') | '+sbu_selected.harga+' | '+sbu_selected.satuan);
            }
        });
    }
}

function get_sbu(){
    return new Promise(function(resolve, reject){
        if(typeof data_sbu_global == 'undefined'){
            jQuery('#wrap-loading').show();
            jQuery.ajax({
                method: 'post',
                url: '<?php echo admin_url('admin-ajax.php'); ?>',
                dataType: 'json',
                data: {
                    'action': 'get_data_sbu_lembur',
                    'api_key': '<?php echo get_option( SIMPEG_APIKEY ); ?>',
                    'tahun_anggaran': jQuery('#tahun_anggaran').val()
                },
                success: function(res){
                    data_sbu_global = res.data;
                    jQuery('#wrap-loading').hide();
                    return resolve(data_sbu_global);
                }
            });
        }else{
            return resolve(data_sbu_global);
        }
    });
}
</script>