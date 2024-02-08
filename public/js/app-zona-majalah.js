let selectedTable,
    selectedData  =  [],
    dataZona =[],
    listToko = [],
    search  =  false,
    firs_visit  =  true,
    page = 1,
    field = null,
    cabang = null;

$(document).ready(function(){

   $('.tombol_edit').prop('disabled',true);
   $('.tombol_reset').hide();
   view();
   $('.select2').select2(); 
   
   $('#table_member tbody').on('click', 'tr', function () {
        // Remove the 'selected-row' class from all rows
        $('#table_member tbody tr').removeClass('selected-row');

        // Add the 'selected-row' class to the clicked row
        $(this).addClass('selected-row');
              
        // Get Text in field data
        selectedTable = $(this).find('td').map(function (data) {
            return $(this).text();
        }).get();
        
        selectedValue(selectedTable[1]);
        $('.tombol_edit').prop('disabled',false);
        $('.tombol_reset').show();
      //   selectedValue(selectedData[0],selectedData[1]);
    });

   // scroll function
   //  $('#scrollContainer').on('scroll', function () {
   //    var container = $(this);
   //    // add more 1 because height scroll less 0.5
   //    if ((container.scrollTop() + container.innerHeight()) + 1>= container[0].scrollHeight) {
   //      // Load more data when scrolled to the bottom
   //      if (dataZona.length) {
   //         view();
   //      }
   //    }
   //  });
});

view =(search = null,set_page = null)=>{
   reset_selected();
   dataZona = [];
   listToko = [];
   field    = '';
   let select = '';
   $("#toko").val('')
   $("#zona").val('')

   $("#toko").html('<option value="" disabled selected>Pilih Toko</option>');
   
   $('#label-tag').loading('toggle');
   $.getJSON(link + "/api/get_data_toko?search="+search+"&page="+page, function(data) {

         if(data){
            $.each(data,function(key,value){
                select+=` <option value="${value.tko_kodeomi}" >${value.tko_kodeomi}</option>`;
                listToko[value.id] = value;

            });
            $("#toko").append(select);
        }
   })
   $.getJSON(link + "/api/get_data_zona?search="+search+"&page="+page, function(data) {
      
     // list data member
      $.each(data.data,function(key,value) {
         field+=`
                  <tr>
                        <td scope="row">${value.zona}</td>
                        <td>${value.toko}</td>
                  </tr>
               `;
               dataZona[value.kode_member] = value;
      });
   }).done(function() {

      $("#table-content").html(field);
      page++
   }); 
   $('#label-tag').loading('toggle');

}


selectedValue =(kode_member)=>{
   selectedData  = dataZona[kode_member];
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
