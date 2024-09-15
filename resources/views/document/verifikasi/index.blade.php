@extends('layout.base')
@push('css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" />
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.rtl.min.css" />
    <link rel="stylesheet" href="{{ asset('assets/extensions/quill/quill.snow.css') }}">
@endpush
@section('main')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h6>{{ $data }}</h6>
                </div>
            </div>

            <section class="section">
                <div class="card">

                    <div class="card-header">
                        <h6 class="card-title text-center">{{ $doc->titles }}</h6>
                        <p class="text-center">{{ $head->nomor }}</p>

                        @php
                            $header = (array) json_decode($head->header);
                        @endphp
                        <div class="row my-3">
                            <div class="col-4">
                                <h6>No Registrasi</h6>
                                {{ $head->reg}}
                            </div>
                            <div class="col-4">
                                <h6>Pemohon</h6>
                                {{ $header ? $header[2] : null }}
                            </div>
                            <div class="col-4">
                                <h6>Alamat</h6>
                                {{ $head->region ? $head->region->name : null }},{{ $head->region ? $head->region->kecamatan->name : null }},{{ $header ? $header[4] : null }}
                            </div>
                            <div class="col-4">        
                                <h6>Fungsi</h6>            
                                {{ $header ? $header[6] : null }}
                            </div>
                            <div class="col-4">
                                <h6>Bangunan</h6>
                                {{ $header ? $header[5] : null }}
                            </div>
                            <div class="col-4">
                                <h6>Lokasi</h6>
                                {{ $header ? $header[7] : null }}
                            </div>
                            <div class="col-4">                    
                            </div>
                        </div>                     
                    </div>

                    <div class="card-body px-3">

                        @if ($head->step == 1)
                            <form action="{{ route('next.verifikasi', ['id' => md5($head->id)]) }}" method="post">
                                @csrf
                                @include('document.verifikasi.step')
                                <div class="col-12 my-3 px-3">
                                    <button class="btn btn-primary rounded-pill">Save</button>
                                </div>
                            </form>
                        @else
                            <form action="{{ route('nexts.verifikasi', ['id' => md5($head->id)]) }}" method="post">
                                @csrf
                                @include('document.verifikasi.steps')
                                <div class="col-md-12 my-3">
                                    <div class="d-flex justify-content-between">
                                        <button class="btn btn-primary rounded-pill">Save</button>
                                    </div>
                                </div>
                            </form>
                        @endif
                    </div>
                </div>

            </section>

        </div>
    </div>
@endsection

@push('js')
    <script src="{{ asset('assets/extensions/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/extensions/quill/quill.min.js') }}"></script>
    <script>
        const toolbarOptions = [
            ['bold', 'italic', 'underline', 'strike'],       

            [{ 'list': 'ordered'}, { 'list': 'bullet' }, { 'list': 'check' }],
            [{ 'script': 'sub'}, { 'script': 'super' }],    
            [{ 'size': ['small', false, 'large', 'huge'] }],  
            [{ 'color': [] }, { 'background': [] }],          
            [{ 'align': [] }],
            ['clean']                                        
            ];

        var quill = new Quill('#snow', {
            modules: {
                toolbar: toolbarOptions
            },
            theme: 'snow'
        });

        quill.on('text-change', function(delta, oldDelta, source) {
            document.querySelector("input[name='content']").value = quill.root.innerHTML;
        });

        function remove(e) {
            e.parentNode.remove();
        }

        $('#add-item').on('click', function() {
            var n = $(':radio').length / 3 + 1;
            var clonedDiv = '<div class="row mb-3">\
                                                 <div class="col-md-3">\
                                                    <input type="text" class="form-control" name="nameOther[' + n + ']" placeholder="item name"></div>\
                                                 <div class="col-md-5">\
                                                    <div class="d-flex justify-content-center">\
                                                        <div class="form-check d-inline-block">\
                                                            <input class="form-check-input" type="radio" name="item[' + n + ']" value="1">\
                                                            <label class="form-check-label">Ada</label>\
                                                        </div>\
                                                        <div class="form-check d-inline-block mx-3">             \
                                                            <input class="form-check-input" type="radio" name="item[' + n + ']" value="0" checked>\
                                                            <label class="form-check-label">Tidak Ada</label>\
                                                        </div>\
                                                        <div class="form-check d-inline-block">\
                                                            <input class="form-check-input" type="radio" name="item[' + n + ']" value="2">\
                                                            <label class="form-check-label">Tidak Perlu</label>\
                                                        </div>\
                                                    </div>\
                                                 </div>\
                                                 <div class="col-md-3">\
                                                    <textarea class="form-control" name="saranOther[' + n + ']" rows="2"></textarea>\
                                                 </div>\
                                                 <button class="btn btn-danger btn-sm my-auto" style="width:fit-content;height:fit-content" onclick="remove(this)"  type="button"><i class="bi bi-trash"></i></button>\
                                                 </div>\
                                                ';
            $('#input').append(clonedDiv);
        });
    </script>
@endpush
