@extends('../../master')
@section('content')
    <style>
        /* Add your styling table_plu_seasonal */
        #table_plu {
            border-collapse: collapse;
            width: 100%;
        }

        #table_plu th,
        #table_plu td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        #table_plu th {
            background-color: #f2f2f2;
        }

        #table_plu tbody tr.selected {
            background-color: #a6e7ff; /* Change the background color when selected */
        }

    </style>

    <script> $(".nav-item-home").addClass("active"); </script>
   
    <div class="container-fluid">
        <div class="card shadow mb-4">
            <div class="card-body" id="label-tag">
                    
                <div class="container mt-5">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Pilihan Input:</label>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="option" value="" onchange="toggleInput('by-plu',false)" id="by-plu">
                                                    <label class="form-check-label" for="by-plu">By PLU</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="option" value="" onchange="toggleInput('by-rak',false)" id="by-rak">
                                                    <label class="form-check-label" for="by-rak">By Rak</label>
                                                </div>
                                            </div>
                                        </div>
        
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Pilihan Delete:</label>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="option" value="" onchange="toggleInput('by-plu',true)" id="delete-by-plu">
                                                    <label class="form-check-label" for="by-plu">By PLU</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="option" value="" onchange="toggleInput('by-rak',true)" id="delete-by-rak">
                                                    <label class="form-check-label" for="by-rak">By Rak</label>
                                                </div>
                                            </div>
                                        </div>
        
                                    </div>
                                </div>
                            </div>


                            <div class="card input-form by-plu">
                                <div class="card-body">
                                    <form action="{{url('/api/insert/byplu')}}" method="post" class="form_data">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <label>By PLU:</label>
                                            </div>
                                        </div>
                                        <div class="row d-flex justify-content-center">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="prdcd">PRDCD</label>
                                                    <div class="form-group">
                                                        <select class="form-control select2 input-data by-plu" name="prdcd" id="prdcd" onchange="changePRDCD(this)">
                                                            <option value="" disabled selected>Pilih PRDCD</option>
                                                        
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <!-- <div class="row d-flex justify-content-center">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="desc">Desc</label>
                                                    <textarea readonly class="form-control input-data by-plu" name="desc" id="desc" cols="30" rows="10"></textarea>
                                                </div>
                                            </div>
                                        </div> -->
    
                                        <div class="row d-flex justify-content-center">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="satuan">Kategori</label>
                                                    <select class="form-control select2 input-data by-plu kategori" name="kategori" onchange="changePRDCD(this)">
                                                        <option value="">ALL</option>
                                                        <option value="fast moving">Fast Moving</option>
                                                        <option value="slow moving">Slow Moving</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row d-flex justify-content-center">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="satuan">Jenis SO IC</label>
                                                    <select class="form-control select2 input-data by-plu" name="jenis">
                                                        <option value="regular">Regular</option>
                                                        <option value="uji_petik">Uji Petik</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
    
                                        <div class="row d-flex justify-content-center">
                                            <div class="col-md-12">
                                                <div class="form-group d-flex justify-content-center">
                                                   <input type="hidden" class="form-control text" name="" value="Apa anda yakinStart SO?">
                                                   <button class="btn btn-sm btn-primary" type="submit">Start SO</button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>

                                </div>
                            </div>

                            <div class="card input-form by-rak">
                                <div class="card-body">
                                    <form action="{{url('/api/insert/byrak')}}" method="post" class="form_data">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <label>By Rak:</label>
                                            </div>
                                        </div>

                                        <div class="row d-flex justify-content-center">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="sub-rak">Sub Rak</label>
                                                    <div class="form-group">
                                                        <select class="form-control select2 input-data by-rak" name="sub_rak" id="sub-rak">
                                                            <option value="" disabled selected>Pilih Sub Rak</option>
                                                        
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>


                                        <div class="row d-flex justify-content-center">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="satuan">Jenis SO IC</label>
                                                    <select class="form-control select2 input-data by-plu" name="jenis">
                                                        <option value="regular">Regular</option>
                                                        <option value="uji_petik">Uji Petik</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

    
                                        <div class="row d-flex justify-content-center">
                                            <div class="col-md-12">
                                                <div class="form-group d-flex justify-content-center">
                                                   <button class="btn btn-sm btn-primary" type="submit">Start SO</button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>

                                </div>
                            </div>

                            <div class="card list-plu ">
                                <div class="card-header">
                                    Label
                                </div>
                                <div class="card-body">
                                        <!-- ============================ -->
                                        <!--             Table            -->
                                        <!-- ============================ -->
                                        <div class="table-container" id="scrollContainer">
                                            <table class="table table-bordered" id="table_plu">
                                            <thead>
                                                <tr>
                                                <th style="min-width: 100px;" scope="col" colspan="2">PLU</th>
                                                <th style="min-width: 100px;" scope="col">RECORDID</th>
                                                <th style="min-width: 100px;" scope="col">SUBRAK</th>
                                                <th style="min-width: 100px;" scope="col">DESKRIPSI</th>
                                                <th style="min-width: 100px;" scope="col">UNIT</th>
                                                <th style="min-width: 100px;" scope="col">TAG</th>
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
                                </div>
                            </div>

                </div>

            </div>
        </div>
    </div>

    <script src="{{asset('js/app-initial-so.js')}}"></script>
    <script src="{{asset('js/app-submitForm.js')}}"></script>
    <script src="{{asset('js/app-submitForm2.js')}}"></script>
    <script src="{{asset('js/app-hapus.js')}}"></script>
@endsection