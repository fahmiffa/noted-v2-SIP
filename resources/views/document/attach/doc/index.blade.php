@extends('layout.pdf')

@section('main')
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
                    @php
                      $var = json_decode($head->attach->pile_map);
                    @endphp
                    @foreach($var as $key)
                        <center>
                            <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('storage/'.$key))) }}"  style="width:95%;object-fit:cover;object-position:center;margin:auto;display:block;padding:0.1rem">
                        </center>       
                    @endforeach
                @endif
            </td>     
        </tr>
        <tr>
            <td style="padding: 0.5rem;font-weight:bold;text-align:center" width="50%">
                Lokasi Bangunan         
            </td>
            <td style="padding: 0.5rem;font-weight:bold;text-align:center" width="50%">
                Kondisi Lahan / Bangunan        
            </td>    
        </tr>   
        <tr>
            <td style="padding: 0.5rem;font-weight:bold;text-align:center" width="50%">
                @if($head->attach->pile_land)
                <center>
                    <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('storage/'.$head->attach->pile_loc))) }}"  style="width:100%;object-fit:cover;object-position:center;margin:auto;display:block">
                </center>                
                @endif
            </td>
            <td style="padding: 0.5rem;font-weight:bold;text-align:center" width="50%">
                @if($head->attach->pile_land)
                <center>
                    <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('storage/'.$head->attach->pile_land))) }}"  style="width:100%;object-fit:cover;object-position:center;margin:auto;display:block">
                </center>                
                @endif
            </td>
        </tr>   
        <tr>
            <td colspan="2" style="padding: 0.5rem;font-weight:bold">Koordinat : {{$head->attach->koordinat}}</td>
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
@endsection