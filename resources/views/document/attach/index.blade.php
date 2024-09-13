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
                        <button onclick="location.href='{{route('attach.create')}}'" class="btn btn-primary btn-sm rounded-pill">Tambah</button>
                    </div>
                </div>       
            </div>
            {{-- <div class="card-body">                   
               <div class="px-1">
                <form action="{{route('verifikasi.index')}}" method="get">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">               
                                <input type="text" class="form-control" name="key" placeholder="Masukan kata kunci">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">                 
                                <select class="form-control" name="opsi" required>
                                    <option value="">Pilih Opsi</option>
                                    <option value="step">Tahap</option>
                                    <option value="nomor">Nomor Dokumen</option>                              
                                    <option value="type">Tipe</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <button class="btn btn-primary rounded-pill">Filter</button>
                            <button type="button" onclick="location.href='{{route('news.index')}}'" class="btn btn-secondary rounded-pill">Reset</button>
                        </div>
                    </div>
                </form>
               </div>
            </div> --}}
        </div>

        @foreach($da as $item)        
        
        @php
          $header = json_decode($item->doc->header);
        @endphp
        <div class="card rounded shadow-sm">
            <div class="card-header bg-primary text-white small p-1">
                <div class="d-flex justify-content-between px-1">
                    <p class="my-auto">
                        <span style="font-size: 0.85rem">No Dokumen : </span>{{(str_replace('SPm','BARP',str_replace('600.1.15','600.1.15/PBLT',$item->doc->nomor)))}}
                    </p>

                    <p class="my-auto"> 
                        {{-- <span style="font-size: 0.85rem">No Registrasi : </span>{{$item->doc->reg}} --}}
                    </p>
              
                    <div></div>
                </div>
            </div>
            <div class="card-body">
                <div class="row mt-3">          
                    <div class="col-md-4 col-6">
                        <h6>Pemohon</h6>                   
                        {{$header[2]}}      
                    </div>
                    <div class="col-md-4 col-6">
                        <h6>Tahun Konsultasi</h6>                  
                        {{dateID($item->tanggal)}}
                    </div>                         
                    <div class="col-md-4 col-6">
                        <h6>Status</h6>              
                        @if($ver)
                                @if($item->grant == 0)
                                    <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#ver{{$item->id}}">
                                    Verifikasi
                                    </button>
                                @else
                                    <button type="button" class="btn btn-success btn-sm rounded-pill">Success</button>
                                @endif  
                            <a target="_blank" href="{{ route('barp.doc', ['id'=>md5($item->id)]) }}" class="btn btn-sm btn-danger"><i class="bi bi-file-pdf"></i></a>     
                        @else
                            <a target="_blank" href="{{ route('doc.meet', ['id'=>md5($item->id)]) }}" class="btn btn-sm btn-danger"><i class="bi bi-file-pdf"></i></a>    
                            @if($item->grant == 0)
                                <button type="button" class="btn btn-warning text-dark btn-sm rounded-pill">On Progress</button>    
                            @else
                                <button type="button" class="btn btn-success btn-sm rounded-pill">Success</button>
                            @endif                                                  
                        @endif                     
                    </div>                     
                </div>
            </div>
        </div>

        <div class="modal fade" id="ver{{$item->id}}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel{{$item->id}}">Verifikasi Dokumen</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{route('approve.barp',['id'=>md5($item->id)])}}" method="post">                                                                               
                        @csrf   
                        <p>Anda akan menerima dokumen ini ?<p>                                         
                        <button class="btn btn-success rounded-pill">Diterima</button>
                        {{-- <button type="button" class="btn btn-danger rounded-pill" data-bs-toggle="modal" data-bs-target="#re{{$item->id}}">Ditolak</button> --}}
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>                            
                </div>
            </div>
            </div>
        </div>

        @endforeach

        {!! $da->withQueryString()->links('pagination::bootstrap-5') !!}
    </section>  
</div>
@endsection

@push('js')    
<script src="{{asset('assets/extensions/jquery/jquery.min.js')}}"></script>
<script src="{{asset('assets/extensions/datatables.net/js/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('assets/extensions/datatables.net-bs5/js/dataTables.bootstrap5.min.js')}}"></script>
<script src="{{asset('assets/static/js/pages/datatables.js')}}"></script>
@endpush