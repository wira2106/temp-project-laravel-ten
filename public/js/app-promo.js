let selectedTable,
    selectedData  =  [],
    dataMember =[],
    listMasterPromo = [],
    listMasterLabel= [],
    search  =  false,
    page = 1,
    field = null,
    cabang = null,
    checkbox = $('#checkbox1').val();
var temp_function_deleteAll = null,
    temp_function_viewHasil = null;

$(document).ready(function(){
      $('#table_cabang tbody').on('click', 'tr', function () {
         
         // Remove the 'selected-row' class from all rows
         $('#table_cabang tbody tr').removeClass('selected-row');

         // Add the 'selected-row' class to the clicked row
         $(this).addClass('selected-row');
               
         // Get Text in field data
         selectedTable = $(this).find('td').map(function (data) {
               return $(this).text();
         }).get();
         
         selectedValue(selectedTable[1]);

      });

      $('#scrollContainer').on('scroll', function () {
         var container = $(this);
         if (container.scrollTop() + container.innerHeight() >= container[0].scrollHeight) {
         // Load more data when scrolled to the bottom
         // view();
         }
      });

      $('.select2').select2({
         allowClear: false
      }); 
      $("#datepicker").datepicker({
         format: "dd-MM-yyyy",
         autoclose: true,
         todayHighlight: true
      });
      $('#checkbox1').change(function() {
         $('#prdcd').prop('disabled', $(this).prop('checked'));
         $('#select1').prop('disabled', !$(this).prop('checked'));
         $('#select2').prop('disabled', !$(this).prop('checked'));
       });
      getDataPromo();
      // getDataDivisi();
      
});

toggleInput =(nameClass)=>{

   $('#label-tag').loading('toggle');
   let className = '.'+nameClass;
   
   $('.input-form').hide();
   $('.input-data').prop('disabled',true);
   $(className).prop('disabled',false);
   $(className).show();
   $('.list-label').hide();

    listMasterLabel= [];
    search  =  false;
    page = 1;
    field = null;
    cabang = null;
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
   let csrf = $('meta[name="csrf-token"]').attr('content'),
       formCheckPRDCD = new FormData(),
       prdcd = $('#prdcd').val();

   formCheckPRDCD.append('_token', csrf);
   formCheckPRDCD.append('prdcd', prdcd);

   $('#label-tag').loading('toggle');
   $.ajax({
      url: link+'/api/promo/check_prdcd',
      method: 'POST',
      data: formCheckPRDCD,

      success: function (response) {

          // console.log(response.download,response.redirect,runNext,multipleForm)
          let messages = response.messages?response.messages:'Data Berhasil Dihapus';
          Swal.fire(
              'Berhasil',
               messages,
              'success'
          )
         //  getDataLabel('');
      },
      error: function (xhr) {

          let res = xhr.responseJSON,
              messages = xhr.responseJSON.messages?xhr.responseJSON.messages:'Proses Hapus Gagal';
             
         $('#label-tag').loading('toggle');  
           Swal.fire({
              title: 'Gagal',
              html: messages,
              icon: 'warning',
              allowOutsideClick: false,
              onOpen: () => {
                      swal.hideLoading()
              }
          });
          if ($.isEmptyObject(res) == false) {
              $.each(res.errors, function (i, value) {
                  $('#' + i).addClass('is-invalid');
                  $('.' + i).append('<span class="help-block"><strong>' + value + '</strong></span>')
              })
          }

      },
      cache: false,
      contentType: false,
      processData: false,
      dataType: "json"
  }).done(function () {

   $('#label-tag').loading('toggle');
  });  
}

