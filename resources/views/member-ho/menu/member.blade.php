@extends('../master')
@section('content')

    <script> $(".nav-item-home").addClass("active"); </script>

    <div class="container-fluid">
        <div class="card-header">
           View Member
        </div>
        <div class="card shadow mb-4">
            <div class="card-body loading-card">
                <div class="container mt-4">
                    <!-- ============================ -->
                    <!--             Table            -->
                    <!-- ============================ -->
                    <div class="table-container" id="scrollContainer">
                        <table class="table table-bordered" id="table_member">
                        <thead>
                            <tr>
                            <th scope="col">Kode IGR</th>
                            <th scope="col">Kode Member</th>
                            <th scope="col">Nama Member</th>
                            <th scope="col">Alamat Member</th>
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
                                <button onclick="pencarian()" type="button" data-toggle="modal" data-target="#modal_search" class="mr-1 btn btn-lg btn-info">Search</button>
                                <button onclick="edit()" type="button" data-toggle="modal" data-target="#modal_edit" class="mr-1 btn btn-lg btn-default tombol_edit">Edit</button> 
                                <button onclick="reset_selected()" type="button" class="mr-1 btn btn-lg btn-danger tombol_reset">Reset</button> 
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex justify-content-end">
                                <button onclick="alokasi(this)" type="button" class="mr-1 btn btn-lg btn-info"  data-toggle="modal" data-target="#modal_alokasi" >Alokasi</button>
                            </div>
                        </div>
                    </div>
                    <!-- ============================ -->
                    <!--             Modal Alokasi    -->
                    <!-- ============================ -->
                    <div class="modal fade" id="modal_alokasi" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <!-- <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel"><span class="title modal_title_user"></span></h5>
                                </div> -->
                                <div class="modal-body tambah_perhitungan" style="margin:0px;">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="user-profile text-left">
                                                <div class="name text-black modal_title_form">Alokasi Member Baru</div>
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

                                    <form action="{{url('/api/member/alokasi')}}" method="post" class="form_data">
                                        @csrf
                                                <div class="row pt-md-4">
                                                    <div class="col-md-12">
                                                        <div class="form-groups row">
                                                            <label for="alasan_baru" class="col-sm-4">Cabang</label>
                                                            <div class="col-sm-8">
                                                                <div class="form-group">
                                                                    <select value=""  class="form-control kode_cabang" name="kode_cabang">
                                                                        <option value="" disabled selected>Pilih Cabang</option>
                                                                    
                                                                    </select>
                                                                </div>
                                                                <!-- <input type="text" class="form-control form-control-sm kode_cabang"  name="kode_cabang"> -->
                                                                <!-- <small id="error_alasan_baru" class="form-text text-muted">We'll never share your email with anyone else.</small> -->
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-4">
                                                    </div>
                                                    <div class="col-md-8">
                                                        <div class="form-groups">
                                                            <input type="checkbox" class="" id="member_merah"  name="member_merah">
                                                            <label for="member_merah" class="col-sm-8">Member Merah</label>
                                                            
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row pt-md-4">
                                                    <div class="col-md-12">
                                                        <div class="form-groups row">
                                                            <label for="alasan_baru" class="col-sm-4">Jumlah Alokasi</label>
                                                            <div class="col-sm-8">
                                                                <input type="text" class="form-control form-control-sm"  name="jumlah_alokasi">
                                                                <!-- <small id="error_alasan_baru" class="form-text text-muted">We'll never share your email with anyone else.</small> -->
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- Button Submit -->
                                                <div class="d-flex justify-content-center mt-3">

                                                    <input type="hidden" class="form-control form-control-sm text"  name="text" value="Anda Yakin Mua melakukan Alokasi Member Baru">
                                                    <button class="btn btn-info px-4" type="submit">ALOKASI</button>
                                                    <!-- <button class="btn btn-danger mr-2" data-dismiss="modal" type="button">Cancel</button> -->
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
                    <!--         End Modal Alokasi    -->
                    <!-- ============================ -->
                    <!-- ============================ -->
                    <!--             Modal Search     -->
                    <!-- ============================ -->
                    <div class="modal fade" id="modal_search" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
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

                                    <form action="" method="post" class="form_data">
                                        @csrf
                                                <div class="row pt-md-4">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <p class="font-weight-light">Masukan Nama/ Kode yang ingin dicari</p>
                                                            <input type="text" class="form-control form-control-sm" placeholder="Nama / Kode" id="search" name="search" value=""/>
                                                            <div class="search">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- Button Submit -->
                                                <div class="d-flex justify-content-end">
                                                    <button class="btn btn-info px-4" type="button" onclick="view($('#search').val(),1)">OK</button>
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
                    <!--         End Modal Search     -->
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
                                    <!-- Modal Form                         -->
                                    <!-- ================================== -->

                                    <form action="" method="post" class="form_data">
                                        @csrf
                                                <div class="row pt-md-4">
                                                    <div class="col-md-6">
                                                        <div class="form-groups row">
                                                            <label for="alasan_baru" class="col-sm-4">Kode Cabang</label>
                                                            <div class="col-sm-8">
                                                                <div class="form-group">
                                                                    <select value="" id="kode_cabang" class="form-control" name="kode_cabang">
                                                                        <option value="" disabled selected>Pilih Cabang</option>
                                                                    
                                                                    </select>
                                                                </div>
                                                                <!-- <small id="error_alasan_baru" class="form-text text-muted">We'll never share your email with anyone else.</small> -->
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-groups row">
                                                            <label for="alasan_baru" class="col-sm-4">Alamat Surat</label>
                                                            <div class="col-sm-8">
                                                                <input type="text" class="form-control form-control-sm"  name="alamat_surat">
                                                                <!-- <small id="error_alasan_baru" class="form-text text-muted">We'll never share your email with anyone else.</small> -->
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row pt-md-4">
                                                    <div class="col-md-6">
                                                        <div class="form-groups row">
                                                            <label for="alasan_baru" class="col-sm-4">Kode Member</label>
                                                            <div class="col-sm-8">
                                                                <input type="text" class="form-control form-control-sm"  name="kode_member" readonly style="background-color: #eaecf4;">
                                                                <!-- <small id="error_alasan_baru" class="form-text text-muted">We'll never share your email with anyone else.</small> -->
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-groups row">
                                                            <label for="alasan_baru" class="col-sm-4">Kota</label>
                                                            <div class="col-sm-8">
                                                                <input type="text" class="form-control form-control-sm"  name="kota">
                                                                <!-- <small id="error_alasan_baru" class="form-text text-muted">We'll never share your email with anyone else.</small> -->
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row pt-md-4">
                                                    <div class="col-md-6">
                                                        <div class="form-groups row">
                                                            <label for="alasan_baru" class="col-sm-4">Nama</label>
                                                            <div class="col-sm-8">
                                                                <input type="text" class="form-control form-control-sm"  name="nama">
                                                                <!-- <small id="error_alasan_baru" class="form-text text-muted">We'll never share your email with anyone else.</small> -->
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-groups row">
                                                            <label for="alasan_baru" class="col-sm-4">Kelurahan</label>
                                                            <div class="col-sm-8">
                                                                <input type="text" class="form-control form-control-sm"  name="kelurahan">
                                                                <!-- <small id="error_alasan_baru" class="form-text text-muted">We'll never share your email with anyone else.</small> -->
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row pt-md-4">
                                                    <div class="col-md-6">
                                                        <div class="form-groups row">
                                                            <label for="alasan_baru" class="col-sm-4">No. KTP</label>
                                                            <div class="col-sm-8">
                                                                <input type="text" class="form-control form-control-sm"  name="no_ktp">
                                                                <!-- <small id="error_alasan_baru" class="form-text text-muted">We'll never share your email with anyone else.</small> -->
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-groups row">
                                                            <label for="alasan_baru" class="col-sm-4">Kode pos</label>
                                                            <div class="col-sm-8">
                                                                <input type="text" class="form-control form-control-sm"  name="kode_pos">
                                                                <!-- <small id="error_alasan_baru" class="form-text text-muted">We'll never share your email with anyone else.</small> -->
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row pt-md-4">
                                                    <div class="col-md-6">
                                                        <div class="form-groups row">
                                                            <label for="alasan_baru" class="col-sm-4">Alamat KTP</label>
                                                            <div class="col-sm-8">
                                                                <input type="text" class="form-control form-control-sm"  name="alamat_ktp">
                                                                <!-- <small id="error_alasan_baru" class="form-text text-muted">We'll never share your email with anyone else.</small> -->
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-groups row">
                                                            <label for="alasan_baru" class="col-sm-4">No. HP</label>
                                                            <div class="col-sm-8">
                                                                <input type="text" class="form-control form-control-sm"  name="no_hp">
                                                                <!-- <small id="error_alasan_baru" class="form-text text-muted">We'll never share your email with anyone else.</small> -->
                                                            </div>
                                                            <label for="alasan_baru" class="col-sm-4">Tgl Lahir</label>
                                                            <div class="col-sm-8">
                                                                <input type="text" class="form-control form-control-sm"  name="tgl_lahir">
                                                                <!-- <small id="error_alasan_baru" class="form-text text-muted">We'll never share your email with anyone else.</small> -->
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row pt-md-4">
                                                    <div class="col-md-6">
                                                        <div class="form-groups row">
                                                            <label for="alasan_baru" class="col-sm-4">Kota KTP</label>
                                                            <div class="col-sm-8">
                                                                <input type="text" class="form-control form-control-sm"  name="kota_ktp">
                                                                <!-- <small id="error_alasan_baru" class="form-text text-muted">We'll never share your email with anyone else.</small> -->
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-groups row">
                                                            <label for="alasan_baru" class="col-sm-4">Jenis Outlet</label>
                                                            <div class="col-sm-8">    
                                                                <div class="form-group">
                                                                    <select value="" id="jenis_outlet" class="form-control" name="jenis_outlet">
                                                                        <option value="" disabled selected>Pilih Outlet</option>
                                                                    
                                                                    </select>
                                                                </div>
                                                                <!-- <small id="error_alasan_baru" class="form-text text-muted">We'll never share your email with anyone else.</small> -->
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row pt-md-4">
                                                    <div class="col-md-6">
                                                        <div class="form-groups row">
                                                            <label for="alasan_baru" class="col-sm-4">Kelurahan KTP</label>
                                                            <div class="col-sm-8">
                                                                <input type="text" class="form-control form-control-sm"  name="kelurahan_ktp">
                                                                <!-- <small id="error_alasan_baru" class="form-text text-muted">We'll never share your email with anyone else.</small> -->
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-groups row">
                                                            <label for="alasan_baru" class="col-sm-4">SubOutlet</label>
                                                            <div class="col-sm-8">
                                                                <div class="form-group">
                                                                    <select value="" id="sub_outlet" class="form-control" name="sub_outlet">
                                                                        <option value="" disabled selected>Pilih SubOutlet</option>
                                                                    
                                                                    </select>
                                                                </div>
                                                                <!-- <small id="error_alasan_baru" class="form-text text-muted">We'll never share your email with anyone else.</small> -->
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row pt-md-4">
                                                    <div class="col-md-6">
                                                        <div class="form-groups row">
                                                            <label for="alasan_baru" class="col-sm-4">Kode Pos KTP</label>
                                                            <div class="col-sm-8">
                                                                <input type="text" class="form-control form-control-sm"  name="kode_pos_ktp">
                                                                <!-- <small id="error_alasan_baru" class="form-text text-muted">We'll never share your email with anyone else.</small> -->
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-groups row">
                                                            <label for="alasan_baru" class="col-sm-4">PKP</label>
                                                            <div class="col-sm-8">
                                                                <div class="form-group">
                                                                    <select value="" id="pkp" class="form-control" name="pkp">
                                                                        <option value="" disabled selected>Pilih PKP</option>
                                                                        <option value="Y">Yes</option>
                                                                        <option value="T">No</option>
                                                                    
                                                                    </select>
                                                                </div>
                                                                <!-- <small id="error_alasan_baru" class="form-text text-muted">We'll never share your email with anyone else.</small> -->
                                                            </div>
                                                            <label for="alasan_baru" class="col-sm-4">Area</label>
                                                            <div class="col-sm-8">
                                                                <input type="text" class="form-control form-control-sm"  name="area">
                                                                <!-- <small id="error_alasan_baru" class="form-text text-muted">We'll never share your email with anyone else.</small> -->
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row pt-md-4">
                                                    <div class="col-md-6">
                                                        <div class="form-groups row">
                                                            <label for="alasan_baru" class="col-sm-4">Telepon</label>
                                                            <div class="col-sm-8">
                                                                <input type="text" class="form-control form-control-sm"  name="telepon">
                                                                <!-- <small id="error_alasan_baru" class="form-text text-muted">We'll never share your email with anyone else.</small> -->
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-groups row">
                                                            <label for="alasan_baru" class="col-sm-4">Kredit</label>
                                                            <div class="col-sm-8">

                                                                <div class="form-group">
                                                                    <select value="" id="kredit" class="form-control" name="kredit">
                                                                        <option value="" disabled selected>Pilih Kredit</option>
                                                                        <option value="Y">Yes</option>
                                                                        <option value="T">No</option>
                                                                    
                                                                    </select>
                                                                </div>
                                                                <input type="text" class="form-control form-control-sm"  name="kredit">
                                                                <!-- <small id="error_alasan_baru" class="form-text text-muted">We'll never share your email with anyone else.</small> -->
                                                            </div>
                                                            <label for="alasan_baru" class="col-sm-4">TOP</label>
                                                            <div class="col-sm-8">
                                                                <input type="text" class="form-control form-control-sm"  name="top">
                                                                <!-- <small id="error_alasan_baru" class="form-text text-muted">We'll never share your email with anyone else.</small> -->
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row pt-md-4">
                                                    <div class="col-md-6">
                                                        <div class="form-groups row">
                                                            <label for="alasan_baru" class="col-sm-4">Jenis Cust</label>
                                                            <div class="col-sm-8">
                                                                <div class="form-group">
                                                                    <select value="" id="jenis_cust" class="form-control" name="jenis_cust">
                                                                        <option value="" disabled selected>Pilih Jenis Cust</option>
                                                                    
                                                                    </select>
                                                                </div>
                                                                
                                                                <!-- <small id="error_alasan_baru" class="form-text text-muted">We'll never share your email with anyone else.</small> -->
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-groups row">
                                                            <label for="alasan_baru" class="col-sm-4">Bebas Iuran</label>
                                                            <div class="col-sm-8">

                                                                <div class="form-group">
                                                                    <select value="" id="bebas_iuran" class="form-control" name="bebas_iuran">
                                                                        <option value="" disabled selected>Pilih Bebas_Iuran</option>
                                                                        <option value="Y">Yes</option>
                                                                        <option value="T">No</option>
                                                                    
                                                                    </select>
                                                                </div>
                                                                <!-- <small id="error_alasan_baru" class="form-text text-muted">We'll never share your email with anyone else.</small> -->
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row pt-md-4">
                                                    <div class="col-md-6">
                                                        <div class="form-groups row">
                                                            <label for="alasan_baru" class="col-sm-4">Retail Khusus</label>
                                                            <div class="col-sm-8">

                                                                <div class="form-group">
                                                                    <select value="" id="retail_khusus" class="form-control" name="retail_khusus">
                                                                        <option value="" disabled selected>Pilih Retail_Khusus</option>
                                                                        <option value="Y">Yes</option>
                                                                        <option value="T">No</option>
                                                                    
                                                                    </select>
                                                                </div>
                                                                <!-- <small id="error_alasan_baru" class="form-text text-muted">We'll never share your email with anyone else.</small> -->
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-groups row">
                                                            <label for="alasan_baru" class="col-sm-4">Ganti Kartu</label>
                                                            <div class="col-sm-8">

                                                                <div class="form-group">
                                                                    <select value="" id="ganti_kartu" class="form-control" name="ganti_kartu">
                                                                        <option value="" disabled selected>Pilih Ganti_Kartu</option>
                                                                        <option value="Y">Yes</option>
                                                                        <option value="T">No</option>
                                                                    
                                                                    </select>
                                                                </div>
                                                                <input type="text" class="form-control form-control-sm"  name="ganti_kartu">
                                                                <!-- <small id="error_alasan_baru" class="form-text text-muted">We'll never share your email with anyone else.</small> -->
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row pt-md-4">
                                                    <div class="col-md-6">
                                                        <div class="form-groups row">
                                                            <label for="alasan_baru" class="col-sm-4">Jarak</label>
                                                            <div class="col-sm-8">
                                                                <input type="text" class="form-control form-control-sm"  name="jarak">
                                                                <!-- <small id="error_alasan_baru" class="form-text text-muted">We'll never share your email with anyone else.</small> -->
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-groups row">
                                                            <label for="alasan_baru" class="col-sm-4">Limit</label>
                                                            <div class="col-sm-8">
                                                                <input type="text" class="form-control form-control-sm"  name="limit">
                                                                <!-- <small id="error_alasan_baru" class="form-text text-muted">We'll never share your email with anyone else.</small> -->
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row pt-md-4">
                                                    <div class="col-md-6">
                                                        <div class="form-groups row">
                                                            <label for="alasan_baru" class="col-sm-4">NPWP</label>
                                                            <div class="col-sm-8">
                                                                <input type="text" class="form-control form-control-sm"  name="npwp">
                                                                <!-- <small id="error_alasan_baru" class="form-text text-muted">We'll never share your email with anyone else.</small> -->
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-groups row">
                                                            <label for="alasan_baru" class="col-sm-4">Blocking Pengiriman</label>
                                                            <div class="col-sm-8">
                                                                <div class="form-group">
                                                                    <select value="" id="blocking_pengiriman" class="form-control" name="blocking_pengiriman">
                                                                        <option value="" disabled selected>Pilih Blocking_Pengiriman</option>
                                                                        <option value="Y">Yes</option>
                                                                        <option value="T">No</option>
                                                                    
                                                                    </select>
                                                                </div>
                                                                <!-- <small id="error_alasan_baru" class="form-text text-muted">We'll never share your email with anyone else.</small> -->
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row pt-md-4">
                                                    <div class="col-md-6">
                                                        <div class="form-groups row">
                                                            <label for="alasan_baru" class="col-sm-4">Salesman</label>
                                                            <div class="col-sm-8">
                                                                <input type="text" class="form-control form-control-sm"  name="salesman">
                                                                <!-- <small id="error_alasan_baru" class="form-text text-muted">We'll never share your email with anyone else.</small> -->
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <div class="row pt-md-4">
                                                    <div class="col-md-6">
                                                        <div class="form-groups row">
                                                            <label for="alasan_baru" class="col-sm-4">Alamat Email</label>
                                                            <div class="col-sm-8">
                                                                <input type="text" class="form-control form-control-sm"  name="alamat_email">
                                                                <!-- <small id="error_alasan_baru" class="form-text text-muted">We'll never share your email with anyone else.</small> -->
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- Button Submit -->
                                                <div class="d-flex justify-content-end mt-2">

                                                    <input type="hidden" name="multipleForm" id="multipleForm" value="1">
                                                    <input type="hidden" name="runNext1" id="runNext1" onchange="view(null,1)">
                                                    <button class="btn btn-info px-4" type="submit">Save</button>
                                                    <button class="btn btn-danger mr-2" data-dismiss="modal" type="button">Cancel</button>
                                                </div>

                                    </form>
                                    <!-- ================================== -->
                                    <!-- End Modal Form                     -->
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

    <script src="{{asset('js/app-member-ho.js')}}"></script>
    <script src="{{asset('js/app-submitForm.js')}}"></script>
    <script src="{{asset('js/app-submitForm2.js')}}"></script>
    <script src="{{asset('js/app-hapus.js')}}"></script>
@endsection