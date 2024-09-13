<!DOCTYPE html>
<html>
<head>
    <title>Dokumen Permohonan</title>
    <link rel="shortcut icon" href="{{asset('assets/logo.png')}}" type="image/x-icon">
</head>
<style>
    body {
        font-size: 12px;
        font-family: DejaVu Sans;
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

    .page-break {
        page-break-after: always;
    }

    ol {
        margin-top: 0rem;
        margin-left: 0rem;
    }
</style>
<body>
    <!-- bak -->
    <header >
        <table style="width: 100%; border:none">
            <tr>
                <td style="border:none"><img class="img" src="{{ gambar('kab.png') }}" /></td>
                <td width="100%" style="border:none; text-align:center">
                    <p>
                        <span style="font-weight: bold; font-size:0.8rem;text-wrap:none">BERITA ACARA KONSULTASI (BAK)</span>
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
                <td width="60%" style="border:none">: {{$header[1]}}</td>
            </tr>
            <tr>
                <td width="40%" style="border:none">Nama Pemohon </td>
                <td width="60%" style="border:none">: {{$header[2]}}</td>
                <td width="40%" style="border:none">No. Telp. / HP </td>
                <td width="60%" style="border:none">: {{$header[3]}}</td>
            </tr>
            <tr>
                <td width="40%" style="border:none">Alamat Pemohon </td>
                <td width="60%" style="border:none">: {{$header[4]}}</td>
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
            <td width="60%" style="border:none">: {{ucwords($area->kondisi)}} </td>
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
            <td>&nbsp;&nbsp;{{$item['idb'][1]}}</td>
            <td>&nbsp;&nbsp;{{$item['idp'][1]}}</td>
        </tr>
    </table>
    <p>Saran :<br>
        {{$head->note}}
    </p>
    <table style="width:100%;">
        <tr>
            <td style="border: none" colspan="2">Dengan ditandatanganinya Berita Acara ini, maka Pemohon bersedia untuk :</td>
        </tr>
        <tr>
            <td width="3%" style="border: none;vertical-align:top">&#x2611;</td>
            <td style="border: none;vertical-align:top">Bertanggungjawab terhadap seluruh dokumen dan sebab akibat adanya bangunan yang diajukan</td>
        </tr>
        <tr>
            <td style="border: none;vertical-align:top">&#x2611;</td>
            <td style="border: none;vertical-align:top">Pemohon bersedia mematuhi dan memenuhi persyaratan administrasi dan teknis sesuai persyaratan yang berlaku</td>
        </tr>
        <tr>
            <td style="border: none;vertical-align:top">&#x2611;</td>
            <td style="border: none;vertical-align:top">Pemohon bersedia melakukan pembayaran retribusi sesuai perhitungan nilai retribusi yang dikenakan</td>
        </tr>
    </table>
    <p>Demikian hasil konsultasi TPT/TPA yang dihadiri oleh:</p>
    <ol>
        @foreach($head->kons->kons as $val)
        <li>{{$val}}</li>
        @endforeach
    </ol>
    <table style="width:100%;">
        <tr>
            <td style="border: none" align="center">
                <p>Mengetahui,<br>
                    Ketua TPT/TPA Kab. Tegal
                </p>
                    @if($head->bak->sign)
                    <img src="{{$head->bak->sign}}"  width="20%"  style="margin: auto">
                    <br>
                    @else
                    <br><br><br><br>
                    @endif
                    {{$head->kons->not->name}}
            </td>
            <td style="border: none" align="center">Setuju hasil pemeriksaan<br>Pemohon PBG<br>
                @if($head->bak->signs)
                <img src="{{$head->bak->signs}}"  width="20%"  style="margin: auto">
                <br>
                @else
                <br><br><br><br>
                @endif
                {{$header[2]}}
            </td>
        </tr>
    </table>

    <!-- surat -->
    <div class="page-break"></div>
    <table style="width: 100%; border:none">
            <tr>
                <td width="10%" style="border:none;vertical-align:middle"><img
                        style="margin-left: 2rem;display:block" src="{{ gambar('surat.png') }}" /></td>
                <td style="border:none; text-align:center">
                    <p>
                        <span style="font-size:18px">PEMERINTAH KABUPATEN TEGAL</span><br>
                        <span style="font-weight: bold; font-size:18px">
                            DINAS PEKERJAAN UMUM DAN PENATAAN RUANG
                        </span><br>
                        Alamat : Jalan Cut Nyak Dien No. 13 Slawi Kode Pos 52416
                    </p>
                </td>
            </tr>
    </table>
    <div style="border-bottom: 3px solid black;width:100%;margin-bottom:0.1rem"></div>
    <div style="border-bottom: 1px solid black;width:100%"></div>
    <div style="margin: auto; display:block; width:600px; max-width:100%">
        <table style="width:100%; margin-top: 0.5rem">
            <tr>
                <td width="10%" style="border:none">Nomor</td>
                <td width="1%" style="border:none;">:</td>
                <td style="border:none">{{ $head->nomor }}</td>
                <td style="border:none;text-align:right">Slawi, {{ dateID($head->surat->tanggal) }}</td>
            </tr>
            <tr>
                <td width="10%" style="border:none;vertical-align:top">Perihal</td>
                <td width="1%" style="border:none;vertical-align:top">:</td>
                <td style="border:none;">Surat Pemberitahuan / Undangan <br>Konsultasi PBG dan/atau SLF</td>
            </tr>
        </table>

        @php
        $time = explode('#', $head->surat->waktu);
        $place = explode('#', $head->surat->tempat);
        $header = json_decode($head->header);
        @endphp

        <p style="margin-left:24rem">
            Kepada Yth.<br>
            Bapak/Ibu<br>
            {{ $header[2] }}<br>
            di -<br>
            <span style="margin-left:2.5rem">Tempat</span>
        </p>

        <p style="text-align: justify"><span style="margin-right: 1rem">&nbsp;</span>
            Sehubungan dengan Permohonan Persetujuan Bangunan Gedung (PBG) dan/atau Sertifikat Laik (SLF) yang diunggah
            melalui Sistem Informasi Manajemen Bangunan Gedung (SIMBG) :
        </p>

        <table style="width:95%; margin:auto" align="center">
            <tr>
                <td width="30%" style="border:none">Nomr Registrasi</td>
                <td width="1%" style="border:none">: </td>
                <td style="border:none">{{ $head->reg }}</td>
            </tr>
            <tr>
                <td width="30%" style="border:none">Nama Pemohon/Pemilik</td>
                <td width="1%" style="border:none">: </td>
                <td style="border:none">{{ $header[2] }}</td>
            </tr>
            <tr>
                <td width="30%" style="border:none">Alamat Pemohon/Pemilik</td>
                <td width="1%" style="border:none">: </td>
                <td style="border:none">{{ $header[4] }}</td>
            </tr>
            <tr>
                <td width="30%" style="border:none">Nama Bangunan</td>
                <td width="1%" style="border:none">: </td>
                <td style="border:none">{{ $header[5] }}</td>
            </tr>
            <tr>
                <td width="30%" style="border:none;vertical-align:top">Alamat Bangunan</td>
                <td width="1%" style="border:none;vertical-align:top">: </td>
                <td style="border:none;vertical-align:top">{{ $header[7] }} <br>Kec.
                    {{ $head->region->name }} Kab. {{ $head->region->kecamatan->name }} </td>
            </tr>
        </table>

        <p style="text-align: justify">
            Dapat kami informasikan bahwa permohonan PBG dan/atau SLF tersebut dilanjutkan ketahap Konsultasi yang akan
            dilaksanakan pada :
        </p>

        <table style="width:95%; margin:auto" align="center">
            <tr>
                <td width="30%" style="border:none">Hari, Tanggal</td>
                <td width="1%" style="border:none">: </td>
                <td style="border:none">{{ hari($time[1]) }}</td>
            </tr>
            <tr>
                <td width="30%" style="border:none">Pukul</td>
                <td width="1%" style="border:none">: </td>
                <td style="border:none">{{ $time[0] }} WIB s.d. Selesai</td>
            </tr>
            <tr>
                <td width="30%" style="border:none">Jenis Konsultasi</td>
                <td width="1%" style="border:none">: </td>
                <td style="border:none">{{ ucwords(str_replace('_', ' ', $head->surat->jenis)) }}</td>
            </tr>
            <tr>
                <td width="30%" style="border:none">Tempat</td>
                <td width="1%" style="border:none">: </td>
                <td style="border:none"> {{ ucwords(str_replace('_', ' ', $place[0])) }}</td>
            </tr>
            <tr>
                <td width="30%" style="border:none;vertical-align:top">Keterangan</td>
                <td width="1%" style="border:none;vertical-align:top">: </td>
                <td style="border:none;vertical-align:top">
                    {!! $head->surat->keterangan !!}
                </td>
            </tr>
        </table>

        <p style="text-align: justify">
            Demikian surat pemberitahuan / undangan ini dibuat untuk dipergunakan sebagaimana mestinya. Terima kasih.
        </p>


        <table style="width:100%; margin:auto" align="center">
            <tr>
                <td width="35%" style="border:none">&nbsp;</td>
                <td style="border:none;">
                    <p style="text-align: center">
                        a.n. Kepala DPUPR Kabupaten Tegal<br>
                        Kepala Bidang Penataan Bangunan, Lingkungan<br>
                        dan Tata Ruang<br>
                        <img src="data:image/png;base64, {{ $qrCode }}" width="25%">
                        <br>
                        <b><u>WIDODO SETIA NUGRAHA, ST, MA. MURP.</u></b><br>
                        NIP. 198410292009031003z
                    </p>
                </td>
            </tr>
        </table>
    </div>

    <!-- barp -->
    <div class="page-break"></div>
    <table style="width: 100%; border:none">
        <tr>
            <td style="border:none"><img class="img" src="{{ gambar('kab.png') }}" /></td>
            <td width="100%" style="border:none; text-align:center">
                <p>
                    <span style="font-weight: bold; font-size:0.8rem;text-wrap:none">BERITA ACARA RAPAT PLENO (BARP)</span>
                    <br>No.&nbsp;&nbsp;{{(str_replace('SPm','BARP',str_replace('600.1.15','600.1.15/PBLT',$head->nomor)))}}
                </p>
            </td>
            <td style="border:none"><img class="img" src="{{ gambar('logo.png') }}" /></td>
        </tr>
    </table>
    @php
        $header = (array) json_decode($head->header);
        $mheader = json_decode($head->barp->header);
        $items = json_decode($head->barp->item);
        $item = (array) json_decode($head->bak->item);
        $umum = $item['informasi_umum'];
        $bangunan = $item['informasi_bangunan_gedung'];
    @endphp
    <p>Sehubungan telah dilakukannya Konsultasi dengan TPT/TPA DPUPR Kabupaten Tegal pada :</p>
    <table style="width:98%" align="center">
            <tr>
                <td width="40%" style="border:none">Hari / Tanggal</td>
                <td width="60%" style="border:none">: {{dateID($head->barp->tanggal)}} </td>
                <td width="40%" style="border:none">Permohonan </td>
                <td width="60%" style="border:none">: {{strtoupper($header[1])}}</td>
            </tr>
            <tr>
                <td width="40%" style="border:none">No. Registrasi PBG</td>
                <td width="60%" style="border:none">: {{$header[0]}}</td>
                <td width="40%" style="border:none"></td>
                <td width="60%" style="border:none"></td>
            </tr>
    </table>
    <p>Atas pengajuan Persetujuan Bangunan Gedung :</p>
    <table style="width:98%;" align="center">
        <tbody>
            <tr>
                <td width="40%" style="border:none">Nama Pemohon </td>
                <td width="60%" style="border:none">: {{$header[2]}}</td>
                <td width="40%" style="border:none">No. Telp. / HP </td>
                <td width="60%" style="border:none">: {{$header[3]}}</td>
            </tr>
            <tr>
                <td width="40%" style="border:none">Alamat Pemohon </td>
                <td width="60%" style="border:none">: {{$header[4]}}</td>
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
            <tr>
                <td width="40%" style="border:none">Status Kepemilikan</td>
                <td width="60%" style="border:none">: {{ucwords($mheader->status)}}</td>
                <td width="40%" style="border:none">NIB </td>
                <td width="60%" style="border:none">: {{$mheader->nib}}</td>
            </tr>
            <tr>
                <td width="40%" style="border:none">Jenis Permohonan</td>
                <td width="60%" style="border:none">: {{ucwords($mheader->jenis)}}</td>
                <td width="40%" style="border:none"></td>
                <td width="60%" style="border:none"></td>
            </tr>
            <tr>
                <td width="40%" style="border:none">Fungsi Bangunan</td>
                <td width="60%" style="border:none">: {{ucwords($mheader->jenis)}}</td>
                <td width="40%" style="border:none"></td>
                <td width="60%" style="border:none"></td>
            </tr>


        </tbody>
    </table>
    <p>Sebagaimana terlampir pada Lembar Berita Acara Konsultasi
        No.
        {{ str_replace('SPm', 'BAK', str_replace('600.1.15', '600.1.15/PBLT', $head->nomor)) }}
        yang
        merupakan bagian tidak terpisahkan dari Berita Acara Rapat Pleno ini,
        TPT/TPA memberikan masukkan:
        <br>
        {{$items->item[0]}}
    </p>
    <p>Dan dengan pertimbangan bahwa :<br>{{$items->item[1]}}</p>
    Memutuskan untuk :
    <table style="width:100%;">
        <tr>
            <td width="3%" style="border: none;vertical-align:top">&#x2611;</td>
            <td style="border: none;vertical-align:top">Merekomendasikan penerbitan Surat Pernyataan Pemenuhan Standar Teknis PBG dan/atau SLF dengan :
            </td>
        </tr>
    </table>
    <table style="width:98%;">
        <tr align="center">
            <td>Uraian</td>
            <td>Pengajuan</td>
            <td>Disetujui</td>
            <td>Keterangan</td>
        </tr>
        <tr>
            <td style="padding: 0.3rem">Luas Total Bangunan termasuk <br> Luas Total Basement (LLt)
            </td>
            @foreach($items->luas as $key => $val)
            <td style="padding: 0.3rem">{{$val}}</td>
            @endforeach
        </tr>
        <tr>
            <td style="padding: 0.3rem">Prasarana (jika ada)
            </td>
            @foreach($items->pra as $key => $val)
            <td style="padding: 0.3rem">{{$val}}</td>
            @endforeach
        </tr>
    </table>
    <table style="width:100%;">
        <tr>
            <td width="3%" style="border: none;vertical-align:top">&#x2611;</td>
            <td style="border: none;vertical-align:top">Merekomendasikan pemohon untuk memperbaiki
                dokumen / informasi yang diunggah melalui SIMBG</td>
        </tr>
        <tr>
            <td style="border: none;vertical-align:top">&#x2611;</td>
            <td style="border: none;vertical-align:top">
                Merekomendasikan pemohon untuk melakukan
                pendaftaran ulang PBG dan/atau SLF melalui SIMBG</td>
        </tr>
        <tr>
            <td style="border: none;vertical-align:top">&#x2611;</td>
            <td style="border: none;vertical-align:top">
                Proses PBG dan/atau SLF tidak dapat dilanjutkan
                / ditolak</td>
        </tr>
    </table>
    <p>Demikian hasil konsultasi TPT/TPA yang dihadiri oleh:</p>
    <ol>
        @foreach($head->kons->kons as $val)
        <li>{{$val}}</li>
        @endforeach
    </ol>
    <table style="width:100%;">
        <tr>
            <td width="60%" style="border: none" align="center">
            </td>
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
                    {{$head->kons->not->name}}
            </td>
        </tr>
    </table>
    <!-- lampiran -->
    <div class="page-break"></div>
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
            <td align="center" colspan="2" style="padding: 0.5rem">GAMBAR DENAH / SITUASI
                <br>
                <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('storage/'.$head->attach->gambar))) }}"  width="50%">
            </td>
        </tr>
        <tr>
            <td align="center">LOKASI BANGUNAN</td>
            <td align="center">KONDISI LAHAN / BANGUNAN</td>
        </tr>
        <tr>
            <td align="center">{{$head->attach->lokasi}}</td>
            <td align="center">{{$head->attach->lahan}}</td>
        </tr>
        <tr>
            <td align="center">Koordinat</td>
            <td align="center">{{$head->attach->koordinat}}</td>
        </tr>
    </table>
    <p>Catatan :</p>
    <ol>
        <li>Lampiran ini merupakan bagian yang tidak terpisahkan dari Berita Acara Rapat Pleno (BARP) No. {{$head->number}}
        </li>
        <li>Pemilik bangunan tidak diperkenankan mengembangkan bangunan diluar ketentuan yang berlaku.
        </li>
        <li>Terhadap bangunan yang telah berdiri (existing) agar dilakukan pemeriksaan kelaikan fungsi sebelum bangunan dimanfaatkan.
        </li>
    </ol>
    <img src="data:image/png;base64, {{ $qrCode }}" width="20%" style="float: right">

    <!-- tax -->
    <div class="page-break"></div>
    <table style="width: 100%; border:none">
        <tr>
            <td style="border:none"><img class="img" src="{{ gambar('kab.png') }}" /></td>
            <td width="100%" style="border:none; text-align:center">
                <p>
                    <span style="font-weight: bold; font-size:0.8rem;text-wrap:none">PERHITUNGAN RETRIBUSI PERSETUJUAN
                        BANGUNAN GEDUNG</span>
                </p>
            </td>
            <td style="border:none"><img class="img" src="{{ gambar('logo.png') }}" /></td>
        </tr>
    </table>

    @php
        $header = (array) json_decode($head->header);
    @endphp
    <h4>A. INFORMASI UMUM</h4>
    <table style="width:95%;" align="center">
        <tr>
            <td width="40%" style="border:none">No. Registrasi PBG </td>
            <td width="60%" style="border:none">: {{ $header[0] }} </td>
            <td width="40%" style="border:none">Tanggal</td>
            <td width="60%" style="border:none">: {{ dateID($head->tax->tanggal) }}</td>
        </tr>
        <tr>
            <td width="40%" style="border:none">Nama Pemohon </td>
            <td width="60%" style="border:none">: {{ $header[2] }}</td>
            <td width="40%" style="border:none"></td>
            <td width="60%" style="border:none"></td>
        </tr>
        <tr>
            <td width="40%" style="border:none">Alamat Pemohon </td>
            <td width="60%" style="border:none">: {{ $header[4] }}</td>
        </tr>
        <tr>
            <td width="40%" style="border:none">Nama Bangunan </td>
            <td width="60%" style="border:none">: {{ $header[5] }}</td>
            <td width="40%" style="border:none"></td>
            <td width="60%" style="border:none"></td>
        </tr>
        <tr>
            <td width="40%" style="border:none;vertical:align:top">Alamat Bangunan </td>
            <td colspan="3" style="border:none;vertical-align:top">
                : {{ $header[7] }}, Kec. {{ $head->region->name }}, Kab. {{ $head->region->kecamatan->name }}
            </td>
        </tr>
    </table>

    @php
        $par = json_decode($head->tax->parameter);
    @endphp
    <h4>B. PARAMETER</h4>
    <table style="width: 98%">
        <tr align="center" style="background-color:lightgrey">
            <td>No.</td>
            <td>Uraian</td>
            <td>Indexs</td>
        </tr>
        <tr>
            <td align="center">1</td>
            <td style="padding:0.2rem">Fungsi Bangunan <i>(If)</i></td>
            <td style="padding:0.2rem">{{ $par->if[0] }}</td>
        </tr>
        <tr>
            <td align="center">2</td>
            <td style="padding:0.2rem">Kompleksitas <i>(Ik)</i></td>
            <td style="padding:0.2rem">{{ $par->ik[0] }}</td>
        </tr>
        <tr>
            <td align="center">3</td>
            <td style="padding:0.2rem">Tingkat Permanensi <i>(Ip)</i></td>
            <td style="padding:0.2rem">{{ $par->ip[0] }}</td>
        </tr>
        <tr>
            <td align="center">4</td>
            <td style="padding:0.2rem">Jumlah Lantai <i>(Il)</i></td>
            <td style="padding:0.2rem">{{ $par->il[0] }}</td>
        </tr>
        <tr>
            <td align="center">5</td>
            <td style="padding:0.2rem">Status Kepemilikan <i>(Fm)</i></td>
            <td style="padding:0.2rem">{{ $par->fm[0] }}</td>
        </tr>
        <tr>
            <td align="center">6</td>
            <td style="padding:0.2rem">Indeks Terintegrasi <i>(It)</i></td>
            <td style="padding:0.2rem">{{ $par->it }}</td>
        </tr>
        <tr>
            <td align="center">7</td>
            <td style="padding:0.2rem">Indeks BG Terbangun <i>(Ibg)</i></td>
            <td style="padding:0.2rem">{{ $par->ibg[0] }}</td>
        </tr>
        <tr>
            <td align="center">8</td>
            <td style="padding:0.2rem">Indeks Lokalitas <i>(Ilo)</i></td>
            <td style="padding:0.2rem">{{ $par->ilo }}</td>
        </tr>
        <tr>
            <td align="center">9</td>
            <td style="padding:0.2rem">SHST Tahun 2023</td>
            <td style="padding:0.2rem">{{ $par->shst }}</td>
        </tr>
    </table>
    @php
        $nb = (array) $par->par;
    @endphp
    <h4>C. PERHITUNGAN NILAI RETRIBUSI BANGUNAN GEDUNG</h4>
    <table style="width: 98%">
        <tr align="center" style="background-color:lightgrey">
            <td>No.</td>
            <td>Uraian</td>
            <td>Luas (m<sup>2</sup>)</td>
        </tr>
        @for ($i = 1; $i < count($nb); $i++)
            @isset($nb[$i][0])
                <tr>
                    <td align="center" width="3%">{{ $i }}</td>
                    <td style="padding:0.2rem">{{ $nb[$i][0] }}</td>
                    <td style="padding:0.2rem" align="right">{{ $nb[$i][1] }}</td>
                </tr>
            @endif
            @endfor
            <tr style="background-color:lightgrey">
                <td colspan="2" style="text-align:right">Luas Total Bangunan <i>(LLt)</i>&nbsp;</td>
                <td align="right">{{ $par->llt }}</td>
            </tr>
            <tr style="background-color:ivory">
                <td colspan="2" style="text-align:right">NILAI RETRIBUSI BANGUNAN GEDUNG&nbsp;<br>&nbsp;<i>(It x Ibg x
                        Ilo x SHST x LLt)</i>&nbsp;</td>
                <td align="right">{{ number_format($par->retri, 0, ',', '.') }}</td>
            </tr>
        </table>
        @php
            $pra = (array) $par->pra;
        @endphp

        <h4>D. PERHITUNGAN NILAI RETRIBUSI PRASARANA</h4>
        <table style="width: 98%">
            <tr align="center" style="background-color:lightgrey">
                <td>No.</td>
                <td>Uraian</td>
                <td>Volume</td>
                <td>Sat.</td>
                <td>Harga Satuan.</td>
                <td>Jumlah Harga</td>
            </tr>
            @for ($i = 1; $i < count($pra); $i++)
                @isset($pra[$i][0])
                    <tr>
                        <td align="center">{{ $i }}</td>
                        <td style="padding:0.2rem">{{ $pra[$i][0] }}</td>
                        <td style="padding:0.2rem">{{ $pra[$i][1] }}</td>
                        <td style="padding:0.2rem">{{ $pra[$i][2] }}</td>
                        <td style="padding:0.2rem" align="right">
                            {{ number_format($pra[$i][3], 0, ',', '.') }}
                        </td>
                        <td style="padding:0.2rem" align="right">
                            {{ number_format($pra[$i][4], 0, ',', '.') }}
                        </td>
                    </tr>
                @endif
                @endfor
                <tr style="background-color:ivory">
                    <td colspan="5" style="text-align:right">NILAI RETRIBUSI PRASARANA&nbsp;</td>
                    <td align="right">{{ number_format($par->sumPra, 0, ',', '.') }}</td>
                </tr>
                <tr style="background-color:ivory">
                    <td colspan="5" style="text-align:right">
                        <strong>TOTAL NILAI RETRIBUSI</strong><br>
                        (NILAI RETRIBUSI BANGUNAN GEDUNG + NILAI RETRIBUSI PRASARANA)
                    </td>
                    <td align="right">{{ number_format($par->totRetri, 0, ',', '.') }}</td>
                </tr>
            </table>

            <div class="page-break"></div>
            <p>Catatan :</p>
            <ol>
                <li>Perhitungan Retribusi ini merupakan simulasi dengan mengacu pada Perda Kab. Tegal Nomor 12 Tahun 2021
                    tentang Retribusi Daerah
                </li>
                <li>Dokumen ini BUKAN merupakan PBG / Bukti Penagihan / Bukti Pembayaran yang sah, proses penagihan dan
                    pembayaran tetap mengacu pada SKRD yang dikeluarkan oleh DPMPTSP
                </li>
                <li>Hasil perhitungan ini dimungkinan terdapat perbedaan dengan SIMBG karena faktor sistem, dan perhitungan yang
                    digunakan adalah perhitungan melalui SIMBG
                </li>
            </ol>
</body>
</html>
