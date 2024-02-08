let selectedTable,
    selectedData  =  [],
    dataMember =[],
    listCabang = [],
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

    $('#scrollContainer').on('scroll', function () {
      var container = $(this);
      // add more 1 because height scroll less 0.5
      if ((container.scrollTop() + container.innerHeight()) + 1>= container[0].scrollHeight) {
        // Load more data when scrolled to the bottom
        if (dataMember.length) {
           view();
        }
      }
    });
});

view =(search = null,set_page = null)=>{
   reset_selected();

   $('.loading-card').loading('toggle');


   if (firs_visit) {
      get_data_select();
      firs_visit = false;
   }
   if(set_page){
      page = set_page;
      dataMember = [];
      field = '';
      $("#table-content").html(field)
      $('#modal_edit').modal('hide');
      $('#modal_search').modal('hide');
      $('#modal_alokasi').modal('hide');
      console.log('call function');
   }
   $.getJSON(link + "/api/member/data?search="+search+"&page="+page, function(data) {
      
      // list select cabang
      //    if(data.dataCabang){
      //       $.each(data.dataCabang,function(key,value){
      //           select+=` <option value="${value.id}" >${value.cabang}</option>`;
      //           listCabang[value.id] = value;

      //       });
      //       $("#kode_cabang").append(select);
      //   }

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

      $('.loading-card').loading('toggle');
      $("#table-content").html(field);
      page++
   }); 

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
