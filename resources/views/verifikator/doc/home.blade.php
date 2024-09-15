@extends('layout.pdf')

@section('main')
    @include('verifikator.doc.header')

    @if ($head->steps->count() > 0)
        @php
            $no = 1;
            $doc = $head->steps->where('kode', 'VL3')->first();
            $doc2 = $head->steps->where('kode', 'VL2')->first();
        @endphp
        <main>
            <p style="font-weight: bold;">{{ $docs->tag }}</p>
            <table autosize="1" style="width: 100%">
                <tbody>

                    {{-- dokumen_administrasi --}}
                    @if ($doc)
                        <tr style="font-weight: bold;">
                            <td width="5%" align="center">A.</td>
                            <td colspan="2" width="50%">Dokumen Administrasi</td>
                            <td width="10%" align="center">Status</td>
                            <td width="35%" align="center">Catatan / Saran</td>
                        </tr>
                        @php
                            $da = json_decode($doc->item);
                            $item = (array) $da->dokumen_administrasi->item;
                            $saranItem = (array) $da->dokumen_administrasi->saranItem;
                            $sub = (array) $da->dokumen_administrasi->sub;
                        @endphp

                        @foreach ($item as $key => $value)
                            <tr>
                                <td style="text-align: right; vertical-align:top">{{ $no++ }}&nbsp;</td>
                                <td colspan="2">{{ named($key, 'item') }}
                                <td align="center">{{ status($value) }}</td>
                                <td align="center">&nbsp;{{ $saranItem[$key] }}</td>
                            </tr>
                        @endforeach


                        @foreach ($sub as $key => $value)
                            <tr>
                                <td style="text-align: right; vertical-align:top">{{ $no++ }}&nbsp;</td>
                                <td colspan="2">{{ named($value->title, 'item') }}</td>
                                <td></td>
                                <td></td>
                            </tr>
                            @php $saran = (array) $value->saran @endphp
                            @foreach ($value->value as $key => $value)
                                <tr>
                                    <td></td>
                                    <td width="1%" style="vertical-align:top;border-right:0px">
                                        &nbsp;{{ abjad($loop->index) }}. </td>
                                    <td style="border-left:0px">{{ named($key, 'sub') }}</td>
                                    <td align="center">{{ status($value) }}</td>
                                    <td align="center">{{ $saran[$key] }}</td>
                                </tr>
                            @endforeach
                        @endforeach
                    @endif

                    @if ($doc2)
                        @php
                            $other = $doc2->other ? json_decode($doc2->other) : null;
                            $da = json_decode($doc2->item);
                            if ($head->type == 'umum') {
                                $sub = (array) $da->dokumen_teknis->sub;
                            } else {
                                $item = (array) $da->persyaratan_teknis->item;
                                $saranItem = (array) $da->persyaratan_teknis->saranItem;
                                $sub = (array) $da->persyaratan_teknis->sub;
                            }
                        @endphp
                        <tr style="font-weight: bold;">
                            <td width="5%" style="text-align: center">B.</td>
                            @if ($head->type == 'umum')
                                <td width="5%" colspan="4">Dokumen Teknis</td>
                            @else
                                <td colspan="4">Persyaratan Teknis</td>
                            @endif
                        </tr>
                        @foreach ($sub as $key => $value)
                            <tr>
                                <td style="text-align: right; vertical-align:top">{{ $loop->iteration }}&nbsp;</td>
                                <td colspan="2">{{ named($value->title, 'item') }}</td>
                                <td></td>
                                <td></td>
                            </tr>
                            @php $saran = (array) $value->saran @endphp
                            @foreach ($value->value as $key => $value)
                                <tr>
                                    <td></td>
                                    <td width="1%" style="vertical-align:top;border-right:0px">
                                        &nbsp;{{ abjad($loop->index) }}. </td>
                                    <td style="border-left:0px">{{ named($key, 'sub') }}</td>
                                    <td align="center">{{ status($value) }}</td>
                                    <td align="center">{{ $saran[$key] }}</td>
                                </tr>
                            @endforeach
                        @endforeach

                        @if ($head->type == 'menara')
                            @foreach ($item as $key => $value)
                                @if ($value != 2)
                                    <tr>
                                        <td style="text-align: right; vertical-align:top">
                                            {{ $loop->iteration + 1 }}&nbsp;</td>
                                        <td colspan="2">&nbsp;{{ named($key, 'item') }}
                                        <td align="center">{{ status($value) }}</td>
                                        <td>&nbsp;{{ $saranItem[$key] }}</td>
                                    </tr>
                                @endif
                            @endforeach
                        @endif


                    @endif

                    @if ($head->type == 'umum')
                        {{-- dokumen pendukung --}}
                        @php
                            $item = (array) $da->dokumen_pendukung_lainnya->item;
                            $saranItem = (array) $da->dokumen_pendukung_lainnya->saranItem;
                            $sub = (array) $da->dokumen_pendukung_lainnya->sub;
                            $view = 0;
                            $other = 0;
                        @endphp

                        @foreach ($item as $key => $value)
                            @php
                                $other += $value;
                            @endphp
                        @endforeach
                        @foreach ($sub as $key => $value)
                            @foreach ($value->value as $key => $var)
                                @php
                                    $view += $var;
                                @endphp
                            @endforeach
                        @endforeach


                        <tr style="font-weight: bold;">
                            <td style="text-align: center">C.</td>
                            <td colspan="4">&nbsp;Dokumen Pendukung Lainnya (Untuk SLF)</td>
                        </tr>

                        @foreach ($item as $key => $value)
                            @if ($value != 2)
                                <tr>
                                    <td style="text-align: right; vertical-align:top">{{ $loop->iteration }}&nbsp;</td>
                                    <td colspan="2">&nbsp;{{ named($key, 'item') }}
                                    <td align="center">{{ status($value) }}</td>
                                    <td>&nbsp;{{ $saranItem[$key] }}</td>
                                </tr>

                                @php $next = $loop->iteration; @endphp
                            @else
                                @php $next = 0; @endphp
                            @endif
                        @endforeach

                        @foreach ($sub as $key => $value)
                            @if ($view != 30)
                                <tr>
                                    <td style="text-align: right; vertical-align:top">
                                        {{ $loop->iteration + $next }}&nbsp;</td>
                                    <td colspan="2">&nbsp;{{ named($value->title, 'item') }}</td>
                                    <td></td>
                                    <td></td>
                                </tr>
                            @endif
                            @php $saran = (array) $value->saran @endphp
                            @foreach ($value->value as $key => $value)
                                @if ($value != 2)
                                    <tr>
                                        <td></td>
                                        <td width="1%" style="vertical-align:top;border-right:0px">
                                            &nbsp;{{ abjad($loop->index) }}. </td>
                                        <td style="border-left:0px">&nbsp;{{ named($key, 'sub') }}</td>
                                        <td align="center">{{ status($value) }}</td>
                                        <td align="center">{{ $saran[$key] }}</td>
                                    </tr>
                                @endif
                            @endforeach
                        @endforeach
                    @endif

                       @if($doc2->other)
                         @php
                            $other = $doc2->other ? json_decode($doc2->other) : null;             
                         @endphp
                         
                        <tr style="font-weight: bold;">
                            <td style="text-align: center">D.</td>
                            <td colspan="4">&nbsp;Lain-lain</td>
                        </tr>

                        @for($i=0;$i < count($other); $i++)
                            <tr>
                                <td></td>
                                <td width="1%" style="vertical-align:top;border-right:0px">
                                    &nbsp;{{ abjad($i) }}. </td>
                                <td style="border-left:0px">&nbsp;{{ $other[$i]->name }}</td>
                                <td align="center">{{ status($other[$i]->value) }}</td>
                                <td align="center">{{ $other[$i]->saran }}</td>
                            </tr>
                        @endfor
                        @endif
                </tbody>
            </table>
        </main>

        @if ($head->status == 1)
            @include('verifikator.doc.footer')
        @endif

    @endif

    @php  $header = (array) json_decode($head->header); @endphp
    <script type="text/php"> 
         if (isset($pdf)) { 
             //Shows number center-bottom of A4 page with $x,$y values
            $x = 300;  //X-axis vertical position 
            $y = 820; //Y-axis horizontal position
            $text = "Lembar Verifikasi Dokumen No. Registrasi {{$header[0]}} | Halaman {PAGE_NUM} dari {PAGE_COUNT}";             
            $font =  $fontMetrics->get_font("helvetica", "bold");
            $size = 7;
            $color = array(0,0,0);
            $word_space = 0.0;  //  default
            $char_space = 0.0;  //  default
            $angle = 0.0;   //  default
            $pdf->page_text($x, $y, $text, $font, $size, $color, $word_space, $char_space, $angle);
        }
    </script>
@endsection
