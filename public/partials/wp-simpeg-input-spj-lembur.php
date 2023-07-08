<?php
global $wpdb;

$user_id = um_user( 'ID' );
$user_meta = get_userdata($user_id);
$disabled = 'disabled';
if(in_array("administrator", $user_meta->roles)){
    $disabled = '';
}

// print_r($total); die($wpdb->last_query);
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
    <h1 class="text-center" style="margin:3rem;">Input Surat Penanggungjawaban</h1>
        <div style="margin-bottom: 25px;">
            <button class="btn btn-primary" onclick="tambah_data_spj();"><i class="dashicons dashicons-plus"></i> Tambah Data</button>
        </div>
        <div class="wrap-table">
        <table id="management_data_table" cellpadding="2" cellspacing="0" style="font-family:\'Open Sans\',-apple-system,BlinkMacSystemFont,\'Segoe UI\',sans-serif; border-collapse: collapse; width:100%; overflow-wrap: break-word;" class="table table-bordered">
            <thead>
                <tr>
                    <th class="text-center">Id SPJ</th>
                    <th class="text-center">Daftar Hadir</th>
                    <th class="text-center">Foto Lembur</th>
                    <th class="text-center" style="width: 150px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
        </div>
    </div>          
</div>

<div class="modal fade mt-4" id="modalTambahDataSPJ" tabindex="-1" role="dialog" aria-labelledby="modalTambahDataSPJLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTambahDataSPJLabel">Data Surat Penanggungjawaban</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <input type='hidden' id='id_data' name="id_data" placeholder=''>
                <div class="form-group">
                    <label for='id_spj' style='display:inline-block'>Id SPJ</label>
                    <input type='text' id='id_spj' name="id_spj" class="form-control" placeholder=''>
                </div>
                <div class="form-group">
                    <label for="">Daftar Hadir</label>
                    <input type="file" name="file" class="form-control-file" id="file_daftar_hadir">
                    <small>Tipe file adalah .jpg .jpeg .png .pdf dengan maksimal ukuran 1MB.</small>
                    <div style="padding-top: 10px; padding-bottom: 10px;"><a id="file_daftar_hadir_existing"></a></div>
                </div>
                <div class="form-group">
                    <label for="">Foto Lembur</label>
                    <input type="file" name="file" class="form-control-file" id="foto_lembur">
                    <small>Tipe file adalah .jpg .jpeg .png .pdf dengan maksimal ukuran 1MB.</small>
                    <div style="padding-top: 10px; padding-bottom: 10px;"><a id="foto_lembur_existing"></a></div>
                </div>
                  <button type="submit" onclick="submitTambahDataFormSPJ();" class="btn btn-primary send_data">Kirim</button>
                  <button type="button" class="btn btn-danger" data-dismiss="modal" aria-label="Close">Tutup</button>
            </form>
        </div>
    </div>
</div>   
<script>    
jQuery(document).ready(function(){
    get_data_spj();
});

function get_data_spj(){
    if(typeof datapencairan_spj == 'undefined'){
        window.datapencairan_spj = jQuery('#management_data_table').on('preXhr.dt', function(e, settings, data){
            jQuery("#wrap-loading").show();
        }).DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": {
                url: '<?php echo admin_url('admin-ajax.php'); ?>',
                type: 'post',
                dataType: 'json',
                data:{
                    'action': 'get_datatable_data_spj',
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
                    "data": 'id_spj',
                    className: "text-center"
                },
                {
                    "data": 'file_daftar_hadir',
                    className: "text-center"
                },
                {
                    "data": 'foto_lembur',
                    className: "text-center"
                },
                {
                    "data": 'aksi',
                    className: "text-center"
                }
            ]
        });
    }else{
        datapencairan_spj.draw();
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
                'action' : 'hapus_data_spj_by_id',
                'api_key': '<?php echo get_option( SIMPEG_APIKEY ); ?>',
                'id'     : id
            },
            dataType: 'json',
            success:function(response){
                jQuery('#wrap-loading').hide();
                if(response.status == 'success'){
                    get_data_spj(); 
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
            'action': 'get_data_spj_by_id',
            'api_key': '<?php echo get_option( SIMPEG_APIKEY ); ?>',
            'id': _id,
        },
        success: function(res){
            if(res.status == 'success'){
                jQuery('#id_data').val(res.data.id).prop('disabled', false);
                jQuery('#id_spj').val(res.data.id_spj_anggaran).prop('disabled', false);
                get_spj()
                .then(function(){
                    jQuery("#file_daftar_hadir").val('');
                    jQuery("#file_daftar_hadir_existing").html(res.data.file_daftar_hadir);
                    jQuery("#file_daftar_hadir_existing").attr('target', '_blank');
                    jQuery("#file_daftar_hadir_existing").attr('href', '<?php echo WPSIPD_PLUGIN_URL.'public/media/simpeg/'; ?>' + res.data.file_daftar_hadir);
                    jQuery("#foto_lembur").val('');
                    jQuery("#foto_lembur_existing").html(res.data.foto_lembur);
                    jQuery("#foto_lembur_existing").attr('target', '_blank');
                    jQuery("#foto_lembur_existing").attr('href', '<?php echo WPSIPD_PLUGIN_URL.'public/media/simpeg/'; ?>' + res.data.foto_lembur);
                    jQuery('#modalTambahDataSPJ').modal('show');
                })
            }else{
                alert(res.message);
                jQuery('#wrap-loading').hide();
            }
        }
    });
}

//show tambah data
function tambah_data_spj(){
    jQuery('#id_data').val('').prop('disabled', false);
    jQuery('#id_spj').val('').prop('disabled', false);
    jQuery('#file_daftar_hadir').val('').prop('disabled', false);
    jQuery('#foto_lembur').val('').prop('disabled', false);

    jQuery("#file_daftar_hadir").val('');
    jQuery("#file_daftar_hadir_existing").html('');
    jQuery("#file_daftar_hadir_existing").attr('target', '_blank');
    jQuery("#file_daftar_hadir_existing").attr('href', '');

    jQuery("#foto_lembur").val('');
    jQuery("#foto_lembur_existing").html('');
    jQuery("#foto_lembur_existing").attr('target', '_blank');
    jQuery("#foto_lembur_existing").attr('href', '');
    jQuery('#modalTambahDataSPJ .send_data').show();
    jQuery('#modalTambahDataSPJ').modal('show');
}

function submitTambahDataFormSPJ(){
    var id_data = jQuery('#id_data').val();
    var id_spj = jQuery('#id_spj').val();
    if(id_spj == ''){
        return alert('Pilih id_spj Dulu!');
    }
    var file_daftar_hadir = jQuery('#file_daftar_hadir')[0].files[0];;
    if(typeof file_daftar_hadir == 'undefined'){
        return alert('Upload file file_daftar_hadir dulu!');
    }
    var foto_lembur = jQuery('#foto_lembur')[0].files[0];;
    if(typeof foto_lembur == 'undefined'){
        return alert('Upload file foto_lembur dulu!');
    }

    let tempData = new FormData();
    tempData.append('action', 'tambah_data_spj');
    tempData.append('api_key', '<?php echo get_option( SIMPEG_APIKEY ); ?>');
    tempData.append('id_data', id_data);
    tempData.append('id_spj', id_spj);
    tempData.append('file_daftar_hadir', file_daftar_hadir);
    tempData.append('foto_lembur', foto_lembur);

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
                jQuery('#modalTambahDataSPJ').modal('hide');
                get_data_spj();
            }else{
                jQuery('#wrap-loading').hide();
            }
        }
    });
}
</script>