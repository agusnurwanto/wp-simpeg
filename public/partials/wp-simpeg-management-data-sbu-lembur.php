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
    <h1 class="text-center" style="margin:3rem;">Manajemen Data SBU Lembur</h1>
        <div style="margin-bottom: 25px;">
            <button class="btn btn-primary" onclick="tambah_data_sbu_lembur();"><i class="dashicons dashicons-plus"></i> Tambah Data</button>
        </div>
        <div class="wrap-table">
        <table id="management_data_table" cellpadding="2" cellspacing="0" style="font-family:\'Open Sans\',-apple-system,BlinkMacSystemFont,\'Segoe UI\',sans-serif; border-collapse: collapse; width:100%; overflow-wrap: break-word;" class="table table-bordered">
            <thead>
                <tr>
                    <th class="text-center">Kode Standar Harga</th>
                    <th class="text-center">No Aturan</th>
                    <th class="text-center">Nama</th>
                    <th class="text-center">Uraian</th>
                    <th class="text-center">Satuan</th>
                    <th class="text-center">Harga</th>
                    <th class="text-center">Id Golongan</th>
                    <th class="text-center">Jenis Hari</th>
                    <th class="text-center">PPH 21</th>
                    <!-- <th class="text-center">Tahun</th> -->
                    <th class="text-center" style="width: 150px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
        </div>
    </div>          
</div>

<div class="modal fade mt-4" id="modalTambahDataSBULembur" tabindex="-1" role="dialog" aria-labelledby="modalTambahDataSBULemburLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTambahDataSBULemburLabel">Data SBULembur</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <input type='hidden' id='id_data' name="id_data" placeholder=''>
                <div class="form-group">
                    <label for='kode_standar_harga' style='display:inline-block'>Kode Standar Harga</label>
                    <input type="text" id='kode_standar_harga' name="kode_standar_harga" class="form-control" placeholder=''/>
                </div>
                <div class="form-group">
                    <label for='no_aturan' style='display:inline-block'>No Aturan</label>
                    <input type='text' id='no_aturan' name="no_aturan" class="form-control" placeholder=''>
                </div>
                <div class="form-group">
                    <label for='nama' style='display:inline-block'>Nama</label>
                    <input type="text" id='nama' name="nama" class="form-control" placeholder=''/>
                </div>
                <div class="form-group">
                    <label for='uraian' style='display:inline-block'>Uraian</label>
                    <input type="text" id='uraian' name="uraian" class="form-control" placeholder=''/>
                </div>
                <div class="form-group">
                    <label for='satuan' style='display:inline-block'>Satuan</label>
                    <input type="text" id='satuan' name="satuan" class="form-control" placeholder=''/>
                </div>
                <div class="form-group">
                    <label for='harga' style='display:inline-block'>Harga</label>
                    <input type="text" id='harga' name="harga" class="form-control" placeholder=''/>
                </div>
                <div class="form-group">
                    <label for='id_golongan' style='display:inline-block'>Id Golongan</label>
                    <input type="text" id='id_golongan' name="id_golongan" class="form-control" placeholder=''/>
                </div>
                <div class="form-group">
                    <label for='jenis_hari' style='display:inline-block'>Jenis Hari</label>
                    <input type="text" id='jenis_hari' name="jenis_hari" class="form-control" placeholder=''/>
                </div>
                <div class="form-group">
                    <label for='pph_21' style='display:inline-block'>PPH 21</label>
                    <input type="text" id='pph_21' name="pph_21" class="form-control" placeholder=''/>
                </div>
<!--                 <div class="form-group">
                    <label for='tahun' style='display:inline-block'>Tahun</label>
                    <input type="text" id='tahun' name="tahun" class="form-control" placeholder=''/>
                </div> -->
            </div> 
            <div class="modal-footer">
                <button class="btn btn-primary submitBtn" onclick="submitTambahDataFormSBULembur()">Simpan</button>
                <button type="submit" class="components-button btn btn-secondary" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
<!-- <div style="max-width: 10000px; margin: auto;">
    <h5>Keterangan:</h5>
    <ul>
        <li>Berdasarkan Id Golongan:    
            <br>1. Golongan I harga 26,000.00
            <br>2. Golongan II harga  34,000.00 
            <br>3. Golongan III harga 40,000.00
            <br>4. Golongan IV harga 50,000.00
            <br>5. Golongan V harga 26,000.00
    </ul>
    </ul>
</div> -->
<script>    
jQuery(document).ready(function(){
    get_data_sbu_lembur();
});

