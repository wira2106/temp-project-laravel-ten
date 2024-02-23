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
                                <form action="{{url('/')}}" method="post" class="form_data">
                                    <div class="row d-flex justify-content-center">
                                        <div class="col-md-10">
                                            <div class="form-group">
                                                <label for="kode_seasonal">Kode Seasonal</label>
                                                <div class="form-group">

                                                    <div class="row">
                                                        <div class="col-6">
                                                            <select class="form-control select2" name="kode_seasonal" id="kode_seasonal" onchange="changeKodeSeasonal(this.value)" disabled>
                                                                <option value="" disabled selected>Pilih Kode Seasonal</option>
                                                            
                                                            </select>
                                                        </div>
                                                        <div class="col-6">
                                                            <input type="text" class="form-control input-data by-plu" placeholder="Periode" name="periode" id="periode" disabled>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <label for="kode_seasonal"style="color:white;">button</label>
                                            <div class="form-group">
                                                <input type="hidden" class="form-control text" name="" value="Tarik Ulang DT9?">
                                                <!-- <button class="btn btn-sm btn-primary" type="submit"> Tarik Ulang DT9</button> -->
                                                <button class="btn btn-sm btn-primary" onclick="loadSeasonal()"> Tarik Ulang DT9</button>
                                            </div>
                                        </div>
                                    </div>
                                    
                                </form>

                            </div>
                        </div>
                        <div class="row my-5">
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
                            <div class="col-md-7">
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
                            
                            <div class="card input-form">
                                <div class="card-body">
                                    <div class="form-group">
                                        <label>Pilihan folder dengan file csv:</label>

                                        <form action="{{url('/api/tarik/data')}}" method="post" id="form_data">
                                            @csrf
                                            <div class="row  d-flex justify-content-center">
                                                <div class="col-md-8">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="file" name="file" value="" webkitdirectory directory multiple > -->
                                                    </div>

                                                    <div class="file">
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group d-flex justify-content-center">
                                                        <button class="btn btn-sm btn-primary mr-1" type="button" onclick="KirimPBSeasonal(this)"> Kirim PB Seasonal</button>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row d-flex justify-content-center">
                                            </div>
                                        </form>

                                    </div>

                                </div>
                            </div>
                            <!-- <div class="card input-form by-plu">
                                <div class="card-body">
                                    <form action="{{url('/api/insert/byplu')}}" method="post" class="form_data">
                                        <div class="row d-flex justify-content-center">
                                            <div class="col-md-10">
                                                <div class="form-group">
                                                    <label for="kode_seasonal">Kode Seasonal</label>
                                                    <div class="form-group">

                                                        <div class="row">
                                                            <div class="col-6">
                                                                <select class="form-control select2 input-data by-plu" name="kode_seasonal" id="kode_seasonal" onchange="changeKodeSeasonal(this)">
                                                                    <option value="" disabled selected>Pilih Kode Seasonal</option>
                                                                
                                                                </select>
                                                            </div>
                                                            <div class="col-6">
                                                                <input type="text" class="form-control input-data by-plu" name="periode" id="periode">
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <label for="kode_seasonal"style="color:white;">button</label>
                                                <div class="form-group">
                                                   <input type="hidden" class="form-control text" name="" value="Tarik Ulang DT9?">
                                                   <button class="btn btn-sm btn-primary" type="submit"> Tarik Ulang DT9</button>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="row d-flex justify-content-center">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="desc">Desc</label>
                                                    <textarea readonly class="form-control input-data by-plu" name="desc" id="desc" cols="30" rows="10"></textarea>
                                                </div>
                                            </div>
                                        </div>
    
                                        <div class="row d-flex justify-content-center">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="satuan">Satuan</label>
                                                    <select multiple class="form-control select2 input-data by-plu" id="satuan" onchange="satuanSelected()" name="satuan[]">
                                                        <option value="all">ALL</option>
                                                        <option value="0 ctn">0 CTN</option>
                                                        <option value="1 pcs">1 PCS</option>
                                                        <option value="2 pcs">2 PCS</option>
                                                        <option value="no pcs">No PCS</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
    
                                        <div class="row d-flex justify-content-center">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="prdcd">Qty</label>
                                                    <input type="number" class="form-control input-data by-plu" name="qty" id="qty">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row d-flex justify-content-center">
                                            <div class="col-md-12">
                                                <div class="form-group d-flex justify-content-center">
                                                   <input type="hidden" class="form-control text" name="" value="Apa anda yakin insert ke database?">
                                                   <button class="btn btn-sm btn-primary" type="submit"> Insert Ke Database</button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>

                                </div>
                            </div> -->


                </div>

            </div>
        </div>
    </div>

    <!-- <script src="{{asset('js/app-label.js')}}"></script> -->
    <script src="{{asset('js/app-alokasi-seasonal.js')}}"></script>
    <script src="{{asset('js/app-submitForm.js')}}"></script>
    <script src="{{asset('js/app-submitForm2.js')}}"></script>
    <script src="{{asset('js/app-hapus.js')}}"></script>
@endsection