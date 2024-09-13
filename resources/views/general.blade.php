@extends('layout.base')
@section('main')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Dokumen</h3>
                    <p class="text-subtitle text-muted">Ringkasan Task Dokumen</p>
                </div>
            </div>
        </div>
        <section class="section">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col col-md-4">
                                    <div class="d-flex jusitify-content-between">
                                        <div class="p-1">
                                            <div class="stats-icon green mb-2">
                                                <i class="iconly-boldPaper"></i>
                                            </div>
                                        </div>
                                        <div class="p-1">
                                            <h6 class="text-muted font-semibold">Task</h6>
                                            <h6 class="font-extrabold mb-0">{{$task}}</h6>
                                        </div>
                                    </div>
                                </div>
                                <div class="col col-md-4">
                                    <div class="d-flex jusitify-content-between">
                                        <div class="p-1">
                                            <div class="stats-icon success mb-2">
                                                <i class="iconly-boldPaper"></i>
                                            </div>
                                        </div>
                                        <div class="p-1">
                                            <h6 class="text-muted font-semibold">Complete</h6>
                                            <h6 class="font-extrabold mb-0">{{$comp}}</h6>
                                        </div>
                                    </div>
                                </div>                
                            </div>                      
                        </div>
                    </div>
                </div>          
            </div>               
        </section>
    </div>
@endsection

@push('js') 
@endpush
