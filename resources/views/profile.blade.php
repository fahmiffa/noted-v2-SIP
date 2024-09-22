@extends('layout.base')
@section('main')
    <div class="page-heading">

        <section class="section">

            <div class="row">
                <div class="col-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-center align-items-center flex-column">
                                <div class="avatar avatar-2xl" data-bs-toggle="modal" data-bs-target="#myModal">
                                    <img src="{{ asset('assets/compiled/jpg/2.jpg') }}" alt="Avatar">
                                </div>
                                <h6 class="mt-3">{{ auth()->user()->name }}</h6>
                                <p class="text-small text-capitalize mb-3">{{ ucfirst(auth()->user()->roles->name) }}</p>
                            </div>

                            <div class="modal fade" id="myModal">
                                <div class="modal-dialog">
                                    <div class="modal-content">

                                        <!-- Modal Header -->
                                        <div class="modal-header">
                                            <h4 class="modal-title">Upload Image</h4>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>

                                        <!-- Modal body -->
                                        <div class="modal-body">
                                            <form action="{{ route('attach.store') }}" method="post" enctype="multipart/form-data">
                                                @csrf
                                                <small class="text-danger" style="font-size:0.8rem">Format ekstensi upload JPG, JPEG, PNG</small>
                                                <input class="form-control" type="file" name="pile_loc"
                                                accept=".jpg, .jpeg, .png" required>

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
                <div class="col-9">
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
