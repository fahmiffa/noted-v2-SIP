<!DOCTYPE html>
<html>

<head>
    <title>{{env('APP_NAME')}} | {{env('APP_TAG')}}</title>
    <link rel="shortcut icon" href="{{asset('assets/logo.png')}}" type="image/x-icon">    
</head>
<style>
    body {
        font-size: 13px;
    }

    table {
        border-collapse: collapse;
        border-spacing: 0;
    }

    td {
        border: 1px solid black;
    }

    .img {
        object-fit: cover;
        width: 50px;
        height: 50px;
    }
</style>

<body>
    <table style="width: 100%; border:none">
        <tr>
            <td style="border:none"><img class="img" src="{{ gambar('kab.png') }}" /></td>
            <td width="100%" style="border:none; text-align:center">
                <p>
                    <span style="font-weight: bold; font-size:0.8rem;text-wrap:none">LAMPIRAN DOKUMEN PBG</span>
                    <br>No.&nbsp;&nbsp;{{(str_replace('SPm','LDP',str_replace('600.1.15','600.1.15/PBLT',$head->nomor)))}}
                </p>
            </td>
            <td style="border:none"><img class="img" src="{{ gambar('logo.png') }}" /></td>
        </tr>
    </table>
    
    @php  $header = (array) json_decode($head->header); @endphp
    <table style="width:100%; margin-top: 1rem" align="center">
        <tbody>
            <tr>
                <td width="40%" style="border:none">No. Registrasi </td>
                <td width="60%" style="border:none">: {{$header[0]}} </td>
                <td width="40%" style="border:none"></td>
                <td width="60%" style="border:none"></td>
            </tr>
            <tr>
                <td width="40%" style="border:none">Nama Pemohon </td>
                <td width="60%" style="border:none">: {{$header[2]}}</td>
                <td width="40%" style="border:none"></td>
                <td width="60%" style="border:none"></td>
            </tr>
            <tr>
                <td width="40%" style="border:none">Alamat Pemohon </td>
                <td width="60%" style="border:none">: {{$header[4]}}</td>
            </tr>
            <tr>
                <td width="40%" style="border:none">Nama Bangunan </td>
                <td width="60%" style="border:none">: {{$header[5]}}</td>
                <td width="40%" style="border:none"></td>
                <td width="60%" style="border:none"></td>
            </tr>
            <tr>
                <td width="40%" style="border:none;vertical:align:top">Alamat Bangunan </td>
                <td colspan="3" style="border:none;vertical-align:top">
                    : {{$header[7]}}, Kec. {{$head->region->name}}, Kab. {{$head->region->kecamatan->name}}                  
                </td>
            </tr>
            <tr>
                <td width="40%" style="border:none">Luas Tanah</td>
                <td width="60%" style="border:none">: {{$head->attach->luas}}</td>
                <td width="50%" style="border:none">Bukti Kepemilikan Tanah</td>
                <td width="50%" style="border:none">: {{$head->attach->bukti}}</td>
            </tr>
        </tbody>
    </table> 
    <table style="width: 100%; border:none;margin-top:1rem">
        <tr>
            <td colspan="2" style="padding: 0.5rem;font-weight:bold;text-align:center">Gambar Denah / Situasi</td>     
        </tr>
        <tr>
            <td colspan="2" style="padding: 0.5rem;font-weight:bold;text-align:center">
                @if($head->attach->pile_map)
                    <center>
                        <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('storage/'.$head->attach->pile_map))) }}"  style="width:120px;height:100px;object-fit:cover;object-position:center;margin:auto;display:block">
                    </center>       
                @endif
            </td>     
        </tr>
        <tr>
            <td style="padding: 0.5rem;font-weight:bold;text-align:center" width="50%">
                Lokasi Bangunan
                @if($head->attach->pile_loc)
                    <center>
                        <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('storage/'.$head->attach->pile_loc))) }}"  style="width:120px;height:100px;object-fit:cover;object-position:center;margin:auto;display:block">
                    </center>                
                @endif
            </td>
            <td style="padding: 0.5rem;font-weight:bold;text-align:center" width="50%">Kondisi Lahan / Bangunan
                @if($head->attach->pile_land)
                <center>
                    <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('storage/'.$head->attach->pile_land))) }}"  style="width:120px;height:100px;object-fit:cover;object-position:center;margin:auto;display:block">
                </center>                
                @endif
            </td>
        </tr>   
        <tr>
            <td style="padding: 1rem;font-weight:bold">Koordinat</td>
            <td style="padding: 1rem">{{$head->attach->koordinat}}</td>  
        </tr>
    </table>
    <p>Catatan :</p>
    <ol>
        <li>Lampiran ini merupakan bagian yang tidak terpisahkan dari Berita Acara Rapat Pleno (BARP) <br> No. {{$head->number}}														
        </li>
        <li>Pemilik bangunan tidak diperkenankan mengembangkan bangunan diluar ketentuan yang berlaku.														
        </li>
        <li>Terhadap bangunan yang telah berdiri (existing) agar dilakukan pemeriksaan kelaikan fungsi sebelum bangunan dimanfaatkan.														
        </li>
    </ol>

    <img src="data:image/png;base64, {{ $head->qr }}" width="20%" style="float: right">
</body>

</html>
