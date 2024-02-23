let selectedTable,
    selectedTablePLU,
    selectedData  =  [],
    kode_seasonal = null,
    dataKode =[],
    dataToko =[],
    dataPlu =[],
    listPLU =[],
    search  =  false,
    page = 1,
    cabang = null;

$(document).ready(function(){

   $('#periode').datepicker({
      startView: 0,
      minViewMode: 0,
      maxViewMode: 2,
      multidate: true,
      multidateSeparator: "-",
      autoClose: true,
      beforeShowDay: highlightRange,
      format: 'dd/mm/yyyy',
   }).on("changeDate", function(event) {
      var dates = event.dates,
         elem = $('#periode');
      if (elem.data("selecteddates") == dates.join(",")) return;
      if (dates.length > 2) dates = dates.splice(dates.length - 1);
      dates.sort(function(a, b) { return new Date(a).getTime() - new Date(b).getTime() });
      elem.data("selecteddates", dates.join(",")).datepicker('setDates', dates);
   });
   /**
    * table_omi
    */
   $('#table_omi tbody').on('click', 'tr', function () {
         
      // Remove the 'selected-row' class from all rows
      $('#table_omi tbody tr').removeClass('selected-row');

      // Add the 'selected-row' class to the clicked row
      $(this).addClass('selected-row');
            
      // Get Text in field data
      selectedTable = $(this).find('td').map(function (data) {
            return $(this).text();
      }).get();
      selectedValue(selectedTable[0]);

   });
   /**
    * table_plu_seasonal
    */
   $('#table_plu_seasonal input[type="checkbox"]').click(function () {
         // Toggle the 'selected' class on the parent row
         $(this).closest('tr').toggleClass('selected-row', this.checked);
   });
   $('#table_plu_seasonal tbody').on('click', 'tr', function () {

      $(this).toggleClass('selected-row');
      selectedTablePLU = $(this).find('td').map(function (data) {
            return $(this).text();
      }).get();
      $(this).find('input[type="checkbox"]').prop('checked', function (i, oldProp) {
         if ($(this).is(':checked')) {
            addPlu(selectedTablePLU[1],false)
        } else {
            addPlu(selectedTablePLU[1],true)
        }
         return !oldProp;
      });
      

   });
  
   loadSeasonal()
});

changeKodeSeasonal =(kode)=>{
   let data_kode_seasonal = dataKode[kode];
       kode_seasonal = kode;
   $("#periode").val(data_kode_seasonal.periode)

   loadToko(kode)
}


loadSeasonal =()=>{
   $("#kode_seasonal").prop('disabled',true)
   $("#periode").prop('disabled',true)
   $("#periode").val('')
   $("#kode_seasonal").html('');
   $('#card-container').loading('toggle');
   let select = '  <option value="" disabled selected>Pilih Kode Seasonal</option>';
   $.getJSON(link + "/api/alokasi/seasonal/loadseasonal", function(data) {
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
      if(data.kode){
         $.each(data.kode,function(key,value){
             select+=` <option value="${value.kode}" >${value.kode}</option>`;
             dataKode[value.kode] = value;
             

         });

         $("#kode_seasonal").prop('disabled',false)
         $("#periode").prop('disabled',false)
         $("#kode_seasonal").append(select);
     }

   }).done(function(){
      $('#card-container').loading('toggle');

   })

}
loadToko =(kode = null)=>{

   $('#card-container').loading('toggle');
   let field = '';
   $.getJSON(link + "/api/alokasi/seasonal/loadtoko?kode="+kode, function(data) {

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
            field+=`
               <tr>
                     <td scope="row">${value.omi}</td>
                     <td>${value.nama_omi}</td>
                     <td>${value.jatuh_tempo}</td>
               </tr>
            `;
            dataToko[value.omi] = value;
         });

         $("#table-content-omi").append(field);
     }

   }).done(function(){
      $('#card-container').loading('toggle');

   })

}
loadPlu =(kode = null,toko = null)=>{

   $('#card-container').loading('toggle');
   let field = '';
   $.getJSON(link + "/api/alokasi/seasonal/loadplu?kode="+kode+"&&toko="+toko, function(data) {
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
                     <td><input type="checkbox" value="1"></td>
                     <td scope="row">${value.plu}</td>
                     <td>${value.deskripsi}</td>
                     <td>${value.qty_alokasi}</td>
                     <td>${value.qty_pemenuhan}</td>
                     <td>${value.qty}</td>
               </tr>
            `;
            dataPlu[value.plu] = value;
         });

         $("#table-content-plu-seasonal").append(field);
     }

   }).done(function(){
      $('#card-container').loading('toggle');

   })

}

highlightRange=(date)=>{
   var selectedDates = $('#date').datepicker('getDates');
   if (selectedDates.length === 2 && date >= selectedDates[0] && date <= selectedDates[1]) {
     return 'highlighted';
   }
   return '';
 }
 selectedValue=(date)=>{
  
   loadPlu(kode_seasonal,selectedTable[0])

 }
 KirimPBSeasonal=(button)=>{
   let csrf = $('meta[name="csrf-token"]').attr('content'),
       plu = [],
       periode = $("#periode").val();
       formKirimPB = new FormData();
   
   listPLU.forEach(function(index){
      plu.push(dataPlu[index])
   })

   formKirimPB.append('_token', csrf);
   formKirimPB.append('kode_seasonal', kode_seasonal);
   formKirimPB.append('periode', periode);
   formKirimPB.append('plu', JSON.stringify(plu));
   formKirimPB.append('toko', selectedTable[0]);
   formKirimPB.append('omi', selectedTable[1]);
   formKirimPB.append('jatuh_tempo', selectedTable[2]);
  
   $('#label-tag').loading('toggle');
   $.ajax({
         url: link+'/api/alokasi/KirimPBSeasonal',
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

 addPlu=(plu,status)=>{
   if (status) {
      listPLU.push(plu)
      
   } else {
      // remove array by value
      Array.prototype.remove = function() {
         var what, a = arguments, L = a.length, ax;
         while (L && this.length) {
             what = a[--L];
             while ((ax = this.indexOf(what)) !== -1) {
                 this.splice(ax, 1);
             }
         }
         return this;
     };
      listPLU.remove(plu)

      
   }
 }

