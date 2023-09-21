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
    <h1 class="text-center" style="margin:3rem;">Manajemen Data Pegawai</h1>
        <div style="margin-bottom: 25px;">
            <button class="btn btn-primary" onclick="tambah_data_pegawai();"><i class="dashicons dashicons-plus"></i> Tambah Data</button>
        </div>
        <div class="wrap-table">
        <table id="management_data_table" cellpadding="2" cellspacing="0" style="font-family:\'Open Sans\',-apple-system,BlinkMacSystemFont,\'Segoe UI\',sans-serif; border-collapse: collapse; width:100%; overflow-wrap: break-word;" class="table table-bordered">
            <thead>
                <tr>
                    <th class="text-center">Id SKPD</th>
                    <th class="text-center">NIK</th>
                    <th class="text-center">NIP</th>
                    <th class="text-center">Nama</th>
                    <th class="text-center">Tanggal Lahir</th>
                    <th class="text-center">Tempat Lahir</th>
                    <th class="text-center">Status</th>
                    <th class="text-center">Golongan Ruang</th>
                    <th class="text-center">TMT Pangkat</th>
                    <th class="text-center">Eselon</th>
                    <th class="text-center">Jabatan</th>
                    <th class="text-center">Tipe Pegawai</th>
                    <th class="text-center">TMT Jabatan</th>
                    <th class="text-center">Agama</th>
                    <th class="text-center">Alamat</th>
                    <th class="text-center">No Handphone</th>
                    <th class="text-center">Satuan Kerja</th>
                    <th class="text-center">Unit Kerja Induk</th>
                    <th class="text-center">TMT Pensiun</th>
                    <th class="text-center">Pendidikan</th>
                    <th class="text-center">Kode Pendidikan</th>
                    <th class="text-center">Nama Sekolah</th>
                    <th class="text-center">Nama Pendidikan</th>
                    <th class="text-center">Lulus</th>
                    <th class="text-center">Kartu Pekerja</th>
                    <th class="text-center">Karis / Karsu</th>
                    <th class="text-center">Nilai Prestasi</th>
                    <th class="text-center">Email</th>
                    <th class="text-center">Tahun</th>
                    <th class="text-center">User</th>
                    <th class="text-center" style="width: 150px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
        </div>
    </div>          
</div>

