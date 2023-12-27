@extends('PDF/pdf-template')

@section('table_font_size','7 px')

@section('page_title')
    @lang('404 NOT FOUND')
@endsection

@section('title')
    @lang('404 NOT FOUND')
@endsection

@section('subtitle')
    {{ date('d/m/Y') }} - {{ date('d/m/Y')}}
@endsection

@section('content')

<h4 class="center">@lang('TIDAK ADA DATA')</h4>
@endsection



