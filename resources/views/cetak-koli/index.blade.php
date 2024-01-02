@extends('../../master')
@section('content')
    <style>
        .select2-container--default.select2-container--open {
            border-color: #007bff;
            width: 100% !important;
        }
        .select2-container {
            box-sizing: border-box;
            display: inline-block;
            margin: 0;
            position: relative;
            vertical-align: middle;
            width: 100% !important;
            
        }
    </style>
    <script> $(".nav-item-home").addClass("active"); </script>
   
    <div class="container-fluid">
        <div class="card shadow mb-4">
            <div class="card-body card_loading" id="label-tag">
                    
                <div class="container mt-5">
                            
                    <!-- =========================== -->
                    <!-- ======= Header Input ====== -->
                    <!-- =========================== -->
                    <div class="card border border-primary mb-2">
                        <div class="card-body" id="cetak-koli">
                                
                            <div class="container mt-5">
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="basic-addon3">Jarak Kiri</span>
                                        </div>
                                        <input type="number" class="form-control" id="jarak_kiri" aria-describedby="basic-addon3" name="jarak_kiri" value="0">
                                    </div>
                                    <div class="jarak_kiri">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="basic-addon3">Jarak Atas</span>
                                        </div>
                                        <input type="number" class="form-control" id="jarak_atas" aria-describedby="basic-addon3" name="jarak_atas" value="0">
                                    </div>
                                    <div class="jarak_atas">
                                    </div>
                                </div>
                            </div>

                            </div>

                        </div>
                    </div>
                    <!-- =========================== -->
                    <!-- ===== End Header Input ==== -->
                    <!-- =========================== -->
                    <!-- =========================== -->
                    <!-- ========    Tabs   ======== -->
                    <!-- =========================== -->
                    <div class="card border border-primary">
                        <div class="card-body" id="cetak-koli">
                                
                            <div class="container mt-5">
                                <ul class="nav nav-tabs" id="myTabs">
                                    <li class="nav-item">
                                    <a class="nav-link active" id="tab1-tab" data-toggle="tab" href="#tab1">Nomor Koli</a>
                                    </li>
                                    <li class="nav-item">
                                    <a class="nav-link" id="tab2-tab" data-toggle="tab" href="#tab2">Barcode PLU</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="tab3-tab" data-toggle="tab" href="#tab3">Barcode OBI</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="tab3-tab" data-toggle="tab" href="#tab4">Reprint Checker</a>
                                    </li>
                                </ul>

                                <div class="tab-content mt-2">

                                    <!-- =========================== -->
                                    <!-- ===== Tab NOMOR KOLI ====== -->
                                    <!-- =========================== -->
                                    <div class="tab-pane fade show active" id="tab1">
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text" id="basic-addon3">Nama Sarana</span>
                                            </div>
                                            <select class="custom-select" name="nama_sarana">
                                                <option selected>Open this select menu</option>
                                                <option value="1">One</option>
                                                <option value="2">Two</option>
                                                <option value="3">Three</option>
                                            </select>
                                        </div>
                                        <div class="card border border-primary mb-2">
                                            <div class="card-header">
                                                Cetak Nomor Baru
                                            </div>
                                            <div class="card-body" id="">
                                                    
                                                <div class="container mt-5">
                                                    <form action="{{url('/api/koli/cetak_koli')}}" method="post" class="form_data">
                                                        @csrf
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <div class="input-group mb-3">
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text" id="basic-addon3">Nomor Terakhir</span>
                                                                    </div>
                                                                    <input type="number" class="form-control" id="nomor_terakhir_koli" aria-describedby="basic-addon3" name="nomor_terakhir" readonly>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-12 mb-3">
                                                                <div class="form-check">
                                                                    <input class="form-check-input" name="dengan_akhiran_d" type="checkbox" value="" id="dengan_akhiran_d">
                                                                    <label class="form-check-label" for="dengan_akhiran_d">
                                                                       Dengan Akhiran D
                                                                    </label>
                                                                </div>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" name="idm" type="checkbox" value="" id="idm">
                                                                    <label class="form-check-label" for="idm">
                                                                       IDM
                                                                    </label>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-12">
                                                                <div class="input-group mb-3">
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text" id="basic-addon3">Jumlah Label</span>
                                                                    </div>
                                                                    <input type="number" class="form-control" id="jarak_kiri" aria-describedby="basic-addon3" name="jumlah_label">
                                                                                <input type="hidden" class="form-control" id="jarak_kiri_koli" name="jarak_kiri">
                                                                                <input type="hidden" class="form-control" id="jarak_atas_koli" name="jarak_atas">
                                                                                <input type="hidden" name="multipleForm"  value="1">
                                                                                <input type="hidden" class="form-control" id="runNext1" onchange="get_set_koli_omi()">
                                                                </div>
                                                                <div class="jumlah_label">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row d-flex justify-content-center">
                                                            <div class="col-md-12">
                                                                <div class="form-group d-flex justify-content-center">
                                                                <button class="btn btn-sm btn-primary" type="button" onclick="cetak_koli(this)"> Cetak</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </form>


                                                </div>

                                            </div>
                                        </div>
                                        <div class="card border border-primary mb-2">
                                            <div class="card-header">
                                                Reprint
                                            </div>
                                            <div class="card-body" id="">
                                                    
                                                <div class="container mt-5">
                                                    <form action="{{url('/api/koli/cetak_koli_reprint')}}" method="post" class="form_data">
                                                        @csrf
                                                        <div class="row d-flex justify-content-center">
                                                                <div class="col-md-12">
                                                                    <div class="input-group mb-3">
                                                                        <div class="input-group-prepend">
                                                                            <span class="input-group-text" id="basic-addon3">Nomor Awal</span>
                                                                        </div>
                                                                        <input type="number" class="form-control" name="input1" id="input1" min="0" >
                                                                        <div class="input-group-prepend">
                                                                            <span class="input-group-text" id="basic-addon3">S / D</span>
                                                                        </div>
                                                                        <input type="number" class="form-control" name="input2" id="input2" min="0" >
    
                                                                        <input type="hidden" class="form-control" id="jarak_kiri_koli_reprint" name="jarak_kiri">
                                                                        <input type="hidden" class="form-control" id="jarak_atas_koli_reprint" name="jarak_atas">
                                                                        <input type="hidden" class="form-control" id="nomor_terakhir_koli_reprint" name="nomor_terakhir">
                                                                        <input class="form-check-input" name="idm" type="hidden" value="" id="idm_reprint">
                                                                        <input type="hidden" name="multipleForm"  value="1">
                                                                        <input type="hidden" class="form-control" id="runNext1" onchange="get_set_koli_omi()">
                                                                    </div>
                                                                    <div class="input1">
                                                                    </div>
                                                                    <div class="input2">
                                                                    </div>
                                                                </div>
                                                        </div>
                                                        <div class="row d-flex justify-content-center">
                                                            <div class="col-md-12">
                                                                <div class="form-group d-flex justify-content-center">
                                                                <button class="btn btn-sm btn-primary" type="button" onclick="cetak_koli_reprint(this)">Reprint</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </form>

                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                    <!-- =========================== -->
                                    <!-- ==== END Tab NOMOR KOLI === -->
                                    <!-- =========================== -->
                                    <!-- =========================== -->
                                    <!-- ==== Tab BARCODE PLU ====== -->
                                    <!-- =========================== -->
                                    <div class="tab-pane fade" id="tab2">
                                        <div class="card border border-primary mb-2">
                                            <div class="card-header">
                                                Cetak Barcode PLU
                                            </div>
                                            <div class="card-body" id="cetak-koli">
                                                    
                                                <div class="container mt-5">

                                                    <form action="{{url('/api/cetak/plu')}}" method="post" class="form_data">
                                                        @csrf
                                                        <div class="row d-flex justify-content-center">
                                                                <!-- <div class="col-md-12 form-group">
                                                                    <div class="input-group mb-3">
                                                                        <div class="input-group-prepend">
                                                                            <span class="input-group-text" id="basic-addon3">PLU</span>
                                                                        </div>
                                                                        <select class="form-control select2 input-data by-plu" name="PLU" id="PLU" onchange="changePRDCD(this)">
                                                                            <option value="" disabled selected>Pilih PRDCD</option>
                                                                        
                                                                        </select>
                                                                    </div>
                                                                </div> -->
                                                                <div class="col-md-12">
                                                                    <div class="input-group mb-3">
                                                                        <div class="input-group-prepend">
                                                                            <span class="input-group-text" id="basic-addon3">PLU</span>
                                                                        </div>
                                                                        <input type="text" class="form-control" id="prdcd_deskripsi" name="prdcd_deskripsi">
                                                                        <input type="hidden" class="form-control" id="prdcd" name="prdcd">
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-12">
                                                                    <div class="input-group mb-3">
                                                                        <div class="input-group-prepend">
                                                                            <span class="input-group-text" id="basic-addon3">Jumlah Label</span>
                                                                        </div>
                                                                        <input type="number" class="form-control" id="jumlah_label_plu" name="jumlah_label" min="0" >
                                                                    </div>

                                                                    <div class="jumlah_label">
                                                                    </div>
                                                                </div>
                                                        </div>
    
                                                        <div class="row d-flex justify-content-center">
                                                            <div class="col-md-12">
                                                                <div class="form-group d-flex justify-content-center">
                                                                <button class="btn btn-sm btn-primary" type="button" onclick="cetak_plu(this)"> Cetak</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </form>

                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                    <!-- =========================== -->
                                    <!-- === END Tab BARCODE PLU === -->
                                    <!-- =========================== -->
                                    <!-- =========================== -->
                                    <!-- ===== Tab NOMOR KOLI ====== -->
                                    <!-- =========================== -->
                                    <div class="tab-pane fade" id="tab3">
                                        <div class="card border border-primary mb-2">
                                            <div class="card-header">
                                                Cetak Nomor Baru
                                            </div>
                                            <div class="card-body" id="">
                                                <div class="container mt-5">
                                                    <div class="card border border-primary mb-2">
                                                        <div class="card-header">
                                                            Cetak Nomor Baru
                                                        </div>
                                                        <div class="card-body" id="">
                                                                
                                                            <div class="container mt-5">
                                                                <form action="{{url('/api/cetak/obi')}}" method="post" class="form_data">
                                                                    @csrf
                                                                    <div class="row">
                                                                        <div class="col-md-12">
                                                                            <div class="input-group mb-3">
                                                                                <div class="input-group-prepend">
                                                                                    <span class="input-group-text" id="basic-addon3">Nomor Terakhir</span>
                                                                                </div>
                                                                                <input type="number" class="form-control" id="nomor_terakhir" name="nomor_terakhir" readonly>
                                                                                <input type="hidden" class="form-control" id="jarak_kiri_omi" name="jarak_kiri">
                                                                                <input type="hidden" class="form-control" id="jarak_atas_omi" name="jarak_atas">
                                                                                <input type="hidden" name="multipleForm"  value="3">
                                                                                <input type="hidden" class="form-control" id="runNext3" onchange="get_last_row()">
                                                                                <!-- <input type="hidden" class="form-control" name="download3"> -->
                                                                            </div>
                                                                            <div class="nomor_terakhir">
                                                                            </div>
                                                                        </div>
                                                                        
                                                                        <div class="col-md-12">
                                                                            <div class="input-group mb-3">
                                                                                <div class="input-group-prepend">
                                                                                    <span class="input-group-text" id="basic-addon3">Jumlah Label</span>
                                                                                </div>
                                                                                <input type="number" class="form-control" id="jumlah_label" aria-describedby="basic-addon3" name="jumlah_label">
                                                                            </div>
                                                                            <div class="jumlah_label">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="row d-flex justify-content-center">
                                                                        <div class="col-md-12">
                                                                            <div class="form-group d-flex justify-content-center">
                                                                            <button class="btn btn-sm btn-primary" type="button" onclick="cetak_omi(this)"> Cetak</button>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </form>
                                                            </div>

                                                        </div>
                                                    </div>
                                                    <div class="card border border-primary mb-2">
                                                        <div class="card-header">
                                                            Reprint
                                                        </div>
                                                        <div class="card-body" id="">  
                                                            <div class="container mt-5">
                                                                <form action="{{url('/api/cetak/obi/reprint')}}" method="post" class="form_data">
                                                                    @csrf
                                                                    <div class="row d-flex justify-content-center">
                                                                        <div class="col-md-12">
                                                                            <div class="input-group mb-3">
                                                                                <div class="input-group-prepend">
                                                                                    <span class="input-group-text" id="basic-addon3">Nomor Awal</span>
                                                                                </div>
                                                                                <input type="number" class="form-control" name="input1" id="input1" min="0" >
                                                                                <div class="input-group-prepend">
                                                                                    <span class="input-group-text" id="basic-addon3">S / D</span>
                                                                                </div>
                                                                                <input type="number" class="form-control" name="input2" id="input2" min="0" >
                                                                                <input type="hidden" class="form-control" id="jarak_kiri_omi_reprint" name="jarak_kiri">
                                                                                <input type="hidden" class="form-control" id="jarak_atas_omi_reprint" name="jarak_atas">
                                                                                <input type="hidden" class="form-control" id="nomor_terakhir_reprint" name="nomor_terakhir">
                                                                                <input type="hidden" name="multipleForm"  value="4">
                                                                                <!-- <input type="hidden" class="form-control" name="download4"> -->
                                                                            </div>
                                                                            <div class="input1">
                                                                            </div>
                                                                            <div class="input2">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="row d-flex justify-content-center">
                                                                        <div class="col-md-12">
                                                                            <div class="form-group d-flex justify-content-center">
                                                                            <button class="btn btn-sm btn-primary" type="button" onclick="cetak_omi_reprint(this)">Reprint</button>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- =========================== -->
                                    <!-- ==== END Tab NOMOR KOLI === -->
                                    <!-- =========================== -->
                                    <!-- =========================== -->
                                    <!-- ===== Tab NOMOR KOLI ====== -->
                                    <!-- =========================== -->
                                    <div class="tab-pane fade" id="tab4">
                                        <div class="card-header">
                                                Cetak Nomor Baru
                                        </div>
                                        <div class="card border border-primary mb-2">
                                            <div class="card-body" id="">
                                                <form action="{{url('/api/reprint/checker')}}" method="post" class="form_data">
                                                    @csrf
                                                    <div class="container mt-5">
                                                        <div class="row d-flex justify-content-center">
                                                                <div class="col-md-12">
                                                                    <div class="input-group mb-3">
                                                                        <div class="input-group-prepend">
                                                                            <span class="input-group-text" id="basic-addon3">Nomor Koli</span>
                                                                        </div>
                                                                        <input type="number" name="nomor_koli" class="form-control" id="input1" min="0">
                                                                        <input type="hidden" name="multipleForm"  value="5">
                                                                        <input type="hidden" name="download5"  value="" >
                                                                    </div>
                                                                    <div class="nomor_koli">
                                                                    </div>
                                                                </div>
                                                        </div>
    
                                                        <div class="row d-flex justify-content-center">
                                                            <div class="col-md-12">
                                                                <div class="form-group d-flex justify-content-center">
                                                                <button class="btn btn-sm btn-primary" type="button" onclick="cetak_reprint_checker(this)"> Cetak</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </form>

                                            </div>
                                        </div>
                                    </div>
                                    <!-- =========================== -->
                                    <!-- ==== END Tab NOMOR KOLI === -->
                                    <!-- =========================== -->
                                </div>
                            </div>

                        </div>
                    </div>
                    <!-- =========================== -->
                    <!-- ========  End Tabs ======== -->
                    <!-- =========================== -->

                </div>

            </div>
        </div>
    </div>

    <script src="{{asset('js/app-cetak-koli.js')}}"></script>
    <script src="{{asset('js/app-submitForm.js')}}"></script>
    <script src="{{asset('js/app-submitForm2.js')}}"></script>
    <script src="{{asset('js/app-hapus.js')}}"></script>
@endsection