getDataPromo =()=>{
   let select = "";
       listMasterPromo = [];
   
   $('#label-tag').loading('toggle');
   $.getJSON(link + "/api/promo/data/promo", function(data) {

      // list select cabang
      console.log(data)
      if(data.data){
         $.each(data.data,function(key,value){
               select+=` <option value="${value.brg_prdcd}" >(${value.brg_prdcd}) - ${value.brg_merk} || ${value.brg_nama} || ${value.brg_ukuran} || (${value.prmd_tglawal+"-"+value.prmd_tglakhir})</option>`;
               listMasterPromo[value.prdcd] = value;

         });
         $("#prdcd").append(select);
         $("#select1").append(`<option value="${data.tgl_awal}" >${data.tgl_awal}</option>`);
         $("#select2").append(`<option value="${data.tgl_akhir}" >${data.tgl_akhir}</option>`);
      }

   }).done(function(){

      $('#label-tag').loading('toggle');
   })

}
getDataLabel =(params = null)=>{
   let no = 0;
       field = null;
       
   $("#table-content").html('');
   if (params) {
      isJSON(params)?params = "pcrd="+params:params;
      temp_function_viewHasil = function(){window.open(link+'/cetak?'+params,'_blank');}
      $('#label-tag').loading('toggle');
      $.getJSON(link + "/api/label/data/label?"+params, function(data) {
   
         $('.list-label').show();
         if(data.data){
            $.each(data.data,function(key,value){
                  listMasterLabel[key] = value;
                  field+=`
                       
                  <tr>
                     <td>${value.ipadd?value.ipadd:'-'}</td> 
                     <td>${value.prdcd?value.prdcd:'-'}</td> 
                     <td>${value.kplu?value.kplu:'-'}</td> 
                     <td>${value.nama1?value.nama1:'-'}</td> 
                     <td>${value.nama2?value.nama2:'-'}</td> 
                     <td>${value.barc?value.barc:'-'}</td> 
                     <td>${value.jml1?value.jml1:'-'}</td> 
                     <td>${value.jml2?value.jml2:'-'}</td> 
                     <td>${value.jml3?value.jml3:'-'}</td> 
                     <td>${value.unit1?value.unit1:'-'}</td> 
                     <td>${value.unit2?value.unit2:'-'}</td> 
                     <td>${value.unit3?value.unit3:'-'}</td> 
                     <td>${value.price_all1?value.price_all1:'-'}</td> 
                     <td>${value.price_all2?value.price_all2:'-'}</td> 
                     <td>${value.price_all3?value.price_all3:'-'}</td> 
                     <td>${value.price_unit1?value.price_unit1:'-'}</td> 
                     <td>${value.price_unit2?value.price_unit2:'-'}</td> 
                     <td>${value.price_unit3?value.price_unit3:'-'}</td> 
                     <td>${value.fmbsts?value.fmbsts:'-'}</td> 
                     <td>${value.flag?value.flag:'-'}</td> 
                     <td>${value.lokasi?value.lokasi:'-'}</td> 
                     <td>${value.fmkdsb?value.fmkdsb:'-'}</td> 
                     <td>${value.statusppn?value.statusppn:'-'}</td> 
                     <td>${value.statusppn?value.tempo:'-'}</td> 
                     <td>${value.statusppn?value.tempo1:'-'}</td> 
                     <td>${value.tglinsert?value.tglinsert:'-'}</td> 
                     <td>${value.lrec?value.lrec:'-'}</td> 
                     <td>${value.div?value.div:'-'}</td> 
                     <td>${value.dept?value.dept:'-'}</td> 
                     <td>${value.katb?value.katb:'-'}</td> 
                  </tr>
               `;
                no++
            });
         }
   
      }).done(function() {
   
         $('#button_view_hasil').prop('disabled',false);
         $('#button_delete_all').prop('disabled',false);
         $('#label-tag').loading('toggle');
         $("#table-content").html(field);
      }); 
   }

}


submitByPLU =(button)=>{
   let prdcd =null,
       qty = null,
       satuan = null,
       formDataHapus = new FormData();

    let csrf = $('meta[name="csrf-token"]').attr('content');
   
   //defind field formData for delete label
   formDataHapus.append('prdcd', prdcd);
   formDataHapus.append('qty', qty);
   formDataHapus.append('satuan', satuan);
   formDataHapus.append('_token', csrf);
   $(button).submit();
   // temp_function_viewHasil = deleteDataLable(formDataHapus);
   // temp_function_deleteAll = getDataLabel(['params'])
   temp_function_deleteAll = function(){deleteDataLable(formDataHapus);}
   // temp_function_viewHasil = function(){window.open(link+'/cetak','_blank');;}
}

