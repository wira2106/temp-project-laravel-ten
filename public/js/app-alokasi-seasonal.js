let selectedTable,
    selectedData  =  [],
    dataMember =[],
    listMasterProduk = [],
    search  =  false,
    page = 1,
    field = null,
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

});


loadToko =()=>{

   $('#card-container').loading('toggle');
   $.getJSON(link + "/api/alokasi/seasonal/loadtoko", function(data) {
      if(!data.errors){
         $("#cc").val(data.data_email.cc)
         $("#password").val(data.data_email.pass)
         $("#port").val(data.data_email.port)
         $("#server").val(data.data_email.server)
         $("#subject").val(data.data_email.subject)
         $("#to").val(data.data_email.too)
         $("#email").val(data.data_email.uuser)
         $(".form_data").attr('action')
         $('.form_data').attr('action',link+'/api/email/edit');
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

