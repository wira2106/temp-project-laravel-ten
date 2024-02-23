<!DOCTYPE html>
<html>
<head>
    <title>Data Export Kirim Data OTP</title>
</head>
<body>
    @php
    
    $tmpIGR = [];
    @endphp
    <h4> To : EDP Issuing "{{ucfirst($to[1])}}" </h4>
    <p> Dh, </p>
    <p style='margin-top: -15px;'> Mohon dapat diproses PB Alokasi Seasonal OMI untuk </p>
    <p style='margin-top: -10px;margin-left: 30px'> Toko OMI : <b>{{$toko}}</b>, </p>
    <p style='margin-top: -20px;margin-left: 30px'> No PB : <b>{{$noPB}}</b>, </p>
    <p style='margin-top: -20px;margin-left: 30px'> Tgl PB : <b>{{date('Y-m-d')}}</b>, </p>
    <p style='margin-top: -20px;margin-left: 30px'> Jml Item : <b>{{$jmlitem}}</b> </p>
    <p style='margin-top: -5px;'> Demikian informasi dari kami.</p>
    <p style='margin-top: -20px;'> Terimakasih. </p>
    <h4 style='margin-top: 35px;'> EDP OMI </h4>
</body>
</html>
