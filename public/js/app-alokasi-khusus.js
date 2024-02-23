let selectedTable,
    selectedTablePLU,
    selectedData  =  [],
    kode_toko = null,
    dataToko =[],
    dataPlu =[],
    listPLU =[],
    listPLUEdit =[],
    search  =  false,
    page = 1,
    cabang = null;

$(document).ready(function(){

   $('.select2').select2({
      allowClear: false
   }); 
   /**
    * table_plu_khusus
    */
      $('#table_plu_khusus tbody').on('click', 'tr', function () {
         
         // Remove the 'selected-row' class from all rows
         $('#table_plu_khusus tbody tr').removeClass('selected-row');
   
         // Add the 'selected-row' class to the clicked row
         $(this).addClass('selected-row');
               
         // Get Text in field data
         selectedTable = $(this).find('td').map(function (data) {
               return $(this).text();
         }).get();
         // selectedValue(selectedTable);
   
      });

      /**
       * search
       */
      $('#searchInput').on('input', function () {
         var searchText = $(this).val().toLowerCase();

         // Iterate through each row in the table body
         $('#table_plu_khusus tbody tr').each(function () {
             var rowText = $(this).text().toLowerCase();

             // If the row contains the search text, show it; otherwise, hide it
             $(this).toggle(rowText.includes(searchText));
         });
     });

   loadToko()
});


loadToko =()=>{
   
   $("#kode_toko").prop('disabled',true)
   $("#omi").prop('disabled',true)
   $("#omi").val('')
   $("#kode_toko").html('');
   $('#card-container').loading('toggle');
   let select = '  <option value="" disabled selected>Pilih Kode Toko</option>';
   $.getJSON(link + "/api/alokasi/khusus/loadtoko", function(data) {
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
      if(data.toko){
         $.each(data.toko,function(key,value){
             select+=` <option value="${value.kode}" >${value.kode}</option>`;
             dataToko[value.kode] = value;
             

         });

         $("#kode_toko").prop('disabled',false)
         $("#omi").prop('disabled',false)
         $("#kode_toko").append(select);
     }

   }).done(function(){
      $('#card-container').loading('toggle');

   })


}
changeKodeToko =(kode)=>{
   let data_kode_toko = dataToko[kode];
       kode_toko = kode;
   $("#omi").val(data_kode_toko.nama)

   loadPlu(kode)
}

loadPlu =(toko = null)=>{

   $('#card-container').loading('toggle');
   let field = '';
   $.getJSON(link + "/api/alokasi/khusus/loadplu?toko="+toko, function(data) {
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
       
      if(data.plu){
         $.each(data.plu,function(key,value){
            field+=`
               <tr>
                     <td scope="row">${value.plu}</td>
                     <td>${value.deskripsi}</td>
                     <td>${value.minor}</td>
                     <td class="qty_alokasi" onclick="chagneQtyAlokasi(this)">0</td>
               </tr>
            `;
            dataPlu[value.plu] = value;
         });

         $("#table-content-plu-khusus").append(field);
     }

   }).done(function(){
      $('#card-container').loading('toggle');

   })

}

// selectedValue=(data_field)=>{
//      listPLUEdit[data_field[0]] = data_field;
// }
chagneQtyAlokasi=(field)=>{
   var currentValue = $(this).text();

   // Create an input element
   var inputElement = $('<input type="number">').val(currentValue);

   // Replace the cell content with the input
   $(field).html(inputElement);

   // Focus on the input
   inputElement.focus();

   // Add a blur event to save changes when input loses focus
   inputElement.blur(function () {
       saveChanges($(field));
   });
}
saveChanges=(cell)=>{
   // Get the updated value from the input
   var updatedValue = cell.find('input').val();

   
   // Update the cell content
   if (!(updatedValue % selectedTable[2]  === 0) || updatedValue < selectedTable[2]) {
      Swal.fire({
         title: 'Gagal',
         html: 'Data Qty Alokasi harus kelipatan denan minor / lebih besar dari minor',
         icon: 'warning',
         allowOutsideClick: false,
         onOpen: () => {
                 swal.hideLoading()
         }
     });

      cell.html(0);
     return false
   }
   
   if (updatedValue > 0) {
      // listPLUEdit[selectedTable[0]] = selectedTable
      // listPLUEdit[selectedTable[0]][3] = updatedValue
      listPLUEdit.push(selectedTable[0]);
      dataPlu[selectedTable[0]]['qty'] = updatedValue;
      cell.html(updatedValue);
   }
}

KirimPBKhusus=(button)=>{
   let csrf = $('meta[name="csrf-token"]').attr('content'),
       plu = [];
       omi = $("#omi").val();
       formKirimPB = new FormData();
       listPLUEdit.forEach(function(index){
         plu.push(dataPlu[index])
      })
console.log(listPLUEdit,plu)
   formKirimPB.append('_token', csrf);
   formKirimPB.append('kode_toko', kode_toko);
   formKirimPB.append('omi', omi);
   formKirimPB.append('plu', JSON.stringify(plu));
  
   $('#label-tag').loading('toggle');
   $.ajax({
         url: link+'/api/alokasi/KirimPBKhusus',
         method: 'POST',
         data: formKirimPB,

         success: function (response) {

            // console.log(response.download,response.redirect,runNext,multipleForm)
            let messages = response.messages?response.messages:'Data Berhasil Dihapus';
            Swal.fire(
               'Berhasil',
                  messages,
               'success'
            )
            //  getDataLabel('');
            $('.promo_button').prop('disabled',false)
            response.callback.forEach(function (value){
               console.log(value,response.callback);
               $('.desc').val(value.brg_singkatan)
            });
         },
         error: function (xhr) {

            let res = xhr.responseJSON,
               messages = xhr.responseJSON.messages?xhr.responseJSON.messages:'Proses Hapus Gagal';
               
            $('#label-tag').loading('toggle');  
            Swal.fire({
               title: 'Gagal',
               html: messages,
               icon: 'warning',
               allowOutsideClick: false,
               onOpen: () => {
                        swal.hideLoading()
               }
            });
            if ($.isEmptyObject(res) == false) {
               $.each(res.errors, function (i, value) {
                     $('#' + i).addClass('is-invalid');
                     $('.' + i).append('<span class="help-block"><strong>' + value + '</strong></span>')
               })
            }

         },
         cache: false,
         contentType: false,
         processData: false,
         dataType: "json"
   }).done(function () {

      $('#label-tag').loading('toggle');
   });  

 }
