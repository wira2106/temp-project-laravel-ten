@extends('../../master')
@section('content')
<style>
        /* Add your styling table_omi */
        #table_dv1 {
            border-collapse: collapse;
            width: 100%;
        }

        #table_dv1 th,
        #table_dv1 td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        #table_dv1 th {
            background-color: #f2f2f2;
        }

        #table_dv1 tbody tr.selected {
            background-color: #a6e7ff; /* Change the background color when selected */
        }
        /* Add your styling table_omi */
        #table_dv2 {
            border-collapse: collapse;
            width: 100%;
        }

        #table_dv2 th,
        #table_dv2 td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        #table_dv2 th {
            background-color: #f2f2f2;
        }

        #table_dv2 tbody tr.selected {
            background-color: #a6e7ff; /* Change the background color when selected */
        }
        /* Add your styling table_plu_seasonal */
        #table_struk {
            border-collapse: collapse;
            width: 100%;
        }

        #table_struk th,
        #table_struk td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        #table_struk th {
            background-color: #f2f2f2;
        }

        #table_struk tbody tr.selected {
            background-color: #a6e7ff; /* Change the background color when selected */
        }

    </style>
    <script> $(".nav-item-home").addClass("active"); </script>
   
    <div class="container-fluid">
        <div class="card shadow mb-4">
            <div class="card-body" id="card-container">
                    
                <div class="container mt-5">
                           
                        <div class="card input-form">
                            <div class="card-body">
                                <form action="{{url('/')}}" method="post" class="form_data">
                                    <div class="row d-flex justify-content-center">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="kode_seasonal">Monitoring Checker Mobile</label>
                                                <div class="form-group">

                                                    <div class="row">
                                                        <div class="col-4">
                                                            
                                                        <input type="date" class="form-control form-control-sm input-data by-plu" placeholder="Periode" name="periode" id="periode">
                                                        </div>
                                                    </div>
                                                    <div class="row mt-2">
                                                        <div class="col-4">
                                                            <label for="filter_by"></label>
                                                            <select class="form-control form-control-sm select2" name="filter" id="filter_by">
                                                                <option value="" disabled selected>Pilih Filter</option>
                                                                <option value="checker" >Checker</option>
                                                                <option value="kasir" >Kasir</option>
                                                            
                                                            </select>
                                                        </div>
                                                        <div class="col-8 mt-4">
                                                            <div class="btn-group btn-group-md">
                                                                <button type="button" class="btn btn-primary mr-1" onclick="Tampilkan()">Tampilkan</button>
                                                                <button type="button" class="btn btn-primary mr-1" onclick="ExportDataLebih()">Export Data Lebih</button>
                                                                <button type="button" class="btn btn-primary mr-1" onclick="ExportDataKurang()">Export Data Kurang </button>
                                                                <button type="button" class="btn btn-primary mr-1"type="button" class="btn btn-primary" data-toggle="modal" data-target=".bd-example-modal-lg">Item Diluar Struk </button>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                </form>

                            </div>
                        </div>
                        <div class="row my-5">
                            <div class="col-md-2 p-0">
                                <!-- ============================ -->
                                <!--             Table            -->
                                <!-- ============================ -->
                                <div class="table-container" id="">

                                    <input type="text" placeholder="Search" class="form-control form-control-sm" name="search" id="searchStruk">
                                    <table class="table table-sm" id="table_struk">
                                    <thead>
                                        <tr>
                                        <th style="min-width: 45px;" scope="col">ID</th>
                                        <th style="min-width: 57px;" scope="col">Struk</th>
                                        <th style="min-width: 53px;" scope="col">Selisih</th>
                                        <!-- Add more headers as needed -->
                                        </tr>
                                    </thead>
                                    <tbody id="table-content-struk">
                                        
                                    </tbody>
                                    </table>
                                </div>
                                <!-- ============================ -->
                                <!--         End Table            -->
                                <!-- ============================ -->
                            </div>
                            <div class="col-md-5  p-0">
                                <div class="card list-label ">
                                    <div class="card-body p-0">
                                            <!-- ============================ -->
                                            <!--             Table            -->
                                            <!-- ============================ -->
                                            <div class="table-container" id="">

                                                <input type="text" placeholder="Search" class="form-control form-control-sm" name="search" id="searchDv1">
                                                <table class="table table-bordered" id="table_dv1">
                                                <thead>
                                                    <tr>
                                                    <th style="min-width: 100px;" scope="col">Notrans</th>
                                                    <th style="min-width: 100px;" scope="col">Kasir</th>
                                                    <th style="min-width: 100px;" scope="col">Station</th>
                                                    <th style="min-width: 100px;" scope="col">Member</th>
                                                    <th style="min-width: 100px;" scope="col">Jam</th>
                                                    <th style="min-width: 100px;" scope="col">Status</th>
                                                    <!-- Add more headers as needed -->
                                                    </tr>
                                                </thead>
                                                <tbody id="table-content-dv1">
                                                    
                                                </tbody>
                                                </table>
                                            </div>
                                            <!-- ============================ -->
                                            <!--         End Table            -->
                                            <!-- ============================ -->
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-5  p-0">
                                <div class="card list-label ">
                                    <div class="card-body p-0">
                                            <!-- ============================ -->
                                            <!--             Table            -->
                                            <!-- ============================ -->
                                            <div class="table-container" id="">
                                                <input type="text" placeholder="Search" class="form-control form-control-sm" name="search" id="searchDv2">
                                                <table class="table table-bordered" id="table_dv2">
                                                <thead>
                                                    <tr>
                                                    <th style="min-width: 100px;">Plu</th>
                                                    <th style="min-width: 100px;">Deskripsi</th>
                                                    <th style="min-width: 100px;">Unit</th>
                                                    <th style="min-width: 100px;">Frac</th>
                                                    <th style="min-width: 100px;">Qty_order</th>
                                                    <th style="min-width: 100px;">Qty_real</th>
                                                    <th style="min-width: 100px;">Selisih</th>
                                                    <th style="min-width: 100px;">Keterangan</th>
                                                    <th style="min-width: 100px;">Referensi</th>
                                                    <!-- Add more headers as needed -->
                                                    </tr>
                                                </thead>
                                                <tbody id="table-content-dv2">
                                                    
                                                </tbody>
                                                </table>
                                            </div>
                                            <!-- ============================ -->
                                            <!--         End Table            -->
                                            <!-- ============================ -->
                                    </div>
                                </div>
                            </div>
                        </div>

                </div>

            </div>
        </div>
    </div>

    <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">

        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Daftar item diluar struk</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="card ">
                    <div class="card-body p-0">
                            <!-- ============================ -->
                            <!--             Table            -->
                            <!-- ============================ -->
                            <div class="table-container" id="">
                                <div class="row">
                                    <div class="col-md-10">
                                        <input type="date" placeholder="Periode" class="form-control form-control-sm" name="periode" id="periodeStruk">
                                    </div>
                                    <div class="col-md-2">
                                        <button type="button" class="btn btn-sm btn-primary mr-1" onclick="TampilkanItemDiluarStruk()">Tampilkan</button>
                                    </div>
                                </div>

                                <table class="table table-bordered" id="table_diluar_struk">
                                <thead>
                                    <tr>
                                    <th style="min-width: 100px;" scope="col">Checker_id</th>
                                    <th style="min-width: 100px;" scope="col">Kodeplu</th>
                                    <th style="min-width: 100px;" scope="col">Nama_barang</th>
                                    <th style="min-width: 100px;" scope="col">Qty</th>
                                    <th style="min-width: 100px;" scope="col">Tgl_trans</th>
                                    <th style="min-width: 100px;" scope="col">Kasir</th>
                                    <th style="min-width: 100px;" scope="col">Station</th>
                                    <th style="min-width: 100px;" scope="col">No_trans</th>
                                    <th style="min-width: 100px;" scope="col">Kode_member</th>
                                    <th style="min-width: 100px;" scope="col">Nama_member</th>
                                    <!-- Add more headers as needed -->
                                    </tr>
                                </thead>
                                <tbody id="table-content-diluar-struk">
                                    
                                </tbody>
                                </table>
                            </div>
                            <!-- ============================ -->
                            <!--         End Table            -->
                            <!-- ============================ -->
                    </div>
                </div>
            </div>

            <div class="modal-footer d-flex justify-content-center">
                <button type="button" class="btn btn-primary">Export</button>
            </div>
        </div>
    </div>
    </div>

    <!-- <script src="{{asset('js/app-label.js')}}"></script> -->
    <script src="{{asset('js/app-monitoring.js')}}"></script>
    <script src="{{asset('js/app-submitForm.js')}}"></script>
    <script src="{{asset('js/app-submitForm2.js')}}"></script>
    <script src="{{asset('js/app-hapus.js')}}"></script>
@endsection