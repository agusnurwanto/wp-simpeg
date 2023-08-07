function formatRupiah(angka, prefix){
	var cek_minus = false;
	if(!angka || angka == '' || angka == 0){
		angka = '0';
	}else if(angka < 0){
		angka = angka*-1;
		cek_minus = true;
	}
	try {
		if(typeof angka == 'number'){
			angka = Math.round(angka*100)/100;
			angka += '';
			angka = angka.replace(/\./g, ',').toString();
		}
		angka += '';
		number_string = angka;
	}catch(e){
		console.log('angka', e, angka);
		var number_string = '0';
	}
	var split = number_string.split(','),
	sisa = split[0].length % 3,
	rupiah = split[0].substr(0, sisa),
	ribuan = split[0].substr(sisa).match(/\d{3}/gi);

	// tambahkan titik jika yang di input sudah menjadi angka ribuan
	if(ribuan){
		separator = sisa ? '.' : '';
		rupiah += separator + ribuan.join('.');
	}

	rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
	if(cek_minus){
		return '-'+(prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : ''));
	}else{
		return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
	}
}