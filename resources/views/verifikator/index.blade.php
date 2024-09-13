@extends('layout.base')
@push('css')
    <link rel="stylesheet" href="{{ asset('assets/extensions/datatables.net-bs5/css/dataTables.bootstrap5.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/compiled/css/table-datatable-jquery.css') }}">
@endpush
@section('main')
    <div class="page-heading">

        <!-- Basic Tables start -->
        <section class="section">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between py-3">
                        <div class="p-2">
                            <h5 class="card-title">Task {{ $data }}</h5>
                        </div>
                        <div class="p-2">
                        </div>
                    </div>
                </div>
                <div class="card-body">
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
                                    @if ($item->task)
                                        @php
                                            $header = (array) json_decode($item->header);
                                        @endphp
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>                                        
                                                {{ $item->reg }}                                        
                                            </td>
                                            <td>
                                                <h6 class="mb-0">Nama</h6>
                                                {{ $header ? $header[2] : null }}
                                                <h6 class="mb-0">Alamat</h6>
                                                {{ $item->region ? $item->region->name : null }}, {{ $item->region ? $item->region->kecamatan->name : null }}, <br>{{ $header ? $header[4] : null }}                                       
                                            </td>
                                            <td>                                           
                                                {{ $header ? $header[5] : null }}
                                            </td>
                                            <td>                                           
                                                {{ $header ? $header[7] : null }}
                                            </td>
                                            <td>                                       
                                                {{$item->nomor}} 
                                            </td>
                                            <td class="d-flex jusstify-content-between align-items-center my-auto" style="height: 100px">
                                                @if ($item->head->count() > 0)
                                                    <button class="btn btn-warning btn-sm" data-toggle="tooltip"
                                                        data-placement="top" title="Dokumen di tolak verifikasi" data-bs-toggle="modal" data-bs-target="#des{{ $item->id }}">
                                                        <i class="bi bi-arrow-repeat"></i>
                                                    </button>
                                                @endif
                                                
                                                @if ($item->status == 1)
                                                    <a target="_blank"
                                                        href="{{ route('doc.verifikator', ['id' => md5($item->id)]) }}"
                                                        class="btn btn-sm btn-danger mx-2"><i class="bi bi-file-pdf"></i></a>
                                                    @if ($item->grant == 1)
                                                        <button class="btn btn-success btn-sm" data-toggle="tooltip"
                                                        data-placement="top" title="Dokumen di terima verifikasi">
                                                            <i class="bi bi-check-lg"></i>
                                                        </button>
                                                    @else
                                                        
                                                        <a href="{{ route('step.verifikasi', ['id' => md5($item->id)]) }}" data-toggle="tooltip"
                                                        data-placement="top" title="Form Dokumen verifikasi"
                                                            class="btn btn-sm btn-primary"><i class="bi bi-files"></i></a>
                                                    @endif
                                                @else
                                                    @if ($item->step == 2)
                                                        <a href="{{ route('step.verifikasi', ['id' => md5($item->id)]) }}"
                                                            class="btn btn-sm btn-primary"><i class="bi bi-files"></i></a>
                                                    @else
                                                        <a href="{{ route('step.verifikasi', ['id' => md5($item->id)]) }}"
                                                            class="btn btn-sm btn-primary"><i class="bi bi-files"></i></a>
                                                    @endif
                                                @endif
                                            </td>
                                        </tr>
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            @foreach ($da as $item)
                @if ($item->head->count() > 0)
                    <div class="modal fade" id="des{{ $item->id }}" data-bs-backdrop="static" data-bs-keyboard="false"
                        tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="staticBackdropLabel{{ $item->id }}">Dokumen Ini di tolak
                                        verifikasi
                                    </h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <ul>
                                        @if($item->parents)
                                        <li>{{ $item->parents->note }}</li>
                                        @endif
                                        @foreach ($item->parents->tmp->whereNotNull('deleted_at') as $val)
                                        <li>{{ $val->note }}</li>
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
        <!-- Basic Tables end -->

    </div>
@endsection

@push('js')
    <script src="{{ asset('assets/extensions/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/extensions/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/extensions/datatables.net-bs5/js/dataTables.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('assets/static/js/pages/datatables.js') }}"></script>
@endpush
