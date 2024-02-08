@extends('../../master')
@section('content')

    <script> $(".nav-item-home").addClass("active"); </script>
   
    <div class="container-fluid">
        <div class="card shadow mb-4">
            <div class="card-body" id="label-tag">
                    
                <div class="container mt-5">

                    <div class="row">
                        <div class="col-md-2"></div>
                        <div class="col-md-8">
                            <div class="card list-label ">
                                <div class="card-header">
                                    Zona Majalah
                                </div>
                                <div class="card-body">
                                    <form action="{{url('/api/save/zona')}}" method="post" class="form_data">
                                        @csrf
                                        <div class="row d-flex justify-content-center">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="prdcd">Zona</label>
                                                    <input type="text" class="form-control input-data by-plu" name="zona" id="zona">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row d-flex justify-content-center">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="prdcd">Toko</label>
                                                    <div class="form-group">
                                                        <select class="form-control select2 input-data by-plu" name="toko" id="toko" onchange="">
                                                            <option value="" disabled selected>Pilih Toko</option>
                                                        
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
    
                                        <div class="row d-flex justify-content-center">
                                            <div class="col-md-12">
                                                <div class="form-group d-flex justify-content-center">
                                                    <input type="hidden" name="multipleForm" value="1">
                                                    <input type="hidden" name="runtNext1" id="runNext1" onchange="view()">
                                                   <input type="hidden" class="form-control text" name="" value="Apa anda yakin insert ke database?">
                                                   <button class="btn btn-sm btn-primary" type="submit"> Insert Ke Database</button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                        <!-- ============================ -->
                                        <!--             Table            -->
                                        <!-- ============================ -->
                                        <div class="table-container" id="scrollContainer">
                                            <table class="table table-bordered" id="table_cabang">
                                            <thead>
                                                <tr>
                                                <th style="min-width: 100px;" scope="col">Kode Zona</th>
                                                <th style="min-width: 100px;" scope="col">Toko</th>
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

    <script src="{{asset('js/app-zona-majalah.js')}}"></script>
    <script src="{{asset('js/app-submitForm.js')}}"></script>
    <script src="{{asset('js/app-submitForm2.js')}}"></script>
    <script src="{{asset('js/app-hapus.js')}}"></script>
@endsection