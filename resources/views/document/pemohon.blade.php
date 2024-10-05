@php
    $header = (array) json_decode($head->header);
@endphp
<div class="row my-3">
    <div class="col-4">
        <h6>No Registrasi</h6>
        {{ $head->reg }}
    </div>
    <div class="col-4">
        <h6>Nama Pemohon</h6>
        {{ $header ? $header[2] : null }}
    </div>
    <div class="col-4 mb-3">
        <h6>Alamat Pemohon</h6>
        {{ $header ? $header[4] : null }}
    </div>
    <div class="col-4">
        <h6>{{ $head->type == 'umum' ? 'Fungsi' : 'Koordinat' }}</h6>
        {{ $head->type == 'umum' ? ucfirst($header[6]) : $header[8] }}
    </div>
    <div class="col-4">
        <h6>Nama Bangunan</h6>
        {{ $header ? $header[5] : null }}
    </div>
    <div class="col-4">
        <h6>Lokasi Bangunan</h6>
        {{ $header ? $header[7] : null }}<br>
        {{ $head->region ? 'Desa/Kel. ' . $head->region->name : null }}
        {{ $head->region ? ' Kec. ' . $head->region->kecamatan->name : null }}

    </div>
    <div class="col-4">
    </div>
</div>
