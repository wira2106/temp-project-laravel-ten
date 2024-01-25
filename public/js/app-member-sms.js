let selectedTable,
    selectedData  =  [],
    dataSms =[],
    search  =  false,
    page = 1,
    firs_visit  =  true,
    field = null;

$(document).ready(function(){

   $('.tombol_edit').prop('disabled',true);
   $('.tombol_hapus').prop('disabled',true);
   $('.tombol_reset').hide();

   $('.select2').select2(); 
   view();
   
   $('#table_cabang tbody').on('click', 'tr', function () {
         console.log('masuk');
        // Remove the 'selected-row' class from all rows
        $('#table_cabang tbody tr').removeClass('selected-row');

        // Add the 'selected-row' class to the clicked row
        $(this).addClass('selected-row');
              
        // Get Text in field data
        selectedTable = $(this).find('td').map(function (data) {
            return $(this).text();
        }).get();
      //   console.log(selectedTable)
        
        selectedValue(selectedTable[2]);
        $('.tombol_edit').prop('disabled',false);
        $('.tombol_hapus').prop('disabled',false);
        $('.tombol_reset').show();
      //   selectedValue(selectedData[0],selectedData[1]);
    });

    $('#scrollContainer').on('scroll', function () {
      var container = $(this);
      if (container.scrollTop() + container.innerHeight() +1 >= container[0].scrollHeight) {
        // Load more data when scrolled to the bottom
        view();
      }
    });
});

view =(search = null, set_page =null)=>{
   reset_selected();
   if (firs_visit) {
      get_data_select();
      firs_visit = false;
   }
   if(set_page){
      page = set_page;
      dataSms = [];
      field = '';
      $("#table-content").html(field)
      $('#modal_csv').modal('hide');
      $('#modal_edit').modal('hide');
   }

   $('.loading-card').loading('toggle');
   $.getJSON(link + "/api/member/sms/data?search="+search+"&page="+page, function(data) {
      $.each(data.data,function(key,value) {
         field+=`
                  <tr>
                        <td style="display:none;">${value.kode_cabang}</td>
                        <td scope="row">${value.cabang}</td>
                        <td>${value.kode}</td>
                        <td>${value.nama_sms}</td>
                        <td>${value.awal_tgl}</td>
                        <td>${value.akhir_tgl}</td>
                  </tr>
               `;
               dataSms[value.kode] = value;
      });
   }).done(function() {

      $('.loading-card').loading('toggle');
      $("#table-content").html(field);
      page++
   }); 

}

edit =()=>{
      let data = selectedData;

      console.log(data);
      
      $("input[name='kode']").prop('disabled',true)
      $("select[name='cabang']").val(data.kode_cabang)
      $("input[name='kode']").val(data.kode)
      $("input[name='awal_tgl']").val(data.awal_tgl)
      $("input[name='akhir_tgl']").val(data.akhir_tgl)
      $("input[name='nama_sms']").val(data.nama_sms)

      $('#form_data').attr('action',link+'/api/update');
}

tambah=()=>{
   $('#form_data').attr('action',link+'/api/add');
}
get_data_select=()=>{
   let select = "",
       select_outlet = "",
       select_suboutlet = "",
       select_sms = "",
       select_jenis_member = "",
       listkodesms = [],
       listCabang = [],
       listoutlet = [],
       listsuboutlet = [],
       listjenis_member = [];
   $.getJSON(link + "/api/select/data?", function(data) {
      // list select cabang
      if(data.cabang){
         $.each(data.cabang,function(key,value){
             select+=` <option value="${value.id}" >${value.cabang}</option>`;
             listCabang[value.id] = value;

         });
         $.each(data.outlet,function(key,value){
             select_outlet+=` <option value="${value.id}" >${value.outlet}</option>`;
             listoutlet[value.id] = value;

         });
         // $.each(data.suboutlet,function(key,value){
         //    select_suboutlet+=` <option value="${value.id}" >${value.suboutlet}</option>`;
         //    listsuboutlet[value.id] = value;

         // });
         $.each(data.jenis_member,function(key,value){
            select_jenis_member+=` <option value="${value.id}" >${value.jenis_member}</option>`;
             listjenis_member[value.id] = value;

         });
      }
      // $("#kode_cabang").append(select);
      $(".kode_cabang").append(select);
      $(".outlet").append(select_outlet);
      // $("#sub_outlet").append(select_suboutlet);
      $(".member").append(select_jenis_member);
   })
   $.getJSON(link + "/api/member/sms/all?", function(data) {
      // list select cabang
      if(data.data){
         $.each(data.data,function(key,value){
            select_sms+=` <option value="${value.sms_kodemonitoring}" >(${value.sms_kodemonitoring})- ${value.sms_namasms}</option>`;
             listkodesms[value.id] = value;
         });
      }
      // $("#kode_cabang").append(select);
      $(".kode_monitoring").append(select_sms);
   })
}

add =(data)=>{
   $('.text').val('Anda yakin untuk Menambah Data ini?')
   $('#form_data').submit();
}

update =(data)=>{
   $('.text').val('Anda yakin untuk Mengubah Data ini?')
   $('#form_data').submit();
}
remove =(data)=>{
   // $('#form_data').attr('action',link+'/api/remov/'+data.kode);
   $('.text').val('Anda yakin untuk Hapus Data ini?')
   hapus(selectedData.kode,'api/remove')
   // $('#form_data').submit();
}

pencarian=()=>{
   reset_selected();
}

selectedValue =(kode)=>{
   selectedData  = dataSms[kode];
}

reset_selected=()=>{
   selectedData  =  [];
   $('.tombol_edit').prop('disabled',true);
   $('.tombol_hapus').prop('disabled',true);
   $('#table_cabang tbody tr').removeClass('selected-row');
   $('.tombol_reset').hide();
   if (search) {
      view();
   }

}
