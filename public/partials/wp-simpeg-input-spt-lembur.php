<?php
global $wpdb;
$idtahun = $wpdb->get_results("select distinct tahun_anggaran from data_unit", ARRAY_A);
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
    <h1 class="text-center" style="margin:3rem;">Input Data SPT</h1>
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

<div class="modal fade mt-4" id="modalTambahDataSPTLembur" tabindex="-1" role="dialog" aria-labelledby="modalTambahDataSPTLemburLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTambahDataSPTLemburLabel">Input Data SPT</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <input type='hidden' id='id_data' name="id_data" placeholder=''>
                <div class="form-group">
                    <label>Pilih Tahun Anggaran</label>
                    <select class="form-control" id="tahun_anggaran" onchange="get_skpd(this);">
                    <?php echo $tahun; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label>Pilih SKPD</label>
                    <select class="form-control" id="id_skpd" onchange="get_pegawai(this);">
                    </select>
                </div>
                <table class="table table-bordered" id="daftar_pegawai">
                    <thead>
                        <tr>
                            <th>Nama Pegawai</th>
                            <th>Waktu Mulai</th>
                            <th>Waktu Selesai</th>
                            <th>Uang Makan</th>
                            <th>Uang Lembur</th>
                            <th>Keterangan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
                <div class="form-group">
                    <label>Keterangan Lembur</label>
                    <textarea class="form-control" id="ket_lembur" onchange=""></textarea>
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
                  <button type="submit" onclick="submitTambahDataFormSPTLembur();" class="btn btn-primary send_data">Kirim</button>
                  <button type="button" class="btn btn-danger" data-dismiss="modal" aria-label="Close">Tutup</button>
            </form>
        </div>
    </div>
</div>   
<script>    
jQuery(document).ready(function(){
    get_data_spt_lembur();
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
                jQuery('#id_skpd').html(response.html);
                // jQuery('#id_skpd').select2();
            }else{
                alert(`GAGAL! \n${response.message}`);
            }
        }
    });
}

function get_pegawai(that) {
    var id_skpd = jQuery(that).val();
    if(id_skpd == ''){
        return alert('Nama tidak boleh kosong!');
    }
    jQuery("#wrap-loading").show();
    jQuery.ajax({
        url: '<?php echo admin_url('admin-ajax.php'); ?>',
        type:'post',
        data:{
            'action' : 'get_pegawai_simpeg',
            'api_key': '<?php echo get_option( SIMPEG_APIKEY ); ?>',
            'id_skpd': id_skpd
        },
        dataType: 'json',
        success:function(response){
            jQuery('#wrap-loading').hide();
            if(response.status == 'success'){
                var html = ''+
                    '<tr data-id="1">'+
                        '<td>'+
                            '<select class="form-control" id="id_pegawai[1]" onchange="">'+response.html+'</select>'+
                        '</td>'+
                        '<td>'+
                            '<input type="datetime-local" class="form-control" id="waktu_mulai[1]" onchange=""/>'+
                        '</td>'+
                        '<td>'+
                            '<input type="datetime-local" class="form-control" id="waktu_selesai[1]" onchange=""/>'+
                        '</td>'+
                        '<td>'+
                            '<input type="text" disabled class="form-control" id="uang_makan[1]" onchange="get_uang_makan"/>'+
                        '</td>'+
                        '<td>'+
                            '<input type="text" disabled class="form-control" id="uang_lembur[1]" onchange="get_uang_lembur"/>'+
                        '</td>'+
                        '<td>'+
                            '<textarea class="form-control" id="keterangan[1]"></textarea>'+
                        '</td>'+
                        '<td style="width: 75px;" class="text-center">'+
                            '<button class="btn btn-warning btn-sm" onclick="tambah_pegawai(this); return false;"><i class="dashicons dashicons-plus"></i></button>'+
                    '</td>'+
                    '</tr>';
                jQuery('#daftar_pegawai tbody').html(html);
                jQuery('#id_pegawai[1]').html(response.html); 
            }else{
                alert(`GAGAL! \n${response.message}`);
            }
        }
    });
}

//show tambah data
function tambah_pegawai(that){
    var tr = jQuery(that).closest('tr');
    var id = +tr.attr('data-id');
    var newid = id + 1;
    var tr_html = tr.html();
    tr_html = tr_html.replace('['+id+']', '['+newid+']');
    tr_html = '<tr data-id="'+newid+'">'+tr_html+'</tr>';
    jQuery('#daftar_pegawai tbody').append(tr_html);
    jQuery('#daftar_pegawai tbody tr').map(function(i, b){
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
    var id_data = jQuery('#id_data').val();
    var id_ppk = jQuery('#id_ppk').val();
    if(id_ppk == ''){
        return alert('Pilih id_ppk Dulu!');
    }
    var id_skpd = jQuery('#id_skpd').val();
    if(id_skpd == ''){
        return alert('Pilih id_skpd Dulu!');
    }
    var id_bendahara = jQuery('#id_bendahara').val();
    if(id_bendahara == ''){
        return alert('Pilih id_bendahara Dulu!');
    }
    var uang_lembur = jQuery('#uang_lembur').val();
    if(uang_lembur == ''){
        return alert('Pilih uang_lembur Dulu!');
    }
    var uang_makan = jQuery('#uang_makan').val();
    if(uang_makan == ''){
        return alert('Pilih Uang Makan Dulu!');
    }
    var ket_ver_ppk = jQuery('#ket_ver_ppk').val();
    if(ket_ver_ppk == ''){
        return alert('Isi Keterangan Verifikasi PPK Dulu!');
    }
    var ket_ver_kepala = jQuery('#ket_ver_kepala').val();
    if(ket_ver_kepala == ''){
        return alert('Isi Keterangan Verifikasi Kepala Dulu!');
    }
    var status_ver_bendahara = jQuery('#status_ver_bendahara').val();
    if(status_ver_bendahara == ''){
        return alert('Pilih status_ver_bendahara Dulu!');
    }
    var status_bendahara = jQuery('#status_bendahara').val();
    if(jQuery('#status_bendahara').is(':checked') == false){
        status_bendahara = 0;
    }
    var keterangan_status_bendahara = jQuery('#keterangan_status_bendahara').val();

    let tempData = new FormData();
    tempData.append('action', 'tambah_data_spt_lembur');
    tempData.append('api_key', '<?php echo get_option( SIMPEG_APIKEY ); ?>');
    tempData.append('id_data', id_data);
    tempData.append('waktu_mulai[1]', waktu_mulai);
    tempData.append('waktu_akhir[1]', waktu_akhir);
    tempData.append('uang_makan[1]', uang_makan);
    tempData.append('uang_lembur[1]', uang_lembur);
    tempData.append('ket_lembur[1]', ket_lembur);
    tempData.append('ket_ver_ppk', ket_ver_ppk);
    tempData.append('ket_ver_kepala', ket_ver_kepala);
    tempData.append('status_ver_bendahara', status_ver_bendahara);
    tempData.append('status_bendahara', status_bendahara);
    tempData.append('keterangan_status_bendahara', keterangan_status_bendahara);
    jQuery('#wrap-loading').show();
    jQuery.ajax({
        method: 'post',
        url: '<?php echo admin_url('admin-ajax.php'); ?>',
        dataType: 'json',
        data: tempData,
        processData: false,
        contentType: false,
        cache: false,
        success: function(res){
            alert(res.message);
            if(res.status == 'success'){
                jQuery('#modalTambahDataSPTLembur').modal('hide');
                get_data_spt_lembur();
            }else{
                jQuery('#wrap-loading').hide();
            }
        }
    });
}
</script>