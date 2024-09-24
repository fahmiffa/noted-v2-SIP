@extends('layout.pdf')
@section('main')
<img src=" {{ gambar('bg.png') }} " class="watermark" alt="Watermark" width="100%" />
    @include('document.bak.doc.home');
@endsection
