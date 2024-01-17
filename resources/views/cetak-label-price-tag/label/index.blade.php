@extends('../../master')
@section('content')

    <script> $(".nav-item-home").addClass("active"); </script>
   
    <div class="container-fluid">
        <div class="card shadow mb-4">
            <div class="card-body" id="label-tag">
                    
                <div class="container mt-5">
                            <div class="form-group">
                                <label>Pilihan Input:</label>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="option" value="" onchange="toggleInput('by-plu')" id="by-plu">
                                            <label class="form-check-label" for="by-plu">By PLU</label>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="option" value="" onchange="toggleInput('by-div')" id="by-div">
                                            <label class="form-check-label" for="by-div">By Div,Dep, Katb</label>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="option" value="" onchange="toggleInput('by-setting')" id="by-setting">
                                            <label class="form-check-label" for="by-setting">By Setting Pagi</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="option" value="" onchange="toggleInput('by-rak')" id="by-rak">
                                            <label class="form-check-label" for="by-rak">By Rak</label>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="option" value="" onchange="toggleInput('by-tanggal')" id="by-tanggal">
                                            <label class="form-check-label" for="by-tanggal">By Tanggal</label>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="option" value="" onchange="toggleInput('by-flag')" id="by-flag">
                                            <label class="form-check-label" for="by-flag">By Perubahan Flag Aktivasi</label>
                                        </div>
                                    </div>
                                </div>

                            </div>


                            <div class="card input-form by-plu">
                                <div class="card-body">
                                    <form action="{{url('/api/insert/byplu')}}" method="post" class="form_data">
                                        @csrf
                                        <div class="row">
                                            <div class="col-md-12">
                                                <label>By PLU:</label>
                                            </div>
                                        </div>
                                        <div class="row d-flex justify-content-center">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="prdcd">PRDCD/Barcode</label>
                                                    <div class="form-group">
                                                        <select class="form-control select2 input-data by-plu" name="prdcd" id="prdcd" onchange="changePRDCD(this)">
                                                            <option value="" disabled selected>Pilih PRDCD/Barcode</option>
                                                        
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="prdcd"></div>
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

                                                <div class="satuan"></div>
                                            </div>
                                        </div>
    
                                        <div class="row d-flex justify-content-center">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="prdcd">Qty</label>
                                                    <input type="number" class="form-control input-data by-plu" name="qty" id="qty">
                                                </div>
                                                <div class="qty"></div>
                                            </div>
                                        </div>
                                        <div class="row d-flex justify-content-center">
                                            <div class="col-md-12">
                                                <div class="form-group d-flex justify-content-center">
                                                   <input type="hidden" class="form-control multipleForm" name="multipleForm" value="1">
                                                   <input type="hidden" class="form-control text" name="" value="Apa anda yakin insert ke database?">
                                                   <input type="hidden" class="form-control" id="runNext1" onchange="getDataLabel(`prdcd=${$('#prdcd').val()}`)">
                                                   <button class="btn btn-sm btn-primary"  type="button" onclick="submitByPLU(this)"> Insert Ke Database</button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>

                                </div>
                            </div>

                            <div class="card input-form by-rak">
                                <div class="card-body">
                                    <form action="{{url('/api/insert/byrak')}}" method="post" class="form_data">
                                        @csrf
                                        <div class="row">
                                            <div class="col-md-12">
                                                <label>By Rak:</label>
                                            </div>
                                        </div>

                                        <div class="row d-flex justify-content-center">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="rak">Rak</label>
                                                    <div class="form-group">
                                                        <select class="form-control select2 input-data by-rak" name="rak" id="rak" onchange="changeRak(this)">
                                                            <option value="" disabled selected>Pilih Rak</option>
                                                                <option class="option-rak" value="O01">O01</option>
                                                                <option class="option-rak" value="O02">O02</option>
                                                                <option class="option-rak" value="O03">O03</option>
                                                                <option class="option-rak" value="O04">O04</option>
                                                                <option class="option-rak" value="O05">O05</option>
                                                                <option class="option-rak" value="O06">O06</option>
                                                                <option class="option-rak" value="O07">O07</option>
                                                                <option class="option-rak" value="O08">O08</option>
                                                                <option class="option-rak" value="R06A">R06A</option>
                                                                <option class="option-rak" value="R65">R65</option>
                                                                <option class="option-rak" value="RSR">RSR</option>
                                                        
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row d-flex justify-content-center">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="sub-rak">Sub Rak</label>
                                                    <div class="form-group">
                                                        <select class="form-control select2 input-data by-rak" name="sub_rak" id="sub-rak" onchange="changeSubRak(this)">
                                                            <option value="" disabled selected>Pilih Sub Rak</option>
                                                        
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row d-flex justify-content-center">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="tipe">Tipe</label>
                                                    <div class="form-group">
                                                        <select class="form-control select2 input-data by-rak" name="tipe" id="tipe" onchange="changeTipeRak(this)">
                                                            <option value="" disabled selected>Pilih Tipe</option>
                                                        
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row d-flex justify-content-center">
                                            <div class="form-group col-md-3">
                                                <label for="Selving">Selving:</label>
                                                <select class="form-control" id="select1" onchange="updateSelect2Options()" name="selving1" id="Selving">
                                                    <option value="" selected disabled> Pilih Selving</option>
                                                    <option  class="option-sheving" value="1"> 1</option>
                                                    <option  class="option-sheving" value="2"> 2</option>
                                                    <option  class="option-sheving" value="3"> 3</option>
                                                    <option  class="option-sheving" value="4"> 4</option>
                                                    <option  class="option-sheving" value="5"> 5</option>
                                                </select>
                                            </div>

                                            <div class="form-group col-md-3">
                                                <label for="select2" style="color:white;">Selving:</label>
                                                <select class="form-control" id="select2" name="selving2" disabled>
                                                    <!-- Options will be dynamically updated based on the selected value in Select 1 -->
                                                </select>
                                            </div>
                                        </div>
    
                                        <div class="row d-flex justify-content-center">
                                            <div class="col-md-12">
                                                <div class="form-group d-flex justify-content-center">
                                                   <input type="hidden" class="form-control multipleForm" name="multipleForm" value="2">
                                                   <input type="hidden" class="form-control text" name="" value="Apa anda yakin insert ke database?">
                                                   <input type="hidden" class="form-control" id="runNext2" onchange="getDataLabel(this.value)" name="runNext2">
                                                   <button class="btn btn-sm btn-primary"  type="button" onclick="submitByRak(this)"> Insert Ke Database</button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>

                                </div>
                            </div>

                            <div class="card input-form by-div">
                                <div class="card-body">
                                    <form action="{{url('/api/insert/bydiv')}}" method="post" class="form_data">
                                        @csrf
                                        <div class="row">
                                            <div class="col-md-12">
                                                <label>By Div,Dep, Katb:</label>
                                            </div>
                                        </div>

                                        <div class="row d-flex justify-content-center">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="div">DIV</label>
                                                    <div class="form-group">
                                                        <select class="form-control select2 input-data by-div" name="div" id="div" onchange="changeDiv(this)">
                                                            <option value="" disabled selected>Pilih DIV</option>
                                                        
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row d-flex justify-content-center">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="dept">DEPT</label>
                                                    <div class="form-group">
                                                        <select class="form-control select2 input-data by-div" name="dept" id="dept" onchange="changeDept(this)">
                                                            <option value="" disabled selected>Pilih DEPT</option>
                                                        
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row d-flex justify-content-center">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="katb">KATB</label>
                                                    <div class="form-group">
                                                        <select class="form-control select2 input-data by-div" name="katb" id="katb">
                                                            <option value="" disabled selected>Pilih KATB</option>
                                                        
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
    
                                        <div class="row d-flex justify-content-center">
                                            <div class="col-md-12">
                                                <div class="form-group d-flex justify-content-center">
                                                   <input type="hidden" class="form-control multipleForm" name="multipleForm" value="3">
                                                   <input type="hidden" class="form-control text" name="" value="Apa anda yakin insert ke database?">
                                                   <input type="hidden" class="form-control" id="runNext3" onchange="getDataLabel(this.value)" name="runNext3">
                                                   <button class="btn btn-sm btn-primary"  type="button" onclick="submitByDiv(this)"> Insert Ke Database</button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>

                                </div>
                            </div>

                            <div class="card input-form by-tanggal">
                                <div class="card-body">
                                    <form action="{{url('/api/insert/bytanggal')}}" method="post" class="form_data">
                                        @csrf
                                        <div class="row">
                                            <div class="col-md-12">
                                                <label>By Tanggal Aktif:</label>
                                            </div>
                                        </div>

                                        <div class="row d-flex justify-content-center">
                                            <div class="col-md-6">
                                                
                                                    <div class="form-group">
                                                        <label for="datepicker">Tanggal Aktif</label>
                                                        <input type="text" class="form-control input-data by-tanggal" id="datepicker" name="tanggal_aktif" placeholder="Masukan Tanggal Aktif" readonly>
                                                    </div>
                                                    
                                            </div>
                                        </div>
                                        
                                        <div class="row d-flex justify-content-center">
                                            <div class="col-md-12">
                                                <div class="form-group d-flex justify-content-center">

                                                   <input type="hidden" class="form-control multipleForm" name="multipleForm" value="4">
                                                   <input type="hidden" class="form-control text" name="" value="Apa anda yakin insert ke database?">
                                                   <input type="hidden" class="form-control" id="runNext4" onchange="getDataLabel(this.value)" name="runNext4">
                                                   <button class="btn btn-sm btn-primary"  type="button" onclick="submitByTanggal(this)"> Insert Ke Database</button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>

                                </div>
                            </div>

                            <div class="card input-form by-setting">
                                <div class="card-body">
                                    <form action="{{url('/api/insert/bysetting')}}" method="post" class="form_data">
                                        @csrf
                                        <div class="row">
                                            <div class="col-md-12">
                                                <label>By Setting Pagi Hari:</label>
                                            </div>
                                        </div>
                                        
                                        <div class="row d-flex justify-content-center">
                                            <div class="col-md-12">
                                                <div class="form-group d-flex justify-content-center">
                                                   <input type="hidden" class="form-control multipleForm" name="multipleForm" value="5">
                                                   <input type="hidden" class="form-control text" name="" value="Apa anda yakin insert ke database?">
                                                   <input type="hidden" class="form-control" id="runNext5" onchange="getDataLabel(this.value)" name="runNext5">
                                                   <button class="btn btn-sm btn-primary"  type="button" onclick="submitBySetting(this)"> Insert Ke Database</button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>

                                </div>
                            </div>

                            <div class="card input-form by-flag">
                                <div class="card-body">
                                    <form action="{{url('/api/insert/byflag')}}" method="post" class="form_data">
                                        @csrf
                                        <div class="row">
                                            <div class="col-md-12">
                                                <label>By Perubahan Flag Aktivasi:</label>
                                            </div>
                                        </div>
                                        
                                        <div class="row d-flex justify-content-center">
                                            <div class="col-md-12">
                                                <div class="form-group d-flex justify-content-center">
                                                   <input type="hidden" class="form-control multipleForm" name="multipleForm" value="6">
                                                   <input type="hidden" class="form-control text" name="" value="Apa anda yakin insert ke database?">
                                                   <input type="hidden" class="form-control" id="runNext6" onchange="getDataLabel(this.value)" name="runNext6">
                                                   <button class="btn btn-sm btn-primary"  type="button" onclick="submitByFlag(this)"> Insert Ke Database</button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>

                                </div>
                            </div>

                            <div class="card list-label ">
                                <div class="card-header">
                                    Label
                                </div>
                                <div class="card-body">
                                        <!-- ============================ -->
                                        <!--             Table            -->
                                        <!-- ============================ -->
                                        <div class="table-container" id="scrollContainer">
                                            <table class="table table-bordered" id="table_cabang">
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
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            

                </div>

            </div>
        </div>
    </div>

    <script src="{{asset('js/app-label.js')}}"></script>
    <script src="{{asset('js/app-submitForm.js')}}"></script>
    <script src="{{asset('js/app-submitForm2.js')}}"></script>
    <script src="{{asset('js/app-hapus.js')}}"></script>
@endsection