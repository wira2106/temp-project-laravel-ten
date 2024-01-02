@extends('PDF/pdf-template')

@section('table_font_size','7 px')

@section('page_title')
    @lang('Reprint Checker')
@endsection

@section('title')
    @lang('Reprint Checker')
@endsection

@section('subtitle')
    {{ date('d/m/Y') }} - {{ date('d/m/Y')}}
@endsection

@section('custom_style')
        .list_barcode{
            display:inline-block;
            flex-wrap: wrap;
       }
       .barcode_nomor_koli {
            transform: scale(0.78);
            padding-left:0px;
            margin-left:-22px;
            /* Optional: Set the transform origin to center the rotation */
            color: white;
            display: inline-block;
        }
       .nomor_koli {
            padding-top:0px;
            margin-top:-10px;
            display: block;
            font-size:14px;
        }

@endsection

@section('content')
<div class="list_barcode">
    <div class="barcode_nomor_koli">
        {!! DNS1D::getBarcodeHTML($data, 'C128') !!}
    </div>
    <div class="nomor_koli">
       {{$data}}
    </div>
</div>

@endsection



