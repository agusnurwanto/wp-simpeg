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


function run_download_excel_simpeg(type){
	var current_url = window.location.href;
	var body = '<a id="excel" onclick="return false;" href="#" class="btn btn-primary text-center">DOWNLOAD EXCEL</a>';
	var download_excel = ''
		+'<div class="text-center" style="margin-top: 10px;" id="action-sipd" class="hide-print">'
			+body
		+'</div>';
	if(jQuery('.entry-content').length >= 1){
		jQuery('.entry-content').prepend(download_excel);
	}else{
		jQuery('body').prepend(download_excel);
	}

	var style = '';

	style = jQuery('.cetak').attr('style');
	if (typeof style == 'undefined'){ style = ''; };
	jQuery('.cetak').attr('style', style+" font-family:'Open Sans',-apple-system,BlinkMacSystemFont,'Segoe UI',sans-serif; padding:0; margin:0; font-size:13px;");
	
	jQuery('.bawah').map(function(i, b){
		style = jQuery(b).attr('style');
		if (typeof style == 'undefined'){ style = ''; };
		jQuery(b).attr('style', style+" border-bottom:1px solid #000;");
	});
	
	jQuery('.kiri').map(function(i, b){
		style = jQuery(b).attr('style');
		if (typeof style == 'undefined'){ style = ''; };
		jQuery(b).attr('style', style+" border-left:1px solid #000;");
	});

	jQuery('.kanan').map(function(i, b){
		style = jQuery(b).attr('style');
		if (typeof style == 'undefined'){ style = ''; };
		jQuery(b).attr('style', style+" border-right:1px solid #000;");
	});

	jQuery('.atas').map(function(i, b){
		style = jQuery(b).attr('style');
		if (typeof style == 'undefined'){ style = ''; };
		jQuery(b).attr('style', style+" border-top:1px solid #000;");
	});

	jQuery('.text_tengah').map(function(i, b){
		style = jQuery(b).attr('style');
		if (typeof style == 'undefined'){ style = ''; };
		jQuery(b).attr('style', style+" text-align: center;");
	});

	jQuery('.text_kiri').map(function(i, b){
		style = jQuery(b).attr('style');
		if (typeof style == 'undefined'){ style = ''; };
		jQuery(b).attr('style', style+" text-align: left;");
	});

	jQuery('.text_kanan').map(function(i, b){
		style = jQuery(b).attr('style');
		if (typeof style == 'undefined'){ style = ''; };
		jQuery(b).attr('style', style+" text-align: right;");
	});

	jQuery('.text_block').map(function(i, b){
		style = jQuery(b).attr('style');
		if (typeof style == 'undefined'){ style = ''; };
		jQuery(b).attr('style', style+" font-weight: bold;");
	});

	jQuery('.text_15').map(function(i, b){
		style = jQuery(b).attr('style');
		if (typeof style == 'undefined'){ style = ''; };
		jQuery(b).attr('style', style+" font-size: 15px;");
	});

	jQuery('.text_20').map(function(i, b){
		style = jQuery(b).attr('style');
		if (typeof style == 'undefined'){ style = ''; };
		jQuery(b).attr('style', style+" font-size: 20px;");
	});

	var td = document.getElementsByTagName("td");
	for(var i=0, l=td.length; i<l; i++){
		style = td[i].getAttribute('style');
		if (typeof style == 'undefined'){ style = ''; };
		td[i].setAttribute('style', style+'; mso-number-format:\\@;');
	};

	jQuery('#excel').on('click', function(){
		var name = "Laporan";
		var title = jQuery('#cetak').attr('title');
		if(title){
			name = title;
		}
		
		jQuery("a").removeAttr("href");
		
		var cek_hide_excel = jQuery('#cetak .hide-excel');
		if(cek_hide_excel.length >= 1){
			cek_hide_excel.remove();
			setTimeout(function(){
				alert('Ada beberapa fungsi yang tidak bekerja setelah melakukan donwload excel. Refresh halaman ini!');
				location.reload();
			}, 5000);
		}

		tableHtmlToExcel('cetak', name);
	});
}

function tableHtmlToExcel(tableID, filename = ''){
    var downloadLink;
    var dataType = 'application/vnd.ms-excel';
    var tableSelect = document.getElementById(tableID);
    var tableHTML = tableSelect.outerHTML.replace(/ /g, '%20').replace(/#/g, '%23');
   
    filename = filename?filename+'.xls':'excel_data.xls';
   
    downloadLink = document.createElement("a");
    
    document.body.appendChild(downloadLink);
    
    if(navigator.msSaveOrOpenBlob){
        var blob = new Blob(['\ufeff', tableHTML], {
            type: dataType
        });
        navigator.msSaveOrOpenBlob( blob, filename);
    }else{
        downloadLink.href = 'data:' + dataType + ', ' + tableHTML;
   
        downloadLink.download = filename;
       
        downloadLink.click();
    }
}

function filePickedSimpeg(oEvent) {
    jQuery('#wrap-loading').show();
    // Get The File From The Input
    var oFile = oEvent.target.files[0];
    var sFilename = oFile.name;
    // Create A File Reader HTML5
    var reader = new FileReader();

    reader.onload = function(e) {
        var data = e.target.result;
        var workbook = XLSX.read(data, {
            type: 'binary'
        });

        var cek_sheet_name = false;
        workbook.SheetNames.forEach(function(sheetName) {
            // Here is your object
            console.log('sheetName', sheetName);
            if(sheetName == 'data'){
                cek_sheet_name = true;
                var XL_row_object = XLSX.utils.sheet_to_row_object_array(workbook.Sheets[sheetName]);
                var data = [];
                XL_row_object.map(function(b, i){
                    for(ii in b){
                        b[ii] = b[ii].replace(/(\r\n|\n|\r)/g, " ").trim();
                    }
                    data.push(b);
                });
                var json_object = JSON.stringify(data);
                jQuery('#data-excel').val(json_object);
                jQuery('#wrap-loading').hide();
            }
        });
        setTimeout(function(){
            if(false == cek_sheet_name){
                jQuery('#data-excel').val('');
                alert('Sheet dengan nama "data" tidak ditemukan!');
                jQuery('#wrap-loading').hide();
            }
        }, 2000);
    };

    reader.onerror = function(ex) {
      console.log(ex);
    };

    reader.readAsBinaryString(oFile);
}