function get_data_sbu_lembur(){
    if(typeof datasbulembur == 'undefined'){
        window.datasbulembur = jQuery('#management_data_table').on('preXhr.dt', function(e, settings, data){
            jQuery("#wrap-loading").show();
        }).DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": {
                url: '<?php echo admin_url('admin-ajax.php'); ?>',
                type: 'post',
                dataType: 'json',
                data:{
                    'action': 'get_datatable_sbu_lembur',
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
                    "data": 'kode_standar_harga',
                    className: "text-center"
                },
                {
                    "data": 'no_aturan',
                    className: "text-center"
                },
                {
                    "data": 'nama',
                    className: "text-center"
                },
                {
                    "data": 'uraian',
                    className: "text-center"
                },
                {
                    "data": 'satuan',
                    className: "text-center"
                },
                {
                    "data": 'harga',
                    className: "text-center"
                },
                {
                    "data": 'id_golongan',
                    className: "text-center"
                },
                {
                    "data": 'jenis_hari',
                    className: "text-center"
                },
                {
                    "data": 'pph_21',
                    className: "text-center"
                },
                // {
                //     "data": 'tahun',
                //     className: "text-center"
                // },
                {
                    "data": 'aksi',
                    className: "text-center"
                }
            ]
        });
    }else{
        datasbulembur.draw();
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
                'action' : 'hapus_data_sbu_lembur_by_id',
                'api_key': '<?php echo get_option( SIMPEG_APIKEY ); ?>',
                'id'     : id
            },
            dataType: 'json',
            success:function(response){
                jQuery('#wrap-loading').hide();
                if(response.status == 'success'){
                    get_data_sbu_lembur(); 
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
            'action': 'get_data_sbu_lembur_by_id',
            'api_key': '<?php echo get_option( SIMPEG_APIKEY ); ?>',
            'id': _id,
        },
        success: function(res){
            if(res.status == 'success'){
                jQuery('#id_data').val(res.data.id);
                jQuery('#kode_standar_harga').val(res.data.kode_standar_harga);
                jQuery('#no_aturan').val(res.data.no_aturan);
                jQuery('#nama').val(res.data.nama);
                jQuery('#uraian').val(res.data.uraian);
                jQuery('#satuan').val(res.data.satuan);
                jQuery('#harga').val(res.data.harga);
                jQuery('#id_golongan').val(res.data.id_golongan);
                jQuery('#jenis_hari').val(res.data.jenis_hari);
                jQuery('#pph_21').val(res.data.pph_21);
                // jQuery('#tahun').val(res.data.tahun);
                jQuery('#modalTambahDataSBULembur').modal('show');
            }else{
                alert(res.message);
            }
            jQuery('#wrap-loading').hide();
        }
    });
}

//show tambah data
function tambah_data_sbu_lembur(){
    jQuery('#id_data').val('');
    jQuery('#kode_standar_harga').val('');
    jQuery('#no_aturan').val('');
    jQuery('#nama').val('');
    jQuery('#uraian').val('');
    jQuery('#satuan').val('');
    jQuery('#harga').val('');
    jQuery('#id_golongan').val('');
    jQuery('#jenis_hari').val('');
    jQuery('#pph_21').val('');
    // jQuery('#tahun').val('');
    jQuery('#modalTambahDataSBULembur').modal('show');
}

function submitTambahDataFormSBULembur(){
    var id_data = jQuery('#id_data').val();
    var no_aturan = jQuery('#no_aturan').val();
    if(no_aturan == ''){
        return alert('Data no_aturan tidak boleh kosong!');
    }
    var uraian = jQuery('#uraian').val();
    if(uraian == ''){
        return alert('Data uraian tidak boleh kosong!');
    }
    var nama = jQuery('#nama').val();
    if(nama == ''){
        return alert('Data nama tidak boleh kosong!');
    }
    var kode_standar_harga = jQuery('#kode_standar_harga').val();
    if(kode_standar_harga == ''){
        return alert('Data kode_standar_harga tidak boleh kosong!');
    }
    var satuan = jQuery('#satuan').val();
    if(satuan == ''){
        return alert('Data satuan tidak boleh kosong!');
    }
    var harga = jQuery('#harga').val();
    if(harga == ''){
        return alert('Data harga tidak boleh kosong!');
    }
    var id_golongan = jQuery('#id_golongan').val();
    if(id_golongan == ''){
        return alert('Data Id Golongan tidak boleh kosong!');
    }
    var jenis_hari = jQuery('#jenis_hari').val();
    if(jenis_hari == ''){
        return alert('Data jenis_hari tidak boleh kosong!');
    }
    var pph_21 = jQuery('#pph_21').val();
    if(pph_21 == ''){
        return alert('Data pph_21 tidak boleh kosong!');
    }
    // var tahun = jQuery('#tahun').val();
    // if(tahun == ''){
    //     return alert('Data tahun tidak boleh kosong!');
    // }

    jQuery('#wrap-loading').show();
    jQuery.ajax({
        method: 'post',
        url: '<?php echo admin_url('admin-ajax.php'); ?>',
        dataType: 'json',
        data:{
            'action': 'tambah_data_sbu_lembur',
            'api_key': '<?php echo get_option( SIMPEG_APIKEY ); ?>',
            'id_data': id_data,
            'kode_standar_harga': kode_standar_harga,
            'no_aturan': no_aturan,
            'nama': nama,
            'uraian': uraian,
            'satuan': satuan,
            'harga': harga,
            'id_golongan': id_golongan,
            'jenis_hari': jenis_hari,
            'pph_21': pph_21,
            // 'tahun': tahun,
        },
        success: function(res){
            alert(res.message);
            jQuery('#modalTambahDataSBULembur').modal('hide');
            if(res.status == 'success'){
                get_data_sbu_lembur();
            }else{
                jQuery('#wrap-loading').hide();
            }
        }
    });
}
</script>