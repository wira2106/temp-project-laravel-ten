let selectedTable,
    selectedData  =  [],
    dataMember =[],
    listCabang = [],
    search  =  false,
    page = 1,
    field = null,
    cabang = null;

$(document).ready(function(){

   $('.tombol_edit').prop('disabled',true);
   $('.tombol_reset').hide();
   view();
//    $('.select2').select2({
//       allowClear: true
//   }); 
   
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
      if (container.scrollTop() + container.innerHeight() >= container[0].scrollHeight) {
        // Load more data when scrolled to the bottom
        view();
      }
    });
});

view =(search = null)=>{
   reset_selected();

   $('#table_member tbody').loading('toggle');

   let select = "";
       listCabang = [];
   $.getJSON(link + "/api/member/data?search"+search+"&page="+page, function(data) {
      
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

edit =()=>{
      let data = selectedData;
      
      $('#form_data').attr('action',link+'/api/add');
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
      $("input[name='jenis_outlet']").val(data.jenis_outlet)
      $("input[name='kelurahan_ktp']").val(data.kelurahan_ktp)
      $("input[name='sub_outlet']").val(data.sub_outlet)
      $("input[name='kode_pos_ktp']").val(data.kode_pos_ktp)
      $("input[name='pkp']").val(data.pkp)
      $("input[name='area']").val(data.area)
      $("input[name='telepon']").val(data.telepon)
      $("input[name='kredit']").val(data.kredit)
      $("input[name='top']").val(data.top)
      $("input[name='jenis_cust']").val(data.jenis_cust)
      $("input[name='bebas_iuran']").val(data.bebas_iuran)
      $("input[name='retail_khusus']").val(data.retail_khusus)
      $("input[name='ganti_kartu']").val(data.ganti_kartu)
      $("input[name='jarak']").val(data.jarak)
      $("input[name='limit']").val(data.limit)
      $("input[name='npwp']").val(data.npwp)
      $("input[name='blocking_pengiriman']").val(data.blocking_pengiriman)
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
