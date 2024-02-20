@extends('../../master')
@section('content')

    <script> $(".nav-item-home").addClass("active"); </script>
   
    <div class="container-fluid">
        <div class="card shadow mb-4">
            <div class="card-body" id="card-container">
                    
                <div class="container mt-5">
                            <div class="card input-form by-plu">
                                <div class="card-body">
                                    <form action="{{url('/api/email/add')}}" method="post" class="form_data">
                                       @csrf
                                        <div class="row d-flex justify-content-center">
                                            <div class="form-group col-md-3">
                                                <label for="server">Server:</label>
                                                <input type="text" class="form-control" name="servers" required id="server">
                                            </div>

                                            <div class="form-group col-md-3">
                                                <label for="port" >Port:</label>
                                                <input type="number" class="form-control" name="port" required id="port">
                                            </div>
                                        </div>
                                            
                                        <div class="row d-flex justify-content-center">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="email">Email User</label>
                                                    <input type="email" class="form-control" name="email" required id="email">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row d-flex justify-content-center">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="password">Password</label>
                                                    <input type="password" class="form-control" name="password" required id="password">
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="row d-flex justify-content-center">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="to">To</label>
                                                    <textarea class="form-control" name="to" id="to" cols="30" rows="10" required></textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row d-flex justify-content-center">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="cc">CC</label>
                                                    <textarea class="form-control" name="cc" id="cc" cols="30" rows="10"></textarea>
                                                </div>
                                            </div>
                                        </div>
    
                                        <div class="row d-flex justify-content-center">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="subject">Subject</label>
                                                    <input type="text" class="form-control" name="subject" id="subject" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row d-flex justify-content-center">
                                            <div class="col-md-12">
                                                <div class="form-group d-flex justify-content-center">
                                                   <input type="hidden" class="form-control runNext" name="runNext" id="runNext" onchange="checkEmail">
                                                   <input type="hidden" class="form-control text" name="" value="Apa anda yakin insert ke database?">
                                                   <button class="btn btn-sm btn-primary" type="submit"> Simpan</button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>

                                </div>
                            </div>
                </div>

            </div>
        </div>
    </div>

    <script src="{{asset('js/app-email.js')}}"></script>
    <script src="{{asset('js/app-submitForm.js')}}"></script>
    <script src="{{asset('js/app-submitForm2.js')}}"></script>
    <script src="{{asset('js/app-hapus.js')}}"></script>
@endsection