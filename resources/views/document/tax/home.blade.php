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
                                        $header = (array) json_decode($item->header);
                                    @endphp
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>
                                            {{ $item->reg }}
                                        </td>
                                        <td>
                                            <h6 class="mb-0">Nama</h6>{{ $header ? $header[2] : null }}      
                                            <h6 class="mb-0">Alamat</h6>
                                            {{ $item->region ? $item->region->name.', ' : null }} {!! $item->region ? $item->region->kecamatan->name.'<br>' : null !!} {{ $header ? $header[4] : null }}       
                                        </td>      
                                        <td>
                                            {{ $header ? $header[5] : null }}
                                        </td>
                                        <td>
                                            {{ $header ? $header[7] : null }}
                                        </td>                                
                                        <td>{{ $item->nomor }}</td>
                                        <td>
                                            @if ($item->tax)                      
                                                <a target="_blank" href="{{ route('doc.tax', ['id' => md5($item->id)]) }}"
                                                    class="btn btn-sm btn-danger"><i class="bi bi-file-pdf"></i></a>
                                            @else                                    
                                                <a class="btn btn-primary btn-sm"
                                                    href="{{ route('step.tax', ['id' => md5($item->id)]) }}"
                                                    data-toggle="tooltip" data-placement="top" title="Submit Dokumen">
                                                    <i class="bi bi-send"></i>
                                                </a>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </section>
    </div>
@endsection

@push('js')
    <script src="{{ asset('assets/extensions/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/extensions/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/extensions/datatables.net-bs5/js/dataTables.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('assets/static/js/pages/datatables.js') }}"></script>
@endpush