<div class="modal fade mt-4" id="modalTambahDataPegawai" tabindex="-1" role="dialog" aria-labelledby="modalTambahDataPegawaiLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTambahDataPegawaiLabel">Data Pegawai</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <input type='hidden' id='id_data' name="id_data" placeholder=''>
                <div class="form-group">
                    <label for='id_skpd' style='display:inline-block'>Id SKPD</label>
                    <input type="text" id='id_skpd' name="id_skpd" class="form-control" placeholder=''/>
                </div>
                <div class="form-group">
                    <label for='nik' style='display:inline-block'>Id nama</label>
                    <input type='text' id='nik' name="nik" class="form-control" placeholder=''>
                </div>
                <div class="form-group">
                    <label for='nip' style='display:inline-block'>NIP</label>
                    <input type="text" id='nip' name="nip" class="form-control" placeholder=''/>
                </div>
                <div class="form-group">
                    <label for='nama' style='display:inline-block'>Nama</label>
                    <input type="text" id='nama' name="nama" class="form-control" placeholder=''/>
                </div>
                <div class="form-group">
                    <label for='tanggal_lahir' style='display:inline-block'>Tanggal Lahir</label>
                    <input type="text" id='tanggal_lahir' name="tanggal_lahir" class="form-control" placeholder=''/>
                </div>
                <div class="form-group">
                    <label for='tempat_lahir' style='display:inline-block'>Tempat Lahir</label>
                    <input type="text" id='tempat_lahir' name="tempat_lahir" class="form-control" placeholder=''/>
                </div>
                <div class="form-group">
                    <label for='status' style='display:inline-block'>Status</label>
                    <input type="text" id='status' name="status" class="form-control" placeholder=''/>
                </div>
                <div class="form-group">
                    <label for='gol_ruang' style='display:inline-block'>Golongan Ruang</label>
                    <input type="text" id='gol_ruang' name="gol_ruang" class="form-control" placeholder=''/>
                </div>
                <div class="form-group">
                    <label for='tmt_pangkat' style='display:inline-block'>TMT Pangkat</label>
                    <input type="text" id='tmt_pangkat' name="tmt_pangkat" class="form-control" placeholder=''/>
                </div>
                <div class="form-group">
                    <label for='eselon' style='display:inline-block'>Eselon</label>
                    <input type="text" id='eselon' name="eselon" class="form-control" placeholder=''/>
                </div>
                <div class="form-group">
                    <label for='jabatan' style='display:inline-block'>Jabatan</label>
                    <input type="text" id='jabatan' name="jabatan" class="form-control" placeholder=''/>
                </div>
                <div class="form-group">
                    <label for='tipe_pegawai' style='display:inline-block'>Tipe Pegawai</label>
                    <input type="text" id='tipe_pegawai' name="tipe_pegawai" class="form-control" placeholder=''/>
                </div>
                <div class="form-group">
                    <label for='tmt_jabatan' style='display:inline-block'>TMT Jabatan</label>
                    <input type="text" id='tmt_jabatan' name="tmt_jabatan" class="form-control" placeholder=''/>
                </div>
                <div class="form-group">
                    <label for='agama' style='display:inline-block'>Agama</label>
                    <input type="text" id='agama' name="agama" class="form-control" placeholder=''/>
                </div>
                <div class="form-group">
                    <label for='alamat' style='display:inline-block'>Alamat</label>
                    <input type="text" id='alamat' name="alamat" class="form-control" placeholder=''/>
                </div>
                <div class="form-group">
                    <label for='no_hp' style='display:inline-block'>No Handphone</label>
                    <input type="text" id='no_hp' name="no_hp" class="form-control" placeholder=''/>
                </div>
                <div class="form-group">
                    <label for='satuan_kerja' style='display:inline-block'>Satuan Kerja</label>
                    <input type="text" id='satuan_kerja' name="satuan_kerja" class="form-control" placeholder=''/>
                </div>
                <div class="form-group">
                    <label for='unit_kerja_induk' style='display:inline-block'>Unit Kerja Induk</label>
                    <input type="text" id='unit_kerja_induk' name="unit_kerja_induk" class="form-control" placeholder=''/>
                </div>
                <div class="form-group">
                    <label for='tmt_pensiun' style='display:inline-block'>TMT Pensiun</label>
                    <input type="text" id='tmt_pensiun' name="tmt_pensiun" class="form-control" placeholder=''/>
                </div>
                <div class="form-group">
                    <label for='pendidikan' style='display:inline-block'>Pendidikan</label>
                    <input type="text" id='pendidikan' name="pendidikan" class="form-control" placeholder=''/>
                </div>
                <div class="form-group">
                    <label for='kode_pendidikan' style='display:inline-block'>Kode Pendidikan</label>
                    <input type="text" id='kode_pendidikan' name="kode_pendidikan" class="form-control" placeholder=''/>
                </div>
                <div class="form-group">
                    <label for='nama_sekolah' style='display:inline-block'>Nama Sekolah</label>
                    <input type="text" id='nama_sekolah' name="nama_sekolah" class="form-control" placeholder=''/>
                </div>
                <div class="form-group">
                    <label for='nama_pendidikan' style='display:inline-block'>Nama Pendidikan</label>
                    <input type="text" id='nama_pendidikan' name="nama_pendidikan" class="form-control" placeholder=''/>
                </div>
                <div class="form-group">
                    <label for='lulus' style='display:inline-block'>Lulus</label>
                    <input type="text" id='lulus' name="lulus" class="form-control" placeholder=''/>
                </div>
                <div class="form-group">
                    <label for='karpeg' style='display:inline-block'>Kartu Pegawai</label>
                    <input type="text" id='karpeg' name="karpeg" class="form-control" placeholder=''/>
                </div>
                <div class="form-group">
                    <label for='karis_karsu' style='display:inline-block'>Karis / Karsu</label>
                    <input type="text" id='karis_karsu' name="karis_karsu" class="form-control" placeholder=''/>
                </div>
                <div class="form-group">
                    <label for='nilai_prestasi' style='display:inline-block'>Nilai Prestasi</label>
                    <input type="text" id='nilai_prestasi' name="nilai_prestasi" class="form-control" placeholder=''/>
                </div>
                <div class="form-group">
                    <label for='email' style='display:inline-block'>Email</label>
                    <input type="text" id='email' name="email" class="form-control" placeholder=''/>
                </div>
                <div class="form-group">
                    <label for='tahun' style='display:inline-block'>Tahun</label>
                    <input type="text" id='tahun' name="tahun" class="form-control" placeholder=''/>
                </div>
                <div class="form-group">
                    <label for='user_role' style='display:inline-block'>User</label>
                    <input type="text" id='user_role' name="user_role" class="form-control" placeholder=''/>
                </div>
            </div> 
            <div class="modal-footer">
                <button class="btn btn-primary submitBtn" onclick="submitTambahDataFormPegawai()">Simpan</button>
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
    get_data_pegawai();
});

