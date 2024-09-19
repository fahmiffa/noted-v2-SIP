@extends('layout.base')     
@push('css')
<link rel="stylesheet" href="{{asset('assets/extensions/choices.js/public/assets/styles/choices.css')}}">
<link rel="stylesheet" href="{{asset('assets/extensions/datatables.net-bs5/css/dataTables.bootstrap5.min.css')}}">
<link rel="stylesheet" href="{{asset('assets/compiled/css/table-datatable-jquery.css')}}">

@endpush
@section('main')
<div class="page-heading">

    <section class="section">  

        <div class="row">
            <div class="col-3">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-center align-items-center flex-column">
                            <div class="avatar avatar-2xl">
                                <img src="{{asset('assets/compiled/jpg/2.jpg')}}" alt="Avatar">
                            </div>
                            <h6 class="mt-3">{{auth()->user()->name}}</h6>                                                     
                            <p class="text-small text-capitalize mb-3">{{ucfirst(auth()->user()->roles->name)}}</p>
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
                                        <input type="password" name="oldpassword"  class="form-control">
                                        @error('oldpassword')<div class='small text-danger text-left'>{{$message}}</div>@enderror
                                    </div>
                                </div>

                                <div class="form-group row mb-3">
                                    <label class="col-md-4">Password Baru</label>
                                    <div class="col-md-8">
                                        <input type="password" name="newpassword"  class="form-control">
                                        @error('newpassword')<div class='small text-danger text-left'>{{$message}}</div>@enderror
                                    </div>
                                </div>

                                <div class="form-group row mb-3">
                                    <label class="col-md-4">Konfirmasi Password</label>
                                    <div class="col-md-8">
                                        <input type="password" name="confpassword"  class="form-control">
                                        @error('confpassword')<div class='small text-danger text-left'>{{$message}}</div>@enderror
                                    </div>
                                </div>
        
                                <div class="mb-3 d-flex justify-content-start ">
                                    <button class="btn btn-primary rounded-pill" disabled>Update</button>                                 
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
<script src="{{asset('assets/extensions/jquery/jquery.min.js')}}"></script>
<script src="{{asset('assets/extensions/datatables.net/js/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('assets/extensions/datatables.net-bs5/js/dataTables.bootstrap5.min.js')}}"></script>
<script src="{{asset('assets/static/js/pages/datatables.js')}}"></script>

<script src="{{asset('assets/extensions/choices.js/public/assets/scripts/choices.js')}}"></script>
<script src="{{asset('assets/static/js/pages/form-element-select.js')}}"></script>

@endpush