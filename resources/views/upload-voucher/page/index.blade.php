@extends('../../master')
@section('content')

    <script> $(".nav-item-home").addClass("active"); </script>
   
    <div class="container-fluid">
        <div class="card shadow mb-4">
            <div class="card-body" id="label-tag">
                    
                <div class="container mt-5">
                            <div class="form-group">
                                <label>Pilihan folder dengan file csv:</label>

                                <form action="{{url('/api/upload/voucher')}}" method="post" class="form_data">
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
                                                <button class="btn btn-sm btn-primary" type="submit"> Insert Ke Database</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>

                            </div>

                </div>

            </div>
        </div>
    </div>

    <script src="{{asset('js/app-submitForm.js')}}"></script>
    <script src="{{asset('js/app-submitForm2.js')}}"></script>
    <script src="{{asset('js/app-hapus.js')}}"></script>
@endsection