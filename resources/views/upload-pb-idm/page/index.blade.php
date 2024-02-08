@extends('../../master')
@section('content')

    <script> $(".nav-item-home").addClass("active"); </script>
   
    <div class="container-fluid">
        <div class="card shadow mb-4">
            <div class="card-body" id="label-tag">
                    
                <div class="container mt-5">
                            <div class="form-group">
                                <label>Pilihan folder dengan file csv:</label>

                                <form action="{{url('/api/tarik/data')}}" method="post" id="form_data">
                                    @csrf
                                    <div class="row  d-flex justify-content-center">
                                        <div class="col-md-12">
                                            <div class="form-check">
                                                <input class="form-check-input" type="file" name="file" value="" webkitdirectory directory multiple > -->
                                            </div>

                                            <div class="file">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row d-flex justify-content-center">
                                        <div class="col-md-12">
                                            <div class="form-group d-flex justify-content-center">
                                                <button class="btn btn-sm btn-primary mr-1" type="button" onclick="TarikData(this)"> Tarik Data CSV</button>
                                                <button class="btn btn-sm btn-primary" type="button" onclick="UploadPB(this)" disabled> Upload PB Majalah IDM + Send</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>

                            </div>
                </div>

            </div>
        </div>
        <div class="card shadow mb-4">
            <div class="card-body" id="label-tag">
                    
                <div class="container mt-5">

                    <div class="row">
                        <div class="col-md-2"></div>
                        <div class="col-md-8">
                            <div class="card list-label ">
                                <!-- <div class="card-header">
                                    Zona Majalah
                                </div> -->
                                <div class="card-body">
                                        <!-- ============================ -->
                                        <!--             Table            -->
                                        <!-- ============================ -->
                                        <div class="table-container" id="">
                                            <table class="table table-bordered" id="table_cabang">
                                            <thead>
                                                <tr>
                                                <th style="min-width: 100px;" scope="col">No PB</th>
                                                <th style="min-width: 100px;" scope="col">Tgl PB</th>
                                                <th style="min-width: 100px;" scope="col">Toko</th>
                                                <th style="min-width: 100px;" scope="col">Item</th>
                                                <th style="min-width: 100px;" scope="col">Rupiah</th>
                                                <th style="min-width: 100px;" scope="col">Namafile</th>
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
                        <div class="col-md-2"></div>
                    </div>
                    <div class="row">
                        <div class="col-md-2"></div>
                        <div class="col-md-8">
                            <div class="card list-label ">
                                <!-- <div class="card-header">
                                    Zona Majalah
                                </div> -->
                                <div class="card-body">
                                        <!-- ============================ -->
                                        <!--             Table            -->
                                        <!-- ============================ -->
                                        <div class="table-container" id="">
                                            <table class="table table-bordered" id="table_cabang">
                                            <thead>
                                                <tr>
                                                <th style="min-width: 100px;" scope="col">PLU</th>
                                                <th style="min-width: 100px;" scope="col">Deskripsi</th>
                                                <th style="min-width: 100px;" scope="col">Qty</th>
                                                <th style="min-width: 100px;" scope="col">RPh</th>
                                                <th style="min-width: 100px;" scope="col">Stock</th>
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
                        <div class="col-md-2"></div>
                    </div>

                </div>

            </div>
        </div>
    </div>

    <script src="{{asset('js/app-upload-pb-idm.js')}}"></script>
    <script src="{{asset('js/app-submitForm.js')}}"></script>
    <script src="{{asset('js/app-submitForm2.js')}}"></script>
    <script src="{{asset('js/app-hapus.js')}}"></script>
@endsection