hapus = (id,url) => {
    let csrf = $('meta[name="csrf-token"]').attr('content');
    Swal.fire({
        title: 'Apakah Anda yakin menghapus data ini?',
        showCancelButton: true,
        confirmButtonText: `Ya`,
        cancelButtonText: `Tidak`,
    }).then((result) => {
        /* Read more about isConfirmed, isDenied below */
        if (result.value) {
            Swal.fire({
                    title: 'Loading..',
                    html: '',
                    allowOutsideClick: false,
                    onOpen: () => {
                            swal.showLoading()
                    }
                });
            $.ajax({
                url: link + "/"+url+"/" + id,
                type: "POST",
                data: {
                    _method: "DELETE",
                    _token: csrf
                },
                success: function () {
                    Swal.fire('Berhasil!', 'Data Berhasil dihapus', 'success')
                    url == 'hasil/penilaian' || url == 'hasil/wawancara' ? location.reload() : '';
                    view();
                },
                error: function (xhr) {
                    let res = xhr.responseJSON,
                    messages = xhr.responseJSON.messages?xhr.responseJSON.messages:'Harap Periksa kembali data yang anda input';
                    
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
                }
            });
        }
    });

}