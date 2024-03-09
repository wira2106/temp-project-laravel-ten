let selectedTable,
    selectedTableDv1,
    selectedData  =  [],
    dataStruk =[],
    search  =  false,
    page = 1,
    field = null;

$(document).ready(function(){
    /**
    *  Selected table_struk
    */
    $('#table_struk tbody').on('click', 'tr', function () {
         
        // Remove the 'selected-row' class from all rows
        $('#table_struk tbody tr').removeClass('selected-row');
  
        // Add the 'selected-row' class to the clicked row
        $(this).addClass('selected-row');
              
        // Get Text in field data
        selectedTable = $(this).find('td').map(function (data) {
              return $(this).text();
        }).get();
        SelectedStruk(selectedTable);
  
     });
    /**
    *  Selected table_dv1
    */
    $('#table_dv1 tbody').on('click', 'tr', function () {
         
        // Remove the 'selected-row' class from all rows
        $('#table_dv1 tbody tr').removeClass('selected-row');
  
        // Add the 'selected-row' class to the clicked row
        $(this).addClass('selected-row');
              
        // Get Text in field data
        selectedTableDv1 = $(this).find('td').map(function (data) {
              return $(this).text();
        }).get();
        SelectedDv1(selectedTableDv1);
  
     });
     /**
        * search Struk
        */
    $('#searchStruk').on('input', function () {
        var searchText = $(this).val().toLowerCase();

        // Iterate through each row in the table body
        $('#table_struk tbody tr').each(function () {
            var rowText = $(this).text().toLowerCase();

            // If the row contains the search text, show it; otherwise, hide it
            $(this).toggle(rowText.includes(searchText));
        });
    });
     /**
        * search Dv1
        */
    $('#searchDv1').on('input', function () {
        var searchText = $(this).val().toLowerCase();

        // Iterate through each row in the table body
        $('#table_dv1 tbody tr').each(function () {
            var rowText = $(this).text().toLowerCase();

            // If the row contains the search text, show it; otherwise, hide it
            $(this).toggle(rowText.includes(searchText));
        });
    });
     /**
        * search Dv2
        */
    $('#searchDv2').on('input', function () {
        var searchText = $(this).val().toLowerCase();

        // Iterate through each row in the table body
        $('#table_dv2 tbody tr').each(function () {
            var rowText = $(this).text().toLowerCase();

            // If the row contains the search text, show it; otherwise, hide it
            $(this).toggle(rowText.includes(searchText));
        });
    });
});

 Tampilkan =(toko = null)=>{

    $('#card-container').loading('toggle');
    let field = '',
        periode = $('#periode').val(),
        filter = $('#filter_by').val();

        $("#table-content-struk").html('');
        $("#table-content-dv1").html('');
        $("#table-content-dv2").html('');
    $.getJSON(link + "/api/tampil/data?periode="+periode+"&filter="+filter, function(data) {
       
        if (data.errors) {
          Swal.fire({
             title: 'Gagal',
             html: data.messages,
             icon: 'warning',
             allowOutsideClick: false,
             onOpen: () => {
                     swal.hideLoading()
             }
         });
        }
        
       if(data.data.length){
          $.each(data.data,function(key,value){
             field+=`
                <tr>
                      <td scope="row">${value.id}</td>
                      <td>${value.total}</td>
                      <td>${value.selisih}</td>
                </tr>
             `;
             dataStruk[value.id] = value;
          });
 
          $("#table-content-struk").append(field);
      }else{
        Swal.fire({
            title: 'Perhatian!',
            html: 'Data Tidak Ditemukan',
            icon: 'warning',
            allowOutsideClick: false,
            onOpen: () => {
                    swal.hideLoading()
            }
        });
      }
 
    }).done(function(){
       $('#card-container').loading('toggle');
 
    })
 
 }
 SelectedStruk =(selected = null)=>{
    $('#card-container').loading('toggle');
    let field = '',
        periode = $('#periode').val(),
        filter = $('#filter_by').val();

        $("#table-content-dv1").html('');
        $("#table-content-dv2").html('');
    $.getJSON(link + "/api/selected/struk/data?periode="+periode+"&filter="+filter+"&id="+selected[0]+"&struk="+selected[1]+"&selisih="+selected[2], function(data) {
        
        if (data.errors) {
          Swal.fire({
             title: 'Gagal',
             html: data.messages,
             icon: 'warning',
             allowOutsideClick: false,
             onOpen: () => {
                     swal.hideLoading()
             }
         });
        }
        
       if(data.data.length){
          $.each(data.data,function(key,value){
             field+=`
                <tr>
                      <td>${value.notrans}</td>
                      <td>${value.kasir}</td>
                      <td>${value.station}</td>
                      <td>${value.member}</td>
                      <td>${value.jam}</td>
                      <td>${value.status}</td>
                </tr>
             `;
             dataStruk[value.id] = value;
          });
 
          $("#table-content-dv1").append(field);
      }else{
        Swal.fire({
            title: 'Perhatian!',
            html: 'Data Tidak Ditemukan',
            icon: 'warning',
            allowOutsideClick: false,
            onOpen: () => {
                    swal.hideLoading()
            }
        });
      }
 
    }).done(function(){
       $('#card-container').loading('toggle');
 
    })
 
 }
 SelectedDv1 =(selected = null)=>{
    $('#card-container').loading('toggle');
    let field = '',
        periode = $('#periode').val(),
        filter = $('#filter_by').val();

        $("#table-content-dv2").html('');
    $.getJSON(link + "/api/selected/dv1/data?periode="+periode+"&filter="+filter+"&id="+selectedTable[0]+"&notrans="+selected[0]+"&kasir="+selected[1]+"&station="+selected[2]+"&member="+selected[3]+"&jam="+selected[4]+"&status="+selected[5], function(data) {
        
        if (data.errors) {
          Swal.fire({
             title: 'Gagal',
             html: data.messages,
             icon: 'warning',
             allowOutsideClick: false,
             onOpen: () => {
                     swal.hideLoading()
             }
         });
        }
        
       if(data.data.length){
          $.each(data.data,function(key,value){
             field+=`
                <tr>
                      <td>${value.plu}</td>
                      <td>${value.deskripsi}</td>
                      <td>${value.unit}</td>
                      <td>${value.frac}</td>
                      <td>${value.qty_order}</td>
                      <td>${value.qty_real}</td>
                      <td>${value.selisih}</td>
                      <td>${value.keterangan}</td>
                      <td>${value.referensi}</td>
                </tr>
             `;
             dataStruk[value.id] = value;
          });
 
          $("#table-content-dv2").append(field);
      }else{
        Swal.fire({
            title: 'Perhatian!',
            html: 'Data Tidak Ditemukan',
            icon: 'warning',
            allowOutsideClick: false,
            onOpen: () => {
                    swal.hideLoading()
            }
        });
      }
 
    }).done(function(){
       $('#card-container').loading('toggle');
 
    })
 
 }
 TampilkanItemDiluarStruk =()=>{
    $('.modal-body').loading('toggle');
    let field = '',
        periode = $('#periodeStruk').val();

        $("#table-content-diluar-struk").html('');
    $.getJSON(link + "/api/diluar/struk/data?periode="+periode , function(data) {
        
        if (data.errors) {
          Swal.fire({
             title: 'Gagal',
             html: data.messages,
             icon: 'warning',
             allowOutsideClick: false,
             onOpen: () => {
                     swal.hideLoading()
             }
         });
        }
        
       if(data.data.length){
          $.each(data.data,function(key,value){
             field+=`
                <tr>
                      <td>${value.checker_id}</td>
                      <td>${value.kodeplu}</td>
                      <td>${value.nama_barang}</td>
                      <td>${value.qty}</td>
                      <td>${value.tgl_trans}</td>
                      <td>${value.kasir}</td>
                      <td>${value.station}</td>
                      <td>${value.no_trans}</td>
                      <td>${value.kode_member}</td>
                      <td>${value.nama_member}</td>
                </tr>
             `;
             dataStruk[value.id] = value;
          });
 
          $("#table-content-diluar-struk").append(field);
      }else{
        Swal.fire({
            title: 'Perhatian!',
            html: 'Data Tidak Ditemukan',
            icon: 'warning',
            allowOutsideClick: false,
            onOpen: () => {
                    swal.hideLoading()
            }
        });
      }
 
    }).done(function(){
       $('.modal-body').loading('toggle');
 
    })
 
 }
 
