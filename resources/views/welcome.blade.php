<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="description" content="{{ env('APP_DES') }}">
    <meta name="keywords" content="{{ env('APP_TAG') }},{{ env('APP_NAME') }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ env('APP_NAME') }} | {{ env('APP_TAG') }}</title>
    <link rel="shortcut icon" href="{{ asset('assets/logo.png') }}" type="image/x-icon">
    <link rel="stylesheet" href="{{ asset('assets/compiled/css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/compiled/css/app-dark.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/compiled/css/auth.css') }}">

    <style>
        #bg {
            background: url('{{ asset('assets/bgs.jpg') }}') no-repeat center center fixed;
            background-size: cover;
            width: 100%;
            height: 100%;
            position: fixed;
            top: 0;
            right: 0;
            bottom: 0;
            left: 0;
        }

        .vertical-center {
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }

        .round-left {
            border-top-left-radius: 0.75rem;
            border-bottom-left-radius: 0.75rem;
        }

        .round-right {
            border-top-right-radius: 0.75rem;
            border-bottom-right-radius: 0.75rem;
        }

        @media (max-width: 576px) {
            .pad {
                margin-left: 1rem;
                margin-right: 1rem;
            }

            .mt-5
            {
                margin-top: 0rem !important;
            }

            .vertical-center {                  
               height: 80vh !important;
            }

            .round-left-m {
                border-top-left-radius: 0.75rem;
                border-bottom-left-radius: 0.75rem;
            }

            
        }
        .float-button {
             position: fixed;
             bottom: 20px;
             right: 20px;
             z-index: 1000;                
             box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
             border-radius: 50px;
         }
    </style>
</head>

<body>
    
    <div id="bg">
        <button class="btn btn-dark float-button">
            <a class="text-white" href="{{route('login')}}"><i class="bi bi-box-arrow-in-right"></i></a>
        </button>
        <div class="row justify-content-center vertical-center">
            <div class="col-md-6 col-lg-8 col-sm-12">
                <div class="row mx-3">
                    <div class="col-md-6 d-none d-md-block d-lg-block bg-dark opacity-75 round-left shadow">
                        <div class="d-flex flex-column p-3">
                            <div class="d-inline-flex justify-content-start p-3">
                                <img src="{{ asset('logo.png') }}" style="height: 2.8rem; width:2.8rem;" class="me-3" >                           
                                <h6 class="text-white my-auto">Sistem Informasi Penyelenggaraan Bangunan Gedung</h6>
                            </div>
                            <p class="text-white p-3">
                                Aplikasi penunjang dalam proses Penyelenggaraan Bangunan Gedung di Kabupaten Tegal
                            </p>
                            <h5 class="my-5 text-white p-3">Dinas Pekerjaan Umum dan Penataan Ruang <br>Kabupaten Tegal</h5>
                        </div>
                    </div>
                    <div class="col-md-6 bg-white round-right shadow round-left-m">
                        <div class="p-3">
                            <div class="d-flex justify-content-start py-3">
                                <img src="{{ asset('kab.png') }}" style="height: 2.5rem; width:2.5rem;" class="p-1 me-1">
                                <h2 class="my-auto">SIP BANGED
                                </h2>
                            </div>

                            <p class="fw-bold">Cek Dokumen Verifikasi</p>
                            <form action="{{ route('store') }}" method="post">
                                @csrf
                                <div class="form-group position-relative has-icon-left">
                                    <input type="text" class="form-control" value="{{ old('reg') }}"
                                        name="reg" placeholder="Nomor Registrasi PBG/SLF">
                                    <div class="form-control-icon">
                                        <i class="bi bi-file-text"></i>
                                    </div>
                                    @error('reg')
                                        <div class='small text-danger text-left'>{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group position-relative has-icon-left">
                                    <input type="text" class="form-control" value="{{ old('doc') }}"
                                        name="doc" placeholder="Nomor Dokumen Verifikasi">
                                    <div class="form-control-icon">
                                        <i class="bi bi-file-binary"></i>
                                    </div>
                                    @error('doc')
                                        <div class='small text-danger text-left'>{{ $message }}</div>
                                    @enderror
                                </div>
                                <button class="btn btn-warning rounded-pill shadow-sm  btn-sm fw-bold mb-3">Check</button>
                            </form>
                            @if(session('res'))
                                @php 
                                $item = session('res'); 
                                $header = (array) json_decode($item->header);
                                @endphp
                                <div class="row small">
                                    <div class="col-3">Nama Pemohon</div>
                                    <div class="col-9">: {{ $header ? $header[2] : null }}   </div>
                                    <div class="col-3">Alamat Pemohon</div>
                                    <div class="col-9 d-inline-flex">:&nbsp;<p class="mb-0">{{ $header ? $header[4] : null }}</p></div>                              
                                    <div class="col-3">No. Registrasi</div>
                                    <div class="col-9">: {{ $item->reg }}</div>
                                    <div class="col-3">No. Dokumen</div>
                                    <div class="col-9 d-inline-flex">:&nbsp;<p class="mb-0" >{{ $item->nomor }}</p></div>
                                    <div class="col-3">Nama Bangunan</div>
                                    <div class="col-9">: {{ $header ? $header[5] : null }}</div>
                                    <div class="col-3">Lokasi Bangunan</div>
                                    <div class="col-9">: <p>{{ $header ? $header[7].', ' : null }} {{ $item->region ? 'Desa/Kel. '.$item->region->name : null }} {{ $item->region ? ', Kec. '.$item->region->kecamatan->name : null }}, Kab. Tegal</p></div>
                                    <div class="col-3">Status</div>
                                    <div class="col-9">: {{$item->dokumen}}</div>                     
                                    <div class="col-3">Lihat Dokumen</div>
                                    <div class="col-9 d-inline-flex">:&nbsp;<p>&#9632; {!! ucfirst(implode('<br>&#9632; ', $item->verif)) !!}</p></div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>     
            </div>
        </div>
    </div>

    <script src="{{ asset('assets/extensions/jquery/jquery.min.js') }}"></script>

    <script type="text/javascript">
        $('#reload').click(function() {
            $.ajax({
                type: 'GET',
                url: 'reload-captcha',
                success: function(data) {
                    $(".captcha span").html(data.captcha);
                }
            });
        });
    </script>
</body>

</html>
