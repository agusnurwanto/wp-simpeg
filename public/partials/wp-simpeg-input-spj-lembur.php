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
    <h1 class="text-center" style="margin:3rem;">Surat Pertanggungjawaban Lembur</h1>
        <!-- <div style="margin-bottom: 25px;">
            <button class="btn btn-primary" onclick="edit_data_spj_lembur();"><i class="dashicons dashicons-plus"></i> Edit Data</button>
        </div> -->
        <div class="wrap-table">
        <table id="management_data_table" cellpadding="2" cellspacing="0" style="font-family:\'Open Sans\',-apple-system,BlinkMacSystemFont,\'Segoe UI\',sans-serif; border-collapse: collapse; width:100%; overflow-wrap: break-word;" class="table table-bordered">
            <thead>
                <tr>
                    <th class="text-center" style="vertical-align: middle;" rowspan="2">Nomor SPT</th>
                    <th class="text-center" style="vertical-align: middle;" rowspan="2">SKPD</th>
                    <th class="text-center" style="vertical-align: middle;" colspan="2">Waktu SPT</th> 
                    <th class="text-center" style="vertical-align: middle;" rowspan="2">File Daftar Hadir</th>
                    <th class="text-center" style="vertical-align: middle;" rowspan="2">Foto Lembur</th>
                    <th class="text-center" style="vertical-align: middle; width: 30px;" rowspan="2">Aksi</th>
                <tr>
                    <th class="text-center">Waktu Mulai</th>
                    <th class="text-center">Waktu Selesai</th>
                </tr>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
        </div>
    </div>          
</div>

<div class="modal fade mt-4" id="modalEditDataSPJLembur" tabindex="-1" role="dialog" aria-labelledby="modalEditDataSPJLemburLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalEditDataSPJLemburLabel">Data SPJLembur</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <input type='hidden' id='id_data' name="id_data">
                <input type='hidden' id='id_spt' name="id_spt">
                    <div class="form-group">
                        <label>Nomor SPT</label>
                        <input type="text" class="form-control" id="nomor_spt" name="nomor_spt"/>
                    </div>
                    <div class="form-group">
                        <label>Nama SKPD</label>
                        <input type="text" class="form-control" id="id_skpd" name="id_skpd"/>
                    </div>
                    <div class="form-group">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th class="text-center" style="width: 50%;">Tanggal Mulai</th>
                                    <th class="text-center" style="width: 50%;">Tanggal Selesai</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td id="waktu_mulai_spt" class="text-center"></td>
                                    <td id="waktu_selesai_spt" class="text-center"></td>
                                </tr>
                            </tbody>
                        </table>
                <div class="form-group">
                    <label for="">Daftar Hadir</label>
                    <input type="file" name="file" class="form-control-file" id="file_daftar_hadir" accept="image/*,.pdf">
                    <small>Tipe file adalah .jpg .jpeg .png .pdf dengan maksimal ukuran 1MB.</small>
                    <div style="padding-top: 10px; padding-bottom: 10px;"><a id="file_daftar_hadir_existing"></a></div>
                </div>
                <div class="form-group">
                    <label for="">Foto Lembur</label>
                    <input type="file" name="file" class="form-control-file" id="foto_lembur" accept="image/*,.pdf">
                    <small>Tipe file adalah .jpg .jpeg .png .pdf dengan maksimal ukuran 1MB.</small>
                    <div style="padding-top: 10px; padding-bottom: 10px;"><a id="foto_lembur_existing"></a></div>
                </div>
            <div class="modal-footer">
                <button class="btn btn-primary submitBtn" onclick="submitEditDataFormSPJLembur()">Simpan</button>
                <button type="submit" class="components-button btn btn-secondary" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
<script>    
jQuery(document).ready(function(){
    // penyesuaian thema wp full width page
    jQuery('.mg-card-box').parent().removeClass('col-md-8').addClass('col-md-12');
    jQuery('#secondary').parent().remove();
    
    get_data_spj_by_id();
    window.path_file = '<?php echo SIMPEG_PLUGIN_URL.'public/media/simpeg/'; ?>';
});

