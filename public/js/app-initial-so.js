let selectedTable,
    selectedData  =  [],
    dataMember =[],
    listMasterProduk = [],
    search  =  false,
    page = 1,
    field = null,
    cabang = null;

$(document).ready(function(){
      // $('#table_cabang tbody').on('click', 'tr', function () {
         
      //    // Remove the 'selected-row' class from all rows
      //    $('#table_cabang tbody tr').removeClass('selected-row');

      //    // Add the 'selected-row' class to the clicked row
      //    $(this).addClass('selected-row');
               
      //    // Get Text in field data
      //    selectedTable = $(this).find('td').map(function (data) {
      //          return $(this).text();
      //    }).get();
         
      //    selectedValue(selectedTable[1]);

      // });

      // $('#scrollContainer').on('scroll', function () {
      //    var container = $(this);
      //    if (container.scrollTop() + container.innerHeight() >= container[0].scrollHeight) {
      //    // Load more data when scrolled to the bottom
      //    // view();
      //    }
      // });



      $('.input-data').prop('disabled',true);
      $('.list-label').hide();
      $('.input-form').hide();
      $('.select2').select2({
         allowClear: false
      }); 
      $("#datepicker").datepicker({
         format: "dd-MM-yyyy",
         autoclose: true,
         todayHighlight: true
      });
      getDataPlu();
      $("#by-plu").prop("checked", true);
      toggleInput('by-plu')
});

toggleInput =(nameClass,deleteVar)=>{

   $('#label-tag').loading('toggle');
   let className = '.'+nameClass;
   
   $('.input-form').hide();
   $('.input-data').prop('disabled',true);
   $(className).prop('disabled',false);
   $(className).show();

   $('#label-tag').loading('toggle');

}

changePRDCD=(data)=>{

   let prdcd = $("#prdcd").val();

   view(prdcd,null);
   
}


getDataPlu =()=>{
   let select = "";
       listMasterProduk = [];

   $('#label-tag').loading('toggle');
   $.getJSON(link + "/api/data/plu", function(data) {
     
      if(data){
         $.each(data,function(key,value){
               select+=` <option value="${value.prdcd}" >(${value.prdcd})</option>`;
               listMasterProduk[value.prdcd] = value;

         });
         $("#prdcd").append(select);
      }

   })

   $('#label-tag').loading('toggle');

}

view =(prdcd = null,rak = null)=>{
   reset_selected();

   let select = "",
       param = "",
       kategori=null;
       listCabang = [];

       kategori = $(".kategori").val();
       if (prdcd) {
         param = "prdcd="+prdcd;
      } else {
          param = "rak="+rak;
         
       }
       param = param+"&kategori="+kategori;
   $.getJSON(link + "/api/check/data?"+param, function(data) {

   $('#label-tag').loading('toggle');
      // console.log(data)
     // list data member
      $.each(data,function(key,value) {
         field+=`
                  <tr>
                        <td scope="row">${value.kode_cabang}</td>
                        <td>${value.kode_member}</td>
                        <td>${value.nama}</td>
                        <td>${value.alamat_ktp}</td>
                  </tr>
               `;
               dataMember[value.kode_member] = value;
      });
   }).done(function() {

      $("#table-content").html(field);
      page++
   }); 

}



add =(data)=>{
   $('#form_data').attr('action',link+'/api/add');
   $('.text').val('Tambah')
   $('#form_data').submit();
}

update =(data)=>{
   $('#form_data').attr('action',link+'/api/update');
   $('.text').val('Edit')
   $('#form_data').submit();
}

pencarian=()=>{
   reset_selected();
}

selectedValue =(kode_member)=>{
   selectedData  = dataMember[kode_member];
}

reset_selected=()=>{
   selectedData  =  [];
   $('.tombol_edit').prop('disabled',true);
   $('#table_member tbody tr').removeClass('selected-row');
   $('.tombol_reset').hide();
   if (search) {
      view();
   }

}
