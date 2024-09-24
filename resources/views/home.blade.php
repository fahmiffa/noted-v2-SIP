@extends('layout.base')
@section('main')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Ringkasan</h3>
                </div>
            </div>
        </div>
        <section class="section">            
            <div class="row">
                <div class="col-12">
                    <div class="card card-body">
                        <div class="row">
                            <div class="col col-md-4">
                                <div class="d-flex jusitify-content-between">
                                    <div class="p-1">
                                        <div class="stats-icon red mb-2">
                                            <i class="iconly-boldPaper"></i>
                                        </div>
                                    </div>
                                    <div class="p-1">
                                        <h6 class="text-muted font-semibold">Jumlah Permohonan</h6>
                                        <h6 class="font-extrabold mb-0">{{$head->where('do',0)->count()}}</h6>
                                    </div>
                                </div>
                            </div>
                            <div class="col col-md-4">
                                <div class="d-flex jusitify-content-between">
                                    <div class="p-1">
                                        <div class="stats-icon mb-2" style="background-color: darkgray">
                                            <i class="iconly-boldPaper"></i>
                                        </div>
                                    </div>
                                    <div class="p-1">
                                        <h6 class="text-muted font-semibold">Tahap Verifikasi</h6>
                                        <h6 class="font-extrabold mb-0">{{$verif}}</h6>
                                    </div>
                                </div>
                            </div>
                            <div class="col col-md-4">
                                <div class="d-flex jusitify-content-between">
                                    <div class="p-1">
                                        <div class="stats-icon dark mb-2">
                                            <i class="iconly-boldPaper"></i>
                                        </div>
                                    </div>
                                    <div class="p-1">
                                        <h6 class="text-muted font-semibold">Proses Konsultasi</h6>
                                        <h6 class="font-extrabold mb-0">{{$kons}}</h6>
                                    </div>
                                </div>
                            </div>
                            <div class="col col-md-4">
                                <div class="d-flex jusitify-content-between">
                                    <div class="p-1">
                                        <div class="stats-icon green mb-2">
                                            <i class="iconly-boldPaper"></i>
                                        </div>
                                    </div>
                                    <div class="p-1">
                                        <h6 class="text-muted font-semibold">Proses BAK</h6>
                                        <h6 class="font-extrabold mb-0">{{$bak}}</h6>
                                    </div>
                                </div>
                            </div>
                            <div class="col col-md-4">
                                <div class="d-flex jusitify-content-between">
                                    <div class="p-1">
                                        <div class="stats-icon blue mb-2">
                                            <i class="iconly-boldPaper"></i>
                                        </div>
                                    </div>
                                    <div class="p-1">
                                        <h6 class="text-muted font-semibold">BARP</h6>
                                        <h6 class="font-extrabold mb-0">{{$barp}}</h6>
                                    </div>
                                </div>
                            </div>
                            {{-- <div class="col col-md-4">
                                <div class="d-flex jusitify-content-between">
                                    <div class="p-1">
                                        <div class="stats-icon blue mb-2">
                                            <i class="iconly-boldPaper"></i>
                                        </div>
                                    </div>
                                    <div class="p-1">
                                        <h6 class="text-muted font-semibold">BARP</h6>
                                        <h6 class="font-extrabold mb-0">{{$barp}}</h6>
                                    </div>
                                </div>
                            </div> --}}
                        </div>             
                    </div>
                </div>        
            </div>        
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Grafik Dokumen</h4>
                        </div>
                        <div class="card-body">
                            <div id="chart-profile-visit" style="min-height: 315px;">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@push('js')
    <script src="{{ asset('assets/extensions/apexcharts/apexcharts.min.js') }}"></script>
    <script>
        var optionsProfileVisit = {
            annotations: {
                position: "back",
            },
            dataLabels: {
                enabled: false,
            },
            chart: {
                type: "bar",
                height: 300,
            },
            fill: {
                opacity: 1,
            },
            plotOptions: {},
            series: [{
                name: "Permohonan",
                data: @json($chart['counts']),
            }, ],
            colors: "#435ebe",
            xaxis: {
                categories: @json($chart['months']),
            },
        }
        var chartProfileVisit = new ApexCharts(
            document.querySelector("#chart-profile-visit"),
            optionsProfileVisit
        )

        chartProfileVisit.render()
    </script>
@endpush
