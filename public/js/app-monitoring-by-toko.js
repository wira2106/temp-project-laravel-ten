let selectedTable,
    selectedTablePLU,
    selectedData  =  [],
    kode_toko = null,
    dataToko =[],
    dataPlu =[],
    listToko =[],
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
   loadPeriodeToko();
});

highlightRange=(date)=>{
   var selectedDates = $('#date').datepicker('getDates');
   if (selectedDates.length === 2 && date >= selectedDates[0] && date <= selectedDates[1]) {
     return 'highlighted';
   }
   return '';
 }

loadData =()=>{
   let kode_toko = $("#kode_toko").val(),
       periode = $("#periode").val(),
       omi = $("#omi").val();

       $("#table-content-bytoko").html('')
   $('#card-container').loading('toggle');
   let field = '';
   $.getJSON(link + "/api/monitoring/toko/loadData?toko="+kode_toko+"&periode="+periode+"&omi="+omi, function(data) {

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
            listToko[value.plu] = value;
         });

         $("#table-content-bytoko").append(field);
   }

   }).done(function(){
      $('#card-container').loading('toggle');

   })
}

changeKodeToko =(kode)=>{
   let data_kode_toko = dataToko[kode];
       kode_toko = kode;
   $("#omi").val(data_kode_toko.nama)
}
loadPeriodeToko =()=>{

   $("#kode_toko").prop('disabled',true)
   $("#omi").prop('disabled',true)
   $("#kode_toko").html('');
   $('#card-container').loading('toggle');
   let select = '  <option value="" disabled selected>Pilih Kode Toko</option>';
   $.getJSON(link + "/api/monitoring/toko/loadPeriodeToko", function(data) {
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

         $("#kode_toko").append(select);
      }

      $("#kode_toko").prop('disabled',false)
      $("#omi").prop('disabled',false)
      $("#periode").val(data.periode.periode);

   }).done(function(){
      $('#card-container').loading('toggle');

   })

}

