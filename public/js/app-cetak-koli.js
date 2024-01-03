let selectedTable,
    selectedData  =  [],
    dataMember =[],
    listMasterProduk = [],
    search  =  false,
    page = 1,
    field = null,
    cabang = null;

$(document).ready(function(){
      get_last_row();
      get_set_koli_omi();
       // Add event listener to input1
      //  $('#input1').on('input', function() {
      //    validateInputs();
      //  });
   
       // Add event listener to input2
      //  $('#input2').on('input', function() {
      //    console.log($(this).val());
      //    validateInputs();
      //  });
       $('.select2').select2({
         allowClear: false
      }); 
      $('#selectInput').select2();

      // input PLU event
      $('#prdcd_deskripsi').on('keydown', function (event) {
         if (event.which === 13) {
             // Enter key pressed, make the input value even
             check_plu();
             event.preventDefault(); // Prevent the default Enter key behavior
         }
     });
      
});

check_plu =()=>{
   let prdcd = $('#prdcd_deskripsi').val();
   $('.card_loading').loading('toggle');
   $.getJSON(link + "/api/obi/check_plu?prdcd="+prdcd, function(data) {

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
      } else {
         $('#prdcd_deskripsi').val('('+data.data.prdcd+') - '+data.data.deskripsi);
         $('#prdcd').val(data.data.prdcd);
      }
      $('.card_loading').loading('toggle');

   })

}
get_last_row =()=>{
   let select = "";
       listMasterProduk = [];
   $.getJSON(link + "/api/obi/get_last_row", function(data) {

      $('#nomor_terakhir_display').val(data.data.nomor_terakhir_display);
      $('#nomor_terakhir').val(data.data.nomor_terakhir);
   })

}
get_set_koli_omi =()=>{
   $.getJSON(link + "/api/koli/get_set_koli_omi", function(data) {

      $('#nomor_terakhir_koli').val(data.data);
   })

}

cetak_plu=(cetak)=>{
   let prdcd = $('#prdcd').val();

      if (prdcd !== "") {
         $(cetak).submit();
      } else {
         check_plu();
      }
}
cetak_koli=(cetak)=>{
   let jarak_atas = $("#jarak_atas").val(),
       jarak_kiri = $("#jarak_kiri").val();

        $("#jarak_atas_koli").val(jarak_atas),
        $("#jarak_kiri_koli").val(jarak_kiri),

       $(cetak).submit();
}
cetak_koli_reprint=(cetak)=>{
   let jarak_atas = $("#jarak_atas").val(),
       nomor_terakhir = $("#nomor_terakhir_koli").val(),
       idm = $("#idm_koli").val(),
       jarak_kiri = $("#jarak_kiri").val();

        $("#jarak_atas_koli_reprint").val(jarak_atas),
        $("#jarak_kiri_koli_reprint").val(jarak_kiri),
        $("#idm_reprint").val(idm),
        $("#nomor_terakhir_koli_reprint").val(nomor_terakhir),

       $(cetak).submit();
}
cetak_omi=(cetak)=>{
   let jarak_atas = $("#jarak_atas").val(),
       jarak_kiri = $("#jarak_kiri").val();

        $("#jarak_atas_omi").val(jarak_atas),
        $("#jarak_kiri_omi").val(jarak_kiri),
       $(cetak).submit();
}
cetak_omi_reprint=(cetak)=>{
   let jarak_atas = $("#jarak_atas").val(),
       jarak_kiri = $("#jarak_kiri").val(),
       nomor_terakhir_display = $("#nomor_terakhir_display").val(),
       nomor_terakhir = $("#nomor_terakhir").val();

        $("#jarak_atas_omi_reprint").val(jarak_atas)
        $("#jarak_kiri_omi_reprint").val(jarak_kiri)
        $("#nomor_terakhir_display_reprint").val(nomor_terakhir_display)
        $("#nomor_terakhir_reprint").val(nomor_terakhir)

       $(cetak).submit();
}
cetak_reprint_checker=(cetak)=>{
   let nomor_koli = $("input[name='nomor_koli']").val(),
       link_cetak = link+'/print/reprint_checker?nomor_koli='+nomor_koli;

      //  $("input[name='download5']").val(link_cetak);
       $(cetak).submit();
}

validateInputs =()=> {
   var input1Value = parseInt($('#input1').val());
   var input2Value = parseInt($('#input2').val());

   // Disable input2 if input1 is null
   if (!input1Value) {
     $('#input2').prop('disabled', true);
   } else {
     $('#input2').prop('disabled', false);

     // Ensure input1 < input2
     if (input1Value >= input2Value) {
       // Adjust input2 value if necessary
       $('#input2').val(input1Value++);
     }
   }
 }

toggleInput =(nameClass)=>{

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
changePRDCD=()=>{
   $('#label-tag').loading('toggle');

   let prdcd = $("#prdcd").val(),
       dataMasterProduk = listMasterProduk[prdcd];
       $("#desc").val(dataMasterProduk.deskripsi);
   
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
