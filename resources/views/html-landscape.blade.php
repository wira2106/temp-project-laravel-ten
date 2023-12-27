<!DOCTYPE html>
<html>
<head>
    <title>@yield('page_title')</title>
    <style>
        body{
            margin: 0;
        }

        .bg-white{
            background-color: white;
        }

        .bg-gray{
            background-color: rgb(82, 86, 89);
        }

        .content-wrapper{
            margin:auto;
            min-height: @yield('paper_height','700pt');
            width: @yield('paper_width','842pt');
            padding: 10px 10px 10px 10px;
        }

        table.report-container {
            page-break-after:always;
            width: 100%;
        }
        thead.report-header {
            display:table-header-group;
        }
        tfoot.report-footer {
            display:table-footer-group;
        }
        table.report-container div.article {
            page-break-inside: avoid;
        }

        .btn-print{
            float:right;
            color: #fff;
            background-color: #007bff;
            display: inline-block;
            font-weight: 400;
            border: 1px solid transparent;
            padding: .375rem .75rem;
            font-size: 1rem;
            line-height: 1.5;
            height: 100%;
            cursor: pointer;
            border-radius: 5px;
        }

        @page {
            /*margin: 25px 20px;*/
            /*size: 1071pt 792pt;*/
             size: @yield('paper_width','842pt') @yield('paper_height','595pt');
            /* size: @yield('paper_width','auto') @yield('paper_height','auto'); */
            /* size: @yield('paper_size','700pt 842pt'); */
            /*size: 842pt 638pt;*/
        }

        @media print{
            #buttonArea{
                display: none;
            }

            .content-wrapper{
                padding: 0;
            }
        }

        header {
            /*position: fixed;*/
            top: 0cm;
            left: 0cm;
            right: 0cm;
            height: 3cm;
        }
        body {
            /*margin-top: 80px;*/
            /*margin-bottom: 10px;*/
            font-size: 9px;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
            font-weight: 400;
            line-height: @yield('body_line_height','1.8'); /* 1.25 */

            counter-reset: page;
        }

        #pageNumber {
            page-break-before: always;
            counter-increment: page;
        }
        #pageNumber::after {
            content: counter(page);
        }

        .table tbody {
            display: table-row-group;
            vertical-align: middle;
            border-color: inherit;
        }
        .table tr {
            display: table-row;
            vertical-align: inherit;
            border-color: inherit;
        }
        .table td {
            display: table-cell;
        }
        .table thead{
            text-align: center;
        }
        .table tbody{
            text-align: center;
        }
        .table tfoot{
            border-top: 1px solid black;
            border-bottom: 1px solid black;
        }

        .keterangan{
            text-align: left;
        }
        .table{
            border-collapse: collapse;
            width: 100%;
            font-size: @yield('table_font_size','10px') !important;
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
        .judul, .table-borderless{
            text-align: center;
        }
        .table-borderless th, .table-borderless td {
            border: 0;
            padding: 0.50rem;
        }

        .table tbody td.padding-right,tbody th.padding-right, .table thead th.padding-right, .table tfoot th.padding-right{
            padding-right: 10px !important;
        }

        .table tbody td.padding-left, .table thead th.padding-left, .table tfoot th.padding-left{
            padding-left: 10px !important;
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

        .bawah{
            vertical-align: bottom !important;
        }

        .bawah{
            vertical-align: bottom !important;
        }

        .blank-row {
            line-height: 70px!important;
            color: white;
        }

        .bold td{
            font-weight: bold;
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

        @media print {
            .pagebreak { page-break-before: always; } /* page-break-after works, as well */
        }
        @yield('add-css')
        /* @yield('custom_style') */
    </style>

    {{-- <link rel="stylesheet" type="text/css" href="{{ asset('/css/bootstrap.min.css') }}"> --}}

    <script src={{asset('/js/jquery.js')}}></script>    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.5/jspdf.min.js"></script>  
    {{-- <script src="{{ asset('/js/bootstrap.bundle.js') }}"></script> --}}


    
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.22/pdfmake.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.4.1/html2canvas.min.js"></script>

    <script>
        var oldPrintFunction = window.print;

        window.print = function () {
            var curURL = window.location.href;
            var title = $('title').html();
            history.replaceState(history.state, '', '/');
            $('title').html('.');
            oldPrintFunction();
            $('title').html(title);
            history.replaceState(history.state, '', curURL);
        };      
          
      
        

        //$( document ).ready(function() {
        //     var curURL = window.location.href;
        //     namaFile = 'helvin';
        //     // // console.log(curURL)

        //     var url= curURL;
        //     var link = document.createElement('a');
        //     link.href = url;
        //     link.download = namaFile;
        //     link.dispatchEvent(new MouseEvent('click'));

            // $(".btn-print").on("click", function () {
            //     console.log('ok')
            //     html2canvas($('.report-container')[0], {
            //         onrendered: function (canvas) {
            //             var data = canvas.toDataURL();
            //             var docDefinition = {
            //                 content: [{
            //                     image: data,
            //                     width: 500
            //                 }]
            //             };
            //             pdfMake.createPdf(docDefinition).download("customer-details.pdf");
            //         }
            //     });
            // });
        // });

        
        
    </script>
</head>

<body class="bg-gray" id="hlv">
    <div id="buttonArea" style="position: sticky; width: 100%; height: 50px; top: 0;">
        <button class="btn-print" onclick="window.print();">@lang('CETAK')</button>
    </div>
    <div class="bg-white content-wrapper">
       @yield('content')
    </div>

    <script src={{asset('/js/moment.min.js')}}></script>
    <script>
        let momentNow = moment();
        $('#lbl-tanggal').text(momentNow.format('DD-MM-YYYY'));
        $('#lbl-jam').text(momentNow.format('HH:mm:ss'));
        // console.log(momentNow.format('HH:mm:ss'));
    </script>
    <script>
        window.addEventListener("beforeprint", (event) => {
            document.title='@yield('page_title')';
        });

        window.addEventListener("afterprint", (event) => {
            document.title='@yield('page_title')';
        });
    </script>
</body>
</html>