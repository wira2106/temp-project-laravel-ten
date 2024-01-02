@extends('../html-landscape')

@section('table_font_size','7 px')

@section('page_title')
    @lang('KARTU GUDANG')
@endsection


@section('title')
    ** @lang('KARTU GUDANG') **
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
           font-size: 14px;
           line-height: 16px;
           font-weight: bold;
           margin-bottom: -3px;
       }
       .tr1{
            line-height: 14px;
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
            margin-left: -110px;
            /* Rotate the element by 45 degrees */
            transform: rotate(90deg) scale(0.5);
            /* Optional: Set the transform origin to center the rotation */
            transform-origin: center;
            color: white;
            display: inline-block;
        }
       .rotate-2 {
            margin-left: -137px;
            /* Rotate the element by 45 degrees */
            transform: rotate(270deg) scale(0.5);
            /* Optional: Set the transform origin to center the rotation */
            transform-origin: center;
            display: inline-block;
            font-size:46px;
        }

@endsection

@section('content')
     <div class="listLabel">
         <div class="labelCardContainer">
             <div class="labelCard">
                 <div class="name">INDOMIE MIE GORENG PLUS SPECIAL PCK 80g </div>
                 <table>
                     <tr>
                         <th colspan="4" class="th1">006041021 R12B/02/93/030499</th>
                         <th colspan="2"  class="th1">18010824 0099893010947</th>
                     </tr>
                     <tr class="tr1">
                         <td>Rp.</td>
                         <td class="font1">100.000</td>
                         <td class="font2">CTN</td>
                         <td class="font2">/40</td>
                         <td colspan="2" class="font4">( <span class="font3">2.600</span> <span class="font2">/PCS</span> )</td>
                     </tr>
                     <tr class="tr1">
                         <td>Rp.</td>
                         <td class="font1">80.000</td>
                         <td class="font2">PCS</td>
                         <td class="font2">/40</td>
                         <td colspan="2" class="font4">( <span class="font3">2.600</span> <span class="font2">/PCS</span> )</td>
                     </tr>
                     <tr class="tr1">
                         <td>Rp.</td>
                         <td class="font1">6.000</td>
                         <td class="font2">PCS</td>
                         <td class="font2">/40</td>
                         <td colspan="2" class="font4">( <span class="font3">2.600</span> <span class="font2">/PCS</span> )</td>
                     </tr>
                     </tr>
                         <td colspan="4">Harga Sudah Termasuk PPN</td>
                         <td colspan="2" style="text-align:center;">WIN BE RI</td>
                     </tr>
                 </table>
             </div>
             <div class="rotate-tag">
                 {!! DNS1D::getBarcodeHTML('121412', 'C128') !!}
             </div>
             <div class="rotate-2">
                 NR12B 0212
             </div>
         </div>
         <div class="labelCardContainer">
             <div class="labelCard">
                 <div class="name">INDOMIE MIE GORENG PLUS SPECIAL PCK 80g </div>
                 <table>
                     <tr>
                         <th colspan="4" class="th1">006041021 R12B/02/93/030499</th>
                         <th colspan="2"  class="th1">18010824 0099893010947</th>
                     </tr>
                     <tr class="tr1">
                         <td>Rp.</td>
                         <td class="font1">100.000</td>
                         <td class="font2">CTN</td>
                         <td class="font2">/40</td>
                         <td colspan="2" class="font4">( <span class="font3">2.600</span> <span class="font2">/PCS</span> )</td>
                     </tr>
                     <tr class="tr1">
                         <td>Rp.</td>
                         <td class="font1">80.000</td>
                         <td class="font2">PCS</td>
                         <td class="font2">/40</td>
                         <td colspan="2" class="font4">( <span class="font3">2.600</span> <span class="font2">/PCS</span> )</td>
                     </tr>
                     <tr class="tr1">
                         <td>Rp.</td>
                         <td class="font1">6.000</td>
                         <td class="font2">PCS</td>
                         <td class="font2">/40</td>
                         <td colspan="2" class="font4">( <span class="font3">2.600</span> <span class="font2">/PCS</span> )</td>
                     </tr>
                     </tr>
                         <td colspan="4">Harga Sudah Termasuk PPN</td>
                         <td colspan="2" style="text-align:center;">WIN BE RI</td>
                     </tr>
                 </table>
             </div>
             <div class="rotate-tag">
                 {!! DNS1D::getBarcodeHTML('121412', 'C128') !!}
             </div>
             <div class="rotate-2">
                 NR12B 0212
             </div>
         </div>
         <div class="labelCardContainer">
             <div class="labelCard">
                 <div class="name">INDOMIE MIE GORENG PLUS SPECIAL PCK 80g </div>
                 <table>
                     <tr>
                         <th colspan="4" class="th1">006041021 R12B/02/93/030499</th>
                         <th colspan="2"  class="th1">18010824 0099893010947</th>
                     </tr>
                     <tr class="tr1">
                         <td>Rp.</td>
                         <td class="font1">100.000</td>
                         <td class="font2">CTN</td>
                         <td class="font2">/40</td>
                         <td colspan="2" class="font4">( <span class="font3">2.600</span> <span class="font2">/PCS</span> )</td>
                     </tr>
                     <tr class="tr1">
                         <td>Rp.</td>
                         <td class="font1">80.000</td>
                         <td class="font2">PCS</td>
                         <td class="font2">/40</td>
                         <td colspan="2" class="font4">( <span class="font3">2.600</span> <span class="font2">/PCS</span> )</td>
                     </tr>
                     <tr class="tr1">
                         <td>Rp.</td>
                         <td class="font1">6.000</td>
                         <td class="font2">PCS</td>
                         <td class="font2">/40</td>
                         <td colspan="2" class="font4">( <span class="font3">2.600</span> <span class="font2">/PCS</span> )</td>
                     </tr>
                     </tr>
                         <td colspan="4">Harga Sudah Termasuk PPN</td>
                         <td colspan="2" style="text-align:center;">WIN BE RI</td>
                     </tr>
                 </table>
             </div>
             <div class="rotate-tag">
                 {!! DNS1D::getBarcodeHTML('121412', 'C128') !!}
             </div>
             <div class="rotate-2">
                 NR12B 0212
             </div>
         </div>
         <div class="labelCardContainer">
             <div class="labelCard">
                 <div class="name">INDOMIE MIE GORENG PLUS SPECIAL PCK 80g </div>
                 <table>
                     <tr>
                         <th colspan="4" class="th1">006041021 R12B/02/93/030499</th>
                         <th colspan="2"  class="th1">18010824 0099893010947</th>
                     </tr>
                     <tr class="tr1">
                         <td>Rp.</td>
                         <td class="font1">100.000</td>
                         <td class="font2">CTN</td>
                         <td class="font2">/40</td>
                         <td colspan="2" class="font4">( <span class="font3">2.600</span> <span class="font2">/PCS</span> )</td>
                     </tr>
                     <tr class="tr1">
                         <td>Rp.</td>
                         <td class="font1">80.000</td>
                         <td class="font2">PCS</td>
                         <td class="font2">/40</td>
                         <td colspan="2" class="font4">( <span class="font3">2.600</span> <span class="font2">/PCS</span> )</td>
                     </tr>
                     <tr class="tr1">
                         <td>Rp.</td>
                         <td class="font1">6.000</td>
                         <td class="font2">PCS</td>
                         <td class="font2">/40</td>
                         <td colspan="2" class="font4">( <span class="font3">2.600</span> <span class="font2">/PCS</span> )</td>
                     </tr>
                     </tr>
                         <td colspan="4">Harga Sudah Termasuk PPN</td>
                         <td colspan="2" style="text-align:center;">WIN BE RI</td>
                     </tr>
                 </table>
             </div>
             <div class="rotate-tag">
                 {!! DNS1D::getBarcodeHTML('121412', 'C128') !!}
             </div>
             <div class="rotate-2">
                 NR12B 0212
             </div>
         </div>
         <div class="labelCardContainer">
             <div class="labelCard">
                 <div class="name">INDOMIE MIE GORENG PLUS SPECIAL PCK 80g </div>
                 <table>
                     <tr>
                         <th colspan="4" class="th1">006041021 R12B/02/93/030499</th>
                         <th colspan="2"  class="th1">18010824 0099893010947</th>
                     </tr>
                     <tr class="tr1">
                         <td>Rp.</td>
                         <td class="font1">100.000</td>
                         <td class="font2">CTN</td>
                         <td class="font2">/40</td>
                         <td colspan="2" class="font4">( <span class="font3">2.600</span> <span class="font2">/PCS</span> )</td>
                     </tr>
                     <tr class="tr1">
                         <td>Rp.</td>
                         <td class="font1">80.000</td>
                         <td class="font2">PCS</td>
                         <td class="font2">/40</td>
                         <td colspan="2" class="font4">( <span class="font3">2.600</span> <span class="font2">/PCS</span> )</td>
                     </tr>
                     <tr class="tr1">
                         <td>Rp.</td>
                         <td class="font1">6.000</td>
                         <td class="font2">PCS</td>
                         <td class="font2">/40</td>
                         <td colspan="2" class="font4">( <span class="font3">2.600</span> <span class="font2">/PCS</span> )</td>
                     </tr>
                     </tr>
                         <td colspan="4">Harga Sudah Termasuk PPN</td>
                         <td colspan="2" style="text-align:center;">WIN BE RI</td>
                     </tr>
                 </table>
             </div>
             <div class="rotate-tag">
                 {!! DNS1D::getBarcodeHTML('121412', 'C128') !!}
             </div>
             <div class="rotate-2">
                 NR12B 0212
             </div>
         </div>
         <div class="labelCardContainer">
             <div class="labelCard">
                 <div class="name">INDOMIE MIE GORENG PLUS SPECIAL PCK 80g </div>
                 <table>
                     <tr>
                         <th colspan="4" class="th1">006041021 R12B/02/93/030499</th>
                         <th colspan="2"  class="th1">18010824 0099893010947</th>
                     </tr>
                     <tr class="tr1">
                         <td>Rp.</td>
                         <td class="font1">100.000</td>
                         <td class="font2">CTN</td>
                         <td class="font2">/40</td>
                         <td colspan="2" class="font4">( <span class="font3">2.600</span> <span class="font2">/PCS</span> )</td>
                     </tr>
                     <tr class="tr1">
                         <td>Rp.</td>
                         <td class="font1">80.000</td>
                         <td class="font2">PCS</td>
                         <td class="font2">/40</td>
                         <td colspan="2" class="font4">( <span class="font3">2.600</span> <span class="font2">/PCS</span> )</td>
                     </tr>
                     <tr class="tr1">
                         <td>Rp.</td>
                         <td class="font1">6.000</td>
                         <td class="font2">PCS</td>
                         <td class="font2">/40</td>
                         <td colspan="2" class="font4">( <span class="font3">2.600</span> <span class="font2">/PCS</span> )</td>
                     </tr>
                     </tr>
                         <td colspan="4">Harga Sudah Termasuk PPN</td>
                         <td colspan="2" style="text-align:center;">WIN BE RI</td>
                     </tr>
                 </table>
             </div>
             <div class="rotate-tag">
                 {!! DNS1D::getBarcodeHTML('121412', 'C128') !!}
             </div>
             <div class="rotate-2">
                 NR12B 0212
             </div>
         </div>
         <div class="labelCardContainer">
             <div class="labelCard">
                 <div class="name">INDOMIE MIE GORENG PLUS SPECIAL PCK 80g </div>
                 <table>
                     <tr>
                         <th colspan="4" class="th1">006041021 R12B/02/93/030499</th>
                         <th colspan="2"  class="th1">18010824 0099893010947</th>
                     </tr>
                     <tr class="tr1">
                         <td>Rp.</td>
                         <td class="font1">100.000</td>
                         <td class="font2">CTN</td>
                         <td class="font2">/40</td>
                         <td colspan="2" class="font4">( <span class="font3">2.600</span> <span class="font2">/PCS</span> )</td>
                     </tr>
                     <tr class="tr1">
                         <td>Rp.</td>
                         <td class="font1">80.000</td>
                         <td class="font2">PCS</td>
                         <td class="font2">/40</td>
                         <td colspan="2" class="font4">( <span class="font3">2.600</span> <span class="font2">/PCS</span> )</td>
                     </tr>
                     <tr class="tr1">
                         <td>Rp.</td>
                         <td class="font1">6.000</td>
                         <td class="font2">PCS</td>
                         <td class="font2">/40</td>
                         <td colspan="2" class="font4">( <span class="font3">2.600</span> <span class="font2">/PCS</span> )</td>
                     </tr>
                     </tr>
                         <td colspan="4">Harga Sudah Termasuk PPN</td>
                         <td colspan="2" style="text-align:center;">WIN BE RI</td>
                     </tr>
                 </table>
             </div>
             <div class="rotate-tag">
                 {!! DNS1D::getBarcodeHTML('121412', 'C128') !!}
             </div>
             <div class="rotate-2">
                 NR12B 0212
             </div>
         </div>
         <div class="labelCardContainer">
             <div class="labelCard">
                 <div class="name">INDOMIE MIE GORENG PLUS SPECIAL PCK 80g </div>
                 <table>
                     <tr>
                         <th colspan="4" class="th1">006041021 R12B/02/93/030499</th>
                         <th colspan="2"  class="th1">18010824 0099893010947</th>
                     </tr>
                     <tr class="tr1">
                         <td>Rp.</td>
                         <td class="font1">100.000</td>
                         <td class="font2">CTN</td>
                         <td class="font2">/40</td>
                         <td colspan="2" class="font4">( <span class="font3">2.600</span> <span class="font2">/PCS</span> )</td>
                     </tr>
                     <tr class="tr1">
                         <td>Rp.</td>
                         <td class="font1">80.000</td>
                         <td class="font2">PCS</td>
                         <td class="font2">/40</td>
                         <td colspan="2" class="font4">( <span class="font3">2.600</span> <span class="font2">/PCS</span> )</td>
                     </tr>
                     <tr class="tr1">
                         <td>Rp.</td>
                         <td class="font1">6.000</td>
                         <td class="font2">PCS</td>
                         <td class="font2">/40</td>
                         <td colspan="2" class="font4">( <span class="font3">2.600</span> <span class="font2">/PCS</span> )</td>
                     </tr>
                     </tr>
                         <td colspan="4">Harga Sudah Termasuk PPN</td>
                         <td colspan="2" style="text-align:center;">WIN BE RI</td>
                     </tr>
                 </table>
             </div>
             <div class="rotate-tag">
                 {!! DNS1D::getBarcodeHTML('121412', 'C128') !!}
             </div>
             <div class="rotate-2">
                 NR12B 0212
             </div>
         </div>
         <div class="labelCardContainer">
             <div class="labelCard">
                 <div class="name">INDOMIE MIE GORENG PLUS SPECIAL PCK 80g </div>
                 <table>
                     <tr>
                         <th colspan="4" class="th1">006041021 R12B/02/93/030499</th>
                         <th colspan="2"  class="th1">18010824 0099893010947</th>
                     </tr>
                     <tr class="tr1">
                         <td>Rp.</td>
                         <td class="font1">100.000</td>
                         <td class="font2">CTN</td>
                         <td class="font2">/40</td>
                         <td colspan="2" class="font4">( <span class="font3">2.600</span> <span class="font2">/PCS</span> )</td>
                     </tr>
                     <tr class="tr1">
                         <td>Rp.</td>
                         <td class="font1">80.000</td>
                         <td class="font2">PCS</td>
                         <td class="font2">/40</td>
                         <td colspan="2" class="font4">( <span class="font3">2.600</span> <span class="font2">/PCS</span> )</td>
                     </tr>
                     <tr class="tr1">
                         <td>Rp.</td>
                         <td class="font1">6.000</td>
                         <td class="font2">PCS</td>
                         <td class="font2">/40</td>
                         <td colspan="2" class="font4">( <span class="font3">2.600</span> <span class="font2">/PCS</span> )</td>
                     </tr>
                     </tr>
                         <td colspan="4">Harga Sudah Termasuk PPN</td>
                         <td colspan="2" style="text-align:center;">WIN BE RI</td>
                     </tr>
                 </table>
             </div>
             <div class="rotate-tag">
                 {!! DNS1D::getBarcodeHTML('121412', 'C128') !!}
             </div>
             <div class="rotate-2">
                 NR12B 0212
             </div>
         </div>
         <div class="labelCardContainer">
             <div class="labelCard">
                 <div class="name">INDOMIE MIE GORENG PLUS SPECIAL PCK 80g </div>
                 <table>
                     <tr>
                         <th colspan="4" class="th1">006041021 R12B/02/93/030499</th>
                         <th colspan="2"  class="th1">18010824 0099893010947</th>
                     </tr>
                     <tr class="tr1">
                         <td>Rp.</td>
                         <td class="font1">100.000</td>
                         <td class="font2">CTN</td>
                         <td class="font2">/40</td>
                         <td colspan="2" class="font4">( <span class="font3">2.600</span> <span class="font2">/PCS</span> )</td>
                     </tr>
                     <tr class="tr1">
                         <td>Rp.</td>
                         <td class="font1">80.000</td>
                         <td class="font2">PCS</td>
                         <td class="font2">/40</td>
                         <td colspan="2" class="font4">( <span class="font3">2.600</span> <span class="font2">/PCS</span> )</td>
                     </tr>
                     <tr class="tr1">
                         <td>Rp.</td>
                         <td class="font1">6.000</td>
                         <td class="font2">PCS</td>
                         <td class="font2">/40</td>
                         <td colspan="2" class="font4">( <span class="font3">2.600</span> <span class="font2">/PCS</span> )</td>
                     </tr>
                     </tr>
                         <td colspan="4">Harga Sudah Termasuk PPN</td>
                         <td colspan="2" style="text-align:center;">WIN BE RI</td>
                     </tr>
                 </table>
             </div>
             <div class="rotate-tag">
                 {!! DNS1D::getBarcodeHTML('121412', 'C128') !!}
             </div>
             <div class="rotate-2">
                 NR12B 0212
             </div>
         </div>
         <div class="labelCardContainer">
             <div class="labelCard">
                 <div class="name">INDOMIE MIE GORENG PLUS SPECIAL PCK 80g </div>
                 <table>
                     <tr>
                         <th colspan="4" class="th1">006041021 R12B/02/93/030499</th>
                         <th colspan="2"  class="th1">18010824 0099893010947</th>
                     </tr>
                     <tr class="tr1">
                         <td>Rp.</td>
                         <td class="font1">100.000</td>
                         <td class="font2">CTN</td>
                         <td class="font2">/40</td>
                         <td colspan="2" class="font4">( <span class="font3">2.600</span> <span class="font2">/PCS</span> )</td>
                     </tr>
                     <tr class="tr1">
                         <td>Rp.</td>
                         <td class="font1">80.000</td>
                         <td class="font2">PCS</td>
                         <td class="font2">/40</td>
                         <td colspan="2" class="font4">( <span class="font3">2.600</span> <span class="font2">/PCS</span> )</td>
                     </tr>
                     <tr class="tr1">
                         <td>Rp.</td>
                         <td class="font1">6.000</td>
                         <td class="font2">PCS</td>
                         <td class="font2">/40</td>
                         <td colspan="2" class="font4">( <span class="font3">2.600</span> <span class="font2">/PCS</span> )</td>
                     </tr>
                     </tr>
                         <td colspan="4">Harga Sudah Termasuk PPN</td>
                         <td colspan="2" style="text-align:center;">WIN BE RI</td>
                     </tr>
                 </table>
             </div>
             <div class="rotate-tag">
                 {!! DNS1D::getBarcodeHTML('121412', 'C128') !!}
             </div>
             <div class="rotate-2">
                 NR12B 0212
             </div>
         </div>
         <div class="labelCardContainer">
             <div class="labelCard">
                 <div class="name">INDOMIE MIE GORENG PLUS SPECIAL PCK 80g </div>
                 <table>
                     <tr>
                         <th colspan="4" class="th1">006041021 R12B/02/93/030499</th>
                         <th colspan="2"  class="th1">18010824 0099893010947</th>
                     </tr>
                     <tr class="tr1">
                         <td>Rp.</td>
                         <td class="font1">100.000</td>
                         <td class="font2">CTN</td>
                         <td class="font2">/40</td>
                         <td colspan="2" class="font4">( <span class="font3">2.600</span> <span class="font2">/PCS</span> )</td>
                     </tr>
                     <tr class="tr1">
                         <td>Rp.</td>
                         <td class="font1">80.000</td>
                         <td class="font2">PCS</td>
                         <td class="font2">/40</td>
                         <td colspan="2" class="font4">( <span class="font3">2.600</span> <span class="font2">/PCS</span> )</td>
                     </tr>
                     <tr class="tr1">
                         <td>Rp.</td>
                         <td class="font1">6.000</td>
                         <td class="font2">PCS</td>
                         <td class="font2">/40</td>
                         <td colspan="2" class="font4">( <span class="font3">2.600</span> <span class="font2">/PCS</span> )</td>
                     </tr>
                     </tr>
                         <td colspan="4">Harga Sudah Termasuk PPN</td>
                         <td colspan="2" style="text-align:center;">WIN BE RI</td>
                     </tr>
                 </table>
             </div>
             <div class="rotate-tag">
                 {!! DNS1D::getBarcodeHTML('121412', 'C128') !!}
             </div>
             <div class="rotate-2">
                 NR12B 0212
             </div>
         </div>
         <div class="labelCardContainer">
             <div class="labelCard">
                 <div class="name">INDOMIE MIE GORENG PLUS SPECIAL PCK 80g </div>
                 <table>
                     <tr>
                         <th colspan="4" class="th1">006041021 R12B/02/93/030499</th>
                         <th colspan="2"  class="th1">18010824 0099893010947</th>
                     </tr>
                     <tr class="tr1">
                         <td>Rp.</td>
                         <td class="font1">100.000</td>
                         <td class="font2">CTN</td>
                         <td class="font2">/40</td>
                         <td colspan="2" class="font4">( <span class="font3">2.600</span> <span class="font2">/PCS</span> )</td>
                     </tr>
                     <tr class="tr1">
                         <td>Rp.</td>
                         <td class="font1">80.000</td>
                         <td class="font2">PCS</td>
                         <td class="font2">/40</td>
                         <td colspan="2" class="font4">( <span class="font3">2.600</span> <span class="font2">/PCS</span> )</td>
                     </tr>
                     <tr class="tr1">
                         <td>Rp.</td>
                         <td class="font1">6.000</td>
                         <td class="font2">PCS</td>
                         <td class="font2">/40</td>
                         <td colspan="2" class="font4">( <span class="font3">2.600</span> <span class="font2">/PCS</span> )</td>
                     </tr>
                     </tr>
                         <td colspan="4">Harga Sudah Termasuk PPN</td>
                         <td colspan="2" style="text-align:center;">WIN BE RI</td>
                     </tr>
                 </table>
             </div>
             <div class="rotate-tag">
                 {!! DNS1D::getBarcodeHTML('121412', 'C128') !!}
             </div>
             <div class="rotate-2">
                 NR12B 0212
             </div>
         </div>
         <div class="labelCardContainer">
             <div class="labelCard">
                 <div class="name">INDOMIE MIE GORENG PLUS SPECIAL PCK 80g </div>
                 <table>
                     <tr>
                         <th colspan="4" class="th1">006041021 R12B/02/93/030499</th>
                         <th colspan="2"  class="th1">18010824 0099893010947</th>
                     </tr>
                     <tr class="tr1">
                         <td>Rp.</td>
                         <td class="font1">100.000</td>
                         <td class="font2">CTN</td>
                         <td class="font2">/40</td>
                         <td colspan="2" class="font4">( <span class="font3">2.600</span> <span class="font2">/PCS</span> )</td>
                     </tr>
                     <tr class="tr1">
                         <td>Rp.</td>
                         <td class="font1">80.000</td>
                         <td class="font2">PCS</td>
                         <td class="font2">/40</td>
                         <td colspan="2" class="font4">( <span class="font3">2.600</span> <span class="font2">/PCS</span> )</td>
                     </tr>
                     <tr class="tr1">
                         <td>Rp.</td>
                         <td class="font1">6.000</td>
                         <td class="font2">PCS</td>
                         <td class="font2">/40</td>
                         <td colspan="2" class="font4">( <span class="font3">2.600</span> <span class="font2">/PCS</span> )</td>
                     </tr>
                     </tr>
                         <td colspan="4">Harga Sudah Termasuk PPN</td>
                         <td colspan="2" style="text-align:center;">WIN BE RI</td>
                     </tr>
                 </table>
             </div>
             <div class="rotate-tag">
                 {!! DNS1D::getBarcodeHTML('121412', 'C128') !!}
             </div>
             <div class="rotate-2">
                 NR12B 0212
             </div>
         </div>
         <div class="labelCardContainer">
             <div class="labelCard">
                 <div class="name">INDOMIE MIE GORENG PLUS SPECIAL PCK 80g </div>
                 <table>
                     <tr>
                         <th colspan="4" class="th1">006041021 R12B/02/93/030499</th>
                         <th colspan="2"  class="th1">18010824 0099893010947</th>
                     </tr>
                     <tr class="tr1">
                         <td>Rp.</td>
                         <td class="font1">100.000</td>
                         <td class="font2">CTN</td>
                         <td class="font2">/40</td>
                         <td colspan="2" class="font4">( <span class="font3">2.600</span> <span class="font2">/PCS</span> )</td>
                     </tr>
                     <tr class="tr1">
                         <td>Rp.</td>
                         <td class="font1">80.000</td>
                         <td class="font2">PCS</td>
                         <td class="font2">/40</td>
                         <td colspan="2" class="font4">( <span class="font3">2.600</span> <span class="font2">/PCS</span> )</td>
                     </tr>
                     <tr class="tr1">
                         <td>Rp.</td>
                         <td class="font1">6.000</td>
                         <td class="font2">PCS</td>
                         <td class="font2">/40</td>
                         <td colspan="2" class="font4">( <span class="font3">2.600</span> <span class="font2">/PCS</span> )</td>
                     </tr>
                     </tr>
                         <td colspan="4">Harga Sudah Termasuk PPN</td>
                         <td colspan="2" style="text-align:center;">WIN BE RI</td>
                     </tr>
                 </table>
             </div>
             <div class="rotate-tag">
                 {!! DNS1D::getBarcodeHTML('121412', 'C128') !!}
             </div>
             <div class="rotate-2">
                 NR12B 0212
             </div>
         </div>
         <div class="labelCardContainer">
             <div class="labelCard">
                 <div class="name">INDOMIE MIE GORENG PLUS SPECIAL PCK 80g </div>
                 <table>
                     <tr>
                         <th colspan="4" class="th1">006041021 R12B/02/93/030499</th>
                         <th colspan="2"  class="th1">18010824 0099893010947</th>
                     </tr>
                     <tr class="tr1">
                         <td>Rp.</td>
                         <td class="font1">100.000</td>
                         <td class="font2">CTN</td>
                         <td class="font2">/40</td>
                         <td colspan="2" class="font4">( <span class="font3">2.600</span> <span class="font2">/PCS</span> )</td>
                     </tr>
                     <tr class="tr1">
                         <td>Rp.</td>
                         <td class="font1">80.000</td>
                         <td class="font2">PCS</td>
                         <td class="font2">/40</td>
                         <td colspan="2" class="font4">( <span class="font3">2.600</span> <span class="font2">/PCS</span> )</td>
                     </tr>
                     <tr class="tr1">
                         <td>Rp.</td>
                         <td class="font1">6.000</td>
                         <td class="font2">PCS</td>
                         <td class="font2">/40</td>
                         <td colspan="2" class="font4">( <span class="font3">2.600</span> <span class="font2">/PCS</span> )</td>
                     </tr>
                     </tr>
                         <td colspan="4">Harga Sudah Termasuk PPN</td>
                         <td colspan="2" style="text-align:center;">WIN BE RI</td>
                     </tr>
                 </table>
             </div>
             <div class="rotate-tag">
                 {!! DNS1D::getBarcodeHTML('121412', 'C128') !!}
             </div>
             <div class="rotate-2">
                 NR12B 0212
             </div>
         </div>
         <div class="labelCardContainer">
             <div class="labelCard">
                 <div class="name">INDOMIE MIE GORENG PLUS SPECIAL PCK 80g </div>
                 <table>
                     <tr>
                         <th colspan="4" class="th1">006041021 R12B/02/93/030499</th>
                         <th colspan="2"  class="th1">18010824 0099893010947</th>
                     </tr>
                     <tr class="tr1">
                         <td>Rp.</td>
                         <td class="font1">100.000</td>
                         <td class="font2">CTN</td>
                         <td class="font2">/40</td>
                         <td colspan="2" class="font4">( <span class="font3">2.600</span> <span class="font2">/PCS</span> )</td>
                     </tr>
                     <tr class="tr1">
                         <td>Rp.</td>
                         <td class="font1">80.000</td>
                         <td class="font2">PCS</td>
                         <td class="font2">/40</td>
                         <td colspan="2" class="font4">( <span class="font3">2.600</span> <span class="font2">/PCS</span> )</td>
                     </tr>
                     <tr class="tr1">
                         <td>Rp.</td>
                         <td class="font1">6.000</td>
                         <td class="font2">PCS</td>
                         <td class="font2">/40</td>
                         <td colspan="2" class="font4">( <span class="font3">2.600</span> <span class="font2">/PCS</span> )</td>
                     </tr>
                     </tr>
                         <td colspan="4">Harga Sudah Termasuk PPN</td>
                         <td colspan="2" style="text-align:center;">WIN BE RI</td>
                     </tr>
                 </table>
             </div>
             <div class="rotate-tag">
                 {!! DNS1D::getBarcodeHTML('121412', 'C128') !!}
             </div>
             <div class="rotate-2">
                 NR12B 0212
             </div>
         </div>
         <div class="labelCardContainer">
             <div class="labelCard">
                 <div class="name">INDOMIE MIE GORENG PLUS SPECIAL PCK 80g </div>
                 <table>
                     <tr>
                         <th colspan="4" class="th1">006041021 R12B/02/93/030499</th>
                         <th colspan="2"  class="th1">18010824 0099893010947</th>
                     </tr>
                     <tr class="tr1">
                         <td>Rp.</td>
                         <td class="font1">100.000</td>
                         <td class="font2">CTN</td>
                         <td class="font2">/40</td>
                         <td colspan="2" class="font4">( <span class="font3">2.600</span> <span class="font2">/PCS</span> )</td>
                     </tr>
                     <tr class="tr1">
                         <td>Rp.</td>
                         <td class="font1">80.000</td>
                         <td class="font2">PCS</td>
                         <td class="font2">/40</td>
                         <td colspan="2" class="font4">( <span class="font3">2.600</span> <span class="font2">/PCS</span> )</td>
                     </tr>
                     <tr class="tr1">
                         <td>Rp.</td>
                         <td class="font1">6.000</td>
                         <td class="font2">PCS</td>
                         <td class="font2">/40</td>
                         <td colspan="2" class="font4">( <span class="font3">2.600</span> <span class="font2">/PCS</span> )</td>
                     </tr>
                     </tr>
                         <td colspan="4">Harga Sudah Termasuk PPN</td>
                         <td colspan="2" style="text-align:center;">WIN BE RI</td>
                     </tr>
                 </table>
             </div>
             <div class="rotate-tag">
                 {!! DNS1D::getBarcodeHTML('121412', 'C128') !!}
             </div>
             <div class="rotate-2">
                 NR12B 0212
             </div>
         </div>
         <div class="labelCardContainer">
             <div class="labelCard">
                 <div class="name">INDOMIE MIE GORENG PLUS SPECIAL PCK 80g </div>
                 <table>
                     <tr>
                         <th colspan="4" class="th1">006041021 R12B/02/93/030499</th>
                         <th colspan="2"  class="th1">18010824 0099893010947</th>
                     </tr>
                     <tr class="tr1">
                         <td>Rp.</td>
                         <td class="font1">100.000</td>
                         <td class="font2">CTN</td>
                         <td class="font2">/40</td>
                         <td colspan="2" class="font4">( <span class="font3">2.600</span> <span class="font2">/PCS</span> )</td>
                     </tr>
                     <tr class="tr1">
                         <td>Rp.</td>
                         <td class="font1">80.000</td>
                         <td class="font2">PCS</td>
                         <td class="font2">/40</td>
                         <td colspan="2" class="font4">( <span class="font3">2.600</span> <span class="font2">/PCS</span> )</td>
                     </tr>
                     <tr class="tr1">
                         <td>Rp.</td>
                         <td class="font1">6.000</td>
                         <td class="font2">PCS</td>
                         <td class="font2">/40</td>
                         <td colspan="2" class="font4">( <span class="font3">2.600</span> <span class="font2">/PCS</span> )</td>
                     </tr>
                     </tr>
                         <td colspan="4">Harga Sudah Termasuk PPN</td>
                         <td colspan="2" style="text-align:center;">WIN BE RI</td>
                     </tr>
                 </table>
             </div>
             <div class="rotate-tag">
                 {!! DNS1D::getBarcodeHTML('121412', 'C128') !!}
             </div>
             <div class="rotate-2">
                 NR12B 0212
             </div>
         </div>
         <div class="labelCardContainer">
             <div class="labelCard">
                 <div class="name">INDOMIE MIE GORENG PLUS SPECIAL PCK 80g </div>
                 <table>
                     <tr>
                         <th colspan="4" class="th1">006041021 R12B/02/93/030499</th>
                         <th colspan="2"  class="th1">18010824 0099893010947</th>
                     </tr>
                     <tr class="tr1">
                         <td>Rp.</td>
                         <td class="font1">100.000</td>
                         <td class="font2">CTN</td>
                         <td class="font2">/40</td>
                         <td colspan="2" class="font4">( <span class="font3">2.600</span> <span class="font2">/PCS</span> )</td>
                     </tr>
                     <tr class="tr1">
                         <td>Rp.</td>
                         <td class="font1">80.000</td>
                         <td class="font2">PCS</td>
                         <td class="font2">/40</td>
                         <td colspan="2" class="font4">( <span class="font3">2.600</span> <span class="font2">/PCS</span> )</td>
                     </tr>
                     <tr class="tr1">
                         <td>Rp.</td>
                         <td class="font1">6.000</td>
                         <td class="font2">PCS</td>
                         <td class="font2">/40</td>
                         <td colspan="2" class="font4">( <span class="font3">2.600</span> <span class="font2">/PCS</span> )</td>
                     </tr>
                     </tr>
                         <td colspan="4">Harga Sudah Termasuk PPN</td>
                         <td colspan="2" style="text-align:center;">WIN BE RI</td>
                     </tr>
                 </table>
             </div>
             <div class="rotate-tag">
                 {!! DNS1D::getBarcodeHTML('121412', 'C128') !!}
             </div>
             <div class="rotate-2">
                 NR12B 0212
             </div>
         </div>
         <div class="labelCardContainer">
             <div class="labelCard">
                 <div class="name">INDOMIE MIE GORENG PLUS SPECIAL PCK 80g </div>
                 <table>
                     <tr>
                         <th colspan="4" class="th1">006041021 R12B/02/93/030499</th>
                         <th colspan="2"  class="th1">18010824 0099893010947</th>
                     </tr>
                     <tr class="tr1">
                         <td>Rp.</td>
                         <td class="font1">100.000</td>
                         <td class="font2">CTN</td>
                         <td class="font2">/40</td>
                         <td colspan="2" class="font4">( <span class="font3">2.600</span> <span class="font2">/PCS</span> )</td>
                     </tr>
                     <tr class="tr1">
                         <td>Rp.</td>
                         <td class="font1">80.000</td>
                         <td class="font2">PCS</td>
                         <td class="font2">/40</td>
                         <td colspan="2" class="font4">( <span class="font3">2.600</span> <span class="font2">/PCS</span> )</td>
                     </tr>
                     <tr class="tr1">
                         <td>Rp.</td>
                         <td class="font1">6.000</td>
                         <td class="font2">PCS</td>
                         <td class="font2">/40</td>
                         <td colspan="2" class="font4">( <span class="font3">2.600</span> <span class="font2">/PCS</span> )</td>
                     </tr>
                     </tr>
                         <td colspan="4">Harga Sudah Termasuk PPN</td>
                         <td colspan="2" style="text-align:center;">WIN BE RI</td>
                     </tr>
                 </table>
             </div>
             <div class="rotate-tag">
                 {!! DNS1D::getBarcodeHTML('121412', 'C128') !!}
             </div>
             <div class="rotate-2">
                 NR12B 0212
             </div>
         </div>
         <div class="labelCardContainer">
             <div class="labelCard">
                 <div class="name">INDOMIE MIE GORENG PLUS SPECIAL PCK 80g </div>
                 <table>
                     <tr>
                         <th colspan="4" class="th1">006041021 R12B/02/93/030499</th>
                         <th colspan="2"  class="th1">18010824 0099893010947</th>
                     </tr>
                     <tr class="tr1">
                         <td>Rp.</td>
                         <td class="font1">100.000</td>
                         <td class="font2">CTN</td>
                         <td class="font2">/40</td>
                         <td colspan="2" class="font4">( <span class="font3">2.600</span> <span class="font2">/PCS</span> )</td>
                     </tr>
                     <tr class="tr1">
                         <td>Rp.</td>
                         <td class="font1">80.000</td>
                         <td class="font2">PCS</td>
                         <td class="font2">/40</td>
                         <td colspan="2" class="font4">( <span class="font3">2.600</span> <span class="font2">/PCS</span> )</td>
                     </tr>
                     <tr class="tr1">
                         <td>Rp.</td>
                         <td class="font1">6.000</td>
                         <td class="font2">PCS</td>
                         <td class="font2">/40</td>
                         <td colspan="2" class="font4">( <span class="font3">2.600</span> <span class="font2">/PCS</span> )</td>
                     </tr>
                     </tr>
                         <td colspan="4">Harga Sudah Termasuk PPN</td>
                         <td colspan="2" style="text-align:center;">WIN BE RI</td>
                     </tr>
                 </table>
             </div>
             <div class="rotate-tag">
                 {!! DNS1D::getBarcodeHTML('121412', 'C128') !!}
             </div>
             <div class="rotate-2">
                 NR12B 0212
             </div>
         </div>
         <div class="labelCardContainer">
             <div class="labelCard">
                 <div class="name">INDOMIE MIE GORENG PLUS SPECIAL PCK 80g </div>
                 <table>
                     <tr>
                         <th colspan="4" class="th1">006041021 R12B/02/93/030499</th>
                         <th colspan="2"  class="th1">18010824 0099893010947</th>
                     </tr>
                     <tr class="tr1">
                         <td>Rp.</td>
                         <td class="font1">100.000</td>
                         <td class="font2">CTN</td>
                         <td class="font2">/40</td>
                         <td colspan="2" class="font4">( <span class="font3">2.600</span> <span class="font2">/PCS</span> )</td>
                     </tr>
                     <tr class="tr1">
                         <td>Rp.</td>
                         <td class="font1">80.000</td>
                         <td class="font2">PCS</td>
                         <td class="font2">/40</td>
                         <td colspan="2" class="font4">( <span class="font3">2.600</span> <span class="font2">/PCS</span> )</td>
                     </tr>
                     <tr class="tr1">
                         <td>Rp.</td>
                         <td class="font1">6.000</td>
                         <td class="font2">PCS</td>
                         <td class="font2">/40</td>
                         <td colspan="2" class="font4">( <span class="font3">2.600</span> <span class="font2">/PCS</span> )</td>
                     </tr>
                     </tr>
                         <td colspan="4">Harga Sudah Termasuk PPN</td>
                         <td colspan="2" style="text-align:center;">WIN BE RI</td>
                     </tr>
                 </table>
             </div>
             <div class="rotate-tag">
                 {!! DNS1D::getBarcodeHTML('121412', 'C128') !!}
             </div>
             <div class="rotate-2">
                 NR12B 0212
             </div>
         </div>
         <div class="labelCardContainer">
             <div class="labelCard">
                 <div class="name">INDOMIE MIE GORENG PLUS SPECIAL PCK 80g </div>
                 <table>
                     <tr>
                         <th colspan="4" class="th1">006041021 R12B/02/93/030499</th>
                         <th colspan="2"  class="th1">18010824 0099893010947</th>
                     </tr>
                     <tr class="tr1">
                         <td>Rp.</td>
                         <td class="font1">100.000</td>
                         <td class="font2">CTN</td>
                         <td class="font2">/40</td>
                         <td colspan="2" class="font4">( <span class="font3">2.600</span> <span class="font2">/PCS</span> )</td>
                     </tr>
                     <tr class="tr1">
                         <td>Rp.</td>
                         <td class="font1">80.000</td>
                         <td class="font2">PCS</td>
                         <td class="font2">/40</td>
                         <td colspan="2" class="font4">( <span class="font3">2.600</span> <span class="font2">/PCS</span> )</td>
                     </tr>
                     <tr class="tr1">
                         <td>Rp.</td>
                         <td class="font1">6.000</td>
                         <td class="font2">PCS</td>
                         <td class="font2">/40</td>
                         <td colspan="2" class="font4">( <span class="font3">2.600</span> <span class="font2">/PCS</span> )</td>
                     </tr>
                     </tr>
                         <td colspan="4">Harga Sudah Termasuk PPN</td>
                         <td colspan="2" style="text-align:center;">WIN BE RI</td>
                     </tr>
                 </table>
             </div>
             <div class="rotate-tag">
                 {!! DNS1D::getBarcodeHTML('121412', 'C128') !!}
             </div>
             <div class="rotate-2">
                 NR12B 0212
             </div>
         </div>
         <div class="labelCardContainer">
             <div class="labelCard">
                 <div class="name">INDOMIE MIE GORENG PLUS SPECIAL PCK 80g </div>
                 <table>
                     <tr>
                         <th colspan="4" class="th1">006041021 R12B/02/93/030499</th>
                         <th colspan="2"  class="th1">18010824 0099893010947</th>
                     </tr>
                     <tr class="tr1">
                         <td>Rp.</td>
                         <td class="font1">100.000</td>
                         <td class="font2">CTN</td>
                         <td class="font2">/40</td>
                         <td colspan="2" class="font4">( <span class="font3">2.600</span> <span class="font2">/PCS</span> )</td>
                     </tr>
                     <tr class="tr1">
                         <td>Rp.</td>
                         <td class="font1">80.000</td>
                         <td class="font2">PCS</td>
                         <td class="font2">/40</td>
                         <td colspan="2" class="font4">( <span class="font3">2.600</span> <span class="font2">/PCS</span> )</td>
                     </tr>
                     <tr class="tr1">
                         <td>Rp.</td>
                         <td class="font1">6.000</td>
                         <td class="font2">PCS</td>
                         <td class="font2">/40</td>
                         <td colspan="2" class="font4">( <span class="font3">2.600</span> <span class="font2">/PCS</span> )</td>
                     </tr>
                     </tr>
                         <td colspan="4">Harga Sudah Termasuk PPN</td>
                         <td colspan="2" style="text-align:center;">WIN BE RI</td>
                     </tr>
                 </table>
             </div>
             <div class="rotate-tag">
                 {!! DNS1D::getBarcodeHTML('121412', 'C128') !!}
             </div>
             <div class="rotate-2">
                 NR12B 0212
             </div>
         </div>
         <div class="labelCardContainer">
             <div class="labelCard">
                 <div class="name">INDOMIE MIE GORENG PLUS SPECIAL PCK 80g </div>
                 <table>
                     <tr>
                         <th colspan="4" class="th1">006041021 R12B/02/93/030499</th>
                         <th colspan="2"  class="th1">18010824 0099893010947</th>
                     </tr>
                     <tr class="tr1">
                         <td>Rp.</td>
                         <td class="font1">100.000</td>
                         <td class="font2">CTN</td>
                         <td class="font2">/40</td>
                         <td colspan="2" class="font4">( <span class="font3">2.600</span> <span class="font2">/PCS</span> )</td>
                     </tr>
                     <tr class="tr1">
                         <td>Rp.</td>
                         <td class="font1">80.000</td>
                         <td class="font2">PCS</td>
                         <td class="font2">/40</td>
                         <td colspan="2" class="font4">( <span class="font3">2.600</span> <span class="font2">/PCS</span> )</td>
                     </tr>
                     <tr class="tr1">
                         <td>Rp.</td>
                         <td class="font1">6.000</td>
                         <td class="font2">PCS</td>
                         <td class="font2">/40</td>
                         <td colspan="2" class="font4">( <span class="font3">2.600</span> <span class="font2">/PCS</span> )</td>
                     </tr>
                     </tr>
                         <td colspan="4">Harga Sudah Termasuk PPN</td>
                         <td colspan="2" style="text-align:center;">WIN BE RI</td>
                     </tr>
                 </table>
             </div>
             <div class="rotate-tag">
                 {!! DNS1D::getBarcodeHTML('121412', 'C128') !!}
             </div>
             <div class="rotate-2">
                 NR12B 0212
             </div>
         </div>
         <div class="labelCardContainer">
             <div class="labelCard">
                 <div class="name">INDOMIE MIE GORENG PLUS SPECIAL PCK 80g </div>
                 <table>
                     <tr>
                         <th colspan="4" class="th1">006041021 R12B/02/93/030499</th>
                         <th colspan="2"  class="th1">18010824 0099893010947</th>
                     </tr>
                     <tr class="tr1">
                         <td>Rp.</td>
                         <td class="font1">100.000</td>
                         <td class="font2">CTN</td>
                         <td class="font2">/40</td>
                         <td colspan="2" class="font4">( <span class="font3">2.600</span> <span class="font2">/PCS</span> )</td>
                     </tr>
                     <tr class="tr1">
                         <td>Rp.</td>
                         <td class="font1">80.000</td>
                         <td class="font2">PCS</td>
                         <td class="font2">/40</td>
                         <td colspan="2" class="font4">( <span class="font3">2.600</span> <span class="font2">/PCS</span> )</td>
                     </tr>
                     <tr class="tr1">
                         <td>Rp.</td>
                         <td class="font1">6.000</td>
                         <td class="font2">PCS</td>
                         <td class="font2">/40</td>
                         <td colspan="2" class="font4">( <span class="font3">2.600</span> <span class="font2">/PCS</span> )</td>
                     </tr>
                     </tr>
                         <td colspan="4">Harga Sudah Termasuk PPN</td>
                         <td colspan="2" style="text-align:center;">WIN BE RI</td>
                     </tr>
                 </table>
             </div>
             <div class="rotate-tag">
                 {!! DNS1D::getBarcodeHTML('121412', 'C128') !!}
             </div>
             <div class="rotate-2">
                 NR12B 0212
             </div>
         </div>
         <div class="labelCardContainer">
             <div class="labelCard">
                 <div class="name">INDOMIE MIE GORENG PLUS SPECIAL PCK 80g </div>
                 <table>
                     <tr>
                         <th colspan="4" class="th1">006041021 R12B/02/93/030499</th>
                         <th colspan="2"  class="th1">18010824 0099893010947</th>
                     </tr>
                     <tr class="tr1">
                         <td>Rp.</td>
                         <td class="font1">100.000</td>
                         <td class="font2">CTN</td>
                         <td class="font2">/40</td>
                         <td colspan="2" class="font4">( <span class="font3">2.600</span> <span class="font2">/PCS</span> )</td>
                     </tr>
                     <tr class="tr1">
                         <td>Rp.</td>
                         <td class="font1">80.000</td>
                         <td class="font2">PCS</td>
                         <td class="font2">/40</td>
                         <td colspan="2" class="font4">( <span class="font3">2.600</span> <span class="font2">/PCS</span> )</td>
                     </tr>
                     <tr class="tr1">
                         <td>Rp.</td>
                         <td class="font1">6.000</td>
                         <td class="font2">PCS</td>
                         <td class="font2">/40</td>
                         <td colspan="2" class="font4">( <span class="font3">2.600</span> <span class="font2">/PCS</span> )</td>
                     </tr>
                     </tr>
                         <td colspan="4">Harga Sudah Termasuk PPN</td>
                         <td colspan="2" style="text-align:center;">WIN BE RI</td>
                     </tr>
                 </table>
             </div>
             <div class="rotate-tag">
                 {!! DNS1D::getBarcodeHTML('121412', 'C128') !!}
             </div>
             <div class="rotate-2">
                 NR12B 0212
             </div>
         </div>
         <div class="labelCardContainer">
             <div class="labelCard">
                 <div class="name">INDOMIE MIE GORENG PLUS SPECIAL PCK 80g </div>
                 <table>
                     <tr>
                         <th colspan="4" class="th1">006041021 R12B/02/93/030499</th>
                         <th colspan="2"  class="th1">18010824 0099893010947</th>
                     </tr>
                     <tr class="tr1">
                         <td>Rp.</td>
                         <td class="font1">100.000</td>
                         <td class="font2">CTN</td>
                         <td class="font2">/40</td>
                         <td colspan="2" class="font4">( <span class="font3">2.600</span> <span class="font2">/PCS</span> )</td>
                     </tr>
                     <tr class="tr1">
                         <td>Rp.</td>
                         <td class="font1">80.000</td>
                         <td class="font2">PCS</td>
                         <td class="font2">/40</td>
                         <td colspan="2" class="font4">( <span class="font3">2.600</span> <span class="font2">/PCS</span> )</td>
                     </tr>
                     <tr class="tr1">
                         <td>Rp.</td>
                         <td class="font1">6.000</td>
                         <td class="font2">PCS</td>
                         <td class="font2">/40</td>
                         <td colspan="2" class="font4">( <span class="font3">2.600</span> <span class="font2">/PCS</span> )</td>
                     </tr>
                     </tr>
                         <td colspan="4">Harga Sudah Termasuk PPN</td>
                         <td colspan="2" style="text-align:center;">WIN BE RI</td>
                     </tr>
                 </table>
             </div>
             <div class="rotate-tag">
                 {!! DNS1D::getBarcodeHTML('121412', 'C128') !!}
             </div>
             <div class="rotate-2">
                 NR12B 0212
             </div>
         </div>
         <div class="labelCardContainer">
             <div class="labelCard">
                 <div class="name">INDOMIE MIE GORENG PLUS SPECIAL PCK 80g </div>
                 <table>
                     <tr>
                         <th colspan="4" class="th1">006041021 R12B/02/93/030499</th>
                         <th colspan="2"  class="th1">18010824 0099893010947</th>
                     </tr>
                     <tr class="tr1">
                         <td>Rp.</td>
                         <td class="font1">100.000</td>
                         <td class="font2">CTN</td>
                         <td class="font2">/40</td>
                         <td colspan="2" class="font4">( <span class="font3">2.600</span> <span class="font2">/PCS</span> )</td>
                     </tr>
                     <tr class="tr1">
                         <td>Rp.</td>
                         <td class="font1">80.000</td>
                         <td class="font2">PCS</td>
                         <td class="font2">/40</td>
                         <td colspan="2" class="font4">( <span class="font3">2.600</span> <span class="font2">/PCS</span> )</td>
                     </tr>
                     <tr class="tr1">
                         <td>Rp.</td>
                         <td class="font1">6.000</td>
                         <td class="font2">PCS</td>
                         <td class="font2">/40</td>
                         <td colspan="2" class="font4">( <span class="font3">2.600</span> <span class="font2">/PCS</span> )</td>
                     </tr>
                     </tr>
                         <td colspan="4">Harga Sudah Termasuk PPN</td>
                         <td colspan="2" style="text-align:center;">WIN BE RI</td>
                     </tr>
                 </table>
             </div>
             <div class="rotate-tag">
                 {!! DNS1D::getBarcodeHTML('121412', 'C128') !!}
             </div>
             <div class="rotate-2">
                 NR12B 0212
             </div>
         </div>
         <div class="labelCardContainer">
             <div class="labelCard">
                 <div class="name">INDOMIE MIE GORENG PLUS SPECIAL PCK 80g </div>
                 <table>
                     <tr>
                         <th colspan="4" class="th1">006041021 R12B/02/93/030499</th>
                         <th colspan="2"  class="th1">18010824 0099893010947</th>
                     </tr>
                     <tr class="tr1">
                         <td>Rp.</td>
                         <td class="font1">100.000</td>
                         <td class="font2">CTN</td>
                         <td class="font2">/40</td>
                         <td colspan="2" class="font4">( <span class="font3">2.600</span> <span class="font2">/PCS</span> )</td>
                     </tr>
                     <tr class="tr1">
                         <td>Rp.</td>
                         <td class="font1">80.000</td>
                         <td class="font2">PCS</td>
                         <td class="font2">/40</td>
                         <td colspan="2" class="font4">( <span class="font3">2.600</span> <span class="font2">/PCS</span> )</td>
                     </tr>
                     <tr class="tr1">
                         <td>Rp.</td>
                         <td class="font1">6.000</td>
                         <td class="font2">PCS</td>
                         <td class="font2">/40</td>
                         <td colspan="2" class="font4">( <span class="font3">2.600</span> <span class="font2">/PCS</span> )</td>
                     </tr>
                     </tr>
                         <td colspan="4">Harga Sudah Termasuk PPN</td>
                         <td colspan="2" style="text-align:center;">WIN BE RI</td>
                     </tr>
                 </table>
             </div>
             <div class="rotate-tag">
                 {!! DNS1D::getBarcodeHTML('121412', 'C128') !!}
             </div>
             <div class="rotate-2">
                 NR12B 0212
             </div>
         </div>
         <div class="labelCardContainer">
             <div class="labelCard">
                 <div class="name">INDOMIE MIE GORENG PLUS SPECIAL PCK 80g </div>
                 <table>
                     <tr>
                         <th colspan="4" class="th1">006041021 R12B/02/93/030499</th>
                         <th colspan="2"  class="th1">18010824 0099893010947</th>
                     </tr>
                     <tr class="tr1">
                         <td>Rp.</td>
                         <td class="font1">100.000</td>
                         <td class="font2">CTN</td>
                         <td class="font2">/40</td>
                         <td colspan="2" class="font4">( <span class="font3">2.600</span> <span class="font2">/PCS</span> )</td>
                     </tr>
                     <tr class="tr1">
                         <td>Rp.</td>
                         <td class="font1">80.000</td>
                         <td class="font2">PCS</td>
                         <td class="font2">/40</td>
                         <td colspan="2" class="font4">( <span class="font3">2.600</span> <span class="font2">/PCS</span> )</td>
                     </tr>
                     <tr class="tr1">
                         <td>Rp.</td>
                         <td class="font1">6.000</td>
                         <td class="font2">PCS</td>
                         <td class="font2">/40</td>
                         <td colspan="2" class="font4">( <span class="font3">2.600</span> <span class="font2">/PCS</span> )</td>
                     </tr>
                     </tr>
                         <td colspan="4">Harga Sudah Termasuk PPN</td>
                         <td colspan="2" style="text-align:center;">WIN BE RI</td>
                     </tr>
                 </table>
             </div>
             <div class="rotate-tag">
                 {!! DNS1D::getBarcodeHTML('121412', 'C128') !!}
             </div>
             <div class="rotate-2">
                 NR12B 0212
             </div>
         </div>
         <div class="labelCardContainer">
             <div class="labelCard">
                 <div class="name">INDOMIE MIE GORENG PLUS SPECIAL PCK 80g </div>
                 <table>
                     <tr>
                         <th colspan="4" class="th1">006041021 R12B/02/93/030499</th>
                         <th colspan="2"  class="th1">18010824 0099893010947</th>
                     </tr>
                     <tr class="tr1">
                         <td>Rp.</td>
                         <td class="font1">100.000</td>
                         <td class="font2">CTN</td>
                         <td class="font2">/40</td>
                         <td colspan="2" class="font4">( <span class="font3">2.600</span> <span class="font2">/PCS</span> )</td>
                     </tr>
                     <tr class="tr1">
                         <td>Rp.</td>
                         <td class="font1">80.000</td>
                         <td class="font2">PCS</td>
                         <td class="font2">/40</td>
                         <td colspan="2" class="font4">( <span class="font3">2.600</span> <span class="font2">/PCS</span> )</td>
                     </tr>
                     <tr class="tr1">
                         <td>Rp.</td>
                         <td class="font1">6.000</td>
                         <td class="font2">PCS</td>
                         <td class="font2">/40</td>
                         <td colspan="2" class="font4">( <span class="font3">2.600</span> <span class="font2">/PCS</span> )</td>
                     </tr>
                     </tr>
                         <td colspan="4">Harga Sudah Termasuk PPN</td>
                         <td colspan="2" style="text-align:center;">WIN BE RI</td>
                     </tr>
                 </table>
             </div>
             <div class="rotate-tag">
                 {!! DNS1D::getBarcodeHTML('121412', 'C128') !!}
             </div>
             <div class="rotate-2">
                 NR12B 0212
             </div>
         </div>

     </div>
@endsection
