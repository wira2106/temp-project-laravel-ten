@extends('../master')
@section('content')

    <script> $(".nav-item-home").addClass("active"); </script>

    <div class="container-fluid">
        <div class="card-header">
           Master SMS
        </div>
        <div class="card shadow mb-4">
            <div class="card-body loading-card">
                <div class="container mt-4">
                    <!-- ============================ -->
                    <!--             Table            -->
                    <!-- ============================ -->
                    <div class="table-container" id="scrollContainer">
                        <table class="table table-bordered" id="table_cabang">
                        <thead>
                            <tr>
                            <th scope="col">Cabang</th>
                            <th scope="col">Kode</th>
                            <th scope="col">Nama SMS</th>
                            <th scope="col">Tgl Awal</th>
                            <th scope="col">Tgl Akhir</th>
                            <!-- Add more headers as needed -->
                            </tr>
                        </thead>
                        <tbody id="table-content">
                             
                        </tbody>
                        </table>
                    </div>
                    <!-- ============================ -->
                    <!--         End Table            -->
                    <!-- ============================ -->
                    
                

                    <div class="row mt-3">
                        <div class="col-md-6">
                            <div class="d-flex justify-content-start">
                                <input type="hidden" class="text">

                                <input type="hidden" name="multipleForm" id="multipleForm" value="2">
                                <input type="hidden" name="runNext2" id="runNext1" onchange="view(null,1)">
                                <button onclick="tambah()" type="button" data-toggle="modal" data-target="#modal_edit" class="mr-1 btn btn-lg btn-info">Tambah</button>
                                <button onclick="edit()" type="button" data-toggle="modal" data-target="#modal_edit" class="mr-1 btn btn-lg btn-info tombol_edit">Edit</button> 
                                <button onclick="remove()" type="button" class="mr-1 btn btn-lg btn-info tombol_hapus">Hapus</button> 
                                <button onclick="reset_selected()" type="button" class="mr-1 btn btn-lg btn-danger tombol_reset">Reset</button> 
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex justify-content-end">
                                <input type="hidden" class="text">
                                <button onclick="alokasi(this)" type="button" class="mr-1 btn btn-lg btn-info"  data-toggle="modal" data-target="#modal_csv" >CSV</button>
                            </div>
                        </div>
                    </div>
                    <!-- ============================ -->
                    <!--             Modal CSV        -->
                    <!-- ============================ -->
                    <div class="modal fade" id="modal_csv" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <!-- <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel"><span class="title modal_title_user"></span></h5>
                                </div> -->
                                <div class="modal-body tambah_perhitungan" style="margin:0px;">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="user-profile text-left">
                                                <div class="name text-black modal_title_form">Proses CSV</div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <button type="button" class="close  d-flex justify-content-right" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                    </div>
                                
                                    <!-- ================================== -->
                                    <!-- Modal Form CSV             -->
                                    <!-- ================================== -->

                                    <form action="{{url('/api/proses/csv')}}" method="post" class="form_data">
                                        @csrf
                                                <div class="row pt-md-4">
                                                    <div class="col-md-12">
                                                        <div class="form-groups row">
                                                            <label for="alasan_baru" class="col-sm-4 ">Kode Monitoring</label>
                                                            <div class="col-sm-8">
                                                                <select value=""  class="form-control kode_monitoring select2" name="kode_monitoring">
                                                                    <option value="" disabled selected>Pilih Kode Monitoring</option>
                                                                
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row pt-md-4">
                                                    <div class="col-md-12">
                                                        <div class="form-groups row">
                                                            <label for="alasan_baru" class="col-sm-4">Cabang</label>
                                                            <div class="col-sm-8">
                                                                <select value=""  class="form-control kode_cabang" name="cabang">
                                                                    <option value="" disabled selected>Pilih Kode Cabang</option>
                                                                
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row pt-md-4">
                                                    <div class="col-md-12">
                                                        <div class="form-groups row">
                                                            <label for="alasan_baru" class="col-sm-4">Member</label>
                                                            <div class="col-sm-8">
                                                                <select value=""  class="form-control " name="member">
                                                                    <option value="" disabled selected>Pilih Member</option>
                                                                    <option value="merah">Merah</option>
                                                                    <option value="reguler">Reguler</option>
                                                                
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row pt-md-4">
                                                    <div class="col-md-12">
                                                        <div class="form-groups row">
                                                            <label for="alasan_baru" class="col-sm-4">Group</label>
                                                            <div class="col-sm-8">
                                                                <select value=""  class="form-control member" name="group">
                                                                    <option value="" disabled selected>Pilih Group</option>
                                                                
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row pt-md-4">
                                                    <div class="col-md-12">
                                                        <div class="form-groups row">
                                                            <label for="alasan_baru" class="col-sm-4">Outlet</label>
                                                            <div class="col-sm-8">
                                                                <select value=""  class="form-control outlet" name="outlet">
                                                                    <option value="" disabled selected>Pilih Outlet</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row pt-md-4">
                                                    <div class="col-md-12">
                                                        <div class="form-groups row">
                                                            <label for="alasan_baru" class="col-sm-4">PKP</label>
                                                            <div class="col-sm-8">
                                                                <select value=""  class="form-control pkp" name="pkp">
                                                                    <option value="" disabled selected>Pilih PKP</option>
                                                                    <option value="1">Ya</option>
                                                                    <option value="">Tidak</option>
                                                                
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row pt-md-4">
                                                    <div class="col-md-12">
                                                        <div class="form-groups row">
                                                            <label for="alasan_baru" class="col-sm-4">Jumlah Member</label>
                                                            <div class="col-sm-8">
                                                                <input type="number" class="form-control form-control-sm" name="jumlah_member" value=""/>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row pt-md-4">
                                                    <div class="col-md-12">
                                                        <div class="form-groups row">
                                                            <label for="alasan_baru" class="col-sm-4">Jenis Hp</label>
                                                            <div class="col-sm-8">
                                                                <select value=""  class="form-control jenis_hp" name="jenis_hp">
                                                                    <option value="" disabled selected>Pilih Jenis Hp</option>
                                                                    <option value="GSM">GSM</option>
                                                                    <option value="CDMA">CDMA</option>
                                                                
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row pt-md-4">
                                                    <div class="col-md-12">
                                                        <div class="form-groups row">
                                                            <label for="alasan_baru" class="col-sm-4">Member Aktif Berbelanja</label>
                                                            <div class="col-sm-4">
                                                                <select value=""  class="form-control member_aktif_berbelanja" name="member_aktif_berbelanja">
                                                                    <option value="" disabled selected>Pilih Member Aktif Berbelanja</option>
                                                                    <option value="1">Ya</option>
                                                                    <option value="">Tidak</option>
                                                                
                                                                </select>
                                                            </div>
                                                            <div class="col-sm-4">
                                                                <input type="number" class="form-control form-control-sm" name="periode" value=""/>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- Button Submit -->
                                                <div class="d-flex justify-content-center mt-3">
                                                    <button class="btn btn-info px-4" type="submit">Proses CSV</button>
                                                    <!-- <button class="btn btn-danger mr-2" data-dismiss="modal" type="button">Cancel</button> -->
                                                </div>

                                    </form>
                                    <!-- ================================== -->
                                    <!-- End Modal Form CSV         -->
                                    <!-- ================================== -->

                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- ============================ -->
                    <!--         End Modal CSV        -->
                    <!-- ============================ -->
                     
                    <!-- ============================ -->
                    <!--             Modal Edit       -->
                    <!-- ============================ -->
                    <div class="modal fade" id="modal_edit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                            <div class="modal-content">
                                <!-- <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel"><span class="title modal_title_user"></span></h5>
                                </div> -->
                                <div class="modal-body tambah_perhitungan" style="margin:0px;">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="user-profile text-left">
                                                <div class="name text-black modal_title_form">Member Detail</div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <button type="button" class="close  d-flex justify-content-right" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                    </div>
                                
                                    <!-- ================================== -->
                                    <!-- Modal Form Perhitungan             -->
                                    <!-- ================================== -->

                                    <form action="" method="post" id="form_data">
                                        @csrf
                                                <div class="row pt-md-4">
                                                    <div class="col-md-12">
                                                        <div class="form-groups row">
                                                            <label for="alasan_baru" class="col-sm-4">Cabang</label>
                                                            <div class="col-sm-8">
                                                                <select value=""  class="form-control kode_cabang" name="cabang">
                                                                    <option value="" disabled selected>Pilih Cabang</option>
                                                                
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row pt-md-4">
                                                    <div class="col-md-12">
                                                        <div class="form-groups row">
                                                            <label for="alasan_baru" class="col-sm-4">Kode SMS</label>
                                                            <div class="col-sm-8">
                                                            <input type="text" class="form-control form-control-sm" id="datepicker" name="kode" value=""/>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row pt-md-4">
                                                    <div class="col-md-12">
                                                        <div class="form-groups row">
                                                            <label for="alasan_baru" class="col-sm-4">Nama SMS</label>
                                                            <div class="col-sm-8">
                                                            <input type="text" class="form-control form-control-sm" id="datepicker" name="nama_sms" value=""/>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row pt-md-4">
                                                    <div class="col-md-12">
                                                        <div class="form-groups row">
                                                            <label for="alasan_baru" class="col-sm-4">Periode</label>
                                                            <div class="col-sm-4">
                                                                <input type="date" class="form-control form-control-sm" id="datepicker" name="awal_tgl" value=""/>
                                                            </div>
                                                            <div class="col-sm-4">
                                                                <input type="date" class="form-control form-control-sm" id="datepicker" name="akhir_tgl" value=""/>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- Button Submit -->
                                                <div class="d-flex justify-content-end mt-2">

                                                    <input type="hidden" name="multipleForm" id="multipleForm" value="1">
                                                    <input type="hidden" name="runNext1" id="runNext1" onchange="view(null,1)">
                                                    <button class="btn btn-info px-4 button-save" type="submit">Save</button>
                                                    <button class="btn btn-danger mr-2" data-dismiss="modal" type="button">Cancel</button>
                                                </div>

                                    </form>
                                    <!-- ================================== -->
                                    <!-- End Modal Form Perhitungan         -->
                                    <!-- ================================== -->

                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- ============================ -->
                    <!--         End Modal Edit       -->
                    <!-- ============================ -->
                    
                </div>
            </div>
        </div>
    </div>

    <script src="{{asset('js/app-member-sms.js')}}"></script>
    <script src="{{asset('js/app-submitForm.js')}}"></script>
    <script src="{{asset('js/app-submitForm2.js')}}"></script>
    <script src="{{asset('js/app-hapus.js')}}"></script>
@endsection