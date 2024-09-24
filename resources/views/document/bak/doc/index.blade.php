@extends('layout.pdf')
@section('main')
<img src=" {{ gambar('bg.png') }} " class="watermark" alt="Watermark" width="100%" />
<div style="position: relative">
    @include('document.bak.doc.home');
</div>
@endsection