function get_data_pegawai(){
    if(typeof datapegawai == 'undefined'){
        window.datapegawai = jQuery('#management_data_table').on('preXhr.dt', function(e, settings, data){
            jQuery("#wrap-loading").show();
        }).DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": {
                url: '<?php echo admin_url('admin-ajax.php'); ?>',
                type: 'post',
                dataType: 'json',
                data:{
                    'action': 'get_datatable_pegawai',
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
                    "data": 'nik',
                    className: "text-center"
                },
                {
                    "data": 'nip',
                    className: "text-center"
                },
                {
                    "data": 'nama',
                    className: "text-center"
                },
                {
                    "data": 'tempat_lahir',
                    className: "text-center"
                },
                {
                    "data": 'tanggal_lahir',
                    className: "text-center"
                },
                {
                    "data": 'status',
                    className: "text-center"
                },
                {
                    "data": 'gol_ruang',
                    className: "text-center"
                },
                {
                    "data": 'tmt_pangkat',
                    className: "text-center"
                },
                {
                    "data": 'eselon',
                    className: "text-center"
                },
                {
                    "data": 'jabatan',
                    className: "text-center"
                },
                {
                    "data": 'tipe_pegawai',
                    className: "text-center"
                },
                {
                    "data": 'tmt_jabatan',
                    className: "text-center"
                },
                {
                    "data": 'agama',
                    className: "text-center"
                },
                {
                    "data": 'alamat',
                    className: "text-center"
                },
                {
                    "data": 'no_hp',
                    className: "text-center"
                },
                {
                    "data": 'satuan_kerja',
                    className: "text-center"
                },
                {
                    "data": 'unit_kerja_induk',
                    className: "text-center"
                },
                {
                    "data": 'tmt_pensiun',
                    className: "text-center"
                },
                {
                    "data": 'pendidikan',
                    className: "text-center"
                },
                {
                    "data": 'kode_pendidikan',
                    className: "text-center"
                },
                {
                    "data": 'nama_sekolah',
                    className: "text-center"
                },
                {
                    "data": 'nama_pendidikan',
                    className: "text-center"
                },
                {
                    "data": 'lulus',
                    className: "text-center"
                },
                {
                    "data": 'karpeg',
                    className: "text-center"
                },
                {
                    "data": 'karis_karsu',
                    className: "text-center"
                },
                {
                    "data": 'nilai_prestasi',
                    className: "text-center"
                },
                {
                    "data": 'email',
                    className: "text-center"
                },
                {
                    "data": 'tahun',
                    className: "text-center"
                },
                {
                    "data": 'user_role',
                    className: "text-center"
                },
                {
                    "data": 'aksi',
                    className: "text-center"
                }
            ]
        });
    }else{
        datapegawai.draw();
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
                'action' : 'hapus_data_pegawai_by_id',
                'api_key': '<?php echo get_option( SIMPEG_APIKEY ); ?>',
                'id'     : id
            },
            dataType: 'json',
            success:function(response){
                jQuery('#wrap-loading').hide();
                if(response.status == 'success'){
                    get_data_pegawai(); 
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
            'action': 'get_data_pegawai_by_id',
            'api_key': '<?php echo get_option( SIMPEG_APIKEY ); ?>',
            'id': _id,
        },
        success: function(res){
            if(res.status == 'success'){
                jQuery('#id_data').val(res.data.id);
                jQuery('#id_skpd').val(res.data.id_skpd);
                jQuery('#nik').val(res.data.nik);
                jQuery('#nip').val(res.data.nip);
                jQuery('#nama').val(res.data.nama);
                jQuery('#tempat_lahir').val(res.data.tempat_lahir);
                jQuery('#tanggal_lahir').val(res.data.tanggal_lahir);
                jQuery('#status').val(res.data.status);
                jQuery('#gol_ruang').val(res.data.gol_ruang);
                jQuery('#tmt_pangkat').val(res.data.tmt_pangkat);
                jQuery('#eselon').val(res.data.eselon);
                jQuery('#jabatan').val(res.data.jabatan);
                jQuery('#tipe_pegawai').val(res.data.tipe_pegawai);
                jQuery('#tmt_jabatan').val(res.data.tmt_jabatan);
                jQuery('#agama').val(res.data.agama);
                jQuery('#alamat').val(res.data.alamat);
                jQuery('#no_hp').val(res.data.no_hp);
                jQuery('#satuan_kerja').val(res.data.satuan_kerja);
                jQuery('#unit_kerja_induk').val(res.data.unit_kerja_induk);
                jQuery('#tmt_pensiun').val(res.data.tmt_pensiun);
                jQuery('#pendidikan').val(res.data.pendidikan);
                jQuery('#kode_pendidikan').val(res.data.kode_pendidikan);
                jQuery('#nama_sekolah').val(res.data.nama_sekolah);
                jQuery('#nama_pendidikan').val(res.data.nama_pendidikan);
                jQuery('#lulus').val(res.data.lulus);
                jQuery('#karpeg').val(res.data.karpeg);
                jQuery('#karis_karsu').val(res.data.karis_karsu);
                jQuery('#nilai_prestasi').val(res.data.nilai_prestasi);
                jQuery('#email').val(res.data.email);
                jQuery('#tahun').val(res.data.tahun);
                jQuery('#user_role').val(res.data.user_role);
                jQuery('#modalTambahDataPegawai').modal('show');
            }else{
                alert(res.message);
            }
            jQuery('#wrap-loading').hide();
        }
    });
}

