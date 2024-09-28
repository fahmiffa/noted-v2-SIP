@extends('layout.base')
@push('css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" />
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.rtl.min.css" />

    <style>
        /* Chrome, Safari, Edge, Opera */
        input::-webkit-outer-spin-button,
        input::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        /* Firefox */
        input[type=number] {
            -moz-appearance: textfield;
            text-align: right;
        }
    </style>
@endpush
@section('main')
    <div class="page-heading">

        <section class="section">
            <div class="card">

                <div class="card-header">
                    <h5 class="card-title mb-3">Simulasi Perhitungan Retribusi</h5>  
                    @include('document.pemohon')
                </div>

                <div class="card-body">

                    <form action="{{ route('tax.store', ['id' => md5($head->id)]) }}" method="post">
                        @php
                            if ($tax) {
                                $tax = (object) json_decode($tax->parameter);
                                $par = (array) $tax->par;
                                $pra = (array) $tax->pra;
                            }
                        @endphp
                        @csrf
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group mb-3">
                                    <label>Tanggal</label>
                                    <input type="date" name="tanggal" value="{{ $tax ? $tax->tanggal : old('tanggal') }}"
                                        class="form-control">
                                    @error('tanggal')
                                        <div class='small text-danger text-left'>{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <h6>PARAMETER</h6>
                        <table class="table table-bordered">
                            <thead class="h6">
                                <tr>
                                    <th class="text-center" width="3%">No.</th>
                                    <th colspan="2" class="text-center">Uraian</th>
                                    <th class="text-center">Index</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>Fungsi Bangunan <i>(If)</i></td>
                                    <td width="50%">
                                        <input type="hidden" value="{{ $tax ? $tax->if[0] : 0 }}" name="if[]"
                                            id="name-if">
                                        <select class="form-control select-field w-100" onchange="pilihNilaine(this)"
                                            name="if[]" id="if">
                                            @if ($tax)
                                                <option value="{{ $tax->if[1] }}">{{ $tax->if[0] }}</option>
                                            @else
                                                <option value="">Pilih</option>
                                            @endif
                                        </select>
                                    </td>
                                    <td class="text-center">
                                        <p id="view-if">{{ $tax ? $tax->if[2] : 0 }}</p>
                                        <input type="hidden" value="{{ $tax ? $tax->if[2] : 0 }}" name="if[]"
                                            id="index-if">
                                    </td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td>Kompleksitas<i>(Ik)</i></td>
                                    <td width="50%">
                                        <input type="hidden" value="{{ $tax ? $tax->ik[0] : 0 }}" name="ik[]"
                                            id="name-ik">
                                        <select class="form-control select-field w-100" onchange="pilihNilaine(this)"
                                            name="ik[]" id="ik">
                                            @if ($tax)
                                                <option value="{{ $tax->ik[1] }}">{{ $tax->ik[0] }}</option>
                                            @else
                                                <option value="">Pilih</option>
                                            @endif
                                        </select>
                                    </td>
                                    <td class="text-center">
                                        <p id="view-ik">{{ $tax ? $tax->ik[2] : 0 }}</p>
                                        <input type="hidden" value="{{ $tax ? $tax->ik[2] : 0 }}" name="ik[]"
                                            id="index-ik">
                                    </td>
                                </tr>
                                <tr>
                                    <td>3</td>
                                    <td>Tingkat Permanensi<i>(Ip)</i></td>
                                    <td width="50%">
                                        <input type="hidden" value="{{ $tax ? $tax->ip[0] : 0 }}" name="ip[]" id="name-ip">
                                        <select class="form-control select-field w-100" onchange="pilihNilaine(this)"
                                            name="ip[]" id="ip">
                                            @if ($tax)
                                                <option value="{{ $tax->ip[1] }}">{{ $tax->ip[0] }}</option>
                                            @else
                                                <option value="">Pilih</option>
                                            @endif
                                        </select>
                                    </td>
                                    <td class="text-center">
                                        <p id="view-ip">{{ $tax ? $tax->ip[2] : 0 }}</p>
                                        <input type="hidden" value="{{ $tax ? $tax->ip[2] : 0 }}" name="ip[]" id="index-ip">
                                    </td>
                                </tr>
                                <tr>
                                    <td>4</td>
                                    <td>Jumlah Lantai<i>(Il)</i></td>
                                    <td width="50%">
                                        <input type="hidden" value="{{ $tax ? $tax->il[0] : 0 }}" name="il[]" id="name-il">
                                        <select class="form-control select-field w-100" onchange="pilihNilaine(this)"
                                            name="il[]" id="il">
                                            @if ($tax)
                                            <option value="{{ $tax->il[1] }}">{{ $tax->il[0] }}</option>
                                        @else
                                            <option value="">Pilih</option>
                                        @endif
                                        </select>
                                    </td>
                                    <td class="text-center">
                                        <p id="view-il">{{ $tax ? $tax->il[2] : 0 }}</p>
                                        <input type="hidden" value="{{ $tax ? $tax->il[2] : 0 }}" name="il[]" id="index-il">
                                    </td>
                                </tr>
                                <tr>
                                    <td>5</td>
                                    <td>Status Kepemilikan<i>(Fm)</i></td>
                                    <td width="50%">
                                        <input type="hidden" value="{{ $tax ? $tax->fm[0] : 0 }}" name="fm[]" id="name-fm">
                                        <select class="form-control select-field w-100" onchange="pilihNilaine(this)"
                                            name="fm[]" id="fm">
                                            @if ($tax)
                                            <option value="{{ $tax->fm[1] }}">{{ $tax->fm[0] }}</option>
                                        @else
                                            <option value="">Pilih</option>
                                        @endif
                                        </select>
                                    </td>
                                    <td class="text-center">
                                        <p id="view-fm">{{ $tax ? $tax->fm[2] : 0 }}</p>
                                        <input type="hidden" value="{{ $tax ? $tax->fm[2] : 0 }}" name="fm[]" id="index-fm">
                                    </td>
                                </tr>
                                <tr>
                                    <td>6</td>
                                    <td>Indeks Terintegrasi<i>(It)</i></td>
                                    <td width="50%">
                                        <input type="text" value="{{ $tax ? $tax->it : 0 }}" class="form-control" name="it"
                                            id="it" readonly>
                                    </td>
                                    <td class="text-center">
                                        <p id="view-it"></p>
                                    </td>
                                </tr>
                                <tr>
                                    <td>7</td>
                                    <td>Indeks BG Terbangun<i>(Ibg)</i></td>
                                    <td width="50%">
                                        <input type="hidden" value="{{ $tax ? $tax->ibg[0] : 0 }}" name="ibg[]" id="name-ibg">
                                        <select class="form-control select-field w-100" onchange="pilihNilaine(this)"
                                            name="ibg[]" id="ibg">
                                            @if ($tax)
                                            <option value="{{ $tax->ibg[1] }}">{{ $tax->ibg[0] }}</option>
                                        @else
                                            <option value="">Pilih</option>
                                        @endif
                                        </select>
                                    </td>
                                    <td class="text-center">
                                        <p id="view-ibg">{{ $tax ? $tax->ibg[2] : 0 }}</p>
                                        <input type="hidden" value="{{ $tax ? $tax->ibg[2] : 0 }}" name="ibg[]" id="index-ibg">
                                    </td>
                                </tr>
                                <tr>
                                    <td>8</td>
                                    <td>Indeks Lokalitas<i>(Ilo)</i></td>
                                    <td width="50%">
                                        <input type="number" value="{{ $tax ? $tax->ilo : 0 }}" name="ilo" class="form-control w-75"
                                            id="ilo" readonly>
                                    </td>
                                    <td class="text-center">
                                        <p id="view-ilo">{{ $tax ? $tax->ilo : 0 }}</p>
                                    </td>
                                </tr>
                                <tr>
                                    <td>9</td>
                                    <td>SHST</td>
                                    <td width="50%">
                                        <input type="text" name="shst" id="shst" class="form-control">
                                    </td>
                                    <td class="text-center">
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <h6 class="my-3">PERHITUNGAN NILAI RETRIBUSI BANGUNAN GEDUNG</h6>
                        <table class="table table-bordered">
                            <thead class="h6">
                                <tr>
                                    <th class="text-center" width="3%">No.</th>
                                    <th class="text-center" width="60%">Uraian</th>
                                    <th class="text-center">Luas (m<sup>2</sup>)</th>
                                </tr>
                            </thead>
                            <tbody>
                                @for ($i = 1; $i < 11; $i++)
                                    <tr>
                                        <td>{{ $i }}</td>
                                        <td>
                                            <input type="text" class="form-control"
                                                name="par[{{ $i }}][]" value="{{$tax ? $par[$i][0] : null}}">
                                        </td>
                                        <td>
                                            <input type="number" value="{{$tax ? $par[$i][1] : 0}}" onkeyup="sumWide()"
                                                class="form-control float-input" name="par[{{ $i }}][]">
                                        </td>
                                    </tr>
                                @endfor
                                <tr class="text-end">
                                    <td colspan="2"><strong>Luas Total Bangunan <i>(LLt)</i></strong></td>
                                    <td><input type="number" id="llt" name="llt" value="{{$tax ? $tax->llt : null}}" class="form-control"
                                            readonly></td>
                                </tr>
                                <tr class="text-end">
                                    <td colspan="2">
                                        <strong>NILAI RETRIBUSI BANGUNAN GEDUNG</strong><br>
                                        <span style="font-style:italic">(It x Ibg x Ilo x SHST x LLt)</span>
                                    </td>
                                    <td class="text-end">
                                        <p id="view-retri" class="my-auto">{{$tax ? number_format($tax->retri, 0, ',','.') : null}}</p>
                                        <input type="hidden" id="retri" name="retri" value="{{$tax ? $tax->retri : null}}" class="form-control">
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <h6 class="my-3">PERHITUNGAN NILAI RETRIBUSI PRASARANA</h6>
                        <table class="table table-bordered">
                            <thead class="h6">
                                <tr>
                                    <th class="text-center" width="3%">No.</th>
                                    <th class="text-center" width="50%">Uraian</th>
                                    <th class="text-center">Volume</th>
                                    <th class="text-center">Satuan</th>
                                    <th class="text-center">Harga</th>
                                    <th class="text-center">Jumlah</th>
                                </tr>
                            </thead>
                            <tbody>
                                @for ($i = 1; $i < 11; $i++)
                                    <tr>
                                        <td>{{ $i }}</td>
                                        <td>

                                            <select class="form-control select-field ur" onchange="pilihUraian(this)"
                                                name="pra[{{ $i }}][]" data-id="{{ $i }}">
                                                @if($tax)
                                                    <option value="{{$pra[$i][0]}}">{{$pra[$i][0]}}</option>
                                                @else
                                                    <option value="">Pilih</option>
                                                @endif
                                            </select>
                                        </td>
                                        <td>
                                            <input type="number"  onkeyup="praSum(this)"
                                                data-id="{{ $i }}" class="form-control vol" value="{{$tax ? $pra[$i][1] : 0}}"
                                                name="pra[{{ $i }}][]">
                                        </td>
                                        <td>
                                            <p class="text-center my-auto" id="view-sat{{ $i }}">{{$tax ? $pra[$i][2] : null}}</p>
                                            <input type="hidden" class="form-control" id="sat{{ $i }}" value="{{$tax ? $pra[$i][2] : null}}"
                                                name="pra[{{ $i }}][]">
                                        </td>
                                        <td>
                                            <p class="text-center my-auto" id="view-price{{ $i }}">
                                                {{$tax ? number_format($pra[$i][3],0,',','.') : 0}}
                                            </p>
                                            <input type="hidden" class="form-control" id="price{{ $i }}"
                                              name="pra[{{ $i }}][]" value="{{$tax ? $pra[$i][3] : 0}}">
                                        </td>
                                        <td>
                                            <p class="text-end my-auto" id="view-sum{{ $i }}">
                                                {{$tax ? number_format($pra[$i][4],0,',','.') : 0}}
                                            </p>
                                            <input type="hidden" value="{{$tax ? $pra[$i][4] : 0}}" class="form-control sum"
                                                id="sum{{ $i }}" name="pra[{{ $i }}][]" readonly>
                                        </td>
                                    </tr>
                                @endfor
                                <tr class="text-end">
                                    <td colspan="5"><strong>NILAI RETRIBUSI PRASARANA</strong></td>
                                    <td>
                                        <p id="view-sumPra" class="my-auto text-end">{{$tax ? number_format($tax->sumPra, 0, ',','.') : 0}}</p>
                                        <input type="hidden" name="sumPra" id="sumPra" value="{{$tax ? $tax->sumPra : 0}}"  class="form-control"
                                            readonly>
                                    </td>
                                </tr>
                                <tr class="text-end">
                                    <td colspan="5">
                                        <strong>TOTAL NILAI RETRIBUSI</strong><br>
                                        (NILAI RETRIBUSI BANGUNAN GEDUNG + NILAI RETRIBUSI PRASARANA)
                                    </td>
                                    <td>
                                        <p id="view-totRetri" class="my-auto text-end">{{$tax ? number_format($tax->totRetri, 0, ',','.') : 0}}</p>
                                        <input type="hidden" name="totRetri" id="totRetri" value="{{$tax ? $tax->totRetri : 0}}" class="form-control"
                                            readonly>
                                    </td>
                                </tr>
                            </tbody>

                        </table>
                        <div class="col-md-12">
                            <button class="btn btn-primary rounded-pill">Save</button>
                        </div>
                    </form>
                </div>
            </div>

        </section>

    </div>
@endsection

@push('js')
    <script src="{{ asset('assets/extensions/jquery/jquery.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script type="text/javascript">
        const settings = {
            kompleksitas: 0.3,
            permanensi: 0.2,
            ketinggian: 0.5,
            shst: {{ $val->shst }},
            indeks_lokalitas: 0.5,
        };
    </script>

    <script src="{{ asset('assets/tax.js') }}"></script>
@endpush
