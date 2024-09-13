@extends('layout.base')
@push('css')
    <link rel="stylesheet" href="{{ asset('assets/extensions/datatables.net-bs5/css/dataTables.bootstrap5.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/compiled/css/table-datatable-jquery.css') }}">
@endpush
@section('main')
    <div class="page-heading">
        <section class="section">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between">
                        <div class="p-1">
                            <h5 class="card-title">{{ $data }}</h5>
                        </div>
                        <div class="p-1">
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="table1">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Nomor</th>
                                    <th>Pemohon</th>
                                    <th>Data</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($da as $item)
                                    @php
                                        $header = (array) json_decode($item->doc->header);
                                        $items = json_decode($item->header);
                                    @endphp
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>
                                            <h6 class="mb-0">Registrasi</h6>
                                            {{ $item->doc->reg }}
                                            <h6 class="mb-0">Dokumen</h6>
                                            {{ $item->doc->nomor }}
                                        </td>
                                        <td>
                                            {{ $header ? $header[2] : null }}<br>
                                            <h6 class="mb-0">Alamat</h6>
                                            {{ $item->doc->region ? $item->doc->region->name : null }},{{ $item->doc->region ? $item->doc->region->kecamatan->name : null }},{{ $header ? $header[4] : null }}
                                            <hr>
                                            <h6 class="mb-0">Bangunan</h6>
                                            {{ $header[5] }}<br>
                                            <h6 class="mb-0">Lokasi</h6>
                                            {{ $header[7] }} Kec. {{ $item->doc->region->name }},
                                            Kab.{{ $item->doc->region->kecamatan->name }} <br>
                                            <h6 class="mb-0">Fungsi</h6>
                                            {{ $header[6] }}
                                        </td>
                                        <td>
                                            <h6 class="mb-0">Jenis</h6>
                                            {{ ucwords(str_replace('_', ' ', $items->jenis)) }}
                                            <h6 class="mb-0">Status</h6>
                                            {{ ucwords(str_replace('_', ' ', $items->status)) }}
                                            <h6 class="mb-0">Fungsi</h6>
                                            {{ ucwords(str_replace('_', ' ', $items->fungsi)) }}
                                        </td>
                                        <td>
                                            <div class="d-flex justify-content-between">
                                                @if ($item->grant == 0)
                                                    @if ($item->primary == 'TPT')
                                                        <button data-toggle="tooltip" data-placement="top"
                                                            title="Tanda Tangan Dokumen" type="button"
                                                            data-id="{{$item->id}}"
                                                            class="btn btn-primary btn-sm mx-2 signs">
                                                            <i class="bi bi-vector-pen"></i>
                                                        </button>
                                                    @else
                                                        <button type="button" class="btn btn-info btn-sm"
                                                            data-bs-toggle="modal" data-toggle="tooltip"
                                                            data-placement="top" title="Dokumen Belum diverifikasi"
                                                            data-bs-target="#ver{{ $item->id }}">
                                                            <i class="bi bi-info"></i>
                                                        </button>
                                                    @endif
                                                @else
                                                    <button type="button" class="btn btn-success btn-sm"
                                                        data-toggle="tooltip" data-placement="top"
                                                        title="Dokumen telah diverifikasi"><i
                                                            class="bi bi-check-lg"></i></button>
                                                @endif

                                                <a target="_blank" href="{{ route('barp.doc', ['id' => md5($item->id)]) }}"
                                                    data-toggle="tooltip" data-placement="top" title="Dokumen PDF"
                                                    class="btn btn-sm btn-danger"><i class="bi bi-file-pdf"></i></a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            @foreach ($da as $item)
                @php
                    $header = json_decode($item->doc->header);
                    $items = json_decode($item->header);
                @endphp
                <div class="modal fade" id="ver{{ $item->id }}" data-bs-backdrop="static" data-bs-keyboard="false"
                    tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="staticBackdropLabel{{ $item->id }}">Verifikasi Dokumen</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form action="{{ route('approve.barp', ['id' => md5($item->id)]) }}" method="post">
                                    @csrf
                                    <p>Anda akan menerima dokumen ini ?
                                    <p>
                                        <button class="btn btn-success rounded-pill">Diterima</button>
                                        <button type="button" class="btn btn-danger rounded-pill" data-bs-toggle="modal"
                                            data-bs-target="#re{{ $item->id }}">Ditolak</button>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal fade" id="re{{ $item->id }}" data-bs-backdrop="static" data-bs-keyboard="false"
                    tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="staticBackdropLabel{{ $item->id }}">Menolak Verifikasi
                                    Dokumen</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form action="{{ route('reject.barp', ['id' => md5($item->id)]) }}" method="post">
                                    @csrf
                                    <p class="mb-3">Anda akan menolak dokumen ini ?
                                    <p>
                                        <label>Catatan : </label>
                                        <textarea class="form-control" name="noted" required></textarea>
                                        <button class="btn btn-success rounded-pill mt-3">Submit</button>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal fade sign" id="signature{{$item->id}}" data-bs-backdrop="static" data-bs-keyboard="false"
                    tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="staticBackdropLabel">Tanda Tangan</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form action="{{ route('approve.barp', ['id' => md5($item->id)]) }}" method="post">
                                    @csrf
                                    <canvas class="border border-light mx-auto d-block canvas" width="450"
                                        height="200"></canvas>
                                    <button type="button" id="clear"
                                        class="btn btn-dark btn-sm my-3 rounded-pill">Clear</button>
                                    <input type="hidden" name="sign">
    
                                    <button type="submit" class="btn btn-success rounded-pill btn-sm save">Submit</button>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary rounded-pill"
                                    data-bs-dismiss="modal">Close</button>
                                <button type="button" class="btn btn-danger rounded-pill" data-bs-toggle="modal"
                                    data-bs-target="#re{{$item->id}}">Ditolak</button>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach


        </section>
    </div>
@endsection

@push('js')
    <script src="{{ asset('assets/extensions/jquery/jquery.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/signature_pad"></script>
    <script src="{{ asset('assets/extensions/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/extensions/datatables.net-bs5/js/dataTables.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('assets/static/js/pages/datatables.js') }}"></script>

    <script>
        $(document).ready(function() {

            const canvas = document.querySelector("canvas");
            var signaturePad = new SignaturePad(canvas);

            $('.signs').on('click', function() {
                var id = $(this).attr('data-id');
                $('#signature'+id).modal('show');
                signaturePad.clear();
            });



            $('#clear').on('click', function() {
                signaturePad.clear();
            });

            $('.save').on('click', function(e) {
                if (signaturePad.isEmpty()) {
                    alert("Please provide a signature first.");
                    e.preventDefault();
                } else {
                    var signatureData = signaturePad.toDataURL();
                    $('input[name="sign"]').attr('value', signatureData);
                }
            });

        });
    </script>
@endpush
