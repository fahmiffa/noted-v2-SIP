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
                            <h5 class="card-title">Data {{ $data }}</h5>
                        </div>
                    </div>
                </div>
                <div class="card-body">

                    <p>
                        <span class="badge bg-success"><i class="bi bi-file-pdf"></i></span>
                        &nbsp;
                        Dokumen diisetujui atau diterima
                    </p>
                    <p>
                        <span class="badge bg-primary"><i class="bi bi-vector-pen text-white"></i></span>
                        &nbsp;
                        Tanda Tangan Dokumen
                    </p>
                    <p>
                        <span class="badge bg-dark"><i class="bi bi-archive"></i></span>
                        &nbsp;
                        Dokumen Draft
                    </p>
                    <p>
                        <span class="badge bg-primary"><i class="bi bi-send text-white"></i></span>
                        &nbsp;
                        Submit Dokumen
                    </p>

                    <div class="table-responsive">
                        <table class="table table-bordered" id="table1">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>No. Registrasi</th>
                                    <th>Pemohon</th>
                                    <th>Bangunan</th>
                                    <th>Lokasi</th>
                                    <th>No. Dokumen</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($da as $item)
                                    @php
                                        $header = (array) json_decode($item->doc->header);
                                    @endphp
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>
                                            {{ $item->doc->reg }}
                                        </td>
                                        <td>
                                            <h6 class="mb-0">Nama</h6>{{ $header ? $header[2] : null }}      
                                            <h6 class="mb-0">Alamat</h6>
                                            {{ $item->doc->region ? $item->doc->region->name.', ' : null }} {!! $item->doc->region ? $item->doc->region->kecamatan->name.'<br>' : null !!} {{ $header ? $header[4] : null }}                                                                                
                                        </td>
                                        <td>
                                            {{ $header ? $header[5] : null }}
                                        </td>
                                        <td>
                                            {{ $header ? $header[7] : null }}
                                        </td>
                                        <td>
                                            {{ $item->doc->nomor }}
                                        </td>
                                        <td>
                                            <div class="d-flex justify-content-between">
                                                @if ($item->barp)
                                                    @if ($item->barp->status == 2)
                                                        <a class="btn btn-{{ $item->barp->status == 2 ? 'dark' : 'success' }} btn-sm"
                                                            href="{{ route('step.meet', ['id' => md5($item->head)]) }}"
                                                            data-toggle="tooltip" data-placement="top"
                                                            title="Dokumen Draft">
                                                            <i class="bi bi-archive"></i>
                                                        </a>
                                                        <button data-toggle="tooltip" data-placement="top"
                                                            title="Tanda Tangan Dokumen"
                                                            onclick="location.href='{{ route('sign.meet', ['id' => md5($item->doc->barp->id)]) }}'"
                                                            class="btn btn-primary btn-sm mx-2"><i
                                                                class="bi bi-vector-pen"></i></button>
                                                    @endif

                                                    <a class="btn {{ $item->barp->grant == 1 ? 'btn-success' : 'btn-danger' }} btn-sm"
                                                        target="_blank"
                                                        href="{{ route('doc.meet', ['id' => md5($item->barp->id)]) }}"
                                                        data-toggle="tooltip" data-placement="top" title="PDF Dokumen">
                                                        <i class="bi bi-file-pdf"></i>
                                                    </a>
                                                @else
                                                    @if ($item->barp && $item->barp->grant == 1)
                                                        <button data-toggle="tooltip" data-placement="top"
                                                            title="Dokumen terlah diverifikasi"
                                                            class="btn btn-success btn-sm"><i
                                                                class="bi bi-check"></i></button>
                                                        <a class="btn btn-danger btn-sm" target="_blank"
                                                            href="{{ route('doc.news', ['id' => md5($item->doc->bak->id)]) }}"
                                                            data-toggle="tooltip" data-placement="top" title="PDF Dokumen">
                                                            <i class="bi bi-file-pdf"></i>
                                                        </a>
                                                    @else
                                                        <a class="btn btn-primary btn-sm"
                                                            href="{{ route('step.meet', ['id' => md5($item->head)]) }}"
                                                            data-toggle="tooltip" data-placement="top"
                                                            title="Submit Dokumen">
                                                            <i class="bi bi-send"></i>
                                                        </a>
                                                        @if ($item->doc->barpTemp && $item->doc->barpTemp->count() > 0)
                                                            <button class="btn btn-warning btn-sm" data-toggle="tooltip"
                                                                data-placement="top" title="Dokumen di tolak verifikasi"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#des{{ $item->id }}">
                                                                <i class="bi bi-arrow-repeat"></i>
                                                            </button>
                                                        @endif
                                                    @endif
                                                @endif
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
                @if ($item->doc->barpTemp && $item->doc->barpTemp->count() > 0)
                    <div class="modal fade" id="des{{ $item->id }}" data-bs-backdrop="static" data-bs-keyboard="false"
                        tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="staticBackdropLabel{{ $item->id }}">Catatan Dokumen
                                        Ini di tolak</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <ul>
                                        @foreach ($item->doc->barpTemp as $val)
                                            <li>{{ $val->reason }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
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
@endpush
