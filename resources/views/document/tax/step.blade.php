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
                    <h5 class="card-title">Perhitungan Retribusi</h5>
                    <div class="divider">
                        <div class="divider-text">{{ $data }}</div>
                    </div>
                    @include('document.pemohon')                  
                </div>

                <div class="card-body">

                    <form action="{{ route('tax.store', ['id' => md5($head->id)]) }}" method="post"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group mb-3">
                                    <label>Tanggal</label>
                                    <input type="date" name="tanggal" value="{{ old('tanggal') }}" class="form-control">
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
                                        <input type="hidden" value="0" name="if[]" id="name-if">
                                        <select class="form-control select-field w-100" onchange="pilihNilaine(this)"
                                            name="if[]" id="if">
                                            <option value="">Pilih</option>
                                        </select>
                                    </td>
                                    <td class="text-center">
                                        <p id="view-if"></p>
                                        <input type="hidden" value="0" name="if[]" id="index-if">
                                    </td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td>Kompleksitas<i>(Ik)</i></td>
                                    <td width="50%">
                                        <input type="hidden" value="0" name="ik[]" id="name-ik">
                                        <select class="form-control select-field w-100" onchange="pilihNilaine(this)"
                                            name="ik[]" id="ik">
                                            <option value="">Pilih</option>
                                        </select>
                                    </td>
                                    <td class="text-center">
                                        <p id="view-ik"></p>
                                        <input type="hidden" value="0" name="ik[]" id="index-ik">
                                    </td>
                                </tr>
                                <tr>
                                    <td>3</td>
                                    <td>Tingkat Permanensi<i>(Ip)</i></td>
                                    <td width="50%">
                                        <input type="hidden" value="0" name="ip[]" id="name-ip">
                                        <select class="form-control select-field w-100" onchange="pilihNilaine(this)"
                                            name="ip[]" id="ip">
                                            <option value="">Pilih</option>
                                        </select>
                                    </td>
                                    <td class="text-center">
                                        <p id="view-ip"></p>
                                        <input type="hidden" value="0" name="ip[]" id="index-ip">
                                    </td>
                                </tr>
                                <tr>
                                    <td>4</td>
                                    <td>Jumlah Lantai<i>(Il)</i></td>
                                    <td width="50%">
                                        <input type="hidden" value="0" name="il[]" id="name-il">
                                        <select class="form-control select-field w-100" onchange="pilihNilaine(this)"
                                            name="il[]" id="il">
                                            <option value="">Pilih</option>
                                        </select>
                                    </td>
                                    <td class="text-center">
                                        <p id="view-il"></p>
                                        <input type="hidden" value="0" name="il[]" id="index-il">
                                    </td>
                                </tr>
                                <tr>
                                    <td>5</td>
                                    <td>Status Kepemilikan<i>(Fm)</i></td>
                                    <td width="50%">
                                        <input type="hidden" value="0" name="fm[]" id="name-fm">
                                        <select class="form-control select-field w-100" onchange="pilihNilaine(this)"
                                            name="fm[]" id="fm">
                                            <option value="">Pilih</option>
                                        </select>
                                    </td>
                                    <td class="text-center">
                                        <p id="view-fm"></p>
                                        <input type="hidden" value="0" name="fm[]" id="index-fm">
                                    </td>
                                </tr>
                                <tr>
                                    <td>6</td>
                                    <td>Indeks Terintegrasi<i>(It)</i></td>
                                    <td width="50%">
                                        <input type="text" value="0" class="form-control" name="it"
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
                                        <input type="hidden" value="0" name="ibg[]" id="name-ibg">
                                        <select class="form-control select-field w-100" onchange="pilihNilaine(this)"
                                            name="ibg[]" id="ibg">
                                            <option value="">Pilih</option>
                                        </select>
                                    </td>
                                    <td class="text-center">
                                        <p id="view-ibg"></p>
                                        <input type="hidden" value="0" name="ibg[]" id="index-ibg">
                                    </td>
                                </tr>
                                <tr>
                                    <td>8</td>
                                    <td>Indeks Lokalitas<i>(Ilo)</i></td>
                                    <td width="50%">
                                        <input type="number" value="0" name="ilo" class="form-control w-75"
                                            id="ilo" readonly>
                                    </td>
                                    <td class="text-center">
                                        <p id="view-ilo"></p>
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
                                                name="par[{{ $i }}][]">
                                        </td>
                                        <td>
                                            <input type="number" value="0" onkeyup="sumWide()"
                                                class="form-control float-input" name="par[{{ $i }}][]">
                                        </td>
                                    </tr>
                                @endfor
                                <tr class="text-end">
                                    <td colspan="2"><strong>Luas Total Bangunan <i>(LLt)</i></strong></td>
                                    <td><input type="number" id="llt" name="llt" class="form-control"
                                            readonly></td>
                                </tr>
                                <tr class="text-end">
                                    <td colspan="2">
                                        <strong>NILAI RETRIBUSI BANGUNAN GEDUNG</strong><br>
                                        <span style="font-style:italic">(It x Ibg x Ilo x SHST x LLt)</span>
                                    </td>
                                    <td class="text-end">
                                        <p id="view-retri" class="my-auto"></p>
                                        <input type="hidden" id="retri" name="retri" class="form-control">
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
                                                <option value="">Pilih</option>
                                            </select>
                                        </td>
                                        <td>
                                            <input type="number" value="0" onkeyup="praSum(this)"
                                                data-id="{{ $i }}" class="form-control vol"
                                                name="pra[{{ $i }}][]">
                                        </td>
                                        <td>
                                            <p class="text-center my-auto" id="view-sat{{ $i }}"></p>
                                            <input type="hidden" class="form-control" id="sat{{ $i }}"
                                                name="pra[{{ $i }}][]">
                                        </td>
                                        <td>
                                            <p class="text-center my-auto" id="view-price{{ $i }}">
                                            </p>
                                            <input type="hidden" class="form-control" id="price{{ $i }}"
                                                value="0" name="pra[{{ $i }}][]">
                                        </td>
                                        <td>
                                            <p class="text-end my-auto" id="view-sum{{ $i }}">
                                            </p>
                                            <input type="hidden" value="0" class="form-control sum"
                                                id="sum{{ $i }}" name="pra[{{ $i }}][]" readonly>
                                        </td>
                                    </tr>
                                @endfor
                                <tr class="text-end">
                                    <td colspan="5"><strong>NILAI RETRIBUSI PRASARANA</strong></td>
                                    <td>
                                        <p id="view-sumPra" class="my-auto text-end"></p>
                                        <input type="hidden" name="sumPra" id="sumPra" class="form-control"
                                            readonly>
                                    </td>
                                </tr>
                                <tr class="text-end">
                                    <td colspan="5">
                                        <strong>TOTAL NILAI RETRIBUSI</strong><br>
                                        (NILAI RETRIBUSI BANGUNAN GEDUNG + NILAI RETRIBUSI PRASARANA)
                                    </td>
                                    <td>
                                        <p id="view-totRetri" class="my-auto text-end"></p>
                                        <input type="hidden" name="totRetri" id="totRetri" class="form-control"
                                            readonly>
                                    </td>
                                </tr>
                            </tbody>

                        </table>
                        <div class="col-md-12">
                            <button class="btn btn-primary rounded-pill">Save</button>
                            <a class="btn btn-danger ms-1 rounded-pill" href="{{ route('tax.index') }}">Back</a>
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
            shst: {{$val->shst}},
            indeks_lokalitas: 0.5,
        };  
    </script>

<script src="{{ asset('assets/tax.js') }}"></script>
@endpush
