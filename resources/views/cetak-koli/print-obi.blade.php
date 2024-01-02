@extends('PDF/pdf-template')

@section('table_font_size','7 px')

@section('page_title')
    @lang('barcode OBI')
@endsection

@section('title')
    @lang('barcode OBI')
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
@if(count($data))
@foreach($data as $barcode)
<div class="list_barcode">
    <div class="barcode_nomor_koli">
        {!! DNS1D::getBarcodeHTML($barcode->barcode, 'C128') !!}
    </div>
    <div class="nomor_koli">
       {{$barcode->barcode}}
    </div>
</div>
@endforeach
@else
<div style="text-align: center; font-size:14px;"> Data Tidak Tersedia</div>
@endif
@endsection



