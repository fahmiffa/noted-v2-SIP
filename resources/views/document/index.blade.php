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
                        <div class="p-1 d-flex justify-content-between">    
                            <a href="{{ route('verifikasi.create') }}" class="btn btn-primary btn-sm">Tambah
                            {{ $data }}</a>
                        </div>
                    </div>
                </div>
                <div class="card-body p-5">

                        <p>
                            <span class="badge bg-success"><i class="bi bi-check"></i></span>
                            &nbsp;
                            Dokumen diisetujui atau diterima
                        </p>
                        <p>
                            <span class="badge bg-warning"><i class="bi bi-eye text-dark"></i></span>
                            &nbsp;
                            Riwayat & Detail Dokumen Pemohon
                        </p>
                        <p>
                            <span class="badge bg-dark"><i class="bi bi-eye"></i></span>
                            &nbsp;
                            Detail Dokumen Pemohon
                        </p>
                        <p>
                            <span class="badge bg-primary"><i class="bi bi-pencil"></i></span>
                            &nbsp;
                            Edit Dokumen
                        </p>
                        <p>
                            <span class="badge bg-danger"><i class="bi bi-trash"></i></span>
                            &nbsp;
                            Hapus Dokumen
                        </p>                            
                        <p>
                            <span class="badge bg-warning">
                                <i class="bi bi-exclamation-triangle-fill text-dark"></i>
                            </span>
                            &nbsp;
                            Dokumen Sedang di proses (Verifikasi 2 Tahap)
                        </p>
                        <p>
                            <span class="badge bg-info">
                                <i class="bi bi-info text-dark"></i>
                            </span>
                            &nbsp;
                            Verifikasi Dokumen
                        </p>    
                    <div class="table-responsive">
                        <table class="table table-bordered" id="table1" style="width:100%">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>No. Registrasi</th>
                                    <th>Pemohon</th>
                                    <th>Bangunan</th>
                                    <th>Lokasi</th>
                                    <th>No. Dokumen</th>
                                    <th>Tanggal</th>
                                    <th>Status</th>
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
                                            {{ $header ? $header[2] : null }}                                
                                        </td>
                                        <td>                            
                                            {{ $header ? $header[5] : null }}
                                    
                                        </td>
                                        <td>                                    
                                            {{ $item->region ? $item->region->name : null }}, {{ $item->region ? $item->region->kecamatan->name : null }}, <br>{{ $header ? $header[4] : null }}                            
                                        </td>
                                        <td>                          
                                            {{$item->nomor}}
                                        </td>
                                        <td>                          
                                            @if ($item->tang)
                                            {{ date('d-m-Y', strtotime($item->tang)) }}
                                        @endif
                                        </td>
                                        <td>
                                           {{$item->dokumen}}
                                        </td>
                                       
                                        <td class="d-flex jusstify-content-between align-items-center"
                                            style="height: 100px">                  

                                            @if ($item->status == 5)
                                                <a href="{{ route('verifikasi.edit', $item->id) }}" data-toggle="tooltip"
                                                    data-placement="top" title="Edit Dokumen"
                                                    class="btn btn-sm btn-primary"><i class="bi bi-pencil"></i></a>
                                                <form onsubmit="return confirm('Apakah Anda Yakin Menghapus ?');"
                                                    action="{{ route('verifikasi.destroy', $item->id) }}" method="POST">
                                                    @method('DELETE')
                                                    @csrf
                                                    <button type="submit" class="btn btn-sm btn-danger mx-2"
                                                        data-toggle="tooltip" data-placement="top" title="Hapus Dokumen">
                                                        <i class="bi bi-trash"></i></button>
                                                </form>
                                            @endif

                                            @if ($item->status > 1 && $item->status != 5)
                                                <button type="button"
                                                    class="btn btn-warning btn-sm"
                                                    data-toggle="tooltip" data-placement="top" title="Dokumen Process">
                                                    <i class="bi bi-exclamation-triangle-fill"></i>
                                                </button>
                                                &nbsp;
                                            @endif

                                            @if ($item->status == 1)                               

                                                @if ($item->grant == 0)
                                                    <button type="button" class="btn btn-info btn-sm mx-2"
                                                        data-toggle="tooltip" data-placement="top"
                                                        title="Dokumen belum diverifikasi" data-bs-toggle="modal"
                                                        data-bs-target="#ver{{ $item->id }}">
                                                        <i class="bi bi-info"></i>
                                                    </button>
                                                @else
                                                    <button type="button" class="btn btn-success btn-sm mx-2"
                                                        data-toggle="tooltip" data-placement="top"
                                                        title="Dokumen telah diverifikasi"><i
                                                            class="bi bi-check-lg"></i></button>
                                                @endif
                                            @endif

                                            <button type="button"
                                                class="btn {{ $item->head->count() > 0 ? 'btn-warning' : 'btn-dark' }} btn-sm"
                                                data-toggle="tooltip" data-placement="top" title="Dokumen Detail"
                                                data-bs-toggle="modal" data-bs-target="#det{{ $item->id }}">
                                                <i class="bi bi-eye"></i>
                                            </button>

                                            @if($item->status != 5)                                                
                                                @php
                                                if($item->grant == 1)
                                                {
                                                    $links = $item->links->where('ket','verifikasi')->values();
                                                    $new = asset('storage/'.$links[0]->files);
                                                }
                                                $old = route('doc.verifikasi', ['id' => md5($item->id)]);
                                                @endphp
                                                <a target="_blank" data-toggle="tooltip" data-placement="top" title="Dokumen PDF"
                                                                href="{{ $item->grant == 1 ? $new : $old }}"
                                                                class="btn btn-sm btn-danger mx-2"><i class="bi bi-file-pdf"></i></a>
                                            @endif
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
                    $header = (array) json_decode($item->header);
                @endphp
                <div class="modal fade" id="det{{ $item->id }}" data-bs-backdrop="static" data-bs-keyboard="false"
                    tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="staticBackdropLabel{{ $item->id }}">Dokumen
                                    {{ $item->nomor }}
                                </h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="row mb-3">
                                    <div class="col-4 ">
                                        <h6>Task</h6>
                                        {{ $item->step }} Tahap
                                    </div>
                                    <div class="col-4 ">
                                        <h6>Verifikator</h6>
                                        &#9632; {!! ucfirst(implode('<br>&#9632; ', $item->verif)) !!}
                                    </div>
                                    <div class="col-4 ">
                                        <h6>Tipe</h6>
                                        {{ ucfirst($item->type) }}
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-3 col-6 fw-bold">Nama Pemohon</div>
                                    <div class="col-md-8 col-6">{{ $header ? $header[2] : null }}</div>
                                    <div class="col-md-3 col-6 fw-bold">Alamat Pemohon</div>
                                    <div class="col-md-8 col-6">{{ $item->region ? $item->region->name : null }},
                                        {{ $item->region ? $item->region->kecamatan->name : null }},
                                        {{ $header ? $header[4] : null }}
                                    </div>
                                    <div class="col-md-3 col-6 fw-bold">Nama Bangunan</div>
                                    <div class="col-md-8 col-6">{{ $header ? $header[5] : null }}</div>
                                    <div class="col-md-3 col-6 fw-bold">Lokasi Bangunan</div>
                                    <div class="col-md-8 col-6">{{ $header ? $header[7] : null }}</div>
                                </div>
                                @if ($item->head->count() > 0)
                                    <h6>Dokumen Perbaikan</h6>
                                    <ul>
                                        @if($item->parents)
                                        <li>{{ $item->parents->reg }} ({{ $item->parents->nomor }}) <a target="_blank"
                                                href="{{ route('doc.verifikasi', ['id' => md5($item->parents->id)]) }}"
                                                class="btn btn-sm btn-danger mb-2"><i class="bi bi-file-pdf"></i></a>
                                            ({{ $item->parents->note }})
                                        </li>
                                        @endif                      
                                        @foreach ($item->parents->tmp->whereNotNull('deleted_at') as $val)
                                            <li>{{ $val->reg }} ({{ $val->nomor }}) <a target="_blank"
                                                    href="{{ route('doc.verifikasi', ['id' => md5($val->id)]) }}"
                                                    class="btn btn-sm btn-danger mb-2"><i class="bi bi-file-pdf"></i></a>
                                                ({{ $val->note }})
                                            </li>
                                        @endforeach
                                    </ul>
                                @endif
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal fade" id="ver{{ $item->id }}" data-bs-backdrop="static" data-bs-keyboard="false"
                    tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="staticBackdropLabel{{ $item->id }}">Verifikasi Dokumen
                                </h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form action="{{ route('doc.approve', ['id' => md5($item->id)]) }}" method="post">
                                    @csrf
                                    <p>Anda akan menerima dokumen ini dan melanjutkan ke Penunjukan TPA/TPT ?
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
                                <form action="{{ route('doc.reject', ['id' => md5($item->id)]) }}" method="post">
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
            @endforeach
        </section>
    </div>
@endsection

@push('js')
    <script src="{{ asset('assets/extensions/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/extensions/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/extensions/datatables.net-bs5/js/dataTables.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('assets/static/js/pages/datatables.js') }}"></script>
@endpush
