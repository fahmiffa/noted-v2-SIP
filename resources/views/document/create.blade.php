@extends('layout.base')
@push('css')
    <link rel="stylesheet" href="{{ asset('assets/extensions/choices.js/public/assets/styles/choices.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" />
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.rtl.min.css" />
@endpush
@section('main')
    <div class="page-heading">

        <section class="section">
            <div class="card">

                <div class="card-header">
                    <h5 class="card-title">{{ $data }}</h5>
                </div>

                <div class="card-body">

                    @isset($verifikasi)
                        <form action="{{ route('verifikasi.update', ['verifikasi' => $verifikasi]) }}" method="post">
                            @method('PATCH')
                        @else
                            <form action="{{ route('verifikasi.store') }}" method="post">
                                @endif
                                @csrf
                                <div class="px-5">
                                    <div class="form-group row mb-3">
                                        <div class="col-md-6">
                                            <label>No Dokumen</label>
                                            <p class="form-control-static mt-1">{{ nomor() }}</p>
                                        </div>

                                        <div class="col-md-6">
                                            <label>Jenis</label>
                                            <select class="choices form-select" name="type" id="type">
                                                <option value="">Pilih Jenis</option>
                                                @php $doc = baseDoc();  @endphp
                                                @foreach ($doc as $item)
                                                    @if (old('type'))
                                                        <option value="{{ $item }}" @selected(old('type') == $item)>
                                                            {{ ucfirst($item) }}</option>
                                                    @else
                                                        <option value="{{ $item }}" @selected(isset($verifikasi) && $verifikasi->type == $item)>
                                                            {{ ucfirst($item) }}</option>
                                                    @endif
                                                @endforeach
                                            </select>
                                            @error('type')
                                                <div class='small text-danger text-left'>{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    @include('document.header')

                                    <div class="form-group row mb-3">
                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <label>Tahap</label>
                                                <select class="form-control" name="task" placeholder="tahap" id="task">
                                                    <option value="">Pilih Tahap</option>
                                                    <option value="1" @selected(isset($verifikasi) && $verifikasi->step == 1)>1 (Satu)</option>
                                                    <option value="2" @selected(isset($verifikasi) && $verifikasi->step == 2)>2 (Dua)</option>
                                                </select>
                                                @error('task')
                                                    <div class='small text-danger text-left'>{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group row mb-3">
                                        <div class="col-md-6 mb-3 d-none" id="ver1">
                                            <label>Verifikator Tahap 1</label>
                                            <select class="select-field" name="verifikator[]" id="task1">
                                                <option value="">Pilih Verifikator</option>
                                            </select>
                                            @error('verifikator')
                                                <div class='small text-danger text-left'>{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-6 mb-3 d-none" id="ver2">
                                            <label>Verifikator Tahap 2</label>
                                            <select class="select-field" name="verifikator[]" id="task2">
                                                <option value="">Pilih Verifikator</option>                                  
                                            </select>
                                            @error('verifikator')
                                                <div class='small text-danger text-left'>{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-12">
                                            <button class="btn btn-primary rounded-pill">Save</button>
                                            <a class="btn btn-danger ms-1 rounded-pill"
                                                href="{{ route('verifikasi.index') }}">Back</a>
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
        <script src="{{ asset('assets/extensions/jquery/jquery.min.js') }}"></script>
        <script src="{{ asset('assets/extensions/choices.js/public/assets/scripts/choices.js') }}"></script>
        <script src="{{ asset('assets/static/js/pages/form-element-select.js') }}"></script>
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

        <script>
            $('#type').on('change', function() {
                var tipe = $(this).val();

                if (tipe == 'umum') {
                    $('#con').html('Fungsi');
                } else {
                    $('#con').html('Koordinat');
                }
            });

            $('.select-field').select2({
                theme: 'bootstrap-5'
            });

            $('#dis').on('change', function(e) {
                e.preventDefault();
                $('#des').empty();
                $.ajax({
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: "{{ route('village') }}",
                    data: {
                        id: $(this).val()
                    },
                    success: function(data) {
                        $.each(data, function(key, value) {
                            $('#des').append('<option value="' + key + '">' + value + '</option>');
                        });
                    }
                });
            });

            $('#task').on('change', function(e) {
                var par = $(this).val();
                e.preventDefault();
                $('#task1').empty();
                $('#task2').empty();
                if (par == 1) {
                    $('#ver1').removeClass('d-none');
                    $('#ver2').addClass('d-none');
                    $.ajax({
                        type: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        url: "{{ route('task') }}",
                        data: {
                            id: $(this).val()
                        },
                        success: function(data) {
                            $.each(data.satu, function(key, value) {
                                $('#task1').append('<option value="' + key + '">' + value.toUpperCase() +
                                    '</option>');
                            });
                        }
                    });

                } else {

                    $('#ver2').removeClass('d-none');
                    $('#ver1').removeClass('d-none');
                    $.ajax({
                        type: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        url: "{{ route('task') }}",
                        data: {
                            id: $(this).val()
                        },
                        success: function(data) {

                            $.each(data.satu, function(key, value) {
                                $('#task1').append('<option value="' + key + '">' + value.toUpperCase() +
                                    '</option>');
                            });
                            $.each(data.dua, function(key, value) {
                                $('#task2').append('<option value="' + key + '">' + value.toUpperCase() +
                                    '</option>');
                            });
                        }
                    });

                }
            });
        </script>
    @endpush
