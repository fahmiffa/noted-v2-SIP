@extends('layout.base')
@push('css')
<link rel="stylesheet" href="{{asset('assets/extensions/datatables.net-bs5/css/dataTables.bootstrap5.min.css')}}">
<link rel="stylesheet" href="{{asset('assets/compiled/css/table-datatable-jquery.css')}}">
@endpush
@section('main')
<div class="page-heading">
    <section class="section">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between">
                    <div class="p-1">
                        <h5 class="card-title">{{$data}}</h5>
                    </div>
                    <div class="p-1">
                    </div>
                </div>
            </div>
            <div class="card-body p-5">
                <div class="table-responsive">
                    <table class="table table-bordered" id="table1">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>No Registrasi</th>
                                <th>Pemohon</th>
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
                                    <td>{{ $item->reg }}</td>
                                    <td>
                                        {{ $header ? $header[2] : null }}<br>
                                        Alamat  :    {{ $item->region ? $item->region->name : null }},{{ $item->region ? $item->region->kecamatan->name : null }},{{ $header ? $header[4] : null }}<br>
                                        Bangunan :  {{ $header ? $header[5] : null }}<br>
                                        Lokasi : {{ $header ? $header[7] : null }}
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-dark btn-sm" data-toggle="tooltip" data-placement="top" title="Dokumen Detail"
                                            data-bs-toggle="modal" data-bs-target="#det{{ $item->id }}">
                                            <i class="bi bi-eye"></i>
                                        </button>
                                      <a target="_blank" href="{{ route('req.doc', ['id'=>md5($item->id)]) }}" class="btn btn-sm btn-danger"><i class="bi bi-file-pdf"></i></a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </diV>
        </div>

        @foreach($da as $item)

        @php
          $header = json_decode($item->header);
        @endphp
        <div class="modal fade" id="det{{ $item->id }}" data-bs-backdrop="static" data-bs-keyboard="false"
            tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel{{ $item->id }}">Dokumen {{$item->nomor}}
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                       <div class="container">
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
                             <div class="col-md-3 col-6">Nama Pemohon</div>
                             <div class="col-md-8 col-6">: {{ $header ? $header[2] : null }}</div>
                             <div class="col-md-3 col-6">Alamat Pemohon</div>
                             <div class="col-md-8 col-6">: {{ $item->region ? $item->region->name : null }},
                               {{ $item->region ? $item->region->kecamatan->name : null }},
                               {{ $header ? $header[4] : null }}</div>
                               <div class="col-md-3 col-6">Nama Bangunan</div>
                               <div class="col-md-8 col-6">: {{ $header ? $header[5] : null }}</div>
                               <div class="col-md-3 col-6">Lokasi Bangunan</div>
                               <div class="col-md-8 col-6">: {{ $header ? $header[7] : null }}</div>
                               <div class="col-md-3 col-6">Fungsi</div>
                               <div class="col-md-8 col-6">: {{ $header[6] }}</div>
                               @if($item->bak)
                               <div class="col-md-3 col-6">Tahun Pembangunan</div>
                               <div class="col-md-8 col-6">: {{ $item->bak->plan }}</div>
                               @endif
                           </div>
                             @if ($item->head->count() > 0)
                             <h6>Dokumen Perbaikan</h6>
                               <div class="row mb-3 mx-3">
                                 <ol>
                                   @foreach ($item->head as $val)
                                   <li>{{ $val->reg }} ({{ $val->nomor }})
                                     <a target="_blank" href="{{ route('doc.verifikasi', ['id' => md5($val->id)]) }}"
                                       class="btn btn-sm btn-danger"><i class="bi bi-file-pdf"></i></a>
                                     </li>
                                     @endforeach
                                 </ol>
                               </div>
                              @endif
                       </div>
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
<script src="{{asset('assets/extensions/jquery/jquery.min.js')}}"></script>
<script src="{{asset('assets/extensions/datatables.net/js/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('assets/extensions/datatables.net-bs5/js/dataTables.bootstrap5.min.js')}}"></script>
<script src="{{asset('assets/static/js/pages/datatables.js')}}"></script>
@endpush
