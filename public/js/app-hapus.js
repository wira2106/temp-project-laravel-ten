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
                    Swal.fire({
                        title: 'Loading..',
                        html: '',
                        allowOutsideClick: false,
                        onOpen: () => {
                                swal.showLoading()
                        }
                    })
                }
            });
        }
    });

}