function get_data_spj_by_id(){
    if(typeof dataspj_lembur == 'undefined'){
        window.dataspj_lembur = jQuery('#management_data_table').on('preXhr.dt', function(e, settings, data){
            jQuery("#wrap-loading").show();
        }).DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": {
                url: '<?php echo admin_url('admin-ajax.php'); ?>',
                type: 'post',
                dataType: 'json',
                data:{
                    'action': 'get_datatable_spj_lembur',
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
                    "data": 'nomor_spt',
                    className: "text-center"
                },
                {
                    "data": 'nama_skpd',
                    className: "text-center"
                },
                {
                    "data": 'waktu_mulai_spt',
                    className: "text-center"
                },
                {
                    "data": 'waktu_selesai_spt',
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
        dataspj_lembur.draw();
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
                    get_data_spj_by_id(); 
                }else{
                    alert(`GAGAL! \n${response.message}`);
                }
            }
        });
    }
}

function submit_data(id_spt){
    if(confirm('Apakah anda yakin untuk mengirim data ini ke proses selanjutnya?')){
        jQuery('#wrap-loading').show();
        jQuery.ajax({
            method: 'post',
            url: '<?php echo admin_url('admin-ajax.php'); ?>',
            dataType: 'json',
            data:{
                'action': 'verifikasi_spj_lembur',
                'api_key': jQuery('#api_key').val(),
                'data': JSON.stringify({
                'id_data': id_spt
                })
            },
            success: function(res){
                jQuery('#wrap-loading').hide();
                alert(res.message);
                if(res.status == 'success'){
                    get_data_spj_lembur();
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
                jQuery('#id_spt').val(res.data.id_spt);
                jQuery('#id_data').val(res.data.id);
                jQuery('#nomor_spt').val(res.data.nomor_spt).prop('disabled', true);
                jQuery('#id_skpd').val(res.data.nama_skpd).prop('disabled', true);
                jQuery('#waktu_mulai_spt').html(res.data.waktu_mulai_spt);
                jQuery('#waktu_selesai_spt').html(res.data.waktu_selesai_spt);
                jQuery('#file_daftar_hadir_existing').html(res.data.file_daftar_hadir).attr('href', path_file+res.data.file_daftar_hadir);
                jQuery('#foto_lembur_existing').html(res.data.foto_lembur).attr('href', path_file+res.data.foto_lembur);
                jQuery('#modalEditDataSPJLembur').modal('show');
            }else{
                alert(res.message);
            }
            jQuery('#wrap-loading').hide();
        }
    });
}

//show Edit data
function edit_data_spj_lembur(){
    jQuery('#id_data').val('').prop('disabled', false);
    jQuery('#id_spt').val('').prop('disabled', false);
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
    jQuery('#modalEditDataSPJLembur').modal('show');
}

function submitEditDataFormSPJLembur(){
    var id_data = jQuery('#id_data').val();
    var id_spt = jQuery('#id_spt').val();
    if(id_spt == ''){
        return alert('ID SPT tidak boleh kosong!');
    }
    var file_daftar_hadir = jQuery('#file_daftar_hadir')[0].files[0];;
    if(typeof file_daftar_hadir == 'undefined'){
        return alert('Upload daftar hadir dulu!');
    }
    var foto_lembur = jQuery('#foto_lembur')[0].files[0];;
    if(typeof foto_lembur == 'undefined'){
        return alert('Upload foto lembur dulu!');
    }

    jQuery('#wrap-loading').show();
    let tempData = new FormData();
    tempData.append('action', 'edit_data_spj_lembur');
    tempData.append('api_key', '<?php echo get_option(SIMPEG_APIKEY); ?>');
    tempData.append('id_data', id_data);
    tempData.append('id_spt', id_spt);
    tempData.append('file_daftar_hadir', file_daftar_hadir);
    tempData.append('foto_lembur', foto_lembur);
    jQuery.ajax({
        method: 'post',
        url: '<?php echo admin_url('admin-ajax.php'); ?>',
        dataType: 'json',
        data: tempData,
        processData: false,
        contentType: false,
        cache: false,
        success: function(res){
            jQuery('#wrap-loading').hide();
            alert(res.message);
            if(res.status == 'success'){
                jQuery('#modalEditDataSPJLembur').modal('hide');
                get_data_spj_by_id();
            }
        }
    });
}
</script>