//show tambah data
function tambah_data_pegawai(){
    jQuery('#id_data').val('');
    jQuery('#id_skpd').val('');
    jQuery('#nik').val('');
    jQuery('#nip').val('');
    jQuery('#nama').val('');
    jQuery('#tempat_lahir').val('');
    jQuery('#tanggal_lahir').val('');
    jQuery('#status').val('');
    jQuery('#gol_ruang').val('');
    jQuery('#tmt_pangkat').val('');
    jQuery('#eselon').val('');
    jQuery('#jabatan').val('');
    jQuery('#tipe_pegawai').val('');
    jQuery('#tmt_jabatan').val('');
    jQuery('#agama').val('');
    jQuery('#alamat').val('');
    jQuery('#no_hp').val('');
    jQuery('#satuan_kerja').val('');
    jQuery('#unit_kerja_induk').val('');
    jQuery('#tmt_pensiun').val('');
    jQuery('#pendidikan').val('');
    jQuery('#kode_pendidikan').val('');
    jQuery('#nama_sekolah').val('');
    jQuery('#nama_pendidikan').val('');
    jQuery('#lulus').val('');
    jQuery('#karpeg').val('');
    jQuery('#karis_karsu').val('');
    jQuery('#nilai_prestasi').val('');
    jQuery('#email').val('');
    jQuery('#tahun').val('');
    jQuery('#user_role').val('');
    jQuery('#modalTambahDataPegawai').modal('show');
}

