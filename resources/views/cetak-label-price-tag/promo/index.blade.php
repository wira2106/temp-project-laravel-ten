@extends('../../master')
@section('content')

    <script> $(".nav-item-home").addClass("active"); </script>
   
    <div class="container-fluid">
        <div class="card shadow mb-4">
            <div class="card-body" id="label-tag">
                    
                <div class="container mt-5">

                        <div class="row">
                            <div class="col-md-4">
                                <div class="card">
                                    <div class="card-body">
                                        <form action="{{url('/api/insert/promo')}}" method="post" class="form_data">
                                            @csrf
    
                                            <div class="row">
                                                <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="prdcd">PRDCD</label>
                                                    <div class="form-group">
                                                        <select class="form-control select2" name="prdcd" id="prdcd" onchange="changePRDCD(this)">
                                                            <option value="" disabled selected>Pilih PRDCD</option>
                                                            <option value="all"> View All</option>
                                                        
                                                        </select>
                                                    </div>
                                                </div>
                                                </div>
                                            </div>
    
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <div class="form-group">
                                                            <input class="form-control-md" type="checkbox" id="checkbox1"> 
                                                            <label for="checkbox1">Insert All Promo</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

    
                                            <div class="row">
                                                <div class="form-group col-md-6">
                                                    <label for="Selving">Period:</label>
                                                    <select class="form-control" id="select1" name="tgl_awal" id="Selving" disabled>
                                                        <option value="" selected disabled> Tgl Awal</option>
                                                    </select>
                                                </div>
    
                                                <div class="form-group col-md-6">
                                                    <label for="select2" style="color:white;">Selving:</label>
                                                    <select class="form-control" id="select2" name="tgl_akhir" disabled>
                                                        <option value="" selected disabled> Tgl Akhir</option>
                                                        <!-- Options will be dynamically updated based on the selected value in Select 1 -->
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="prdcd">Qty</label>
                                                        <input type="number" class="form-control" name="qty" id="qty">
                                                    </div>
                                                    <div class="qty"></div>
                                                </div>
                                            </div>
        
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group d-flex justify-content-center">
                                                       <input type="hidden" class="form-control desc" name="desc" value="">
                                                       <input type="hidden" class="form-control multipleForm" name="multipleForm" value="">
                                                       <input type="hidden" class="form-control text" name="" value="Apa anda yakin insert ke database?">
                                                       <input type="hidden" class="form-control" id="runNext" onchange="getDataPromo(this.value)" name="runNext">
                                                       <button class="btn btn-sm btn-primary promo_button"  type="button" onclick="submitByRak(this)" disabled> Insert Ke Database</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
    
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="card">
                                    <div class="card-header">
                                        Promo
                                    </div>
                                    <div class="card-body">
                                            <!-- ============================ -->
                                            <!--             Table            -->
                                            <!-- ============================ -->
                                            <div class="table-container" id="scrollContainer">
                                                <table class="table table-bordered" id="table_cabang" style="min-height: 200px;">
                                                <thead>
                                                    <tr>
                                                        <th style="min-width: 100px;" scope="col">lpadd</th>
                                                        <th style="min-width: 100px;" scope="col">prdcd</th>
                                                        <th style="min-width: 100px;" scope="col">kplu</th>
                                                        <th style="min-width: 100px;" scope="col">Nama 1</th>
                                                        <th style="min-width: 100px;" scope="col">Nama 2</th>
                                                        <th style="min-width: 100px;" scope="col">Barc</th>
                                                        <th style="min-width: 100px;" scope="col">Jml 1</th>
                                                        <th style="min-width: 100px;" scope="col">Jml 2</th>
                                                        <th style="min-width: 100px;" scope="col">Jml 3</th>
                                                        <th style="min-width: 100px;" scope="col">Unit 1</th>
                                                        <th style="min-width: 100px;" scope="col">Unit 2</th>
                                                        <th style="min-width: 100px;" scope="col">Unit 3</th>
                                                        <th style="min-width: 150px;" scope="col">Price All 1</th>
                                                        <th style="min-width: 150px;" scope="col">Price All 2</th>
                                                        <th style="min-width: 150px;" scope="col">Price All 3</th>
                                                        <th style="min-width: 150px;" scope="col">Price Unit 1</th>
                                                        <th style="min-width: 150px;" scope="col">Price Unit 2</th>
                                                        <th style="min-width: 150px;" scope="col">Price Unit 3</th>
                                                        <th style="min-width: 100px;" scope="col">Fmbsts</th>
                                                        <th style="min-width: 100px;" scope="col">Flag</th>
                                                        <th style="min-width: 100px;" scope="col">Lokasi</th>
                                                        <th style="min-width: 100px;" scope="col">Fmkdsb</th>
                                                        <th style="min-width: 150px;" scope="col">Status ppn</th>
                                                        <th style="min-width: 100px;" scope="col">Tempo 1</th>
                                                        <th style="min-width: 100px;" scope="col">Tempo 2</th>
                                                        <th style="min-width: 100px;" scope="col">Tgl Insert</th>
                                                        <th style="min-width: 100px;" scope="col">LRec</th>
                                                        <th style="min-width: 100px;" scope="col">Div</th>
                                                        <th style="min-width: 100px;" scope="col">Dept</th>
                                                        <th style="min-width: 100px;" scope="col">Katb</th>
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
                                    <div class="card-footer">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group d-flex justify-content-center">
                                                    <button class="btn btn-sm btn-primary" id="button_view_hasil" onclick="temp_function_viewHasil()" type="button" disabled> View Hasil</button>
                                                    &nbsp;
                                                    <button class="btn btn-sm btn-danger" id="button_delete_all" onclick="temp_function_deleteAll()" type="button" disabled> Delete All</button>
                                                    &nbsp;
                                                    &nbsp;
                                                    &nbsp;
                                                    <button class="btn btn-sm btn-info" id="button_check_all" onclick="temp_function_checkAll()" type="button" disabled> Check All</button>
                                                    &nbsp;
                                                    <button class="btn btn-sm btn-info" id="button_uncheck_all" onclick="temp_function_uncheckAll()" type="button" disabled> Uncheck All</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                            

                </div>

            </div>
        </div>
    </div>

    <script src="{{asset('js/app-promo.js')}}"></script>
    <script src="{{asset('js/app-submitForm.js')}}"></script>
    <script src="{{asset('js/app-submitForm2.js')}}"></script>
    <script src="{{asset('js/app-hapus.js')}}"></script>
@endsection