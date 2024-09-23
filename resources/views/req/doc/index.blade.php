@extends('layout.pdf')
@section('main')
    {{-- bak --}}
    @if ($head->bak && $head->bak->grant == 1)
        <header>
            <table style="width: 100%; border:none">
                <tr>
                    <td style="border:none"><img class="img" src="{{ gambar('kab.png') }}" /></td>
                    <td width="100%" style="border:none; text-align:center">
                        <p>
                            <span style="font-weight: bold; font-size:rem;text-wrap:none">BERITA ACARA KONSULTASI
                                (BAK)</span>
                            <br>No.&nbsp;&nbsp;{{ str_replace('SPm', 'BAK', str_replace('600.1.15', '600.1.15/PBLT', $head->nomor)) }}
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
                    <td width="60%" style="border:none">: {{ $header[0] }} </td>
                    <td width="40%" style="border:none">Pengajuan </td>
                    <td width="60%" style="border:none">: {{ strtoupper($header[1]) }}</td>
                </tr>
                <tr>
                    <td width="40%" style="border:none">Nama Pemohon </td>
                    <td width="60%" style="border:none">: {{ $header[2] }}</td>
                    <td width="40%" style="border:none">No. Telp. / HP </td>
                    <td width="60%" style="border:none">: {{ $header[3] }}</td>
                </tr>
                <tr>
                    <td width="40%" style="border:none">Alamat Pemohon </td>
                    <td colspan="3" style="border:none">: {{ $header[4] }}</td>
                </tr>
                <tr>
                    <td width="40%" style="border:none">Nama Bangunan </td>
                    <td width="60%" style="border:none">: {{ $header[5] }}</td>
                    <td width="40%" style="border:none">Fungsi </td>
                    <td width="60%" style="border:none">: {{ $header[6] }}</td>
                </tr>
                <tr>
                    <td width="40%" style="border:none;vertical:align:top">Alamat Bangunan </td>
                    <td colspan="3" style="border:none;vertical-align:top">
                        : {{ $header[7] }}, Kec. {{ $head->region->name }}, Kab. {{ $head->region->kecamatan->name }}
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
                    <td style="border:none" width="30%">: {{ $area->north }}</td>
                    <td style="border:none" width="40%">Timur </td>
                    <td style="border:none" width="60%">: {{ $area->east }}</td>
                </tr>
                <tr>
                    <td width="40%" style="border:none"></td>
                    <td style="border:none">&nbsp;&nbsp;&nbsp;Selatan </td>
                    <td style="border:none">: {{ $area->south }}</td>
                    <td style="border:none">Barat </td>
                    <td style="border:none">: {{ $area->west }}</td>
                </tr>
            </tbody>
        </table>
        <table style="width:100%;" align="center">
            <tr>
                <td width="40%" style="border:none">Kondisi </td>
                <td width="60%" style="border:none">: {{ ucwords(str_replace('_', ' ', $area->kondisi)) }} </td>
                <td width="40%" style="border:none">Tahun Pembangunan</td>
                <td width="60%" style="border:none">: {{ $head->bak->plan }} </td>
            </tr>
            <tr>
                <td width="40%" style="border:none">Tingkat Permanen </td>
                <td width="60%" style="border:none">: {{ ucwords(str_replace('_', ' ', $area->permanensi)) }} </td>
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
                        <td>&nbsp;&nbsp;{{ $umum[$i]->uraian }}</td>
                        <td>&nbsp;&nbsp;{{ $umum[$i]->value }}</td>
                    @else
                        <td></td>
                        <td></td>
                @endif
                <td style="border: none"></td>
                <td>&nbsp;&nbsp;{{ ucwords(str_replace('_', ' ', $bangunan[$i]->uraian)) }}</td>
                <td>&nbsp;&nbsp;{{ $bangunan[$i]->dimensi }}</td>
                <td>&nbsp;&nbsp;{{ $bangunan[$i]->note }}</td>
                </tr>
        @endfor

        @if ($head->bak->ibg)
            @foreach (json_decode($head->bak->ibg) as $fa)
                <tr>
                    <td></td>
                    <td></td>
                    <td style="border: none"></td>
                    <td>&nbsp;&nbsp;{{ $fa[0] }}</td>
                    <td>&nbsp;&nbsp;{{ $fa[1] }}</td>
                    <td>&nbsp;&nbsp;{{ $fa[2] }}</td>
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
        @if ($head->bak->note)
            {!! $head->bak->note !!}
        @else
            <br>
        @endif
        <table style="width:100%;">
            <tr>
                <td style="border: none" colspan="2">Dengan ditandatangani Berita Acara ini, maka Pemohon telah memahami
                    bahwa :</td>
            </tr>
            <tr>
                <td width="3%" class="code" style="border: none;vertical-align:top">1</td>
                <td style="border: none;vertical-align:top">
                    Luas bangunan yang disetujui adalah luasan bangunan yang sesuai / tidak bertentangan dengan ketentuan tata
                    bangunan yang berlaku dan/atau direkomendasikan (GSB, KDB, KDH, KLB, dan sebagainya).
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
                    Terhadap bangunan yang tidak disetujui / tidak sesuai dengan ketentuan yang berlaku, maka Pemohon / Pemilik
                    Bangunan bersedia melakukan penyesuaian bangunan sesuai peraturan perundang-undangan yang berlaku,
                </td>
            </tr>
            <tr>
                <td class="code" style="border: none;vertical-align:top">4</td>
                <td style="border: none;vertical-align:top">
                    Dalam hal Pemohon / Pemilik Bangunan tidak melakukan penyesuaian bangunan sesuai ketentuan, maka Pemohon /
                    Pemilik Bangunan bersedia menerima sanksi sesuai peraturan perundang-undangan yang berlaku.
                </td>
            </tr>
            <tr>
                <td class="code" style="border: none;vertical-align:top">5</td>
                <td style="border: none;vertical-align:top">
                    Seluruh kebenaran dan keabsahan dokumen baik administrasi dan teknis merupakan tanggungjawab Pemohon /
                    Pemilik Bangunan dan Penyedia Jasa / Konsultan Perencana.
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
                    Apabila dikemudian hari terdapat ketidaksesuaian terhadap dokumen administrasi dan/atau dokumen teknis yang
                    diajukan maka PBG dan/atau SLF akan dievaluasi kembali dan Pemohon bersedia menerima konsekuensi dan/atau
                    sanksi sesuai peraturan perundang-undangan yang berlaku serta retribusi yang telah dibayarkan tidak dapat
                    diminta kembali
                </td>
            </tr>
        </table>
        <p>Demikian hasil konsultasi TPT/TPA yang dihadiri oleh:</p>
        @if ($head->sign)
            <table style="width:35%;">
                @foreach ($head->sign->where('type', 'member') as $val)
                    <tr>
                        <td width="2%" style="border: none">
                            {{ $loop->iteration }}.
                        </td>
                        <td width="40%" style="border: none">
                            {{ $val->users->name }}
                        </td>
                        <td style="border: none">
                            @if ($val->bak)
                                <img src="{{ $val->bak }}" width="80%" style="margin: auto">
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
                    @if ($head->bak->sign)
                        <img src="{{ $head->bak->sign }}" width="50%" style="margin: auto">
                        <br>
                    @else
                        <br><br><br><br>
                    @endif
                    {{ $head->bak->primary == 'TPT' ? $head->bak->kabid : $head->kons->not->name }}
                </td>
                <td style="border: none" align="center">Setuju hasil pemeriksaan<br>Pemohon PBG<br>
                    @if ($head->bak->signs)
                        <img src="{{ $head->bak->signs }}" width="50%" style="margin: auto">
                        <br>
                    @else
                        <br><br><br><br>
                    @endif
                    {{ $header[2] }}
                </td>
            </tr>
        </table>
        <div class="page-break"></div>
        @endif

        {{-- barp --}}
        @if ($head->barp && $head->barp->grant == 1)
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
            @endphp
            <p>Sehubungan telah dilakukannya Konsultasi dengan TPT/TPA DPUPR Kabupaten Tegal pada :</p>
            <table style="width:98%" align="center">
                <tr>
                    <td width="40%" style="border:none">Hari / Tanggal</td>
                    <td width="60%" style="border:none">: {{ dateID($head->barp->tanggal) }} </td>
                    <td width="40%" style="border:none">Permohonan </td>
                    <td width="60%" style="border:none">: {{ strtoupper($header[1]) }}</td>
                </tr>
                <tr>
                    <td width="40%" style="border:none">No. Registrasi PBG</td>
                    <td width="60%" style="border:none">: {{ $header[0] }}</td>
                    <td width="40%" style="border:none"></td>
                    <td width="60%" style="border:none"></td>
                </tr>
            </table>
            <p>Atas pengajuan Persetujuan Bangunan Gedung :</p>
            <table style="width:98%;" align="center">
                <tbody>
                    <tr>
                        <td width="40%" style="border:none">Nama Pemohon </td>
                        <td width="60%" style="border:none">: {{ $header[2] }}</td>
                        <td width="40%" style="border:none">No. Telp. / HP </td>
                        <td width="60%" style="border:none">: {{ $header[3] }}</td>
                    </tr>
                    <tr>
                        <td width="40%" style="border:none">Alamat Pemohon </td>
                        <td width="60%" style="border:none">: {{ $header[4] }}</td>
                    </tr>
                    <tr>
                        <td width="40%" style="border:none">Nama Bangunan </td>
                        <td width="60%" style="border:none">: {{ $header[5] }}</td>
                        <td width="40%" style="border:none">Fungsi </td>
                        <td width="60%" style="border:none">: {{ $header[6] }}</td>
                    </tr>
                    <tr>
                        <td width="40%" style="border:none;vertical:align:top">Alamat Bangunan </td>
                        <td colspan="3" style="border:none;vertical-align:top">
                            : {{ $header[7] }}, Kec. {{ $head->region->name }}, Kab. {{ $head->region->kecamatan->name }}
                        </td>
                    </tr>
                    <tr>
                        <td width="40%" style="border:none">Status Kepemilikan</td>
                        <td width="60%" style="border:none">: {{ ucwords($mheader->status) }}</td>
                        <td width="40%" style="border:none">NIB </td>
                        <td width="60%" style="border:none">: {{ $mheader->nib }}</td>
                    </tr>
                    <tr>
                        <td width="40%" style="border:none">Jenis Permohonan</td>
                        <td width="60%" style="border:none">: {{ ucwords($mheader->jenis) }}</td>
                        <td width="40%" style="border:none"></td>
                        <td width="60%" style="border:none"></td>
                    </tr>
                    <tr>
                        <td width="40%" style="border:none">Fungsi Bangunan</td>
                        <td width="60%" style="border:none">: {{ ucwords($mheader->jenis) }}</td>
                        <td width="40%" style="border:none"></td>
                        <td width="60%" style="border:none"></td>
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
                    <td width="3%" style="border: none;vertical-align:top;font-family:DejaVu Sans">{!! $items->val[0] == 1 ? '&#x2611;' : '&#9746;' !!}
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
                        <td style="padding: 0.3rem">{{ $val }}</td>
                    @endforeach
                </tr>
                @for ($i = 0; $i < count($other); $i++)
                    <tr>
                        <td style="padding: 0.3rem">{{ $other[$i]->uraian }}</td>
                        <td style="padding: 0.3rem">{{ $other[$i]->pengajuan }}</td>
                        <td style="padding: 0.3rem">{{ $other[$i]->disetujui }}</td>
                        <td style="padding: 0.3rem">{{ $other[$i]->keterangan }}</td>
                    </tr>
                @endfor

            </table>
            <table style="width:100%;">
                <tr>
                    <td width="3%" style="border: none;vertical-align:top;font-family:DejaVu Sans">{!! $items->val[1] == 1 ? '&#x2611;' : '&#9746;' !!}
                    </td>
                    <td style="border: none;vertical-align:top">Merekomendasikan pemohon untuk memperbaiki
                        dokumen / informasi yang diunggah melalui SIMBG</td>
                </tr>
                <tr>
                    <td style="border: none;vertical-align:top;font-family:DejaVu Sans">{!! $items->val[2] == 1 ? '&#x2611;' : '&#9746;' !!}</td>
                    <td style="border: none;vertical-align:top">
                        Merekomendasikan pemohon untuk melakukan
                        pendaftaran ulang PBG dan/atau SLF melalui SIMBG</td>
                </tr>
                <tr>
                    <td style="border: none;vertical-align:top;font-family:DejaVu Sans">{!! $items->val[3] == 1 ? '&#x2611;' : '&#9746;' !!}</td>
                    <td style="border: none;vertical-align:top">
                        Proses PBG dan/atau SLF tidak dapat dilanjutkan
                        / ditolak</td>
                </tr>
            </table>
            <p>Demikian hasil konsultasi TPT/TPA yang dihadiri oleh:</p>
            @if ($head->sign)
                <table style="width:35%;">
                    @foreach ($head->sign->where('type', 'member') as $val)
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
                        <p>Mengetahui,<br>
                            Ketua Rapat Pleno TPT/TPA
                        </p>
                        @if ($head->barp->sign)
                            <img src="{{ $head->barp->sign }}" width="50%" style="margin: auto">
                            <br>
                        @else
                            <br><br><br><br>
                        @endif
                        {{ $head->barp->primary == 'TPT' ? $head->barp->kabid : $head->kons->not->name }}
                    </td>
                </tr>
            </table>
            <div class="page-break"></div>
        @endif

        {{-- lampiran --}}
        @if ($head->attach)
            <table style="width: 100%; border:none">
                <tr>
                    <td style="border:none"><img class="img" src="{{ gambar('kab.png') }}" /></td>
                    <td width="100%" style="border:none; text-align:center">
                        <p>
                            <span style="font-weight: bold; font-size:0.8rem;text-wrap:none">LAMPIRAN DOKUMEN PBG</span>
                            <br>No.&nbsp;&nbsp;{{ str_replace('SPm', 'LDP', str_replace('600.1.15', '600.1.15/PBLT', $head->nomor)) }}
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
                        <td width="60%" style="border:none">: {{ $header[0] }} </td>
                        <td width="40%" style="border:none"></td>
                        <td width="60%" style="border:none"></td>
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
                    <tr>
                        <td width="40%" style="border:none">Luas Tanah</td>
                        <td width="60%" style="border:none">: {{ $head->attach->luas }}</td>
                        <td width="50%" style="border:none">Bukti Kepemilikan Tanah</td>
                        <td width="50%" style="border:none">: {{ $head->attach->bukti }}</td>
                    </tr>
                </tbody>
            </table>
            <table style="width: 100%; border:none;margin-top:1rem">
                <tr>
                    <td colspan="2" style="padding: 0.5rem;font-weight:bold;text-align:center">Gambar Denah / Situasi</td>
                </tr>
                @if ($head->attach->pile_map)
                    @php
                        $var = json_decode($head->attach->pile_map);
                    @endphp
                    @foreach ($var as $key)
                        <tr class="{{ $loop->last ? 'page-break' : null }}">
                            <td colspan="2" style="padding: 0.5rem;">
                                <center>
                                    <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('storage/' . $key))) }}"
                                        style="width:100%;object-fit:cover;object-position:center;margin:auto;display:block;padding:0.3rem">
                                </center>
                            </td>
                        </tr>
                    @endforeach
                @endif
                <tr>
                    <td style="padding: 0.5rem;font-weight:bold;text-align:center" width="50%">
                        Lokasi Bangunan
                        @if ($head->attach->pile_loc)
                            <center>
                                <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('storage/' . $head->attach->pile_loc))) }}"
                                    style="width:100%;object-fit:cover;object-position:center;margin:auto;display:block">
                            </center>
                        @endif
                    </td>
                    <td style="padding: 0.5rem;font-weight:bold;text-align:center" width="50%">Kondisi Lahan / Bangunan
                        @if ($head->attach->pile_land)
                            <center>
                                <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('storage/' . $head->attach->pile_land))) }}"
                                    style="width:100%;object-fit:cover;object-position:center;margin:auto;display:block">
                            </center>
                        @endif
                    </td>
                </tr>
                <tr>
                    <td colspan="2" style="padding: 0.5rem;font-weight:bold">Koordinat : {{ $head->attach->koordinat }}
                    </td>
                </tr>
            </table>
            <p>Catatan :</p>
            <ol>
                <li>Lampiran ini merupakan bagian yang tidak terpisahkan dari Berita Acara Rapat Pleno (BARP) <br> No.
                    {{ $head->number }}
                </li>
                <li>Pemilik bangunan tidak diperkenankan mengembangkan bangunan diluar ketentuan yang berlaku.
                </li>
                <li>Terhadap bangunan yang telah berdiri (existing) agar dilakukan pemeriksaan kelaikan fungsi sebelum bangunan
                    dimanfaatkan.
                </li>
            </ol>
            <img src="data:image/png;base64, {{ $head->qr }}" width="20%" style="float: right">
            <div class="page-break"></div>
        @endif

        {{-- retribusi --}}
        @if ($head->tax)
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
                <p>Catatan :</p>
                <ol>
                    <li>Perhitungan Retribusi ini merupakan simulasi dengan mengacu pada Perda Kab. Tegal Nomor 11 Tahun 2023 tentang
                        Pajak Daerah dan Retribusi Daerah
                    </li>
                    <li>Dokumen ini BUKAN merupakan PBG / Bukti Penagihan / Bukti Pembayaran yang sah, proses penagihan dan pembayaran
                        tetap mengacu pada SKRD yang dikeluarkan oleh DPMPTSP
                    </li>
                    <li>Hasil perhitungan ini dimungkinan terdapat perbedaan dengan hasil perhitungan retribusi akhir karena faktor
                        sistem dan hasil verifikasi akhir terhadap dokumen teknis secara menyeluruh
                    </li>
                </ol>
                @endif
            @endsection
