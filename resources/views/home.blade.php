@extends('master')
@section('content')

    <script> $(".nav-item-home").addClass("active"); </script>

    <div class="container-fluid">
        <!-- <div class="form-group" style="width:30%">
            <label for="">Title</label>
            <input type="text" name="" id="" class="form-control" placeholder="" aria-describedby="helpId">
            <small id="helpId" class="text-muted">Help text</small>
        </div>

        <div class="form-group" style="width:30%">
            <label for="">Desc</label>
            <input type="text" name="" id="" class="form-control" placeholder="" aria-describedby="helpId">
            <small id="helpId" class="text-muted">Help text</small>
        </div> -->
        <div class="card shadow mb-4">
            <div class="card-body">
                <table class="table table-bordered dataTable" id="dataTable" width="100%" cellspacing="0" role="grid" aria-describedby="dataTable_info" style="width: 100%;">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Desc</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td scope="row">1</td>
                            <td>test</td>
                            <td>test</td>
                        </tr>
                        <tr>
                            <td scope="row">2</td>
                            <td>test2</td>
                            <td>test2</td>
                        </tr>
                    </tbody>
                </table>  
            </div>
        </div>
    </div>
@endsection