@extends('layout.base')
@section('main')
    <div class="page-heading">

        <section class="section">

            <div class="row">
                <div class="col-md-3 d-none d-md-block">
                    <div class="card">
                        <div class="card-body">

                            @if ($errors->any())
                                <div class="text-danger small">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <div class="d-flex justify-content-center align-items-center flex-column">
                                <div class="avatar avatar-2xl" data-bs-toggle="modal" data-bs-target="#myModals">
                                    @if(auth()->user()->img)
                                        <img src="{{ asset('storage/'.auth()->user()->img) }}">
                                    @else
                                        <img src="{{ asset('assets/compiled/jpg/2.jpg') }}" alt="Avatar">
                                    @endif
                                </div>
                                <h6 class="mt-3">{{ auth()->user()->name }}</h6>
                                <p class="text-small text-capitalize mb-3">{{ ucfirst(auth()->user()->roles->name) }}</p>
                            </div>

                            <div class="modal fade" id="myModals">
                                <div class="modal-dialog">
                                    <div class="modal-content">

                                        <!-- Modal Header -->
                                        <div class="modal-header">
                                            <h4 class="modal-title">Upload Image</h4>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>

                                        <!-- Modal body -->
                                        <div class="modal-body">
                                            <form action="{{ route('image') }}" method="post" enctype="multipart/form-data">
                                                @csrf
                                                <small class="text-danger" style="font-size:0.8rem">Format ekstensi upload JPG, JPEG, PNG</small>
                                                <input class="form-control" type="file" name="image"
                                                accept=".jpg, .jpeg, .png" required>
                                                <small class="text-danger" style="font-size:0.8rem">Rekomendasi 400x400 pixels</small>
                                                <br>

                                                <button class="btn btn-primary my-3">Save</button>
                                            </form>
                                        </div>

                                        <!-- Modal footer -->
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-danger"
                                                data-bs-dismiss="modal">Close</button>
                                        </div>

                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="col-md-9 col-sm-12">
                    <div class="card">
                        <div class="card-body">
                            <form action="" method="post">
                                @csrf
                                <div class="px-5">
                                    <div class="form-group row mb-3">
                                        <label class="col-md-4">Password Lama</label>
                                        <div class="col-md-8">
                                            <input type="password" name="oldpassword" class="form-control">
                                            @error('oldpassword')
                                                <div class='small text-danger text-left'>{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-group row mb-3">
                                        <label class="col-md-4">Password Baru</label>
                                        <div class="col-md-8">
                                            <input type="password" name="password" class="form-control">
                                            @error('password')
                                                <div class='small text-danger text-left'>{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-group row mb-3">
                                        <label class="col-md-4">Konfirmasi Password</label>
                                        <div class="col-md-8">
                                            <input type="password" name="password_confirmation" class="form-control">
                                            @error('confpassword')
                                                <div class='small text-danger text-left'>{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="mb-3 d-flex justify-content-start ">
                                        <button class="btn btn-primary rounded-pill">Save</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>

    </div>
@endsection

@push('js')
    <script src="{{ asset('assets/extensions/jquery/jquery.min.js') }}"></script>
@endpush
