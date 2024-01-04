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
                <div class="table-container">
                    <table class="table table-bordered">
                    <thead>
                        <tr>
                        <th scope="col">#</th>
                        <th scope="col">First Name</th>
                        <th scope="col">Last Name</th>
                        <th scope="col">Email</th>
                        <!-- Add more headers as needed -->
                        </tr>
                    </thead>
                    <tbody id="table-content">
                        <tr>
                            <th scope="row">1</th>
                            <td>John</td>
                            <td>Doe</td>
                            <td>john@example.com</td>
                            <!-- Add more rows as needed -->
                        </tr>
                        <!-- Add more rows as needed -->
                        <tr>
                            <th scope="row">1</th>
                            <td>John</td>
                            <td>Doe</td>
                            <td>john@example.com</td>
                            <!-- Add more rows as needed -->
                        </tr>
                        <!-- Add more rows as needed -->
                        <tr>
                            <th scope="row">1</th>
                            <td>John</td>
                            <td>Doe</td>
                            <td>john@example.com</td>
                            <!-- Add more rows as needed -->
                        </tr>
                        <!-- Add more rows as needed -->
                        <tr>
                            <th scope="row">1</th>
                            <td>John</td>
                            <td>Doe</td>
                            <td>john@example.com</td>
                            <!-- Add more rows as needed -->
                        </tr>
                        <!-- Add more rows as needed -->
                        <tr>
                            <th scope="row">1</th>
                            <td>John</td>
                            <td>Doe</td>
                            <td>john@example.com</td>
                            <!-- Add more rows as needed -->
                        </tr>
                        <!-- Add more rows as needed -->
                        <tr>
                            <th scope="row">1</th>
                            <td>John</td>
                            <td>Doe</td>
                            <td>john@example.com</td>
                            <!-- Add more rows as needed -->
                        </tr>
                        <!-- Add more rows as needed -->
                        <tr>
                            <th scope="row">1</th>
                            <td>John</td>
                            <td>Doe</td>
                            <td>john@example.com</td>
                            <!-- Add more rows as needed -->
                        </tr>
                        <!-- Add more rows as needed -->
                        <tr>
                            <th scope="row">1</th>
                            <td>John</td>
                            <td>Doe</td>
                            <td>john@example.com</td>
                            <!-- Add more rows as needed -->
                        </tr>
                        <!-- Add more rows as needed -->
                        <tr>
                            <th scope="row">1</th>
                            <td>John</td>
                            <td>Doe</td>
                            <td>john@example.com</td>
                            <!-- Add more rows as needed -->
                        </tr>
                        <!-- Add more rows as needed -->
                        <tr>
                            <th scope="row">1</th>
                            <td>John</td>
                            <td>Doe</td>
                            <td>john@example.com</td>
                            <!-- Add more rows as needed -->
                        </tr>
                        <!-- Add more rows as needed -->
                        <tr>
                            <th scope="row">1</th>
                            <td>John</td>
                            <td>Doe</td>
                            <td>john@example.com</td>
                            <!-- Add more rows as needed -->
                        </tr>
                        <!-- Add more rows as needed -->
                        <tr>
                            <th scope="row">1</th>
                            <td>John</td>
                            <td>Doe</td>
                            <td>john@example.com</td>
                            <!-- Add more rows as needed -->
                        </tr>
                        <!-- Add more rows as needed -->
                        <tr>
                            <th scope="row">1</th>
                            <td>John</td>
                            <td>Doe</td>
                            <td>john@example.com</td>
                            <!-- Add more rows as needed -->
                        </tr>
                        <!-- Add more rows as needed -->
                        <tr>
                            <th scope="row">1</th>
                            <td>John</td>
                            <td>Doe</td>
                            <td>john@example.com</td>
                            <!-- Add more rows as needed -->
                        </tr>
                        <!-- Add more rows as needed -->
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
                    <div class="form-groups row mb-3">

                        <label for="alasan_baru" class="col-sm-2">Alasan Dipilih</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="alasan_dipilih" aria-describedby="emailHelp" readonly name="alasan_dipilih">
                            <button type="button" class="close" id="reset_input" style="margin-top: -32px; margin-right:10px;">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>

                        <!-- <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small> -->
                        
                    </div>
                    <div class="form-groups row">

                        <label for="alasan_baru" class="col-sm-2">Alasan Baru</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="alasan_baru" aria-describedby="emailHelp" name="alasan_baru">
                        </div>
                        <!-- <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small> -->
  
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
                        <input type="hidden" class="text">
                        <button onclick="add(this)" type="button" class="mr-1 btn btn-info">Add</button>
                        <button onclick="update(this)" type="button" class="mr-1 btn btn-primary">Update</button>
                        <button onclick="hapus(this)" type="button" class="mr-1 btn btn-danger">Delete</button>
                    </div>
                    <div class="d-flex justify-content-center mt-3">
                        <button onclick="kirim(this)" type="button" class="btn btn-success mr-3" style="width: 80px;">Kirim</button>
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