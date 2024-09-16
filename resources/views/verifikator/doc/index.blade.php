@extends('layout.pdf')

@section('main')
    @include('verifikator.doc.header')

    <main style="margin-top: 0.2rem">
        <p style="font-weight: bold; margin-top:1rem;">{{ $docs->tag }}</p>
        <table autosize="1" style="width: 100%">
            <tbody>
                {{-- dokumen_administrasi --}}
                <tr style="font-weight: bold;">
                    <td width="5%" align="center">A.</td>
                    <td colspan="2" width="50%">&nbsp;Dokumen Administrasi</td>
                    <td width="10%" align="center">Status</td>
                    <td width="35%" align="center">Catatan / Saran</td>
                </tr>
                @php
                    $da = json_decode($head->steps[0]->item);
                    $item = (array) $da->dokumen_administrasi->item;
                    $saranItem = (array) $da->dokumen_administrasi->saranItem;
                    $sub = (array) $da->dokumen_administrasi->sub;
                @endphp

                @foreach ($item as $key => $value)
                    <tr>
                        <td style="text-align: right; vertical-align:top">{{ $loop->iteration }}&nbsp;</td>
                        <td colspan="2">&nbsp;{{ named($key, 'item') }}
                        <td align="center">{{ status($value) }}</td>
                        <td>&nbsp;{{ $saranItem[$key] }}</td>
                    </tr>
                @php
                  $next = $loop->iteration;
                @endphp
                @endforeach


                @foreach ($sub as $key => $value)
                    <tr>
                        <td style="text-align: right; vertical-align:top">{{$next+$loop->iteration}}&nbsp;</td>
                        <td colspan="2">&nbsp;{{ named($value->title, 'item') }}</td>
                        <td></td>
                        <td></td>
                    </tr>
                    @php $saran = (array) $value->saran @endphp
                    @foreach ($value->value as $key => $value)
                        <tr>
                            <td></td>
                            <td width="1%" style="vertical-align:top;border-right:0px">
                                &nbsp;{{ abjad($loop->index) }}. </td>
                            <td style="border-left:0px">&nbsp;{{ named($key, 'sub') }}</td>
                            <td align="center">{{ status($value) }}</td>
                            <td align="center">{{ $saran[$key] }}</td>
                        </tr>
                    @endforeach
                @endforeach

                @if ($head->type == 'umum')
                    {{-- dokumen teknis --}}
                    <tr style="font-weight: bold;">
                        <td style="text-align: center">B.</td>
                        <td colspan="4">&nbsp;Dokumen Teknis</td>
                    </tr>

                    @php
                        $sub = (array) $da->dokumen_teknis->sub;
                    @endphp
                    @foreach ($sub as $key => $value)
                        <tr>
                            <td style="text-align: right; vertical-align:top">{{ $loop->iteration }}&nbsp;</td>
                            <td colspan="2">&nbsp;{{ named($value->title, 'item') }}</td>
                            <td></td>
                            <td></td>
                        </tr>
                        @php $saran = (array) $value->saran @endphp
                        @foreach ($value->value as $key => $value)
                            <tr>
                                <td></td>
                                <td width="1%" style="vertical-align:top;border-right:0px">
                                    &nbsp;{{ abjad($loop->index) }}. </td>
                                <td style="border-left:0px">&nbsp;{{ named($key, 'sub') }}</td>
                                <td align="center">{{ status($value) }}</td>
                                <td align="center">{{ $saran[$key] }}</td>
                            </tr>
                        @endforeach
                    @endforeach


                    {{-- dokumen pendukung --}}
                    @php
                        $item = (array) $da->dokumen_pendukung_lainnya->item;      
                        $saranItem = (array) $da->dokumen_pendukung_lainnya->saranItem;
                        $sub = (array) $da->dokumen_pendukung_lainnya->sub;
                        $view = 0;
                        $other = 0;
                        $vdpl = [];
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

                    @foreach ($item as $key => $value)                  
                            @php
                                array_push($vdpl,$value);
                            @endphp
                    @endforeach

                    @php
                        $vw0 = in_array(0, $vdpl);
                        $vw1 = in_array(1, $vdpl);
                        $noDpl = 1;
                    @endphp
      
                    @if($vw0 && $vw1)
                        <tr style="font-weight: bold;">
                            <td style="text-align: center">C.</td>
                            <td colspan="4">&nbsp;Dokumen Pendukung Lainnya (Untuk SLF)</td>
                        </tr>
                    @elseif($vw1)
                        <tr style="font-weight: bold;">
                            <td style="text-align: center">C.</td>
                            <td colspan="4">&nbsp;Dokumen Pendukung Lainnya (Untuk SLF)</td>
                        </tr>
                    @elseif($vw0)
                        <tr style="font-weight: bold;">
                            <td style="text-align: center">C.</td>
                            <td colspan="4">&nbsp;Dokumen Pendukung Lainnya (Untuk SLF)</td>
                        </tr>
                    @endif

                    @foreach ($item as $key => $value)
                        @if ($value != 2)
                            <tr>
                                <td style="text-align: right; vertical-align:top">{{ $noDpl++ }}&nbsp;</td>
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
                                <td style="text-align: right; vertical-align:top">{{ $loop->iteration + $next }}&nbsp;
                                </td>
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
                                    <td align="center">{{ status($value) }} {{$value}}</td>
                                    <td align="center">{{ $saran[$key] }}</td>
                                </tr>
                            @endif
                        @endforeach
                    @endforeach
                @else
                    {{-- dokumen persyaratan teknis --}}
                    <tr style="font-weight: bold;">
                        <td style="text-align: center">B.</td>
                        <td colspan="4">&nbsp;Persyaratan Teknis</td>
                    </tr>

                    @php
                        $item = (array) $da->persyaratan_teknis->item;
                        $saranItem = (array) $da->persyaratan_teknis->saranItem;
                        $sub = (array) $da->persyaratan_teknis->sub;
                    @endphp


                    @foreach ($sub as $key => $value)
                        <tr>
                            <td style="text-align: right; vertical-align:top">1&nbsp;</td>
                            <td colspan="2">&nbsp;{{ named($value->title, 'item') }}</td>
                            <td></td>
                            <td></td>
                        </tr>
                        @php $saran = (array) $value->saran @endphp
                        @foreach ($value->value as $key => $value)
                            <tr>
                                <td></td>
                                <td width="1%" style="vertical-align:top;border-right:0px">
                                    &nbsp;{{ abjad($loop->index) }}. </td>
                                <td style="border-left:0px">&nbsp;{{ named($key, 'sub') }}</td>
                                <td align="center">{{ status($value) }}</td>
                                <td align="center">{{ $saran[$key] }}</td>
                            </tr>
                        @endforeach
                    @endforeach

                    @foreach ($item as $key => $value)
                        @if ($value != 2)
                            <tr>
                                <td style="text-align: right; vertical-align:top">{{ $loop->iteration+1 }}&nbsp;</td>
                                <td colspan="2">&nbsp;{{ named($key, 'item') }}
                                <td align="center">{{ status($value) }}</td>
                                <td>&nbsp;{{ $saranItem[$key] }}</td>
                            </tr>
                        @endif
                    @endforeach

                @endif


            </tbody>
        </table>
    </main>

    @if ($head->status == 1)
        @include('verifikator.doc.footer')
    @endif


    @if ($head->head->count() > 0)
        <script type="text/php"> 
            if (isset($pdf)) { 
                //Shows number center-bottom of A4 page with $x,$y values
                $x = 35;  //X-axis i.e. vertical position 
                $y = 820; //Y-axis horizontal position
                $text = "Dokumen Perbaikain ke {{$head->parents->tmp->count()}}";             
                $font =  $fontMetrics->get_font("helvetica", "bold");
                $size = 7;
                $color = array(255,0,0);
                $word_space = 0.0;  //  default
                $char_space = 0.0;  //  default
                $angle = 0.0;   //  default
                $pdf->page_text($x, $y, $text, $font, $size, $color, $word_space, $char_space, $angle);
            }
        </script>
    @endif


    @php  $header = (array) json_decode($head->header); @endphp

    <script type="text/php"> 
        if (isset($pdf)) { 
            //Shows number center-bottom of A4 page with $x,$y values
            $x = 280;  //X-axis vertical position 
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
