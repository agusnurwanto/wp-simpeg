CREATE TABLE `data_unit_lembur` (
  `id` int(11) NOT NULL auto_increment,
  `id_setup_unit` int(11) DEFAULT NULL,
  `id_unit` int(11) DEFAULT NULL,
  `is_skpd` tinyint(4) DEFAULT NULL,
  `kode_skpd` varchar(50) DEFAULT NULL,
  `kunci_skpd` int(11) DEFAULT NULL,
  `nama_skpd` text DEFAULT NULL,
  `posisi` varchar(30) DEFAULT NULL,
  `status` varchar(30) DEFAULT NULL,
  `id_skpd` int(11) DEFAULT NULL,
  `bidur_1` smallint(6) DEFAULT NULL,
  `bidur_2` smallint(6) DEFAULT NULL,
  `bidur_3` smallint(6) DEFAULT NULL,
  `idinduk` int(11) DEFAULT NULL,
  `ispendapatan` tinyint(4) DEFAULT NULL,
  `isskpd` tinyint(4) DEFAULT NULL,
  `kode_skpd_1` varchar(10) DEFAULT NULL,
  `kode_skpd_2` varchar(10) DEFAULT NULL,
  `kodeunit` varchar(30) DEFAULT NULL,
  `komisi` int(11) DEFAULT NULL,
  `namabendahara` text,
  `namakepala` text DEFAULT NULL,
  `namaunit` text DEFAULT NULL,
  `nipbendahara` varchar(30) DEFAULT NULL,
  `nipkepala` varchar(30) DEFAULT NULL,
  `pangkatkepala` varchar(50) DEFAULT NULL,
  `setupunit` int(11) DEFAULT NULL,
  `statuskepala` varchar(20) DEFAULT NULL,
  `mapping` varchar(10) DEFAULT NULL,
  `id_kecamatan` int(11) DEFAULT NULL,
  `id_strategi` int(11) DEFAULT NULL,
  `is_dpa_khusus` tinyint(4) DEFAULT NULL,
  `is_ppkd` tinyint(4) DEFAULT NULL,
  `set_input` tinyint(4) DEFAULT NULL,
  `update_at` datetime DEFAULT NULL,
  `tahun_anggaran` year(4) NOT NULL DEFAULT '2021',
  `active` tinyint(4) NOT NULL DEFAULT '1',
  PRIMARY KEY  (id)
);

CREATE TABLE `data_pegawai_lembur` (
  `id` int(11) NOT NULL auto_increment,
  `id_skpd` int(11) NOT NULL,
  `nip` varchar(50) DEFAULT NULL,
  `nik` varchar(50) DEFAULT NULL,
  `gelar_depan` text DEFAULT NULL,
  `nama` varchar(60) DEFAULT NULL,
  `gelar_belakang` text DEFAULT NULL,
  `tempat_lahir` text DEFAULT NULL,
  `tanggal_lahir` date DEFAULT NULL,
  `jenis_kelamin` varchar(10) DEFAULT NULL,
  `kode_jenis_kelamin` int(11) DEFAULT NULL,
  `status` varchar(50) DEFAULT NULL,
  `gol_ruang` text DEFAULT NULL,
  `kode_gol` int(11) DEFAULT NULL,
  `tmt_pangkat` date DEFAULT NULL,
  `ese` int(11) DEFAULT NULL,
  `mk_bulan` int(11) DEFAULT NULL,
  `eselon` text DEFAULT NULL,
  `jabatan` text DEFAULT NULL,
  `tipe_pegawai` text DEFAULT NULL,
  `tmt_jabatan` date DEFAULT NULL,
  `agama` varchar(20) DEFAULT NULL,
  `alamat` text DEFAULT NULL,
  `no_hp` varchar(50) DEFAULT NULL,
  `satuan_kerja` text DEFAULT NULL,
  `unit_kerja_induk` text DEFAULT NULL,
  `tmt_pensiun` date DEFAULT NULL,
  `pendidikan` varchar(20) DEFAULT NULL,
  `kode_pendidikan` int(20) DEFAULT NULL,
  `nama_sekolah` text DEFAULT NULL,
  `nama_pendidikan` text DEFAULT NULL,
  `lulus` year (4) DEFAULT NULL,
  `karpeg` text DEFAULT NULL,
  `karis_karsu` text DEFAULT NULL,
  `nilai_prestasi` int(11) DEFAULT NULL,
  `email` text DEFAULT NULL,
  `tahun` year DEFAULT NULL,
  `update_at` datetime NOT NULL,
  `active` tinyint(4) DEFAULT 1,
  PRIMARY KEY  (id)
);

