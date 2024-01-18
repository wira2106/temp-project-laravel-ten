@extends('../html-landscape')

@section('table_font_size','7 px')

@section('page_title')
    @lang('Print Label')
@endsection


@section('title')
    ** @lang('Print Label') **
@endsection
@section('add-css')
       .listLabel{
            display:flex;
            flex-wrap: wrap;
            max-width:842pt;
       }
       .labelCardContainer {
            index:1;
           font-family: Arial, sans-serif;
            display: flex;
            margin-right: -100px;
            margin-top:3px;
            
       }

       .labelCard {
           index:0;
           background-color: #fff;
           border-radius: 10px;
           width:320px;
       }

       .labelCard img {
           width: 100px;
           border-radius: 50%;
           margin-bottom: 10px;
       }

       .name {
           font-size: 16px;
           line-height: 16px;
           font-weight: bold;
           margin-bottom: -3px;
           width:229px;
       }
       .tr1{
            line-height: 14px;
            width:245px;
       }
       .th1{
           font-size: 11px;
       }
       .font1{
            font-size: 22px;
            font-weight: bolder;
            text-align:end;
       }
       .font2{
            font-size: 14px;
       }
       .font3{
            font-size: 16px;
            font-weight: bolder;
       }
       .font4{
            text-align:end;
       }

       .address, .phone, .university, .dob {
           margin-bottom: 10px;
       }
       .rotate-tag {
            margin-left: -205px;
            /* Rotate the element by 45 degrees */
            transform: rotate(90deg) scale(0.5);
            /* Optional: Set the transform origin to center the rotation */
            transform-origin: center;
            color: white;
            display: inline-block;
        }
       .rotate-2 {
            margin-left: -190px;
            /* Rotate the element by 45 degrees */
            transform: rotate(270deg) scale(0.5);
            /* Optional: Set the transform origin to center the rotation */
            transform-origin: center;
            display: inline-block;
            font-size:60px;
        }

@endsection

@section('content')
     <div class="listLabel">

        @foreach($data as $key => $value)
        @php
            $barcode = explode(" ",$value->barc);
            $length = count($barcode) - 1;
        @endphp
         <div class="labelCardContainer">
             <div class="labelCard">
                 <div class="name">{{$value->nama1 && $value->nama1 !== " "?$value->nama1:$value->nama2}}</div>
                 <table>
                     <tr>
                         <th colspan="4" class="th1">{{$value->prdcd}} {{$value->lokasi}}</th>
                         <th colspan="2"  class="th1">{{$barcode[$length]}}</th>
                     </tr>
                     <tr class="tr1">
                         <td>Rp.</td>
                         <td class="font1">{{$value->price_all1?number_format((int)$value->price_all1):'0'}}</td>
                         <td class="font2">{{$value->unit1?$value->unit1:'CTN'}}</td>
                         <td class="font2">{{$value->jml1?$value->jml1:'-'}}</td>
                         <td colspan="2" class="font4">( <span class="font3">{{$value->price_unit1?number_format((int)$value->price_unit1):'0'}}</span> <span class="font2">/PCS</span> )</td>
                     </tr>
                     <tr class="tr1">
                         <td>Rp.</td>
                         <td class="font1">{{$value->price_all2?number_format((int)$value->price_all2):'0'}}</td>
                         <td class="font2">{{$value->unit2?$value->unit2:'PCS'}}</td>
                         <td class="font2">{{$value->jml2?$value->jml2:'-'}}</td>
                         <td colspan="2" class="font4">( <span class="font3">{{$value->price_unit2?number_format((int)$value->price_unit2):'0'}}</span> <span class="font2">/PCS</span> )</td>
                     </tr>
                     <tr class="tr1">
                         <td>Rp.</td>
                         <td class="font1">{{$value->price_all3?number_format((int)$value->price_all3):'0'}}</td>
                         <td class="font2">{{$value->unit3?$value->unit3:'PCS'}}</td>
                         <td class="font2">{{$value->jml3?$value->jml3:'-'}}</td>
                         <td colspan="2" class="font4">( <span class="font3">{{$value->price_unit3?number_format((int)$value->price_unit3):'0'}}</span> <span class="font2">/PCS</span> )</td>
                     </tr>
                     
                     </tr>
                         <td colspan="4">Harga Sudah Termasuk PPN</td>
                         <td colspan="2" style="text-align:center;">{{date('dmy')}} {{$value->fmkdsb}}</td>
                     </tr>
                 </table>
             </div>
             <div class="rotate-tag">
               
                 {!! DNS1D::getBarcodeHTML($barcode[$length], 'C128') !!}
             </div>
             <div class="rotate-2">
                 N00001C
             </div>
         </div> 
        @endforeach
     </div>
@endsection
