@extends('layout.base')     
@push('css')
<link rel="stylesheet" href="{{asset('assets/extensions/choices.js/public/assets/styles/choices.css')}}">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.rtl.min.css" />
<link rel="stylesheet" href="{{asset('assets/extensions/quill/quill.snow.css')}}">


@endpush
@section('main')
<div class="page-heading">  

    <section class="section">
        <div class="card">       

            <div class="card-header">
                <h5 class="card-title">{{$data}}</h5>                    
            </div>

            <div class="card-body">

                @isset($schedule)
                <form action="{{route('schedule.update',['schedule'=>$schedule])}}" method="post">                            
                @method('PATCH')   
                    @php
                        $time = explode('#',$schedule->waktu);
                        $place = explode('#',$schedule->tempat);
                    @endphp
                @else                                      
                    <form action="{{route('schedule.store')}}" method="post">                               
                @endif                    
                    @csrf           
                    <div class="px-5">

                        <div class="form-group row mb-3">        
                            <div class="col-md-6 mb-3">
                                <label>Pilih Dokumen</label>              
                                <select class="choices form-select" name="doc">
                                    <option value="">Pilih Dokumen</option>                                                                                            
                                    @foreach($doc as $item)                                                            
                                        <option value="{{$item->id}}"  @selected(isset($schedule) && $schedule->head == $item->id) >{{$item->reg}} ({{$item->nomor}})</option>                                 
                                    @endforeach                       
                                </select>
                                @error('doc')<div class='small text-danger text-left'>{{$message}}</div>@enderror
                            </div>
                            <div class="col-md-6">
                                <label>Jenis</label>              
                                <select class="form-control" name="jenis" required>
                                    <option value="">Pilih Jenis</option>          
                                    @php
                                      $var = ['peninjuan_lokasi','rapat_pembahasan','online'];                                    
                                    @endphp                                              
                                    @foreach($var as $item)
                                        <option value="{{$item}}" @selected(isset($schedule) && $schedule->jenis == $item)>{{ucwords(str_replace('_',' ',$item))}}</option>
                                    @endforeach                                                                                                                          
                                </select>
                                @error('jenis')<div class='small text-danger text-left'>{{$message}}</div>@enderror
                            </div>                  
                        </div>
                        
                        <div class="form-group mb-3">
                            <div class="row">
                                <div class="col-md-6">
                                    <label>No. Surat</label>
                                    <input type="text" name="nomor" value="{{isset($schedule) ? $schedule->nomor : old('nomor')}}" class="form-control">
                                    @error('nomor')<div class='small text-danger text-left'>{{ $message }}</div>@enderror
                                </div>
                                <div class="col-md-6">
                                    <label>Tanggal Surat</label>
                                    <input type="date" name="tanggal" value="{{isset($schedule) ? $schedule->tanggal : old('tanggal')}}" class="form-control">
                                    @error('tanggal')<div class='small text-danger text-left'>{{ $message }}</div>@enderror
                                </div>
                            </div>
                        </div>                           

                        <div class="form-group mb-3">
                            <div class="row">              
                                <div class="col-md-4">
                                    <label>Waktu Mulai</label>                              
                                    <input type="time" name="timeStart" value="{{isset($schedule) ? $time[0] : old('timeStart')}}" class="form-control">                             
                                    @error('timeStart')<div class='small text-danger text-left'>{{ $message }}</div>@enderror
                                </div>

                                <div class="col-md-4">
                                    <label>Waktu Akhir</label>                              
                                    <input type="time" name="timeEnd" value="{{isset($schedule) ? $time[0] : old('timeEnd')}}" class="form-control">                             
                                    @error('timeEnd')<div class='small text-danger text-left'>{{ $message }}</div>@enderror
                                </div>

                                <div class="col-md-4">          
                                    <label></label>                                    
                                    <input type="date" name="date" value="{{isset($schedule) ? $time[1] : old('date')}}" class="form-control">
                                    @error('tanggal')<div class='small text-danger text-left'>{{ $message }}</div>@enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-group row mb-3">        
                            <div class="col-md-4">
                                <label>Tempat</label>     
                                         
                                <select class="form-control" name="place" required>
                                    <option value="">Pilih Tempat</option>          
                                    @php
                                      $var = ['alamat_bangunan','ruang_rapat_DPUPR','link_zoom'];                                    
                                    @endphp                                              
                                    @foreach($var as $item)
                                        <option value="{{$item}}" @selected(isset($schedule) && $place[0] == $item)>{{ucwords(str_replace('_',' ',$item))}}</option>
                                    @endforeach                                                                                                                          
                                </select>
                                @error('place')<div class='small text-danger text-left'>{{$message}}</div>@enderror
                            </div>
                            <div class="col-md-8">
                                <label></label>                               
                                <input type="text" name="place_des" value="{{isset($schedule) ? $place[1] : old('place_des')}}" class="form-control">
                                @error('place_des')<div class='small text-danger text-left'>{{$message}}</div>@enderror
                            </div>                          
                        </div>

                        <div class="form-group row mb-3">
                            <div class="col-md-12">
                                <label>Keterangan</label>
                                <input type="hidden" name="content" value="{!! isset($schedule) ? $schedule->keterangan : old('keterangan') !!}">                       
                                <div id="snow" style="height: 100px">     
                                    {!! isset($schedule) ? $schedule->keterangan : old('keterangan') !!}                                
                                </div>
                            </div>
                        </div>

                        <div class="form-group row mb-3">                               
                            <div class="col-md-12" >
                                <button class="btn btn-primary rounded-pill">Save</button>
                                <a class="btn btn-danger ms-1 rounded-pill" href="{{route('schedule.index')}}">Back</a>
                            </div>
                        </div>

                    </div>             
                </form>
            </div>
        </div>

    </section>

</div>
@endsection

@push('js')    
<script src="{{asset('assets/extensions/jquery/jquery.min.js')}}"></script>
<script src="{{asset('assets/extensions/choices.js/public/assets/scripts/choices.js')}}"></script>
<script src="{{asset('assets/static/js/pages/form-element-select.js')}}"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="{{asset('assets/extensions/quill/quill.min.js')}}"></script>


<script>

var quill = new Quill('#snow', {
      theme: 'snow'
    });

    quill.on('text-change', function(delta, oldDelta, source) {
    document.querySelector("input[name='content']").value = quill.root.innerHTML;
  });

$('#type').on('change',function(){
    var tipe = $(this).val();

    if(tipe == 'umum')
    {
        $('#con').html('Fungsi');
    }
    else
    {
        $('#con').html('Koordinat');
    }
});

$( '.select-field' ).select2( {
    theme: 'bootstrap-5'
});

$('#dis').on('change',function(e){
    e.preventDefault();    
    $('#des').empty();
    $.ajax({
        type:'POST',
        headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url:"{{ route('village') }}",
        data:{id:$(this).val()},
        success:function(data){                        
            $.each(data, function(key, value) {
                $('#des').append('<option value="' + key + '">' + value + '</option>');
            });
        }
    });
});

</script>

@endpush