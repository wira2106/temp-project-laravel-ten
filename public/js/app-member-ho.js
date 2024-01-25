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

get_data_select=()=>{
   let select = "",
       select_outlet = "",
       select_suboutlet = "",
       select_jenis_member = "",
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
         $.each(data.suboutlet,function(key,value){
            select_suboutlet+=` <option value="${value.id}" >${value.suboutlet}</option>`;
            listsuboutlet[value.id] = value;

         });
         $.each(data.jenis_member,function(key,value){
            select_jenis_member+=` <option value="${value.id}" >${value.jenis_member}</option>`;
             listjenis_member[value.id] = value;

         });
      }
      $("#kode_cabang").append(select);
      $(".kode_cabang").append(select);
      $("#jenis_outlet").append(select_outlet);
      $("#sub_outlet").append(select_suboutlet);
      $("#jenis_cust").append(select_jenis_member);
   })
}

edit =()=>{
      let data = selectedData;
      console.log(data);
      $('.form_data').attr('action',link+'/api/member/edit');
      $("select[name='kode_cabang']").val(data.kode_cabang)
      $("input[name='alamat_surat']").val(data.alamat_surat)
      $("input[name='kode_member']").val(data.kode_member)
      $("input[name='kota']").val(data.kota)
      $("input[name='nama']").val(data.nama)
      $("input[name='kelurahan']").val(data.kelurahan)
      $("input[name='no_ktp']").val(data.no_ktp)
      $("input[name='kode_pos']").val(data.kode_pos)
      $("input[name='alamat_ktp']").val(data.alamat_ktp)
      $("input[name='no_hp']").val(data.no_hp)
      $("input[name='tgl_lahir']").val(data.tgl_lahir)
      $("input[name='kota_ktp']").val(data.kota_ktp)
      $("select[name='jenis_outlet']").val(data.jenis_outlet)
      $("input[name='kelurahan_ktp']").val(data.kelurahan_ktp)
      $("select[name='sub_outlet']").val(data.sub_outlet)
      $("input[name='kode_pos_ktp']").val(data.kode_pos_ktp)
      $("select[name='pkp']").val(data.pkp)
      $("input[name='area']").val(data.area)
      $("input[name='telepon']").val(data.telepon)
      $("select[name='kredit']").val(data.kredit)
      $("input[name='top']").val(data.top)
      $("select[name='jenis_cust']").val(data.jenis_cust)
      $("select[name='bebas_iuran']").val(data.bebas_iuran)
      $("select[name='retail_khusus']").val(data.retail_khusus)
      $("select[name='ganti_kartu']").val(data.ganti_kartu)
      $("input[name='jarak']").val(data.jarak)
      $("input[name='limit']").val(data.limit)
      $("input[name='npwp']").val(data.npwp)
      $("select[name='blocking_pengiriman']").val(data.blocking_pengiriman)
      $("input[name='salesman']").val(data.salesman)
      $("input[name='alamat_email']").val(data.alamat_email)
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