submitByRak =(button)=>{
   let formDataHapus = new FormData();

    let csrf = $('meta[name="csrf-token"]').attr('content');
   
   //defind field formData for delete label
   formDataHapus.append('_token', csrf);
   $(button).submit();
   // temp_function_viewHasil = deleteDataLable(formDataHapus);
   // temp_function_deleteAll = getDataLabel(['params'])
   temp_function_deleteAll = function(){deleteDataLable(formDataHapus);}
   // temp_function_viewHasil = function(){window.open(link+'/cetak','_blank');;}
}

submitByDiv =(button)=>{
   let formDataHapus = new FormData();

    let csrf = $('meta[name="csrf-token"]').attr('content');
   
   //defind field formData for delete label
   formDataHapus.append('_token', csrf);
   $(button).submit();
   // temp_function_viewHasil = deleteDataLable(formDataHapus);
   // temp_function_deleteAll = getDataLabel(['params'])
   temp_function_deleteAll = function(){deleteDataLable(formDataHapus);}
   // temp_function_viewHasil = function(){window.open(link+'/cetak','_blank');;}
}

submitByTanggal =(button)=>{
   let formDataHapus = new FormData();

    let csrf = $('meta[name="csrf-token"]').attr('content');
   
   //defind field formData for delete label
   formDataHapus.append('_token', csrf);
   $(button).submit();
   // temp_function_viewHasil = deleteDataLable(formDataHapus);
   // temp_function_deleteAll = getDataLabel(['params'])
   temp_function_deleteAll = function(){deleteDataLable(formDataHapus);}
   // temp_function_viewHasil = function(){window.open(link+'/cetak','_blank');;}
}

submitBySetting =(button)=>{
   let formDataHapus = new FormData();

    let csrf = $('meta[name="csrf-token"]').attr('content');
   
   //defind field formData for delete label
   formDataHapus.append('_token', csrf);
   $(button).submit();
   // temp_function_viewHasil = deleteDataLable(formDataHapus);
   // temp_function_deleteAll = getDataLabel(['params'])
   temp_function_deleteAll = function(){deleteDataLable(formDataHapus);}
   // temp_function_viewHasil = function(){window.open(link+'/cetak','_blank');;}
}

submitByFlag =(button)=>{
   let formDataHapus = new FormData();

    let csrf = $('meta[name="csrf-token"]').attr('content');
   
   //defind field formData for delete label
   formDataHapus.append('_token', csrf);
   $(button).submit();
   // temp_function_viewHasil = deleteDataLable(formDataHapus);
   // temp_function_deleteAll = getDataLabel(['params'])
   temp_function_deleteAll = function(){deleteDataLable(formDataHapus);}
   // temp_function_viewHasil = function(){window.open(link+'/cetak','_blank');;}
}

deleteDataLable=(data = null)=>{

   $('#label-tag').loading('toggle');
   $.ajax({
      url: link+'/api/label/delete',
      method: 'POST',
      data: data,

      success: function (response) {

          // console.log(response.download,response.redirect,runNext,multipleForm)
          let messages = response.messages?response.messages:'Data Berhasil Dihapus';
          Swal.fire(
              'Berhasil',
               messages,
              'success'
          )
          getDataLabel('');
      },
      error: function (xhr) {

          let res = xhr.responseJSON,
              messages = xhr.responseJSON.messages?xhr.responseJSON.messages:'Proses Hapus Gagal';
              
           Swal.fire({
              title: 'Gagal',
              html: messages,
              icon: 'warning',
              allowOutsideClick: false,
              onOpen: () => {
                      swal.hideLoading()
              }
          });
          if ($.isEmptyObject(res) == false) {
              $.each(res.errors, function (i, value) {
                  $('#' + i).addClass('is-invalid');
                  $('.' + i).append('<span class="help-block"><strong>' + value + '</strong></span>')
              })
          }
      },
      cache: false,
      contentType: false,
      processData: false,
      dataType: "json"
  }).done(function () {

   $('#label-tag').loading('toggle');
  });  

}

deleteAll =()=>{

    temp_function_deleteAll.call();

 }
viewHasil =()=>{

    temp_function_viewHasil.call();

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


isJSON=(str)=>{
   try {
     JSON.parse(str);
     return true;
   } catch (e) {
     return false;
   }
 }
