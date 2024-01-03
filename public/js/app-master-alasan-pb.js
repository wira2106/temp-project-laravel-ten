let selectedData,
    dataAlasan =[],
    search  =  false,
    page = 1,
    no = 1,
    field = null;

$(document).ready(function(){
   hide_error_message();
   get_list_alasan()
   $('#alasan_dipilih').val().toUpperCase();
   $('#alasan_baru').val().toUpperCase();
   $('#table_alasan tbody').on('click', 'tr', function () {
        // Remove the 'selected-row' class from all rows
        $('#table_alasan tbody tr').removeClass('selected-row');

        // Add the 'selected-row' class to the clicked row
        $(this).addClass('selected-row');
              
        // Get Text in field data
        selectedData = $(this).find('td').map(function (data) {
            return $(this).text();
        }).get();
        selectedValue(selectedData[0],selectedData[1]);
    });

    $('#scrollContainer').on('scroll', function () {
        var container = $(this);
        // add more 1 because height scroll less 0.5
        if ((container.scrollTop() + container.innerHeight()) +1 >= container[0].scrollHeight) {
          // Load more data when scrolled to the bottom
          get_list_alasan();
        }
      });
});
get_list_alasan =(reset_page = false)=>{
    let select = "";
        dataAlasan = (reset_page)?[]:dataAlasan,
        field = (reset_page)?null:field,
        page = (reset_page)?1:page,
        no = (reset_page)?1:no;
        if (reset_page) {
            $('#scrollContainer').animate({ scrollTop: 0 }, 'fast');
            reset_alasan()
        }

    $('.container-fluid').loading('toggle');
    $.getJSON(link + "/api/get_list_alasan?page="+page, function(data) {
        $.each(data.data,function(key,value) {
            
            field+=`
                    
                     <tr>
                           <td style="display: none;">${no}</td>
                           <td>${value.alasan}</td>
                     </tr>
                  `;
                  dataAlasan[no] = value;
            no++
         });
    }).done(function() {

      $('.container-fluid').loading('toggle');
      $("#table-content").html(field);
      page++
   }); 
 
 }
add =(data)=>{
   $('#form_data').attr('action',link+'/api/add');
   $('.text').val('Tambah Alasan PB Darurat Baru?')
   $('#form_data').submit();
}
update =(data)=>{
   $('#form_data').attr('action',link+'/api/update');
   $('.text').val('Edit Alasan PB Darurat ini?')
   $('#form_data').submit();
}
hapus =(data)=>{
   $('#form_data').attr('action',link+'/api/delete');
   $('.text').val('Hapus Alasan PB Darurat ini?')
   $('#form_data').submit();
}
kirim =(data)=>{
   $('#form_data').attr('action',link+'/api/kirim');
   $('.text').val('Kirim')
   $('#form_data').submit();
}
hide_error_message = async ()=>{
    $('#error_alasan_baru').hide();
    $('#error_alasan_dipilih').hide();
    $('#reset_input').hide();
    disabled_switch(true)
}
selectedValue=(id,alasanDipilih)=>{
    console.log(id,alasanDipilih)
    $("input[name='alasan_dipilih']").val(alasanDipilih);
    $("input[name='id']").val(id);
    $('#reset_input').show();
    disabled_switch(false);
}
reset_alasan = ()=>{
    $("input[name='alasan_dipilih']").val('');
    $("input[name='alasan_baru']").val('');
    $("input[name='id']").val('');
    $('#reset_input').hide();
    $('#table_alasan tbody tr').removeClass('selected-row');
    disabled_switch(true)
}
disabled_switch =(condition =false)=>{
    let condition_add = !condition;
    $('#edit').prop('disabled',condition)
    $('#delete').prop('disabled',condition)
    $('#tambah').prop('disabled',condition_add)
}