CREATE TABLE `data_spt_lembur` (
  `id` int(11) NOT NULL auto_increment,
  `id_skpd` int(11) NOT NULL,
  `id_ppk` int(11) DEFAULT NULL,
  `id_bendahara` int(11) DEFAULT NULL,
  `uang_makan` double DEFAULT NULL,
  `uang_lembur` double DEFAULT NULL,
  `ket_lembur` text DEFAULT NULL,
  `ket_ver_ppk` text DEFAULT NULL,
  `ket_ver_kepala` text DEFAULT NULL,
  `status_ver_bendahara` enum ('0', '1') DEFAULT NULL COMMENT '0=ditolak, 1=disetujui',
  `ket_ver_bendahara` text DEFAULT NULL,
  `user` text DEFAULT NULL,
  `status` enum ('0', '1', '2', '3') DEFAULT NULL COMMENT '0=belum diverifikasi, 1=disetujui kasubag keuangan, 2=disetujui ppk, 3=selesai ', 
  `update_at` datetime NOT NULL,
  `active` enum ('0', '1') DEFAULT '1' COMMENT '0=hapus, 1=aktif',
  PRIMARY KEY  (id)
);

CREATE TABLE `data_spj_lembur` (
  `id` int(11) NOT NULL auto_increment,
  `id_spj` int(11) NOT NULL,
  `file_daftar_hadir` text DEFAULT NULL,
  `foto_lembur` text DEFAULT NULL,
  `user` text DEFAULT NULL,
  `update_at` datetime NOT NULL,
  `active` enum ('0', '1') DEFAULT '1' COMMENT '0=hapus, 1=aktif',
  PRIMARY KEY  (id)
);

CREATE TABLE `data_sbu_lembur` (
  `id` int(11) NOT NULL auto_increment,
  `kode_standar_harga` text NOT NULL,
  `nama` text NOT NULL,
  `uraian` text DEFAULT NULL,
  `satuan` text NOT NULL,
  `harga` double NOT NULL,
  `id_golongan` text DEFAULT NULL COMMENT '1=golongan 1, 2=golongan 2, 3=golongan 3, 4=golongan 4, 5=no asn'
  `tahun` year DEFAULT '2023',
  `no_aturan` text NOT NULL,
  `pph_21` int(11) DEFAULT NULL,
  `jenis_hari` int(11) NOT NULL COMMENT '1=hari libur, 2=hari efektif',
  `update_at` datetime NOT NULL,
  `active` enum ('0', '1') DEFAULT '1' COMMENT '0=hapus, 1=aktif',
  PRIMARY KEY  (id)
);

CREATE TABLE `data_spt_lembur_detail` (
  `id` int(11) NOT NULL auto_increment,
  `id_spt` int(11) NOT NULL,
  `id_pegawai` int(11) NOT NULL,
  `id_standar_harga_lembur` int(11) NOT NULL,
  `id_standar_harga_makan` int(11) NOT NULL,
  `waktu_mulai` datetime DEFAULT NULL,
  `waktu_akhir` datetime DEFAULT NULL,
  `waktu_mulai_ppk` datetime DEFAULT NULL,
  `waktu_akhir_ppk` datetime DEFAULT NULL,
  `waktu_mulai_hadir` datetime DEFAULT NULL,
  `waktu_akhir_hadir` datetime DEFAULT NULL,
  `tipe_hari` enum ('1', '2') DEFAULT '1' COMMENT '1=hari libur, 2=hari kerja',
  `keterangan` text DEFAULT NULL,
  `keterangan_ppk` text DEFAULT NULL,
  `file_lampiran` text DEFAULT NULL,
  `update_at` datetime NOT NULL,
  `active` enum ('0', '1') DEFAULT '1' COMMENT '0=hapus, 1=aktif',
  PRIMARY KEY  (id)
);