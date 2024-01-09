@extends('../master')
@section('content')

    <script> $(".nav-item-home").addClass("active"); </script>

    <div class="container-fluid">
        <div class="card-header">
            Alasan PB Darurat
        </div>
        <div class="card shadow mb-4">
            <div class="card-body">
               
            <div class="container mt-4">
                <!-- ============================ -->
                <!--             Table            -->
                <!-- ============================ -->
                <div class="table-container" id="scrollContainer">
                    <table class="table table-bordered" id="table_alasan">
                    <thead>
                        <tr>
                        <th scope="col">ALASAN</th>
                        <!-- Add more headers as needed -->
                        </tr>
                    </thead>
                    <tbody id="table-content" >
                       
                        <!-- <tr>
                            <td style="display: none;">6</td>
                            <td>ALASAN 6</td>
                        </tr> -->
                    </tbody>
                    </table>
                </div>
                <!-- ============================ -->
                <!--         End Table            -->
                <!-- ============================ -->
                
                <!-- ============================ -->
                <!--          Form                -->
                <!-- ============================ -->
                <form action="" method="post" class="mt-2" id="form_data">
                    @csrf
                    <div class="form-groups row mb-3">

                        <label for="alasan_baru" class="col-sm-2">Alasan Dipilih</label>
                        <div class="col-sm-10">
                            <div class="input-group ">
                                <input type="hidden" class="form-control" id="id_dipilih"  readonly name="id">
                                <input type="text" class="form-control" id="alasan_dipilih"  readonly name="alasan_dipilih">
                                <div class="input-group-append p-1" style="background-color: #EAECF4; border:1px solid #d1d3e2;border-radius:0 0.35rem 0.35rem 0;" id="reset_input">
                                    <button type="button" class="close"  onclick="reset_alasan()">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            </div>    

                            <small id="error_alasan_dipilih" class="form-text text-muted hide alasan_dipilih">We'll never share your email with anyone else.</small>
                        </div>

                        
                    </div>
                    <div class="form-groups row">

                        <label for="alasan_baru" class="col-sm-2">Alasan Baru</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="alasan_baru" name="alasan_baru">
                            <input type="hidden" class="form-control" id="runNext" name="runNext" onchange="get_list_alasan(true)">
                            <small id="error_alasan_baru-not-use" class="form-text text-muted alasan_baru"></small>
                        </div>
  
                    </div>
                    <div class="form-group">
                        <div class="form-check">
                        <!-- <input class="form-check-input" type="checkbox" id="gridCheck">
                        <label class="form-check-label" for="gridCheck">
                            Check me out
                        </label> -->
                        </div>
                    </div>
                    <div class="d-flex justify-content-center">
                        <input type="hidden" class="text" value="">
                        <button onclick="add(this)" type="button" class="mr-1 btn btn-info tambah" id="tambah">Add</button>
                        <button onclick="update(this)" type="button" class="mr-1 btn btn-primary edit" id="edit">Update</button>
                        <button onclick="hapus(this)" type="button" class="mr-1 btn btn-danger delete" id="delete">Delete</button>
                    </div>
                    <div class="d-flex justify-content-center mt-3">
                        <button onclick="kirim(this)" type="button" class="btn btn-success mr-3 kirim" style="width: 80px;">Kirim</button>
                    </div>
                </form>
                <!-- ============================ -->
                <!--         End Form             -->
                <!-- ============================ -->

                <div class="row mt-3">
                    <div class="col-md-12">
                    <label for="alasan_baru" class="d-flex justify-content-end">Cabang</label>
                        <div class="progress">
                            <div class="progress-bar bg-success w-0" role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100">
                                <div class="persentase_progres">
                                    <span class="angka_progres">0</span><span>%</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
            </div>
            </div>
        </div>
    </div>

    <script src="js/app-master-alasan-pb.js"></script>
    <script src="js/app-submitForm.js"></script>
    <script src="js/app-hapus.js"></script>
@endsection