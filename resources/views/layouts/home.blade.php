@extends('master')
@section('title')
    <h4>HOME</h4>
@endsection

@section('content')
    <script src="{{ url('js/home.js?time=') . rand() }}"></script>

    <div class="container-fluid">
        <div class="card shadow mb-4">
            <div class="card-body">
                <div class="form-group">
                    <label for="royalti-date">Select Date</label>
                    <input type="month" class="form-control" name="royaltiDate" id="royalti-date"
                        style="max-width:20%; display:inline-block">
                    <button type="button" class="btn btn-primary" name="btnProcessAll" id="btn-process-all"
                        style="margin-left:15px;">Process All Store</button>
                </div>
                <br>
                <table class="table datatble table-striped table-bordered" id="dTable-royalti" width="100%">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Store Code</th>
                            <th>Royalti Date</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
@endsection