function submitTambahDataFormPegawai(){
    var id_data = jQuery('#id_data').val();
    var nik = jQuery('#nik').val();
    if(nik == ''){
        return alert('Data nik tidak boleh kosong!');
    }
    var nama = jQuery('#nama').val();
    if(nama == ''){
        return alert('Data nama tidak boleh kosong!');
    }
    var nip = jQuery('#nip').val();
    if(nip == ''){
        return alert('Data nip tidak boleh kosong!');
    }
    var id_skpd = jQuery('#id_skpd').val();
    if(id_skpd == ''){
        return alert('Data id_skpd tidak boleh kosong!');
    }
    var tempat_lahir = jQuery('#tempat_lahir').val();
    if(tempat_lahir == ''){
        return alert('Data tempat_lahir tidak boleh kosong!');
    }
    var tanggal_lahir = jQuery('#tanggal_lahir').val();
    if(tanggal_lahir == ''){
        return alert('Data tanggal_lahir tidak boleh kosong!');
    }
    var status = jQuery('#status').val();
    if(status == ''){
        return alert('Data status tidak boleh kosong!');
    }
    var gol_ruang = jQuery('#gol_ruang').val();
    if(gol_ruang == ''){
        return alert('Data gol_ruang tidak boleh kosong!');
    }
    var tmt_pangkat = jQuery('#tmt_pangkat').val();
    if(tmt_pangkat == ''){
        return alert('Data tmt_pangkat tidak boleh kosong!');
    }
    var eselon = jQuery('#eselon').val();
    if(eselon == ''){
        return alert('Data eselon tidak boleh kosong!');
    }
    var jabatan = jQuery('#jabatan').val();
    if(jabatan == ''){
        return alert('Data jabatan tidak boleh kosong!');
    }
    var tipe_pegawai = jQuery('#tipe_pegawai').val();
    if(tipe_pegawai == ''){
        return alert('Data tipe_pegawai tidak boleh kosong!');
    }
    var tmt_jabatan = jQuery('#tmt_jabatan').val();
    if(tmt_jabatan == ''){
        return alert('Data tmt_jabatan tidak boleh kosong!');
    }
    var agama = jQuery('#agama').val();
    if(agama == ''){
        return alert('Data agama tidak boleh kosong!');
    }
    var alamat = jQuery('#alamat').val();
    if(alamat == ''){
        return alert('Data alamat tidak boleh kosong!');
    }
    var no_hp = jQuery('#no_hp').val();
    if(no_hp == ''){
        return alert('Data no_hp tidak boleh kosong!');
    }
    var satuan_kerja = jQuery('#satuan_kerja').val();
    if(satuan_kerja == ''){
        return alert('Data satuan_kerja tidak boleh kosong!');
    }
    var unit_kerja_induk = jQuery('#unit_kerja_induk').val();
    if(unit_kerja_induk == ''){
        return alert('Data unit_kerja_induk tidak boleh kosong!');
    }
    var tmt_pensiun = jQuery('#tmt_pensiun').val();
    if(tmt_pensiun == ''){
        return alert('Data tmt_pensiun tidak boleh kosong!');
    }
    var pendidikan = jQuery('#pendidikan').val();
    if(pendidikan == ''){
        return alert('Data pendidikan tidak boleh kosong!');
    }
    var kode_pendidikan = jQuery('#kode_pendidikan').val();
    if(kode_pendidikan == ''){
        return alert('Data kode_pendidikan tidak boleh kosong!');
    }
    var nama_sekolah = jQuery('#nama_sekolah').val();
    if(nama_sekolah == ''){
        return alert('Data nama_sekolah tidak boleh kosong!');
    }
    var nama_pendidikan = jQuery('#nama_pendidikan').val();
    if(nama_pendidikan == ''){
        return alert('Data nama_pendidikan tidak boleh kosong!');
    }
    var lulus = jQuery('#lulus').val();
    if(lulus == ''){
        return alert('Data lulus tidak boleh kosong!');
    }
    var karpeg = jQuery('#karpeg').val();
    if(karpeg == ''){
        return alert('Data karpeg tidak boleh kosong!');
    }
    var karis_karsu = jQuery('#karis_karsu').val();
    if(karis_karsu == ''){
        return alert('Data karis_karsu tidak boleh kosong!');
    }
    var nilai_prestasi = jQuery('#nilai_prestasi').val();
    if(nilai_prestasi == ''){
        return alert('Data nilai_prestasi tidak boleh kosong!');
    }
    var email = jQuery('#email').val();
    if(email == ''){
        return alert('Data email tidak boleh kosong!');
    }
    var tahun = jQuery('#tahun').val();
    if(tahun == ''){
        return alert('Data tahun tidak boleh kosong!');
    }
    var user_role = jQuery('#user_role').val();
    if(user_role == ''){
        return alert('Data User tidak boleh kosong!');
    }

    jQuery('#wrap-loading').show();
    jQuery.ajax({
        method: 'post',
        url: '<?php echo admin_url('admin-ajax.php'); ?>',
        dataType: 'json',
        data:{
            'action': 'tambah_data_pegawai',
            'api_key': '<?php echo get_option( SIMPEG_APIKEY ); ?>',
            'id_data': id_data,
            'id_skpd': id_skpd,
            'nik': nik,
            'nip': nip,
            'nama': nama,
            'tempat_lahir': tempat_lahir,
            'tanggal_lahir': tanggal_lahir,
            'status': status,
            'gol_ruang': gol_ruang,
            'tmt_pangkat': tmt_pangkat,
            'eselon': eselon,
            'jabatan': jabatan,
            'tipe_pegawai': tipe_pegawai,
            'tmt_jabatan': tmt_jabatan,
            'agama': agama,
            'alamat': alamat,
            'no_hp': no_hp,
            'satuan_kerja': satuan_kerja,
            'unit_kerja_induk': unit_kerja_induk,
            'tmt_pensiun': tmt_pensiun,
            'pendidikan': pendidikan,
            'kode_pendidikan': kode_pendidikan,
            'nama_sekolah': nama_sekolah,
            'nama_pendidikan': nama_pendidikan,
            'lulus': lulus,
            'karpeg': karpeg,
            'karis_karsu': karis_karsu,
            'nilai_prestasi': nilai_prestasi,
            'email': email,
            'tahun': tahun,
            'user_role': user_role,
        },
        success: function(res){
            alert(res.message);
            jQuery('#modalTambahDataPegawai').modal('hide');
            if(res.status == 'success'){
                get_data_pegawai();
            }else{
                jQuery('#wrap-loading').hide();
            }
        }
    });
}
</script>