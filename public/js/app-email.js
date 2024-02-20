let selectedTable,
    selectedData  =  [],
    dataMember =[],
    listMasterProduk = [],
    search  =  false,
    page = 1,
    field = null,
    cabang = null;

$(document).ready(function(){
   checkEmail();
});


checkEmail =()=>{

   $('#card-container').loading('toggle');
   $.getJSON(link + "/api/email/check", function(data) {
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

