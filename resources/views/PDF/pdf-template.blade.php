<!DOCTYPE html>
<html>
<head>
    <title>@yield('page_title')</title>
    <style>
    @page {
        /*margin: 25px 20px;*/
        /*size: 1071pt 792pt;*/
        /* size: @yield('paper_size','595pt 842pt'); */
        size: @yield('paper_size','700pt 842pt');
        /*size: 842pt 638pt;*/
    }
    header {
        position: fixed;
        top: 0cm;
        left: 0cm;
        right: 0cm;
        height: 3cm;
    }
    body {
        margin-top: 10px;
        margin-bottom: 10px;
        font-size: 9px;
        /*Helvin 19/01/2023*/
        /*font-size: 9px;*/
        font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
        font-weight: 400;
        line-height: @yield('body_line_height','1.8'); /* 1.25 */
    }
    table{
        border-collapse: collapse;
    }
    tbody {
        display: table-row-group;
        vertical-align: middle;
        border-color: black;
    }
    tr {
        display: table-row;
        vertical-align: inherit;
        border-color: black;
    }
    td {
        display: table-cell;
    }
    thead{
        text-align: center;
    }
    tbody{
        text-align: center;
    }
    tfoot{
        border-top: 1px solid black;
    }

    .keterangan{
        text-align: left;
    }
    .table{
        width: 100%;
        font-size: @yield('table_font_size','10px');
        white-space: nowrap;
        color: #212529;
        /*padding-top: 20px;*/
        /*margin-top: 25px;*/
    }
    .table-ttd{
        width: 100%;
        font-size: 9px;
        /*white-space: nowrap;*/
        color: #212529;
        /*padding-top: 20px;*/
        /*margin-top: 25px;*/
    }
    .table tbody td {
        /*font-size: 6px;*/
        vertical-align: top;
        /*border-top: 1px solid #dee2e6;*/
        padding: 0.20rem 0;
        width: auto;
    }
    .table th{
        vertical-align: top;
        padding: 0.20rem 0;
    }

    .table tfoot tr td{
        font-weight: bold;
    }

    .judul, .table-borderless{
        text-align: center;
    }
    .table-borderless th, .table-borderless td {
        border: 0;
        padding: 0.50rem;
    }

    .table tbody td.padding-right,.table tbody th.padding-right, .table thead th.padding-right, .table tfoot th.padding-right{
        padding-right: 10px !important;
    }

    .center{
        text-align: center;
    }

    .left{
        text-align: left;
    }

    .right{
        text-align: right;
    }

    .page-break {
        page-break-before: always;
    }

    .page-break-avoid{
        page-break-inside: avoid;
    }

    .table-header td{
        white-space: nowrap;
    }

    .tengah{
        vertical-align: middle !important;
    }

    .blank-row {
        line-height: 70px!important;
        color: white;
    }

    .bold td{
        font-weight: bold;
    }

    .border-top td{
        border-top: 1px solid black;
    }

    .top-bottom{
        border-top: 1px solid black;
        border-bottom: 1px solid black;
    }

    .nowrap{
        white-space: nowrap;
    }

    .overline{
        text-decoration: overline;
    }
    .pagebreak {
        page-break-before: always;
    }
    @yield('custom_style')
</style>
</head>
<body>

<header>
   

</header>



<main>

        @yield('content')


</main>

{{--<footer>--}}
{{--    <p class="right" style="font-size: @yield('table_font_size','10px')">@yield('footer',(__('** Akhir dari laporan **')))</p>--}}
{{--</footer>--}}

<br>
</body>

</html>
