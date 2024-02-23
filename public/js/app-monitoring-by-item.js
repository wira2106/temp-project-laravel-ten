let selectedTable,
    selectedTablePLU,
    selectedData  =  [],
    kode_plu = null,
    dataPlu =[],
    listPLU =[],
    listPLUEdit =[],
    search  =  false,
    page = 1,
    cabang = null;

$(document).ready(function(){
   /**
    * select2
    */
   $('.select2').select2({
      allowClear: false
   }); 
   /**
    * input periode
    */
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
    * search
    */
   $('#searchInput').on('input', function () {
      var searchText = $(this).val().toLowerCase();

      // Iterate through each row in the table body
      $('#table_bytoko tbody tr').each(function () {
            var rowText = $(this).text().toLowerCase();

            // If the row contains the search text, show it; otherwise, hide it
            $(this).toggle(rowText.includes(searchText));
      });
   });
   loadPeriodePlu();
});

highlightRange=(date)=>{
   var selectedDates = $('#date').datepicker('getDates');
   if (selectedDates.length === 2 && date >= selectedDates[0] && date <= selectedDates[1]) {
     return 'highlighted';
   }
   return '';
 }

loadData =()=>{
   let kode_plu = $("#kode_plu").val(),
       periode = $("#periode").val(),
       omi = $("#omi").val();
       $("#table-content-byitem").html('')
   $('#card-container').loading('toggle');
   let field = '';
   $.getJSON(link + "/api/monitoring/item/loadData?plu="+kode_plu+"&periode="+periode+"&omi="+omi, function(data) {

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
      
      if(data.data){
         $.each(data.data,function(key,value){
            field+=`
               <tr>
                     <td scope="row">${value.plu}</td>
                     <td>${value.deskripsi}</td>
                     <td>${value.qty_alokasi}</td>
                     <td>${value.qty_pemenuhan}</td>
                     <td>${value.persentase_pemenuhan}</td>
                     <td>${value.sisa}</td>
               </tr>
            `;
            listPLU[value.plu] = value;
         });

         $("#table-content-byitem").append(field);
   }

   }).done(function(){
      $('#card-container').loading('toggle');

   })
}

changeKodePlu =(kode)=>{
   let data_kode_plu = dataPlu[kode];
         kode_plu = kode;
   $("#omi").val(data_kode_plu.nama)
}
loadPeriodePlu =()=>{

   $("#kode_plu").prop('disabled',true)
   $("#omi").prop('disabled',true)
   $("#kode_plu").html('');
   $('#card-container').loading('toggle');
   let select = '  <option value="" disabled selected>Pilih Kode plu</option>';
   $.getJSON(link + "/api/monitoring/item/loadPeriodePlu", function(data) {
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
             dataPlu[value.kode] = value;
             

         });

         $("#kode_plu").append(select);
      }

      $("#kode_plu").prop('disabled',false)
      $("#omi").prop('disabled',false)
      $("#periode").val(data.periode.periode);

   }).done(function(){
      $('#card-container').loading('toggle');

   })

}

