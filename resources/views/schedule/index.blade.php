@extends('layout.base')     
@push('css')
<link rel="stylesheet" href="{{asset('assets/extensions/datatables.net-bs5/css/dataTables.bootstrap5.min.css')}}">
<link rel="stylesheet" href="{{asset('assets/compiled/css/table-datatable-jquery.css')}}">
@endpush
@section('main')
<div class="page-heading">

    <!-- Basic Tables start -->
    <section class="section">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between">
                    <div class="p-1">
                        <h5 class="card-title">Data {{$data}}</h5>
                    </div>
                    <div class="p-1">
                        <a href="{{route('schedule.create')}}" class="btn btn-primary btn-sm rounded-pill">Tambah</a>
                    </div>                    
                </div>       
            </div>
            {{-- <div class="card-body">     
                <div class="px-1">
                    <form action="{{route('schedule.index')}}" method="get">
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
                                <button type="button" onclick="location.href='{{route('schedule.index')}}'" class="btn btn-secondary rounded-pill">Reset</button>
                            </div>
                        </div>
                    </form>
                </div>     
            </div> --}}
        </div>

        @foreach($da as $item)                
        <div class="card rounded shadow-sm">
            <div class="card-header bg-primary text-white small p-1">
                <div class="d-flex justify-content-between px-1">
                    <p class="my-auto">
                        <span style="font-size: 0.85rem">No Surat : </span>{{$item->nomor}}
                    </p>

                    <p class="my-auto"> 
                        <span style="font-size: 0.85rem">No Dokumen : </span>{{$item->doc->nomor}}
                    </p>          
                    <div></div>
                </div>
            </div>
            <div class="card-body">
                <div class="row mt-3">
                    <div class="col-md-3 col-6 mb-3">
                        <h6>Tanggal</h6>                  
                        {{$item->tanggal}}                        
                    </div>
                    <div class="col-md-3 col-6 mb-3">
                        <h6>Email</h6>                  
                        {{$item->doc->email}}                                           
                    </div>
                    <div class="col-md-3 col-6 mb-3">
                        <h6>Jenis</h6>
                        {{ucwords(str_replace('_',' ',$item->jenis))}} 
                    </div>
                    @php
                    $time = explode('#',$item->waktu);
                    $place = explode('#',$item->tempat);
                    $header = json_decode($item->doc->header);
                    $hp = str_replace('08', '628', $header[3]);          
                    @endphp
                    <!-- <div class="col-md-3 col-6 mb-3">
                        <h6>Waktu</h6>                   
                        {{$time[0]}}, {{dateID($time[1])}}
                    </div>                    -->
                    
                    <div class="col-md-3 col-12 mb-3">
                        <h6>Action</h6>                  
                        <form onsubmit="return confirm('Apakah Anda Yakin Menghapus ?');" action="{{ route('schedule.destroy', $item->id) }}" method="POST">                                                                       
                            <a href="{{ route('schedule.edit', $item->id) }}" class="btn btn-sm btn-primary"><i class="bi bi-pencil"></i></a>             
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger"><i class="bi bi-trash"></i></button>                     
                            <a target="_blank" href="{{ route('schedule.show', ['schedule'=>$item->id]) }}" class="btn btn-sm btn-danger"><i class="bi bi-file-pdf"></i></a>                            
                        </form>
                        <form onsubmit="return confirm('Anda akan mengiri email notif ?');" action="{{ route('schedule.send', md5($item->id)) }}" method="POST">
                            @csrf
                          <button type="submit" id="email" class="btn btn-sm btn-dark my-1"><i class="bi bi-envelope-arrow-up"></i></button>   
                          
                          <button type="button" onclick="location.href='whatsapp://send?phone={{$hp}}&text=Anda%20mendapat%20Undangan%20Konsultasi%0ADengan%20Nomor%20Registrasi%20{{$item->doc->reg}}%0A'" class="btn btn-sm btn-success my-1"><i class="bi bi-whatsapp"></i></button>   
                        </form>
                    </div>
                    <div class="col-md-3 col-6 mb-3">
                        <h6>Tempat</h6>                  
                        {{ucwords(str_replace('_',' ',$place[0]))}}<br>
                        <p>{{$place[1]}}</p>
                    </div>
                    <div class="col-md-6 col-6 mb-3">
                        <h6>Keterangan</h6>                  
                        {!! $item->keterangan !!}                        
                    </div>                  
                </div>
            </div>
        </div>
        @endforeach
        {!! $da->withQueryString()->links('pagination::bootstrap-5') !!}
    </section>
    <!-- Basic Tables end -->

</div>
@endsection

@push('js')    
<script src="{{asset('assets/extensions/jquery/jquery.min.js')}}"></script>
<script src="{{asset('assets/extensions/datatables.net/js/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('assets/extensions/datatables.net-bs5/js/dataTables.bootstrap5.min.js')}}"></script>
<script src="{{asset('assets/static/js/pages/datatables.js')}}"></script>
@endpush