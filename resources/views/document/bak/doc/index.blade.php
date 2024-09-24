@extends('layout.pdf')
@section('main')
<img src=" {{gambar('bg.png')}} " class="watermark" alt="Watermark" />
    @include('document.bak.doc.home');
@endsection
