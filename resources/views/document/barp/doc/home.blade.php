    <header>
        <table style="width: 100%; border:none">
            <tr>
                <td style="border:none"><img class="img" src="{{ gambar('kab.png') }}" /></td>
                <td width="100%" style="border:none; text-align:center">
                    <p>
                        <span style="font-weight: bold; font-size:0.8rem;text-wrap:none">BERITA ACARA RAPAT PLENO
                            (BARP)</span>
                        <br>No.&nbsp;&nbsp;{{ str_replace('SPm', 'BARP', str_replace('600.1.15', '600.1.15/PBLT', $head->nomor)) }}
                    </p>
                </td>
                <td style="border:none"><img class="img" src="{{ gambar('logo.png') }}" /></td>
            </tr>
        </table>
    </header>
    @php
        $header = (array) json_decode($head->bak->doc->header);
        $mheader = json_decode($head->barp->header);
        $items = json_decode($head->barp->item);
        $item = (array) json_decode($head->bak->item);
        $other = json_decode($head->barp->other);
        $umum = $item['informasi_umum'];
        $bangunan = $item['informasi_bangunan_gedung'];
        $surat = explode('#', $head->surat->waktu);
    @endphp
    <p>Sehubungan telah dilakukannya Konsultasi dengan TPT/TPA DPUPR Kabupaten Tegal pada :</p>
    <table style="width:100%" align="center">
        <tr>
            <td width="10%" style="border:none">Hari / Tanggal</td>
            <td width="1%" style="border:none">:</td>
            <td width="20%" style="border:none">{{ dateID($surat[2]) }} </td>
            <td width="10%" style="border:none">Permohonan </td>
            <td width="1%" style="border:none">:</td>
            <td width="20%" style="border:none">{{ strtoupper($header[1]) }}</td>
        </tr>
        <tr>
            <td width="10%" style="border:none">No. Registrasi PBG</td>
            <td width="1%" style="border:none">:</td>
            <td colspan="3" style="border:none">{{ $header[0] }}</td>      
        </tr>
    </table>
    <p>Atas pengajuan Persetujuan Bangunan Gedung :</p>
    <table style="width:100%;" align="center">
        <tbody>
            <tr>
                <td width="10%" style="border:none">Nama Pemohon </td>
                <td width="1%" style="border:none">:</td>
                <td width="20%" style="border:none">{{ $header[2] }}</td>
                <td width="10%" style="border:none">No. Telp. / HP </td>
                <td width="1%" style="border:none">:</td>
                <td width="20%" style="border:none">{{ $header[3] }}</td>
            </tr>
            <tr>
                <td width="10%" style="border:none">Alamat Pemohon </td>
                <td width="1%" style="border:none">:</td>
                <td colspan="4" style="border:none">{{ $header[4] }}</td>
            </tr>
            <tr>
                <td width="10%" style="border:none">Nama Bangunan </td>
                <td width="1%"  style="border:none">:</td>
                <td width="20%" style="border:none">{{ $header[5] }}</td>
                <td width="10%" style="border:none">Fungsi </td>
                <td width="1%"  style="border:none">:</td>
                <td width="20%" style="border:none">{{ $header[6] }}</td>
            </tr>
            <tr>
                <td width="10%" style="border:none;vertical:align:top">Alamat Bangunan </td>
                <td width="1%"  style="border:none;vertical-align:top">:</td>
                <td colspan="4" style="border:none;vertical-align:top">
                    {{ $header[7] }}, Desa/Kel. {{ $head->region->name }}, Kec.
                    {{ $head->region->kecamatan->name }}
                    Kab. Tegal, Prov. Jawa Tengah
                </td>
            </tr>
            <tr>
                <td width="10%" style="border:none">Status Kepemilikan</td>
                <td width="1%" style="border:none">:</td>
                <td width="20%" style="border:none">{{ ucwords($mheader->status) }}</td>
                <td width="10%" style="border:none">NIB </td>
                <td width="1%" style="border:none">:</td>
                <td width="20%" style="border:none">{{ $mheader->nib }}</td>
            </tr>
            <tr>
                <td width="10%" style="border:none">Jenis Permohonan</td>
                <td width="1%" style="border:none">:</td>
                <td colspan="4" style="border:none">{{ ucwords($mheader->jenis) }}</td>              
            </tr>
            <tr>
                <td width="10%" style="border:none">Fungsi Bangunan</td>
                <td width="1%" style="border:none">:</td>
                <td colspan="4" style="border:none">{{ ucwords($mheader->fungsi) }}</td>     
            </tr>


        </tbody>
    </table>
    <p>Sebagaimana terlampir pada Lembar Berita Acara Konsultasi
        No.
        {{ str_replace('SPm', 'BAK', str_replace('600.1.15', '600.1.15/PBLT', $head->barp->doc->nomor)) }}
        yang
        merupakan bagian tidak terpisahkan dari Berita Acara Rapat Pleno ini,
        TPT/TPA memberikan masukkan:
        <br>
        {!! $items->item[0] !!}
    </p>
    <p>Dan dengan pertimbangan bahwa :<br>{!! $items->item[1] !!}</p>
    Memutuskan untuk :
    <table style="width:100%;">
        <tr>
            <td width="3%" style="border: none;vertical-align:top;font-family:DejaVu Sans">{!! $items->val[0] == 1 ? '&#x2611;' : '&#9744;' !!}
            </td>
            <td style="border: none;vertical-align:top">Merekomendasikan penerbitan Surat Pernyataan Pemenuhan Standar
                Teknis PBG dan/atau SLF dengan :
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
            @foreach ($items->luas as $key => $val)
                <td align="{{$key == 2 ? 'left' : 'center'}}" style="padding: 0.3rem">{{ $val }}</td>
            @endforeach
        </tr>
        @for ($i = 0; $i < count($other); $i++)
            <tr>
                <td style="padding: 0.3rem">{{ $other[$i]->uraian }}</td>
                <td align="center" style="padding: 0.3rem">{{ $other[$i]->pengajuan }}</td>
                <td align="center" style="padding: 0.3rem">{{ $other[$i]->disetujui }}</td>
                <td style="padding: 0.3rem">{{ $other[$i]->keterangan }}</td>
            </tr>
        @endfor

    </table>
    <table style="width:100%;">
        <tr>
            <td width="3%" style="border: none;vertical-align:top;font-family:DejaVu Sans">{!! $items->val[1] == 1 ? '&#x2611;' : '&#9744;' !!}
            </td>
            <td style="border: none;vertical-align:top">Merekomendasikan pemohon untuk memperbaiki
                dokumen / informasi yang diunggah melalui SIMBG</td>
        </tr>
        <tr>
            <td style="border: none;vertical-align:top;font-family:DejaVu Sans">{!! $items->val[2] == 1 ? '&#x2611;' : '&#9744;' !!}</td>
            <td style="border: none;vertical-align:top">
                Merekomendasikan pemohon untuk melakukan
                pendaftaran ulang PBG dan/atau SLF melalui SIMBG</td>
        </tr>
        <tr>
            <td style="border: none;vertical-align:top;font-family:DejaVu Sans">{!! $items->val[3] == 1 ? '&#x2611;' : '&#9744;' !!}</td>
            <td style="border: none;vertical-align:top">
                Proses PBG dan/atau SLF tidak dapat dilanjutkan
                / ditolak</td>
        </tr>
    </table>
    <p>Demikian hasil konsultasi TPT/TPA yang dihadiri oleh:</p>
    @if ($head->sign)
        <table style="width:35%;">
            @foreach (collect($head->sign)->sortBy('type') as $val)
                <tr>
                    <td width="2%" style="border: none">
                        {{ $loop->iteration }}.
                    </td>
                    <td width="40%" style="border: none">
                        {{ $val->users->name }}
                    </td>
                    <td style="border: none">
                        @if ($val->barp)
                            <img src="{{ $val->barp }}" width="98%" style="margin: auto">
                        @endif
                    </td>
                </tr>
            @endforeach
        </table>
    @endif
    <table style="width:100%;">
        <tr>
            <td width="60%" style="border: none" align="center">
            </td>
            <td style="border: none" align="center">
            <p>{{ $head->barp->place }}, {{ dateID($head->barp->date) }}</p>           
                <p>Mengetahui,<br>
                    Ketua Rapat Pleno TPT/TPA
                </p>
                @if ($head->barp->grant == 1)
                    @if($head->barp->primary == 'TPT')
                        <img src="{{ $head->barp->sign }}" width="50%" style="margin: auto">
                    @else
                        <img src="{{ $head->sign->where('type','lead')->first()->barp }}" width="50%" style="margin: auto">
                    @endif
                    <br>
                @else
                    <br><br><br><br>
                @endif
                {{ $head->barp->primary == 'TPT' ? $head->barp->kabid : $head->kons->not->name }}
            </td>
        </tr>
    </table>
    @if ($head->grant == 1)
        @php  $header = (array) json_decode($head->header); @endphp
        <script type="text/php"> 
        if (isset($pdf)) { 
            //Shows number center-bottom of A4 page with $x,$y values
            $x = 300;  //X-axis vertical position 
            $y = 990; //Y-axis horizontal position
            $text = "Lembar BARP No. {{ str_replace('SPm', 'BARP', str_replace('600.1.15', '600.1.15/PBLT', $head->nomor)) }} | Halaman {PAGE_NUM} dari {PAGE_COUNT}";             
            $font =  $fontMetrics->get_font("helvetica", "bold");
            $size = 7;
            $color = array(0,0,0);
            $word_space = 0.0;  //  default
            $char_space = 0.0;  //  default
            $angle = 0.0;   //  default
            $pdf->page_text($x, $y, $text, $font, $size, $color, $word_space, $char_space, $angle);
        }
        </script>
    @endif
