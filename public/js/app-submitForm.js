$('#form_data').submit(function (e) {
    e.preventDefault();
    let form = $('#form_data'),
        text = $('.text').val()?$('.text').val():'Menyimpan',
        url = form.attr('action'),
        method = form.attr('method') == undefined ? 'PUT' : 'POST',
        redirect = $("input[name='redirect']").val(),
        download = $("input[name='download']").val();
    form.find('.form-control').removeClass('is-invalid');
    form.find('.help-block').remove();
    Swal.fire({
        title: 'Apakah Anda ingin '+text+' Data Ini?',
        showDenyButton: true,
        showCancelButton: true,
        confirmButtonText: `Ya`,
        denyButtonText: `Tidak`,
    }).then((result) => {
    /* Read more about isConfirmed, isDenied below */
        if (result.value) {
            load = 1;
             Swal.fire({
                title: 'Loading..',
                html: '',
                allowOutsideClick: false,
                onOpen: () => {
                        swal.showLoading()
                }
            });
            $.ajax({
                url: url,
                method: method,
                data: new FormData(this),
    
                success: function (response) {
                    Swal.fire(
                        'Tersimpan!',
                        'Data telah tersimpan.',
                        'success'
                    )
                   if(download !== '' && download !== null && download !== undefined){
                       window.open(download,'_blank');
                   } 
                    window.location.href = redirect
                },
                error: function (xhr) {
                    Swal.fire(
                        'Tersimpan!',
                        'Data telah tersimpan.',
                        'success'
                    )
                     Swal.fire({
                        title: 'Data tidak dapat di Simpan',
                        html: 'Harap Isi Dengan Benar',
                        icon: 'warning',
                        allowOutsideClick: false,
                        onOpen: () => {
                                swal.hideLoading()
                        }
                    });
                    let res = xhr.responseJSON;
                    console.log(res);
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
            });  
        }
    });
});