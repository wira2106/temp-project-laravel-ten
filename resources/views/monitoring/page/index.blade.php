@extends('../../master')
@section('content')
<style>
        /* Add your styling table_omi */
        #table_omi {
            border-collapse: collapse;
            width: 100%;
        }

        #table_omi th,
        #table_omi td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        #table_omi th {
            background-color: #f2f2f2;
        }

        #table_omi tbody tr.selected {
            background-color: #a6e7ff; /* Change the background color when selected */
        }
        /* Add your styling table_plu_seasonal */
        #table_plu_seasonal {
            border-collapse: collapse;
            width: 100%;
        }

        #table_plu_seasonal th,
        #table_plu_seasonal td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        #table_plu_seasonal th {
            background-color: #f2f2f2;
        }

        #table_plu_seasonal tbody tr.selected {
            background-color: #a6e7ff; /* Change the background color when selected */
        }

    </style>
    <script> $(".nav-item-home").addClass("active"); </script>
   
    <div class="container-fluid">
        <div class="card shadow mb-4">
            <div class="card-body" id="label-tag">
                    
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
                                                            <select class="form-control form-control-sm select2" name="filter_by" id="filter_by">
                                                                <option value="" disabled selected>Pilih Filter</option>
                                                                <option value="checker" >Checker</option>
                                                                <option value="kasir" >Kasir</option>
                                                            
                                                            </select>
                                                        </div>
                                                        <div class="col-8 mt-4">
                                                            <div class="btn-group btn-group-md">
                                                                <button type="button" class="btn btn-primary mr-1">Tampilkan</button>
                                                                <button type="button" class="btn btn-primary mr-1">Export Data Lebih</button>
                                                                <button type="button" class="btn btn-primary mr-1">Export Data Kurang </button>
                                                                <button type="button" class="btn btn-primary mr-1">Item Diluar Struk </button>
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
                                    <table class="table table-sm" id="table_struk">
                                    <thead>
                                        <tr>
                                        <th style="min-width: 45px;" scope="col" colspan="2">ID</th>
                                        <th style="min-width: 57px;" scope="col">Struk</th>
                                        <th style="min-width: 52px;" scope="col">Selisih</th>
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
                            <div class="col-md-5">
                                <div class="card list-label ">
                                    <div class="card-header">
                                        Toko OMI
                                    </div>
                                    <div class="card-body">
                                            <!-- ============================ -->
                                            <!--             Table            -->
                                            <!-- ============================ -->
                                            <div class="table-container" id="">
                                                <table class="table table-bordered" id="table_omi">
                                                <thead>
                                                    <tr>
                                                    <th style="min-width: 100px;" scope="col">OMI</th>
                                                    <th style="min-width: 100px;" scope="col">Nama OMI</th>
                                                    <th style="min-width: 100px;" scope="col">Jatuh Tempo</th>
                                                    <!-- Add more headers as needed -->
                                                    </tr>
                                                </thead>
                                                <tbody id="table-content-omi">
                                                    
                                                </tbody>
                                                </table>
                                            </div>
                                            <!-- ============================ -->
                                            <!--         End Table            -->
                                            <!-- ============================ -->
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-5">
                                <div class="card list-label ">
                                    <div class="card-header">
                                        PLU Seasonal
                                    </div>
                                    <div class="card-body">
                                            <!-- ============================ -->
                                            <!--             Table            -->
                                            <!-- ============================ -->
                                            <div class="table-container" id="">
                                                <table class="table table-bordered" id="table_plu_seasonal">
                                                <thead>
                                                    <tr>
                                                    <th style="min-width: 100px;" scope="col" colspan="2">PLU</th>
                                                    <th style="min-width: 100px;" scope="col">Deskripsi</th>
                                                    <th style="min-width: 100px;" scope="col">Qty Alokasi</th>
                                                    <th style="min-width: 100px;" scope="col">Qty Pemenuhan</th>
                                                    <th style="min-width: 100px;" scope="col">Qty</th>
                                                    <!-- Add more headers as needed -->
                                                    </tr>
                                                </thead>
                                                <tbody id="table-content-plu-seasonal">
                                                    
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

    <!-- <script src="{{asset('js/app-label.js')}}"></script> -->
    <script src="{{asset('js/app-monitoring.js')}}"></script>
    <script src="{{asset('js/app-submitForm.js')}}"></script>
    <script src="{{asset('js/app-submitForm2.js')}}"></script>
    <script src="{{asset('js/app-hapus.js')}}"></script>
@endsection