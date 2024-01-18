let selectedTable,
    selectedData  =  [],
    dataMember =[],
    listMasterProduk = [],
    listMasterLabel= [],
    search  =  false,
    page = 1,
    field = null,
    cabang = null,
    last_Selving = null,
    first_visit=true;
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

      $('.list-label').hide();
      $('.input-data').prop('disabled',true);
      $('.input-form').hide();
      $('.select2').select2({
         allowClear: false
      }); 
      $("#datepicker").datepicker({
         format: "dd-MM-yyyy",
         autoclose: true,
         todayHighlight: true
      });
      getDataProduk();
      getDataDivisi();
});

toggleInput =(nameClass)=>{

   $('#label-tag').loading('toggle');
   let className = '.'+nameClass;
   
   $('.input-form').hide();
   $('.input-data').prop('disabled',true);
   $(className).prop('disabled',false);
   $(className).show();
   if (first_visit) {
      $('.list-label').hide();

   }

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
   $('#label-tag').loading('toggle');

   let prdcd = $("#prdcd").val(),
       dataMasterProduk = listMasterProduk[prdcd];
       $("#desc").val(dataMasterProduk.deskripsi);
   
   $('#label-tag').loading('toggle');
}


changeRak=(dataRak)=>{
   let select = "",
       rak = $('#rak').val();

       tipe = $('#tipe').val('');
       sub_rak = $('#sub-rak').val('');
       $(".option-subrak").remove();
       $(".option-tipe").remove();
       $('#label-tag').loading('toggle');
   $.getJSON(link + "/api/label/data/sub_rak?rak="+rak, function(data) {

      // list select subrak=
      if(data){
         
         $.each(data,function(key,value){
               select+=` <option class="option-subrak"  value="${value.fmsrak}" > ${value.fmsrak} </option>`;
         });
         $("#sub-rak").append(select);
      }

   }).done(function(){

         $('#label-tag').loading('toggle');
   })
}
changeSubRak=(dataSubRak)=>{
   let select = "",
       rak = $('#rak').val(),
       sub_rak = $('#sub-rak').val();

       tipe = $('#tipe').val('');
       $(".option-tipe").remove();
      $('#label-tag').loading('toggle');
      $.getJSON(link + "/api/label/data/tipe_rak?sub_rak="+sub_rak+"&&rak="+rak, function(data) {

         // list select tipe rak
         if(data){
            $.each(data,function(key,value){
                  select+=` <option class="option-tipe"  value="${value.fmtipe}" > ${value.fmtipe} </option>`;
            });
            $("#tipe").append(select);
         }

      }).done(function(){

         $('#label-tag').loading('toggle');
      })
}
changeTipeRak=(dataSubRak)=>{
   let select = "",
       tipe = $('#tipe').val(),
       rak = $('#rak').val(),
       sub_rak = $('#sub-rak').val()
       length_Selving = 0;
   
       $(".option-sheving").remove();
       $('#label-tag').loading('toggle');
      $.getJSON(link + "/api/label/data/shelving_rak?sub_rak="+sub_rak+"&&rak="+rak+"&&tipe="+tipe, function(data) {

         // list select tipe rak
         if(data){
            length_Selving = data.length;
            last_Selving =parseInt(data[(length_Selving-1)].fmselv);
            $.each(data,function(key,value){
                  select+=` <option class="option-sheving"  value="${parseInt(value.fmselv)}" > ${parseInt(value.fmselv)} </option>`;
            });
            $("#select1").append(select);
         }

      }).done(function(){

         $('#label-tag').loading('toggle');
      })
}

changeDiv=(dataDiv)=>{
   let select = "",
   div = $('#div').val();

       dept = $('#dept').val('');
       katb = $('#katb').val('');
       $(".option-dept").remove();
       $(".option-katb").remove();
       $('#label-tag').loading('toggle');
   $.getJSON(link + "/api/label/data/dept?div="+div, function(data) {

      // list select subrak=
      if(data){
         
         $.each(data,function(key,value){
               select+=` <option class="option-dept"  value="${value.dep_kodedepartement}" >${value.dep_kodedepartement} - ${value.dep_namadepartement} </option>`;
         });
         $("#dept").append(select);
      }

   }).done(function(){

         $('#label-tag').loading('toggle');
   })
}

changeDept=(dataDept)=>{
   let select = "",
      dept = $('#dept').val(),
      div = $('#div').val();

       katb = $('#katb').val('');
       $(".option-katb").remove();
       $('#label-tag').loading('toggle');
   $.getJSON(link + "/api/label/data/katb?div="+div+"&&dept="+dept, function(data) {

      // list select subrak=
      if(data){
         
         $.each(data,function(key,value){
               select+=` <option class="option-katb"  value="${value.kat_kodekategori}" >(${value.kat_kodedepartement})${value.kat_kodekategori} - ${value.kat_namakategori} </option>`;
         });
         $("#katb").append(select);
      }

   }).done(function(){

         $('#label-tag').loading('toggle');
   })
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
   for (let i = 1; i <= last_Selving; i++) {
     // Add an option only if it's greater than the selected value in Select 1
     if (i >= selectedValue) {
       const option = document.createElement("option");
       option.value = i;
       option.text = `${i}`;
       select2.appendChild(option);
     }
   }
 }

getDataDivisi =()=>{
   let select = "";
   $.getJSON(link + "/api/label/data/divisi", function(data) {

      // list select divisi
      if(data){
         $.each(data,function(key,value){
               select+=` <option value="${value.div_kodedivisi}" >(${value.div_kodedivisi}) - ${value.div_namadivisi}</option>`;

         });
         $("#div").append(select);
      }

   })

}

getDataProduk =()=>{
   let select = "";
       listMasterProduk = [];
   $.getJSON(link + "/api/label/data/produk?first_visit="+first_visit, function(data) {

      // list select cabang
      if(data.data){
         $.each(data.data,function(key,value){
               select+=` <option value="${value.prdcd}" >(${value.prdcd}) - ${value.deskripsi}</option>`;
               listMasterProduk[value.prdcd] = value;

         });
         $("#prdcd").append(select);
      }

   }).done(function() {
      if (first_visit) {
         first_visit = false;
      }
   });

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
              
          $('#label-tag').loading('toggle');
          console.log('lewat');
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
