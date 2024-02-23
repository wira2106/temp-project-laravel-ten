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
            <div class="card-body" id="card-container">
                    
                <div class="container mt-5">

                        <div class="card input-form">
                            <div class="card-body">
                                <!-- <form action="{{url('/api/insert/byplu')}}" method="post" class="form_data"> -->
                                    <div class="row d-flex justify-content-center">
                                        <div class="col-md-10">
                                            <div class="form-group">
                                                <div class="form-group">

                                                    <div class="row mb-2">
                                                        <div class="col-sm-12">
                                                            <input type="text" class="form-control form-control-sm input-data by-plu" placeholder="Periode" name="periode" id="periode">
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-sm-6">
                                                            <select class="form-control select2" name="kode_toko" id="kode_toko" onchange="changeKodeToko(this.value)" disabled>
                                                                <option value="" disabled selected>Pilih Kode Toko</option>
                                                            
                                                            </select>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <input type="text" class="form-control form-control-sm input-data by-plu" placeholder="Nama Toko" name="omi" id="omi" readonly disabled>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <label for="kode_seasonal"style="color:white;">button</label>
                                            <div class="form-group">
                                                <input type="hidden" class="form-control text" name="" value="Load Data?">
                                                <!-- <button class="btn btn-sm btn-primary" type="submit"> Tarik Ulang DT9</button> -->
                                                <button class="btn btn-sm btn-primary" type="button" onclick="loadData()"> Load Data</button>
                                            </div>
                                        </div>
                                    </div>
                                    
                                <!-- </form> -->

                            </div>
                        </div>
                        <div class="row my-5 d-flex justify-content-center">                           
                            <div class="col-md-8">
                                <div class="card list-label ">
                                    <!-- <div class="card-header">
                                        PLU Seasonal
                                    </div> -->
                                    <div class="card-body">
                                            <!-- ============================ -->
                                            <!--             Table            -->
                                            <!-- ============================ -->
                                            <input type="text" placeholder="Search" class="form-control form-control-sm" name="search" id="searchInput">
                                            <div class="table-container" id="">
                                                <table class="table table-bordered" id="table_bytoko">
                                                <thead>
                                                    <tr>
                                                    <th style="min-width: 100px;" scope="col">PLU</th>
                                                    <th style="min-width: 100px;" scope="col">Deskripsi</th>
                                                    <th style="min-width: 100px;" scope="col">Alokasi</th>
                                                    <th style="min-width: 100px;" scope="col">Pemenuhan</th>
                                                    <th style="min-width: 100px;" scope="col">%</th>
                                                    <th style="min-width: 100px;" scope="col">Sisa</th>
                                                    <!-- Add more headers as needed -->
                                                    </tr>
                                                </thead>
                                                <tbody id="table-content-bytoko">
                                                    
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
    <script src="{{asset('js/app-monitoring-by-toko.js')}}"></script>
    <script src="{{asset('js/app-submitForm.js')}}"></script>
    <script src="{{asset('js/app-submitForm2.js')}}"></script>
    <script src="{{asset('js/app-hapus.js')}}"></script>
@endsection