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

satuanSelected=()=>{

   let selectMultiple  = $("#satuan")
       value =  selectMultiple.val();

       selectMultiple.find('option[value="all"]').prop('disabled', false);
       selectMultiple.find('option[value="0 ctn"]').prop('disabled', false);
       selectMultiple.find('option[value="1 pcs"]').prop('disabled', false);
       selectMultiple.find('option[value="2 pcs"]').prop('disabled', false);

      value.forEach(element => {
         console.log(element);
         if(element == 'all'){
            selectMultiple.find('option[value="all"]').prop('disabled', false);
            selectMultiple.find('option[value="0 ctn"]').prop('disabled', true);
            selectMultiple.find('option[value="1 pcs"]').prop('disabled', true);
            selectMultiple.find('option[value="2 pcs"]').prop('disabled', true);
            selectMultiple.find('option[value="no pcs"]').prop('disabled', true);
         }else{
            selectMultiple.find('option[value="all"]').prop('disabled', true);
            selectMultiple.find('option[value="0 ctn"]').prop('disabled', false);
            selectMultiple.find('option[value="1 pcs"]').prop('disabled', false);
            selectMultiple.find('option[value="2 pcs"]').prop('disabled', false);
            selectMultiple.find('option[value="no pcs"]').prop('disabled', false);
         }
         
      });
   
}
changePRDCD=(data)=>{
   $('#label-tag').loading('toggle');

   let prdcd = $("#prdcd").val();

   view(prdcd,null);
   
   $('#label-tag').loading('toggle');
}

updateSelect2Options=()=>{
   const select1 = document.getElementById("select1");
   const select2 = document.getElementById("select2");
   $('#select2').prop('disabled',false);
   // Clear existing options
   select2.innerHTML = '';

   // Get the selected value from Select 1
   const selectedValue = parseInt(select1.value);

   // Populate options for Select 2 based on the selected value in Select 1
   for (let i = 1; i <= 10; i++) {
     // Add an option only if it's greater than the selected value in Select 1
     if (i > selectedValue) {
       const option = document.createElement("option");
       option.value = i;
       option.text = `${i}`;
       select2.appendChild(option);
     }
   }
 }

getDataPlu =()=>{
   let select = "";
       listMasterProduk = [];
   $.getJSON(link + "/api/data/plu", function(data) {
console.log(data)
      // list select cabang
      if(data){
         $.each(data,function(key,value){
               select+=` <option value="${value.prdcd}" >(${value.prdcd})</option>`;
               listMasterProduk[value.prdcd] = value;

         });
         $("#prdcd").append(select);
      }

   })

}

view =(prdcd = null,rak = null)=>{
   reset_selected();

   $('#table_member tbody').loading('toggle');

   let select = "",
       param = "";
       listCabang = [];
       if (prdcd) {
         param = "prdcd="+prdcd;
      } else {
          param = "rak="+rak;
         
       }
   $.getJSON(link + "/api/plu/data?"+param, function(data) {
      
      // list select cabang
      if(data.dataCabang){
         $.each(data.dataCabang,function(key,value){
             select+=` <option value="${value.id}" >${value.cabang}</option>`;
             listCabang[value.id] = value;

         });
         $("#kode_cabang").append(select);
     }

     // list data member
      $.each(data.data,function(key,value) {
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

      $('#table_member tbody').loading('toggle');
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
