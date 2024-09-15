@extends('layout.pdf')
@section('main')
    <header >
        <table style="width: 100%; border:none">
            <tr>
                <td style="border:none"><img class="img" src="{{ gambar('kab.png') }}" /></td>
                <td width="100%" style="border:none; text-align:center">
                    <p>
                        <span style="font-weight: bold; font-size:rem;text-wrap:none">BERITA ACARA KONSULTASI (BAK)</span>
                        <br>No.&nbsp;&nbsp;{{(str_replace('SPm','BAK',str_replace('600.1.15','600.1.15/PBLT',$head->nomor)))}}
                    </p>
                </td>
                <td style="border:none"><img class="img" src="{{ gambar('logo.png') }}" /></td>
            </tr>
        </table>
    </header>
    @php  
        $header = (array) json_decode($head->header); 
        $item = (array) json_decode($head->bak->item);
        $umum = $item['informasi_umum'];
        $bangunan = $item['informasi_bangunan_gedung'];
    @endphp
    <table style="width:100%" align="center">
        <tbody>
            <tr>
                <td width="40%" style="border:none">No. Registrasi </td>
                <td width="60%" style="border:none">: {{$header[0]}} </td>
                <td width="40%" style="border:none">Pengajuan </td>
                <td width="60%" style="border:none">: {{strtoupper($header[1])}}</td>
            </tr>
            <tr>
                <td width="40%" style="border:none">Nama Pemohon </td>
                <td width="60%" style="border:none">: {{$header[2]}}</td>
                <td width="40%" style="border:none">No. Telp. / HP </td>
                <td width="60%" style="border:none">: {{$header[3]}}</td>
            </tr>
            <tr>
                <td width="40%" style="border:none">Alamat Pemohon </td>
                <td colspan="3" style="border:none">: {{$header[4]}}</td>
            </tr>
            <tr>
                <td width="40%" style="border:none">Nama Bangunan </td>
                <td width="60%" style="border:none">: {{$header[5]}}</td>
                <td width="40%" style="border:none">Fungsi </td>
                <td width="60%" style="border:none">: {{$header[6]}}</td>
            </tr>
            <tr>
                <td width="40%" style="border:none;vertical:align:top">Alamat Bangunan </td>
                <td colspan="3" style="border:none;vertical-align:top">
                    : {{$header[7]}}, Kec. {{$head->region->name}}, Kab. {{$head->region->kecamatan->name}}                  
                </td>
            </tr>      
        </tbody>
    </table>    
    <table style="width:100%;" align="center">
        <tbody>         
            @php
                $area = json_decode($head->bak->header);              
            @endphp
            <tr>
                <td width="40%" style="border:none">Batas Lahan / Lokasi </td>
                <td style="border:none" width="30%">: Utara </td>                
                <td style="border:none" width="30%">: {{$area->north}}</td>
                <td style="border:none" width="40%">Timur </td>                
                <td style="border:none" width="60%">: {{$area->east}}</td>
            </tr>
            <tr>
                <td width="40%" style="border:none"></td>
                <td style="border:none">&nbsp;&nbsp;&nbsp;Selatan </td>                
                <td style="border:none">: {{$area->south}}</td>
                <td style="border:none">Barat </td>                
                <td style="border:none">: {{$area->west}}</td>
            </tr>
        </tbody>
    </table>    
    <table style="width:100%;" align="center">
        <tr>
            <td width="40%" style="border:none">Kondisi </td>       
            <td width="60%" style="border:none">: {{ucwords(str_replace('_',' ',$area->kondisi))}} </td> 
            <td width="40%" style="border:none">Tahun Pembangunan</td>       
            <td width="60%" style="border:none">: {{$head->bak->plan}} </td>       
        </tr>
        <tr>
            <td width="40%" style="border:none">Tingkat Permanen </td>       
            <td width="60%" style="border:none">: {{ucwords(str_replace('_',' ',$area->permanensi))}} </td>     
        </tr>
    </table>
    <table style="width:100%;margin-top:1rem;margin-bottom:1rem">
        <tr>
            <td colspan="3" style="border: none">Informasi Umum :</td>
            <td colspan="3" style="border: none">Informasi Bangunan Gedung :</td>
        </tr>
        <tr>
            <td align="center">Uraian</td>
            <td align="center">Dimensi</td>
            <td style="border: none"></td>
            <td align="center">Uraian</td>
            <td align="center">Dimensi</td>
            <td align="center">Catatan</td>
        </tr>
        @for ($i = 0; $i < count($bangunan); $i++)
        <tr>
            @isset($umum[$i])
            <td>&nbsp;&nbsp;{{$umum[$i]->uraian}}</td>
            <td>&nbsp;&nbsp;{{$umum[$i]->value}}</td>
            @else
            <td></td>
            <td></td>
            @endif    
            <td style="border: none"></td>    
            <td>&nbsp;&nbsp;{{ucwords(str_replace('_',' ',$bangunan[$i]->uraian))}}</td>
            <td>&nbsp;&nbsp;{{$bangunan[$i]->dimensi}}</td>
            <td>&nbsp;&nbsp;{{$bangunan[$i]->note}}</td>
        </tr>            
        @endfor

        @if($head->bak->ibg)     
            @foreach(json_decode($head->bak->ibg) as $fa)
                <tr>
                    <td></td>
                    <td></td>
                    <td style="border: none"></td>  
                    <td>&nbsp;&nbsp;{{$fa[0]}}</td>
                    <td>&nbsp;&nbsp;{{$fa[1]}}</td>
                    <td>&nbsp;&nbsp;{{$fa[2]}}</td>
                </tr>
            @endforeach
        @endif
    </table> 
    <table style="width:100%;">
        <tr>
            <td style="border: none">Informasi Dimensi Bangunan dan Prasarana :</td>
            <td style="border: none">Informasi Dimensi Prasarana :</td>
        </tr>
        <tr>
            <td align="center">Bangunan Gedung</td>
            <td align="center">Prasarana</td>                
        </tr>
        <tr>
            <td>&nbsp;&nbsp;{!! $item['idb'][1] !!}</td>
            <td>&nbsp;&nbsp;{!! $item['idp'][1] !!}</td>
        </tr>
    </table> 
    <br>
    Saran :<br>    
    @if($head->bak->note)
    {!! $head->bak->note !!}
    @else
    <br>
    @endif
    <table style="width:100%;">
        <tr>
            <td style="border: none" colspan="2">Dengan ditandatangani Berita Acara ini, maka Pemohon telah memahami bahwa :</td>
        </tr>
        <tr>
            <td width="3%" class="code" style="border: none;vertical-align:top">1</td>
            <td style="border: none;vertical-align:top">
                Luas bangunan yang disetujui adalah luasan bangunan yang sesuai / tidak bertentangan dengan ketentuan tata bangunan yang berlaku dan/atau direkomendasikan (GSB, KDB, KDH, KLB, dan sebagainya).														
            </td>
        </tr>
        <tr>
            <td class="code" style="border: none;vertical-align:top">2</td>
            <td style="border: none;vertical-align:top">
                Pemohon bersedia mematuhi dan memenuhi persyaratan administrasi dan teknis sesuai persyaratan yang berlaku
            </td>
        </tr>
        <tr>
            <td class="code" style="border: none;vertical-align:top">3</td>
            <td style="border: none;vertical-align:top">
                Terhadap bangunan yang tidak disetujui  / tidak sesuai dengan ketentuan yang berlaku, maka Pemohon / Pemilik Bangunan bersedia melakukan penyesuaian bangunan sesuai peraturan perundang-undangan yang berlaku,														
            </td>
        </tr>
        <tr>
            <td class="code" style="border: none;vertical-align:top">4</td>
            <td style="border: none;vertical-align:top">
                Dalam hal Pemohon / Pemilik Bangunan tidak melakukan penyesuaian bangunan sesuai ketentuan, maka Pemohon / Pemilik Bangunan bersedia menerima sanksi sesuai peraturan perundang-undangan yang berlaku.														
            </td>
        </tr>
        <tr>
            <td class="code" style="border: none;vertical-align:top">5</td>
            <td style="border: none;vertical-align:top">
                Seluruh kebenaran dan keabsahan dokumen baik administrasi dan teknis merupakan tanggungjawab Pemohon / Pemilik Bangunan dan Penyedia Jasa / Konsultan Perencana.														
            </td>
        </tr>
        <tr>
            <td class="code" style="border: none;vertical-align:top">6</td>
            <td style="border: none;vertical-align:top">
                Pemohon / Pemilik Bangunan bersedia melaksanakan pembangunan dan perawatan bangunan sesuai standar teknis.														
            </td>
        </tr>
        <tr>
            <td class="code" style="border: none;vertical-align:top">7</td>
            <td style="border: none;vertical-align:top">
                Pemohon bersedia melakukan pembayaran retribusi sesuai perhitungan nilai retribusi yang dikenakan.														
            </td>
        </tr>
        <tr>
            <td class="code" style="border: none;vertical-align:top">8</td>
            <td style="border: none;vertical-align:top">
                Apabila dikemudian hari terdapat ketidaksesuaian terhadap dokumen administrasi dan/atau dokumen teknis yang diajukan maka PBG dan/atau SLF akan dievaluasi kembali dan Pemohon bersedia menerima konsekuensi dan/atau sanksi sesuai peraturan perundang-undangan yang berlaku serta retribusi yang telah dibayarkan tidak dapat diminta kembali														
            </td>
        </tr>
    </table>    
    <p>Demikian hasil konsultasi TPT/TPA yang dihadiri oleh:</p>
    @if($head->sign)
        <table style="width:35%;">
            @foreach($head->sign->where('type','member') as $val)
                <tr>      
                    <td width="2%" style="border: none">
                    {{$loop->iteration}}.
                    </td>
                    <td width="40%" style="border: none">
                        {{$val->users->name}}           
                    </td>
                    <td style="border: none">
                        @if($val->bak)
                            <img src="{{$val->bak}}"  width="80%"  style="margin: auto">
                        @endif        
                    </td>
                </tr>    
            @endforeach
        </table> 
    @endif
    <table style="width:100%;">
        <tr>      
            <td style="border: none" align="center">
                <p>Mengetahui,<br>
                    Ketua TPT/TPA Kab. Tegal
                </p>
                    @if($head->bak->sign)
                    <img src="{{$head->bak->sign}}"  width="50%"  style="margin: auto">
                    <br>
                    @else
                    <br><br><br><br>
                    @endif
                    {{$head->bak->primary == 'TPT' ? $head->bak->kabid : $head->kons->not->name}}
            </td>
            <td style="border: none" align="center">Setuju hasil pemeriksaan<br>Pemohon PBG<br>
                @if($head->bak->signs)
                <img src="{{$head->bak->signs}}"  width="50%"  style="margin: auto">
                <br>
                @else
                <br><br><br><br>
                @endif	
                {{$header[2]}}
            </td>
        </tr>    
    </table>        
@endsection